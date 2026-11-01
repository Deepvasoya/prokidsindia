<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Student side of video assessments (AJAX only).
 *
 *  questions : questions for a video, WITHOUT the correct answers
 *  check     : check one answer and return feedback
 *  finish    : score all answers on the server and save an attempt
 *
 * Tables: video_assessment_questions, video_assessment_attempts
 * (see application/sql/video_assessment.sql)
 */
class Student_assessment extends CI_Controller {

    private $student_id;

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'student' || !$this->session->userdata('uid')) {
            $this->output->set_status_header(401);
            $this->json(0, 'Please log in again.');
            $this->output->_display();
            exit;
        }
        $this->student_id = (int) $this->session->userdata('uid');
    }

    function questions() {
        $video = $this->get_video((int) $this->input->post('video_id'));
        if (!$video) {
            return $this->json(0, 'Video not found.');
        }

        $rows = $this->active_questions($video['id']);

        // Question sets: go through the quiz set by set (sets in admin order, then questions without a set).
        $sets = array(); $set_pos = array();
        if ($this->db->table_exists('video_assessment_sets') && $this->db->field_exists('set_id', 'video_assessment_questions')) {
            $set_rows = $this->db->where('video_id', $video['id'])->order_by('sort_order', 'asc')->order_by('id', 'asc')
                                 ->get('video_assessment_sets')->result_array();
            foreach ($set_rows as $i => $sr) {
                $set_pos[(int) $sr['id']] = $i;
                $sets[(int) $sr['id']] = array('id' => (int) $sr['id'], 'name' => $sr['name'], 'count' => 0);
            }
            $order = array();
            foreach ($rows as $k => $r) {
                $sid = isset($r['set_id']) ? (int) $r['set_id'] : 0;
                $order[$k] = isset($set_pos[$sid]) ? $set_pos[$sid] : count($set_pos);   // no set -> last
                if (isset($sets[$sid])) { $sets[$sid]['count']++; }
            }
            // stable sort: by set position, keep the question order inside a set
            $keys = array_keys($rows);
            usort($keys, function ($a, $b) use ($order) { return $order[$a] === $order[$b] ? $a - $b : $order[$a] - $order[$b]; });
            $rows = array_map(function ($k) use ($rows) { return $rows[$k]; }, $keys);
            $sets = array_values(array_filter($sets, function ($st) { return $st['count'] > 0; }));
            // questions without a set become a last "More questions" set when sets are used
            if ($sets) {
                $loose = 0;
                foreach ($rows as $r) { if (!isset($set_pos[isset($r['set_id']) ? (int) $r['set_id'] : 0])) { $loose++; } }
                if ($loose) { $sets[] = array('id' => 0, 'name' => 'More questions', 'count' => $loose); }
            }
            $sets = $this->set_progress($sets, $rows, $video['id']);
        }
        $set_names = array();
        foreach ($sets as $st) { if ($st['id']) { $set_names[$st['id']] = $st['name']; } }

        $questions = array();
        $perms = (array) $this->session->userdata('vas_match_perm');
        foreach ($rows as $q) {
            $options = array();
            $extra   = array();
            if ($q['question_type'] === 'mcq' || $q['question_type'] === 'drag') {
                foreach ($this->decode($q['options']) as $opt) {
                    $options[] = $this->item($opt);
                }
            } elseif ($q['question_type'] === 'match') {
                // Right-hand cards are shuffled here and the order is kept in the session,
                // so the browser never learns which card belongs to which slot.
                $m = $this->decode($q['options']);
                $pairs = isset($m['pairs']) ? $m['pairs'] : array();
                $perm = range(0, count($pairs) - 1);
                if (count($perm) > 1) {
                    do { shuffle($perm); } while ($perm === range(0, count($pairs) - 1));
                }
                $perms[$q['id']] = $perm;
                $left = array(); $right = array();
                foreach ($pairs as $pair) { $left[] = $this->item($pair['left']); }
                foreach ($perm as $orig) { $right[] = $this->item($pairs[$orig]['right']); }
                $extra = array('left_type' => $m['left_type'], 'right_type' => $m['right_type'], 'left' => $left, 'right' => $right);
            }
            $questions[] = $extra + array(
                'id'          => (int) $q['id'],
                'type'        => $q['question_type'],
                'set_id'      => (isset($q['set_id']) && isset($set_names[(int) $q['set_id']])) ? (int) $q['set_id'] : 0,
                'set_name'    => (isset($q['set_id']) && isset($set_names[(int) $q['set_id']])) ? $set_names[(int) $q['set_id']] : '',
                'text'        => (string) $q['question_text'],
                'media_type'  => $q['question_media_type'],
                'media'       => $q['question_media'] ? base_url($q['question_media']) : '',
                'option_type' => $q['option_type'],
                'options'     => $options,
                'marks'       => (float) $q['marks'],
                'show_at'     => $q['show_at_seconds'] !== NULL ? (int) $q['show_at_seconds'] : NULL,
            );
        }

        $this->session->set_userdata('vas_match_perm', $perms);

        $last = NULL;
        if ($this->db->table_exists('video_assessment_attempts')) {
            $last = $this->db->select('score, total_marks, correct_count, question_count, created_at')
                             ->where(array('video_id' => $video['id'], 'student_id' => $this->student_id))
                             ->order_by('id', 'desc')->limit(1)
                             ->get('video_assessment_attempts')->row_array();
        }

        $intro = NULL;
        if ($this->db->table_exists('video_assessment_intro')) {
            $row = $this->db->where('video_id', $video['id'])->get('video_assessment_intro')->row_array();
            if ($row) {
                $intro = array('title' => (string) $row['title'], 'text' => (string) $row['instructions'],
                               'media_type' => $row['media_type'], 'media' => $row['media'] ? base_url($row['media']) : '');
            }
        }

        $sounds = NULL;
        if ($this->db->table_exists('video_assessment_sounds')) {
            $row = $this->db->where('video_id', $video['id'])->get('video_assessment_sounds')->row_array();
            if ($row) {
                $sounds = array('bg'      => $row['bg_music'] ? base_url($row['bg_music']) : '',
                                'correct' => $row['correct_sound'] ? base_url($row['correct_sound']) : '',
                                'wrong'   => $row['wrong_sound'] ? base_url($row['wrong_sound']) : '');
            }
        }

        return $this->json(1, '', array('questions' => $questions, 'sets' => $sets, 'last_attempt' => $last ?: NULL, 'intro' => $intro, 'sounds' => $sounds));
    }

    function check() {
        $q = $this->get_question((int) $this->input->post('question_id'));
        if (!$q) {
            return $this->json(0, 'Question not found.');
        }
        $answer = $this->input->post('answer');
        $grade  = $this->grade($q, $answer);

        $extra = array('correct' => $grade['correct'], 'marks' => $grade['earned']);
        if ($q['question_type'] === 'mcq' || $q['question_type'] === 'drag') {
            $extra['correct_option'] = (int) $q['correct_option'];
        } elseif ($q['question_type'] === 'match') {
            // For each left slot: the position of its correct card, and whether the student got it.
            $perm = $this->match_perm($q['id']);
            $extra['correct_positions'] = $perm ? array_map(function ($i) use ($perm) { return array_search($i, $perm, TRUE); }, array_keys($perm)) : array();
            $extra['pair_results'] = $grade['pairs'];
        } else {
            $answers = $this->decode($q['answers']);
            $extra['correct_answer'] = isset($answers[0]) ? $answers[0] : '';
        }
        return $this->json(1, '', $extra);
    }

    /** POST video_id, answers = JSON {question_id: answer} */
    function finish() {
        $video = $this->get_video((int) $this->input->post('video_id'));
        if (!$video) {
            return $this->json(0, 'Video not found.');
        }
        $given = json_decode((string) $this->input->post('answers'), TRUE);
        if (!is_array($given)) {
            $given = array();
        }

        $score = 0; $total = 0; $right = 0; $detail = array();
        $questions = $this->active_questions($video['id']);

        $set_id = $this->input->post('set_id');
        if ($set_id !== NULL && $set_id !== '' && $this->db->table_exists('video_assessment_sets') && $this->db->field_exists('set_id', 'video_assessment_questions')) {
            $set_id = (int) $set_id;
            $info = $this->sets_for($video['id'], $questions);
            $found = NULL;
            foreach ($info as $st) { if ($st['id'] === $set_id) { $found = $st; } }
            if (!$found) {
                return $this->json(0, 'Set not found.');
            }
            if (!$found['unlocked']) {
                return $this->json(0, 'Please finish the previous level first.');
            }
            $known = array_filter(array_column($info, 'id'));
            $questions = array_values(array_filter($questions, function ($q) use ($set_id, $known) {
                $sid = isset($q['set_id']) ? (int) $q['set_id'] : 0;
                return $set_id ? $sid === $set_id : !in_array($sid, $known, TRUE);
            }));
        }
        foreach ($questions as $q) {
            $total += $q['marks'];
            $answer = isset($given[$q['id']]) ? $given[$q['id']] : NULL;
            $grade  = $answer !== NULL ? $this->grade($q, $answer) : array('correct' => FALSE, 'earned' => 0);
            $score += $grade['earned'];
            if ($grade['correct']) {
                $right++;
            }
            $detail[$q['id']] = array('answer' => $answer, 'correct' => $grade['correct'] ? 1 : 0, 'earned' => $grade['earned']);
        }

        $this->db->insert('video_assessment_attempts', array(
            'video_id'       => $video['id'],
            'student_id'     => $this->student_id,
            'score'          => $score,
            'total_marks'    => $total,
            'correct_count'  => $right,
            'question_count' => count($questions),
            'answers'        => json_encode($detail, JSON_UNESCAPED_UNICODE),
        ));

        $score = round($score, 2);
        return $this->json(1, '', array(
            'score' => $score, 'total_marks' => $total, 'correct_count' => $right, 'question_count' => count($questions),
            'share' => $this->share_info($video, isset($found) && $found ? $found['name'] : ''),
        ));
    }

    /* ------------------------------------------------------------------ helpers */

    /** Details shown on the student's "share my score" card. */
    private function share_info($video, $level) {
        $student = $this->db->select('name, student_state, student_city')->where('id', $this->student_id)
                            ->get('students')->row_array();
        $batch = $this->db->select('batch_name')->where('id', $video['batch'])->get('batches')->row_array();
        $lecture = $this->db->select('title')->where('id', $video['id'])->get('video_lectures')->row_array();
        return array(
            'name'   => $student ? trim($student['name']) : '',
            'school' => $student ? trim((string) $student['student_state']) : '',
            'city'   => $student ? trim((string) $student['student_city']) : '',
            'class'  => $batch ? trim($batch['batch_name']) : '',
            'video'  => $lecture ? trim($lecture['title']) : '',
            'level'  => (string) $level,
        );
    }

    /** A video the logged-in student may watch (one of their batches). */
    private function get_video($video_id) {
        if (!$video_id) {
            return NULL;
        }
        $video = $this->db->select('id, batch')->where(array('id' => $video_id, 'status' => 1))
                          ->get('video_lectures')->row_array();
        if (!$video) {
            return NULL;
        }
        $allowed = ((string) $video['batch'] === (string) $this->session->userdata('batch_id'))
            || $this->db->where(array('student_id' => $this->student_id, 'batch_id' => $video['batch']))
                        ->count_all_results('sudent_batchs') > 0;
        return $allowed ? $video : NULL;
    }

    private function active_questions($video_id) {
        return $this->db->where(array('video_id' => $video_id, 'status' => 1))
                        ->order_by('sort_order', 'asc')->order_by('id', 'asc')
                        ->get('video_assessment_questions')->result_array();
    }

    private function get_question($id) {
        if (!$id) {
            return NULL;
        }
        $q = $this->db->where(array('id' => $id, 'status' => 1))->get('video_assessment_questions')->row_array();
        return ($q && $this->get_video((int) $q['video_id'])) ? $q : NULL;
    }

    /** Sets of a video (in order, with "More questions" last) including this student's progress. */
    private function sets_for($video_id, $rows) {
        $set_rows = $this->db->where('video_id', $video_id)->order_by('sort_order', 'asc')->order_by('id', 'asc')
                             ->get('video_assessment_sets')->result_array();
        $sets = array(); $ids = array();
        foreach ($set_rows as $sr) { $ids[(int) $sr['id']] = TRUE; $sets[(int) $sr['id']] = array('id' => (int) $sr['id'], 'name' => $sr['name'], 'count' => 0); }
        $loose = 0;
        foreach ($rows as $r) {
            $sid = isset($r['set_id']) ? (int) $r['set_id'] : 0;
            if (isset($ids[$sid])) { $sets[$sid]['count']++; } else { $loose++; }
        }
        $sets = array_values(array_filter($sets, function ($st) { return $st['count'] > 0; }));
        if ($sets && $loose) { $sets[] = array('id' => 0, 'name' => 'More questions', 'count' => $loose); }
        return $this->set_progress($sets, $rows, $video_id);
    }

    /**
     * Add done / best / unlocked to each set from this student's saved attempts.
     * A set is done when one attempt answered all of its questions; the next set
     * unlocks only after the previous one is done.
     */
    private function set_progress($sets, $rows, $video_id) {
        if (!$sets) {
            return $sets;
        }
        $known = array();
        foreach ($sets as $st) { if ($st['id']) { $known[$st['id']] = TRUE; } }
        $members = array(); $marks = array();
        foreach ($rows as $r) {
            $sid = isset($r['set_id']) ? (int) $r['set_id'] : 0;
            $key = isset($known[$sid]) ? $sid : 0;
            $members[$key][] = (int) $r['id'];
            $marks[$key] = (isset($marks[$key]) ? $marks[$key] : 0) + (float) $r['marks'];
        }
        $attempts = array();
        if ($this->db->table_exists('video_assessment_attempts')) {
            foreach ($this->db->select('answers')->where(array('video_id' => $video_id, 'student_id' => $this->student_id))
                              ->get('video_assessment_attempts')->result_array() as $a) {
                $attempts[] = json_decode((string) $a['answers'], TRUE) ?: array();
            }
        }
        $prev_done = TRUE;
        foreach ($sets as $i => $st) {
            $ids = isset($members[$st['id']]) ? $members[$st['id']] : array();
            $done = FALSE; $best = NULL;
            foreach ($attempts as $ans) {
                $all = (bool) $ids;
                $score = 0;
                foreach ($ids as $qid) {
                    if (!isset($ans[$qid]) || $ans[$qid]['answer'] === NULL) { $all = FALSE; break; }
                    $score += isset($ans[$qid]['earned']) ? (float) $ans[$qid]['earned'] : 0;
                }
                if ($all) {
                    $done = TRUE;
                    if ($best === NULL || $score > $best) { $best = $score; }
                }
            }
            $sets[$i]['marks']    = isset($marks[$st['id']]) ? $marks[$st['id']] : 0;
            $sets[$i]['done']     = $done;
            $sets[$i]['best']     = $best;
            $sets[$i]['unlocked'] = $prev_done;
            $prev_done = $done;
        }
        return $sets;
    }

    private function item($it) {
        return array('text' => isset($it['text']) ? (string) $it['text'] : '', 'media' => !empty($it['media']) ? base_url($it['media']) : '');
    }

    private function match_perm($question_id) {
        $perms = (array) $this->session->userdata('vas_match_perm');
        return isset($perms[$question_id]) && is_array($perms[$question_id]) ? $perms[$question_id] : NULL;
    }

    /**
     * Grade one answer. Matching gives part marks per correct pair; other types
     * are all-or-nothing. Returns ['correct'=>bool, 'earned'=>float, 'pairs'=>bool[]].
     */
    private function grade($q, $answer) {
        $marks = (float) $q['marks'];
        if ($q['question_type'] !== 'match') {
            $ok = $this->is_correct($q, $answer);
            return array('correct' => $ok, 'earned' => $ok ? $marks : 0, 'pairs' => array());
        }
        // answer = JSON array: answer[leftIndex] = position of the card the student placed there
        $perm   = $this->match_perm($q['id']);
        $placed = is_string($answer) ? json_decode($answer, TRUE) : $answer;
        if (!$perm || !is_array($placed)) {
            return array('correct' => FALSE, 'earned' => 0, 'pairs' => array());
        }
        $pairs = array(); $right = 0;
        foreach (array_keys($perm) as $i) {
            $pos = isset($placed[$i]) && is_numeric($placed[$i]) ? (int) $placed[$i] : -1;
            $ok  = $pos >= 0 && isset($perm[$pos]) && (int) $perm[$pos] === $i;
            $pairs[] = $ok;
            if ($ok) { $right++; }
        }
        $n = count($perm);
        return array('correct' => $right === $n, 'earned' => $n ? round($marks * $right / $n, 2) : 0, 'pairs' => $pairs);
    }

    private function is_correct($q, $answer) {
        if (is_array($answer)) {
            return FALSE;
        }
        if ($q['question_type'] === 'mcq' || $q['question_type'] === 'drag') {
            return $answer !== '' && ctype_digit((string) $answer) && (int) $answer === (int) $q['correct_option'];
        }
        $given = $this->normalise($answer);
        if ($given === '') {
            return FALSE;
        }
        foreach ($this->decode($q['answers']) as $accepted) {
            if ($this->normalise($accepted) === $given) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /** Case-insensitive, ignore extra spaces and trailing punctuation. */
    private function normalise($text) {
        $text = mb_strtolower(trim((string) $text), 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);
        return trim($text, " \t.!?,;:");
    }

    private function decode($json) {
        $data = $json ? json_decode($json, TRUE) : array();
        return is_array($data) ? $data : array();
    }

    private function json($status, $msg, $extra = array()) {
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array_merge(array('status' => $status, 'msg' => $msg), $extra)));
    }
}
