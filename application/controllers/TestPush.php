<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestPush extends CI_Controller {
 
	function __construct(){
	    
		parent::__construct();	
		 $timezoneDB = $this->db_model->select_data('timezone','site_details',array('id'=>1));
		if(isset($timezoneDB[0]['timezone']) && !empty($timezoneDB[0]['timezone'])){
            date_default_timezone_set($timezoneDB[0]['timezone']);
        }
		
			
		
	}
	
	public function send(){
	    $device_id = "dlhkdD8tTzaey2B8Qiq3W1:APA91bFvOu82w1pDANftB1DfPISzhntnRfjgPEi2jOJzD5-M2p2-GkldWjGrv2ZP6NqhUTOOWAMAV3r_1UqMU1dTl2gftZjozDcFtmoyGQfX6-QfmOBigOx5b0FOD-hcmLY4ZOk5KD45";
	    $title = "Title";
	    $bodyMsg = "Body";
       $this->PushNotification_Model->letSendWithToken($device_id,$title,$bodyMsg);
	}
	
}
?>