<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MobileApi extends CI_Controller {
    function __construct()
    {
        error_reporting(0);
        parent::__construct();
    }
    
    
    public function push_notification_android(){
        
         ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


        $this->PushNotification_Model->letSend();
    }
   
    
}