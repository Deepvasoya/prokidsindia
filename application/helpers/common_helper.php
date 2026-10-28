<?php

defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('get_marksdetailrow')) {
	function get_marksdetailrow($id,$questionid)
	{
		$ci = &get_instance();
		$ci->db->select('*');
		$ci->db->from('descriptive_result');
		$ci->db->where(array('descriptive_student_id' => $id,'questionid' => $questionid));
		$row = $ci->db->get()->row();
		if($row){
			return $row;
		}else{
			return '0';
		}
	}
}