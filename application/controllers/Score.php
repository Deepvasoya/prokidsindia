<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Public page for a shared quiz score card: /score/<code>
 *
 * WhatsApp, Facebook etc. read the og:image tags of this page and show the
 * score card picture as a big link preview. The picture and its caption are
 * saved by student_assessment/save_card under uploads/video_assessment/cards/.
 */
class Score extends CI_Controller {

    const CARD_DIR = 'uploads/video_assessment/cards/';

    function index($code = '') {
        if (!preg_match('/^[a-f0-9]{24}$/', $code) || !is_file(FCPATH . self::CARD_DIR . $code . '.jpg')) {
            show_404();
        }
        $info = array();
        if (is_file(FCPATH . self::CARD_DIR . $code . '.json')) {
            $info = json_decode((string) file_get_contents(FCPATH . self::CARD_DIR . $code . '.json'), TRUE) ?: array();
        }
        $site  = $this->db->select('site_title')->where('id', 1)->get('site_details')->row_array();
        $site  = $site && $site['site_title'] ? $site['site_title'] : 'ProKids India';
        $title = !empty($info['title']) ? $info['title'] : 'My quiz score';
        $text  = !empty($info['text']) ? $info['text'] : 'Quiz score card';
        $image = base_url(self::CARD_DIR . $code . '.jpg');
        $url   = base_url('score/' . $code);
        $e = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<title>' . $e($title . ' - ' . $site) . '</title>'
            . '<meta name="description" content="' . $e($text) . '">'
            . '<meta property="og:type" content="website">'
            . '<meta property="og:site_name" content="' . $e($site) . '">'
            . '<meta property="og:title" content="' . $e($title) . '">'
            . '<meta property="og:description" content="' . $e($text) . '">'
            . '<meta property="og:url" content="' . $e($url) . '">'
            . '<meta property="og:image" content="' . $e($image) . '">'
            . '<meta property="og:image:secure_url" content="' . $e($image) . '">'
            . '<meta property="og:image:type" content="image/jpeg">'
            . '<meta property="og:image:width" content="1080"><meta property="og:image:height" content="1350">'
            . '<meta name="twitter:card" content="summary_large_image">'
            . '<meta name="twitter:image" content="' . $e($image) . '">'
            . '<style>body{margin:0;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;padding:20px;box-sizing:border-box;background:#f4f6ff;font-family:Nunito,Segoe UI,Arial,sans-serif;color:#1f2a4d;text-align:center}'
            . 'img{width:min(420px,100%);height:auto;border-radius:20px;box-shadow:0 14px 34px rgba(31,42,77,.18)}'
            . 'p{max-width:420px;margin:0;font-weight:700}a{display:inline-block;padding:12px 22px;border-radius:999px;background:linear-gradient(120deg,#ff8a3d,#ff5c8a);color:#fff;text-decoration:none;font-weight:800}</style>'
            . '</head><body>'
            . '<img src="' . $e($image) . '" alt="' . $e($title) . '">'
            . '<p>' . $e($text) . '</p>'
            . '<a href="' . $e(base_url()) . '">Visit ' . $e($site) . '</a>'
            . '</body></html>';
    }
}
