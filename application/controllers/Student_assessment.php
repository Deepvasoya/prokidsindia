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
        $questions = array();
        foreach ($rows as $q) {
            $options = array();
            foreach ($this->decode($q['options']) as $opt) {
                $options[] = array('text' => $opt['text'], 'media' => $opt['media'] ? base_url($opt['media']) : '');
            }
            $questions[] = array(
                'id'          => (int) $q['id'],
                'type'        => $q['question_type'],
                'text'        => (string) $q['question_text'],
                'media_type'  => $q['question_media_type'],
                'media'       => $q['question_media'] ? base_url($q['question_media']) : '',
                'option_type' => $q['option_type'],
                'options'     => $q['question_type'] === 'mcq' ? $options : array(),
                'marks'       => (float) $q['marks'],
                'show_at'     => $q['show_at_seconds'] !== NULL ? (int) $q['show_at_seconds'] : NULL,
            );
        }

        $last = NULL;
        if ($this->db->table_exists('video_assessment_attempts')) {
            $last = $this->db->select('score, total_marks, correct_count, question_count, created_at')
                             ->where(array('video_id' => $video['id'], 'student_id' => $this->student_id))
                             ->order_by('id', 'desc')->limit(1)
                             ->get('video_assessment_attempts')->row_array();
        }

        return $this->json(1, '', array('questions' => $questions, 'last_attempt' => $last ?: NULL));
    }

    function check() {
        $q = $this->get_question((int) $this->input->post('question_id'));
        if (!$q) {
            return $this->json(0, 'Question not found.');
        }
        $answer  = $this->input->post('answer');
        $correct = $this->is_correct($q, $answer);

        $extra = array('correct' => $correct, 'marks' => $correct ? (float) $q['marks'] : 0);
        if ($q['question_type'] === 'mcq') {
            $extra['correct_option'] = (int) $q['correct_option'];
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
        foreach ($questions as $q) {
            $total += $q['marks'];
            $answer = isset($given[$q['id']]) ? $given[$q['id']] : NULL;
            $ok = $answer !== NULL && $this->is_correct($q, $answer);
            if ($ok) {
                $score += $q['marks'];
                $right++;
            }
            $detail[$q['id']] = array('answer' => $answer, 'correct' => $ok ? 1 : 0);
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

        return $this->json(1, '', array(
            'score' => $score, 'total_marks' => $total, 'correct_count' => $right, 'question_count' => count($questions),
        ));
    }

    /* ------------------------------------------------------------------ helpers */

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

    private function is_correct($q, $answer) {
        if (is_array($answer)) {
            return FALSE;
        }
        if ($q['question_type'] === 'mcq') {
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
