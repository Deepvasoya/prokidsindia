<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Per-video assessment questions (admin + teacher).
 *
 * Question types:
 *  - mcq  : 3 or 4 options; options can be text, image, audio or video.
 *  - fill : learner types the answer; checked against a list of accepted answers.
 * Any question can carry a prompt media file (image / audio / video).
 *
 * Table: video_assessment_questions (see application/sql/video_assessment.sql)
 */
class Video_assessment extends CI_Controller {

    const TABLE      = 'video_assessment_questions';
    const UPLOAD_DIR = 'uploads/video_assessment/';

    /** Allowed extensions and max size (bytes) per media kind. */
    private $media_rules = array(
        'image' => array('ext' => array('jpg', 'jpeg', 'png', 'gif', 'webp'),       'max' => 5242880,   'mime' => 'image/'),
        'audio' => array('ext' => array('mp3', 'wav', 'ogg', 'm4a', 'aac'),         'max' => 20971520,  'mime' => 'audio/'),
        'video' => array('ext' => array('mp4', 'webm', 'mov', 'm4v'),               'max' => 209715200, 'mime' => 'video/'),
    );

    private $owner_id;

    function __construct() {
        parent::__construct();

        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if ($role === '') {
            redirect(base_url('login'));
        } elseif ($role == 'student') {
            redirect(base_url('student/dashboard'));
        } elseif ($role != 1 && $role != 3) {
            redirect(base_url('login'));
        }

        // Videos belong to the admin account; teachers work under their admin.
        $this->owner_id = ($role == 1) ? (int) $this->session->userdata('uid') : (int) $this->session->userdata('admin_id');

        $timezoneDB = $this->db_model->select_data('timezone', 'site_details', array('id' => 1));
        if (!empty($timezoneDB[0]['timezone'])) {
            date_default_timezone_set($timezoneDB[0]['timezone']);
        }
    }

    /* ------------------------------------------------------------------ pages */

    function index($video_id = 0) {
        $video = $this->get_video($video_id);
        if (!$video) {
            show_404();
        }

        $header['title'] = 'Video Assessment';
        $data['video']     = $video;
        $data['questions'] = $this->get_questions($video['id']);
        $data['batch_name'] = '';
        $batch = $this->db_model->select_data('batch_name', 'batches', array('id' => $video['batch']), 1);
        if (!empty($batch)) {
            $data['batch_name'] = $batch[0]['batch_name'];
        }

        $is_teacher = ($this->session->userdata('role') == 3);
        $this->load->view($is_teacher ? 'common/teacher_header' : 'common/admin_header', $header);
        $this->load->view('admin/video_assessment', $data);
        $this->load->view($is_teacher ? 'common/teacher_footer' : 'common/admin_footer');
    }

    /* ------------------------------------------------------------------ ajax */

    /** Return one question as JSON (for the edit form). */
    function get() {
        $q = $this->get_question((int) $this->input->post('id'));
        if (!$q) {
            return $this->json(0, 'Question not found.');
        }
        return $this->json(1, '', array('question' => $this->present($q)));
    }

    /** Create or update a question. */
    function save() {
        $post     = $this->input->post(NULL, TRUE);
        $id       = isset($post['id']) ? (int) $post['id'] : 0;
        $video_id = isset($post['video_id']) ? (int) $post['video_id'] : 0;

        $video = $this->get_video($video_id);
        if (!$video) {
            return $this->json(0, 'Video not found.');
        }

        $existing = NULL;
        if ($id) {
            $existing = $this->get_question($id);
            if (!$existing || (int) $existing['video_id'] !== $video_id) {
                return $this->json(0, 'Question not found.');
            }
        }

        $type = (isset($post['question_type']) && $post['question_type'] === 'fill') ? 'fill' : 'mcq';
        $question_media_type = $this->pick(isset($post['question_media_type']) ? $post['question_media_type'] : 'none', array('none', 'image', 'audio', 'video'), 'none');
        $question_text = isset($post['question_text']) ? trim($post['question_text']) : '';

        $marks = isset($post['marks']) && is_numeric($post['marks']) ? (float) $post['marks'] : 1;
        if ($marks <= 0) {
            $marks = 1;
        }

        $show_at = $this->parse_time(isset($post['show_at']) ? $post['show_at'] : '');
        if ($show_at === FALSE) {
            return $this->json(0, 'Show at time must look like 1:30 or 90 (seconds).');
        }

        // Track files written in this request so we can clean up on failure.
        $new_files = array();

        // Prompt media
        $question_media = $existing ? $existing['question_media'] : NULL;
        if ($question_media_type === 'none') {
            $question_media = NULL;
        } elseif (!empty($_FILES['question_media_file']['name'])) {
            $up = $this->upload('question_media_file', $question_media_type);
            if (isset($up['error'])) {
                return $this->json(0, 'Question media: ' . $up['error']);
            }
            $question_media = $new_files[] = $up['path'];
        } elseif (!$existing || $existing['question_media_type'] !== $question_media_type) {
            $question_media = NULL;
        }
        if ($question_media_type !== 'none' && empty($question_media)) {
            $this->remove_files($new_files);
            return $this->json(0, 'Please upload the question ' . $question_media_type . '.');
        }
        if ($question_media_type === 'none' && $question_text === '') {
            return $this->json(0, 'Please enter the question.');
        }

        $row = array(
            'video_id'            => $video_id,
            'question_type'       => $type,
            'question_text'       => $question_text,
            'question_media_type' => $question_media_type,
            'question_media'      => $question_media,
            'marks'               => $marks,
            'show_at_seconds'     => $show_at,
            'option_type'         => 'text',
            'options'             => NULL,
            'correct_option'      => NULL,
            'answers'             => NULL,
        );

        if ($type === 'mcq') {
            $option_type = $this->pick(isset($post['option_type']) ? $post['option_type'] : 'text', array('text', 'image', 'audio', 'video'), 'text');
            $count = (isset($post['option_count']) && (int) $post['option_count'] === 3) ? 3 : 4;

            $old_options = array();
            if ($existing && $existing['option_type'] === $option_type && $existing['options']) {
                $old_options = json_decode($existing['options'], TRUE) ?: array();
            }

            $texts   = isset($post['option_text']) && is_array($post['option_text']) ? $post['option_text'] : array();
            $options = array();
            for ($i = 0; $i < $count; $i++) {
                $text  = isset($texts[$i]) ? trim($texts[$i]) : '';
                $media = isset($old_options[$i]['media']) ? $old_options[$i]['media'] : '';

                if ($option_type !== 'text') {
                    $field = 'option_media_file_' . $i;
                    if (!empty($_FILES[$field]['name'])) {
                        $up = $this->upload($field, $option_type);
                        if (isset($up['error'])) {
                            $this->remove_files($new_files);
                            return $this->json(0, 'Option ' . chr(65 + $i) . ': ' . $up['error']);
                        }
                        $media = $new_files[] = $up['path'];
                    }
                    if ($media === '') {
                        $this->remove_files($new_files);
                        return $this->json(0, 'Please upload the ' . $option_type . ' for option ' . chr(65 + $i) . '.');
                    }
                } else {
                    $media = '';
                    if ($text === '') {
                        return $this->json(0, 'Please fill in option ' . chr(65 + $i) . '.');
                    }
                }
                $options[] = array('text' => $text, 'media' => $media);
            }

            $correct = isset($post['correct_option']) && $post['correct_option'] !== '' ? (int) $post['correct_option'] : -1;
            if ($correct < 0 || $correct >= $count) {
                $this->remove_files($new_files);
                return $this->json(0, 'Please select the correct answer.');
            }

            $row['option_type']    = $option_type;
            $row['options']        = json_encode($options, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $row['correct_option'] = $correct;
        } else {
            $raw     = isset($post['answers']) ? $post['answers'] : '';
            $answers = array_values(array_unique(array_filter(array_map('trim', preg_split('/\r\n|\r|\n|\|/', $raw)), 'strlen')));
            if (empty($answers)) {
                $this->remove_files($new_files);
                return $this->json(0, 'Please add at least one correct answer.');
            }
            $row['answers'] = json_encode($answers, JSON_UNESCAPED_UNICODE);
        }

        if ($existing) {
            $this->db->where('id', $id)->update(self::TABLE, $row);
            // Delete media that is no longer referenced.
            $this->remove_files(array_diff($this->files_of($existing), $this->files_of($row)));
            $msg = 'Question updated.';
        } else {
            $max = $this->db->select_max('sort_order')->where('video_id', $video_id)->get(self::TABLE)->row_array();
            $row['admin_id']   = $this->owner_id;
            $row['added_by']   = (int) $this->session->userdata('uid');
            $row['sort_order'] = (int) $max['sort_order'] + 1;
            $row['status']     = 1;
            $this->db->insert(self::TABLE, $row);
            $id  = $this->db->insert_id();
            $msg = 'Question added.';
        }

        return $this->json(1, $msg, array('id' => $id));
    }

    function delete() {
        $q = $this->get_question((int) $this->input->post('id'));
        if (!$q) {
            return $this->json(0, 'Question not found.');
        }
        $this->db->where('id', $q['id'])->delete(self::TABLE);
        $this->remove_files($this->files_of($q));
        return $this->json(1, 'Question deleted.');
    }

    function status() {
        $q = $this->get_question((int) $this->input->post('id'));
        if (!$q) {
            return $this->json(0, 'Question not found.');
        }
        $active = $q['status'] ? 0 : 1;
        $this->db->where('id', $q['id'])->update(self::TABLE, array('status' => $active));
        return $this->json(1, $active ? 'Question is now active.' : 'Question is now hidden from students.', array('active' => $active));
    }

    /** Save new order: POST ids[] in display order. */
    function reorder() {
        $video = $this->get_video((int) $this->input->post('video_id'));
        $ids   = $this->input->post('ids');
        if (!$video || !is_array($ids)) {
            return $this->json(0, 'Nothing to reorder.');
        }
        foreach (array_values($ids) as $i => $qid) {
            $this->db->where(array('id' => (int) $qid, 'video_id' => $video['id']))
                     ->update(self::TABLE, array('sort_order' => $i + 1));
        }
        return $this->json(1, 'Order saved.');
    }

    /* ------------------------------------------------------------------ helpers */

    private function get_video($video_id) {
        $video_id = (int) $video_id;
        if (!$video_id) {
            return NULL;
        }
        $row = $this->db->select('id, title, url, video_type, batch, subject, topic, admin_id')
                        ->where(array('id' => $video_id, 'admin_id' => $this->owner_id))
                        ->get('video_lectures')->row_array();
        return $row ?: NULL;
    }

    private function get_question($id) {
        if (!$id) {
            return NULL;
        }
        $row = $this->db->where(array('id' => $id, 'admin_id' => $this->owner_id))->get(self::TABLE)->row_array();
        return $row ?: NULL;
    }

    private function get_questions($video_id) {
        $rows = $this->db->where(array('video_id' => $video_id, 'admin_id' => $this->owner_id))
                         ->order_by('sort_order', 'asc')->order_by('id', 'asc')
                         ->get(self::TABLE)->result_array();
        return array_map(array($this, 'present'), $rows);
    }

    /** Decode JSON columns for views / JSON responses. */
    private function present($q) {
        $q['options'] = $q['options'] ? (json_decode($q['options'], TRUE) ?: array()) : array();
        $q['answers'] = $q['answers'] ? (json_decode($q['answers'], TRUE) ?: array()) : array();
        $q['show_at'] = $q['show_at_seconds'] !== NULL ? sprintf('%d:%02d', floor($q['show_at_seconds'] / 60), $q['show_at_seconds'] % 60) : '';
        return $q;
    }

    /** All media paths referenced by a question row. */
    private function files_of($row) {
        $files = array();
        if (!empty($row['question_media'])) {
            $files[] = $row['question_media'];
        }
        $options = is_array($row['options']) ? $row['options'] : (json_decode((string) $row['options'], TRUE) ?: array());
        foreach ($options as $opt) {
            if (!empty($opt['media'])) {
                $files[] = $opt['media'];
            }
        }
        return array_unique($files);
    }

    private function remove_files($paths) {
        foreach ($paths as $path) {
            // Only ever delete inside our own upload folder.
            if (strpos($path, self::UPLOAD_DIR) === 0 && strpos($path, '..') === FALSE && is_file(FCPATH . $path)) {
                @unlink(FCPATH . $path);
            }
        }
    }

    /** Validate and store one uploaded file. Returns ['path'=>...] or ['error'=>...]. */
    private function upload($field, $kind) {
        if (!isset($this->media_rules[$kind])) {
            return array('error' => 'Unsupported media type.');
        }
        $rule = $this->media_rules[$kind];
        $file = $_FILES[$field];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $too_big = in_array($file['error'], array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE));
            return array('error' => $too_big ? 'File is too large.' : 'Upload failed, please try again.');
        }
        if ($file['size'] > $rule['max']) {
            return array('error' => 'File is too large (max ' . round($rule['max'] / 1048576) . ' MB).');
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $rule['ext'])) {
            return array('error' => 'Allowed ' . $kind . ' files: ' . implode(', ', $rule['ext']) . '.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        // .m4a/.ogg are sometimes detected as video/* containers; accept the family.
        $family_ok = strpos($mime, $rule['mime']) === 0
            || ($kind === 'audio' && in_array($mime, array('video/mp4', 'video/ogg', 'application/ogg', 'video/webm')));
        if (!$family_ok) {
            return array('error' => 'This does not look like a valid ' . $kind . ' file.');
        }

        if (!is_dir(FCPATH . self::UPLOAD_DIR)) {
            @mkdir(FCPATH . self::UPLOAD_DIR, 0775, TRUE);
        }
        $name = $kind . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        if (!@move_uploaded_file($file['tmp_name'], FCPATH . self::UPLOAD_DIR . $name)) {
            return array('error' => 'Could not save the file on the server.');
        }
        return array('path' => self::UPLOAD_DIR . $name);
    }

    /** "1:30" / "90" -> 90; "" -> NULL; invalid -> FALSE */
    private function parse_time($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return NULL;
        }
        if (ctype_digit($value)) {
            return (int) $value;
        }
        if (preg_match('/^(\d{1,3}):([0-5]\d)$/', $value, $m)) {
            return (int) $m[1] * 60 + (int) $m[2];
        }
        return FALSE;
    }

    private function pick($value, $allowed, $default) {
        return in_array($value, $allowed, TRUE) ? $value : $default;
    }

    private function json($status, $msg, $extra = array()) {
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array_merge(array('status' => $status, 'msg' => $msg), $extra)));
    }
}
