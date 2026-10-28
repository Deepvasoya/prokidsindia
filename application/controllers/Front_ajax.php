<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front_ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load paypal library
        $this->load->library('paypal_lib');

        $timezoneDB = $this->db_model->select_data('timezone', 'site_details', ['id' => 1]);
        if (isset($timezoneDB[0]['timezone']) && ! empty($timezoneDB[0]['timezone'])) {
            date_default_timezone_set($timezoneDB[0]['timezone']);
        }
        require_once APPPATH . 'libraries/htmlpurifier/HTMLPurifier.auto.php';
        $this->load->helper('htmlpurifier');

        $this->load->helper('language');

        // check select language
        $language = $this->general_settings('language_name');
        if ($language == "french") {
            $this->lang->load('french_lang', 'french');
        } else if ($language == "arabic") {
            $this->lang->load('arabic_lang', 'arabic');
        } else {
            $this->lang->load('english_lang', 'english');
        }

    }

    public function general_settings($key_text = '')
    {
        $data = $this->db_model->select_data('*', 'general_settings', ['key_text' => $key_text], 1);
        return $data[0]['velue_text'];
    }

    public function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result),
            0, $length_of_string);
    }

//   function login(){
//         if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
//             if(!empty($this->input->post('email',false)) && !empty($this->input->post('password',false))){
//                 $email = trim($this->input->post('email',TRUE));
//                 $pass = md5(trim($this->input->post('password',TRUE)));
//                 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
//                     $stud_cond = array('enrollment_id'=>$email,'password'=>$pass);
//                 }else{
//                     $stud_cond = array('email'=>$email,'password'=>$pass);
//                 }
//                 $userDetails = $this->db_model->select_data('id,name,role,status,parent_id,teach_image,email,teach_batch,teach_subject,super_admin','users use index (id)',array('email'=>$email,'password'=>$pass),1);
//                 $studentDetails = $this->db_model->select_data('id,name,contact_no,batch_id,admin_id,enrollment_id,image,email,status,login_status','students use index (id)',$stud_cond,1);

//                 if(!empty($userDetails)){
//                       if($userDetails[0]['status']=='1'){
//                         $brewers_strings = $this->random_strings(10);
//                         $sess_arr = array(
//                                     'uid'=> $userDetails[0]['id'],
//                                     'name'=> $userDetails[0]['name'],
//                                     'role'=> $userDetails[0]['role'],
//                                     'status'=> $userDetails[0]['status'],
//                                     'admin_id' => $userDetails[0]['parent_id'],
//                                     'profile_img' => $userDetails[0]['teach_image'],
//                                     'email' => $userDetails[0]['email'],
//                                     'mobile' => $userDetails[0]['contact_no'],
//                                     'brewers_check' => $brewers_strings,
//                                     'super_admin' => $userDetails[0]['super_admin'],

//                                 );

//                         $url = '';
//                         if($userDetails[0]['role']=='1'){
//                             $url = base_url().'admin/dashboard';
//                         }else if($userDetails[0]['role']=='3'){
//                             $url = base_url().'teacher/dashboard';
//                             $sess_arr['subject_id'] =implode(",",json_decode($userDetails[0]['teach_subject'])) ;
//                             $sess_arr['batch_id'] = $userDetails[0]['teach_batch'];
//                         }

//                         $this->session->set_userdata($sess_arr);

//                         $this->db_model->update_data_limit('courses use index (id)',$this->security->xss_clean(array('status'=>0)),array('admin_id'=>$userDetails[0]['id'],'end_date <= '=>date('Y-m-d')));

//                         if($this->input->post('remember_me',TRUE)){
//                             $cookie = setcookie("UML", base64_encode(urlencode(base64_encode($email))), time() + 86400, '/');
//                             $cookie =setcookie("SSD", base64_encode(urlencode(base64_encode($this->input->post('password',TRUE)))), time() + 86400,'/');
//                          }
//                          else{
//                             $cookie =setcookie("UML", base64_encode(urlencode(base64_encode($email))), time() - 86400, '/');
//                             $cookie =setcookie("SSD", base64_encode(urlencode(base64_encode($this->input->post('password',TRUE)))), time() - 86400, '/');
//                         }

//                         $resp = array('status'=>'1','msg'=>$this->lang->line('ltr_logged_msg'),'url'=>$url);

//                         $this->db_model->update_data_limit('users use index (id)',$this->security->xss_clean(array('token'=>1,'brewers_check'=>$brewers_strings)),array('id'=>$userDetails[0]['id']),1);
//                       }else{
//                         $resp = array('status' => '0','msg' =>$this->lang->line('ltr_contact_to_admin_msg'));
//                     }

//                 }
//                 // else if(!empty($studentDetails)){
//                 //     if($studentDetails[0]['status']=='1'){
//                 //         $batch_details = $this->db_model->select_data('id,batch_name','batches use index (id)',array('status'=>1,'id'=>$studentDetails[0]['batch_id']),1);

//                 //     //   if(!empty($batch_details)){
//                 //         if($studentDetails[0]['login_status'] == 1){
//                 //             $resp = array('status' => '2','student_id' => $studentDetails[0]['id']);
//                 //         }else{
//                 //             $brewers_strings = $this->random_strings(10);
//                 //             $sess_arr = array(
//                 //                 'uid'=> $studentDetails[0]['id'],
//                 //                 'name'=> $studentDetails[0]['name'],
//                 //                 'role'=> 'student',
//                 //                 'mobile' => $studentDetails[0]['contact_no'],
//                 //                 'admin_id' => $studentDetails[0]['admin_id'],
//                 //                 'profile_img' => $studentDetails[0]['image'],
//                 //                 'email' => $studentDetails[0]['email'],
//                 //                 'batch_id' => $studentDetails[0]['batch_id'],
//                 //                 'enrollment_id' => $studentDetails[0]['enrollment_id'],
//                 //                 'brewers_check' => $brewers_strings,
//                 //             );

//                 //             $this->session->set_userdata($sess_arr);

//                 //             if($this->input->post('remember_me',TRUE)){
//                 //                 $cookie = setcookie("email", base64_encode($email), time() + 86400, '/');
//                 //                 $cookie =setcookie("password", base64_encode($this->input->post('password',TRUE)), time() + 86400,'/');
//                 //             }
//                 //             else{
//                 //                 $cookie =setcookie("email", base64_encode($email), time() - 86400, '/');
//                 //                 $cookie =setcookie("password", base64_encode($this->input->post('password',TRUE)), time() - 86400, '/');
//                 //             }

//                 //             $this->db_model->update_data_limit('students use index (id)',$this->security->xss_clean(array('login_status'=>1,'token'=>1,'brewers_check'=>$brewers_strings)),array('id'=>$studentDetails[0]['id']),1);

//                 //             $resp = array('status'=>'1','msg'=>$this->lang->line('ltr_logged_msg'),'url'=>base_url().'student/dashboard');
//                 //         }
//                 //     //   }else{
//                 //     //       $resp = array('status' => '0','msg' => $this->lang->line('ltr_batch_in_msg'));
//                 //     //   }

//                 //       }else{
//                 //         $resp = array('status' => '0','msg' =>$this->lang->line('ltr_contact_to_admin_msg'));
//                 //     }
//                 // }else{
//                 //     $resp = array('status' => '0','msg' =>$this->lang->line('ltr_wrong_credentials_msg'));
//                 // }
//             }else{
//                 $resp = array('status' => '0','msg' =>$this->lang->line('ltr_wrong_credentials_msg'));
//             }
//             echo json_encode($resp,JSON_UNESCAPED_SLASHES);
//         }else{
//             echo $this->lang->line('ltr_not_allowed_msg');
//         }
//     }

    public function login()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false)) && ! empty($this->input->post('password', false))) {
                $email     = trim($this->input->post('email', true));
                $device_id = $this->input->post('device_id');

                $pass = md5(trim($this->input->post('password', true)));
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $stud_cond = ['enrollment_id' => $email, 'password' => $pass];
                } else {
                    $stud_cond = ['email' => $email, 'password' => $pass];
                }

                $userDetails    = $this->db_model->select_data('id,name,role,access,status,parent_id,teach_image,email,teach_batch,teach_subject,super_admin', 'users use index (id)', ['email' => $email, 'password' => $pass], 1);
                $studentDetails = $this->db_model->select_data('id,name,contact_no,batch_id,admin_id,enrollment_id,image,email,status,login_status', 'students use index (id)', $stud_cond, 1);

                if (! empty($userDetails)) {
                    $deviceSetting = $this->general_settings('web_device_setting');

                    if (! empty($deviceSetting) && ! empty($device_id) && $studentDetails[0]['id'] != 1) {
                        if ($deviceSetting == 2) {
                            $checkDevice = $this->db_model->select_data('id,device_id', 'devices use index (id)', ['student_id' => $studentDetails[0]['id']], 1);
                            if (empty($checkDevice)) {

                                $data_device['device_id']   = $device_id;
                                $data_device['student_id']  = $userDetails[0]['id'];
                                $data_device['name']        = $userDetails[0]['name'];
                                $data_device['email']       = $userDetails[0]['email'];
                                $data_device['is_web']      = 1;
                                $data_device['device_name'] = "WEB";
                                $data_device['contact_no']  = $userDetails[0]['contact_no'];

                                $this->db_model->insert_data('devices', $data_device);

                            } else {
                                if ($checkDevice[0]['device_id'] != $device_id) {
                                    $arr = ['status' => '0', 'msg' => 'Seems you already logged in with other device, Please contact admin if you face any issue'];
                                    echo json_encode($arr);
                                    die;
                                }
                            }
                        }
                    }

                    if ($userDetails[0]['status'] == '1') {

                        // 1 for last login, 2 for single device and 3 for multiple devices

                        $brewers_strings = $this->random_strings(10);
                        $sess_arr        = [
                            'uid'           => $userDetails[0]['id'],
                            'name'          => $userDetails[0]['name'],
                            'role'          => $userDetails[0]['role'],
                            'status'        => $userDetails[0]['status'],
                            'admin_id'      => $userDetails[0]['parent_id'],
                            'profile_img'   => $userDetails[0]['teach_image'],
                            'email'         => $userDetails[0]['email'],
                            'mobile'        => $userDetails[0]['contact_no'],
                            'brewers_check' => $brewers_strings,
                            'access'        => $userDetails[0]['access'],
                            'super_admin'   => $userDetails[0]['super_admin'],

                        ];

                        $url = '';
                        if ($userDetails[0]['role'] == '1') {
                            $url = base_url() . 'admin/dashboard';
                        } else if ($userDetails[0]['role'] == '3') {
                            $url                    = base_url() . 'teacher/dashboard';
                            $sess_arr['subject_id'] = implode(",", json_decode($userDetails[0]['teach_subject']));
                            $sess_arr['batch_id']   = $userDetails[0]['teach_batch'];
                        }

                        $this->session->set_userdata($sess_arr);

                        $this->db_model->update_data_limit('courses use index (id)', $this->security->xss_clean(['status' => 0]), ['admin_id' => $userDetails[0]['id'], 'end_date <= ' => date('Y-m-d')]);

                        if ($this->input->post('remember_me', true)) {
                            $cookie = setcookie("UML", base64_encode(urlencode(base64_encode($email))), time() + 86400, '/');
                            $cookie = setcookie("SSD", base64_encode(urlencode(base64_encode($this->input->post('password', true)))), time() + 86400, '/');
                        } else {
                            $cookie = setcookie("UML", base64_encode(urlencode(base64_encode($email))), time() - 86400, '/');
                            $cookie = setcookie("SSD", base64_encode(urlencode(base64_encode($this->input->post('password', true)))), time() - 86400, '/');
                        }

                        $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_logged_msg'), 'url' => $url];

                        $this->db_model->update_data_limit('users use index (id)', $this->security->xss_clean(['token' => 1, 'brewers_check' => $brewers_strings]), ['id' => $userDetails[0]['id']], 1);
                    } else {
                        $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_contact_to_admin_msg')];
                    }

                } else if (! empty($studentDetails)) {

                    $deviceSetting = $this->general_settings('web_device_setting');

                    if (! empty($deviceSetting) && ! empty($device_id) && $studentDetails[0]['id'] != 1) {

                        if ($deviceSetting == 2) {

                            $checkDevice = $this->db_model->select_data('id,device_id', 'devices use index (id)', ['student_id' => $studentDetails[0]['id']], 1);

                            if (empty($checkDevice)) {

                                $data_device['device_id']   = $device_id;
                                $data_device['student_id']  = $studentDetails[0]['id'];
                                $data_device['name']        = $studentDetails[0]['name'];
                                $data_device['email']       = $studentDetails[0]['email'];
                                $data_device['device_name'] = "WEB";
                                $data_device['is_web']      = 1;
                                $data_device['contact_no']  = $studentDetails[0]['contact_no'];

                                $this->db_model->insert_data('devices', $data_device);

                            } else {
                                if ($checkDevice[0]['device_id'] != $device_id) {
                                    $arr = ['status' => '0', 'msg' => 'Seems you already logged in with other device, Please contact admin if you face any issue'];
                                    echo json_encode($arr);
                                    die;

                                }
                            }
                        }
                    }

                    if ($studentDetails[0]['status'] == '1') {
                        $batch_details = $this->db_model->select_data('id,batch_name', 'batches use index (id)', ['status' => 1, 'id' => $studentDetails[0]['batch_id']], 1);

                        //   if(!empty($batch_details)){
                        if ($studentDetails[0]['login_status'] == 1) {

                            $resp = ['status' => '2', 'student_id' => $studentDetails[0]['id']];

                        } else {
                            $brewers_strings = $this->random_strings(10);
                            $sess_arr        = [
                                'uid'           => $studentDetails[0]['id'],
                                'name'          => $studentDetails[0]['name'],
                                'role'          => 'student',
                                'mobile'        => $studentDetails[0]['contact_no'],
                                'admin_id'      => $studentDetails[0]['admin_id'],
                                'profile_img'   => $studentDetails[0]['image'],
                                'email'         => $studentDetails[0]['email'],
                                'batch_id'      => $studentDetails[0]['batch_id'],
                                'enrollment_id' => $studentDetails[0]['enrollment_id'],
                                'brewers_check' => $brewers_strings,
                            ];

                            $this->session->set_userdata($sess_arr);

                            if ($this->input->post('remember_me', true)) {
                                $cookie = setcookie("email", base64_encode($email), time() + 86400, '/');
                                $cookie = setcookie("password", base64_encode($this->input->post('password', true)), time() + 86400, '/');
                            } else {
                                $cookie = setcookie("email", base64_encode($email), time() - 86400, '/');
                                $cookie = setcookie("password", base64_encode($this->input->post('password', true)), time() - 86400, '/');
                            }

                            $this->db_model->update_data_limit('students use index (id)', $this->security->xss_clean(['login_status' => 1, 'token' => 1, 'brewers_check' => $brewers_strings]), ['id' => $studentDetails[0]['id']], 1);

                            $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_logged_msg'), 'url' => base_url() . 'student/my-course'];
                        }

                    } else {
                        $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_contact_to_admin_msg')];
                    }
                } else {
                    $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_wrong_credentials_msg')];
                }
            } else {
                $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_wrong_credentials_msg')];
            }
            echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            die;
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
            die;
        }
    }

    public function register()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('name', false)) && ! empty($this->input->post('email', false)) && ! empty($this->input->post('mobile', false))) {

                $name         = trim($this->input->post('name', true));
                $email        = trim($this->input->post('email', true));
                $mobile       = $this->input->post('mobile', false);
                $state        = $this->input->post('states', false);
                $student_city = $this->input->post('student_city', false);
                $admin_id     = $this->db_model->select_data('id', 'users use index (id)', ['role' => 1], 1)[0]['id'];

                $prevRecd        = $this->db_model->select_data('id', 'students', ['email' => $email]);
                $prevRecd_mobile = $this->db_model->select_data('id', 'students', ['contact_no' => $mobile]);

                if (empty($prevRecd)) {
                    if (empty($prevRecd_mobile)) {
                        $siteData                    = [];
                        $siteData['word_for_enroll'] = $this->common->enrollWord;
                        $data_arr['admin_id']        = 1;
                        $lastrecord                  = $this->db_model->select_data('id', 'students use index (id)', ['admin_id' => $admin_id], 1, ['id', 'desc']);
                        if (! empty($lastrecord)) {
                            $last_id = $lastrecord[0]['id'];
                        } else {
                            $last_id = 0;
                        }

                        $password                   = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(1000, 5000);
                        $enrolid                    = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(10, 100);
                        $data_arr['name']           = $name;
                        $data_arr['email']          = $email;
                        $data_arr['batch_id']       = '';
                        $data_arr['login_status']   = 0;
                        $data_arr['added_by']       = 'student';
                        $data_arr['status']         = 1;
                        $data_arr['enrollment_id']  = $enrolid;
                        $data_arr['password']       = md5(trim($mobile));
                        $data_arr['admission_date'] = date('Y-m-d');
                        $data_arr['image']          = 'student_img.png';
                        $data_arr['contact_no']     = $mobile;
                        $data_arr['login_status']   = 1;
                        $data_arr['last_login_app'] = date("Y-m-d H:i:s");
                        $data_arr['app_version']    = '';
                        $data_arr['token']          = '';
                        $data_arr['multi_batch']    = json_encode([""]);
                        $data_arr['student_state']  = $state;
                        $data_arr['student_city']   = $student_city;

                        do {
                            $referralCode = $this->random_strings_fefral(8);
                        } while (! $this->hasUniqueReferralCode($referralCode));

                        $data_arr['affiliate_id'] = $referralCode;

                        $data_arr = $this->security->xss_clean($data_arr);

                        try {
                            $ins = $this->db_model->insert_data('students', $data_arr);
                            if ($ins) {
                                $brewers_strings = $this->random_strings(10);
                                $this->db_model->update_data_limit('students use index (id)', $this->security->xss_clean(['login_status' => 1, 'token' => 1, 'brewers_check' => $brewers_strings]), ['id' => $ins], 1);
                                $url = base_url() . 'login';

                                $title  = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];
                                $subj   = $title . ' - ' . $this->lang->line('ltr_credentials');
                                $em_msg = $this->lang->line('ltr_hey') . ' ' . ucwords($name) . ', ' . $this->lang->line('ltr_congratulations') . '<br/><br/>' . $this->lang->line('ltr_successfully_enrolled') . '<br/><br/>' . $this->lang->line('ltr_login_details') . '<br/><br/>' . $this->lang->line('ltr_enrolment_id') . ' : ' . $enrolid . '<br/><br/>' . $this->lang->line('ltr_password') . ' : ' . $mobile . '<br/><br/>' . $this->lang->line('ltr_url') . ' : <a href="' . $url . '">Click here to Login.</a><br/><br/>' . $this->lang->line('ltr_thnx_msg') . '';
                                $this->SendMail($email, $subj, $em_msg);

                                // $brewers_strings = $this->random_strings(10);
                                // $sess_arr = array(
                                //     'uid' => $last_id,
                                //     'name' => $data_arr['name'],
                                //     'role' => 'student',
                                //     'mobile' => $data_arr['contact_no'],
                                //     'admin_id' => 1,
                                //     'profile_img' => $data_arr['image'],
                                //     'email' => $data_arr['email'],
                                //     'batch_id' => $data_arr['batch_id'],
                                //     'enrollment_id' => $data_arr['enrollment_id'],
                                //     'brewers_check' => $brewers_strings
                                // );

                                // $this->session->set_userdata($sess_arr);

                                // if ($this->input->post('remember_me', TRUE)) {
                                //     setcookie("email", base64_encode($email), time() + 86400, '/');
                                //     setcookie("password", base64_encode($data_arr['password'], TRUE), time() + 86400, '/');
                                // } else {
                                //     setcookie("email", base64_encode($email), time() - 86400, '/');
                                //     setcookie("password", base64_encode($data_arr['password'], TRUE), time() - 86400, '/');
                                // }

                                $arr = ['status' => '1', 'msg' => $this->lang->line('ltr_registered_msg'), 'url' => base_url() . 'home/login'];

                            } else {
                                $arr = ['status' => '0', 'msg' => $this->lang->line('ltr_registration_failed_msg')];
                            }
                        } catch (Exception $e) {
                            log_message('error', 'Exception: ' . $e->getMessage());
                            $arr = ['status' => '0', 'msg' => 'An error occurred'];
                        }
                    } else {
                        $arr = ['status' => '0', 'msg' => $this->lang->line('ltr_mobile_already_msg')];
                    }
                } else {
                    $arr = ['status' => '0', 'msg' => $this->lang->line('ltr_email_already_msg')];
                }
                echo json_encode($arr, JSON_UNESCAPED_SLASHES);
            } else {
                $arr = ['status' => '0', 'msg' => $this->lang->line('ltr_invalid_input_msg')];
                echo json_encode($arr, JSON_UNESCAPED_SLASHES);
            }
        } else {
            $arr = ['status' => '0', 'msg' => $this->lang->line('ltr_not_allowed_msg')];
            echo json_encode($arr, JSON_UNESCAPED_SLASHES);
        }
    }

    public function random_strings_fefral($length_of_string)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';

        $rString = substr(str_shuffle($str_result), 0, $length_of_string);

        return $rString;
    }

    public function hasUniqueReferralCode($referralCode)
    {

        // check against database to enforce uniqueness
        $student = $this->db_model->select_data('*', 'students use index (id)', ['affiliate_id' => $referralCode], 1);
        if (! empty($student)) {
            return false;
        }
        return true;
    }

    public function change_student_status()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('id', false))) {
                $res = $this->db_model->update_data_limit('students use index (id)', $this->security->xss_clean(['login_status' => 0]), ['id' => $this->input->post('id', true)], 1);
                if ($res) {
                    echo '1';
                } else {
                    echo '0';
                }

            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    // function reset_password(){
    //     if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
    //         if(!empty($this->input->post('email',false))){
    //             $email = $this->input->post('email',TRUE);
    //             $userDetails = $this->db_model->select_data('id,name','users use index (id)',array('email'=>$email),1);
    //             $studentDetails = $this->db_model->select_data('id,name','students use index (id)',array('email'=>$email),1);
    //             // echo $this->db->last_query();
    //             // print_r($studentDetails);
    //             if(!empty($userDetails)){
    //                 $this->load->library('email');
    //                 $frommail =$this->general_settings('smtp_mail');
    //                 $frompwd =$this->general_settings('smtp_pwd');
    //                 $config = array();
    //                 $config['protocol'] = $this->general_settings('server_type');
    //                 $config['smtp_host'] = $this->general_settings('smtp_host');
    //                 $config['smtp_port'] = $this->general_settings('smtp_port');
    //                 $config['smtp_user'] = $frommail;
    //                 $config['smtp_pass'] = $frompwd;
    //                 $config['charset'] = "utf-8";
    //                 $config['mailtype'] = "html";
    //                 $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
    //                 $config['newline'] = "\r\n";

    //                 $a=str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    //                 $pwd = substr($a, 0, 5);

    //                 $subj = 'Recover your account password '.$this->common->siteTitle;
    //                 $em_msg = 'Hi '.ucwords($userDetails[0]['name']).',<br/><br/>We have received your request to reset your account password.<br/><br/>Here is your new password : '.$pwd.'<br/><br/> This is an auto-generated email. Please do not reply to this email.';

    //                 $from_email = $this->common->siteOwnerEmail;
    //                 $this->email->initialize($config);
    //                 $this->email->from($from_email, 'Admin');
    //                 $this->email->to($email);
    //                 $this->email->subject($subj);
    //                 $this->email->message($em_msg);

    //                 if($this->email->send()){
    //                     $data = array(
    //                         'password'=>md5($pwd)
    //                     );
    //                     $data = $this->security->xss_clean($data);
    //                     $this->db_model->update_data('users',$data, array('email'=>$email));

    //                     $resp = array(
    //                         'status'=>'1',
    //                         'msg'=>'We\'ve sent an email to '.$email.'.',
    //                         'url'=>base_url('login')
    //                     );
    //                 }
    //                 else{
    //                     $resp = array(
    //                         'status'=>'0',
    //                         'msg'=>$this->lang->line('ltr_something_msg')
    //                     );
    //                 }
    //             }else if(!empty($studentDetails)){

    //                 $this->load->library('email');
    //                 $frommail =$this->general_settings('smtp_mail');
    //                 $frompwd =$this->general_settings('smtp_pwd');
    //                 $config = array();
    //                 $config['protocol'] = $this->general_settings('server_type');
    //                 $config['smtp_host'] = $this->general_settings('smtp_host');
    //                 $config['smtp_port'] = $this->general_settings('smtp_port');
    //                 $config['smtp_user'] = $frommail;
    //                 $config['smtp_pass'] = $frompwd;
    //                 $config['charset'] = "utf-8";
    //                 $config['mailtype'] = "html";
    //                 $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
    //                 $config['newline'] = "\r\n";

    //                 $a=str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    //                 $pwd = substr($a, 0, 5);

    //                 $subj = 'Recover your account password '.$this->common->siteTitle;
    //                 $em_msg = 'Hi '.ucwords($studentDetails[0]['name']).',<br/><br/>We have received your request to reset your account password.<br/><br/>Here is your new password : '.$pwd.'<br/><br/> This is an auto-generated email. Please do not reply to this email.';

    //                 $from_email = $this->common->siteOwnerEmail;
    //                 $this->email->initialize($config);
    //                 $this->email->from($from_email, 'Admin');
    //                 $this->email->to($email);
    //                 $this->email->subject($subj);
    //                 $this->email->message($em_msg);
    //                 $this->email->send();
    //                 echo $this->email->print_debugger();
    //                 if($this->email->send()){
    //                     $data = array(
    //                         'password'=>md5($pwd)
    //                     );
    //                     $data = $this->security->xss_clean($data);
    //                     $this->db_model->update_data('students',$data, array('email'=>$email));

    //                     $resp = array(
    //                         'status'=>'1',
    //                         'msg'=>'We\'ve sent an email to '.$email.'.',
    //                         'url'=>base_url('login')
    //                     );
    //                 }
    //                 else{
    //                     $resp = array(
    //                         'status'=>'0',
    //                         'msg'=>$this->lang->line('ltr_something_msg')
    //                     );
    //                 }
    //             }else{
    //                 $resp = array(
    //                     'status'=>'0',
    //                     'msg'=>$this->lang->line('ltr_email_not_exists_msg')
    //                 );
    //             }
    //             echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    //         }
    //     }else{
    //         echo $this->lang->line('ltr_not_allowed_msg');
    //     }
    // }

    public function reset_password()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false))) {
                $email          = $this->input->post('email', true);
                $userDetails    = $this->db_model->select_data('id,name', 'users use index (id)', ['email' => $email], 1);
                $studentDetails = $this->db_model->select_data('id,name', 'students use index (id)', ['email' => $email], 1);
                // echo $this->db->last_query();
                // print_r($studentDetails);
                if (! empty($userDetails)) {
                    $this->load->library('email');
                    $frommail              = $this->general_settings('smtp_mail');
                    $frompwd               = $this->general_settings('smtp_pwd');
                    $config                = [];
                    $config['protocol']    = $this->general_settings('server_type');
                    $config['smtp_host']   = $this->general_settings('smtp_host');
                    $config['smtp_port']   = $this->general_settings('smtp_port');
                    $config['smtp_user']   = $frommail;
                    $config['smtp_pass']   = $frompwd;
                    $config['charset']     = "utf-8";
                    $config['mailtype']    = "html";
                    $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
                    $config['newline']     = "\r\n";

                    $a   = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                    $pwd = substr($a, 0, 5);

                    $subj   = 'Recover your account password ' . $this->common->siteTitle;
                    $em_msg = 'Hi ' . ucwords($userDetails[0]['name']) . ',<br/><br/>We have received your request to reset your account password.<br/><br/>Here is your new password : ' . $pwd . '<br/><br/> This is an auto-generated email. Please do not reply to this email.';

                    $from_email = $this->common->siteOwnerEmail;
                    $this->email->initialize($config);
                    $this->email->from($from_email, 'Admin');
                    $this->email->to($email);
                    $this->email->subject($subj);
                    $this->email->message($em_msg);

                    if ($this->email->send()) {
                        $data = [
                            'password' => md5($pwd),
                        ];
                        $data = $this->security->xss_clean($data);
                        $this->db_model->update_data('users', $data, ['email' => $email]);

                        $resp = [
                            'status' => '1',
                            'msg'    => 'We\'ve sent an email to ' . $email . '.',
                            'url'    => base_url('login'),
                        ];
                    } else {
                        $resp = [
                            'status' => '0',
                            'msg'    => $this->lang->line('ltr_something_msg'),
                        ];
                    }
                } else if (! empty($studentDetails)) {

                    $this->load->library('email');
                    $frommail              = $this->general_settings('smtp_mail');
                    $frompwd               = $this->general_settings('smtp_pwd');
                    $config                = [];
                    $config['protocol']    = $this->general_settings('server_type');
                    $config['smtp_host']   = $this->general_settings('smtp_host');
                    $config['smtp_port']   = $this->general_settings('smtp_port');
                    $config['smtp_user']   = $frommail;
                    $config['smtp_pass']   = $frompwd;
                    $config['charset']     = "utf-8";
                    $config['mailtype']    = "html";
                    $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
                    $config['newline']     = "\r\n";

                    $a   = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                    $pwd = substr($a, 0, 5);

                    $subj   = 'Recover your account password ' . $this->common->siteTitle;
                    $em_msg = 'Hi ' . ucwords($studentDetails[0]['name']) . ',<br/><br/>We have received your request to reset your account password.<br/><br/>Here is your new password : ' . $pwd . '<br/><br/> This is an auto-generated email. Please do not reply to this email.';

                    $from_email = $this->common->siteOwnerEmail;
                    $this->email->initialize($config);
                    $this->email->from($from_email, 'Admin');
                    $this->email->to($email);
                    $this->email->subject($subj);
                    $this->email->message($em_msg);
                    /*$this->email->send();
                    echo $this->email->print_debugger();*/
                    if ($this->email->send()) {
                        $data = [
                            'password' => md5($pwd),
                        ];
                        $data = $this->security->xss_clean($data);
                        $this->db_model->update_data('students', $data, ['email' => $email]);

                        $resp = [
                            'status' => '1',
                            'msg'    => 'We\'ve sent an email to ' . $email . '.',
                            'url'    => base_url('login'),
                        ];
                    } else {
                        $resp = [
                            'status' => '0',
                            'msg'    => $this->lang->line('ltr_something_msg'),
                        ];
                    }
                } else {
                    $resp = [
                        'status' => '0',
                        'msg'    => $this->lang->line('ltr_email_not_exists_msg'),
                    ];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function logout()
    {
        if ($this->session->userdata('role') == 'student') {
            $this->db_model->update_data_limit('students use index (id)', $this->security->xss_clean(['login_status' => 0]), ['id' => $this->session->userdata('uid')], 1);
        }
        if ($this->session->all_userdata()) {
            $this->session->sess_destroy();
            redirect(base_url('login'));
        }
    }

    public function site_settings()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('site_title', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));

                if (isset($_FILES['site_logo']) && ! empty($_FILES['site_logo']['name'])) {
                    $logo = $this->upload_media('single', $_FILES, './uploads/site_data/', 'site_logo');
                    if (is_array($logo)) {
                        $resp = ['status' => '2', 'msg' => $logo['msg']];
                        echo json_encode($resp, JSON_UNESCAPED_SLASHES);

                        die();
                    } else {
                        $data_arr['site_logo'] = $logo;
                    }
                }
                if (isset($_FILES['site_minilogo']) && ! empty($_FILES['site_minilogo']['name'])) {
                    $logo = $this->upload_media('single', $_FILES, './uploads/site_data/', 'site_minilogo');
                    if (is_array($logo)) {
                        $resp = ['status' => '2', 'msg' => $logo['msg']];
                        echo json_encode($resp, JSON_UNESCAPED_SLASHES);

                        die();
                    } else {
                        $data_arr['site_minilogo'] = $logo;
                    }
                }
                if (isset($_FILES['site_loader']) && ! empty($_FILES['site_loader']['name'])) {
                    $loader = $this->upload_media('single', $_FILES, './uploads/site_data/', 'site_loader');
                    if (is_array($loader)) {
                        $resp = ['status' => '2', 'msg' => $loader['msg']];
                        die();
                    } else {
                        $data_arr['site_loader'] = $loader;
                    }
                }
                if (isset($_FILES['site_favicon']) && ! empty($_FILES['site_favicon']['name'])) {
                    $favicon = $this->upload_media('single', $_FILES, './uploads/site_data/', 'site_favicon');
                    if (is_array($favicon)) {
                        $resp = ['status' => '2', 'msg' => $favicon['msg']];
                        die();
                    } else {
                        $data_arr['site_favicon'] = $favicon;
                    }
                }

                $data_arr['enrollment_word'] = ucwords($data_arr['enrollment_word']);
                $data_arr                    = $this->security->xss_clean($data_arr);
                $ins                         = $this->db_model->update_data_limit('site_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_site_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function payment_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('payment_type', false))) {
                $data_arr     = html_escape(html_purify($this->input->post(null, false)));
                $currency_sym = [
                    'AED' => 'د.إ',
                    'AFN' => '؋',
                    'ALL' => 'L',
                    'AMD' => 'AMD',
                    'ANG' => 'ƒ',
                    'AOA' => 'Kz',
                    'ARS' => '$',
                    'AUD' => '$',
                    'AWG' => 'ƒ',
                    'AZN' => 'AZN',
                    'BAM' => 'KM',
                    'BBD' => '$',
                    'BDT' => '৳ ',
                    'BGN' => 'лв.',
                    'BHD' => '.د.ب',
                    'BIF' => 'Fr',
                    'BMD' => '$',
                    'BND' => '$',
                    'BOB' => 'Bs.',
                    'BRL' => 'R$',
                    'BSD' => '$',
                    'BTC' => '฿',
                    'BTN' => 'Nu.',
                    'BWP' => 'P',
                    'BYR' => 'Br',
                    'BZD' => '$',
                    'CAD' => '$',
                    'CDF' => 'Fr',
                    'CHF' => 'CHF',
                    'CLP' => '$',
                    'CNY' => '¥',
                    'COP' => '$',
                    'CRC' => '₡',
                    'CUC' => '$',
                    'CUP' => '$',
                    'CVE' => '$',
                    'CZK' => 'Kč',
                    'DJF' => 'Fr',
                    'DKK' => 'DKK',
                    'DOP' => 'RD$',
                    'DZD' => 'د.ج',
                    'EGP' => 'EGP',
                    'ERN' => 'Nfk',
                    'ETB' => 'Br',
                    'EUR' => '€',
                    'FJD' => '$',
                    'FKP' => '£',
                    'GBP' => '£',
                    'GEL' => 'ლ',
                    'GGP' => '£',
                    'GHS' => '₵',
                    'GIP' => '£',
                    'GMD' => 'D',
                    'GNF' => 'Fr',
                    'GTQ' => 'Q',
                    'GYD' => '$',
                    'HKD' => '$',
                    'HNL' => 'L',
                    'HRK' => 'Kn',
                    'HTG' => 'G',
                    'HUF' => 'Ft',
                    'IDR' => 'Rp',
                    'ILS' => '₪',
                    'IMP' => '£',
                    'INR' => '₹',
                    'IQD' => 'ع.د',
                    'IRR' => '﷼',
                    'IRT' => 'تومان',
                    'ISK' => 'kr.',
                    'JEP' => '£',
                    'JMD' => '$',
                    'JOD' => 'د.ا',
                    'JPY' => '¥',
                    'KES' => 'KSh',
                    'KGS' => 'сом',
                    'KHR' => '៛',
                    'KMF' => 'Fr',
                    'KPW' => '₩',
                    'KRW' => '₩',
                    'KWD' => 'د.ك',
                    'KYD' => '$',
                    'KZT' => 'KZT',
                    'LAK' => '₭',
                    'LBP' => 'ل.ل',
                    'LKR' => 'රු',
                    'LRD' => '$',
                    'LSL' => 'L',
                    'LYD' => 'ل.د',
                    'MAD' => 'د.م.',
                    'MDL' => 'MDL',
                    'MGA' => 'Ar',
                    'MKD' => 'ден',
                    'MMK' => 'Ks',
                    'MNT' => '₮',
                    'MOP' => 'P',
                    'MRO' => 'UM',
                    'MUR' => '₨',
                    'MVR' => '.ރ',
                    'MWK' => 'MK',
                    'MXN' => '$',
                    'MYR' => 'RM',
                    'MZN' => 'MT',
                    'NAD' => '$',
                    'NGN' => '₦',
                    'NIO' => 'C$',
                    'NOK' => 'kr',
                    'NPR' => '₨',
                    'NZD' => '$',
                    'OMR' => 'ر.ع.',
                    'PAB' => 'B/.',
                    'PEN' => 'S/.',
                    'PGK' => 'K',
                    'PHP' => '₱',
                    'PKR' => '₨',
                    'PLN' => 'zł',
                    'PRB' => 'р.',
                    'PYG' => '₲',
                    'QAR' => 'ر.ق',
                    'RMB' => '¥',
                    'RON' => 'lei',
                    'RSD' => 'дин.',
                    'RUB' => '₽',
                    'RWF' => 'Fr',
                    'SAR' => 'ر.س',
                    'SBD' => '$',
                    'SCR' => '₨',
                    'SDG' => 'ج.س.',
                    'SEK' => 'kr',
                    'SGD' => '$',
                    'SHP' => '£',
                    'SLL' => 'Le',
                    'SOS' => 'Sh',
                    'SRD' => '$',
                    'SSP' => '£',
                    'STD' => 'Db',
                    'SYP' => 'ل.س',
                    'SZL' => 'L',
                    'THB' => '฿',
                    'TJS' => 'ЅМ',
                    'TMT' => 'm',
                    'TND' => 'د.ت',
                    'TOP' => 'T$',
                    'TRY' => '₺',
                    'TTD' => '$',
                    'TWD' => 'NT$',
                    'TZS' => 'Sh',
                    'UAH' => '₴',
                    'UGX' => 'UGX',
                    'USD' => '$',
                    'UYU' => '$',
                    'UZS' => 'UZS',
                    'VEF' => 'Bs F',
                    'VND' => '₫',
                    'VUV' => 'Vt',
                    'WST' => 'T',
                    'XAF' => 'Fr',
                    'XCD' => '$',
                    'XOF' => 'Fr',
                    'XPF' => 'Fr',
                    'YER' => '﷼',
                    'ZAR' => 'R',
                    'ZMW' => 'ZK',
                ];
                if (! empty($this->input->post('payment_type'))) {
                    $data_arrp['velue_text'] = $data_arr['payment_type'];
                    $data_arr                = $this->security->xss_clean($data_arrp);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'payment_type'], 1);
                }
                if (! empty($_POST['razorpay_key_id'])) {
                    $data_arrk['velue_text'] = trim($_POST['razorpay_key_id']);
                    $data_arrk               = $this->security->xss_clean($data_arrk);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arrk, ['key_text' => 'razorpay_key_id'], 1);
                }
                if (! empty($this->input->post('razorpay_secret_key'))) {
                    $data_arrs['velue_text'] = trim($_POST['razorpay_secret_key']);
                    $data_arr                = $this->security->xss_clean($data_arrs);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'razorpay_secret_key'], 1);
                }
                if (! empty($this->input->post('paypal_client_id'))) {
                    $data_arpr['velue_text'] = trim($_POST['paypal_client_id']);
                    $data_arr                = $this->security->xss_clean($data_arpr);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'paypal_client_id'], 1);
                }
                if (! empty($this->input->post('paypal_secret_key'))) {
                    $data_arrps['velue_text'] = trim($_POST['paypal_secret_key']);
                    $data_arr                 = $this->security->xss_clean($data_arrps);
                    $ins                      = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'paypal_secret_key'], 1);
                }

                // Stripe
                if (! empty($this->input->post('stripe_secret_key'))) {
                    $data_arpr['velue_text'] = trim($_POST['stripe_secret_key']);
                    $data_arr                = $this->security->xss_clean($data_arpr);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'stripe_secret_key'], 1);
                }
                if (! empty($this->input->post('stripe_publishable_key'))) {
                    $data_arrps['velue_text'] = trim($_POST['stripe_publishable_key']);
                    $data_arr                 = $this->security->xss_clean($data_arrps);
                    $ins                      = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'stripe_publishable_key'], 1);
                }
                // Stripe

                // UPI
                if (! empty($this->input->post('payee_upi_id'))) {
                    $data_arpr['velue_text'] = trim($_POST['payee_upi_id']);
                    $data_arr                = $this->security->xss_clean($data_arpr);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'payee_upi_id'], 1);
                }
                if (! empty($this->input->post('payee_merchant_code'))) {
                    $data_arpr['velue_text'] = trim($_POST['payee_merchant_code']);
                    $data_arr                = $this->security->xss_clean($data_arpr);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'payee_merchant_code'], 1);
                }
                // UPI

                if (! empty($this->input->post('currency_code'))) {
                    $data_arrpscc['velue_text'] = trim($_POST['currency_code']);
                    $data_arr                   = $this->security->xss_clean($data_arrpscc);
                    $this->db_model->update_data_limit('general_settings', ['velue_text' => $currency_sym[$_POST['currency_code']]], ['key_text' => 'currency_decimal_code'], 1);
                    $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'currency_code'], 1);
                }

                if (! empty($this->input->post('currency_converter_api'))) {
                    $data_arrpsc['velue_text'] = trim($_POST['currency_converter_api']);
                    $data_arr                  = $this->security->xss_clean($data_arrpsc);
                    $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'currency_converter_api'], 1);
                }
                if (! empty($this->input->post('sandbox_accounts'))) {
                    $data_arrpsc['velue_text'] = trim($_POST['sandbox_accounts']);
                    $data_arr                  = $this->security->xss_clean($data_arrpsc);
                    $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'sandbox_accounts'], 1);
                }

                if (! empty($this->input->post('phonepe_salt_key'))) {
                    $data_arpr['velue_text'] = trim($_POST['phonepe_salt_key']);
                    $data_arr                = $this->security->xss_clean($data_arpr);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'phonepe_salt_key'], 1);
                }
                if (! empty($this->input->post('phonepe_merchant_key'))) {
                    $data_arrps['velue_text'] = trim($_POST['phonepe_merchant_key']);
                    $data_arr                 = $this->security->xss_clean($data_arrps);
                    $ins                      = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'phonepe_merchant_key'], 1);
                }

                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_payment_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function refer_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('refer_type', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));
                if (! empty($this->input->post('refer_type'))) {
                    $data_arrp['velue_text'] = $data_arr['refer_type'];
                    $data_arr                = $this->security->xss_clean($data_arrp);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'refer_type'], 1);
                }
                if (! empty($_POST['refer_type_amount'])) {
                    $data_arrk['velue_text'] = trim($_POST['refer_type_amount']);
                    $data_arrk               = $this->security->xss_clean($data_arrk);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arrk, ['key_text' => 'refer_type_amount'], 1);
                }

                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function language_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('language_type', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));
                if (! empty($this->input->post('language_type'))) {
                    $data_arrp['velue_text'] = $data_arr['language_type'];
                    $data_arr                = $this->security->xss_clean($data_arrp);
                    $ins                     = $this->db_model->update_data_limit('general_settings', $data_arr, ['key_text' => 'language_name'], 1);
                }

                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_language_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }
    public function contact_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('address', false))) {
                $data_arr            = html_escape(html_purify($this->input->post(null, false)));
                $data_arr['address'] = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($data_arr['address']));
                $data_arr            = $this->security->xss_clean($data_arr);
                $ins                 = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_contact_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function facility_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('faci_heading', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));
                $data_arr = $this->security->xss_clean($data_arr);
                $ins      = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_facility_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function about_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('abt_frst_heading', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));

                if (! empty($_FILES['abt_frst_img']['name']) || ! empty($_FILES['abt_sec_img']['name']) || ! empty($_FILES['abt_thrd_img']['name'])) {
                    foreach ($_FILES as $key => $value) {
                        $image = $this->upload_media('single', $_FILES, './uploads/site_data/', $key);
                        if (is_array($image)) {
                            $resp = ['status' => '2', 'msg' => $image['msg']];
                            die();
                        } else {
                            if (! empty($image)) {
                                $data_arr[$key] = $image;
                            }
                        }
                    }
                }

                $data_arr['abt_frst_desc'] = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($data_arr['abt_frst_desc']));
                $data_arr['abt_sec_desc']  = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($data_arr['abt_sec_desc']));
                $data_arr['abt_thrd_desc'] = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($data_arr['abt_thrd_desc']));
                $data_arr                  = $this->security->xss_clean($data_arr);
                $ins                       = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_about_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function course_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('sec_crse_sub_heading', false))) {
                $data_arr                   = html_escape(html_purify($this->input->post(null, false)));
                $data_arr['frst_crse_desc'] = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($data_arr['frst_crse_desc']));
                $data_arr                   = $this->security->xss_clean($data_arr);
                $ins                        = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_course_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function counter_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('years_of_histry', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));
                $data_arr = $this->security->xss_clean($data_arr);
                $ins      = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }

    }

    public function testimonial_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('testi_heading', false))) {
                $testimonial = array_combine(html_escape(html_purify($this->input->post('testi_stud', false))), html_escape(html_purify($this->input->post('testi_desc', false))));
                $ins         = $this->db_model->update_data_limit('frontend_details', $this->security->xss_clean(['testimonial' => json_encode($testimonial), 'testi_heading' => html_escape(html_purify($this->input->post('testi_heading', false))), 'testi_subheading' => html_escape(html_purify($this->input->post('testi_subheading', false)))]), ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function teacher_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('no_of_teacher', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));
                $data_arr = $this->security->xss_clean($data_arr);
                $ins      = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function client_btn_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            $data_arr   = html_escape(html_purify($this->input->post(null, false)));
            $prevClient = $this->db_model->select_data('client_imgs', 'frontend_details', ['id' => 1], 1);

            if (isset($_FILES['client_imgs']) && ! empty($_FILES['client_imgs']['name'][0])) {
                $client_imgs = $this->upload_media('multiple', $_FILES, './uploads/site_data/', 'client_imgs');
                if (is_array($client_imgs)) {
                    $resp = ['status' => '2', 'msg' => $client_imgs['msg']];
                    die();
                } else {
                    $data_arr['client_imgs'] = $client_imgs;
                    if (! empty($prevClient[0]['client_imgs'])) {
                        $clients = json_decode($prevClient[0]['client_imgs'], true);
                        foreach ($clients as $cln) {
                            unlink(FCPATH . 'uploads/site_data/' . $cln);
                        }
                    }
                }
            }
            $data_arr = $this->security->xss_clean($data_arr);
            $ins      = $this->db_model->update_data_limit('frontend_details', $data_arr, ['id' => 1], 1);
            if ($ins) {
                $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
            } else {
                $resp = ['status' => '0'];
            }
            echo json_encode($resp, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function selection_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('selectn_heading', false))) {
                $selection = array_combine(html_escape(html_purify($this->input->post('select_stud', false))), html_escape(html_purify($this->input->post('select_desc', false))));
                $ins       = $this->db_model->update_data_limit('frontend_details', $this->security->xss_clean(['selection' => json_encode($selection), 'selectn_heading' => html_escape(html_purify($this->input->post('selectn_heading', false))), 'selectn_subheading' => html_escape(html_purify($this->input->post('selectn_subheading', false)))]), ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function slider_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('slider_heading', false))) {
                $data_arr = html_escape(html_purify($this->input->post(null, false)));

                $data_arr = $this->security->xss_clean($data_arr);
                $descs    = $data_arr['slider_desc'];
                unset($data_arr['slider_desc']);
                foreach ($descs as $desc) {
                    $data_arr['slider_desc'][] = preg_replace("/(<br\s*\/>\s*)+/", "<br /><br />", nl2br($desc));
                }

                $prevDetails = $this->db_model->select_data('slider_details', 'frontend_details', ['id' => 1], 1);

                if (isset($_FILES['slider_img']) && ! empty($_FILES['slider_img']['name'])) {
                    $slider_img = $this->upload_media('multiple', $_FILES, './uploads/site_data/', 'slider_img', json_decode(base64_decode($data_arr['prev_slides']), true));
                    if (is_array($slider_img)) {
                        $resp = ['status' => '2', 'msg' => $slider_img['msg']];
                        die();
                    } else {
                        $data_arr['slider_img'] = json_decode($slider_img, true);
                    }
                }
                unset($data_arr['prev_slides']);
                $ins = $this->db_model->update_data_limit('frontend_details', ['slider_details' => json_encode($data_arr)], ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_home_page_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function upload_media($noOfImg, $files, $path, $file, $prevslide = [])
    {

        if ($noOfImg == 'single') {
            $config['upload_path']   = $path;
            $config['allowed_types'] = 'jpeg|jpg|png|gif|SVG|svg';
            $config['max_size']      = '0';
            $filename                = '';
            $this->load->library('upload', $config);
            if (! empty($_FILES[$file]['name'])) {
                if ($this->upload->do_upload($file)) {
                    $uploadData = $this->upload->data();
                    $filename   = $uploadData['file_name'];
                    return $filename;
                } else {
                    $resp = ['status' => '2', 'msg' => $this->upload->display_errors()];
                    return $resp;
                }
            }
        } else {
            $file_names = [];
            if (isset($_FILES) && ! empty($_FILES[$file])) {
                $fileArray = $_FILES;
                $count     = count($_FILES[$file]['name']);
                unset($_FILES[$file]);

                $arr  = [];
                $resp = '';
                for ($i = 0; $i < $count; $i++) {

                    $arr['name']     = $fileArray[$file]['name'][$i];
                    $arr['type']     = $fileArray[$file]['type'][$i];
                    $arr['tmp_name'] = $fileArray[$file]['tmp_name'][$i];
                    $arr['error']    = $fileArray[$file]['error'][$i];
                    $arr['size']     = $fileArray[$file]['size'][$i];

                    $_FILES['newfile_' . $i] = $arr;

                    $config['upload_path']   = $path;
                    $config['allowed_types'] = 'jpg|jpeg|png|docx|doc|pdf';
                    $config['max_size']      = '0';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('newfile_' . $i)) {
                        $uploadData    = $this->upload->data();
                        $filename      = $uploadData['file_name'];
                        $prevslide[$i] = $filename;
                    } else {
                        $resp = ['status' => '2', 'msg' => $this->upload->display_errors()];
                    }
                }
                if (! empty($prevslide)) {
                    return json_encode($prevslide);
                } else {
                    return $resp;
                }

            }
        }

    }

    public function timezone_settings()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('timezone', false))) {
                $data_arr = $this->input->post(null, true);
                $data_arr = $this->security->xss_clean($data_arr);
                $ins      = $this->db_model->update_data_limit('site_details', $data_arr, ['id' => 1], 1);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_timezone_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function enquiry_form()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false))) {
                $data_arr         = html_escape(html_purify($this->input->post(null, false)));
                $data_arr['date'] = date('Y-m-d');
                $data_arr         = $this->security->xss_clean($data_arr);
                $ins              = $this->db_model->insert_data('enquiry', $data_arr);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_contact_send_updated_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function comment_form()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false))) {
                $data_arr['user_email'] = trim($this->input->post('email', false));
                $data_arr['admin_id']   = $this->db_model->select_data('*', 'users use index (id)', ['role' => 1], 1)[0]['id'];
                $data_arr['blog_id']    = trim($this->input->post('blogId', false));
                if (! empty($this->input->post('name', false))) {
                    $data_arr['user_name'] = trim($this->input->post('name', false));
                }
                if (! empty($this->input->post('mobile', false))) {
                    $data_arr['user_mobile'] = trim($this->input->post('mobile', false));
                }
                if (! empty($this->input->post('message', false))) {
                    $data_arr['comments'] = trim($this->input->post('message', false));
                }
                if (! empty($this->session->userdata('uid'))) {
                    $data_arr['user_id']   = trim($this->session->userdata('uid'));
                    $data_arr['user_role'] = trim($this->session->userdata('role'));
                }
                $data_arr['user_image'] = "student_img.png";
                $data_arr               = $this->security->xss_clean($data_arr);
                $ins                    = $this->db_model->insert_data('blog_comments', $data_arr);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_comments_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }
    public function comment_form_reply()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false))) {
                $data_arr['email'] = trim($this->input->post('email', false));
                //$data_arr['admin_id'] = $this->db_model->select_data('*','users use index (id)',array('role'=>1),1)[0]['id'];
                $data_arr['comment_id'] = trim($this->input->post('comment_id', false));
                if (! empty($this->input->post('name', false))) {
                    $data_arr['name'] = trim($this->input->post('name', false));
                }
                if (! empty($this->input->post('mobile', false))) {
                    $data_arr['mobile'] = trim($this->input->post('mobile', false));
                }
                if (! empty($this->input->post('message', false))) {
                    $data_arr['reply'] = trim($this->input->post('message', false));
                }
                if (! empty($this->session->userdata('uid'))) {
                    $data_arr['user_id'] = trim($this->session->userdata('uid'));
                    //$data_arr['user_role'] =trim($this->session->userdata('role'));
                }
                $data_arr['image'] = "student_img.png";
                $data_arr          = $this->security->xss_clean($data_arr);
                $ins               = $this->db_model->insert_data('blog_comments_reply', $data_arr);
                if ($ins) {
                    $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_comments_msg')];
                } else {
                    $resp = ['status' => '0'];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function enroll_check()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('email', false))) {
                $check_email   = $this->db_model->select_data('*', 'students', ['email' => trim($_POST['email'])]);
                $check_email_t = $this->db_model->select_data('*', 'users', ['email' => trim($_POST['email'])]);
                if (! empty($check_email_t)) {
                    $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_email_already_msg')];
                    echo json_encode($resp, JSON_UNESCAPED_SLASHES);

                    die();
                }

                if (! empty($check_email)) {
                    $check_batch = $this->db_model->select_data('*', 'sudent_batchs', ['student_id' => $check_email[0]['id'], 'batch_id' => $_POST['batchId']]);
                    if (! empty($check_batch)) {
                        $resp = ['status' => '0', 'msg' => $this->lang->line('ltr_email_already_msg')];
                    } else {
                        $check_batch = $this->db_model->select_data('*', 'batches', ['id' => $_POST['batchId']]);
                        if ($check_batch[0]['batch_type'] == 1) {
                            $this->student_signUp($_POST['name'], $_POST['email'], $check_email[0]['mobile'], $_POST['batchId']);
                            $resp = ['status' => '2'];
                        } else {
                            $payment_type = $this->general_settings('payment_type');

                            $currency = $this->general_settings('currency_code');
                            $url      = "";
                            $url      = base_url() . 'razorpay-now/' . $_POST['batchId'] . '?email=' . $_POST['email'] . '&mobile=' . $_POST['mobile'] . '&name=' . $_POST['name'];
                            $data     = ['name' => $_POST['name'],
                                'email'                  => $_POST['email'],
                                'mobile'                 => $_POST['mobile'],
                                'batchId'                => $_POST['batchId'],
                                'state'                  => $_POST['state'],
                                'city'                   => $_POST['city'],
                                'currency'               => $currency,
                                'amount'                 => ($check_batch[0]['batch_offer_price'] != '') ? $check_batch[0]['batch_offer_price'] : $check_batch[0]['batch_price'],
                            ];

                            $resp = ['status' => '1', 'url' => $url, 'data' => $data, 'payment_type' => $payment_type];
                        }
                    }
                } else {
                    $check_batch = $this->db_model->select_data('*', 'batches', ['id' => $_POST['batchId']]);
                    // print_r($check_batch);die;
                    if ($check_batch[0]['batch_type'] == 1) {
                        $this->student_signUp($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['batchId'], $_POST['state'], $_POST['city']);
                        $resp = ['status' => '2'];
                    } else {
                        // echo 'nitin';die;
                        $id           = $this->student_signUp($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['batchId'], $_POST['state'], $_POST['city']);
                        $payment_type = $this->general_settings('payment_type');
                        $url          = base_url() . 'buy-now/' . $_POST['batchId'] . '?email=' . $_POST['email'] . '&mobile=' . $_POST['mobile'] . '&name=' . $_POST['name'];
                        $currency     = $this->general_settings('currency_code');
                        $data         = ['name' => $_POST['name'],
                            'email'                      => $_POST['email'],
                            'mobile'                     => $_POST['mobile'],
                            'batchId'                    => $_POST['batchId'],
                            'state'                      => $_POST['state'],
                            'city'                       => $_POST['city'],
                            'currency'                   => $currency,
                            'amount'                     => ($check_batch[0]['batch_offer_price'] != '') ? $check_batch[0]['batch_offer_price'] : $check_batch[0]['batch_price']];

                        $stud_cond = ['id' => id];

                        $studentDetails  = $this->db_model->select_data('id,name,contact_no,batch_id,admin_id,enrollment_id,image,email,status,login_status', 'students use index (id)', $stud_cond, 1);
                        $brewers_strings = $this->random_strings(10);
                        $sess_arr        = [
                            'uid'           => $studentDetails[0]['id'],
                            'name'          => $studentDetails[0]['name'],
                            'role'          => 'student',
                            'mobile'        => $studentDetails[0]['contact_no'],
                            'admin_id'      => $studentDetails[0]['admin_id'],
                            'profile_img'   => $studentDetails[0]['image'],
                            'email'         => $studentDetails[0]['email'],
                            'batch_id'      => $studentDetails[0]['batch_id'],
                            'enrollment_id' => $studentDetails[0]['enrollment_id'],
                            'brewers_check' => $brewers_strings,
                        ];

                        $this->session->set_userdata($sess_arr);

                        if ($this->input->post('remember_me', true)) {
                            $cookie = setcookie("email", base64_encode($email), time() + 86400, '/');
                            $cookie = setcookie("password", base64_encode($this->input->post('password', true)), time() + 86400, '/');
                        } else {
                            $cookie = setcookie("email", base64_encode($email), time() - 86400, '/');
                            $cookie = setcookie("password", base64_encode($this->input->post('password', true)), time() - 86400, '/');
                        }

                        $resp = ['status' => '1', 'url' => $url, 'data' => $data, 'payment_type' => $payment_type];
                    }
                }
                // print_r($resp);
                //die;
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function razorPaySuccess()
    {
        print_r($_POST);
        if (! empty($_POST)) {
            $admin_id            = $this->db_model->select_data('id', 'users use index (id)', ['role' => 1], 1)[0]['id'];
            $name                = trim($_POST['name']);
            $email               = trim($_POST['email']);
            $mobile              = $_POST['mobile'];
            $state               = $_POST['state'];
            $city                = trim($_POST['city']);
            $batchId             = $_POST['product_id'];
            $totalAmount         = $_POST['totalAmount'];
            $razorpay_payment_id = $_POST['razorpay_payment_id'];
            $prevRecd            = $this->db_model->select_data('id as studentId,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token,multi_batch', 'students use index (id)', ['email' => $email], 1);

            if (empty($prevRecd)) {
                $siteData                    = [];
                $siteData['word_for_enroll'] = $this->common->enrollWord;
                $data_arr['admin_id']        = $admin_id;
                $data_arr['login_status']    = 0;
                $lastrecord                  = $this->db_model->select_data('id', 'students use index (id)', ['admin_id' => $admin_id], 1, ['id', 'desc'], '', '', '', [['students.admin_id', 0]]);

                if (! empty($lastrecord)) {
                    $last_id = $lastrecord[0]['id'];
                } else {
                    $last_id = 0;
                }

                $password = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(1000, 5000);
                $enrolid  = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(10, 100);
                if (isset($prevRecd[0]['mobile']) && ! empty($prevRecd[0]['mobile'])) {
                    $mobile = $prevRecd[0]['mobile'];
                } else {
                    $mobile = $mobile;
                }
                $data_arr['name']           = $name;
                $data_arr['email']          = $email;
                $data_arr['contact_no']     = $mobile;
                $data_arr['student_state']  = $state;
                $data_arr['student_city']   = $city;
                $data_arr['batch_id']       = $batchId;
                $data_arr['added_by']       = 'student';
                $data_arr['status']         = 1;
                $data_arr['enrollment_id']  = $enrolid;
                $data_arr['password']       = md5($password);
                $data_arr['admission_date'] = date('Y-m-d');
                $data_arr['image']          = 'student_img.png';
                $data_arr['login_status']   = 0;
                $data_arr['last_login_app'] = date("Y-m-d H:i:s");
                do {
                    $referralCode = $this->random_strings_fefral(8);
                } while (! $this->hasUniqueReferralCode($referralCode));

                $data_arr['affiliate_id'] = $referralCode;

                $data_arr = $this->security->xss_clean($data_arr);
                $ins      = $this->db_model->insert_data('students', $data_arr);
                $arr      = ['msg' => 'Payment successfully credited', 'status' => true];
                if ($ins) {
                    $batch_type = $this->db_model->select_data('*', 'batches use index (id)', ['id' => $batchId], 1);
                    if ($batch_type[0]['batch_type'] == 2) {
                        if (! empty($totalAmount)) {

                            $amount = $totalAmount;
                        }

                        $data_pay = [
                            'student_id'     => $ins,
                            'batch_id'       => $batchId,
                            'mode'           => 'Razorpay',
                            'transaction_id' => ! empty($razorpay_payment_id) ? $razorpay_payment_id : '',
                            'amount'         => ! empty($amount) ? $amount : '',
                            'admin_id'       => $_SESSION['admin_id'],
                        ];
                        $data_pay = $this->security->xss_clean($data_pay);
                        $insf     = $this->db_model->insert_data('student_payment_history', $data_pay);

                        $this->db_model->update_data_limit('students use index (id)', ['payment_status' => 1], ['id' => $ins], 1);
                    }
                    $session_arr['customerBatchName'] = ! empty($batch_type[0]['batch_name']) ? trim($batch_type[0]['batch_name']) : '';
                    $session_arr['customerprice']     = ! empty($amount) ? trim($amount) : '';
                    //batch asin
                    $data_batch = [
                        'student_id' => $ins,
                        'batch_id'   => $batchId,
                        'added_by'   => 'student',
                        'admin_id'   => $admin_id,
                    ];
                    $this->db_model->insert_data('sudent_batchs', $data_batch);
                    // send email

                    $title  = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];
                    $subj   = $title . '- ' . $this->lang->line('ltr_credentials');
                    $em_msg = $this->lang->line('ltr_hey') . ' ' . ucwords($name) . ', ' . $this->lang->line('ltr_congratulation') . ' <br/><br/>' . $this->lang->line('ltr_successfully_enrolled') . '<br/><br/>' . $this->lang->line('ltr_login_details') . '<br/><br/> ' . $this->lang->line('ltr_enrolment_id') . ' : ' . $enrolid . '<br/><br/>' . $this->lang->line('ltr_password') . ' : ' . $password . '';
                    @$this->SendMail($email, $subj, $em_msg);
                    $this->session->set_userdata($session_arr);
                }
            } else {

                $siteData                   = [];
                $data_arr['admin_id']       = $admin_id;
                $data_arr['login_status']   = 0;
                $last_id                    = $prevRecd[0]['studentId'];
                $enrolid                    = $prevRecd[0]['enrollmentId'];
                $data_arr['name']           = $name;
                $data_arr['batch_id']       = $batchId;
                $data_arr['added_by']       = 'student';
                $data_arr['status']         = 1;
                $data_arr['contact_no']     = $prevRecd[0]['mobile'];
                $data_arr['login_status']   = 0;
                $data_arr['last_login_app'] = date("Y-m-d H:i:s");

                $data_arr = $this->security->xss_clean($data_arr);
                $this->db_model->update_data_limit('students', $data_arr, ['id' => $last_id]);

                $arr = ['msg' => 'Payment successfully credited', 'status' => true];
                //check batch type
                $batch_type = $this->db_model->select_data('*', 'batches use index (id)', ['id' => $batchId], 1);

                $data[]    = $batch_type[0]['admin_id'];
                $tempArray = json_decode($prevRecd[0]['multi_batch']);
                array_push($tempArray, $batch_type[0]['admin_id']);
                $jsonData = json_encode($tempArray);
                //   print_r($jsonData);
                //   die();
                $this->db_model->update_data_limit('students', ['students.multi_batch' => $jsonData], ['id' => $prevRecd[0]['studentId']]);
                if ($batch_type[0]['batch_type'] == 2) {
                    if (! empty($totalAmount)) {

                        $amount = $totalAmount;
                    }
                    $data_pay = [
                        'student_id'     => $last_id,
                        'batch_id'       => $batchId,
                        'mode'           => 'Razorpay',
                        //  'transaction_id'=> !empty($batchId)? $batchId:'',
                        'transaction_id' => ! empty($razorpay_payment_id) ? $razorpay_payment_id : '',
                        'amount'         => ! empty($amount) ? $amount : '',
                        //  'admin_id'=>$_SESSION['admin_id'],
                        'admin_id'       => $batch_type[0]['admin_id'],
                    ];
                    $data_pay = $this->security->xss_clean($data_pay);
                    $insg     = $this->db_model->insert_data('student_payment_history', $data_pay);

                    $this->db_model->update_data_limit('students use index (id)', ['payment_status' => 1], ['id' => $last_id], 1);

                }
                $session_arr['customerBatchName'] = ! empty($batch_type[0]['batch_name']) ? trim($batch_type[0]['batch_name']) : '';
                $session_arr['customerprice']     = ! empty($amount) ? trim($amount) : '';
                //batch asin
                $data_batch = [
                    'student_id' => $last_id,
                    'batch_id'   => $batchId,
                    'added_by'   => 'student',
                    'admin_id'   => $batch_type[0]['admin_id'],
                ];
                $this->db_model->insert_data('sudent_batchs', $data_batch);
                // send email
                $title  = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];
                $subj   = $title . '- ' . $this->lang->line('ltr_thanks_msg');
                $em_msg = $this->lang->line('ltr_hey') . ' ' . ucwords($name) . ', ' . $this->lang->line('ltr_congratulations') . ' <br/><br/>' . $this->lang->line('ltr_successfully_enrolled_in') . ' ' . $batch_type[0]['batch_name'] . '<br/><br/>' . $this->lang->line('ltr_enjoy') . '<br/><br/> ' . $this->lang->line('ltr_thanks_msg') . '<br/><br/>' . $title;
                @$this->SendMail($email, $subj, $em_msg);

                // $session_arr['customerId']= !empty($last_id)? trim($last_id):'';
                // $session_arr['customerPwd']= !empty($password)? trim($password):'';
                // $session_arr['customerBatchId']= !empty($batchId)? trim($batchId):'';
                $this->session->set_userdata($session_arr);

            }
            $resp = ['status' => '1'];
            echo json_encode($resp, JSON_UNESCAPED_SLASHES);
        }

    }

    public function student_signUp($name = '', $email = '', $mobile = '', $batchId = '', $state = '', $city = '')
    {

        $admin_id = $this->db_model->select_data('id', 'users use index (id)', ['role' => 1], 1)[0]['id'];

        $prevRecd = $this->db_model->select_data('id as studentId,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token,admin_id', 'students use index (id)', ['email' => $email], 1);

        if (empty($prevRecd)) {
            $siteData                    = [];
            $siteData['word_for_enroll'] = $this->common->enrollWord;
            // $data_arr['admin_id'] = $admin_id;
            if (isset($prevRecd[0]['admin_id']) && ! empty($prevRecd[0]['admin_id'])) {
                if ($prevRecd[0]['admin_id'] == 0) {
                    $data_arr['admin_id'] = $admin_id;
                }
            }

            $data_arr['login_status'] = 0;
            $lastrecord               = $this->db_model->select_data('id', 'students use index (id)', ['admin_id' => $admin_id], 1, ['id', 'desc']);
            if (! empty($lastrecord)) {
                $last_id = $lastrecord[0]['id'];
            } else {
                $last_id = 0;
            }
            $password                   = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(1000, 5000);
            $enrolid                    = $siteData['word_for_enroll'] . $admin_id . $last_id . rand(10, 100);
            $data_arr['name']           = $name;
            $data_arr['email']          = $email;
            $data_arr['student_state']  = $state;
            $data_arr['student_city']   = $city;
            $data_arr['batch_id']       = $batchId;
            $data_arr['added_by']       = 'student';
            $data_arr['status']         = 1;
            $data_arr['enrollment_id']  = $enrolid;
            $data_arr['password']       = md5($password);
            $data_arr['admission_date'] = date('Y-m-d');
            $data_arr['image']          = 'student_img.png';
            $data_arr['contact_no']     = $mobile;
            //update app version and login status
            $data_arr['login_status']   = 0;
            $data_arr['last_login_app'] = date("Y-m-d H:i:s");
            do {
                $referralCode = $this->random_strings_fefral(8);
            } while (! $this->hasUniqueReferralCode($referralCode));

            $data_arr['affiliate_id'] = $referralCode;
            $data_arr                 = $this->security->xss_clean($data_arr);
            $ins                      = $this->db_model->insert_data('students', $data_arr);
            if ($prevRecd[0]['multi_batch'] == "") {
                $jsonData = json_encode(["$admin_id"]);
            } else {
                $data[]    = $prevRecd[0]['admin_id'];
                $tempArray = json_decode($prevRecd[0]['multi_batch']);
                array_push($tempArray, $batch_type[0]['admin_id']);
                $jsonData = json_encode($tempArray);
            }
            $this->db_model->update_data_limit('students', ['students.multi_batch' => $jsonData], ['id' => $prevRecd[0]['studentId']]);
            if ($ins) {
                //batch asin
                $data_batch = [
                    'student_id' => $ins,
                    'batch_id'   => $batchId,
                    'added_by'   => 'student',
                    'admin_id'   => $batch_type[0]['admin_id'],
                ];
                $this->db_model->insert_data('sudent_batchs', $data_batch);
                // send email
                $title  = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];
                $subj   = $title . '- ' . $this->lang->line('ltr_credentials');
                $em_msg = $this->lang->line('ltr_hey') . ' ' . ucwords($name) . ', ' . $this->lang->line('ltr_congratulation') . ' <br/><br/>' . $this->lang->line('ltr_successfully_enrolled') . '<br/><br/>' . $this->lang->line('ltr_login_details') . '<br/><br/> ' . $this->lang->line('ltr_enrolment_id') . ' : ' . $enrolid . '<br/><br/>' . $this->lang->line('ltr_password') . ' : ' . $password . '';
                $this->SendMail($email, $subj, $em_msg);

            }
        } else {

            $batch_type               = $this->db_model->select_data('*', 'batches use index (id)', ['id' => $batchId], 1);
            $siteData                 = [];
            $data_arr['login_status'] = 0;
            $last_id                  = $prevRecd[0]['studentId'];
            $enrolid                  = $prevRecd[0]['enrollmentId'];
            $password                 = $prevRecd[0]['password'];
            if ($prevRecd[0]['admin_id'] == 0) {
                $data_arr['admin_id'] = $batch_type[0]['admin_id'];
            }

            $data_arr['name']           = $name;
            $data_arr['batch_id']       = $batchId;
            $data_arr['added_by']       = 'student';
            $data_arr['status']         = 1;
            $data_arr['contact_no']     = $prevRecd[0]['mobile'];
            $data_arr['login_status']   = 0;
            $data_arr['last_login_app'] = date("Y-m-d H:i:s");

            $data_arr = $this->security->xss_clean($data_arr);
            $this->db_model->update_data_limit('students', $data_arr, ['id' => $last_id]);
            $this->db_model->update_with_increment('batches', 'no_of_student', ['id' => $batchId], 'plus', 1);
            if ($prevRecd[0]['multi_batch'] == "") {
                $jsonData = json_encode(["$admin_id"]);
            } else {
                $data[]    = $prevRecd[0]['admin_id'];
                $tempArray = json_decode($prevRecd[0]['multi_batch']);
                array_push($tempArray, $batch_type[0]['admin_id']);
                $jsonData = json_encode($tempArray);
            }
            $this->db_model->update_data_limit('students', ['students.multi_batch' => $jsonData], ['id' => $prevRecd[0]['studentId']]);

            //batch asin
            $data_batch = [
                'student_id' => $last_id,
                'batch_id'   => $batchId,
                'added_by'   => 'student',
                'admin_id'   => $batch_type[0]['admin_id'],
            ];
            $this->db_model->insert_data('sudent_batchs', $data_batch);
            // send email
            $title = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];

            $subj   = $title . '- ' . $this->lang->line('ltr_thanks_msg');
            $em_msg = $this->lang->line('ltr_hey') . ' ' . ucwords($name) . ', ' . $this->lang->line('ltr_congratulations') . ' <br/><br/>' . $this->lang->line('ltr_successfully_enrolled_in') . ' ' . $batch_type[0]['batch_name'] . '<br/><br/>' . $this->lang->line('ltr_enjoy') . '<br/><br/> ' . $this->lang->line('ltr_thanks_msg') . '<br/><br/>' . $title;
            $this->SendMail($email, $subj, $em_msg);

        }

    }

    public function load_moreGallery()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('limit', false))) {
                $limit   = [3, $this->input->post('limit', true)];
                $html    = '';
                $gallery = $this->db_model->select_data('image,title,video_url', 'gallery use index (id)', ['status' => 1, 'type' => $this->input->post('type', true)], $limit, ['id', 'desc']);

                if (! empty($gallery)) {
                    foreach ($gallery as $gal) {
                        if ($this->input->post('type', true) == 'Image') {
                            $html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="edu_porfolio_section">
                                    <img src="' . base_url('uploads/gallery/') . $gal['image'] . '" alt="">
                                    <div class="edu_overlay">
                                        <a href="' . base_url('uploads/gallery/') . $gal['image'] . '" title=""><span class="icofont-search-2"></span></a>
                                    </div>
                                </div>
                            </div>';
                        } else {
                            $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "https://www.youtube.com/embed/$1", $gal['video_url']);
                            $html .= '<div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="edu_videoGallery_section">
                                    <iframe src="' . $url . '" frameborder="0" allowfullscreen></iframe>
                                    <div class="edu_videoGalleryTitle">
                                        <h5>' . $gal['title'] . '</h5>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                }
                $resp = ['status' => '1', 'html' => $html];
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    /**** Student Section Manage Start ****/

    // function notice_table($id){
    //     if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
    //         $post = $this->input->post(NULL,TRUE);
    //         $get = $this->input->get(NULL,TRUE);
    //         if(isset($post['length']) && $post['length']>0){
    //             if(isset($post['start']) && !empty($post['start'])){
    //                 $limit = array($post['length'],$post['start']);
    //                 $count = $post['start']+1;
    //             }else{
    //                 $limit = array($post['length'],0);
    //                 $count = 1;
    //             }
    //         }else{
    //             $limit = '';
    //             $count = 1;
    //         }

    //         if($post['search']['value'] != ''){
    //             $like = array('title',$post['search']['value']);
    //             $or_like = '';
    //         }else{
    //           $like = '';
    //           $or_like = '';
    //         }

    //         $admin_id = $this->session->userdata('admin_id');
    //         $cond = "admin_id = $admin_id AND status = 1";

    //         if($this->session->userdata('role') == 'student'){
    //             if($id == 'all'){
    //                 $cond .= " AND (notice_for = 'Student' OR notice_for = 'Both')";
    //             }else{
    //                 $cond .= " AND student_id = $id";
    //             }
    //         }else{
    //             if($id == 'all'){
    //                 $cond .= " AND (notice_for = 'Teacher' OR notice_for = 'Both')";
    //             }else{
    //                 $cond .= " AND teacher_id = $id";
    //             }
    //         }
    //         //  print_r($cond);
    //         // die();
    //         $notices = $this->db_model->select_data('title,description,date','notices use index (id)',$cond,$limit,array('id','desc'),$like,'','',$or_like);

    //         if(!empty($notices)){
    //             $role = $this->session->userdata('role');
    //             if($role == '1'){
    //                 $profile = 'admin';
    //             }

    //             foreach($notices as $not){
    //                 $descriptionWord =$this->readMoreWord($not['description'], 'Description');
    //                 $dataarray[] = array(
    //                             $count,
    //                             $not['title'],
    //                             '<p class="descParaCls">'.$descriptionWord.'</p>',
    //                             date('d-m-Y',strtotime($not['date']))
    //                         );
    //                 $count++;
    //             }

    //             $recordsTotal = $this->db_model->countAll('notices use index (id)',$cond,'','',$like,'','',$or_like);

    //             $output = array(
    //                 "draw" => $post['draw'],
    //                 "recordsTotal" => $recordsTotal,
    //                 "recordsFiltered" => $recordsTotal,
    //                 "data" => $dataarray,
    //             );

    //         }else{
    //             $output = array(
    //                 "draw" => $post['draw'],
    //                 "recordsTotal" => 0,
    //                 "recordsFiltered" => 0,
    //                 "data" => array(),
    //             );
    //         }
    //         echo json_encode($output,JSON_UNESCAPED_SLASHES);
    //     }else{
    //         echo $this->lang->line('ltr_not_allowed_msg');
    //     }
    // }
    public function notice_table($id)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post();
            if (isset($post['length']) && $post['length'] > 0) {
                if (isset($post['start']) && ! empty($post['start'])) {
                    $limit = [$post['length'], $post['start']];
                    $count = $post['start'] + 1;
                } else {
                    $limit = [$post['length'], 0];
                    $count = 1;
                }
            } else {
                $limit = '';
                $count = 1;
            }

            if ($post['search']['value'] != '') {
                $like    = ['title', $post['search']['value']];
                $or_like = '';
            } else {
                $like    = '';
                $or_like = '';
            }

            if ($this->session->userdata('role') == 1) {
                $cond = ['admin_id' => $this->session->userdata('uid'), 'student_id' => $id, 'teacher_id' => 0, 'notice_for' => ''];
            } else if ($this->session->userdata('role') == 3) {
                $cond = ['admin_id' => $this->session->userdata('admin_id'), 'student_id' => $id, 'added_by' => $this->session->userdata('uid'), 'teacher_id' => 0, 'notice_for' => ''];
            }

            $notices = $this->db_model->select_data('*', 'notices use index (id)', $cond, $limit, ['id', 'desc'], $like, '', '', $or_like);

            if (! empty($notices)) {
                $role = $this->session->userdata('role');
                if ($role == '1') {
                    $profile = 'admin';
                }

                foreach ($notices as $not) {

                    $descriptionWord = $this->readMoreWord($not['description'], $this->lang->line('ltr_description'));
                    $action          = '<p class="actions_wrap"><a class="deleteData btn_delete" title="Delete" data-id="' . $not['id'] . '" data-table="notices"><i class="fa fa-trash"></i></a></p>';

                    if ($not['status'] == 1) {
                        $statusDrop = '<div class="admin_tbl_status_wrap"><a class="tbl_status_btn light_sky_bg changeStatusButton" data-id="' . $not['id'] . '" data-table ="notices" data-status ="0" href="javascript:;">' . $this->lang->line('ltr_active') . '</a></div>';
                    } else {
                        $statusDrop = '<div class="admin_tbl_status_wrap">
                    <a class="tbl_status_btn light_red_bg changeStatusButton" data-id="' . $not['id'] . '" data-table ="notices" data-status ="1" href="javascript:;">' . $this->lang->line('ltr_inactive') . '</a></div>';
                    }

                    $added_by    = $this->db_model->select_data('name', 'users use index (id)', ['id' => $not['added_by']], 1);
                    $dataarray[] = [
                        $count,
                        $not['title'],
                        '<p class="descParaCls">' . $descriptionWord . '</p>',
                        date('d-m-Y', strtotime($not['date'])),
                        (! empty($added_by) ? $added_by[0]['name'] : ''),
                        $statusDrop,
                        $action,
                    ];
                    $count++;
                }

                $recordsTotal = $this->db_model->countAll('notices use index (id)', $cond, '', '', $like, '', '', $or_like);

                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => $dataarray,
                ];

            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }
            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }
    public function notification_table($id)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);
            $get  = $this->input->get(null, true);
            if (isset($post['length']) && $post['length'] > 0) {
                if (isset($post['start']) && ! empty($post['start'])) {
                    $limit = [$post['length'], $post['start']];
                    $count = $post['start'] + 1;
                } else {
                    $limit = [$post['length'], 0];
                    $count = 1;
                }
            } else {
                $limit = '';
                $count = 1;
            }

            if ($post['search']['value'] != '') {
                $like    = ['msg', $post['search']['value']];
                $or_like = '';
            } else {
                $like    = '';
                $or_like = '';
            }
            $admin_id = $this->session->userdata('admin_id');

            $notify = $this->db_model->select_data('notification_type,msg,time,url', 'notifications use index (id)', ['student_id' => $id], $limit, ['id', 'desc'], $like, '', '', $or_like);
            if (! empty($notify)) {
                $role = $this->session->userdata('role');
                if ($role == '1') {
                    $profile = 'admin';
                }

                foreach ($notify as $not) {
                    $sec     = strtotime($not['time']);
                    $newdate = date("d-m-Y H:i", $sec);
                    $newDate = $newdate . ":00";

                    $dataarray[] = [
                        $count,
                        $not['notification_type'],
                        $not['msg'],
                        $newDate,
                        '<p class="actions_wrap"><a href="' . base_url($not['url']) . '" target="_blank" class="btn_view"><i class="fa fa-eye"></i></a>',

                    ];
                    $count++;
                }

                $recordsTotal = $this->db_model->countAll('notifications use index (id)', ['student_id' => $id], '', $like, '', '', $or_like);

                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => $dataarray,
                ];

            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }
            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function fetch_homework()
    {
        // Get the date from POST data
        $date     = $this->input->post('date');
        $batch_id = $this->session->userdata('batch_id');

        // Check if the date is provided
        if ($date) {
            // Perform the query directly
            $this->db->select('homeworks.description, users.name AS teacher_name, subjects.subject_name');
            $this->db->from('homeworks');
            $this->db->join('users', 'users.id = homeworks.teacher_id', 'left');
            $this->db->join('subjects', 'subjects.id = homeworks.subject_id', 'left');
            $this->db->where('homeworks.batch_id', $batch_id);

            $this->db->where('homeworks.date', $date);

            $query = $this->db->get();

            // Fetch results as an associative array
            $homeworks = $query->result_array();

            // Output the results as JSON
            echo json_encode($homeworks);
        } else {
            // If no date is provided, return an empty array
            echo json_encode([]);
        }
    }

    public function extraclass_table()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);
            $get  = $this->input->get(null, true);
            // $like= array('batch_id','"'.$this->session->userdata('batch_id').'"');
            if (isset($post['length']) && $post['length'] > 0) {
                if (isset($post['start']) && ! empty($post['start'])) {
                    $limit = [$post['length'], $post['start']];
                    $count = $post['start'] + 1;
                } else {
                    $limit = [$post['length'], 0];
                    $count = 1;
                }
            } else {
                $limit = '';
                $count = 1;
            }

            if ($post['search']['value'] != '') {
                $like = ['extra_classes.description', $post['search']['value']];
            }

            //  print_r($_SESSION);
            //  die();
            $cond = ['extra_classes.admin_id' => $this->session->userdata('admin_id')];

            if (isset($get['date'])) {
                if ($get['date'] != '') {
                    $cond = ['extra_classes.admin_id' => $this->session->userdata('admin_id'), 'extra_classes.date' => date('Y-m-d', strtotime($get['date']))];
                }
            }

            $classes = $this->db_model->select_data('extra_classes.*,users.name', 'extra_classes use index (id)', $cond, $limit, ['id', 'desc'], $like, ['users', 'users.id = extra_classes.teacher_id'], '');

            if (! empty($classes)) {

                foreach ($classes as $cls) {

                    $descriptionWord = $this->readMoreWord($cls['description'], 'Description');
                    $dataarray[]     = [
                        $count,
                        date('d-m-Y', strtotime($cls['date'])),
                        date('h:i A', strtotime($cls['start_time'])) . ' - ' . date('h:i A', strtotime($cls['end_time'])),
                        '<p class="descParaCls">' . $descriptionWord . '</p>',
                        $cls['name'],
                    ];

                    $count++;
                }

                $recordsTotal = $this->db_model->countAll('extra_classes use index (id)', $cond, '', '', $like, '', '');

                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => $dataarray,
                ];

            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }
            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function homewrok_table()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);
            $get  = $this->input->get(null, true);
            if (isset($post['length']) && $post['length'] > 0) {
                if (isset($post['start']) && ! empty($post['start'])) {
                    $limit = [$post['length'], $post['start']];
                    $count = $post['start'] + 1;
                } else {
                    $limit = [$post['length'], 0];
                    $count = 1;
                }
            } else {
                $limit = '';
                $count = 1;
            }

            if ($post['search']['value'] != '') {
                $like = ['homeworks.description', $post['search']['value']];
            } else {
                $like = '';
            }

            $cond = ['homeworks.admin_id' => $this->session->userdata('admin_id'), 'homeworks.date >= ' => date('Y-m-d'), 'homeworks.batch_id' => $this->session->userdata('batch_id')];
            if (isset($get['date'])) {
                if ($get['date'] != '') {
                    $cond = ['homeworks.admin_id' => $this->session->userdata('admin_id'), 'homeworks.date' => date('Y-m-d', strtotime($get['date'])), 'homeworks.batch_id' => $this->session->userdata('batch_id')];
                }
            }

            $homewrk = $this->db_model->select_data('homeworks.*,users.name,subjects.subject_name', 'homeworks use index (id)', $cond, $limit, ['id', 'desc'], $like, ['multiple', [['users', 'users.id = homeworks.teacher_id'], ['subjects', 'subjects.id = homeworks.subject_id']]], '');

            if (! empty($homewrk)) {

                foreach ($homewrk as $hw) {
                    $descriptionWord = $this->readMoreWord($hw['description'], 'Description');
                    $dataarray[]     = [
                        $count,
                        date('d-m-Y', strtotime($hw['date'])),
                        $hw['subject_name'],
                        '<p class="descParaCls">' . $descriptionWord . '</p>',
                        $hw['name'],
                    ];

                    $count++;
                }

                $recordsTotal = $this->db_model->countAll('homeworks use index (id)', $cond, '', '', $like, '', '');

                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => $dataarray,
                ];

            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }
            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function paper_list()
    {
        $this->load->database();

        // Retrieve and sanitize input parameters
        $subjectId = $this->input->post('subject_id');
        $chapterId = $this->input->post('chapter_id');
        $type      = $this->input->post('type');

        // Validate inputs
        if (empty($subjectId) || empty($chapterId) || empty($type)) {
            // Return error response if parameters are missing
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Missing parameters']));
            return;
        }

        try {
            // Query the database
            $this->db->select('id, total_question, time_duration, name');
            $this->db->from('exams');
            $this->db->where('subject_id', $subjectId);
            $this->db->where('chapter_id', $chapterId);
            $this->db->where('type', $type);
            $query = $this->db->get();

            $papers = $query->result_array();

            // Check if papers are found
            if (empty($papers)) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => false, 'message' => 'No papers found']));
                return;
            }

            // Return successful response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'papers' => $papers]));

        } catch (Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error fetching papers: ' . $e->getMessage());

            // Return error response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'An error occurred while fetching papers']));
        }
    }

    public function fetch_topics()
    {
        // Get the subject from the AJAX request
        $subject = $this->input->post('subject');

        // Retrieve batch_id from session
        $batch_id = $this->session->userdata('batch_id');

        $this->db->select('DISTINCT(topic)');
        $this->db->from('video_lectures');
        $this->db->where('subject', $subject);
        $this->db->where('batch', $batch_id);
        $this->db->order_by("
            CASE 
                WHEN topic REGEXP '^[a-zA-Z][0-9]+' THEN 0 
                ELSE 1 
            END
        ", '', FALSE);

        $this->db->order_by('CAST(SUBSTRING(topic, 2) AS UNSIGNED)', 'ASC', FALSE);
        $this->db->order_by('topic', 'ASC');
        $query = $this->db->get();

        $topics = $query->result_array();

        // Set content type to JSON
        $this->output->set_content_type('application/json');

        // Return topics as JSON
        echo json_encode($topics);
    }

    public function fetch_booktitles()
    {
        // Get the subject name and batch ID from POST data and session
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        // Convert batch_id to string format for querying
        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id); // Convert array to comma-separated string
        }

        // Fetch the titles from book_pdf based on the subject and batch_id
        $this->db->select('book_pdf.id, book_pdf.title as chapter_name');
        $this->db->from('book_pdf');
        $this->db->join('subjects', 'book_pdf.subject = subjects.id');
        $this->db->where('subjects.subject_name', $subject_name);

        // Use a SQL function to handle JSON array
        $this->db->where('FIND_IN_SET(' . $this->db->escape($batch_id) . ', REPLACE(REPLACE(REPLACE(REPLACE(book_pdf.batch, \'[\', \'\'), \']\', \'\'), \'\"\', \'\'), \',\', \',\')) > 0');

        $query = $this->db->get();

        // Fetch results
        $data['chapters'] = $query->result_array();

        // Return the results as JSON
        echo json_encode($data);
    }

    public function fetch_oldpapertitles()
    {
        // Get the subject name and batch ID from POST data and session
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        // Convert batch_id to string format for querying
        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id); // Convert array to comma-separated string
        }

        // Fetch the titles from book_pdf based on the subject and batch_id
        $this->db->select('old_paper_pdf.id, old_paper_pdf.title as chapter_name');
        $this->db->from('old_paper_pdf');
        $this->db->join('subjects', 'old_paper_pdf.subject = subjects.id');
        $this->db->where('subjects.subject_name', $subject_name);

        // Use a SQL function to handle JSON array
        $this->db->where('FIND_IN_SET(' . $this->db->escape($batch_id) . ', REPLACE(REPLACE(REPLACE(REPLACE(old_paper_pdf.batch, \'[\', \'\'), \']\', \'\'), \'\"\', \'\'), \',\', \',\')) > 0');

        $query = $this->db->get();

        // Fetch results
        $data['chapters'] = $query->result_array();

        // Return the results as JSON
        echo json_encode($data);
    }

    public function fetch_noteschapter()
    {
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id);
        }

        // Fetch notes based on the subject and batch_id
        $this->db->select('chapters.chapter_name,chapters.id, notes_pdf.topic');
        $this->db->from('notes_pdf');
        $this->db->join('chapters', 'notes_pdf.topic = chapters.id');
        $this->db->join('subjects', 'notes_pdf.subject = subjects.id');
        $this->db->where('subjects.subject_name', $subject_name);

        // Handle batch_id if stored as JSON array
        $this->db->where('FIND_IN_SET(' . $this->db->escape($batch_id) . ', REPLACE(REPLACE(REPLACE(REPLACE(notes_pdf.batch, \'[\', \'\'), \']\', \'\'), \'\"\', \'\'), \',\', \',\')) > 0');

        $query  = $this->db->get();
        $result = $query->result_array();

        // Remove duplicate topics
        $unique_topics = [];
        foreach ($result as $row) {
            $unique_topics[$row['topic']] = $row;
        }
        $data['chapters'] = array_values($unique_topics);

        // Return the results as JSON
        echo json_encode($data);
    }

// Example Controller Method for Fetching Titles
    public function fetch_notetitles()
    {
        $chapter_name = $this->input->post('chapter_name');
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id);
        }

        // Fetch subject ID based on subject name
        $this->db->select('id');
        $this->db->from('subjects');
        $this->db->where('subject_name', $subject_name);
        $subject_query = $this->db->get();
        $subject_id    = $subject_query->row()->id;

        // Fetch chapter ID based on chapter name and subject ID
        $this->db->select('id');
        $this->db->from('chapters');
        $this->db->where('chapter_name', $chapter_name);
        $this->db->where('subject_id', $subject_id); // Ensure that chapter belongs to the correct subject
        $chapter_query = $this->db->get();
        $chapter_id    = $chapter_query->row()->id;

        // Fetch titles based on chapter ID and subject ID
        $this->db->select('title', 'id');
        $this->db->from('notes_pdf');
        $this->db->where('topic', $chapter_id);
        $this->db->where('subject', $subject_id);

        $this->db->where('FIND_IN_SET(' . $this->db->escape($batch_id) . ', REPLACE(REPLACE(REPLACE(REPLACE(notes_pdf.batch, \'[\', \'\'), \']\', \'\'), \'\"\', \'\'), \',\', \',\')) > 0');

        $query          = $this->db->get();
        $data['titles'] = $query->result_array();

        // Return the results as JSON
        echo json_encode($data);
    }

    public function fetch_notepdf()
    {
        $title        = $this->input->post('title');
        $chapter_name = $this->input->post('chapter_name');
        $subject_name = $this->input->post('subject_name');

        // Fetch subject ID based on subject name
        $this->db->select('id');
        $this->db->from('subjects');
        $this->db->where('subject_name', $subject_name);
        $subject_query = $this->db->get();
        $subject_id    = $subject_query->row()->id;

        // Fetch chapter ID based on chapter name and subject ID
        $this->db->select('id');
        $this->db->from('chapters');
        $this->db->where('chapter_name', $chapter_name);
        $this->db->where('subject_id', $subject_id); // Ensure that chapter belongs to the correct subject
        $chapter_query = $this->db->get();
        $chapter_id    = $chapter_query->row()->id;

        // Fetch PDF based on title, chapter ID, and subject ID
        $this->db->select('file_name');
        $this->db->from('notes_pdf');
        $this->db->where('title', $title);
        $this->db->where('topic', $chapter_id);
        $this->db->where('subject', $subject_id);

        $query             = $this->db->get();
        $data['file_name'] = $query->row()->file_name ?? null;

        // Return the results as JSON
        echo json_encode($data);
    }

    public function fetch_pdf()
    {
        $chapter_name = $this->input->post('chapter_name');
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        // Convert batch_id to string format for querying
        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id); // Convert array to comma-separated string
        }

        // Query to get the file_name based on chapter_name, subject_name, and batch_id
        $this->db->select('book_pdf.file_name');
        $this->db->from('book_pdf');
        $this->db->join('subjects', 'book_pdf.subject = subjects.id');
        $this->db->where('subjects.subject_name', $subject_name);
        $this->db->where('book_pdf.title', $chapter_name);

        // Use a SQL function to handle JSON array

        $query = $this->db->get();

        $file = $query->row();

        if ($file) {
            echo json_encode(['file_name' => $file->file_name]);
        } else {
            echo json_encode(['file_name' => null]);
        }
    }

    public function fetch_oldpaperpdf()
    {
        $chapter_name = $this->input->post('chapter_name');
        $subject_name = $this->input->post('subject_name');
        $batch_id     = $this->session->userdata('batch_id');

        // Convert batch_id to string format for querying
        if (is_array($batch_id)) {
            $batch_id = implode(',', $batch_id); // Convert array to comma-separated string
        }

        // Query to get the file_name based on chapter_name, subject_name, and batch_id
        $this->db->select('old_paper_pdf.file_name');
        $this->db->from('old_paper_pdf');
        $this->db->join('subjects', 'old_paper_pdf.subject = subjects.id');
        $this->db->where('subjects.subject_name', $subject_name);
        $this->db->where('old_paper_pdf.title', $chapter_name);

        $this->db->where('FIND_IN_SET(' . $this->db->escape($batch_id) . ', REPLACE(REPLACE(REPLACE(REPLACE(old_paper_pdf.batch, \'[\', \'\'), \']\', \'\'), \'\"\', \'\'), \',\', \',\')) > 0');

        // Use a SQL function to handle JSON array

        $query = $this->db->get();

        $file = $query->row();

        if ($file) {
            echo json_encode(['file_name' => $file->file_name]);
        } else {
            echo json_encode(['file_name' => null]);
        }
    }

    public function fetch_titles()
    {
        $subject = $this->input->post('subject');
        $topic   = $this->input->post('topic');
        $batch_id = $this->session->userdata('batch_id');

        $this->db->select('title, url, video_type, description, id, thumbnail, page_order');
        $this->db->from('video_lectures');
        $this->db->where('subject', $subject);
        $this->db->where('topic', $topic);
        $this->db->where('batch', $batch_id);

        // ✅ page_order logic
       $this->db->order_by('page_order', 'ASC');

        // ✅ FIXED sorting
        $this->db->order_by('CAST(title AS UNSIGNED) = 0', 'ASC', false);
        $this->db->order_by('CAST(title AS UNSIGNED)', 'ASC', false);
        $this->db->order_by('title', 'ASC');

        $query = $this->db->get();

        echo json_encode($query->result_array());
    }

    public function get_paper_details()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('id', false))) {
                $timezoneDB = $this->db_model->select_data('timezone', 'site_details', ['id' => 1]);

                if (isset($timezoneDB[0]['timezone']) && ! empty($timezoneDB[0]['timezone'])) {
                    date_default_timezone_set($timezoneDB[0]['timezone']);
                }

                $paperDetails = $this->db_model->select_data('*', 'exams use index (id)', ['id' => $this->input->post('id', true)], 1);
                if (! empty($paperDetails)) {
                    if ($this->input->post('paper_type', true) == 'practice') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain       = '<p style="margin-bottom:0px!important; font-size:14px;><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime        = $paperDetails[0]['time_duration'];
                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                    } elseif ($this->input->post('paper_type', true) == 'descriptive') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain       = '<p style="margin-bottom:0px!important; font-size:14px;><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime        = $paperDetails[0]['time_duration'];
                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                    } else {

                        $current_time = date('Y-m-d H:i:s');
                        $start_time   = $paperDetails[0]['mock_sheduled_date'] . ' ' . $paperDetails[0]['mock_sheduled_time'];
                        $end_time     = date('Y-m-d H:i:s', strtotime($start_time . ' +' . $paperDetails[0]['time_duration'] . ' minutes'));

                        if ($current_time < $end_time) {
                            $time_diff      = strtotime($end_time) - time();
                            $remaining_time = ($time_diff / 60);
                        } else {
                            $remaining_time = '0';
                        }
                        $totalTime        = $remaining_time;
                        $timeRemain       = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                        $instructions     = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>';
                    }

                    $html = '
                              <div class="container-fluid">
                                  <div class="row">

                                <div class="col-lg-9">
                                    <i class="fa-solid fa-arrow-left back_btn"></i>
                                      <div class="main-section" style="margin-top:20px;">
                                        <div class="question-name">
                                           <p style="margin-bottom:0px; font-size:14px;">' . $this->lang->line('ltr_paper') . ' : </span>' . $paperDetails[0]['name'] . '   --  ' . $this->lang->line('ltr_total_questions') . ' : </span><span class="remainingQuest">' . $paperDetails[0]['total_question'] . '</span>/' . $paperDetails[0]['total_question'] . '</p>
                                        </div>
                                        <div class="menu">
                                          <div class="timer">' . $timeRemain . '</div>
                                          <div class="timer">' . $negative_marking . '</div>
                                          <div class="report">
                                            <a href="#"><i class="fa-solid fa-exclamation"></i></a>
                                          </div>
                                        </div>
                                      </div>

                        <div class="edu_main_wrapper question_paper_wrapper">
                            <div class="question_paper_inner">

                                <div class="question_paper_body">
                                    <div class="edu_question_section">
                                        <ol style="list-style:none;">';

                    $questions    = json_decode($paperDetails[0]['question_ids'], true);
                    $question_id  = implode(',', $questions);
                    $questionData = $this->db_model->select_data('id,question,options,answer,question_type,word_limit,total_marks', 'questions use index (id)', "id in ($question_id)", '', ['id', 'desc']);
                    if ($paperDetails[0]['type'] == 3) {

                        if (! empty($questions)) {
                            $i = 1;

                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }

                            foreach ($questionData as $ques) {

                                $html .= '<div class="main-question  x' . $ques['id'] . 'x ' . $ques['id'] . 'aA">
                                                    <li>
                                                        <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                            <div class="edu_single_question">
                                                                <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                                <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                            </div>
                                                            <div class="edu_question_options">';

                                /*$options = json_decode($ques['options'], true);
                                                    $j = 'A';
                                                    $k = 1;*/

                                /*foreach ($options as $op) {
                                                        $html .= '<li><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad">&nbsp;' . $op . '</label></li>';
                                                        $j++;
                                                        $k++;
                                                    }*/

                                if (isset($ques["word_limit"]) && $ques["word_limit"] > 0) {
                                    $wordLimit = '<span style="color:red; padding-left:6px;">Word Limit is: ' . $ques["word_limit"] . '</span>';
                                    $maxlength = 'maxlength="' . $ques["word_limit"] . '"';
                                } else {
                                    $maxlength = 'maxlength="10000000000000000000000000000"';
                                }

                                $html .= '</div>' . $wordLimit . '
                                                                <div class="edu_descriptive_answer">

                                                                    <label for="descriptive_' . $i . '"></label>
                                                                    <textarea id="descriptive_' . $i . '" name="question_answer[' . $ques['id'] . ']" rows="4" cols="100"  ' . $maxlength . '></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </li>';
                                $i++;
                            }
                        }

                        $html .= '</ol>
                                    </div>
                                </div>

         <div class="edu_btn_wrapper">
                    <form method="post">
                        <input type="hidden" name="total_qst" id="total_qst" value="' . count($questionData) . '">
                        <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                        <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                        <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                        <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                        <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                        <input type="hidden" name="submit_time" id="submit_time" value="">
                        <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">
                        <button style="" type="button" style="position: fixed; bottom: 0;  box-shadow: 0 2px 4px rgba(0,0,0,0.1);" class="edu_admin_btn submitPopupShow xxxxxx">' . $this->lang->line('ltr_submit') . '</button>
                    </form>
                </div>
                                ';

                    } else {
                        if (! empty($questions)) {
                            $i = 1;
                            $n = 0;
                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }

                            foreach ($questionData as $ques) {

                                $html .= '<div class="main-question  x' . $ques['id'] . 'x ' . $ques['id'] . 'aA">
                                                <li>
                                                    <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                        <div class="edu_single_question">
                                                            <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                            <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                        </div>
                                                        <div class="edu_question_options">
                                                            <ol>';
                                $options = json_decode($ques['options'], true);
                                $j       = 'A';
                                $k       = 1;
                                foreach ($options as $op) {
                                    $html .= '<li class="col-12"><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad" data-question-id="' . $i . '">&nbsp;' . $op . '</label></li>';
                                    $j++;
                                    $k++;
                                }
                                $html .= '</ol>
                                                        </div>
                                                    </div>
                                                </li></div>';
                                $i++;
                                $n++;

                            }

                        }

                        $html .= '</ol>
                                    </div>
                                </div>
                              ';
                    }
                    '</div>
                        </div>
                        <!------- Question Papre End -------->';
                    if (isset($end_time) && (date('Y-m-d H:i:s') >= $end_time)) {
                        $html = '<div class="sectionHolder mockPaperTimerWrapper mb_30 text-center">
                                <div class="edu_main_wrapper">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4 class="edu_sub_title nomarginbtm">' . $this->lang->line('ltr_time_over') . '</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                    $html .= '</div>
            </div>
            </div>


        <div class="col-lg-3" style="padding-right: 0px;">
        <i class="fa-solid fa-arrow-right next_btn" data-id="' . $ques['id'] . '"></i>
     <button type="button" class="edu_admin_btn1 submitPopupShow" id="submitButton" style="display:none;top: 50%;right: 45%;box-shadow: none;text-transform: uppercase;position: relative;outline: none;    color: #ffffff;
    font-weight: 600;
    border-radius: 6px;
    border: none;    height: 47px;
    width: 135px;    background-color: #006eff;
">' . $this->lang->line('ltr_submit') . '</button>
        <div class="sidebar" id="sidebar" style="height: 1128px; background-color: color(srgb 0.9393 0.9494 0.9837);">

          <div class="row" style="margin-left: 0px; margin-right: 0px;">

            <div class="header">
              <div class="profile d-flex">

                <div class="username"></div>
              </div>
              <div class="status">
                <div class="d-flex col-lg-12">
                  <div class="status-item col-lg-6">
                    <span class="greenx grn">0</span>
                    Attempted
                  </div>
                  <div class="status-item col-lg-6">
                    <span class="yellow yel">0</span>
                    Marked
                  </div>
                </div>
                <div class="d-flex col-lg-12">
                  <div class="status-item col-lg-6">
                    <span class="white">4</span>
                    Not Visited
                  </div>
                  <div class="status-item col-lg-6">
                    <span class="red">1</span>
                    Not Answered
                  </div>
                </div>

                 <div class="profile d-flex">

                <div class="username"></div>
              </div>
              </div>
            </div>
            <div class="section-title" style="padding-top: 10px; padding-bottom: 10px;">
              Warning :- Don`t Change this window, Otherwise Examination will restart
            </div>


              <div style=" width: 100%;">
                  <ul class="row question-grid" id="question-filters" style="padding-right: 0px; padding-left: 7px;">';
                    $jk  = 0;
                    $ids = "";
                    foreach ($questionData as $ques) {
                        $jk++;
                        if ($jk == 1) {
                            $ids = $ques['id'];
                            $html .= '<input type="hidden" id="first_que_id" value="' . $ques['id'] . '-' . $jk . '">
                            <li class="question-number selected redd" onclick="filterSelection(' . $ques['id'] . ',' . $jk . ')" data-filter=".' . $ques['id'] . 'aA">' . $jk . '</li>';
                        } else {
                            $html .= '<li class="question-number" onclick="filterSelection(' . $ques['id'] . ',' . $jk . ')" data-filter=".' . $ques['id'] . 'aA">' . $jk . '</li>';
                        }
                    }

                    $html .= '</ul>

                                        <div class="question_paper_footer" style="position: fixed; bottom: 10px;  box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <div class="edu_btn_wrapper">
                                                <form method="post">
                                                    <input type="hidden" name="total_qst" id="total_qst" value="' . count($questionData) . '">
                                                    <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                                                    <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                                                    <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                                                    <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                                                    <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                                                    <input type="hidden" name="submit_time" id="submit_time" value="">
                                                    <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">
                                                    <button style="" type="button"  class="edu_admin_btn submitPopupShow xxxxxx">' . $this->lang->line('ltr_submit') . '</button>
                                                </form>
                                            </div>
                                        </div>


              </div>
            </div>
          </div>

          <div class="toggle-btn" onclick="toggleSidebar()">
            <div class="toggle-icon"></div>
          </div>

        </div>
          </div>
        </div>
         <script>


        function toggleSidebar(){

            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("show");


        }

      filterSelection(' . $ids . ',1);





      function filterSelection(c,id) {
        var x, i;
        x = document.getElementsByClassName("main-question");
        for (i = 0; i < x.length; i++) {
            w3RemoveClass(x[i], "show");
            if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
        }

        var xx = document.getElementById("total_qst").value;
        var xyx = document.getElementsByClassName("xxxxxx")[0];





         var selectedLis = document.querySelectorAll("#question-filters li.selected.yellow");
            selectedLis.forEach(function(li) {
            li.classList.remove("redd");
                li.classList.add("greenx");
            li.classList.remove("redd");
                 li.classList.remove("yellow");
                  $("li.greenx").css("pointer-events", "");
                 updateCounts();

            });

    }

   function w3AddClass(element, name) {
        var arr1 = element.className.split(" ");
        var arr2 = name.split(" ");
        for (var i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {
                element.className += " " + arr2[i];
            }
        }
    }

    function w3RemoveClass(element, name) {
        var arr1 = element.className.split(" ");
        var arr2 = name.split(" ");
        for (var i = 0; i < arr2.length; i++) {
            while (arr1.indexOf(arr2[i]) > -1) {
                arr1.splice(arr1.indexOf(arr2[i]), 1);
            }
        }
        element.className = arr1.join(" ");
    }

    // Add active class to the current button (highlight it)
      var btnContainer = document.getElementById("question-filters");
    var btns = btnContainer.getElementsByClassName("question-number");
     for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("selected");
            var selectedLi = document.querySelector("#question-filters li.selected");

            // Handle the selected classes
            if (selectedLi && selectedLi.classList.contains("yellow")) {
                if (current[0]) current[0].classList.remove("selected");
                this.classList.add("selected");
                updateCounts();
            } else if (selectedLi && selectedLi.classList.contains("greenx")) {
                $("li.greenx").removeClass("redd");
                this.classList.add("selected");
                updateCounts();
            } else {
                this.classList.add("selected");
                this.classList.add("redd");
                updateCounts();
            }


            var questionIndex = parseInt(this.innerText);
            console.log(questionIndex);
           console.log(btns.length);


            if (questionIndex === btns.length) {
                var submitButton = document.getElementById("submitButton");
                if (submitButton) {
                    submitButton.style.display = "block";
                }
            } else {
                var submitButton = document.getElementById("submitButton");
                if (submitButton) {
                    submitButton.style.display = "none";
                }
            }
        });
    }
    function updateCounts(){
        var selectedCount = $(".question-number.redd").length;
        var yellowCount = $(".question-number.yellow").length;
        var greenCount = $(".question-number.greenx").length;
         var whitecount = $("ul#question-filters li.question-number:not(.redd, .selected, .yellow, .greenx)").length;

        $(".red").text(selectedCount);
        $(".yel").text(yellowCount);
        $(".grn").text(greenCount);
        $(".white").text(whitecount);
    }

 $(".next_btn").click(function(){
             var $selected = $("ul#question-filters .question-number.selected").last();

    // Find the next <li> element after the last selected one
    var $next = $selected.next(".question-number");

            if ($next.length) {
                // $selected.removeClass("selected");
                 $next.addClass("selected").trigger("click");

            } else {

            }
        });


        $(".back_btn").click(function(){
       var $selected = $("ul#question-filters .question-number.selected");

    // Find the previous <li> element before the last selected one
    var $prev = $selected.prev(".question-number");

    if ($prev.length) {

        //$selected.removeClass("selected");


        $prev.addClass("selected").trigger("click");
    } else {

        $selected.addClass("selected").trigger("click");
    }
});



    $(".questionOptionRad").on("click", function() {
        var questionId = $(this).data("question-id");
        var liElements = $("#question-filters li");

        liElements.each(function() {
            var li = $(this);
            if (li.text().trim() == questionId) {
                li.removeClass("redd");
                li.addClass("yellow");
                $("li.yellow").css("pointer-events", "none");

                updateCounts();

            }
        });

    });





    </script>';

                    $resp = ['status' => '1', 'html' => $html, 'totalTime' => $totalTime, 'paper_type' => $this->input->post('paper_type', true)];
                } else {
                    $resp = ['status' => '0', 'html' => '', 'totalTime' => 0];
                }

                echo json_encode($resp, JSON_UNESCAPED_SLASHES);

            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }

    }

    public function get_paper_details1()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('id', false))) {
                $timezoneDB = $this->db_model->select_data('timezone', 'site_details', ['id' => 1]);

                if (isset($timezoneDB[0]['timezone']) && ! empty($timezoneDB[0]['timezone'])) {
                    date_default_timezone_set($timezoneDB[0]['timezone']);
                }

                $paperDetails = $this->db_model->select_data('*', 'exams use index (id)', ['id' => $this->input->post('id', true)], 1);

                if (! empty($paperDetails)) {
                    if ($this->input->post('paper_type', true) == 'practice') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain = '<p style="margin-bottom:0px!important; font-size:14px;><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime  = $paperDetails[0]['time_duration'];

                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                    } elseif ($this->input->post('paper_type', true) == 'descriptive') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain       = '<p style="margin-bottom:0px!important; font-size:14px;><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime        = $paperDetails[0]['time_duration'];
                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                    } else {

                        $current_time = date('Y-m-d H:i:s');
                        $start_time   = $paperDetails[0]['mock_sheduled_date'] . ' ' . $paperDetails[0]['mock_sheduled_time'];
                        $end_time     = date('Y-m-d H:i:s', strtotime($start_time . ' +' . $paperDetails[0]['time_duration'] . ' minutes'));

                        if ($current_time < $end_time) {
                            $time_diff      = strtotime($end_time) - time();
                            $remaining_time = ($time_diff / 60);
                        } else {
                            $remaining_time = '0';
                        }
                        $totalTime        = $remaining_time;
                        $timeRemain       = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $negative_marking = '<p style="margin-bottom:0px!important; font-size:14px;"><span class="edu_paper_smallinfo">Minus Mark : </span><span> ' . $paperDetails[0]['negative_marking'] . '</span></p>';
                        $instructions     = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>';
                    }

                    $html = '
                              <div class="container-fluid">
                                  <div class="row">

                                <div class="col-lg-9">
                                    <i class="fa-solid fa-arrow-left back_btn"></i>
                                      <div class="main-section" style="margin-top:20px;">
                                        <div class="question-name">
                                           <p style="margin-bottom:0px; font-size:14px;">' . $this->lang->line('ltr_paper') . ' : </span>' . $paperDetails[0]['name'] . '   --  ' . $this->lang->line('ltr_total_questions') . ' : </span><span class="remainingQuest">' . $paperDetails[0]['total_question'] . '</span>/' . $paperDetails[0]['total_question'] . '</p>
                                        </div>
                                        <div class="menu">
                                          <div class="timer">' . $timeRemain . '</div>
                                          <div class="timer">' . $negative_marking . '</div>
                                          <div class="report">
                                            <a href="#"><i class="fa-solid fa-exclamation"></i></a>
                                          </div>
                                        </div>
                                      </div>

                        <div class="edu_main_wrapper question_paper_wrapper">
                            <div class="question_paper_inner">

                                <div class="question_paper_body">
                                    <div class="edu_question_section">
                                        <ol style="list-style:none;">';

                    $questions    = json_decode($paperDetails[0]['question_ids'], true);
                    $question_id  = implode(',', $questions);
                    $questionData = $this->db_model->select_data('id,question,options,answer,question_type,word_limit,total_marks', 'questions use index (id)', "id in ($question_id)", '', ['id', 'desc']);
                    if ($paperDetails[0]['type'] == 3) {

                        if (! empty($questions)) {
                            $i = 1;

                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }

                            foreach ($questionData as $ques) {

                                $html .= '<div class="main-question  x' . $ques['id'] . 'x ' . $ques['id'] . 'aA">
                                                    <li>
                                                        <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                            <div class="edu_single_question">
                                                                <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                                <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                            </div>
                                                            <div class="edu_question_options">';

                                /*$options = json_decode($ques['options'], true);
                                                    $j = 'A';
                                                    $k = 1;*/

                                /*foreach ($options as $op) {
                                                        $html .= '<li><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad">&nbsp;' . $op . '</label></li>';
                                                        $j++;
                                                        $k++;
                                                    }*/

                                if (isset($ques["word_limit"]) && $ques["word_limit"] > 0) {
                                    $wordLimit = '<span style="color:red; padding-left:6px;">Word Limit is: ' . $ques["word_limit"] . '</span>';
                                    $maxlength = 'maxlength="' . $ques["word_limit"] . '"';
                                } else {
                                    $maxlength = 'maxlength="10000000000000000000000000000"';
                                }

                                $html .= '</div>' . $wordLimit . '
                                                                <div class="edu_descriptive_answer">

                                                                    <label for="descriptive_' . $i . '"></label>
                                                                    <textarea id="descriptive_' . $i . '" name="question_answer[' . $ques['id'] . ']" rows="4" cols="100"  ' . $maxlength . '></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </li>';
                                $i++;
                            }
                        }

                        $html .= '</ol>
                                    </div>
                                </div>

         <div class="edu_btn_wrapper">
                    <form method="post">
                        <input type="hidden" name="total_qst" id="total_qst" value="' . count($questionData) . '">
                        <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                        <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                        <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                        <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                        <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                        <input type="hidden" name="submit_time" id="submit_time" value="">
                        <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">
                        <button style="" type="button" style="position: fixed; bottom: 0;  box-shadow: 0 2px 4px rgba(0,0,0,0.1);" class="edu_admin_btn submitPopupShow xxxxxx">' . $this->lang->line('ltr_submit') . '</button>
                    </form>
                </div>
                                ';

                    } else {
                        if (! empty($questions)) {
                            $i = 1;
                            $n = 0;
                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }

                            foreach ($questionData as $ques) {

                                $html .= '<div class="main-question  x' . $ques['id'] . 'x ' . $ques['id'] . 'aA">
                                                <li>
                                                    <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                        <div class="edu_single_question">
                                                            <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                            <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                        </div>
                                                        <div class="edu_question_options">
                                                            <ol>';
                                $options = json_decode($ques['options'], true);
                                $j       = 'A';
                                $k       = 1;
                                foreach ($options as $op) {
                                    $html .= '<li class="col-12"><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad" data-question-id="' . $i . '">&nbsp;' . $op . '</label></li>';
                                    $j++;
                                    $k++;
                                }
                                $html .= '</ol>
                                                        </div>
                                                    </div>
                                                </li></div>';
                                $i++;
                                $n++;

                            }

                        }

                        $html .= '</ol>
                                    </div>
                                </div>
                              ';
                    }
                    '</div>
                        </div>
                        <!------- Question Papre End -------->';
                    if (isset($end_time) && (date('Y-m-d H:i:s') >= $end_time)) {
                        $html = '<div class="sectionHolder mockPaperTimerWrapper mb_30 text-center">
                                <div class="edu_main_wrapper">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4 class="edu_sub_title nomarginbtm">' . $this->lang->line('ltr_time_over') . '</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                    $html .= '</div>
            </div>
            </div>


        <div class="col-lg-3" style="padding-right: 0px;">
        <i class="fa-solid fa-arrow-right next_btn" data-id="' . $ques['id'] . '"></i>
     <button type="button" class="edu_admin_btn1 submitPopupShow" id="submitButton" style="display:none;top: 50%;right: 45%;box-shadow: none;text-transform: uppercase;position: relative;outline: none;    color: #ffffff;
    font-weight: 600;
    border-radius: 6px;
    border: none;    height: 47px;
    width: 135px;    background-color: #006eff;
">' . $this->lang->line('ltr_submit') . '</button>
        <div class="sidebar" id="sidebar" style="height: 1128px; background-color: color(srgb 0.9393 0.9494 0.9837);">

          <div class="row" style="margin-left: 0px; margin-right: 0px;">

            <div class="header">
              <div class="profile d-flex">

                <div class="username"></div>
              </div>
              <div class="status">
                <div class="d-flex col-lg-12">
                  <div class="status-item col-lg-6">
                    <span class="greenx grn">0</span>
                    Attempted
                  </div>
                  <div class="status-item col-lg-6">
                    <span class="yellow yel">0</span>
                    Marked
                  </div>
                </div>
                <div class="d-flex col-lg-12">
                  <div class="status-item col-lg-6">
                    <span class="white">4</span>
                    Not Visited
                  </div>
                  <div class="status-item col-lg-6">
                    <span class="red">1</span>
                    Not Answered
                  </div>
                </div>

                 <div class="profile d-flex">

                <div class="username"></div>
              </div>
              </div>
            </div>
            <div class="section-title" style="padding-top: 10px; padding-bottom: 10px;">
              Warning :- Don`t Change this window, Otherwise Examination will restart
            </div>


              <div style=" width: 100%;">
                  <ul class="row question-grid" id="question-filters" style="padding-right: 0px; padding-left: 7px;">';
                    $jk  = 0;
                    $ids = "";
                    foreach ($questionData as $ques) {
                        $jk++;
                        if ($jk == 1) {
                            $ids = $ques['id'];
                            $html .= '<input type="hidden" id="first_que_id" value="' . $ques['id'] . '-' . $jk . '">
                            <li class="question-number selected redd" onclick="filterSelection(' . $ques['id'] . ',' . $jk . ')" data-filter=".' . $ques['id'] . 'aA">' . $jk . '</li>';
                        } else {
                            $html .= '<li class="question-number" onclick="filterSelection(' . $ques['id'] . ',' . $jk . ')" data-filter=".' . $ques['id'] . 'aA">' . $jk . '</li>';
                        }
                    }

                    $html .= '</ul>

                                        <div class="question_paper_footer" style="position: fixed; bottom: 10px;  box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <div class="edu_btn_wrapper">
                                                <form method="post">
                                                    <input type="hidden" name="total_qst" id="total_qst" value="' . count($questionData) . '">
                                                    <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                                                    <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                                                    <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                                                    <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                                                    <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                                                    <input type="hidden" name="submit_time" id="submit_time" value="">
                                                    <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">
                                                    <button style="" type="button"  class="edu_admin_btn submitPopupShow xxxxxx">' . $this->lang->line('ltr_submit') . '</button>
                                                </form>
                                            </div>
                                        </div>


              </div>
            </div>
          </div>

          <div class="toggle-btn" onclick="toggleSidebar()">
            <div class="toggle-icon"></div>
          </div>

        </div>
          </div>
        </div>
         <script>


        function toggleSidebar(){

            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("show");


        }

      filterSelection(' . $ids . ',1);





      function filterSelection(c,id) {
        var x, i;
        x = document.getElementsByClassName("main-question");
        for (i = 0; i < x.length; i++) {
            w3RemoveClass(x[i], "show");
            if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
        }

        var xx = document.getElementById("total_qst").value;
        var xyx = document.getElementsByClassName("xxxxxx")[0];





         var selectedLis = document.querySelectorAll("#question-filters li.selected.yellow");
            selectedLis.forEach(function(li) {
            li.classList.remove("redd");
                li.classList.add("greenx");
            li.classList.remove("redd");
                 li.classList.remove("yellow");
                  $("li.greenx").css("pointer-events", "");
                 updateCounts();

            });

    }

   function w3AddClass(element, name) {
        var arr1 = element.className.split(" ");
        var arr2 = name.split(" ");
        for (var i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {
                element.className += " " + arr2[i];
            }
        }
    }

    function w3RemoveClass(element, name) {
        var arr1 = element.className.split(" ");
        var arr2 = name.split(" ");
        for (var i = 0; i < arr2.length; i++) {
            while (arr1.indexOf(arr2[i]) > -1) {
                arr1.splice(arr1.indexOf(arr2[i]), 1);
            }
        }
        element.className = arr1.join(" ");
    }

    // Add active class to the current button (highlight it)
  var btnContainer = document.getElementById("question-filters");
    var btns = btnContainer.getElementsByClassName("question-number");
     for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("selected");
            var selectedLi = document.querySelector("#question-filters li.selected");

            // Handle the selected classes
            if (selectedLi && selectedLi.classList.contains("yellow")) {
                if (current[0]) current[0].classList.remove("selected");
                this.classList.add("selected");
                updateCounts();
            } else if (selectedLi && selectedLi.classList.contains("greenx")) {
                $("li.greenx").removeClass("redd");
                this.classList.add("selected");
                updateCounts();
            } else {
                this.classList.add("selected");
                this.classList.add("redd");
                updateCounts();
            }


            var questionIndex = parseInt(this.innerText);
            console.log(questionIndex);
           console.log(btns.length);


            if (questionIndex === btns.length) {
                var submitButton = document.getElementById("submitButton");
                if (submitButton) {
                    submitButton.style.display = "block";
                }
            } else {
                var submitButton = document.getElementById("submitButton");
                if (submitButton) {
                    submitButton.style.display = "none";
                }
            }
        });
    }
    function updateCounts(){
        var selectedCount = $(".question-number.redd").length;
        var yellowCount = $(".question-number.yellow").length;
        var greenCount = $(".question-number.greenx").length;
         var whitecount = $("ul#question-filters li.question-number:not(.redd, .selected, .yellow, .greenx)").length;

        $(".red").text(selectedCount);
        $(".yel").text(yellowCount);
        $(".grn").text(greenCount);
        $(".white").text(whitecount);
    }

 $(".next_btn").click(function(){
             var $selected = $("ul#question-filters .question-number.selected").last();

    // Find the next <li> element after the last selected one
    var $next = $selected.next(".question-number");

            if ($next.length) {
                // $selected.removeClass("selected");
                 $next.addClass("selected").trigger("click");

            } else {

            }
        });


        $(".back_btn").click(function(){
       var $selected = $("ul#question-filters .question-number.selected");

    // Find the previous <li> element before the last selected one
    var $prev = $selected.prev(".question-number");

    if ($prev.length) {

        //$selected.removeClass("selected");


        $prev.addClass("selected").trigger("click");
    } else {

        $selected.addClass("selected").trigger("click");
    }
});



    $(".questionOptionRad").on("click", function() {
        var questionId = $(this).data("question-id");
        var liElements = $("#question-filters li");

        liElements.each(function() {
            var li = $(this);
            if (li.text().trim() == questionId) {
                li.removeClass("redd");
                li.addClass("yellow");
                $("li.yellow").css("pointer-events", "none");

                updateCounts();

            }
        });

    });





    </script>';

                    $resp = ['status' => '1', 'html' => $html, 'totalTime' => $totalTime, 'paper_type' => $this->input->post('paper_type', true)];
                } else {
                    $resp = ['status' => '0', 'html' => '', 'totalTime' => 0];
                }

                echo json_encode($resp, JSON_UNESCAPED_SLASHES);

            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }

    }

    public function get_paper_details_old()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('id', false))) {
                $timezoneDB = $this->db_model->select_data('timezone', 'site_details', ['id' => 1]);

                if (isset($timezoneDB[0]['timezone']) && ! empty($timezoneDB[0]['timezone'])) {
                    date_default_timezone_set($timezoneDB[0]['timezone']);
                }

                $paperDetails = $this->db_model->select_data('*', 'exams use index (id)', ['id' => $this->input->post('id', true)], 1);
                if (! empty($paperDetails)) {
                    if ($this->input->post('paper_type', true) == 'practice') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain = '<p ><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime  = $paperDetails[0]['time_duration'];
                    } elseif ($this->input->post('paper_type', true) == 'descriptive') {
                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_please_read') . '</li>';
                        $timeRemain = '<p><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';
                        $totalTime  = $paperDetails[0]['time_duration'];
                    } else {

                        $current_time = date('Y-m-d H:i:s');
                        $start_time   = $paperDetails[0]['mock_sheduled_date'] . ' ' . $paperDetails[0]['mock_sheduled_time'];
                        $end_time     = date('Y-m-d H:i:s', strtotime($start_time . ' +' . $paperDetails[0]['time_duration'] . ' minutes'));

                        if ($current_time < $end_time) {
                            $time_diff      = strtotime($end_time) - time();
                            $remaining_time = ($time_diff / 60);
                        } else {
                            $remaining_time = '0';
                        }
                        $totalTime  = $remaining_time;
                        $timeRemain = '<p><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_time') . ' : </span><span id="timer"> ' . $this->lang->line('ltr_min') . '</span></p>';

                        $instructions = '<li>' . $this->lang->line('ltr_all_questions_com') . '</li>
                                <li>' . $this->lang->line('ltr_there_will_be') . '</li>
                                <li>' . $this->lang->line('ltr_please_do_not') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>
                                <li>' . $this->lang->line('ltr_on_time_completion') . '</li>';
                    }

                    $html = ' <!------- Paper Selecion Start -------->
                        <div class="sectionHolder mb_30">
                            <div class="edu_main_wrapper">
                                <h4 class="edu_sub_title padderTop10">' . $this->lang->line('ltr_instructions') . '</h4>
                                <ol class="paper_instructions">
                                ' . $instructions . '
                                </ol>
                            </div>
                        </div>
                        <!------- Question Papre Start -------->
                        <div class="edu_main_wrapper question_paper_wrapper">
                            <div class="question_paper_inner">
                                <div class="question_paper_header">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom30">
                                            <div class="edu_paper_info responsive_center">
                                                <p><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_paper') . ' : </span>' . $paperDetails[0]['name'] . '</p>
                                                <p><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_total_questions') . ' : </span>' . $paperDetails[0]['total_question'] . '/' . $paperDetails[0]['total_question'] . '</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom30">
                                                <div class="edu_paper_info responsive_center text-right">
                                                ' . $timeRemain . '<p><span class="edu_paper_smallinfo">' . $this->lang->line('ltr_remaining_questions') . ': </span><span class="remainingQuest">' . $paperDetails[0]['total_question'] . '</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="question_paper_body">
                                    <div class="edu_question_section">
                                        <ol>';

                    $questions    = json_decode($paperDetails[0]['question_ids'], true);
                    $question_id  = implode(',', $questions);
                    $questionData = $this->db_model->select_data('id,question,options,answer,question_type,word_limit', 'questions use index (id)', "id in ($question_id)", '', ['id', 'desc']);
                    if ($paperDetails[0]['type'] == 3) {

                        if (! empty($questions)) {
                            $i = 1;

                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }

                            foreach ($questionData as $ques) {

                                $html .= '<li>
                                                        <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                            <div class="edu_single_question">
                                                                <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                                <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                            </div>
                                                            <div class="edu_question_options">';

                                /*$options = json_decode($ques['options'], true);
                                                    $j = 'A';
                                                    $k = 1;*/

                                /*foreach ($options as $op) {
                                                        $html .= '<li><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad">&nbsp;' . $op . '</label></li>';
                                                        $j++;
                                                        $k++;
                                                    }*/

                                if (isset($ques["word_limit"]) && $ques["word_limit"] > 0) {
                                    $wordLimit = '<span style="color:red ">Word Limit is: ' . $ques["word_limit"] . '</span>';
                                    $maxlength = 'maxlength="' . $ques["word_limit"] . '"';
                                } else {
                                    $maxlength = 'maxlength="10000000000000000000000000000"';
                                }

                                $html .= '</div>' . $wordLimit . '
                                                                <div class="edu_descriptive_answer">

                                                                    <label for="descriptive_' . $i . '"></label>
                                                                    <textarea id="descriptive_' . $i . '" name="question_answer[' . $ques['id'] . ']" rows="4" cols="100"  ' . $maxlength . '></textarea>
                                                                </div>
                                                            </div>
                                                        </li>';
                                $i++;
                            }
                        }

                        $html .= '</ol>
                                    </div>
                                </div>

                                <div class="question_paper_footer">
                                    <div class="edu_btn_wrapper">
                                        <form method="post">
                                        <input type="hidden" name="batch_id" value="' . $paperDetails[0]['batch_id'] . '">
                                           <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                                            <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                                            <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                                            <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                                            <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                                            <input type="hidden" name="submit_time" id="submit_time" value="">
                                            <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">

                                            <input type="hidden" name="maxmarks" value="' . $paperDetails[0]['maxmarks'] . '">

                                            <button type="button" class="edu_admin_btn submitPopupShow">' . $this->lang->line('ltr_submit') . '</button>
                                        </form>
                                    </div>
                                </div>';

                    } else {
                        if (! empty($questions)) {
                            $i = 1;

                            if ($paperDetails[0]['format'] == 1) {
                                $questionData = $this->shuffle_array($questionData);
                            }
                            foreach ($questionData as $ques) {

                                $html .= '<li>
                                                    <div class="edu_single_question_wrap questionDesrpWrap" data-id="' . $ques['id'] . '" data-ans="' . $ques['answer'] . '">
                                                        <div class="edu_single_question">
                                                            <p><span>' . $i . '.</span> ' . $ques['question'] . '</p>
                                                            <div class="edu_rest_btn resetAnswer" data-id="' . $i . '">' . $ques['total_marks'] . '<a href="javascript:void(0)"><i class="icofont-ui-reply"></i></a></div>
                                                        </div>
                                                        <div class="edu_question_options">
                                                            <ol>';
                                $options = json_decode($ques['options'], true);
                                $j       = 'A';
                                $k       = 1;
                                foreach ($options as $op) {
                                    $html .= '<li><label><input type="radio" name="options_' . $i . '" value="' . $j . '" class="questionOptionRad">&nbsp;' . $op . '</label></li>';
                                    $j++;
                                    $k++;
                                }
                                $html .= '</ol>
                                                        </div>
                                                    </div>
                                                </li>';
                                $i++;

                            }
                        }

                        $html .= '</ol>
                                    </div>
                                </div>
                                <div class="question_paper_footer">
                                    <div class="edu_btn_wrapper">
                                        <form method="post">
                                            <input type="hidden" name="paper_id" value="' . $this->input->post('id', true) . '">
                                            <input type="hidden" name="paper_name" value="' . $paperDetails[0]['name'] . '">
                                            <input type="hidden" name="total_question" value="' . $paperDetails[0]['total_question'] . '">
                                            <input type="hidden" name="start_time" id="start_time" value="' . date("H:i:s") . '">
                                            <input type="hidden" name="time_duration" value="' . $paperDetails[0]['time_duration'] . '">
                                            <input type="hidden" name="submit_time" id="submit_time" value="">
                                            <input type="hidden" name="paper_type" value="' . $this->input->post('paper_type', true) . '">
                                            <button type="button" class="edu_admin_btn submitPopupShow">' . $this->lang->line('ltr_submit') . '</button>
                                        </form>
                                    </div>
                                </div>';
                    }
                    '</div>

                        </div>
                        <!------- Question Papre End -------->';
                    if (isset($end_time) && (date('Y-m-d H:i:s') >= $end_time)) {
                        $html = '<div class="sectionHolder mockPaperTimerWrapper mb_30 text-center">
                                <div class="edu_main_wrapper">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4 class="edu_sub_title nomarginbtm">' . $this->lang->line('ltr_time_over') . '</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }

                    $resp = ['status' => '1', 'html' => $html, 'totalTime' => $totalTime, 'paper_type' => $this->input->post('paper_type', true)];
                } else {
                    $resp = ['status' => '0', 'html' => '', 'totalTime' => 0];
                }

                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function shuffle_array($array)
    {
        $keys = array_keys($array);

        shuffle($keys);

        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }

        return $new;
    }

    public function submit_paper()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('question_answer', true))) {
                $data_arr = $this->input->post(null, true);
                if ($data_arr['paper_type'] == 'practice') {
                    $table    = 'practice_result';
                    $url      = base_url('student/practice-result');
                    $prevdata = [];
                } elseif ($data_arr['paper_type'] == 'descriptive') {

                    $table    = 'descriptive_result';
                    $url      = base_url('student/descriptive-result');
                    $prevdata = [];
                } else {
                    $table    = 'mock_result';
                    $url      = base_url('student/mock-result');
                    $prevdata = [];
                }

                unset($data_arr['paper_type']);
                $data_arr['admin_id']           = $this->session->userdata('admin_id');
                $data_arr['student_id']         = $this->session->userdata('uid');
                $data_arr['date']               = date('Y-m-d');
                $data_arr['attempted_question'] = count(json_decode($data_arr['question_answer'], true));
                /*code for percentage  calculation */
                $rightCount        = 0;
                $wrongCount        = 0;
                $attemptedQuestion = json_decode($data_arr['question_answer'], true);
                $question_ids      = implode(',', array_keys($attemptedQuestion));

                $right_ansrs = $this->db_model->select_data('id,answer', 'questions use index (id)', 'id in (' . $question_ids . ')');
                $c           = 0;

                foreach ($attemptedQuestion as $key => $value) {
                    if (isset($right_ansrs[$c])) {
                        if (($key == $right_ansrs[$c]['id']) && ($value == $right_ansrs[$c]['answer'])) {
                            $rightCount++;
                        } else {
                            $wrongCount++;
                        }
                    }
                    $c++;
                }
                //  $pp = (( $rightCount - ($wrongCount*0.25) )*100 );
                //  $percentage = ($pp/$data_arr['total_question']);
                $total_score = ($rightCount - ($wrongCount * 0.25)) / $data_arr['total_question'];
                $percentage  = $total_score * 100;

                //$percentage = (($rightCount - ($wrongCount*0.25))*100)/$result['total_question'];
                $data_arr['percentage'] = number_format((float) $percentage, 2, '.', '');

                /*code for percentage  calculation End*/

                if (empty($prevdata)) {

                    $data_arr = $this->security->xss_clean($data_arr);
                    if ($table == 'descriptive_result') {

                        $data_arr['exam_id']   = $data_arr['paper_id'];
                        $data_arr['exam_name'] = $data_arr['paper_name'];
                        unset($data_arr['paper_id']);
                        unset($data_arr['paper_name']);
                        $maxmarks = $data_arr['maxmarks'];
                        unset($data_arr['maxmarks']);
                        unset($data_arr['percentage']);
                        $questionAnswer = json_decode($data_arr['question_answer'], true);
                        unset($data_arr['question_answer']);
                        $tablestudent = 'descriptive_student';
                        unset($data_arr['total_qst']);
                        $ins       = $this->db_model->insert_data($tablestudent, $data_arr);
                        $studentId = $this->db->insert_id();

                        $data_arr['maxmarks'] = $maxmarks;
                        unset($data_arr['total_question']);
                        unset($data_arr['start_time']);

                        unset($data_arr['time_duration']);
                        unset($data_arr['submit_time']);
                        unset($data_arr['admin_id']);
                        $data_arr['descriptive_student_id'] = $studentId;
                        unset($data_arr['student_id']);
                        unset($data_arr['date']);
                        unset($data_arr['attempted_question']);
                        unset($data_arr['percentage']);
                        unset($data_arr['exam_id']);
                        unset($data_arr['exam_name']);
                        unset($data_arr['batch_id']);

                        foreach ($questionAnswer as $key => $value) {
                            $data_arr['questionid']     = $key;
                            $data_arr['student_answer'] = $value;
                            $ins                        = $this->db_model->insert_data($table, $data_arr);
                        }

                    } else {

                        unset($data_arr['total_qst']);
                        $ins = $this->db_model->insert_data($table, $data_arr);

                    }
                    if ($ins) {
                        $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_paper_submitted'), 'url' => $url];
                    } else {
                        $resp = ['status' => '0'];
                    }
                } else {
                    $resp = ['status' => '3', 'url' => $url];
                }
            } else {
                $resp = ['status' => '2', 'msg' => $this->lang->line('ltr_paper_attempt')];
            }
            echo json_encode($resp, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }
    // function submit_paper(){
    //      $current_time = date('H:i:s');

    //     // echo ($current_time);
    //     // print_r($_POST);
    //     // die();
    //     if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
    //         if(!empty($this->input->post('question_answer',TRUE))){
    //             $data_arr = $this->input->post(NULL,TRUE);
    //             if($data_arr['paper_type'] == 'practice'){
    //                 $table = 'practice_result';
    //                 $url = base_url('student/practice-result');
    //                 $prevdata = array();
    //             }else{
    //                 $table = 'mock_result';
    //                 $url = base_url('student/mock-result');
    //                 $prevdata = $this->db_model->select_data('id','mock_result use index (id)',array('student_id'=>$this->session->userdata('uid'),'admin_id'=>$this->session->userdata('admin_id'),'paper_id'=>$this->input->post('paper_id',TRUE)),1);
    //             }
    //             unset($data_arr['paper_type']);
    //             $data_arr['admin_id'] = $this->session->userdata('admin_id');
    //             $data_arr['student_id'] = $this->session->userdata('uid');
    //             $data_arr['date'] = date('Y-m-d');
    //             $data_arr['attempted_question'] = count(json_decode($data_arr['question_answer'],true));
    //             /*code for percentage  calculation */
    //              $rightCount = 0;
    //              $wrongCount = 0;
    //              $attemptedQuestion = json_decode($data_arr['question_answer'],true);
    //              $question_ids = implode(',',array_keys($attemptedQuestion));

    //              $right_ansrs = $this->db_model->select_data('id,answer', 'questions use index (id)','id in ('.$question_ids.')');
    //                     $c = 0;

    //              foreach($attemptedQuestion as $key=>$value){
    //                 if(isset($right_ansrs[$c])){
    //                     if(($key == $right_ansrs[$c]['id']) && ($value == $right_ansrs[$c]['answer'])){
    //                                 $rightCount++;
    //                             }else{
    //                                 $wrongCount++;
    //                             }
    //                         }
    //                         $c++;
    //              }
    //             //  $pp = (( $rightCount - ($wrongCount*0.25) )*100 );
    //             //  $percentage = ($pp/$data_arr['total_question']);
    //              $total_score = ($rightCount - ($wrongCount*0.25))/$data_arr['total_question'];
    //              $percentage = $total_score*100;
    //              //$percentage = (($rightCount - ($wrongCount*0.25))*100)/$result['total_question'];
    //              $data_arr['percentage']=number_format((float)$percentage, 2, '.', '');

    //              /*code for percentage  calculation End*/
    //             if(empty($prevdata)){
    //                 $data_arr = $this->security->xss_clean($data_arr);
    //                 $ins = $this->db_model->insert_data($table,$data_arr);
    //                 if($ins){
    //                     $resp = array('status'=>'1', 'msg' => $this->lang->line('ltr_paper_submitted'),'url'=>$url);
    //                 }else{
    //                     $resp = array('status'=>'0');
    //                 }
    //             }else{
    //                 $resp = array('status'=>'3', 'url'=>$url);
    //             }
    //         }else{
    //             $resp = array('status'=>'2', 'msg' => $this->lang->line('ltr_paper_attempt'));
    //         }
    //         echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    //     }else{
    //         echo $this->lang->line('ltr_not_allowed_msg');
    //     }
    // }
    // function result_table($type){
    //     //  print_r($type);
    //     // die();
    //     if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
    //         $post = $this->input->post(NULL,TRUE);
    //         $get = $this->input->get(NULL,TRUE);
    //         if(isset($post['length']) && $post['length']>0){
    //             if(isset($post['start']) && !empty($post['start'])){
    //                 $limit = array($post['length'],$post['start']);
    //                 $count = $post['start']+1;
    //             }else{
    //                 $limit = array($post['length'],0);
    //                 $count = 1;
    //             }
    //         }else{
    //             $limit = '';
    //             $count = 1;
    //         }

    //         if($post['search']['value'] != ''){
    //             $like = array('name',$post['search']['value']);
    //         }else{
    //           $like = '';
    //         }

    //         $cond = array("admin_id"=>$this->session->userdata('admin_id'),'student_id'=>$this->session->userdata('uid'));

    //         if(isset($get['month']) || isset($get['year'])){
    //             if($get['month']!='' && $get['year']!=''){
    //                 $datefiltr = $get['year'].'-'.$get['month'];
    //                 if($type == 'practice'){
    //                   $like = array('date(added_at)',$datefiltr);
    //                 }else{
    //                   $like = array('mock_sheduled_date',$datefiltr);
    //                 }

    //             }
    //         }

    //         if($type == 'practice'){
    //           $table_name = 'practice_result';
    //           $cond1=array("admin_id"=>$this->session->userdata('admin_id'),'type'=>2,'batch_id'=>$this->session->userdata('batch_id'));
    //         }else{
    //           $table_name = 'mock_result';
    //           $cond1=array("admin_id"=>$this->session->userdata('admin_id'),'type'=>1,'concat(mock_sheduled_date ," ",mock_sheduled_time)<=' => date('Y-m-d H:i:s'),'batch_id'=>$this->session->userdata('batch_id'));
    //         }

    //         if(isset($get['paper'])){
    //             if($get['paper']!=''){
    //                 $cond1['id'] = $get['paper'];
    //             }
    //         }

    //         $exam_Data = $this->db_model->select_data('*', 'exams use index (id)',$cond1,$limit,array('id','desc'),$like);

    //         $recordsTotal = $this->db_model->countAll('exams use index (id)',$cond1,'','','');
    //       //    print_r($recordsTotal);
    //       // die();
    //       if($exam_Data){

    //       foreach($exam_Data as $exams){

    //           $cond['paper_id'] = $exams['id'];
    //         $result_data = $this->db_model->select_data('*', $table_name.' use index (id)',$cond,'',array('id','desc'));

    //         if(!empty($result_data)){
    //             foreach($result_data as $result){

    //                 $attemptedQuestion = json_decode($result['question_answer'],true);
    //                 //print_r($attemptedQuestion);
    //                 if(!empty($result['question_answer'])){
    //                     $question_ids = implode(',',array_keys($attemptedQuestion));
    //                     if(!empty($question_ids)){
    //                         $right_ansrs = current($this->db_model->select_data('id,answer', 'questions use index (id)','id in ('.$question_ids.')'));
    //                     }else{
    //                         $right_ansrs = array();
    //                     }

    //                     $rightCount = 0;
    //                     $wrongCount = 0;
    //                     $c = 0;
    //                     foreach($attemptedQuestion as $key=>$value){
    //                         $right_ansrs = current($this->db_model->select_data('id,answer', 'questions use index (id)',array('id'=>$key)));
    //                         if(($key == $right_ansrs['id']) && ($value == $right_ansrs['answer'])){
    //                             $rightCount++;
    //                         }else{
    //                             $wrongCount++;
    //                         }

    //                     }

    //                     $per_data = (($rightCount - ($wrongCount*0.25))*100)/$result['total_question'];
    //                     //update percentage
    //                     if($per_data < 0){
    //                         $percentage = 0;
    //                     }else{
    //                         $percentage =$per_data;
    //                     }
    //                     // print_r($percentage);
    //                     // die();
    //                     $PN = number_format((float)$percentage, 2, '.', '');

    //                     $this->db_model->update_data_limit($table_name.' use index (id)',$this->security->xss_clean(array('percentage'=>$PN)),array('id'=>$result['id']));
    //                     $url = base_url('student/answer-sheet/'.$type.'/'.$result['id'].'/'.$exams['id']);

    //                     $action = '<p class="actions_wrap"><a href="'.$url.'" target="_blank" class="btn_view"><i class="fa fa-eye"></i></a>';

    //                     $time_taken = '';
    //                     if($result['start_time']!="" || $result['submit_time']!=""){
    //                         $stime=strtotime($result['start_time']);
    //                         $etime=strtotime($result['submit_time']);
    //                         $elapsed = $etime - $stime;
    //                         $time_taken = gmdate("H:i", $elapsed);
    //                     }

    //                     // $dataarray[] = array(
    //                     //     $count,
    //                     //     $result['paper_name'],
    //                     //     date('d-m-Y',strtotime($result['date'])),
    //                     //     date('h:i A',strtotime($result['start_time'])),
    //                     //     date('h:i A',strtotime($result['submit_time'])),
    //                     //     $result['total_question'],
    //                     //     $result['attempted_question'],
    //                     //     gmdate("H:i", $result['time_duration']*60),
    //                     //     $time_taken,
    //                     //     $rightCount,
    //                     //     number_format((float)$percentage, 2, '.', ''),
    //                     //     $action,
    //                     // );
    //                     $dataarray[] = array(
    //                         $count,
    //                         $result['paper_name'],
    //                         date('d-m-Y',strtotime($result['date'])),
    //                         date('h:i A',strtotime($result['start_time'])),
    //                         date('h:i A',strtotime($result['submit_time'])),
    //                         $result['total_question'],
    //                         $result['attempted_question'],
    //                         gmdate("H:i:s", $result['time_duration']*60),
    //                         $time_taken,
    //                         $rightCount,
    //                         number_format((float)$percentage, 2, '.', ''),
    //                         $action,
    //                     );

    //                     $count++;
    //                 }
    //             }
    //         }
    //       }

    //       $output = array(
    //                 "draw" => $post['draw'],
    //                 "recordsTotal" => $recordsTotal,
    //                 "recordsFiltered" => $recordsTotal,
    //                 "data" => (!empty($dataarray) ? $dataarray : ''),
    //             );
    //       }else{

    //           $output = array(
    //                 "draw" => $post['draw'],
    //                 "recordsTotal" => 0,
    //                 "recordsFiltered" => 0,
    //                 "data" => array(),
    //             );
    //       }

    //         echo json_encode($output,JSON_UNESCAPED_SLASHES);
    //     }else{
    //         echo $this->lang->line('ltr_not_allowed_msg');
    //     }
    // }

    public function result_table($type)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);
            $get  = $this->input->get(null, true);
            if (isset($post['length']) && $post['length'] > 0) {
                if (isset($post['start']) && ! empty($post['start'])) {
                    $limit = [$post['length'], $post['start']];
                    $count = $post['start'] + 1;
                } else {
                    $limit = [$post['length'], 0];
                    $count = 1;
                }
            } else {
                $limit = '';
                $count = 1;
            }

            if ($post['search']['value'] != '') {
                $like = ['name', $post['search']['value']];
            } else {
                $like = '';
            }

            $cond = ["admin_id" => $this->session->userdata('admin_id'), 'student_id' => $this->session->userdata('uid')];

            if (isset($get['month']) || isset($get['year'])) {
                if ($get['month'] != '' && $get['year'] != '') {
                    $datefiltr = $get['year'] . '-' . $get['month'];
                    if ($type == 'practice') {
                        $like = ['date(added_at)', $datefiltr];
                    } elseif ($type == 'descriptive') {
                        $like = ['date(added_on)', $datefiltr];
                    } else {
                        $like = ['mock_sheduled_date', $datefiltr];
                    }

                }
            }

            if ($type == 'practice') {
                $table_name = 'practice_result';
                $cond1      = ["admin_id" => $this->session->userdata('admin_id'), 'type' => 2, 'batch_id' => $this->session->userdata('batch_id')];
            } elseif ($type == 'descriptive') {
                $table_name = 'descriptive_student';
                $cond1      = ["admin_id" => $this->session->userdata('admin_id'), 'type' => 3, 'batch_id' => $this->session->userdata('batch_id')];
                $cond2      = ["student_id" => $this->session->userdata('uid'), "admin_id" => $this->session->userdata('admin_id'), 'batch_id' => $this->session->userdata('batch_id')];

            } else {
                $table_name = 'mock_result';
                $cond1      = ["admin_id" => $this->session->userdata('admin_id'), 'type' => 1, 'concat(mock_sheduled_date ," ",mock_sheduled_time)<=' => date('Y-m-d H:i:s'), 'batch_id' => $this->session->userdata('batch_id')];
            }

            if (isset($get['paper'])) {
                if ($get['paper'] != '') {
                    $cond1['id'] = $get['paper'];
                    if ($table_name == 'descriptive_student') {
                        $cond1 = ["admin_id" => $this->session->userdata('admin_id'), 'type' => 3, 'id' => $get['paper']];
                    }
                }
            }

            $exam_Data = $this->db_model->select_data('*', 'exams use index (id)', $cond1, $limit, ['id', 'desc'], $like);

            $recordsTotal = $this->db_model->countAll('exams use index (id)', $cond1, '', '', '');
            //print_r($this->db->last_query());die;
            if ($exam_Data) {
                                                 // echo count($exam_Data);
                foreach ($exam_Data as $exams) { //echo "<pre>";print_r($exams);

                    if ($table_name == 'descriptive_student') {
                        $cond['student_id'] = $cond2['student_id'];
                        if (isset($get['paper'])) {
                            if ($get['paper'] != '') {
                                $cond['exam_id'] = $get['paper'];
                            }
                        }
                        $result_data = $this->db_model->select_data('*', $table_name . ' use index (id)', $cond, '', ['id', 'desc']);

                        $recordsTotal = $this->db_model->countAll('descriptive_student use index (id)', $cond, '', '', '');

                    } else {
                        $cond['paper_id'] = $exams['id'];
                        $result_data      = $this->db_model->select_data('*', $table_name . ' use index (id)', $cond, '', ['id', 'desc']);
                    }
                }
                if (! empty($result_data)) {
                    if ($table_name == 'descriptive_student') {
                        //echo count($result_data);
                        foreach ($result_data as $result) {

                            $attemptedQuestion = $result['attempted_question'];

                            if (! empty($result['attempted_question'])) {

                                //$this->db_model->update_data_limit($table_name.' use index (id)',$this->security->xss_clean(array('percentage'=>$PN)),array('id'=>$result['id']));
                                if ($result['isRelease'] == 1) {
                                    $url   = base_url('student/answer-sheet/' . $type . '/' . $result['id'] . '/' . $exams['id']);
                                    $newtb = 'target="_blank"';
                                } else {
                                    $url   = '#';
                                    $newtb = '';
                                }

                                $action = '<p class="actions_wrap"><a href="' . $url . '" ' . $newtb . '  target="_blank" class="btn_view"><i class="fa fa-eye"></i></a>';

                                $time_taken = '';
                                if ($result['start_time'] != "" || $result['submit_time'] != "") {
                                    $stime      = strtotime($result['start_time']);
                                    $etime      = strtotime($result['submit_time']);
                                    $elapsed    = $etime - $stime;
                                    $time_taken = gmdate("H:i:s", $elapsed);
                                }

                                $dataarray[] = [
                                    $count,
                                    $result['exam_name'],
                                    date('d-m-Y', strtotime($result['date'])),
                                    date('h:i A', strtotime($result['start_time'])),
                                    date('h:i A', strtotime($result['submit_time'])),
                                    $result['total_question'],
                                    $result['attempted_question'],
                                    gmdate("H:i:s", $result['time_duration'] * 60),
                                    $time_taken,

                                    $action,
                                ];

                                $count++;
                            }
                        }
                    } else {
                        foreach ($exam_Data as $exams) {

                            $condss['paper_id'] = $exams['id'];
                            $cond['paper_id']   = $exams['id'];
                            $result_data        = $this->db_model->select_data('*', $table_name . ' use index (id)', $cond, '', ['id', 'desc']);
                            $recordsTotal       = $this->db_model->countAll($table_name . ' use index (id)', $condss, '', '', '');
                            $ttl_q              = 0;
                            $obtain             = 0;
                            foreach ($result_data as $result) { //echo "<pre>"; print_r($result);

                                $attemptedQuestion = json_decode($result['question_answer'], true);
                                //print_r($attemptedQuestion);
                                if (! empty($result['question_answer'])) {
                                    $question_ids = implode(',', array_keys($attemptedQuestion));

                                    if (! empty($question_ids)) {
                                        $right_ansrs = current($this->db_model->select_data('id,answer', 'questions use index (id)', 'id in (' . $question_ids . ')'));
                                        $obtain      = current($this->db_model->select_data('SUM(total_marks) as obtain_marks', 'questions use index (id)', 'id in (' . $question_ids . ')'));
                                    } else {
                                        $right_ansrs = [];
                                    }
                                    $ttl_q      = current($this->db_model->select_data('SUM(total_marks) as total_marks', 'questions'));
                                    $rightCount = 0;
                                    $wrongCount = 0;
                                    $c          = 0;
                                    foreach ($attemptedQuestion as $key => $value) {
                                        $right_ansrs = current($this->db_model->select_data('id,answer', 'questions use index (id)', ['id' => $key]));
                                        if (($key == $right_ansrs['id']) && ($value == $right_ansrs['answer'])) {
                                            $rightCount++;
                                        } else {
                                            $wrongCount++;
                                        }

                                    }

                                    $per_data = (($rightCount - ($wrongCount * 0.25)) * 100) / $result['total_question'];
                                    //update percentage
                                    if ($per_data < 0) {
                                        $percentage = 0;
                                    } else {
                                        $percentage = $per_data;
                                    }
                                    $PN = number_format((float) $percentage, 2, '.', '');

                                    $this->db_model->update_data_limit($table_name . ' use index (id)', $this->security->xss_clean(['percentage' => $PN]), ['id' => $result['id']]);
                                    $url = base_url('student/answer-sheet/' . $type . '/' . $result['id'] . '/' . $exams['id']);

                                    $action = '<p class="actions_wrap"><a href="' . $url . '" target="_blank" class="btn_view"><i class="fa fa-eye"></i></a>';

                                    $time_taken = '';
                                    if ($result['start_time'] != "" || $result['submit_time'] != "") {
                                        $stime      = strtotime($result['start_time']);
                                        $etime      = strtotime($result['submit_time']);
                                        $elapsed    = $etime - $stime;
                                        $time_taken = gmdate("H:i:s", $elapsed);
                                    }

                                    $dataarray[] = [
                                        $count,
                                        $result['paper_name'],
                                        date('d-m-Y', strtotime($result['date'])),
                                        date('h:i A', strtotime($result['start_time'])),
                                        date('h:i A', strtotime($result['submit_time'])),
                                        $result['total_question'],
                                        $result['attempted_question'],
                                        gmdate("H:i:s", $result['time_duration'] * 60),
                                        $time_taken,
                                        $rightCount,
                                        $ttl_q['total_marks'],
                                        $obtain['obtain_marks'],
                                        number_format((float) $percentage, 2, '.', ''),
                                        $action,
                                    ];

                                    $count++;
                                }
                            }
                        }
                    }
                }
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => (! empty($dataarray) ? $dataarray : ''),
                ];
            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }

            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    /**** Student Section Manage End ****/

    public function readMoreWord($story_desc, $title = '', $C_word = '')
    {
        $chars = 90;
        if (! empty($C_word)) {
            $chars = $C_word;
        }

        $count_word = strlen($story_desc);
        if ($count_word > $chars) {
            $readMore   = '<a class="charaViewPopupModel" data-title="' . $title . '" data-word="' . $story_desc . '"  href="javascript:;"> ....</a>';
            $story_desc = substr($story_desc, 0, $chars);
            $story_desc = substr($story_desc, 0, strrpos($story_desc, ' '));
            $story_desc = $story_desc . ' ' . $readMore;
            return $story_desc;

        } else {
            return $story_desc;
        }
    }
    public function SendMail($tomail = '', $subject = '', $msg = '')
    {
        $frommail = $this->general_settings('smtp_mail');
        $frompwd  = $this->general_settings('smtp_pwd');
        $title    = $this->db_model->select_data('site_title', 'site_details', '', 1, ['id', 'desc'])[0]['site_title'];

        $this->load->library('email');
        $config                = [];
        $config['protocol']    = $this->general_settings('server_type');
        $config['smtp_host']   = $this->general_settings('smtp_host');
        $config['smtp_port']   = $this->general_settings('smtp_port');
        $config['smtp_user']   = $frommail;
        $config['smtp_pass']   = $frompwd;
        $config['charset']     = "utf-8";
        $config['mailtype']    = "html";
        $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
        $config['newline']     = "\r\n";

        // Set to, from, message, etc.
        $this->email->initialize($config);
        $this->email->from($frommail, $title);
        $this->email->to($tomail);

        $this->email->subject($subject);
        $this->email->message($msg);

        @$this->email->send();
        return true;
    }

    public function search_batch()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post                     = $this->input->post(null, true);
            $data['batch_Data']       = $this->db_model->select_data('*', 'batches use index (id)', ['status' => '1'], '', ['id', 'desc'], ['batch_name', $post['course_name']]);
            $data['currency_decimal'] = $this->general_settings('currency_decimal_code');
            if (! empty($data['batch_Data'])) {
                $data['batches'] = $data['batch_Data'];
            }
            $result = $this->load->view('frontend/search_batch_data', $data, true);
            echo json_encode(['status' => '1', 'data' => $result]);
        }

    }

    public function search_student_batch()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);

            $data['batch_Data'] = $this->db_model->select_data('*', 'batches use index (id)', "batch_name LIKE '%" . $post['course_name'] . "%' AND status=1");
            // echo $this->db->last_query();
            $data['currency_decimal'] = $this->general_settings('currency_decimal_code');
            $data['site_Details']     = $this->db_model->select_data('*', 'site_details', ['id' => '1'], 1);

            if (! empty($data['batch_Data'])) {
                $data['batches'] = $data['batch_Data'];
            }
            $result = $this->load->view('frontend/search_studbatch_data', $data, true);
            echo json_encode(['status' => '1', 'data' => $result]);
        }

    }

    public function search_student_cat()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);

            $data['batch_Data'] = $this->db_model->select_data('*', 'batches use index (id)', ['status' => '1'], '', ['id', 'desc'], ['sub_cat_id', $post['id']]);

            $data['currency_decimal'] = $this->general_settings('currency_decimal_code');
            $data['site_Details']     = $this->db_model->select_data('*', 'site_details', ['id' => '1'], 1);

            if (! empty($data['batch_Data'])) {
                $data['batches'] = $data['batch_Data'];
            }
            $result = $this->load->view('frontend/search_studbatch_data', $data, true);
            echo json_encode(['status' => '1', 'data' => $result]);
        }

    }

    public function search_singleCatData()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);

            $cond             = ['status' => 1, 'id' => $post['id']];
            $data['category'] = $this->db_model->select_data('*', 'batch_category', $cond);
            $cond_sub         = ['status' => 1, 'cat_id' => $data['category'][0]['id']];
            $subCategory      = $this->db_model->select_data('id as SubcategoryId,name as SubcategoryName', 'batch_subcategory use index (id)', $cond_sub);
            // echo $this->db->last_query();
            if (! empty($subCategory)) {

                foreach ($subCategory as $subkey => $value) {

                    $cond_sub1 = ['status' => 1, 'sub_cat_id' => $value['SubcategoryId']];

                    $batchData = $this->db_model->select_data('*', 'batches use index (id)', $cond_sub1, '', ['id', 'desc']);

                    $subCategory[$subkey]['batchdata'] = $batchData;

                }

                $data['batch_Data'] = $subCategory;
            }

            $data['currency_decimal'] = $this->general_settings('currency_decimal_code');
            $data['site_Details']     = $this->db_model->select_data('*', 'site_details', ['id' => '1'], 1);

            if (! empty($data['batch_Data'])) {
                $data['batches'] = $data['batch_Data'];
            }

            $result = $this->load->view('frontend/singleCatData', $data, true);
            echo json_encode(['status' => '1', 'data' => $result]);
        }
    }

    public function addbatch()
    {

        /*echo "<pre>";
        print_r($_POST);
        die;*/

        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('batch_name', true))) {
                $prevdata = $this->db_model->select_data('*', 'batches use index (id)', ['batch_name' => $this->input->post('batch_name', true)], 1);

                if ($this->input->post('type', true) == 'edit') {

                   
                    if (empty($prevdata) || ($prevdata[0]['id'] == $this->input->post('batch_id', true))) {
                        $data_arr = [
                            'batch_name' => $this->input->post('batch_name', true),
                            'start_time' => date('H:i:s', strtotime($this->input->post('start_time', true))),
                            'end_time'   => date('H:i:s', strtotime($this->input->post('end_time', true))),
                        ];
                        //  print_r($_POST['batch_subject']);
                        // die();

                        // Duration Type

                        if (! empty($this->input->post('start_date', true))) {
                            $data_arr['start_date'] = $this->input->post('start_date', true);
                        }

                        if (! empty($this->input->post('end_date', true))) {
                            $data_arr['end_date'] = $this->input->post('end_date', true);
                        }

                        if (! empty($this->input->post('durationType', true))) {
                            $data_arr['duration_type'] = $this->input->post('durationType', true);
                        }

                        // Duration Type

                        if (! empty($this->input->post('batchType', true))) {
                            $data_arr['batch_type'] = $this->input->post('batchType', true);
                        }

                        if (! empty($this->input->post('batchPrice', true))) {
                            $data_arr['batch_price'] = $this->input->post('batchPrice', true);
                        }

                        if (! empty($this->input->post('batchOfferPrice', true))) {
                            $data_arr['batch_offer_price'] = $this->input->post('batchOfferPrice', true);
                        }
                        if (! empty($this->input->post('batch_description', true))) {
                            $data_arr['description'] = $this->input->post('batch_description', true);
                        }
                        if (! empty($this->input->post('category', true))) {
                            $data_arr['cat_id'] = $this->input->post('category', true);
                        }
                        if (! empty($this->input->post('subcategory', true))) {
                            $data_arr['sub_cat_id'] = $this->input->post('subcategory', true);
                        }

                        $prevduration_type = $prevdata[0]['duration_type'];

                        if ($_POST['durationType'] == '2') {

                            $data_arr['total_validity'] = null;
                            $data_arr['validity_in']    = null;
                            $data_arr['batch_expiry']   = date('Y-m-d', strtotime($_POST['batch_expiry']));
                        }

                        if ($_POST['durationType'] == '1') {

                            $data_arr['total_validity'] = $_POST['total_validity'];
                            $data_arr['validity_in']    = $_POST['validity_in'];
                            $current                    = strtotime("now");
                            if ($_POST['validity_in'] == 'years') {
                                $years                = '+' . $_POST['total_validity'] . ' ' . 'years';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($years, $currenty));
                            }

                            if ($_POST['validity_in'] == 'months') {
                                $months               = '+' . $_POST['total_validity'] . ' ' . 'months';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($months, $current));
                            }

                            if ($_POST['validity_in'] == 'days') {
                                $days                 = '+' . $_POST['total_validity'] . ' ' . 'days';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($days, $current));
                            }

                            $data_arr['batch_expiry'] = null;

                        }

                        if ($_POST['durationType'] == '3') {

                            $data_arr['total_validity'] = null;
                            $data_arr['validity_in']    = null;
                            $data_arr['batch_expiry']   = null;

                        }

                        $data_arr['pay_mode'] = $_POST['payMode'];

                        //batch image upload
                        if (isset($_FILES['batch_image']) && ! empty($_FILES['batch_image']['name'])) {
                            $config['upload_path']   = './uploads/batch_image/';
                            $config['allowed_types'] = 'jpeg|jpg|png';
                            $config['max_size']      = '0';
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('batch_image')) {
                                $uploaddata = $this->upload->data();
                                $pic        = $uploaddata['raw_name'];
                                $pic_ext    = $uploaddata['file_ext'];
                                $image_name = $pic . '_' . date('ymdHis') . $pic_ext;
                                rename('./uploads/batch_image/' . $pic . $pic_ext, './uploads/batch_image/' . $image_name);
                                $data_arr['batch_image'] = $image_name;
                            } else {
                                $resp = ['status' => '0', 'msg' => $this->upload->display_errors()];
                                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
                                die();
                            }
                        }

                        $data_arr = $this->security->xss_clean($data_arr);
                        //print_r($data_arr);
                        //die();

                        $access_data['annoucement']   = $this->input->post('annoucement', true);
                        $access_data['liveclass']     = $this->input->post('liveclass', true);
                        $access_data['mcq']           = $this->input->post('mcq', true);
                        $access_data['upcoming_exam'] = $this->input->post('upcoming_exam', true);
                        $access_data['video_lecture'] = $this->input->post('video_lecture', true);
                        $access_data['assignment']    = $this->input->post('assignment', true);
                        $access_data['extra_classes'] = $this->input->post('extra_classes', true);
                        $access_data['doubts']        = $this->input->post('doubts', true);
                        $access_data['attendace']     = $this->input->post('attendace', true);
                        $access_data['book']          = $this->input->post('book', true);
                        $access_data['notes']         = $this->input->post('notes', true);
                        $access_data['old_paper']     = $this->input->post('old_paper', true);
                        $access_data['syllabus']      = $this->input->post('syllabus', true);
                        $access_data['audio']         = $this->input->post('audio', true);

                        $data_arr['access'] = json_encode($access_data);

                        $ins = $this->db_model->update_data_limit('batches', $data_arr, ['id' => $this->input->post('batch_id', true)], 1);

                        if ($ins == true) {

                            $batch_id = $this->input->post('batch_id');
                            $this->db_model->delete_data('batch_subjects', ['batch_id' => $batch_id]);

                            $data = $this->input->post();

                            for ($i = 0; $i < count($data['batch_subject']); $i++) {
                                $teacher_id  = $data['batch_teacher'][$i];
                                $subjectData = [
                                    'batch_id'       => $batch_id,
                                    'teacher_id'     => $teacher_id,
                                    'subject_id'     => $data['batch_subject'][$i],
                                    'chapter'        => json_encode(json_decode($data['batch_chapter'], true)[$i]),
                                    'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                    'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                    'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                    'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                ];

                                $this->db_model->insert_data('batch_subjects', $subjectData);

                                $teacherData = $this->db_model->select_data('id,teach_batch', 'users use index (id)', ['id' => $teacher_id], 1);

                                if (! empty($teacherData)) {
                                    if (! empty($teacherData[0]['teach_batch'])) {
                                        $newBatch = array_unique(array_merge(explode(',', $teacherData[0]['teach_batch']), [$batch_id]));
                                    } else {
                                        $newBatch = [$batch_id];
                                    }

                                    $result = $this->db_model->update_data_limit('users', ['teach_batch' => implode(',', $newBatch)], ['id' => $teacherData[0]['id']], 1);

                                }
                            }

                            $previous_video = $this->input->post('previous_video');

                            // if ($previous_video != '') {

                            //     foreach ($previous_video as $previous_video_val) {

                            //         $video_lectures_list = $this->db_model->select_data('*', 'video_lectures', ['id' => $previous_video_val]);

                            //         if (! empty($video_lectures_list)) {

                            //             $video_lectures_data['admin_id']       = $video_lectures_list[0]['admin_id'];
                            //             $video_lectures_data['title']          = $video_lectures_list[0]['title'];
                            //             $video_lectures_data['batch']          = $batch_id;
                            //             $video_lectures_data['topic']          = $video_lectures_list[0]['topic'];
                            //             $video_lectures_data['subject']        = $video_lectures_list[0]['subject'];
                            //             $video_lectures_data['description']    = $video_lectures_list[0]['description'];
                            //             $video_lectures_data['url']            = $video_lectures_list[0]['url'];
                            //             $video_lectures_data['video_type']     = $video_lectures_list[0]['video_type'];
                            //             $video_lectures_data['preview_type']   = $video_lectures_list[0]['preview_type'];
                            //             $video_lectures_data['status']         = $video_lectures_list[0]['status'];
                            //             $video_lectures_data['added_by']       = $video_lectures_list[0]['added_by'];
                            //             $video_lectures_data['added_at']       = $video_lectures_list[0]['added_at'];
                            //             $video_lectures_data['comment_status'] = $video_lectures_list[0]['comment_status'];

                            //             $this->db_model->insert_data('video_lectures', $video_lectures_data);

                            //             $video_subject_list = $this->db_model->select_data('*', 'subjects', ['subject_name' => $video_lectures_list[0]['subject']]);
                            //             $video_chapter_list = $this->db_model->select_data('*', 'chapters', ['chapter_name' => $video_lectures_list[0]['topic']]);

                            //             $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $video_subject_list[0]['id'], 'batch_id' => $batch_id]);
                            //             if (empty($checkBatchExist)) {
                            //                 $export_subjectData = [
                            //                     'batch_id'       => $batch_id,
                            //                     'teacher_id'     => $teacher_id,
                            //                     'subject_id'     => $video_subject_list[0]['id'],
                            //                     'chapter'        => '[' . json_encode($video_chapter_list[0]['id']) . ']',
                            //                     'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                            //                     'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                            //                     'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                            //                     'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                            //                 ];

                            //                 $this->db_model->insert_data('batch_subjects', $export_subjectData);
                            //             }
                            //             $this->db_model->delete_data('video_lectures', ['batch' => $batch_id, 'id' => $previous_video_val]);
                            //         }

                            //     }
                            // }

                            $previous_older_papper = $this->input->post('previous_older_papper');

                            if ($previous_older_papper != '') {

                                foreach ($previous_older_papper as $previous_older_papper_val) {
                                    $previous_older_papper_list = $this->db_model->select_data('*', 'old_paper_pdf', ['id' => $previous_older_papper_val]);

                                    if (! empty($previous_older_papper_list)) {

                                        $previous_older_papper_data['admin_id']  = $previous_older_papper_list[0]['admin_id'];
                                        $previous_older_papper_data['title']     = $previous_older_papper_list[0]['title'];
                                        $previous_older_papper_data['batch']     = '[' . json_encode($batch_id) . ']';
                                        $previous_older_papper_data['topic']     = $previous_older_papper_list[0]['topic'];
                                        $previous_older_papper_data['subject']   = $previous_older_papper_list[0]['subject'];
                                        $previous_older_papper_data['file_name'] = $previous_older_papper_list[0]['file_name'];
                                        $previous_older_papper_data['status']    = $previous_older_papper_list[0]['status'];
                                        $previous_older_papper_data['added_by']  = $previous_older_papper_list[0]['added_by'];
                                        $previous_older_papper_data['added_at']  = $previous_older_papper_list[0]['added_at'];

                                        $this->db_model->insert_data('old_paper_pdf', $previous_older_papper_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_older_papper_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => $teacher_id,
                                                'subject_id'     => $previous_older_papper_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_older_papper_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }

                                        $this->db_model->delete_data('old_paper_pdf', ['id' => $previous_older_papper_val, 'batch' => '[' . json_encode($batch_id) . ']']);
                                    }

                                }
                            }

                            $previous_book = $this->input->post('previous_book');

                            if ($previous_book != '') {

                                foreach ($previous_book as $previous_book_val) {
                                    $previous_book_list = $this->db_model->select_data('*', 'book_pdf', ['id' => $previous_book_val]);

                                    if (! empty($previous_book_list)) {

                                        $previous_book_data['admin_id']  = $previous_book_list[0]['admin_id'];
                                        $previous_book_data['title']     = $previous_book_list[0]['title'];
                                        $previous_book_data['batch']     = '[' . json_encode($batch_id) . ']';
                                        $previous_book_data['topic']     = $previous_book_list[0]['topic'];
                                        $previous_book_data['subject']   = $previous_book_list[0]['subject'];
                                        $previous_book_data['file_name'] = $previous_book_list[0]['file_name'];
                                        $previous_book_data['status']    = $previous_book_list[0]['status'];
                                        $previous_book_data['added_by']  = $previous_book_list[0]['added_by'];
                                        $previous_book_data['added_at']  = $previous_book_list[0]['added_at'];
                                        $previous_book_data['type']      = $previous_book_list[0]['type'];
                                        $previous_book_data['parent_id'] = $previous_book_list[0]['parent_id'];

                                        $this->db_model->insert_data('book_pdf', $previous_book_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_book_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => $teacher_id,
                                                'subject_id'     => $previous_book_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_book_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }

                                        $this->db_model->delete_data('book_pdf', ['id' => $previous_book_val, 'batch' => '[' . json_encode($batch_id) . ']']);
                                    }

                                }
                            }

                            $previous_notes = $this->input->post('previous_notes');

                            if ($previous_notes != '') {

                                foreach ($previous_notes as $previous_notes_val) {
                                    $previous_notes_list = $this->db_model->select_data('*', 'notes_pdf', ['id' => $previous_notes_val]);

                                    if (! empty($previous_notes_list)) {

                                        $previous_notes_data['admin_id']  = $previous_notes_list[0]['admin_id'];
                                        $previous_notes_data['title']     = $previous_notes_list[0]['title'];
                                        $previous_notes_data['batch']     = '[' . json_encode($batch_id) . ']';
                                        $previous_notes_data['topic']     = $previous_notes_list[0]['topic'];
                                        $previous_notes_data['subject']   = $previous_notes_list[0]['subject'];
                                        $previous_notes_data['file_name'] = $previous_notes_list[0]['file_name'];
                                        $previous_notes_data['status']    = $previous_notes_list[0]['status'];
                                        $previous_notes_data['added_by']  = $previous_notes_list[0]['added_by'];
                                        $previous_notes_data['added_at']  = $previous_notes_list[0]['added_at'];

                                        $this->db_model->insert_data('notes_pdf', $previous_notes_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_notes_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => $teacher_id,
                                                'subject_id'     => $previous_notes_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_notes_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }
                                        $this->db_model->delete_data('notes_pdf', ['id' => $previous_notes_val, 'batch' => '[' . json_encode($batch_id) . ']']);
                                    }

                                }
                            }

                            // batch fecherd add
                            if (! empty($data['batch_speci_heading'])) {
                                for ($i = 0; $i < count($data['batch_speci_heading']); $i++) {
                                    $speci_heading = [
                                        'batch_id'                    => $batch_id,
                                        'batch_specification_heading' => $data['batch_speci_heading'][$i],
                                        'batch_fecherd'               => json_encode(json_decode($data['batch_sub_fecherd'], true)[$i]),
                                    ];
                                    if (! empty($data['batch_speci_id'][$i])) {
                                        $this->db_model->update_data_limit('batch_fecherd', $speci_heading, ['id' => $data['batch_speci_id'][$i]]);
                                    } else {
                                        $this->db_model->insert_data('batch_fecherd', $speci_heading);
                                    }
                                }
                            }

                            $resp = ['status' => '1', 'msg' => $this->lang->line('ltr_batch_updated_msg'), 'url' => base_url('admin/batch-manage')];
                        } else {
                            $resp = ['status' => '0'];
                        }
                    } else {
                        $resp = ['status' => '2', 'msg' => $this->lang->line('ltr_batch_name_already_msg')];
                    }
                } else {

                    if (empty($prevdata)) {
                        $data_arr = [
                            'batch_name' => $this->input->post('batch_name', true),
                            'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                            'end_date'   => date('Y-m-d', strtotime($this->input->post('end_date'))),
                            'start_time' => date('H:i:s', strtotime($this->input->post('start_time', true))),
                            'end_time'   => date('H:i:s', strtotime($this->input->post('end_time', true))),
                            'status'     => 1,
                            'admin_id'   => $this->session->userdata('uid'),
                        ];
                        if (! empty($this->input->post('batchType', true))) {
                            $data_arr['batch_type'] = $this->input->post('batchType', true);
                        }

                        // Duration Type

                        if (! empty($this->input->post('durationType', true))) {
                            $data_arr['duration_type'] = $this->input->post('durationType', true);
                        }

                        // Duration Type

                        if (! empty($this->input->post('batchPrice', true))) {
                            $data_arr['batch_price'] = $this->input->post('batchPrice', true);
                        }

                        if (! empty($this->input->post('batchOfferPrice', true))) {
                            $data_arr['batch_offer_price'] = $this->input->post('batchOfferPrice', true);
                        }

                        if (! empty($this->input->post('batch_description', true))) {
                            $data_arr['description'] = $this->input->post('batch_description', true);
                        }
                        if (! empty($this->input->post('category', true))) {
                            $data_arr['cat_id'] = $this->input->post('category', true);
                        }
                        if (! empty($this->input->post('subcategory', true))) {
                            $data_arr['sub_cat_id'] = $this->input->post('subcategory', true);
                        }

                        //batch image upload
                        if (isset($_FILES['batch_image']) && ! empty($_FILES['batch_image']['name'])) {
                            $config['upload_path']   = './uploads/batch_image/';
                            $config['allowed_types'] = 'jpeg|jpg|png';
                            $config['max_size']      = '0';
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('batch_image')) {
                                $uploaddata = $this->upload->data();
                                $pic        = $uploaddata['raw_name'];
                                $pic_ext    = $uploaddata['file_ext'];
                                $image_name = $pic . '_' . date('ymdHis') . $pic_ext;
                                rename('./uploads/batch_image/' . $pic . $pic_ext, './uploads/batch_image/' . $image_name);
                                $data_arr['batch_image'] = $image_name;
                            } else {
                                $resp = ['status' => '0', 'msg' => $this->upload->display_errors()];
                                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
                                die();
                            }
                        }
                        $data_arr['pay_mode'] = $_POST['payMode'];

                        if ($_POST['durationType'] == '2') {

                            $data_arr['total_validity'] = null;
                            $data_arr['validity_in']    = null;
                            $data_arr['batch_expiry']   = date('Y-m-d', strtotime($_POST['batch_expiry']));
                        }

                        if ($_POST['durationType'] == '1') {

                            $data_arr['total_validity'] = $_POST['total_validity'];
                            $data_arr['validity_in']    = $_POST['validity_in'];
                            $current                    = strtotime("now");
                            if ($_POST['validity_in'] == 'years') {
                                $years                = '+' . $_POST['total_validity'] . ' ' . 'years';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($years, $currenty));
                            }

                            if ($_POST['validity_in'] == 'months') {
                                $months               = '+' . $_POST['total_validity'] . ' ' . 'months';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($months, $current));
                            }

                            if ($_POST['validity_in'] == 'days') {
                                $days                 = '+' . $_POST['total_validity'] . ' ' . 'days';
                                $data_arr['end_date'] = date("Y-m-d", strtotime($days, $current));
                            }

                            $data_arr['batch_expiry'] = null;

                        }

                        if ($_POST['durationType'] == '3') {

                            $data_arr['total_validity'] = null;
                            $data_arr['validity_in']    = null;
                            $data_arr['batch_expiry']   = null;

                        }

                        $data_arr = $this->security->xss_clean($data_arr);

                        $access_data['annoucement']   = $this->input->post('annoucement', true);
                        $access_data['liveclass']     = $this->input->post('liveclass', true);
                        $access_data['mcq']           = $this->input->post('mcq', true);
                        $access_data['upcoming_exam'] = $this->input->post('upcoming_exam', true);
                        $access_data['video_lecture'] = $this->input->post('video_lecture', true);
                        $access_data['assignment']    = $this->input->post('assignment', true);
                        $access_data['extra_classes'] = $this->input->post('extra_classes', true);
                        $access_data['doubts']        = $this->input->post('doubts', true);
                        $access_data['attendace']     = $this->input->post('attendace', true);
                        $access_data['book']          = $this->input->post('book', true);
                        $access_data['notes']         = $this->input->post('notes', true);
                        $access_data['old_paper']     = $this->input->post('old_paper', true);
                        $access_data['syllabus']      = $this->input->post('syllabus', true);
                        $access_data['audio']         = $this->input->post('audio', true);

                        $data_arr['access'] = json_encode($access_data);

                        $ins = $this->db_model->insert_data('batches', $data_arr);

                        if ($ins) {
                            $batch_id = $this->db->insert_id();

                            $copy_export_batch = $this->input->post('copy_export_batch');

                            $data = $this->input->post();
                            for ($i = 0; $i < count($data['batch_subject']); $i++) {
                                $teacher_id  = $data['batch_teacher'][$i];
                                $teacherData = $this->db_model->select_data('id,teach_batch', 'users use index (id)', ['id' => $teacher_id], 1);

                                if (! empty($teacherData)) {
                                    if (! empty($teacherData[0]['teach_batch'])) {
                                        $newBatch = array_unique(array_merge(explode(',', $teacherData[0]['teach_batch']), [$batch_id]));
                                    } else {
                                        $newBatch = [$batch_id];
                                    }

                                    $this->db_model->update_data_limit('users', ['teach_batch' => implode(',', $newBatch)], ['id' => $teacherData[0]['id']], 1);
                                }

                                $subjectData = [
                                    'batch_id'       => $batch_id,
                                    'teacher_id'     => $teacher_id,
                                    'subject_id'     => $data['batch_subject'][$i],
                                    'chapter'        => json_encode(json_decode($data['batch_chapter'], true)[$i]),
                                    'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                    'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                    'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                    'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                ];

                                $this->db_model->insert_data('batch_subjects', $subjectData);
                            }

                            $previous_video = $this->input->post('previous_video');

                            if ($previous_video != '') {

                                foreach ($previous_video as $previous_video_val) {
                                    $video_lectures_list = $this->db_model->select_data('*', 'video_lectures', ['id' => $previous_video_val]);

                                    if (! empty($video_lectures_list)) {

                                        $video_lectures_data['admin_id']       = $video_lectures_list[0]['admin_id'];
                                        $video_lectures_data['title']          = $video_lectures_list[0]['title'];
                                        $video_lectures_data['batch']          = $batch_id;
                                        $video_lectures_data['topic']          = $video_lectures_list[0]['topic'];
                                        $video_lectures_data['subject']        = $video_lectures_list[0]['subject'];
                                        $video_lectures_data['description']    = $video_lectures_list[0]['description'];
                                        $video_lectures_data['url']            = $video_lectures_list[0]['url'];
                                        $video_lectures_data['video_type']     = $video_lectures_list[0]['video_type'];
                                        $video_lectures_data['preview_type']   = $video_lectures_list[0]['preview_type'];
                                        $video_lectures_data['status']         = $video_lectures_list[0]['status'];
                                        $video_lectures_data['added_by']       = $video_lectures_list[0]['added_by'];
                                        $video_lectures_data['added_at']       = $video_lectures_list[0]['added_at'];
                                        $video_lectures_data['comment_status'] = $video_lectures_list[0]['comment_status'];

                                        $this->db_model->insert_data('video_lectures', $video_lectures_data);

                                        $video_subject_list = $this->db_model->select_data('*', 'subjects', ['subject_name' => $video_lectures_list[0]['subject']]);
                                        $video_chapter_list = $this->db_model->select_data('*', 'chapters', ['chapter_name' => $video_lectures_list[0]['topic']]);
                                        $checkBatchExist    = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $video_subject_list[0]['id'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => 0,
                                                'subject_id'     => $video_subject_list[0]['id'],
                                                'chapter'        => '[' . json_encode($video_chapter_list[0]['id']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }
                                    }

                                }
                            }

                            $previous_older_papper = $this->input->post('previous_older_papper');

                            if ($previous_older_papper != '') {
                                foreach ($previous_older_papper as $previous_older_papper_val) {
                                    $previous_older_papper_list = $this->db_model->select_data('*', 'old_paper_pdf', ['id' => $previous_older_papper_val]);

                                    if (! empty($previous_older_papper_list)) {

                                        $previous_older_papper_data['admin_id']  = $previous_older_papper_list[0]['admin_id'];
                                        $previous_older_papper_data['title']     = $previous_older_papper_list[0]['title'];
                                        $previous_older_papper_data['batch']     = '["' . json_encode($batch_id) . '"]';
                                        $previous_older_papper_data['topic']     = $previous_older_papper_list[0]['topic'];
                                        $previous_older_papper_data['subject']   = $previous_older_papper_list[0]['subject'];
                                        $previous_older_papper_data['file_name'] = $previous_older_papper_list[0]['file_name'];
                                        $previous_older_papper_data['status']    = $previous_older_papper_list[0]['status'];
                                        $previous_older_papper_data['added_by']  = $previous_older_papper_list[0]['added_by'];
                                        $previous_older_papper_data['added_at']  = $previous_older_papper_list[0]['added_at'];

                                        $this->db_model->insert_data('old_paper_pdf', $previous_older_papper_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_older_papper_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => 0,
                                                'subject_id'     => $previous_older_papper_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_older_papper_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }
                                    }

                                }
                            }

                            $previous_book = $this->input->post('previous_book');

                            if ($previous_book != '') {
                                foreach ($previous_book as $previous_book_val) {
                                    $previous_book_list = $this->db_model->select_data('*', 'book_pdf', ['id' => $previous_book_val]);

                                    if (! empty($previous_book_list)) {

                                        $previous_book_data['admin_id']  = $previous_book_list[0]['admin_id'];
                                        $previous_book_data['title']     = $previous_book_list[0]['title'];
                                        $previous_book_data['batch']     = '["' . json_encode($batch_id) . '"]';
                                        $previous_book_data['topic']     = $previous_book_list[0]['topic'];
                                        $previous_book_data['subject']   = $previous_book_list[0]['subject'];
                                        $previous_book_data['file_name'] = $previous_book_list[0]['file_name'];
                                        $previous_book_data['status']    = $previous_book_list[0]['status'];
                                        $previous_book_data['added_by']  = $previous_book_list[0]['added_by'];
                                        $previous_book_data['added_at']  = $previous_book_list[0]['added_at'];
                                        $previous_book_data['type']      = $previous_book_list[0]['type'];
                                        $previous_book_data['parent_id'] = $previous_book_list[0]['parent_id'];

                                        $this->db_model->insert_data('book_pdf', $previous_book_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_book_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => 0,
                                                'subject_id'     => $previous_book_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_book_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }
                                    }

                                }
                            }

                            $previous_notes = $this->input->post('previous_notes');

                            if ($previous_notes != '') {
                                foreach ($previous_notes as $previous_notes_val) {
                                    $previous_notes_list = $this->db_model->select_data('*', 'notes_pdf', ['id' => $previous_notes_val]);

                                    if (! empty($previous_notes_list)) {

                                        $previous_notes_data['admin_id']  = $previous_notes_list[0]['admin_id'];
                                        $previous_notes_data['title']     = $previous_notes_list[0]['title'];
                                        $previous_notes_data['batch']     = '["' . json_encode($batch_id) . '"]';
                                        $previous_notes_data['topic']     = $previous_notes_list[0]['topic'];
                                        $previous_notes_data['subject']   = $previous_notes_list[0]['subject'];
                                        $previous_notes_data['file_name'] = $previous_notes_list[0]['file_name'];
                                        $previous_notes_data['status']    = $previous_notes_list[0]['status'];
                                        $previous_notes_data['added_by']  = $previous_notes_list[0]['added_by'];
                                        $previous_notes_data['added_at']  = $previous_notes_list[0]['added_at'];

                                        $this->db_model->insert_data('notes_pdf', $previous_notes_data);

                                        $checkBatchExist = $this->db_model->select_data('*', 'batch_subjects', ['subject_id' => $previous_notes_list[0]['subject'], 'batch_id' => $batch_id]);
                                        if (empty($checkBatchExist)) {
                                            $export_subjectData = [
                                                'batch_id'       => $batch_id,
                                                'teacher_id'     => 0,
                                                'subject_id'     => $previous_notes_list[0]['subject'],
                                                'chapter'        => '[' . json_encode($previous_notes_list[0]['topic']) . ']',
                                                'sub_start_date' => date('Y-m-d', strtotime($data['sub_start_date'][$i])),
                                                'sub_end_date'   => date('Y-m-d', strtotime($data['sub_end_date'][$i])),
                                                'sub_start_time' => date('H:i:s', strtotime($data['sub_start_time'][$i])),
                                                'sub_end_time'   => date('H:i:s', strtotime($data['sub_end_time'][$i])),
                                            ];

                                            $this->db_model->insert_data('batch_subjects', $export_subjectData);
                                        }
                                    }
                                }
                            }

                            // batch fecherd add
                            if (! empty($data['batch_speci_heading'])) {
                                for ($i = 0; $i < count($data['batch_speci_heading']); $i++) {
                                    $speci_heading = [
                                        'batch_id'                    => $batch_id,
                                        'batch_specification_heading' => $data['batch_speci_heading'][$i],
                                        'batch_fecherd'               => json_encode(json_decode($data['batch_sub_fecherd'], true)[$i]),
                                    ];

                                    $this->db_model->insert_data('batch_fecherd', $speci_heading);
                                }
                            }

                            $resp = ['status' => '1', 'msg' => 'Batch added successfully.', 'url' => base_url('admin/batch-manage')];
                        } else {
                            $resp = ['status' => '0'];
                        }
                    } else {
                        $resp = ['status' => '2', 'msg' => $this->lang->line('ltr_batch_name_already_msg')];
                    }
                }

            }
            echo json_encode($resp, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function playlist_table($videoID)
    {
        // Display errors for debugging (Remove these lines in production)
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            $post = $this->input->post(null, true);
            $get  = $this->input->get(null, true);
            $role = $this->session->userdata('role');

            $cond = '';

            // Handle pagination
            if (isset($post['length']) && $post['length'] > 0) {
                $limit = [$post['length'], $post['start']];
                $count = $post['start'] + 1;
            } else {
                $limit = '';
                $count = 1;
            }

            // Handle search
            if ($post['search']['value'] != '') {
                $like = ['title', $post['search']['value']];
            } else {
                $like = '';
            }

            // Fetch data from the database
            $playList = $this->db_model->select_data('*', 'tbl_playlist use index (id)', ['video_id' => $videoID], $limit, ['serial_number', 'asc'], $like, '', '', '');

            if (! empty($playList)) {
                $dataarray = [];
                foreach ($playList as $vid) {
                    // Build action buttons and status drop-down based on role
                    $action = "
                        <a class='viewVideo btn_view' title='View' data-id='" . $vid["id"] . "' data-id='" . $vid["id"] . "'  data-url='" . base_url($vid["video_file"]) . "' ><i class='fa fa-eye'></i></a>
                        <a class='deleteData btn_delete' title='Delete' data-id='" . $vid["id"] . "' data-table='tbl_playlist'><i class='fa fa-trash'></i></a>
                        </p>";

                    $viewVideo = "<a style='color:black' class='viewVideo btn_view' title='View' data-id='" . $vid["id"] . "' data-id='" . $vid["id"] . "'  data-url='" . base_url($vid["video_file"]) . "' >View Video</a>";

                    $dataarray[] = [
                        'DT_RowId' => 'DT_RowId_' . $vid['id'],
                        '<input type="checkbox" class="checkOneRow" value="' . $vid['id'] . '">',
                        $count,
                        $vid['serial_number'],
                        $viewVideo,
                        $action,
                    ];
                    $count++;
                }

                // Total records count
                $recordsTotal = $this->db_model->countAll('tbl_playlist use index (id)', ['video_id', $videoID], '', '', $like, '', '', '');

                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "data"            => $dataarray,
                ];
            } else {
                $output = [
                    "draw"            => $post['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => [],
                ];
            }

            echo json_encode($output, JSON_UNESCAPED_SLASHES);
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

    public function upload_media_new($files, $path, $file)
    {
        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpeg|jpg|png|SVG|svg|avi|mpeg|mp3|mp4|3gp';
        $config['max_size']      = '2048000';
        $filename                = '';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file)) {
            $uploadData = $this->upload->data();
            $filename   = $uploadData['file_name'];
            return $filename;
        } else {
            $resp = ['status' => '2', 'msg' => $this->upload->display_errors()];
            return $resp;
        }
    }

    public function add_play_list()
    {
        /*ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);*/
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if (! empty($this->input->post('title', true))) {
                $data_arr = $this->input->post();

                if (isset($_FILES['video_file']) && ! empty($_FILES['video_file']['name'])) {
                    $image = $this->upload_media_new($_FILES, 'uploads/video/', 'video_file');

                    if (is_array($image)) {
                        $resp = ['status' => '2', 'msg' => $image['msg']];
                        echo json_encode($resp, JSON_UNESCAPED_SLASHES);
                        die();
                    } else {
                        // $data_arr['url'] = base_url('uploads/video/').$image;
                        $data_arr['url'] = 'uploads/video/' . $image;
                    }
                }

                unset($data_arr['video_file']);
                if ($this->session->userdata('role') == 1) {
                    $data_arr['admin_id'] = $this->session->userdata('uid');
                } else {
                    $data_arr['admin_id'] = $this->session->userdata('admin_id');
                }

                $insert['serial_number'] = $data_arr['title'];
                $insert['video_id']      = $data_arr['video_id'];
                $insert['video_file']    = $data_arr['url'];
                $ins                     = $this->db_model->insert_data('tbl_playlist', $insert);

                if ($ins == true) {
                    $resp = ['status' => 1, 'msg' => "Playlist has been added"];
                } else {
                    $resp = ['status' => 0];
                }
                echo json_encode($resp, JSON_UNESCAPED_SLASHES);
            }
        } else {
            echo $this->lang->line('ltr_not_allowed_msg');
        }
    }

}
