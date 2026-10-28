<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
    function __construct()
    {
        
        error_reporting(0);
        parent::__construct();
        $timezoneDB = $this->db_model->select_data('timezone','site_details',array('id'=>1));
        if(isset($timezoneDB[0]['timezone']) && !empty($timezoneDB[0]['timezone'])){
            date_default_timezone_set($timezoneDB[0]['timezone']);
        }
		
			// check select language
		$this->load->helper('language');
		$language = $this->general_settings('language_name');
		if($language=="french"){
			$this->lang->load('french_lang', 'french');
		}else if($language=="arabic"){
			$this->lang->load('arabic_lang', 'arabic');
		}else{
			$this->lang->load('english_lang', 'english');
		}
    }
	
	
	function general_settings($key_text=''){
		$data = $this->db_model->select_data('*','general_settings',array('key_text'=>$key_text),1);
		return $data[0]['velue_text'];
	}
	
	function general_setting($key_text=''){
	    $data=array();
	    $data['languageName']=$this->general_settings('language_name');
	    $data['currencyCode']=$this->general_settings('currency_code');
	    $data['currencyDecimalCode']=$this->general_settings('currency_decimal_code');
	    $data['paymentType']=$this->general_settings('payment_type');
	    $data['razorpayKeyId']=$this->general_settings('razorpay_key_id');
	    $data['razorpaySecretKey']=$this->general_settings('razorpay_secret_key');
	    $data['paypalClientId']=$this->general_settings('paypal_client_id');
	    $data['paypalSecretKey']=$this->general_settings('paypal_secret_key');
	    $data['stripeSecretKey']=$this->general_settings('stripe_secret_key');
	    $data['stripePublishableKey']=$this->general_settings('stripe_publishable_key');
	    $data['payeeUpiId']=$this->general_settings('payee_upi_id');
	    $data['payeeMerchantCode']=$this->general_settings('payee_merchant_code');
	    $data['isReferralEnable']=$this->general_settings('isReferralEnable');

		$arr = array(
                    'status'=>'true',
                    'data'=>$data
                        );
        echo json_encode($arr);
	}
	
    function chekLogin(){
        $data = $_REQUEST;
        if(isset($data['student_id']) && isset($data['token'])){
            $student_id = trim($data['student_id']);
            $token  =  trim($data['token']);
            // $batch_id  =  trim($data['batch_id']);
            $studentDetails = $this->db_model->select_data('affiliate_id,login_status,status,token','students use index (id)',array('id'=>$student_id),1);
            $batch_details = $this->db_model->select_data('id,status','batches use index (id)',array('id'=>$batch_id),1);
            // 1 for last login, 2 for single device and 3 for multiple devices
            $deviceSetting = $this->general_settings('device_setting');
            
             if(!empty($studentDetails)){
                 if($studentDetails[0]['affiliate_id'] == ""){ 
                     do {
                        $referralCode = $this->random_strings(8);
                    } while (!$this->hasUniqueReferralCode($referralCode));
						
					$data_arr['affiliate_id']= $referralCode;
					
					$this->db_model->update_data_limit('students use index (id)',$data_arr,array('id'=>$data['student_id']),1);
					
                     
                 }
             }
            // if(($studentDetails[0]['status'] == 1) && ($studentDetails[0]['token'] == $token) && ($batch_details[0]['status'] == 1))
            // {
            if(($studentDetails[0]['status'] == 1) && ($studentDetails[0]['token'] == $token))
            {
                if($studentDetails[0]['login_status'] == 0){
                    $arr = array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_logout')
                    ); 
                }else{
					$l =$this->general_settings('language_name');
                    $arr = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_login_continue'),
							'languageName' => $l
							
                        );
                }
            }else{
                if($deviceSetting == 3){
                    $l =$this->general_settings('language_name');
                    $arr = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_login_continue'),
							'languageName' => $l
							
                        );
                }else{
                    $arr = array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_logout')
                    );
                }
                 
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    
    
        function getBundleCourseDetail(){
         /* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

        $data = $_REQUEST;
        if(isset($data['bundle_id']) ){
            $bundle_id = trim($data['bundle_id']);
            $studentID = $data['student_id'];
            $bundleDetails = $this->db_model->custom_single_query('SELECT * FROM tbl_bundles WHERE id = '.$bundle_id.' ');
             if(!empty($bundleDetails)){
                 $couponListing = $this->db_model->custom_query_data('SELECT coupon_code,discount_type,discount_percentage FROM coupons WHERE DATE(expiry_date) >= DATE(NOW()) ');
                 $siteDetail = $this->db_model->custom_query_data('SELECT isGST FROM site_details');
                 $bundleDetails->batch_image = base_url('uploads/bundle_image/').$bundleDetails->batch_image;
                 
                 if(isset($studentID) && !empty($studentID)){
                    $student_batch_dtail = $this->db_model->select_data('*','bundle_payments',array('student_id'=>$studentID,'bundle_id' => $bundle_id ),'');
    				if(!empty($student_batch_dtail)){
    					  $purchaseCondition = true;
    			    }else{
    					  $purchaseCondition = false;
    				}
                    
                } else{
                    $purchaseCondition = false;
                }
                
                
                $batchListing = array();
                 $bundle_batch = $this->db_model->select_data('tbl_bundle_batches.batch_id,','tbl_bundle_batches use index (id)',array('bundles_id'=>$bundle_id));
                 if(!empty($bundle_batch)){
                           foreach($bundle_batch as $val){
                               $batchData = $this->db_model->custom_single_query('SELECT id,batch_name FROM batches WHERE id ='. $val['batch_id'].' ');
                               $batchListing[] = $batchData;
                               
                           }
                }
                      
            
            
                 $arr = array(
                    'status'=>'true',
                    'isGST'=>$siteDetail[0]['isGST'],
                    'bundleDetail'=>$bundleDetails,
                    'coupon'=>$couponListing,
                    'batchList'=>$batchListing,
                    'purchaseCondition' =>$purchaseCondition,
                    'paymentType' => $this->general_settings('payment_type'),
                    'currencyCode' => $this->general_settings('currency_code'),
                ); 
             }else{
                 $arr = array(
                    'status'=>'false',
                    'message'=>'No bundle found!'
                );
             }
        }else{
            $arr = array(
                'status'=>'false',
                'message'=>'No bundle found!'
            ); 
        }
        echo json_encode($arr);
    }


    
    function getBatchDetail(){
         /* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

        $data = $_REQUEST;
        if(isset($data['batch_id']) ){
            $batch_id = trim($data['batch_id']);
            $studentID = $data['student_id'];
            $batchDetails = $this->db_model->custom_single_query('SELECT batches.id,batch_name,description,batch_image,validity_in,batch_category.name as categoryName,
            sub_cat_id,batch_subcategory.name as subCatName,
            batch_type,batch_price,batch_offer_price,duration_type,total_validity 
             FROM batches 
             LEFT JOIN batch_category ON batch_category.id = batches.cat_id
             LEFT JOIN batch_subcategory ON batch_subcategory.id = batches.sub_cat_id
             WHERE batches.id = '.$batch_id.' ');
             if(!empty($batchDetails)){
                 $couponListing = $this->db_model->custom_query_data('SELECT coupon_code,discount_type,discount_percentage FROM coupons WHERE DATE(expiry_date) >= DATE(NOW()) ');
                 $totalVideos = $this->db_model->custom_single_query('SELECT COUNT(id) as videoCount FROM video_lectures WHERE batch = '.$batch_id.' ');
                 $totalNotes = $this->db_model->custom_single_query('SELECT COUNT(id) as noteCount FROM notes_pdf WHERE batch  LIKE "%'.$batch_id.'%" ');
                 $totalOldPaper = $this->db_model->custom_single_query('SELECT COUNT(id) as oldPaperCount FROM old_paper_pdf WHERE batch  LIKE "%'.$batch_id.'%" ');
                 $totalBooks = $this->db_model->custom_single_query('SELECT COUNT(id) as bookCount FROM book_pdf WHERE batch  LIKE "%'.$batch_id.'%" ');
                 
                 $siteDetail = $this->db_model->custom_query_data('SELECT isGST FROM site_details');
                 
                 
                 $batchDetails->batch_image = base_url('uploads/batch_image/').$batchDetails->batch_image;
                 $totalItemsAvailable = $totalVideos->videoCount + $totalNotes->noteCount + $totalOldPaper->oldPaperCount + $totalBooks->bookCount;
                 $totalPDF = $totalNotes->noteCount + $totalOldPaper->oldPaperCount + $totalBooks->bookCount;
                
                if(isset($studentID) && !empty($studentID)){
                    $student_batch_dtail = $this->db_model->select_data('*','sudent_batchs',array('student_id'=>$studentID,'batch_id' => $batch_id ),'');
    				if(!empty($student_batch_dtail)){
    					  $purchaseCondition = true;
    			    }else{
    					  $purchaseCondition = false;
    				}
                    
                } else{
                    $purchaseCondition = false;
                }
                
                

                 $arr = array(
                    'status'=>'true',
                    'isGST'=>$siteDetail[0]['isGST'],
                    'batch'=>$batchDetails,
                    'coupon'=>$couponListing,
                    'totalVideos'=>$totalVideos->videoCount,
                    'totalNotes'=>$totalNotes->noteCount,
                    'totalOldPaper'=>$totalOldPaper->oldPaperCount,
                    'totalBooks'=>$totalBooks->bookCount,
                    'totalItemsAvailable' => $totalItemsAvailable,
                    'totalPDF'=>$totalPDF,
                    'purchaseCondition' =>$purchaseCondition,
                    'paymentType' => $this->general_settings('payment_type'),
                    'currencyCode' => $this->general_settings('currency_code'),

                ); 
             }else{
                 $arr = array(
                    'status'=>'false',
                    'message'=>'No batch found!'
                );
             }
        }else{
            $arr = array(
                'status'=>'false',
                'message'=>'No batch found!'
            ); 
        }
        echo json_encode($arr);
    }
    
    function getCoursePage(){
          /* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

        $data = $_REQUEST;
        if(isset($data['batch_id']) ){
            $batch_id = trim($data['batch_id']);
            $videoListing = $this->db_model->select_data('title,type', 'video_lectures use index (id)',array('status'=>1,'batch'=>$batch_id));
            //$videoListing =$this->db_model->select_data('title,type','book_pdf use index (id)',array('status'=>1,'batch'=>$batch_id),'',array('id','desc'),$like);

             
            $like = array('batch','"'.$batch_id.'"');
    		$book_pdf =$this->db_model->select_data('title,type','book_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
    		
    		$note_pdf =$this->db_model->select_data('title,type','notes_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
    		
    		$old_paper =$this->db_model->select_data('title,type','old_paper_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
    		    
                 $arr = array(
                    'status'=>'true',
                    'videoListing'=>$videoListing,
                    'book_pdf'=>$book_pdf,
                    'note_pdf'=>$note_pdf,
                    'old_paper'=>$old_paper,
                ); 
        }else{
            $arr = array(
                'status'=>'false',
                'message'=>'No batch found!'
            ); 
        }
        echo json_encode($arr);
    }
    
    
    function getBatchBanner(){
           /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

        $data = $_REQUEST;
        if(isset($data['batch_id']) ){
            $batch_id = trim($data['batch_id']);
            $batchBanner = $this->db_model->custom_query_data('SELECT banner,click_action,type FROM batch_banners_details
            LEFT JOIN batch_banners ON batch_banners.id = batch_banners_details.batch_banners_id  WHERE (batch_id = "'.$batch_id.'" OR batch_id=0) ');
                 $arr = array(
                    'status'=>'true',
                    'data'=>$batchBanner
                ); 
        }else{
            $arr = array(
                'status'=>'false',
                'message'=>'No batch found!'
            ); 
        }
        echo json_encode($arr);
    }
    
    function getHomeBanner(){
           /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

            $homeBanner = $this->db_model->custom_query_data('SELECT banner,click_action,type FROM home_banners  WHERE status = 1 ');
                 $arr = array(
                    'status'=>'true',
                    'data'=>$homeBanner
                ); 
        
        echo json_encode($arr);
    }
    
     function getAffiliatedCode(){
        $data = $_REQUEST;
        if(isset($data['student_id']) ){
            $student_id = trim($data['student_id']);
            $studentDetails = $this->db_model->select_data('affiliate_id,login_status,status,token','students use index (id)',array('id'=>$student_id),1);
             if(!empty($studentDetails)){
                 if($studentDetails[0]['affiliate_id'] == ""){ 
                     do {
                        $referralCode = $this->random_strings(8);
                    } while (!$this->hasUniqueReferralCode($referralCode));
					$data_arr['affiliate_id']= $referralCode;
					$studentDetails[0]['affiliate_id'] = $referralCode;
					$this->db_model->update_data_limit('students use index (id)',$data_arr,array('id'=>$data['student_id']),1);
			     }
			     
    			 $arr = array(
                    'status'=>'true',
                    'affiliated'=>$studentDetails[0]['affiliate_id']
                ); 
             }
        }else{
            $arr = array(
                'status'=>'false',
                'affiliated'=>''
            ); 
        }
        echo json_encode($arr);
    }
    
    
    function login(){
             /*ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);*/

        $data = $_REQUEST;
        if(isset($data['username']) && isset($data['password']) && isset($data['versionCode'])  && isset($data['token'])){
            $uname = trim($data['username']);
            $pass = md5(trim($data['password']));
            $version= trim($data['versionCode']);
            $token= trim($data['token']);
            
            $token= trim($data['token']);
            $device_id= trim($data['device_id']);
            $device_name= trim($data['device_name']);
            $device_os_version= trim($data['device_os_version']);
            $app_version= trim($data['app_version']);
            

            $enroll_id = strtoupper($uname);
           
            if(!filter_var($enroll_id, FILTER_VALIDATE_EMAIL)){
                    $stud_cond = array('enrollment_id'=>$enroll_id,'password'=>$pass);
                }else{      
                    $stud_cond = array('email'=>$enroll_id,'password'=>$pass);
                }
            $studentDetails = $this->db_model->select_data('*','students use index (id)',$stud_cond,1);
           
            if(!empty($studentDetails)){
                if($studentDetails[0]['status'] == '1'){
                    $batch_details = $this->db_model->select_data('id,batch_name,batch_type','batches use index (id)',array('status'=>1,'id'=>$studentDetails[0]['batch_id']),1);
                    // if(!empty($batch_details)){
                    
                        // Check Device Setting
                        
                        // 1 for last login, 2 for single device and 3 for multiple devices
                        $deviceSetting = $this->general_settings('device_setting');
                        if(!empty($deviceSetting) && !empty($device_id)){
                            if($deviceSetting == 2){
                               $checkDevice = $this->db_model->select_data('id,device_id','devices use index (id)',array('student_id'=>$studentDetails[0]['id']),1);
                               if(empty($checkDevice)){
                                    $data_device['device_name'] = $data['device_name'];
                					$data_device['device_os_version'] = $data['device_os_version'];
                					$data_device['app_version'] = $data['app_version'];
                					$data_device['device_id'] = $data['device_id'];
                					$data_device['student_id'] = $studentDetails[0]['id'];
                					$this->db_model->insert_data('devices',$data_device);
						    
                                   
                               }else{
                                    if($checkDevice[0]['device_id'] != $device_id){
                                        $arr = array('status' => 'false', 'msg'=>'Seems you already logged in with other device, Please contact admin if you face any issue');
                                        echo json_encode($arr);
                                        die;
                                    }
                               }
                            }
                        }


                        $studentData = array(
                            'studentId' => $studentDetails[0]['id'], 
                            'userEmail' => $studentDetails[0]['email'],
                            'fullName' => $studentDetails[0]['name'],
                            'enrollmentId' => $studentDetails[0]['enrollment_id'],
                            'image' => base_url('uploads/students/').$studentDetails[0]['image'],
                            // 'image' => 'uploads/students/'.$studentDetails[0]['image'],
                            'country_code' => $studentDetails[0]['country_code'],
                            'mobile' => $studentDetails[0]['contact_no'],
                            'versionCode' => $studentDetails[0]['app_version'],
                            'batchId' => $studentDetails[0]['batch_id'],
                            'batchName'=>'',
                            'referred_by' => $studentDetails[0]['referred_by'],
                            'affiliate_id' => $studentDetails[0]['affiliate_id'],
                            'wallet' => $studentDetails[0]['wallet'],
                            'adminId' => $studentDetails[0]['admin_id'],
							'paymentType' => $this->general_settings('payment_type'),
                            'admissionDate' => date('d-m-Y',strtotime($studentDetails[0]['admission_date'])),
							'languageName'=>$this->general_settings('language_name')
                        );
						
						$fee_details = $this->db_model->select_data('*','student_payment_history',array('student_id'=>$studentDetails[0]['id'],'batch_id'=>$studentDetails[0]['batch_id']));
					
						    $studentData['transactionId'] = !empty($fee_details[0]['transaction_id'])?$fee_details[0]['transaction_id']:'';
					
        				$studentData['amount'] = !empty($fee_details[0]['amount'])?$fee_details[0]['amount']:'';
                        //update app version and login status                  
                        $this->db_model->update_data_limit('students use index (id)',array('login_status'=>1,'app_version'=>$version,'token'=>$token),array('id'=>$studentDetails[0]['id']),1);
                        $arr = array(
                                'studentData' => $studentData,
                                'status' => 'true',
                                'msg' => $this->lang->line('ltr_welcome').' '.$studentDetails[0]['name'],
                                 'token' => $token,
                                'student_id' => $studentDetails[0]['id']
                            );
                    // }else{
                    //     $arr = array('status' => 'false', 'msg'=>$this->lang->line('ltr_batch_in_msg'));
                    // }
                }else{
                    $arr = array('status' => 'false', 'msg'=>$this->lang->line('ltr_contact_to_admin_msg'));
                }
            }else{
                $arr = array('status' => 'false', 'msg'=> $this->lang->line('ltr_invalid_c'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }


   function my_course(){
        $data = $_REQUEST;
        if(isset($data['student_id'])){
            $student_id = trim($data['student_id']);
            
            // Verify student exists and is active
            $studentDetails = $this->db_model->select_data('status','students use index (id)',array('id'=>$student_id),1);
            
            if(!empty($studentDetails)){
                if($studentDetails[0]['status'] == 1){
                    // Get batches for the student using join with sudent_batchs table
                    $batches = $this->db_model->select_data('*', 'batches use index (id)', ['batches.status' => '1', 'sudent_batchs.student_id' => $student_id], '', '', '', ['sudent_batchs', 'sudent_batchs.batch_id=batches.id']);
                    
                    if(!empty($batches)){
                        // Truncate description to 150 characters
                        foreach($batches as $key => $value){
                            $description = $value['description'];
                            $chars = 150;
                            $count_word = strlen($description);
                            if($count_word > $chars){
                                $description = substr($description, 0, $chars);
                                $description = substr($description, 0, strrpos($description, ' '));
                            }
                            $batches[$key]['description'] = $description;
                            
                            // Add full image URL if batch_image exists
                            if(!empty($value['batch_image'])){
                                $batches[$key]['batch_image'] = base_url('uploads/batch_image/').$value['batch_image'];
                            }
                        }
                        
                        $currency_decimal = $this->general_settings('currency_decimal_code');
                        $site_Details = $this->db_model->select_data('*', 'site_details', ['id' => '1'], 1);
                        
                        $arr = array(
                            'status' => 'true',
                            'batches' => $batches,
                            'currency_decimal' => $currency_decimal,
                            'site_Details' => !empty($site_Details) ? $site_Details[0] : array()
                        );
                    } else {
                        $currency_decimal = $this->general_settings('currency_decimal_code');
                        $site_Details = $this->db_model->select_data('*', 'site_details', ['id' => '1'], 1);
                        
                        $arr = array(
                            'status' => 'true',
                            'batches' => array(),
                            'currency_decimal' => $currency_decimal,
                            'site_Details' => !empty($site_Details) ? $site_Details[0] : array()
                        );
                    }
                } else {
                    $arr = array(
                        'status' => 'false',
                        'msg' => $this->lang->line('ltr_contact_to_admin_msg')
                    );
                }
            } else {
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_invalid_c')
                );
            }
        } else {
            $arr = array(
                'status' => 'false',
                'msg' => $this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }

	function logout(){
        $data = $_REQUEST;
        if(isset($data['student_id'])){
            $student_id = $data['student_id'];
            $ins = $this->db_model->update_data_limit('students use index (id)',array('login_status'=>0),array('id'=>$student_id),1);
            if($ins){
                 $arr =	array('status'=>'true','msg'=>$this->lang->line('ltr_logged_out'));
            }else{
                 $arr =	array('status'=>'false','msg'=>$this->lang->line('ltr_failed_out'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
       	echo json_encode($arr);
    }
	

    function video_lecture_subjects(){
        $data = $_REQUEST;
        if(isset($data['student_id']) && isset($data['batch_id'])){
            $student_id = trim($data['student_id']);
            $batch_id = trim($data['batch_id']);
            
            // Ensure student is part of the batch
            $checkBatch = $this->db_model->select_data('id','sudent_batchs',array('student_id'=>$student_id,'batch_id'=>$batch_id),1);
            
            if(!empty($checkBatch)){
                $this->db->select('DISTINCT(subject) as subject');
                $this->db->from('video_lectures');
                $this->db->where('batch', $batch_id);
                $query = $this->db->get();
                $subjects = $query->result_array();

                 // Sort the subjects based on the numeric value at the start
                usort($subjects, function ($a, $b) {
                    preg_match('/^\s*(\d+)/', $a['subject'], $m1);
                    preg_match('/^\s*(\d+)/', $b['subject'], $m2);
                    
                    $num1 = isset($m1[1]) ? (int)$m1[1] : 0;
                    $num2 = isset($m2[1]) ? (int)$m2[1] : 0;
                    
                    return $num1 - $num2; // Ascending order
                });
                
                $arr = array(
                    'status' => 'true',
                    'subjects' => $subjects,
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_invalid_c')
                );
            }
        }else{
            $arr = array(
                'status' => 'false',
                'msg' => $this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }


    public function fetch_new_topics()
{
    // Get the subject and batch_id from the AJAX request (use GET or POST method as needed)
    $subject = $this->input->post('subject');
    $batch_id = $this->input->post('batch_id'); // Retrieve the batch_id from the request (not the session)

    // Validate the inputs
    if (empty($subject) || empty($batch_id)) {
        $response = array(
            'status' => 'false',
            'msg' => 'Missing subject or batch_id'
        );
        echo json_encode($response);
        return;
    }

    // Fetch topics from the 'video_lectures' table based on subject and batch_id
    $this->db->select('DISTINCT(topic)');
    $this->db->from('video_lectures');
    $this->db->where('subject', $subject);
    $this->db->where('batch', $batch_id);
    $query = $this->db->get();

    // Get the topics as an array
    $topics = $query->result_array();

    // If topics are found
    if (!empty($topics)) {
        $response = array(
            'status' => 'true',
            'topics' => $topics,
            'msg' => 'Topics fetched successfully'
        );
    } else {
        // If no topics found
        $response = array(
            'status' => 'false',
            'msg' => 'No topics found for the given subject and batch'
        );
    }

    // Set content type to JSON and return the response
    $this->output->set_content_type('application/json');
    echo json_encode($response);
}



public function fetch_titles()
{
    // Get subject and topic from the AJAX request
    $subject = $this->input->post('subject');
    $topic   = $this->input->post('topic');

    // Retrieve batch_id from session
    $batch_id = $this->input->post('batch_id');

    // Check if the necessary parameters are provided
    if (empty($subject) || empty($topic)) {
        // Missing parameters response
        $response = array(
            'status' => 'false',
            'msg' => 'Missing subject or topic'
        );
        echo json_encode($response);
        return;
    }

    // Corrected select statement to get video details based on subject, topic, and batch_id
    $this->db->select('title, url, video_type, description, id, thumbnail');
    $this->db->from('video_lectures');
    $this->db->where('subject', $subject);
    $this->db->where('topic', $topic);
    $this->db->where('batch', $batch_id); // Filter by batch_id
    $this->db->order_by('page_order', 'asc'); // Order by page_order (ascending)
    $query = $this->db->get();

    // Debugging: Check the generated SQL query
    $last_query = $this->db->last_query();
    log_message('debug', 'fetch_titles SQL Query: ' . $last_query); // Logs the query for debugging

    $result = $query->result_array();

    // Debugging: Check the fetched result
    log_message('debug', 'fetch_titles Result: ' . print_r($result, true)); // Logs the result for debugging

    // If no results are found
    if (!empty($result)) {
        $response = array(
            'status' => 'true',
            'titles' => $result,
            'msg' => 'Titles fetched successfully'
        );
    } else {
        $response = array(
            'status' => 'false',
            'msg' => 'No titles found for the given subject and topic'
        );
    }

    // Return the result as JSON
    echo json_encode($response);
}

function profile_detail(){
        $data = $_REQUEST;
        if(isset($data['student_id'])){
            $student_id = trim($data['student_id']);
            $profile = $this->db_model->select_data('id,name,email,image,batch_id,country_code,contact_no,enrollment_id,admin_id,student_state,student_city','students use index (id)',array('id'=>$student_id),1);
            if(!empty($profile)){
                $batchName = '';
                if(!empty($profile[0]['batch_id'])){
                    $batch = $this->db_model->select_data('batch_name','batches use index (id)',array('id'=>$profile[0]['batch_id']),1);
                    if(!empty($batch)){
                        $batchName = $batch[0]['batch_name'];
                    }
                }
                $profile[0]['batch_name'] = $batchName;
                if(!empty($profile[0]['image'])){
                    $profile[0]['image'] = base_url('uploads/students/').$profile[0]['image'];
                    // $profile[0]['image'] = 'uploads/students/'.$profile[0]['image'];
                }else{
                    //  $profile[0]['image'] = 'uploads/students/student_img.png';
                    $profile[0]['image'] = base_url('uploads/students/student_img.png');
                }
                $arr = array(
                    'status'=>'true',
                    'msg'=>$this->lang->line('ltr_fetch_successfully'),
                    'profile'=>$profile[0]
                );
            }else{
                $arr = array(
                    'status'=>'false',
                    'msg'=>$this->lang->line('ltr_invalid_c')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }




	function student_registration(){
	    
	            
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


            $data = $_REQUEST;
			$this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
			if(!empty($data['name']) && !empty($data['email']) && !empty($data['mobile'])){
			    
					$admin_ids =$this->db_model->select_data('id','users use index (id)',array('role'=>1),1)[0]['id'];
					
					$prevRecdEmail = $this->db_model->select_data('id,admin_id','students',array('email'=>$data['email']));
					
					$adm_id =$this->db_model->select_data('*','batches use index (id)',array('id'=>$data['batch_id']),1);
					if(empty($prevRecdEmail)){
					    $prevRecdMobile = $this->db_model->select_data('id,admin_id','students',array('contact_no'=>$data['mobile']));
					    if(empty($prevRecdMobile)){
						$siteData = array();
						$siteData['word_for_enroll'] = $this->common->enrollWord;
						if(!empty($adm_id)){
						    $admin_id = $adm_id[0]['admin_id'];
						}else{
						     $admin_id = 1;
						}
						$data_arr['admin_id'] =$admin_id;      
						$data_arr['login_status'] = 0;
						$lastrecord = $this->db_model->select_data('id','students use index (id)',array('admin_id'=>$admin_id),1,array('id','desc'));             
						if(!empty($lastrecord)){
							$last_id = $lastrecord[0]['id'];
						}else{
							$last_id = 0;
						}
						
						$password = $this->input->post('mobile',TRUE);
						$enrolid = $siteData['word_for_enroll'].$admin_id.$last_id.rand(10,100);
						$data_arr['name'] = $data['name'];
						$data_arr['email'] = $data['email'];
						$data_arr['batch_id'] = $data['batch_id'];
						$data_arr['added_by'] = 'student';
						$data_arr['status'] = 1;
						$data_arr['enrollment_id'] = $enrolid;
						$data_arr['password'] = md5($password);
						$data_arr['admission_date'] = date('Y-m-d');
						$data_arr['image']='student_img.png';
						$data_arr['country_code']=$this->input->post('country_code',TRUE);
						$data_arr['contact_no']=$this->input->post('mobile',TRUE);
						$data_arr['student_state']=$this->input->post('user_state',TRUE);
						$data_arr['student_city']=$this->input->post('student_city',TRUE);

						//update app version and login status
						$data_arr['login_status']= 1;
						$data_arr['last_login_app']= date("Y-m-d H:i:s");
						$data_arr['app_version']= !empty($data['versionCode'])? trim($data['versionCode']):'';
						$data_arr['token']= !empty($data['token'])? trim($data['token']):'';
						
						
						do {
                            $referralCode = $this->random_strings(8);
                        } while (!$this->hasUniqueReferralCode($referralCode));
						
						$data_arr['affiliate_id']= $referralCode;
						$data_arr['referred_by']= $this->findReferralId(!empty($data['refercode'])? trim($data['refercode']):'0');
					
						$data_arr = $this->security->xss_clean($data_arr);
				// 	die(); 
						$ins = $this->db_model->insert_data('students',$data_arr);
						if($ins){
						    
						    // Device Information
						    
						    $data_device['device_name'] = $data['device_name'];
        					$data_device['device_os_version'] = $data['device_os_version'];
        					$data_device['app_version'] = $data['app_version'];
        					$data_device['device_id'] = $data['device_id'];
        					$data_device['student_id'] = $ins;
        					$this->db_model->insert_data('devices',$data_device);
						    
							$studentData =$this->db_model->select_data('id as studentId,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token,referred_by,affiliate_id','students use index (id)',array('id'=>$ins),1);
							$studentData[0]['batchName']='';
							$studentData[0]['image']= base_url('uploads/students/').$studentData[0]['image'];
							$studentData[0]['password'] = $password;
							$studentData[0]['paymentType'] = $this->general_settings('payment_type');
							$studentData[0]['languageName'] = $this->general_settings('language_name');
							
							 //check batch type
							$batch_type =$this->db_model->select_data('*','batches use index (id)',array('id'=>$data['batch_id']),1);
        				    if(!empty($batch_type)){
            				    $admin_ids = $batch_type[0]['admin_id'];
        				    }else{
        				            $admin_ids = 0;
        				    }
        				    if($batch_type[0]['batch_type']==2){
        				        $studentData[0]['batchName']= $batch_type[0]['batch_name'];
    							
    							$refer_type = $this->general_settings('refer_type');
            					$refer_type_amount = $this->general_settings('refer_type_amount');
            					$commissionAmt = $refer_type_amount;
            					
            					if($refer_type == 2){
            					    $amount= !empty($data['amount'])?$data['amount']:0;
            					    $commissionAmt = ($amount * $refer_type_amount)/100;
            					}
            					
            					$walletAmount =$this->db_model->select_data('*','students use index (id)',array('id'=>$studentData[0]['referred_by']),1);
    					        $totalAmount = $walletAmount[0]['wallet'] + $commissionAmt;
            					
            					$this->db_model->update_data_limit('students use index (id)',array('wallet'=>$totalAmount),array('id'=>$studentData[0]['referred_by']),1);
            					
            					$data_pay=array(
    							          'student_id'=>$ins,
    								      'batch_id'=>$data['batch_id'],
    									  'transaction_id'=> !empty($data['transaction_id'])?$data['transaction_id']:'',
										  'amount'=> !empty($data['amount'])?$data['amount']:'',
										  'admin_id'=>$admin_ids,
										  'c_mode'=>$refer_type,
										  'comission'=>$commissionAmt,
								        );
    							$data_pay = $this->security->xss_clean($data_pay);
    							$insf = $this->db_model->insert_data('student_payment_history',$data_pay);
    							
            					$studentData[0]['transactionId'] = !empty($data['transaction_id'])?$data['transaction_id']:'';
            					
            				    $studentData[0]['amount'] = !empty($data['amount'])?$data['amount']:'';
        				    	$this->db_model->update_data_limit('students use index (id)',array('payment_status'=>1),array('id'=>$ins),1);
            				}else{
            				    $studentData[0]['batchName']= $batch_type[0]['batch_name'];
        				    	$studentData[0]['transactionId'] = 'free';
        				    	$studentData[0]['amount'] = !empty($amount)?$amount:'';
        				    }
        				    

						$arr = array('status'=>'true', 'msg' =>$this->lang->line('ltr_account_created'),'studentData'=>$studentData[0]);
						
						if(!empty($data['isBundleBuy']) && !empty($data['bundle_id']) && !empty($data['transaction_id'])){
        		            $bundle_data = $this->db_model->select_data('tbl_bundles.*','tbl_bundles use index (id)',array('id' => $data['bundle_id']));
                            if(!empty($bundle_data)){
                                $data_bundle_payments=array(
                					'student_id'=>$data['student_id'],
                					'bundle_id'=>$data['bundle_id'],
                					'transaction_id'=> $data['transaction_id'],
                					'price'=> $bundle_data[0]['price'],
                					'date'=> date('d-m-Y'),
                				);
            									
                                $this->db_model->insert_data('bundle_payments',$data_bundle_payments);
                                
                                $bundle_batch_list_array = $this->db_model->select_data('tbl_bundle_batches.batch_id','tbl_bundle_batches use index (id)',array('bundles_id' => $bundle_data[0]['id']));
                            
                                if(!empty($bundle_batch_list_array)){
                                    foreach($bundle_batch_list_array as $bundle_batch_list_array_val){
                                        
                                        $checkBatch =$this->db_model->select_data('*','sudent_batchs',array('batch_id'=>$bundle_batch_list_array_val['batch_id'],'student_id'=>$data['student_id']),1);
                                        if(empty($checkBatch)){
                                             $data_student_batch=array(
                        					'student_id'=>$ins,
                        					'batch_id'=>$bundle_batch_list_array_val['batch_id'],
                        					'status'=> 0,
                        					'added_by'=> 'student',
                        					'admin_id'=> 1,
                        					'batch_activation_id'=> 0,
                        				    );
                    								
                                            $this->db_model->insert_data('sudent_batchs',$data_student_batch);
                                        }
                                    }
                                }
                            }
                        }else{
                            
                            //batch asin
							if(!empty($data['batch_id']) && $data['batch_id']>0){
						    $data_batch= array(
						                 'student_id'=>$ins,
						                 'batch_id'=>$data['batch_id'],
						                 'added_by'=>'student',
						                 'admin_id'=>$admin_ids,
	        					                 );
					 	   $this->db_model->insert_data('sudent_batchs',$data_batch);
						}
					    // send email 
					    $title = $this->db_model->select_data('site_title','site_details','',1,array('id','desc'))[0]['site_title'];
                        $subj = $title.'- '.$this->lang->line('ltr_credentials');
                        $em_msg = $this->lang->line('ltr_hey').' '.ucwords($data['name']).', '.$this->lang->line('ltr_congratulation').' <br/><br/>'.$this->lang->line('ltr_successfully_enrolled').'<br/><br/>'.$this->lang->line('ltr_login_details').'<br/><br/> '.$this->lang->line('ltr_enrolment_id').' : '.$enrolid.'<br/><br/>'.$this->lang->line('ltr_password').' : '.$password.'';
                        $this->SendMail($data['email'], $subj, $em_msg);
                        
                            
                    }
                    
            	}
			}else{
					$arr = array(
					'status'=>'false',
					'msg'=>'mobile number already exist'
				);           
                          
					}
					
			}else{
				
                	$arr = array(
					'status'=>'false',
					'msg'=>$this->lang->line('ltr_email_already_msg')
				);           
                          
					}
				
				
			}else{
				$arr = array(
					'status'=>'false',
					'msg'=>$this->lang->line('ltr_missing_parameters_msg')
				); 
			}
			echo json_encode($arr);
		}
		function checkLanguage(){
			$language =$this->general_settings('language_name');
			if(!empty($language)){
					$arr = array('status'=>'true', 'msg' =>$this->lang->line('ltr_fetch_successfully'),'languageName'=>$language);
					
				}else{
					$arr = array('status'=>'false', 'msg' => $this->lang->line('ltr_no_record_msg')); 
				}
			echo json_encode($arr);
		}
		

    function get_chapter(){
        
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        $data = $_REQUEST;
        if(isset($data['subject_id'])){
             $getSubjectName = $this->db_model->select_data('subject_name','subjects use index (id)',array('id'=>$data['subject_id']));
             
             if($getSubjectName){
                 $sname = $getSubjectName[0]['subject_name'];
                 $fetchChapter = $this->db_model->custom_query_data('SELECT topic as chapterName FROM video_lectures where subject = "'.$sname.'" AND batch = '.$data['batch_subject_id'].' GROUP by topic  ORDER BY `video_lectures`.`subject` ASC');
                 
                 if(!empty($fetchChapter)){
                  $arr = array(
                    'chapter' => $fetchChapter,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                ); 
                }else{
                    $arr = array(
                        'status' => 'false',
                        'msg' => $this->lang->line('ltr_no_record_msg')
                    ); 
                }

             }else{
                 $arr = array(
                        'status' => 'false',
                        'msg' => $this->lang->line('ltr_no_record_msg')
                    ); 
             }

        
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }


    function get_batch_fee(){
        header('Content-type: application/json');
        
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        

			$data = $_REQUEST;
 			$this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
			$search = trim($data['search']);
		    $slider_limit = $data['limit'];
		    
			if(!empty($search)){
			  $like_search = array('batch_name',$search);
			}else{
			    $like_search = '';
			}
	
          if(isset($data['length']) && $data['length']>0){
                if(isset($data['start']) && !empty($data['start'])){
                    $limit = array($data['length'],$data['start']);
                    // $count = $data['start']+1;
                }else{ 
                    $limit = array($data['length'],0);
                    // $count = 1;
                }
            }else{
                $limit = '';
                // $count = 1;
            }
            
            
               
            //  bundle batch list start
               $bundleCourse = array();
            
			   $bundleCourse = $this->db_model->select_data('tbl_bundles.*,','tbl_bundles use index (id)');
               
               $batchListing = array();
               if(!empty($bundleCourse)){
                   
                   foreach($bundleCourse as $k=>$value){
                       $bundle_batch = $this->db_model->select_data('tbl_bundle_batches.batch_id,','tbl_bundle_batches use index (id)',array('bundles_id'=>$value['id']));
                       
                       if(!empty($bundle_batch)){
                           foreach($bundle_batch as $val){
                               $batchData = $this->db_model->select_data('id,batch_name','batches use index (id)',array('id'=>$val['batch_id']));
                               $batchListing[] = $batchData;
                               
                           }
                      }
                      
                      $bundleCourse[$k]['batchList'] = $batchListing;
                   }
                   
                 
               }
			// end
        				
			
            $category = $this->db_model->select_data('id as categoryId,name as categoryName','batch_category use index (id)',array('status'=>1),$limit);
					     if(!empty($category)){
					        
					        foreach($category as $catkey=>$value){
					                 
					   //  }
					   
					   // $cond="id not in ($batch_id) AND status=1 AND cat_id= $value['id']";
					   $cond = array('status'=>1,'cat_id'=>$value['categoryId']);
					   
					    $subCategory = $this->db_model->select_data('id as SubcategoryId,name as SubcategoryName','batch_subcategory use index (id)',$cond,'');
					   // echo $this->db->last_query();
					    if(!empty($subCategory)){
					        
					        foreach($subCategory as $subkey=>$value){
					    
					     
					   $cond_sub1 = array('status'=>1,'sub_cat_id'=>$value['SubcategoryId']);
					   
	            $batchData = $this->db_model->select_data('id, batch_name as batchName, start_date as startDate, end_date as endDate, start_time as startTime, end_time as endTime, batch_type as batchType, duration_type, total_validity, validity_in, batch_expiry, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice','batches use index (id)',$cond_sub1,$slider_limit,array('id','desc'),$like_search);
       
				if(!empty($batchData)){
					foreach($batchData as $key=>$value){
						if(!empty($value['batchImage'])){
							$batchData[$key]['batchImage']= base_url('uploads/batch_image/').$value['batchImage'];
						}
						$startDate =$value['startDate'];
						$endDate =$value['endDate'];
                        $batchData[$key]['startDate']=date('d-m-Y',strtotime($startDate));
                        $batchData[$key]['endDate']=date('d-m-Y',strtotime($endDate));
                        
                        $batchData[$key]['durationType']=$value['duration_type']."";
                        $batchData[$key]['totalValidity']=$value['total_validity']."";
                        $batchData[$key]['validityIn']=$value['validity_in']."";
                        $batchData[$key]['batchExpiry']=$value['batch_expiry']."";
                        $batchData[$key]['description']=$value['description']."";
                       
						$batch_fecherd =$this->db_model->select_data('batch_specification_heading as batchSpecification, batch_fecherd as fecherd','batch_fecherd',array('batch_id'=>$value['id']));
						if(!empty($batch_fecherd)){
							   $batchData[$key]['batchFecherd'] =$batch_fecherd;
						}else{
							$batchData[$key]['batchFecherd']=array();
						}
	
					   // add payment type
					   $batchData[$key]['paymentType'] = $this->general_settings('payment_type');
					   $batchData[$key]['currencyCode'] = $this->general_settings('currency_code');
					   $batchData[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
					   
					   
					   $batchSubject = $this->db_model->select_data('subjects.id,subjects.subject_name as subjectName, batch_subjects.chapter','subjects use index (id)',array('batch_id'=>$value['id']),'',array('batch_subjects.id','desc'),'',array('batch_subjects','batch_subjects.subject_id=subjects.id'));
					   
					   //echo "<pre>";
					   //print_r($batchSubject);
					   //die;
					   
					   if(!empty($batchSubject)){
					       foreach($batchSubject as $skey=>$svalue){
					           
					           $chapterArray = $svalue['chapter'];
                               $chapterIdsString = implode(',', json_decode($chapterArray));
                               $chapterIdsComma = implode("','", json_decode($chapterArray)) ;
                               $chapter = $this->db_model->my_query_new($chapterIdsString,$chapterIdsComma);
                               
                              //print_r($chapter);
                 
                  
					            //$cid=implode(', ',json_decode($svalue['chapter']));
					            //$con ="id in ($cid)";
					            //$chapter =$this->db_model->select_data('id,chapter_name as chapterName','chapters use index (id)',$con,'','');
					            if(!empty($chapter)){
					                foreach($chapter as $ckey=>$cvalue){
					                    
					                    $chapter[$ckey]->videoLectures = array(); 
					                    
					                   // $sub_like = array('topic,batch',urldecode($cvalue['chapterName']).',"'.$value['id'].'"');
                					   // $sub_videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$sub_like);
                        //                 if(!empty($sub_videos)){
                        //                     foreach($sub_videos as $vkey=>$vvalue){
                        //                         $url = $vvalue['url'];
                        //                         preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                        //                         $sub_videos[$vkey]['videoId']=$match[1];
                        //                     }
                        //                     $chapter[$ckey]['videoLectures']=$sub_videos;
                        //                 }else{
                        //                   $chapter[$ckey]['videoLectures'] = array(); 
                        //                 }
					                    
					                    
					                }
					                $batchSubject[$skey]['chapter']=$chapter;
					            }else{
					             $batchSubject[$skey]['chapter']=array();   
					            }
					            
					            
					       }
					       
					       $batchData[$key]['batchSubject'] = $batchSubject;
					   }else{
					     $batchData[$key]['batchSubject'] = array();  
					   }
					    $like = array('batch','"'.$value['id'].'"');
					    $videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$like);
                        if(!empty($videos)){
                            foreach($videos as $vkey=>$vvalue){
                                $url = $vvalue['url'];
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                $videos[$vkey]['videoId']=$match[1];
                            }
                            $batchData[$key]['videoLectures']=$videos;
                        }else{
                          $batchData[$key]['videoLectures'] = array(); 
                        }
					   $student_batch_dtail = $this->db_model->select_data('*','sudent_batchs',array('student_id'=>$data['student_id'],'batch_id' => $value['id'] ),'');
					   if(!empty($student_batch_dtail)){
					        $batchData[$key]['purchase_condition'] = true;
					   }else{
					       $batchData[$key]['purchase_condition'] = false;
					   }
					}
        				$subCategory[$subkey]['BatchData'] = $batchData;
        				
					    }else{
					       //unset($subCategory[$subkey]);
					       }
        					   	
        					   	if(!empty($subCategory[$subkey]['BatchData'])){
        					   	     $subCategory=array_values($subCategory);  
        					   	$category[$catkey]['subcategory'] = $subCategory;
        					   	}else{
        					   	    //unset($subCategory[$subkey]);
        					   	    //unset($category[$catkey]['subcategory'][$subkey]);
        					   	}
        					   
        					   
							}
							if(!isset($category[$catkey]['subcategory'])){
							    unset($category[$catkey]);
							}
					   }else{
					   		$category[$catkey]['subcategory'] = array();
					   }
					}
				}
				
					 $category=array_values($category); 
					 if($data['start']==0){
        			/*	$getOtherBatch=$this->otherBatchData($data);
        				if($getOtherBatch){
        				    array_push($category,$getOtherBatch);
        				}*/
					 }

					$yourBatch=array();
					$recommendedBatch=array();
					//$batchCourse=array();
					
					if(!empty($data['student_id'])){
					    
					    $batchs_id =$this->db_model->select_data('batch_id','sudent_batchs',array('student_id'=>$data['student_id']));
					       //print_r($batchs_id);
					    if(!empty($batchs_id)){
					        
					        $batchId=array();
					        foreach($batchs_id as $key=>$value){
					            $batchId[$key] =$value['batch_id'];
					        }
				
					    $batch_id =implode(', ',$batchId);
					  
					    if(!empty($batch_id)){
					    $cond="id in ($batch_id)";
					    }else{
					        $cond = '';
					    }
					   
					    $yourBatch = $this->db_model->select_data('id ,created_date,duration_type,validity_in,batch_expiry,total_validity,batch_name as batchName, start_date as startDate, end_date as endDate, start_time	as startTime, end_time as endTime, batch_type as batchType, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice','batches use index (id)',$cond,'',array('id','desc'));
					 
					                        
					    if(!empty($yourBatch)){
					        
					        foreach($yourBatch as $key=>$value){
        						if(!empty($value['batchImage'])){
        							$yourBatch[$key]['batchImage']= base_url('uploads/batch_image/').$value['batchImage'];
        						}
        						
        					    // Check Student Registration Date and Expiry Date
        					    $studentRegistrationDate =$this->db_model->select_data('create_at','sudent_batchs',array('student_id'=>$data['student_id'],'batch_id'=>$value['id']));

        						$yourBatch[$key]['studentstartDate']=date('d-m-Y',strtotime($studentRegistrationDate[0]['create_at']));
        						$yourBatch[$key]['batchStartDate'] = $value['created_date'];
        						$yourBatch[$key]['duration_type'] = $value['duration_type'];
        						
        						$mStudenDate = strtotime($studentRegistrationDate[0]['create_at']);
                                $mBatchDate = strtotime($value['created_date']);
                                 $mCurrentDate = strtotime(date('Y-m-d'));       

        						if($value['validity_in'] == ""){
        						    // Lifetime
        						    if($value['batch_expiry'] == "0000-00-00"){
        						        $yourBatch[$key]['isExpired']=false;
        						    }else{
        						        
        						        $batchExpiryDate = strtotime($value['batch_expiry']);
        						        if($batchExpiryDate < $mCurrentDate){
        						            $yourBatch[$key]['isExpired']=true;
        						        }else{
        						            $yourBatch[$key]['isExpired']=false;
        						        }
        						    }
        						}else{
        						    $totalValidity = $value['total_validity'];
            						$calculateDays = 0;
            						if($value['validity_in'] == "months"){
            						    $calculateDays = $totalValidity * 30;
            						}else if($value['validity_in'] == "years"){
            						    $calculateDays = $totalValidity * 365;
            						}else if($value['validity_in'] == "days"){
            						    $calculateDays = $totalValidity;
            						}
            						
            						$calculateDays = (int) $calculateDays ;
            						
            						$effectiveDate = strtotime("+".$calculateDays." days", strtotime($studentRegistrationDate[0]['create_at'])); // returns timestamp


            						$datediff = $effectiveDate - time();
                					if($datediff > 0){
                					   $yourBatch[$key]['isExpired']=false;
        						    }else{
        						      $yourBatch[$key]['isExpired']=true;
        						    }
        						     $yourBatch[$key]['calculateDays']=$calculateDays;
        						     $yourBatch[$key]['completeDays']= date('Y-m-d',strtotime($effectiveDate));
        						}
        						
        						$startDate =$value['startDate'];
        						$endDate =$value['endDate'];
                                $yourBatch[$key]['startDate']=date('d-m-Y',strtotime($startDate));
                                $yourBatch[$key]['endDate']=date('d-m-Y',strtotime($endDate));
        						$batch_fecherd =$this->db_model->select_data('batch_specification_heading as batchSpecification, batch_fecherd as fecherd','batch_fecherd',array('batch_id'=>$value['id']));
        						if(!empty($batch_fecherd)){
        							   $yourBatch[$key]['batchFecherd'] =$batch_fecherd;
        						}else{
        							$yourBatch[$key]['batchFecherd']=array();
        						}
        					   // add payment type
        					   $yourBatch[$key]['paymentType'] = $this->general_settings('payment_type');
        					   $yourBatch[$key]['currencyCode'] = $this->general_settings('currency_code');
        					   $yourBatch[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
        					   
        					   $batchSubject = $this->db_model->select_data('subjects.id,subjects.subject_name as subjectName, batch_subjects.chapter','subjects use index (id)',array('batch_id'=>$value['id']),'',array('id','desc'),'',array('batch_subjects','batch_subjects.subject_id=subjects.id'));
        					   if(!empty($batchSubject)){
        					       foreach($batchSubject as $skey=>$svalue){
        					            $chapter =$this->db_model->select_data('id,chapter_name as chapterName','chapters use index (id)','','',array('id','desc'));
        					            if(!empty($chapter)){
        					                foreach($chapter as $ckey=>$cvalue){
        					                    
        					                    $sub_like = array('topic,batch',urldecode($cvalue['chapterName']).',"'.$value['id'].'"');
                        					    $sub_videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$sub_like);
                                                if(!empty($sub_videos)){
                                                    foreach($sub_videos as $vkey=>$vvalue){
                                                        $url = $vvalue['url'];
                                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                                        $sub_videos[$vkey]['videoId']=$match[1];
                                                    }
                                                    $chapter[$ckey]['videoLectures']=$sub_videos;
                                                }else{
                                                  $chapter[$ckey]['videoLectures'] = array(); 
                                                }
        					                    
        					                    
        					                }
        					                $batchSubject[$skey]['chapter']=$chapter;
        					            }else{
        					             $batchSubject[$skey]['chapter']=array();   
        					            }
        					            
        					       }
        					       
        					       $yourBatch[$key]['batchSubject'] = $batchSubject;
        					   }else{
        					       $yourBatch[$key]['batchSubject'] = array();  
        					   }
        					    $like = array('batch','"'.$value['id'].'"');
        					    $videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$like);
                                if(!empty($videos)){
                                    foreach($videos as $vkey=>$vvalue){
                                        $url = $vvalue['url'];
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                        $videos[$vkey]['videoId']=$match[1];
                                    }
                                    $yourBatch[$key]['videoLectures']=$videos;
                                }else{
                                    $yourBatch[$key]['videoLectures'] = array(); 
                                }

        					}
					    }
					        
					    }
					    
					    
					   $categoryData = $this->db_model->select_data('id as categoryId,name as categoryName','batch_category use index (id)',array('status'=>1),'');
					     if(!empty($categoryData)){
					        
					        foreach($categoryData as $key1=>$value){
					                 
					   //  }
					   
					   // $cond="id not in ($batch_id) AND status=1 AND cat_id= $value['id']";
					   $cond = array('status'=>1,'cat_id'=>$value['categoryId']);
					   

					    $subCategory = $this->db_model->select_data('id as SubcategoryId,name as SubcategoryName','batch_subcategory use index (id)',$cond,'');
					   // echo $this->db->last_query();
					    if(!empty($subCategory)){
					        
					        foreach($subCategory as $key2=>$value){
					    
					     
					   $cond_sub = array('status'=>1,'sub_cat_id'=>$value['SubcategoryId']);
					
                        $recommendedBatch = $this->db_model->select_data('id ,batch_name as batchName, start_date as startDate, end_date as endDate, start_time	as startTime, end_time as endTime, batch_type as batchType, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice','batches use index (id)',$cond_sub,'',array('id','desc'));
                        // print_r($recommendedBatch);
                        // echo $this->db->last_query();
					    if(!empty($recommendedBatch)){
					        
					        foreach($recommendedBatch as $key=>$value){
        						if(!empty($value['batchImage'])){
        							$recommendedBatch[$key]['batchImage']= base_url('uploads/batch_image/').$value['batchImage'];
        						}
        						$startDate =$value['startDate'];
        						$endDate =$value['endDate'];
                                $recommendedBatch[$key]['startDate']=date('d-m-Y',strtotime($startDate));
                                $recommendedBatch[$key]['endDate']=date('d-m-Y',strtotime($endDate));
        						$batch_fecherd =$this->db_model->select_data('batch_specification_heading as batchSpecification, batch_fecherd as fecherd','batch_fecherd',array('batch_id'=>$value['id']));
        						if(!empty($batch_fecherd)){
        							   $recommendedBatch[$key]['batchFecherd'] =$batch_fecherd;
        						}else{
        							$recommendedBatch[$key]['batchFecherd']=array();
        						}
        					   // add payment type
        					   $recommendedBatch[$key]['paymentType'] = $this->general_settings('payment_type');
        					   $recommendedBatch[$key]['currencyCode'] = $this->general_settings('currency_code');
        					   $recommendedBatch[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
        					   
        					   $batchSubject = $this->db_model->select_data('subjects.id,subjects.subject_name as subjectName, batch_subjects.chapter','subjects use index (id)',array('batch_id'=>$value['id']),'',array('id','desc'),'',array('batch_subjects','batch_subjects.subject_id=subjects.id'));
        					   if(!empty($batchSubject)){
        					       foreach($batchSubject as $skey=>$svalue){
        					            
        					            $chapter =$this->db_model->select_data('id,chapter_name as chapterName','chapters use index (id)','',array('id','desc'));
        					            if(!empty($chapter)){
        					                foreach($chapter as $ckey=>$cvalue){
        					                    
        					                    $sub_like = array('topic,batch',urldecode($cvalue['chapterName']).',"'.$value['id'].'"');
                        					    $sub_videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$sub_like);
                                                if(!empty($sub_videos)){
                                                    foreach($sub_videos as $vkey=>$vvalue){
                                                        $url = $vvalue['url'];
                                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                                        $sub_videos[$vkey]['videoId']=$match[1];
                                                    }
                                                    $chapter[$ckey]['videoLectures']=$sub_videos;
                                                }else{
                                                  $chapter[$ckey]['videoLectures'] = array(); 
                                                }
        					                    
        					                    
        					                }
        					                $batchSubject[$skey]['chapter']=$chapter;
        					            }else{
        					             $batchSubject[$skey]['chapter']=array();   
        					            }
        					       }
        					       
        					       $recommendedBatch[$key]['batchSubject'] = $batchSubject;
        					   }else{
        					     $recommendedBatch[$key]['batchSubject'] = array();  
        					   }
        					   		

        					   	}
        					   	$subCategory[$key2]['BatchData'] = $recommendedBatch;
        					   	
        					}
        				
					       else{
        					   	 $subCategory[$key2]['BatchData'] = array();
        					   	 $categoryData[$key1]['subcategory'] = array();
        					   	}
							}
				// 			print_r($subCategory);
							 $categoryData[$key1]['subcategory'] = $subCategory;
					   }else{
					   		$categoryData[$key1]['subcategory'] = array();
					   }
					  
					}
				}
				
					    
					}
				
					$arr = array(
				                'status'=>'true',
				                'msg' =>$this->lang->line('ltr_fetch_successfully'),
				                'batchData'=>$category,
				                'yourBatch'=>$yourBatch,
				                'bundleCourse'=>$bundleCourse,
				                // 'category'=>$categoryData,
				                'recommendedBatch'=>$categoryData
				                );
					
				// }else{
				// 	$arr = array('status'=>'false', 'msg' => $this->lang->line('ltr_no_record_msg')); 
				// }
			echo json_encode($arr);
		}
/*other batch function start*/
public function otherBatchData($data){
$search = trim($data['search']);
		    $slider_limit = $data['limit'];
		    
			if(!empty($search)){
			  $like_search = array('batch_name',$search);
			}else{
			    $like_search = '';
			}
	
          if(isset($data['length']) && $data['length']>0){
                if(isset($data['start']) && !empty($data['start'])){
                    $limit = array($data['length'],$data['start']);
                    // $count = $data['start']+1;
                }else{ 
                    $limit = array($data['length'],0);
                    // $count = 1;
                }
            }else{
                $limit = '';
                // $count = 1;
            }
					     $category=array('categoryId'=>'0','categoryName'=>'other');
					     $subCategory['SubcategoryId']='0';
					     $subCategory['SubcategoryName']='other';
					   $cond_sub1 = array('status'=>1,'sub_cat_id'=>0);
					   
	$batchData = $this->db_model->select_data('id, batch_name as batchName, start_date as startDate, end_date as endDate, start_time as startTime, end_time as endTime, batch_type as batchType, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice','batches use index (id)',$cond_sub1,$slider_limit,array('id','desc'),$like_search);
       
				if(!empty($batchData)){
					foreach($batchData as $key=>$value){
						if(!empty($value['batchImage'])){
							$batchData[$key]['batchImage']= base_url('uploads/batch_image/').$value['batchImage'];
						}
						$startDate =$value['startDate'];
						$endDate =$value['endDate'];
                        $batchData[$key]['startDate']=date('d-m-Y',strtotime($startDate));
                        $batchData[$key]['endDate']=date('d-m-Y',strtotime($endDate));
                       
						$batch_fecherd =$this->db_model->select_data('batch_specification_heading as batchSpecification, batch_fecherd as fecherd','batch_fecherd',array('batch_id'=>$value['id']));
						if(!empty($batch_fecherd)){
							   $batchData[$key]['batchFecherd'] =$batch_fecherd;
						}else{
							$batchData[$key]['batchFecherd']=array();
						}
	
					   // add payment type
					   $batchData[$key]['paymentType'] = $this->general_settings('payment_type');
					   $batchData[$key]['currencyCode'] = $this->general_settings('currency_code');
					   $batchData[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
					   
					   
					   $batchSubject = $this->db_model->select_data('subjects.id,subjects.subject_name as subjectName, batch_subjects.chapter','subjects use index (id)',array('batch_id'=>$value['id']),'',array('id','desc'),'',array('batch_subjects','batch_subjects.subject_id=subjects.id'));
					   if(!empty($batchSubject)){
					       foreach($batchSubject as $skey=>$svalue){
					            $cid=implode(', ',json_decode($svalue['chapter']));
                                if(!empty($cid)){
					            $con ="id in ($cid)";
					            $chapter =$this->db_model->select_data('id,chapter_name as chapterName','chapters use index (id)',$con,'',array('id','desc'));
					            if(!empty($chapter)){
					                foreach($chapter as $ckey=>$cvalue){
					                    
					                    $sub_like = array('topic,batch',urldecode($cvalue['chapterName']).',"'.$value['id'].'"');
                					    $sub_videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$sub_like);
                                        if(!empty($sub_videos)){
                                            foreach($sub_videos as $vkey=>$vvalue){
                                                $url = $vvalue['url'];
                                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                                $sub_videos[$vkey]['videoId']=$match[1];
                                            }
                                            $chapter[$ckey]['videoLectures']=$sub_videos;
                                        }else{
                                          $chapter[$ckey]['videoLectures'] = array(); 
                                        }
					                    
					                    
					                }
					                $batchSubject[$skey]['chapter']=$chapter;
					            }else{
					             $batchSubject[$skey]['chapter']=array();   
					            }
                            }else{
                                $batchSubject[$skey]['chapter']=array();   
                               }
					            
					            
					       }
					       
					       $batchData[$key]['batchSubject'] = $batchSubject;
					   }else{
					     $batchData[$key]['batchSubject'] = array();  
					   }
					    $like = array('batch','"'.$value['id'].'"');
					    $videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('status'=>1),'',array('id','desc'),$like);
                        if(!empty($videos)){
                            foreach($videos as $vkey=>$vvalue){
                                $url = $vvalue['url'];
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                $videos[$vkey]['videoId']=$match[1];
                            }
                            $batchData[$key]['videoLectures']=$videos;
                        }else{
                          $batchData[$key]['videoLectures'] = array(); 
                        }
					   $student_batch_dtail = $this->db_model->select_data('*','sudent_batchs',array('student_id'=>$data['student_id'],'batch_id' => $value['id'] ),'');
					   if(!empty($student_batch_dtail)){
					        $batchData[$key]['purchase_condition'] = true;
					   }else{
					       $batchData[$key]['purchase_condition'] = false;
					   }
					   
					}
        				$subCategory['BatchData'] = $batchData;
        				
					    }else{
					        
					       unset($subCategory);
					       
					       
					       
        					   	}
        					   	
        					   	if(!empty($subCategory['BatchData'])){
        					   	     //$subCategory=array_values($subCategory);  
        					   	$category['subcategory'] = array($subCategory);
        					   	}else{
        					   	    unset($subCategory);
        					   	    unset($category['subcategory']);
        					   	}
        					   if(!empty($category['subcategory'])){
        					       return	$category;
        					   }else{
        					       return	false;
        					   }
        					   //print_r($category);
						
}
							/*Other batch functio end*/
    function profile_update(){
        $data = $_REQUEST;
        if(isset($data['name']) && isset($data['password']) && isset($data['student_id'])){
            $data_arr = [];
            $path = 'uploads/students/';
            if($data['name'] != ''){
                $data_arr['name'] = $data['name'];
            }
            $pimage = $this->db_model->select_data('image','students use index (id)',array('id'=>$data['student_id']),1)[0]['image'];         
            if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
                $image = $this->upload_media($_FILES,$path,'image');
                if(is_array($image)){
                    $arr = array(
                        'status'=>'false',
                        'msg' => $image['msg'],
                    );
                }else{
                    $data_arr['image'] = $image;
                    $pimage = $image;
                }
            }
            if($data['password'] != ''){
                $data_arr['password'] = md5($data['password']);
            }
            if(!empty($data_arr)){
                $ins = $this->db_model->update_data_limit('students',$data_arr,array('id'=>$data['student_id']));  
                if($ins==true){



                    $profile = $this->db_model->select_data('id,name,email,image,batch_id,country_code,contact_no,enrollment_id,admin_id,student_state,student_city','students use index (id)',array('id'=>$data['student_id']),1);
                    if(empty($profile)){
                           $arr = array(
                                'status'=>'false'
                            );
                    }else{
                            $batchName = '';
                            if(!empty($profile[0]['batch_id'])){
                                $batch = $this->db_model->select_data('batch_name','batches use index (id)',array('id'=>$profile[0]['batch_id']),1);
                                if(!empty($batch)){
                                    $batchName = $batch[0]['batch_name'];
                                }
                            }
                            $profile[0]['batch_name'] = $batchName;
                            if(!empty($profile[0]['image'])){
                                $profile[0]['image'] = base_url('uploads/students/').$profile[0]['image'];
                                // $profile[0]['image'] = 'uploads/students/'.$profile[0]['image'];
                            }else{
                                // $profile[0]['image'] = 'uploads/students/student_img.png';
                                $profile[0]['image'] = base_url('uploads/students/student_img.png');
                            }


                            $arr = array(
                                'status'=>'true',
                                'name'=>$data['name'],
                                'image'=>base_url('uploads/students/').$pimage,
                                // 'image'=> 'uploads/students/'.$pimage,
                                'msg'=>$this->lang->line('ltr_profile_updated_msg'),
                                'profile'=>$profile[0]
                            );
                    }


                }else{
                    $arr = array(
                        'status'=>'false'
                    );
                }
            }else{
                $arr = array(
                    'status'=>'false',
                    'msg'=>$this->lang->line('ltr_name_can_msg')
                ); 
            } 
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    function upload_media($files,$path,$file){   
        $config['upload_path'] =$path;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']    = '0';
        $filename = '';		
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file)){
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];
            return $filename;
        }else{
            $resp = array('status'=>'2', 'msg' => $this->upload->display_errors());
            return $resp;
        }     
    }
    function notice_count(){
        $data = $_REQUEST;
        if(isset($data['admin_id'])){
            $admin_id = $data['admin_id'];
            $unreadNotice=[];
            $cond = "admin_id = $admin_id AND status = 1 AND (notice_for = 'Student' OR notice_for = 'Both')";
            $notice_count = $this->db_model->countAll('notices',$cond);
            if(!empty($notice_count)){
                $arr = array('status'=>'true','unreadNotice'=>$notice_count);
            }else{
                $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_something_msg'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
		echo json_encode($arr);
    }
    function notices(){
        $data = $_REQUEST;
        if(isset($data['admin_id']) && isset($data['student_id'])){
            $admin_id = $data['admin_id'];
            if(!empty($data['uid'])){
                $this->viewNotificationStatus($data['uid'],'notices');
            }
            $student_id = $data['student_id'];
            $cond = " status = 1";
            if($student_id == 'all'){
                $cond .= " AND (notice_for = 'Student' OR notice_for = 'Both')";
            }else{
                $cond .= " AND student_id = $student_id";
            }
            // $cond = "admin_id = $admin_id AND status = 1 AND (notice_for = 'Student' OR notice_for = 'Both')";
            $notices = $this->db_model->select_data('`id`, `title`, `description`, `notice_for` as noticeFor, `status`, `date`, `admin_id` as adminId, `student_id` as studentId, `teacher_id` as teacherId, `added_by` as addedBy, `read_status` as readStatus, `added_at` as addedAt','notices use index (id)',$cond,'',array('id','desc'));
            if($notices){
                foreach($notices as $key=>$value){
                    
                    $notices[$key]['date']= date('d-m-Y',strtotime($value['date']));
                    $notices[$key]['addedAt']= date('d-m-Y',strtotime($value['addedAt']));
                }
                $this->db_model->update_data('notices use index(id)',array('read_status'=>1),array('student_id'=>$student_id));
                $arr = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'),'allNotice'=>$notices);
            }else{
                $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
    	echo json_encode($arr);		
    }
    function extraClass(){
        $data = $_REQUEST;
        if(isset($data['admin_id']) && isset($data['type']) && isset($data['page_no']) && isset($data['batch_id'])){
            if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'extraClass');
            }
            $admin_id = $data['admin_id'];
            $type = $data['type'];
            $startlimit = $data['page_no'];
            $batch_id_like = '"'.$data['batch_id'].'"';
            if($startlimit > 0){
                $start = ((($startlimit)*10)+1)-1; 
            }else{
                $start = 0;
            }
            $limit = array(10,$start);
            if($type=='previous'){
                $cond = array('extra_classes.admin_id'=>$admin_id,'extra_classes.date < '=>date('Y-m-d'));
                $order = array('date','desc');
            }else{
                $cond = array('extra_classes.admin_id'=>$admin_id,'extra_classes.date >= '=>date('Y-m-d'));
                $order = array('date','desc');
            }
            $extraClsData = $this->db_model->select_data(' extra_classes.id,extra_classes.admin_id as adminId, extra_classes.date,extra_classes.start_time as startTime, extra_classes.end_time as endTime,extra_classes.teacher_id as teacherId, extra_classes.description,extra_classes.status,extra_classes.batch_id as batchId,extra_classes.added_at as addedAt,extra_classes.completed_date_time as completedDateTime,users.name,users.teach_gender as teachGender','extra_classes use index (id)',$cond,$limit,$order,array('batch_id',$batch_id_like),array('users','users.id = extra_classes.teacher_id'),'');
            if (!empty($extraClsData)){
                $arr = array(
                    'extraClass' => $extraClsData,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            } else {
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    function Homework(){ 
        $data = $_REQUEST;
        if(isset($data['admin_id']) && isset($data['batch_id']) && isset($data['homework_date'])){
            
            if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'homeWork');
            }
            $admin_id = $data['admin_id'];
            $batch_id = $data['batch_id'];
            $date = date('Y-m-d',strtotime($data['homework_date'])); 
            $cond = array('homeworks.admin_id'=>$admin_id,'homeworks.date'=>date('Y-m-d',strtotime($date)),'homeworks.batch_id'=>$batch_id);
            $homewrkData = $this->db_model->select_data('homeworks.id,homeworks.admin_id as adminId,homeworks.teacher_id teacherId, homeworks.date,homeworks.subject_id as studentId, homeworks.batch_id as batchId,homeworks.description,homeworks.added_at as addedAt,users.name,users.teach_gender as teachGender,subjects.subject_name as subjectName','homeworks use index (id)',$cond,'',array('id','desc'),'',array('multiple',array(array('users','users.id = homeworks.teacher_id'),array('subjects','subjects.id = homeworks.subject_id'))),'');
            if (!empty($homewrkData)) {
                $arr = array(
                    'homeWork' => $homewrkData,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    function get_subject(){
        
      
        $data = $_REQUEST;
        if(isset($data['admin_id']) && isset($data['batch_id'])){
            if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'videoLecture');
            }
            
            $type =  "0";
            if(!empty($data['type']) && $data['type']==1){
                $type = "1";
            }
            
            $fetchSubject = $this->db_model->custom_query_data('SELECT subject FROM video_lectures where batch = '.$data['batch_id'].' AND video_audio_type = '.$type.'  GROUP by subject  ORDER BY `video_lectures`.`subject` ASC');

            
            $array = [];
            $mSub = [];
            if(!empty($fetchSubject)){
                foreach($fetchSubject as $key=>$value){
                    $msubject = $value['subject'];
                     $getSubjectIds = $this->db_model->select_data('id','subjects use index (id)',array('subject_name'=>$msubject));
                     $array["id"] = $getSubjectIds[0]['id'];
                     $array["subjectName"] = $msubject;
                     $array["batchSubjectId"] = $data['batch_id'];
                     $mSub[] = $array;
                    
                }
            }
            
            $arr = array(
                'subject' => $mSub,
                'status' => 'true',
                'msg' => $this->lang->line('ltr_fetch_successfully')
            ); 
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    
    function customConvert($value) {
        return is_numeric($value) ? (int)$value : null;
    }

    // function video_lecture(){
    //     $data = $_REQUEST;
    //     if(isset($data['admin_id']) && isset($data['page_no']) && $data['batch_id']){
    //         $startlimit = $data['page_no'];
    //         $admin_id = $data['admin_id'];
    //         if($startlimit > 1){
    //             $start = (($startlimit-1)*10)+1; 
    //         }else{
    //             $start = 0;
    //         }
    //         $limit = array(10,$start);
    //         $like = array('batch','"'.$data['batch_id'].'"');
    //         if(isset($data['chapter']) && $data['chapter']!=''){
    //             $like = array('topic,batch',urldecode($data['chapter']).',"'.$data['batch_id'].'"');
    //         }
           
    //         $videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('admin_id'=>$admin_id),$limit,array('id','desc'),$like);
    //         if(!empty($videos)){
    //             foreach($videos as $key=>$value){
    //                 $url = base_url().$value['url'];
    //                 preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    //                 $videos[$key]['videoId']=$match[1];
    //                  print_r( $url);
    //             }
    //         }
           
    //         $num_rows = $this->db_model->countAll('video_lectures use index (id)',array('admin_id'=>$admin_id));
    //         if(!empty($videos)){
    //             $arr = array(
    //                 'videoLecture' => $videos,
    //                 'totalCount' => $num_rows,
    //                 'encCode' => base64_encode('AIzaSyAQ8wpz16d6izBb0wfpDI1A895Bln5nbRs'),
    //                 'status' => 'true',
    //                 'msg' => $this->lang->line('ltr_fetch_successfully')
    //             );
    //         }else{
    //             $arr = array(
    //                 'status' => 'false',
    //                 'msg' => $this->lang->line('ltr_no_record_msg')
    //             );
    //         }
    //     }else{
    //         $arr = array(
    //             'status'=>'false',
    //             'msg'=>$this->lang->line('ltr_missing_parameters_msg')
    //         ); 
    //     }
    //     echo json_encode($arr);
    // }
    function video_lecture(){
        $data = $_REQUEST;
        if(isset($data['admin_id']) && isset($data['page_no']) && $data['batch_id']){
            $startlimit = $data['page_no'];
            $admin_id = $data['admin_id'];
            if($startlimit > 1){
                $start = (($startlimit-1)*10)+1; 
            }else{
                $start = 0;
            }
            //  $limit = array(10,$start);
            $limit = '';
            // $like = array('batch','"'.$data['batch_id'].'"');
            if(isset($data['chapter']) && $data['chapter']!=''){	
                $like = array('topic,"'.urldecode($data['chapter']).'"');	
               // $like = array('topic,batch',urldecode($data['chapter']).',"'.$data['batch_id'].'"');
            }
            
            $type =  "0";
            if(!empty($data['type']) && $data['type']==1){
                $type = "1";
            }
            
            
            
			
			 $join = array('chapters',"chapters.id = video_lectures.topic");
			 // $videos = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('admin_id'=>$admin_id),$limit,array('id','desc'),$like);
            $videos = $this->db_model->select_data('id,thumbnail,video_audio_type,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt,video_type as videoType, preview_type as previewType, description','video_lectures use index (id)',array('video_audio_type' => $type,'batch'=>$data['batch_id'],'subject'=>$data['subject'],'topic'=>$data['chapter']),$limit,array('video_lectures.page_order','asc'),$like);
// 			echo $this->db->last_query();	

            if(!empty($videos)){
                foreach($videos as $key=>$value){
                    $url = $value['url'];
                    if($value['video_audio_type'] == 1){
                        $videos[$key]['videoId']='';
                    }else{
                        $url = $value['url'];
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                        $videos[$key]['videoId']=$match[1];
                    }
                    
                }
            }			
            $num_rows = $this->db_model->countAll('video_lectures use index (id)',array('admin_id'=>$admin_id));
            if(!empty($videos)){
                $arr = array(
                    'videoLecture' => $videos,
                    'totalCount' => $num_rows,
                    'encCode' => base64_encode('AIzaSyAQ8wpz16d6izBb0wfpDI1A895Bln5nbRs'),
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    function viewVacancy()
    {   
        $data = $_REQUEST;
        if(isset($data['admin_id'])){
            
            if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'vacancy');
             }
            $currentDate = date("Y-m-d");
            $admin_id  =  $data['admin_id'];
            $vacancy = $this->db_model->select_data('id,title,description,start_date as startDate,last_date as lastDate,mode,files,status,admin_id as adminId,added_at as addedAt','vacancy use index (id)',array('admin_id'=>$admin_id,'last_date >= '=> $currentDate,'status'=>1),'',array('id','desc'));
            if (!empty($vacancy)){
                foreach($vacancy as $key=>$value){
                    $vacancy[$key]['startDate']= date('d-m-Y', strtotime($value['startDate']));
                    $vacancy[$key]['lastDate']= date('d-m-Y', strtotime($value['lastDate']));
                    $vacancy[$key]['addedAt']= date('d-m-Y', strtotime($value['addedAt']));
                }
                $arr = array(
                    'vacancy' => $vacancy,
                    'filesUrl' => base_url('uploads/vacancy/'),
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully'),
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
 	function app_version(){
        $appVersion = $this->db_model->select_data('*','app_versions');
 	    if(!empty($appVersion)){
			$arr = array( 
        				'status'=>'true',
        				'version'=>$appVersion[0]['latest_version'],
        			);
		}else{
			$arr = array('status'=>'false');
		}
		echo json_encode($arr);
 	}
 	function update_version(){
        $data =	$_REQUEST;
        if(isset($data['version'])){
            $ins = $this->db_model->update_data_limit('app_versions',array('latest_version'=>$data['version']),array('id'=>1),1);
            if($ins){
               $arr = array(
                   'status' => 'true',
                   'msg' => $this->lang->line('ltr_appv_updated_msg')
               );
           }else{
               $arr = array('status'=>'false');
           }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
		echo json_encode($arr);
     }
    function last_login_time(){
    $data = $_REQUEST;
    if(isset($data['student_id'])){
        $ins = $this->db_model->update_data_limit('students',array('last_login_app'=>date('Y-m-d H:i:s')),array('id'=>$data['student_id']),1);
        if($ins){
           $arr = array(
               'status' => 'true',
           );
       }else{
           $arr = array('status'=>'false');
       }
    }else{
        $arr = array(
            'status'=>'false',
            'msg'=>$this->lang->line('ltr_missing_parameters_msg')
        ); 
    }
    echo json_encode($arr);
}

function db_new_changes(){
    $data = $_REQUEST;
    if(isset($data['admin_id']) && isset($data['student_id']) && isset($data['batch_id'])){
        $admin_id = $data['admin_id'];
        $student_id = $data['student_id'];
        $batch_id = $data['batch_id'];
        
        $last_login = $this->db_model->select_data('last_login_app','students use index(id)',array('id'=>$student_id),1);
        
        if($last_login[0]['last_login_app'] != '0000-00-00 00:00:00'){
            
            $lastLoginTime = $last_login[0]['last_login_app'];
            
            // Initialize arrays
            $extraClass = array();
            $homewrkData = array();
            $videos = array();
            $vacancy = array();
            $notices = array();
            $newexampaper_test = array();
            $newexampaper = array();
            $addNewBook = array();
            $addNewNotes = array();
            $addOldPaper = array();
            
            $like = array('batch','"'.$batch_id.'"');
            
            // Get exam papers
            $exampaper = $this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName, status, added_by as addedBy, added_at as addedAt, paper_type','exampaper use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
            
            if(!empty($exampaper)){
                foreach($exampaper as $exam){
                    $paperstatus = array();
                    $view_n = $this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'exampaper','notice_id'=>$exam['id']));
                    
                    if($exam['paper_type'] == 'practice'){
                        if(!empty($paperstatus) && !empty($view_n)){
                            if(strtotime($view_n[0]['views_time']) < strtotime($exam['addedAt'])){
                                array_push($newexampaper_test, $exam);
                            }
                        } else if(empty($paperstatus) && empty($view_n)){
                            array_push($newexampaper_test, $exam);
                        } else if(!empty($view_n)){
                            if(strtotime($view_n[0]['views_time']) < strtotime($exam['addedAt'])){
                                array_push($newexampaper_test, $exam);
                            }
                        }
                    } else {
                        if(!empty($paperstatus) && !empty($view_n)){
                            if(strtotime($view_n[0]['views_time']) < strtotime($exam['addedAt'])){
                                array_push($newexampaper, $exam);
                            }
                        } else if(empty($paperstatus) && empty($view_n)){
                            array_push($newexampaper, $exam);
                        } else if(!empty($view_n)){
                            if(strtotime($view_n[0]['views_time']) < strtotime($exam['addedAt'])){
                                array_push($newexampaper, $exam);
                            }
                        }
                    }
                }
            }
            
            // Get books
            $book_pdf = $this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName, status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
            if(!empty($book_pdf)){
                foreach($book_pdf as $key=>$value){
                    $view_n = $this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'book_notes_paper','notice_id'=>$value['id']));
                    if(empty($view_n)){
                        $addNewBook[$key] = $value;
                        $addNewBook[$key]['url'] = base_url('uploads/book/');
                    } else {
                        if(strtotime($view_n[0]['views_time']) < strtotime($value['addedAt'])){
                            $addNewBook[$key] = $value;
                            $addNewBook[$key]['url'] = base_url('uploads/book/');
                        }
                    }
                    
                    $subjectName = $this->db_model->select_data('subject_name','subjects',array('id'=>$value['subject']));
                    if(!empty($subjectName)){
                        $addNewBook[$key]['subjectName'] = $subjectName[0]['subject_name'];
                    }
                }
            }
            
            // Get notes
            $notes_pdf = $this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName, status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
            if(!empty($notes_pdf)){
                foreach($notes_pdf as $key=>$value){
                    $view_n = $this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'book_notes_paper','notice_id'=>$value['id']));
                    if(empty($view_n)){
                        $addNewNotes[$key] = $value;
                        $addNewNotes[$key]['url'] = base_url('uploads/notes/');
                    } else {
                        if(strtotime($view_n[0]['views_time']) < strtotime($value['addedAt'])){
                            $addNewNotes[$key] = $value;
                            $addNewNotes[$key]['url'] = base_url('uploads/notes/');
                        }
                    }
                    
                    $subjectName = $this->db_model->select_data('subject_name','subjects',array('id'=>$value['subject']));
                    if(!empty($subjectName)){
                        $addNewNotes[$key]['subjectName'] = $subjectName[0]['subject_name'];
                    }
                }
            }
            
            // Get old papers
            $oldPaper = $this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName, status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
            if(!empty($oldPaper)){
                foreach($oldPaper as $key=>$value){
                    $view_n = $this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'book_notes_paper','notice_id'=>$value['id']));
                    if(empty($view_n)){
                        $addOldPaper[$key] = $value;
                        $addOldPaper[$key]['url'] = base_url('uploads/oldpaper/');
                    } else {
                        if(strtotime($view_n[0]['views_time']) < strtotime($value['addedAt'])){
                            $addOldPaper[$key] = $value;
                            $addOldPaper[$key]['url'] = base_url('uploads/oldpaper/');
                        }
                    }
                    
                    $subjectName = $this->db_model->select_data('subject_name','subjects',array('id'=>$value['subject']));
                    if(!empty($subjectName)){
                        $addOldPaper[$key]['subjectName'] = $subjectName[0]['subject_name'];
                    }
                }
            }
            
            $arr = array(
                'status' => 'true',
                'extraClass' => $extraClass,
                'homeWork' => $homewrkData,
                'videoLecture' => $videos,
                'vacancy' => $vacancy,
                'notices' => $notices,
                'practicePaper' => $newexampaper_test,
                'mockPaper' => $newexampaper,
                'addOldPaper' => $addOldPaper,
                'addNewBook' => $addNewBook,
                'addNewNotes' => $addNewNotes,
            ); 
            
        } else {
            $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_its_first_login'));
        }
    } else {
        $arr = array(
            'status'=>'false',
            'msg'=>$this->lang->line('ltr_missing_parameters_msg')
        ); 
    }
    echo json_encode($arr);
}
    
    function viewNotificationStatus($student_id='',$notice_type=''){
        $data = $_REQUEST;
        if(!empty($student_id) && !empty($notice_type)){
            
           
             $data_arr=array();
             $cu_date = date('Y-m-d H:i:s');
             $data_arr['student_id']=$student_id;
             $data_arr['notice_type']=$notice_type;
             $noticeD = $this->db_model->select_data('*','views_notification_student',array('student_id'=>$student_id,'notice_type'=>$notice_type),1);
             if(!empty($noticeD)){
                 $this->db_model->update_data_limit('views_notification_student ',array('views_time'=>$cu_date),array('n_id'=>$noticeD[0]['n_id']),1);
             }else{
                 $data_arr = $this->security->xss_clean($data_arr);
                 $ins = $this->db_model->insert_data('views_notification_student',$data_arr);
                
             }
        }
                
            return;
            
    }
    
    function getLiveClassData()
    {   
        $data = $_REQUEST;
        if(isset($data['batch_id'])){
           
            $setting = $this->db_model->select_data('meeting_number as meetingNumber,password','live_class_setting',array('batch'=>$data['batch_id'],'status'=>1),'',array('id','desc'));
            $datasdk = $this->db_model->select_data('android_api_key,android_api_secret','zoom_api_credentials');
            $setting[0]['sdkKey']=$datasdk[0]['android_api_key'];
            $setting[0]['sdkSecret']=$datasdk[0]['android_api_secret'];
            if (!empty($setting)){
                $arr = array(
                    'data' => $setting,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully'),
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    function getAttendance(){ 
        $data = $_REQUEST;
        if(isset($data['student_id']) && isset($data['month']) && isset($data['year'])){
            $student_id = $data['student_id'];
            $year=$data['year'];
            $month=$data['month'];
            $like = array('date',$year.'-'.$month);
            $attendance = $this->db_model->select_data('student_id as studentId,added_id as addedId,date,time','attendance use index (id)',array('student_id'=>$student_id),'','',$like,'','');
            if (!empty($attendance)) {
                $arr = array(
                    'attendance' => $attendance,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    
    function getTopScorer(){ 
        $data = $_REQUEST;
        if(isset($data['batch_id'])){
            $batch_id = $data['batch_id'];
            $exam = $this->db_model->select_data('id,name','exams  use index (id)',array('batch_id'=>$batch_id,'type'=>1,'mock_sheduled_date <='=>date('Y-m-d')),'1',array('id','desc'));
            $top_three = $this->db_model->select_data('mock_result.paper_name as paperName,students.name,students.image,mock_result.percentage','mock_result  use index (id)',array('paper_id'=>$exam[0]['id'],'mock_result.percentage >'=>0),'3',array('mock_result.percentage','desc'),'',array('students','students.id=mock_result.student_id'));
            if (!empty($top_three)) {
                $arr = array(
                    'topThree' => $top_three,
                    'filesUrl' => base_url('uploads/students/'),
                    'status' => 'true',
                    
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    
    
    function getAllTopScorer(){ 
        $data = $_REQUEST;
        if(isset($data['batch_id'])){
            $batch_id = $data['batch_id'];
            $exam = $this->db_model->select_data('id,name','exams  use index (id)',array('batch_id'=>$batch_id,'type'=>1,'mock_sheduled_date <='=>date('Y-m-d')),'1',array('id','desc'));
            $top_three = $this->db_model->select_data('mock_result.paper_name as paperName,question_answer,students.name,students.image,mock_result.percentage','mock_result  use index (id)',array('paper_id'=>$exam[0]['id'],'mock_result.percentage >'=>0),'200',array('mock_result.percentage','desc'),'',array('students','students.id=mock_result.student_id'));
            if (!empty($top_three)) {
                
                 foreach($top_three as $result => $mValue){
                     $attemptedQuestion = json_decode($mValue['question_answer'],true);
                    $rightCount = 0;
                    $wrongCount = 0;
                    foreach($attemptedQuestion as $key=>$value){
                            $right_ansrs = $this->db_model->select_data('id,answer', 'questions use index (id)',array('id'=>$key));
                            if(($key == $right_ansrs[0]['id']) && ($value == $right_ansrs[0]['answer'])){
                                $rightCount++;
                            }else{
                                $wrongCount++;
                            }
                          
                    }
                    $total_score= $rightCount - ($wrongCount*0.25);
                    $top_three[$result]['total_score'] = $total_score;
                 }
                $arr = array(
                    'topThree' => $top_three,
                    'filesUrl' => base_url('uploads/students/'),
                    'status' => 'true',
                    
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    
    function getAcademicRecord(){ 
        $data = $_REQUEST;
        if(isset($data['student_id']) && isset($data['month']) && isset($data['year']) && isset($data['batch_id'])){
            $student_id = $data['student_id'];
            $year=$data['year'];
            $month=$data['month'];
            $like = $year.'-'.$month.'-';
            $batch_id=$data['batch_id'];
            $like_batch_id='"'.$data['batch_id'].'"';
		    $data1['extraClass'] = $this->db_model->countAll('extra_class_attendance',array('student_id'=>$student_id),'','',array('date',$like));
		    $data1['totalExtraClass'] = $this->db_model->countAll('extra_classes','',array('batch_id'=>$like_batch_id),'',array('date',$like));
    	    
    		$data1['practiceResult'] =(int)$this->db_model->custom_slect_query(" COUNT(*) AS `numrows` FROM ( SELECT practice_result.id FROM `practice_result` JOIN `exams` ON `exams`.`id`=`practice_result`.`paper_id` WHERE  `student_id` = '".$student_id."' AND date(added_at) LIKE '%".$like."%' ESCAPE '!' GROUP BY `paper_id` ) a")[0]['numrows'];
    		
    		$data1['totalPracticeTest'] = $this->db_model->countAll('exams',array('batch_id'=>$batch_id,'type'=>2),'','',array('date(added_at)',$like));
    		
		    $data1['mockResult'] = $this->db_model->countAll('mock_result',array('student_id'=>$student_id),'','',array('date',$like));
		    
		    $data1['totalMockTest'] = $this->db_model->countAll('exams',array('batch_id'=>$batch_id,'type'=>1),'','',array('date(added_at)',$like));
		  
            if (!empty($data1)) {
                $arr = array(
                    'academicRecord' => $data1,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    
    
    function checkActiveLiveClass(){ 
         /*ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);*/
        $data = $_REQUEST;
        if(isset($data['batch_id'])){
            $batch_id = $data['batch_id'];
		    $class_data = $this->db_model->select_data('live_class_setting_id,join_url,video_id,type,users.name,users.teach_image AS teachImage,subjects.subject_name as subjectName,chapters.chapter_name as chapterName,live_class_history.end_time as endTime','live_class_history',array('batch_id'=>$batch_id),'1',array('live_class_history.id','desc'),'',array('multiple',array(array('users','users.id = live_class_history.uid'),array('subjects','subjects.id = live_class_history.subject_id'),array('live_class_setting','live_class_setting.id = live_class_history.live_class_setting_id'),array('chapters','chapters.id = live_class_history.chapter_id'))));
		   
            if (!empty($class_data)) {
                if(empty($class_data[0]['endTime'])){
                    $arr = array(
                    'liveClass' => $class_data[0],
                    'filesUrl' => base_url('uploads/teachers/'),
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );
                }else{
                     $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
                }
                
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            );
        }
        echo json_encode($arr);
    }
    // function certificate(){
      
    //    $data = $_REQUEST;
    //     if(isset($data['batch_id']) && isset($data['student_id']) ){
    //         $id=$data['student_id'];
    //     	$batch_id = $data['batch_id'];
    //     	$data['student_certificate']=$this->db_model->select_data('*','certificate',array('student_id'=>$id,'batch_id'=>$batch_id),1,array('id','desc'));
    //     	if(!empty($data['student_certificate'])){
    //     	    $data['certificate_details']=$this->db_model->select_data('*','certificate_setting','',1,array('id','desc'));
    //         	$data['site_details_logo']=$this->db_model->select_data('site_logo','site_details','',1,array('id','desc'));
    //         	$data['student_details']=$this->db_model->select_data('name','students',array('id'=>$id),1,array('id','desc'));
    //         	$data['batchdata']=$this->db_model->select_data('batch_name','batches',array('id'=>$batch_id),1,array('id','desc'));
    //         	$data['baseurl'] = base_url();
    //             $html=	$this->load->view("student/certificate_pdf",$data,true); 
    //             $this->load->library('pdf'); // change to pdf_ssl for ssl
    //             $filename = "certificate_".$id."_".$batch_id;
    //             $result=$this->pdf->create($html);
                
    //             $file_path= explode("application",APPPATH);
    //             file_put_contents($file_path[0].'uploads/certificate/'.$filename.'.pdf', $result);
    //             $arr = array(
    //                 'fileName' => $filename.'.pdf',
    //                 'filesUrl' => base_url('uploads/certificate/'),
    //                 'status' => 'true',
    //                 'msg' => $this->lang->line('ltr_fetch_successfully')
    //             );
    //         }else{
    //             $arr = array(
    //                 'status' => 'false',
    //                 'msg' => $this->lang->line('ltr_no_record_msg')
    //             );
    //         }
    //     }else{
    //         $arr = array(
    //             'status'=>'false',
    //             'msg'=>$this->lang->line('ltr_missing_parameters_msg')
    //         );
    //     }
    //     echo json_encode($arr);
    // }
    
    function apply_leave(){
        $data = $_REQUEST;
            if(!empty($data['from_date']) && !empty($data['to_date']) && !empty($data['subject']) && !empty($data['uid'])){
        
                $data_arr['from_date'] = date('Y-m-d', strtotime($data['from_date']));
                $data_arr['to_date'] = date('Y-m-d', strtotime($data['to_date']));
                $data_arr['subject'] = $data['subject'];
                $data_arr['leave_msg'] = $data['leave_msg'];
                $data_arr['student_id'] = $data['uid'];
                $data_arr['admin_id'] = 1;
                $data_arr['status'] = 0; 
                $Datediff = strtotime($data['to_date']) - strtotime($data['from_date']);               
                $data_arr['total_days'] = abs(round($Datediff / 86400)); 
                
                $data_arr = $this->security->xss_clean($data_arr);
                $ins = $this->db_model->insert_data('leave_management',$data_arr);
                if($ins==true){
                    $resp = array('status'=>'true','msg'=>$this->lang->line('ltr_leave_apply_msg'));
                }else{
                    $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_leave_apply_msg'));
                }
            }else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
    function view_leave(){
        $data = $_REQUEST;
            if(!empty($data['uid'])){
                $student_id = $data['uid'];
                $leave_data = $this->db_model->select_data('id,status, subject, leave_msg as leaveMsg, from_date as fromDate, to_date as toDate, total_days as totalDays, added_at as addedAt','leave_management',array('student_id'=>$student_id),'',array('id','desc'));
		   
                if(!empty($leave_data)){
                    $resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'), 'leaveData'=>$leave_data);
                }else{
                    $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
                }
            }else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
    function view_subject_list(){
        $data = $_REQUEST;
            if(!empty($data['batch_id'])){
                $batch_id = $data['batch_id'];
                $arrayData=array();
                if(!empty($batch_id) && empty($data['subject_id']) && empty($data['teacher_id'])){
                    $arrayData= array('batch_id'=>$batch_id);
                    
                }else if(!empty($batch_id) && !empty($data['subject_id']) && empty($data['teacher_id'])){
                    
                    $arrayData= array(
                                    'batch_id'=>$batch_id,
                                    'subject_id'=>$data['subject_id']
                                    );
                    
                }else if(!empty($batch_id) && !empty($data['subject_id']) && !empty($data['teacher_id'])){
                    
                    $arrayData= array(
                                    'batch_id'=>$batch_id,
                                    'subject_id'=>$data['subject_id'],
                                    'teacher_id'=>$data['teacher_id']
                                    );
                    
                }
                
                $sub_data = $this->db_model->select_data('id,teacher_id as teacherId, subject_id as subjectId, chapter','batch_subjects',$arrayData,'',array('id','desc'));
                
                if(!empty($sub_data)){
                    foreach($sub_data as $key=>$value){
                        
                        $sub_name = $this->db_model->select_data('id, subject_name','subjects',array('id'=>$value['subjectId']),'',array('id','desc'));
                        
                        $sub_data[$key]['subjectName']= !empty($sub_name)?$sub_name[0]['subject_name']:'';
                        if(!empty($batch_id) && (!empty($data['subject_id']) || !empty($data['teacher_id']))){
                            $teacher_name = $this->db_model->select_data('id, name','users',array('id'=>$value['teacherId']),'',array('id','desc'));
                            
                            $sub_data[$key]['teacherData']= !empty($teacher_name)?$teacher_name:'';
                            
                            $chap_id =implode(', ', json_decode($value['chapter']));
                            $chapterCon = "id in ($chap_id)";
        	                $chapterName = $this->db_model->select_data('id,chapter_name','chapters',$chapterCon,'');
        	                if(!empty($chapterName)){
        	                    
                                $sub_data[$key]['chapterData']=$chapterName;
        	                }else{
        	                    $sub_data[$key]['chapterData']='';
        	                }
                    
                        }
                        
                        unset($sub_data[$key]['teacherId']);
                        unset($sub_data[$key]['chapter']);
                        
    	                
                    }
                    
                    
                    
                    $resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'), 'subjectData'=>$sub_data);
                }else{
                    $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
                }
            }else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
	
	function doubts_class_ask(){
        $data = $_REQUEST;
      
		if(!empty($data['batch_id']) && !empty($data['subject_id']) && !empty($data['student_id'])){
			$batch_id = $data['batch_id'];
			
			$arrayData=array(
							'student_id'=>$data['student_id'],
							'batch_id'=>$data['batch_id'],
							'subjects_id'=>$data['subject_id'],
							);
			if(!empty($data['teacher_id'])){
				$arrayData['teacher_id']= $data['teacher_id'];
			}
			
			if(!empty($data['chapter_id'])){
				$arrayData['chapters_id']= $data['chapter_id'];
			}
			
			if(!empty($data['description'])){
				$arrayData['users_description']= $data['description'];
			}
			
			
		    	 $adm_id = $this->db_model->select_data('*','sudent_batchs',array('student_id'=>$data['student_id'],'batch_id'=>$data['batch_id']));
			$arrayData['admin_id']= $adm_id[0]['admin_id'];
			$checkusers = $this->db_model->select_data('doubt_id','student_doubts_class',array('teacher_id'=>$data['teacher_id'],'batch_id'=>$data['batch_id'],'status'=>0,'student_id'=>$data['student_id'],'subjects_id'=>$data['subject_id'],'chapters_id'=>$data['chapter_id']),'',array('doubt_id ','desc'));
			if(empty($checkusers)){
				/*$coundUsers = count($this->db_model->select_data('doubt_id ','student_doubts_class',array('teacher_id'=>$data['teacher_id'],'batch_id'=>$data['batch_id']),'',array('doubt_id ','desc')));
				
				if($coundUsers<=10){*/
					$data_arr = $this->security->xss_clean($arrayData);
					$ins = $this->db_model->insert_data('student_doubts_class',$data_arr);
					
					$doubts_data = array(
									'doubtId'=>$ins,
									'teacherId'=>$data['teacher_id'],
									'studentId'=>$data['student_id'],
									'batchId'=>$data['batch_id'],
									'subjectsId'=>$data['subject_id'],
									'chaptersId'=>$data['chapter_id'],
									'usersDescription'=>$data['description'],
									'teacherDescription'=>'',
									'appointmentDate'=>'',
									'appointmentTime'=>'',
									'createAt'=>date('Y-m-d H:i:s'),
									'status'=>0
									);
					
					$resp = array('status'=>'true','msg'=>$this->lang->line('ltr_doubt_request_msg'), 'doubtsData'=>$doubts_data);
				/*}else{
					$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_something_msg'));
				}*/
				
			}else{
				$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_doubt_request_already_msg'));
			}
		}else{
			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
		} 
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
	
	function get_doubts_ask(){
        $data = $_REQUEST;
		if(!empty($data['student_id'])){
			$adm_id = $this->db_model->select_data('*','students',array('id'=>$data['student_id']));
	    	if($this->session->userdata('role')==1){
                $cond = array('admin_id'=>$_SESSION['uid']);
                if(!empty($get['subject'])){
                    $cond.=" subjects_id=".$get['subject'];
                }
            }else{
                $cond = "teacher_id = $tid";
                if(!empty($get['subject'])){
                    $cond.=" AND subjects_id=".$get['subject'];
                }
            }
			$checkusers = $this->db_model->select_data('doubt_id as doubtId, student_id as studentId, teacher_id as teacherId, batch_id as batchId, subjects_id as subjectsId, chapters_id as chaptersId, users_description as usersDescription, teacher_description as teacherDescription, appointment_date as appointmentDate, appointment_time as appointmentTime, create_at as createAt, status','student_doubts_class',array('student_id'=>$data['student_id'],'batch_id'=>$adm_id[0]['batch_id']),'',array('doubtId ','desc'));
			if(!empty($checkusers)){
				
				foreach($checkusers as $key=>$value){
					
					$teaNam= $this->db_model->select_data('name','users',array('id'=>$value['teacherId']),'',array('id ','desc'));
					$batchNam= $this->db_model->select_data('batch_name','batches',array('id'=>$value['batchId']),'',array('id ','desc'));
					$subNam= $this->db_model->select_data('subject_name','subjects',array('id'=>$value['subjectsId']),'',array('id ','desc'));
					$chrNam= $this->db_model->select_data('chapter_name','chapters',array('id'=>$value['chaptersId']),'',array('id ','desc'));
					
					$checkusers[$key]['teacherName'] = !empty($teaNam[0]['name'])?$teaNam[0]['name']:'';
					$checkusers[$key]['batchName'] = !empty($batchNam[0]['batch_name'])?$batchNam[0]['batch_name']:'';
					$checkusers[$key]['subjectName'] = !empty($subNam[0]['subject_name'])?$subNam[0]['subject_name']:'';
					$checkusers[$key]['chapterName'] = !empty($chrNam[0]['chapter_name'])?$chrNam[0]['chapter_name']:'';
				}
				$resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'), 'doubtsData'=>$checkusers);
				
			}else{
				$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
			}
		}else{
			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
		} 
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
	function pay_batch_fee(){
			$data = $_REQUEST;
			if(!empty($data['student_id']) && !empty($data['batch_id'])){
				
				$batch_type =$this->db_model->select_data('batch_type','batches use index (id)',array('id'=>$data['batch_id']),1)[0]['batch_type'];
				
				if($batch_type==2){
					if(!empty($data['transaction_id']) && !empty($data['amount'])){
					
						$chackPayment =$this->db_model->select_data('*','student_payment_history ',array('batch_id'=>$data['batch_id'],'student_id'=>$data['student_id']));
					
						if(empty($chackPayment)){
							$refer_type = $this->general_settings('refer_type');
        					$refer_type_amount = $this->general_settings('refer_type_amount');
        					$commissionAmt = $refer_type_amount;
        					
        					if($refer_type == 2){
        					    $amount= !empty($data['amount'])?$data['amount']:0;
        					    $commissionAmt = ($amount * $refer_type_amount)/100;
        					}
        					$walletAmount =$this->db_model->select_data('*','students use index (id)',array('id'=>$studentData[0]['referred_by']),1);
    					    $totalAmount = $walletAmount[0]['wallet'] + $commissionAmt;
        					$this->db_model->update_data_limit('students use index (id)',array('wallet'=>$totalAmount),array('id'=>$studentData[0]['referred_by']),1);
        					
        					$data_pay=array(
							              'student_id'=>$data['student_id'],
										  'batch_id'=>$data['batch_id'],
										  'transaction_id'=>$data['transaction_id'],
										  'amount'=>$data['amount'],
										  'c_mode'=>$refer_type,
										  'comission'=>$commissionAmt,
											);
							$data_pay = $this->security->xss_clean($data_pay);
        					$ins = $this->db_model->insert_data('student_payment_history',$data_pay);
						}else{
							$arr = array(
								'status'=>'false',
								'msg'=>$this->lang->line('ltr_payment_already')
							);
							echo json_encode($arr);
						    die();
						}
						
					}else{
						$arr = array(
							'status'=>'false',
							'msg'=>$this->lang->line('ltr_missing_parameters_msg'),

						);
						echo json_encode($arr);
						die();
					}
					
				}
				
					//update app version and login status                  
					$this->db_model->update_data_limit('students use index (id)',array('status'=>1,'batch_id'=>$data['batch_id'],'payment_status'=>1),array('id'=>$data['student_id']),1);
					
					$batchData =$this->db_model->select_data('*','batches use index (id)',array('id'=>$data['batch_id']),1);
					
					$studentData =$this->db_model->select_data('id as studentId,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image,password,token','students use index (id)',array('id'=>$data['student_id']),1);
						$studentData[0]['batchName']=!empty($batchData)?$batchData[0]['batch_name']:'';
						$studentData[0]['image']= base_url('uploads/students/').$studentData[0]['image'];
						$studentData[0]['password'] = $studentData[0]['password'];
						
						$studentData[0]['transactionId'] = !empty($data['transaction_id'])?$data['transaction_id']:'';
        				$studentData[0]['amount'] = !empty($data['amount'])?$data['amount']:'';
						
					$arr = array('status'=>'true', 'msg' =>$this->lang->line('ltr_payment_processed'),'studentData'=>$studentData[0]);
				
				
			}else{
				$arr = array(
					'status'=>'false',
					'msg'=>$this->lang->line('ltr_missing_parameters_msg')
				); 
			}
			echo json_encode($arr);
    }
	
	function get_payment_history(){
        $data = $_REQUEST;
		if(!empty($data['student_id'])){
			
			$payData= $this->db_model->select_data('id, batch_id as batchId,transaction_id as transactionId, amount, create_at as createAt','student_payment_history',array('student_id'=>$data['student_id']),'',array('id ','desc'));
			if(!empty($payData)){
				foreach($payData as $key=>$value){
					$batchData =$this->db_model->select_data('*','batches use index (id)',array('id'=>$value['batchId']),1);
					
					$payData[$key]['batchName'] =!empty($batchData)?$batchData[0]['batch_name']:'';
					$payData[$key]['startDate'] =!empty($batchData)?$batchData[0]['start_date']:'';
					$payData[$key]['endDate'] =!empty($batchData)?$batchData[0]['end_date']:'';
					$payData[$key]['startTime'] =!empty($batchData)?$batchData[0]['start_time']:'';
					$payData[$key]['endTime'] =!empty($batchData)?$batchData[0]['end_time']:'';
					$payData[$key]['batchType'] =!empty($batchData)?$batchData[0]['batch_type']:'';
					$payData[$key]['batchPrice'] =!empty($batchData)?$batchData[0]['batch_price']:'';
					$payData[$key]['description'] =!empty($batchData)?$batchData[0]['description']:'';
					$payData[$key]['status'] =!empty($batchData)?$batchData[0]['status']:'';
					$payData[$key]['batchOfferPrice'] =!empty($batchData)?$batchData[0]['batch_offer_price']:'';
					$payData[$key]['currencyCode'] = $this->general_settings('currency_code');
					$payData[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
				}
				$resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'), 'paymentData'=>$payData);
				
			}else{
				$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
			}
		}else{
			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
		} 
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
    function convertCurrency($amount,$from_currency,$to_currency){
          $apikey = $this->general_settings('currency_converter_api');
        
          $from_Currency = urlencode($from_currency);
          $to_Currency = urlencode($to_currency);
          $query =  "{$from_Currency}_{$to_Currency}";
        
          // change to the free URL if you're using the free version
          @$json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
          $obj = json_decode($json, true);
        
          $val = floatval($obj["$query"]);
        
        
          $total = $val * $amount;
          return number_format($total, 2, '.', '');
        }
    public function SendMail($tomail='', $subject='', $msg=''){
            $frommail =$this->general_settings('smtp_mail');
            $frompwd =$this->general_settings('smtp_pwd');
            $title = $this->db_model->select_data('site_title','site_details','',1,array('id','desc'))[0]['site_title'];

            $this->load->library('email');
            $config = array();
            $config['protocol'] = $this->general_settings('server_type');
            $config['smtp_host'] = $this->general_settings('smtp_host');
            $config['smtp_port'] = $this->general_settings('smtp_port');
            $config['smtp_user'] = $frommail;
            $config['smtp_pass'] = $frompwd;
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
            $config['newline'] = "\r\n";
             $this->email->initialize($config);
            // Set to, from, message, etc.
            
            $this->email->from($frommail, $title);
            $this->email->to($tomail);
            
            $this->email->subject($subject);
            $this->email->message($msg);
            
           @$this->email->send();
            return true;
        }
        
        
         function mailTesting(){
            $this->SendMailInvoice("jainshubham090@gmail.com", "Test");
        }
        
        
       
        
        function check_batch(){
            $data = $_REQUEST;
    		if(!empty($data['email'])){
    		    $check_email = $this->db_model->select_data('*','students',array('email'=>trim($_POST['email'])));
    		    $check_email_t = $this->db_model->select_data('*','users',array('email'=>trim($_POST['email'])));
    		    if(!empty($check_email_t)){
    		        $resp = array('isEmailExist'=>'true');
    		        echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    		        die();
    		    }
    		    if(!empty($check_email)){
    		        $check_batch = $this->db_model->select_data('*','batches',array('id'=>$check_email[0]['batch_id'],'status'=>1));
    		        if(!empty($check_batch)){
    		            $resp = array('isEmailExist'=>'true');
    		        }else{
    		            $resp = array('isEmailExist'=>'false');
    		        }
    		    }else{
    		        $resp = array('isEmailExist'=>'false');
    		    }
    		}else{
    			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
    		} 
    		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
         function reset_password(){
            $data = $_REQUEST;
            if(!empty($data['email'])){
                $check_email = $this->db_model->select_data('*','students',array('email'=>trim($_POST['email'])));
                if(!empty($check_email)){
                    $this->load->library('email');
                    $frommail =$this->general_settings('smtp_mail');
                    $frompwd =$this->general_settings('smtp_pwd');
                    $config = array();
                    $config['protocol'] = $this->general_settings('server_type');
                    $config['smtp_host'] = $this->general_settings('smtp_host');
                    $config['smtp_port'] = $this->general_settings('smtp_port');
                    $config['smtp_user'] = $frommail;
                    $config['smtp_pass'] = $frompwd;
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
                    $config['newline'] = "\r\n";
                    
                    $a=str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                    $pwd = substr($a, 0, 5);
                    
                    $subj = 'Recover your account password '.$this->common->siteTitle;
                    $em_msg = 'Hi '.ucwords($userDetails[0]['name']).',<br/><br/>We have received your request to reset your account password.<br/><br/>Here is your new password : '.$pwd.'<br/><br/> This is an auto-generated email. Please do not reply to this email.';
                    
                    $from_email = $this->common->siteOwnerEmail;
                    $this->email->initialize($config);
                    $this->email->from($from_email, 'Admin'); 
                    $this->email->to($_POST['email']);
                    $this->email->subject($subj); 
                    $this->email->message($em_msg);
                    if($this->email->send()){
                        $data = array( 
                            'password'=>md5($pwd)
                        );
                        $data = $this->security->xss_clean($data);
                        $this->db_model->update_data('students',$data, array('email'=>$_POST['email']));
    
                        $resp = array(
                            'status'=>'true',
                            'msg'=>'We\'ve sent an email to '.$_POST['email'].'.' 
                        );
                    }
                    else{
                        $resp = array(
                            'status'=>'false',
                            'msg'=>$this->lang->line('ltr_something_msg')
                        );
                    }
                }else{
                    $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_email_not_exists_msg'));
                }
            }else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        //new update
        function list_book_notes_paper(){
            
                       

            $data = $_REQUEST;
    		if(!empty($data['student_id']) && !empty($data['batch_id'])){
    		    
    		    if(!empty($data['student_id'])){
                    $this->viewNotificationStatus($data['student_id'],'book_notes_paper');
                 }
                if(!empty($data['subject_id'])){
                    
                    $like = array('batch','"'.$data['batch_id'].'"');
                    
                     $cond = array('status'=>1,'subject'=>$data['subject_id']);
                     if(!empty($data['chapter_id'])){
                         $cond = array('status'=>1,'subject'=>$data['subject_id'],'topic' => $data['chapter_id']);
                     }
                    
        		    $book_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',$cond,'',array('page_order','asc'),$like);
        		    if(!empty($book_pdf)){
        		        foreach($book_pdf as $key=>$value){
        		            $book_pdf[$key]['url']= base_url('uploads/book/');
        		        }
        		    }
        		    $notes_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',$cond,'',array('page_order','asc'),$like);
        		    if(!empty($notes_pdf)){
        		        foreach($notes_pdf as $key=>$value){
        		            $notes_pdf[$key]['url']= base_url('uploads/notes/');
        		        }
        		    }
        		    
                    $newexampaper =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',$cond,'',array('page_order','asc'),$like);
        		    if(!empty($newexampaper)){
        		        foreach($newexampaper as $key=>$value){
        		            $newexampaper[$key]['url']= base_url('uploads/oldpaper/');
        		        }
        		    }
        		    
                }else{
                    
                    $like = array('batch','"'.$data['batch_id'].'"');
        		    $book_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
        		    if(!empty($book_pdf)){
        		        foreach($book_pdf as $key=>$value){
        		            $book_pdf[$key]['url']= base_url('uploads/book/');
        		        }
        		    }
        		    $notes_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
        		    if(!empty($notes_pdf)){
        		        foreach($notes_pdf as $key=>$value){
        		            $notes_pdf[$key]['url']= base_url('uploads/notes/');
        		        }
        		    }
        		    
                    $newexampaper =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like);
        		    if(!empty($newexampaper)){
        		        foreach($newexampaper as $key=>$value){
        		            $newexampaper[$key]['url']= base_url('uploads/oldpaper/');
        		        }
        		    }
    		    
                    
                }
    		    
    		    
    		     $resp = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_fetch_successfully'),
                            'bookPdf'=> $book_pdf,
                            'notesPdf'=> $notes_pdf,
                            'oldPapers'=>$newexampaper,
                        );
    		    
    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        
        function list_subject_by_book(){
            $data = $_REQUEST;
    		if(!empty($data['student_id']) && !empty($data['batch_id'])){
    		    
    		    if(!empty($data['student_id'])){
                    $this->viewNotificationStatus($data['student_id'],'book_notes_paper');
                 }
    		    $like = array('batch','"'.$data['batch_id'].'"');
    		    $book_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like,'','subject');
    		    if(!empty($book_pdf)){
    		        foreach($book_pdf as $key=>$value){
    		            $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$book_pdf[$key]['subject']),'',array('subject_name','desc'));
    		            $book_pdf[$key]['name']= $subject_pdf[0]['subject_name'];
    		        }
    		    }
    		    $notes_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like,'','subject');
    		    if(!empty($notes_pdf)){
    		        foreach($notes_pdf as $key=>$value){
    		             $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$notes_pdf[$key]['subject']),'',array('subject_name','desc'));
    		             $notes_pdf[$key]['name']= $subject_pdf[0]['subject_name'];
    		        
    		        }
    		    }
    		    
                $newexampaper =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like,'','subject');
    		    if(!empty($newexampaper)){
    		        foreach($newexampaper as $key=>$value){
    		               $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$newexampaper[$key]['subject']),'',array('subject_name','desc'));
    		               $newexampaper[$key]['name']= $subject_pdf[0]['subject_name'];
    		        }
    		    }
    		    
    		     $resp = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_fetch_successfully'),
                            'bookPdf'=> $book_pdf,
                            'notesPdf'=> $notes_pdf,
                            'oldPapers'=>$newexampaper,
                        );
    		    
    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        function list_subject_free_quiz(){
            $data = $_REQUEST;
            $fetchSubject = $this->db_model->custom_query_data('SELECT subject_id FROM free_quizs where status = 1 AND subject_id != 0 GROUP by subject_id  ORDER BY `free_quizs`.`subject_id` ASC');
            
            $array = [];
            $mSub = [];
            if(!empty($fetchSubject)){
                foreach($fetchSubject as $key=>$value){
                     $msubjectId = $value['subject_id'];
                     $getSubjectIds = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$msubjectId));
                     $array["subject_id"] = $msubjectId;
                     $array["subjectname"] = $getSubjectIds[0]['subject_name'];
                     $mSub[] = $array;
                    
                }
            }
            
            $arr = array(
                'subjectList' => $mSub,
                'status' => 'true',
                'msg' => $this->lang->line('ltr_fetch_successfully')
            ); 
        
        echo json_encode($arr);
    		  
    }
        
        function list_chapter_by_freequiz(){
            $data = $_REQUEST;
    		if(!empty($data['subject_id'])){
    		    
    		   $exam_list = $this->db_model->custom_query_data('SELECT chapter_id FROM free_quizs where status = 1 AND subject_id = '.$data['subject_id'].' GROUP by chapter_id  ORDER BY `free_quizs`.`chapter_id` ASC');
    		    
    		    $array = [];
                $mSub = [];
                if(!empty($exam_list)){
                    foreach($exam_list as $key=>$value){
                         $mCHapterId = $value['chapter_id'];
                        $getChapterIds = $this->db_model->select_data('id,chapter_name','chapters use index (id)',array('id'=>$mCHapterId));
                        $array["chapter_id"] = $mCHapterId;
                        $array["chaptername"] = $getChapterIds[0]['chapter_name'];
                        $mSub[] = $array;
                    }
            }
            
                $resp = array(
                    'chapterList' => $mSub,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                );

    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }

        
        
        function list_subject_by_exam(){
            $data = $_REQUEST;
    		if(!empty($data['type'])){

    		    $exam_list =$this->db_model->select_data('id,subject_id','exams use index (id)',array('status'=>1,'subject_id != '=>0,'type'=>$data['type'],'batch_id'=>$data['batch_id']),'',array('id','desc'),'','','subject_id');
    		    if(!empty($exam_list)){
    		        foreach($exam_list as $key=>$value){
    		            $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$exam_list[$key]['subject_id']),'',array('subject_name','desc'));
    		            $exam_list[$key]['subjectname']= $subject_pdf[0]['subject_name'];
    		        }
    		    }
    		    
    		    
              $resp = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_fetch_successfully'),
                            'subjectList'=> $exam_list,
                        );
    		    
    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        
        
        
        function list_chapter_by_note(){
            $data = $_REQUEST;
    		if(!empty($data['student_id']) && !empty($data['batch_id'])  && !empty($data['subject_id'])){
    		    
    		    if(!empty($data['student_id'])){
                    $this->viewNotificationStatus($data['student_id'],'book_notes_paper');
                 }
    		    $like = array('batch','"'.$data['batch_id'].'"');
    		    $book_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like,'','subject');
    		    if(!empty($book_pdf)){
    		        foreach($book_pdf as $key=>$value){
    		            $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$book_pdf[$key]['subject']),'',array('subject_name','desc'));
    		            $book_pdf[$key]['name']= $subject_pdf[0]['subject_name'];
    		        }
    		    }
    		    
    		    $notes_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',array('status'=>1,'subject'=>$data['subject_id']),'',array('id','desc'),$like,'','topic');
    		    if(!empty($notes_pdf)){
    		        foreach($notes_pdf as $key=>$value){
    		             $subject_pdf = $this->db_model->select_data('id,chapter_name','chapters use index (id)',array('id'=>$notes_pdf[$key]['topic']),'',array('chapter_name','desc'));
    		             $notes_pdf[$key]['name']= $subject_pdf[0]['chapter_name'];
    		        
    		        }
    		    }
    		    
                $newexampaper =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',array('status'=>1),'',array('id','desc'),$like,'','subject');
    		    if(!empty($newexampaper)){
    		        foreach($newexampaper as $key=>$value){
    		               $subject_pdf = $this->db_model->select_data('id,subject_name','subjects use index (id)',array('id'=>$newexampaper[$key]['subject']),'',array('subject_name','desc'));
    		               $newexampaper[$key]['name']= $subject_pdf[0]['subject_name'];
    		        }
    		    }
    		    
    		     $resp = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_fetch_successfully'),
                            'bookPdf'=> $book_pdf,
                            'notesPdf'=> $notes_pdf,
                            'oldPapers'=>$newexampaper,
                        );
    		    
    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        
        
        function list_chapter_by_exam(){
            $data = $_REQUEST;
    		if(!empty($data['student_id']) && !empty($data['batch_id']) && !empty($data['type'])  && !empty($data['subject_id'])){
    		    
    		    $like = array('batch','"'.$data['batch_id'].'"');
    		    $exam_list =$this->db_model->select_data('id,chapter_id','exams use index (id)',array('status'=>1,'chapter_id != '=>0,'subject_id'=>$data['subject_id'],'type'=>$data['type'],'batch_id'=>$data['batch_id']),'',array('id','desc'),'','','chapter_id');
    		    if(!empty($exam_list)){
    		        foreach($exam_list as $key=>$value){
    		            $subject_pdf = $this->db_model->select_data('id,chapter_name','chapters use index (id)',array('id'=>$exam_list[$key]['chapter_id']),'',array('chapter_name','desc'));
    		            $exam_list[$key]['chaptername']= $subject_pdf[0]['chapter_name'];
    		        }
    		    }
    		    
    		     $resp = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_fetch_successfully'),
                            'chapterList'=> $exam_list,
                        );
    		    
    		}else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
       
        
        
        function changeMyBatch(){
            
            
            
//             ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


            $data = $_REQUEST;
            
            	$this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
            	
            	
    		if(!empty($data['student_id']) && !empty($data['batch_id'])){
    		    
    		    if(!empty($data['isBundleBuy']) && $data['isBundleBuy'] == 1){
    		        
    		        if(!empty($data['bundle_id']) && !empty($data['student_id']) && !empty($data['transaction_id'])){
    		            $bundle_data = $this->db_model->select_data('tbl_bundles.*','tbl_bundles use index (id)',array('id' => $data['bundle_id']));
                        if(!empty($bundle_data)){
                            $data_bundle_payments=array(
            					'student_id'=>$data['student_id'],
            					'bundle_id'=>$data['bundle_id'],
            					'transaction_id'=> $data['transaction_id'],
            					'price'=> $bundle_data[0]['price'],
            					'date'=> date('d-m-Y'),
            				);
        									
                            $this->db_model->insert_data('bundle_payments',$data_bundle_payments);
                            
                            $bundle_batch_list_array = $this->db_model->select_data('tbl_bundle_batches.batch_id','tbl_bundle_batches use index (id)',array('bundles_id' => $bundle_data[0]['id']));
                        
                            if(!empty($bundle_batch_list_array)){
                                foreach($bundle_batch_list_array as $bundle_batch_list_array_val){
                                    
                                    $checkBatch =$this->db_model->select_data('*','sudent_batchs',array('batch_id'=>$bundle_batch_list_array_val['batch_id'],'student_id'=>$data['student_id']),1);
                                    if(empty($checkBatch)){
                                        
                                         $data_student_batch=array(
                    					'student_id'=>$data['student_id'],
                    					'batch_id'=>$bundle_batch_list_array_val['batch_id'],
                    					'status'=> 0,
                    					'added_by'=> 'student',
                    					'admin_id'=> 1,
                    					'batch_activation_id'=> 0,
                    				    );
                									
                                        $this->db_model->insert_data('sudent_batchs',$data_student_batch);
                                    }
                                }
                            }
                         
                        $studentData =$this->db_model->select_data('id as studentId,password,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,referred_by as referred_by,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token','students use index (id)',array('id'=>$data['student_id']),1);
        				$studentData[0]['batchName']='';
        				$studentData[0]['image']= base_url('uploads/students/').$studentData[0]['image'];
        				$studentData[0]['password'] = $studentData[0]['image'];
        				$studentData[0]['paymentType'] = $this->general_settings('payment_type');
        				$studentData[0]['languageName'] = $this->general_settings('language_name');
        				
                         $resp = array('status'=>'true', 'msg' =>$this->lang->line('ltr_batch_change_msg'),'studentData'=>$studentData[0]);

                    }else{
                        $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));
                    }
                
                	 
                    }
        	        
    		    }else{
    		        $checkBatch =$this->db_model->select_data('*','sudent_batchs',array('batch_id'=>$data['batch_id'],'student_id'=>$data['student_id']),1);
    		        if(!empty($checkBatch)){
    		        
        		    $studentData =$this->db_model->select_data('id as studentId,password,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,referred_by as referred_by,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token','students use index (id)',array('id'=>$data['student_id']),1);
    				$studentData[0]['batchName']='';
    				$studentData[0]['image']= base_url('uploads/students/').$studentData[0]['image'];
    				$studentData[0]['password'] = $studentData[0]['image'];
    				$studentData[0]['paymentType'] = $this->general_settings('payment_type');
    				$studentData[0]['languageName'] = $this->general_settings('language_name');
    				
    				 //check batch type
    				$batch_type =$this->db_model->select_data('*','batches use index (id)',array('id'=>$data['batch_id']),1);
    				
    			    if(!empty($batch_type)){
    			        $studentData[0]['batchName']= $batch_type[0]['batch_name'];
    			        $studentData[0]['batchId']= $batch_type[0]['id'];
    			        if($batch_type[0]['batch_type']==2){
        			            
        			        $batch_his=   $this->db_model->select_data('*','student_payment_history',array('batch_id'=>$data['batch_id'], 'student_id'=>$data['student_id']),1);
        					$studentData[0]['transactionId'] = !empty($batch_his[0]['transaction_id'])?$batch_his[0]['transaction_id']:'';
        			    	$studentData[0]['amount'] = !empty($batch_his[0]['amount'])?$batch_his[0]['amount']:'';
    			            
    			        }else{
    			            $studentData[0]['transactionId'] = 'free';
    			    	    $studentData[0]['amount'] = '';
    			        }
    			    	$update_value =array('batch_id'=>$data['batch_id']);
    				}else{
    				    $resp = array('status'=>'false', 'msg' =>$this->lang->line('ltr_batch_in_msg'));
    				}
    				
    			    
    			    $this->db_model->update_data_limit('students use index (id)',$update_value,array('id'=>$data['student_id']),1);
    			    
    			    $refer_type = $this->general_settings('refer_type');
    					$refer_type_amount = $this->general_settings('refer_type_amount');
    					$commissionAmt = $refer_type_amount;
    					
    					if($refer_type == 2){
    					    $amount= !empty($data['amount'])?$data['amount']:0;
    					    $commissionAmt = ($amount * $refer_type_amount)/100;
    					}
    					
    					$walletAmount =$this->db_model->select_data('*','students use index (id)',array('id'=>$studentData[0]['referred_by']),1);
    					if(!empty($walletAmount)){
    					  $getWalletAmount = $this->db_model->custom_query_data('SELECT SUM(comission) as commisionAmt  FROM `students` LEFT JOIN student_payment_history ON students.id = student_payment_history.student_id  WHERE `referred_by` = '.$studentData[0]['referred_by'].' AND  student_payment_history.transaction_id != "" ');
    					    $totalWalletAmount = $getWalletAmount[0]['commisionAmt'];
    					    
    					   $getWithdrawSum = $this->db_model->custom_query_data("Select SUM(amount) as totalWithdrawl from withdrawal_history Where student_id=".$studentData[0]['referred_by']." AND status='1'");
    					   $totalWithDrawAmount = $getWithdrawSum[0]['totalWithdrawl'];
    					   
    					   $finalAmount = $totalWalletAmount - $totalWithDrawAmount;
    					   $this->db_model->update_data_limit('students use index (id)',array('wallet'=>$finalAmount),array('id'=>$studentData[0]['referred_by']),1);
    			   		}
    				
    				$accessBatch = $batch_type[0]['access'];	 
    			    $enrolid = $studentData[0]['enrollmentId'];
    			    $resp = array('status'=>'true', 'msg' =>$this->lang->line('ltr_batch_change_msg'),'studentData'=>$studentData[0],'batchAccess' => $accessBatch);
    			
    			   
    		    }else{
    		        
        		    $studentData =$this->db_model->select_data('id as studentId,enrollment_id,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,referred_by as referred_by,app_version as versionCode, batch_id as batchId,admin_id,admission_date as admissionDate, image, token','students use index (id)',array('id'=>$data['student_id']),1);
    				$studentData[0]['batchName']='';
    				$studentData[0]['image']= base_url('uploads/students/').$studentData[0]['image'];
    				$studentData[0]['paymentType'] = $this->general_settings('payment_type');
    				$studentData[0]['languageName'] = $this->general_settings('language_name');
    				
    				 //check batch type
    				$batch_type =$this->db_model->select_data('*','batches use index (id)',array('id'=>$data['batch_id']),1);
    			
					if(!empty($batch_type)){
        				    $admin_ids = $batch_type[0]['admin_id'];
				    }else{
				            $admin_ids = 0;
				    }
				    
				    
    				$studentData[0]['batchId']= $batch_type[0]['id'];
    			    if($batch_type[0]['batch_type']==2){
    			        $studentData[0]['batchName']= $batch_type[0]['batch_name'];
    					
    					$refer_type = $this->general_settings('refer_type');
    					$refer_type_amount = $this->general_settings('refer_type_amount');
    					$commissionAmt = $refer_type_amount;
    					
    					if($refer_type == 2){
    					    $amount= !empty($data['amount'])?$data['amount']:0;
    					    $commissionAmt = ($amount * $refer_type_amount)/100;
    					} 
    					
    					$walletAmount =$this->db_model->select_data('*','students use index (id)',array('id'=>$studentData[0]['referred_by']),1);
    					if(!empty($walletAmount)){
    					    $getWalletAmount = $this->db_model->custom_query_data('SELECT SUM(comission) as commisionAmt  FROM `students` LEFT JOIN student_payment_history ON students.id = student_payment_history.student_id  WHERE `referred_by` = '.$studentData[0]['referred_by'].' AND  student_payment_history.transaction_id != "" ');
    					    $totalWalletAmount = $getWalletAmount[0]['commisionAmt'];
    					    
    					   $getWithdrawSum = $this->db_model->custom_query_data("Select SUM(amount) as totalWithdrawl from withdrawal_history Where student_id=".$studentData[0]['referred_by']." AND status='1'");
    					   $totalWithDrawAmount = $getWithdrawSum[0]['totalWithdrawl'];
    					   
    					   $finalAmount = $totalWalletAmount - $totalWithDrawAmount;


    				  	    //$totalAmount = $walletAmount[0]['wallet'] + $commissionAmt;
    				    	$this->db_model->update_data_limit('students use index (id)',array('wallet'=>$finalAmount),array('id'=>$studentData[0]['referred_by']),1);
    					}
    					
    							
    					$fetchInvoiceId =$this->db_model->select_data('*','student_payment_history',array('mode'=>'Online'),1,array('id','desc'));
                        $addLastInvoiceId = $fetchInvoiceId[0]['invoice_id']+1 ;
                        
                        $modeOfPayment = 'Undefined';
                        if(!empty($data['transaction_id']) && $data['transaction_id'] != 'Cash'){
                            $modeOfPayment = 'Online';
                        }

	
    					$data_pay=array(  
    					           'student_id'=>$data['student_id'],
    						       'batch_id'=>$data['batch_id'],
    							   'transaction_id'=> !empty($data['transaction_id'])?$data['transaction_id']:'',
    							   'amount'=> !empty($data['amount'])?$data['amount']:'',
    							   'admin_id'=>$admin_ids,
    							   'mode'=>$modeOfPayment,
    							   'invoice_id'=>$addLastInvoiceId,
    							   'c_mode'=>$refer_type,
								   'comission'=>$commissionAmt,
    									);
    					$data_pay = $this->security->xss_clean($data_pay);
    					$insf = $this->db_model->insert_data('student_payment_history',$data_pay);	
    					
    					
    				

                       $this->SendMailInvoice($studentData[0]['userEmail'],$data['student_id'],$data['batch_id'],$insf);
                    

                    
    					
    					$studentData[0]['transactionId'] = !empty($data['transaction_id'])?$data['transaction_id']:'';
    			    	$studentData[0]['amount'] = !empty($data['amount'])?$data['amount']:'';
    			    	$update_value =array(
    			    	    'payment_status'=>1,
    			    	    'batch_id'=>$data['batch_id']
    			    	    );
    				}else{
    				    $studentData[0]['batchName']= $batch_type[0]['batch_name'];
    			    	$studentData[0]['transactionId'] = 'free';
    			    	$studentData[0]['amount'] = !empty($amount)?$amount:'';
    			    	$update_value =array(
    			    	    'batch_id'=>$data['batch_id']
    			    	    );
    				}
    			    
    			    $this->db_model->update_data_limit('students use index (id)',$update_value,array('id'=>$data['student_id']),1);
    			    if($studentData[0]['admin_id']==0){
    			        $update_value =array(
    			    	    'admin_id'=>$batch_type[0]['admin_id']
    			    	    );
    				    // $data_arr = $batch_type[0]['admin_id'];
    				    $this->db_model->update_data_limit('students use index (id)',$update_value,array('id'=>$data['student_id']),1);
    				}
    				
    				$accessBatch = $batch_type[0]['access'];
    				
    				$resp = array('status'=>'true', 'msg' =>$this->lang->line('ltr_account_created'),'studentData'=>$studentData[0],'batchAccess' => $accessBatch);
    				//batch asin
    			    $data_batch= array(
    			                 'student_id'=>$data['student_id'],
    			                 'batch_id'=>$data['batch_id'],
    			                 'added_by'=>'student',
    			                 'admin_id'=>$admin_ids
    					                 );
    		 	   $this->db_model->insert_data('sudent_batchs',$data_batch);
    			    // send email 
    			     $enrolid = $studentData[0]['enrollment_id'];
    			    $title = $this->db_model->select_data('site_title','site_details','',1,array('id','desc'))[0]['site_title'];
                    $subj = $title.'- '.$this->lang->line('ltr_credentials');
                    $em_msg = $this->lang->line('ltr_hey').' '.ucwords($studentData[0]['fullName']).', '.$this->lang->line('ltr_congratulation').' <br/><br/>'.$this->lang->line('ltr_successfully_enrolled').'<br/><br/>'.$this->lang->line('ltr_login_details').'<br/><br/> '.$this->lang->line('ltr_enrolment_id').' : '.$enrolid.'<br/>';
                    //$this->SendMail($data['email'], $subj, $em_msg);
        		  }
    		        
    		    }
    	        
            }else{
                $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
            } 
            echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        }
        
        
         public function SendMailInvoice($tomail,$studentID,$batchID,$paymentHistoryID){
            
//                     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$studentData =$this->db_model->select_data('id as studentId,password,student_state,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,referred_by as referred_by,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token','students use index (id)',array('id'=>$studentID),1);
	    $batchData =$this->db_model->select_data('*','batches',array('id'=>$batchID),1);
	    $batch_his=   $this->db_model->select_data('*','student_payment_history',array('id'=>$paymentHistoryID),1);
	    $siteSetting = $this->db_model->select_data('*','site_details','',1);

	    $invoiceData['invoiceDate'] = date('Y-m-d');
        $invoiceData['transactionId'] = $batch_his[0]['transaction_id'];
        $invoiceData['amount'] = $batch_his[0]['amount'];
        $invoiceData['name'] = $studentData[0]['fullName'];
        $invoiceData['mobileNumber'] = $studentData[0]['mobile'];
        $invoiceData['studentEmail'] = $studentData[0]['userEmail'];
        $invoiceData['actualPrice'] = $batchData[0]['batch_price'];
        $invoiceData['batchOfferPrice'] = $batchData[0]['batch_offer_price'];
        $invoiceData['transactionDate'] = date('Y/m/d',strtotime($batch_his[0]['create_at']));
        $invoiceData['invoiceId'] = $siteSetting[0]['enrollment_word']."-".$batch_his[0]['invoice_id'];
        $invoiceData['isGST'] = $siteSetting[0]['isGST'];
        $invoiceData['gstNumber'] = $siteSetting[0]['gst_number'];
        $invoiceData['site_minilogo'] = $siteSetting[0]['site_minilogo'];
        
        if($studentData[0]['student_state'] == $siteSetting[0]['state']){
           $percentage = 9;
           $totalPayableAmount = $batchData[0]['batch_offer_price'];
           $gstAmount = ($percentage / 100) * $totalPayableAmount;
           
	       $invoiceData['IGST'] = $gstAmount;
	       $invoiceData['CGST'] = $gstAmount;
	       $invoiceData['gstAmount'] = 0;
	   }else{
	       $percentage = 18;
           $totalPayableAmount = $batchData[0]['batch_offer_price'];
           $gstAmount = ($percentage / 100) * $totalPayableAmount;
        
	       $invoiceData['IGST'] = 0;
	       $invoiceData['CGST'] = 0;
	       $invoiceData['gstAmount'] = $gstAmount;
	   }
	   
        
        $invoiceData['amountInWords'] = $this->getIndianCurrency($totalPayableAmount);

        $newEndingDate = date("Y/m/d", strtotime(date("Y-m-d", strtotime($batch_his[0]['create_at'])) . " + 1 year"));
        $invoiceData['oneYearPlus']= $newEndingDate;
                    
        $html = $this->load->view('invoice',$invoiceData,TRUE);
        $this->load->library('pdf');
        //$html = $this->output->get_output();
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        $file_path= explode("application",APPPATH);
        //echo $file_path[0]; die;
        //$this->dompdf->folder($file_path[0].'uploads/');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        //$this->dompdf->stream($file_path[0].'uploads/invoice/invouce1.pdf', array("Attachment"=>0));
        file_put_contents($file_path[0].'uploads/invoice/invoice1.pdf',$this->dompdf->output());
        

                    
            $frommail =$this->general_settings('smtp_mail');
            $frompwd =$this->general_settings('smtp_pwd');
            $title = $this->db_model->select_data('site_title','site_details','',1,array('id','desc'))[0]['site_title'];

            $this->load->library('email');
            $config = array();
            $config['protocol'] = $this->general_settings('server_type');
            $config['smtp_host'] = $this->general_settings('smtp_host');
            $config['smtp_port'] = $this->general_settings('smtp_port');
            $config['smtp_user'] = $frommail;
            $config['smtp_pass'] = $frompwd;
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['smtp_crypto'] = $this->general_settings('smtp_encryption');
            $config['newline'] = "\r\n";
            $this->email->initialize($config);
            // Set to, from, message, etc.

            $this->email->from($frommail, $title);
            $this->email->to($tomail);
            $this->email->subject("Invoice");
            $this->email->attach($file_path[0].'uploads/invoice/invoice1.pdf');
            $this->email->message("Please find the invoice");
            $this->email->send();
            return true;
        }
        
        
        function getIndianCurrency(float $number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
        
        
    function download_invoice($studentID,$batchID,$paymentHistoryID){
	    
	    $studentData =$this->db_model->select_data('id as studentId,password,email as userEmail,name as fullName,enrollment_id as enrollmentId,contact_no as mobile,referred_by as referred_by,app_version as versionCode, batch_id as batchId,admin_id as adminId,admission_date as admissionDate, image, token','students use index (id)',array('id'=>$studentID),1);
	    $batchData =$this->db_model->select_data('*','batches',array('id'=>$batchID),1);
	    $batch_his=   $this->db_model->select_data('*','student_payment_history',array('id'=>$paymentHistoryID),1);
	    $siteSetting = $this->db_model->select_data('*','site_details','',1);

	    $invoiceData['invoiceDate'] = date('Y-m-d');
        $invoiceData['transactionId'] = $batch_his[0]['transaction_id'];
        $invoiceData['amount'] = $batch_his[0]['amount'];
        $invoiceData['name'] = $studentData[0]['fullName'];
        $invoiceData['mobileNumber'] = $studentData[0]['mobile'];
        $invoiceData['studentEmail'] = $studentData[0]['userEmail'];
        $invoiceData['actualPrice'] = $batchData[0]['batch_price'];
        $invoiceData['batchOfferPrice'] = $batchData[0]['batch_offer_price'];
        $invoiceData['transactionDate'] = date('Y/m/d',strtotime($batch_his[0]['create_at']));
        $invoiceData['invoiceId'] = $siteSetting[0]['enrollment_word']."-".$batch_his[0]['invoice_id'];
        $invoiceData['isGST'] = $siteSetting[0]['isGST'];
        $invoiceData['gstNumber'] = $siteSetting[0]['gst_number'];
        $invoiceData['site_minilogo'] = $siteSetting[0]['site_minilogo'];

        
        $percentage = 18;
        $totalPayableAmount = $batchData[0]['batch_offer_price'];
        $new_width = ($percentage / 100) * $totalPayableAmount;
        
        $invoiceData['gstAmount'] = $new_width;
        $invoiceData['amountInWords'] = $this->getIndianCurrency($totalPayableAmount);

        $newEndingDate = date("Y/m/d", strtotime(date("Y-m-d", strtotime($batch_his[0]['create_at'])) . " + 1 year"));
        $invoiceData['oneYearPlus']= $newEndingDate;
                    
        $html = $this->load->view('invoice',$invoiceData,TRUE);
        $this->load->library('pdf');
        //$html = $this->output->get_output();
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        $file_path= explode("application",APPPATH);
        //echo $file_path[0]; die;
        //$this->dompdf->folder($file_path[0].'uploads/');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream($file_path[0].'uploads/invoice/invoice1.pdf', array("Attachment"=>0));
        //file_put_contents($file_path[0].'uploads/invoice/invouce1.pdf',$this->dompdf->output());
    	echo "test";
    }
    
    
    function db_new_changes_all_batch(){
        $data =	$_REQUEST;
        if(isset($data['admin_id']) && isset($data['student_id'])){
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            //$batch_id = $data['batch_id'];
            
            $last_login = $this->db_model->select_data('last_login_app','students use index(id)',array('id'=>$student_id),1);
            
            if($last_login[0]['last_login_app'] != '0000-00-00 00:00:00'){
                $batch_details = $this->db_model->select_data('*','sudent_batchs ',array('student_id'=>$student_id),'','','',array('batches','batches.id=sudent_batchs.batch_id'));
                foreach($batch_details as $batch_detail){
                $lastLoginTime = $last_login[0]['last_login_app'];
                $batch_id = $batch_detail['batch_id'];
                $likeEX = array('batch_id','"'.$batch_id.'"');
                $extraData = $this->db_model->select_data('extra_classes.id,extra_classes.admin_id as adminId,extra_classes.date, extra_classes.start_time as startDate,extra_classes.end_time as endTime,extra_classes.teacher_id as teacherId,extra_classes.description,extra_classes.status,extra_classes.batch_id as batchId,extra_classes.added_at as addedAt,extra_classes.completed_date_time as completedDateTime,users.name,users.teach_gender as teachGender','extra_classes use index(id)',array('extra_classes.admin_id'=>$admin_id,'extra_classes.added_at >= '=>$lastLoginTime,'date >=' => date('Y-m-d')),'',array('date','desc'),$likeEX,array('users','users.id = extra_classes.teacher_id'));
                $extraClass =array();
                if(!empty($extraData)){
                    foreach($extraData as $key=>$value){
                        $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'extraClass'));
                        if(empty($view_n)){
                            $extraClass[$key]=$value;
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $extraClass[$key]=$value;
                            }
                        }
                    }
                }
                
                $homewrk = $this->db_model->select_data('homeworks.id, homeworks.admin_id as adminId,homeworks.teacher_id as teacherId, homeworks.date,homeworks.subject_id as subjectId, homeworks.batch_id as batchId, homeworks.description,homeworks.added_at as addedAt,users.name,users.teach_gender as teachGender,subjects.subject_name as subjectName','homeworks use index (id)',array('homeworks.admin_id'=>$admin_id,'homeworks.added_at >= '=>$lastLoginTime,'homeworks.batch_id'=>$batch_id,'date >=' => date('Y-m-d')),'',array('id','desc'),'',array('multiple',array(array('users','users.id = homeworks.teacher_id'),array('subjects','subjects.id = homeworks.subject_id'))),'');
                $homewrkData=array();
                if(!empty($homewrk)){
                    foreach($homewrk as $key=>$value){
                     $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'homeWork'));
                        if(empty($view_n)){
                            $homewrkData[$key]=$value;
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $homewrkData[$key]=$value;
                            }
                        }
                    }
                }
                
                $likev = array('batch','"'.$batch_id.'"');
                $videosData = $this->db_model->select_data('id,admin_id as adminId,title,batch,topic,subject,url,status,added_by as addedBy,added_at as addedAt, video_type as videoType','video_lectures use index (id)',array('admin_id'=>$admin_id,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$likev);
                $videos =array();
               
                if(!empty($videosData)){
                    foreach($videosData as $key=>$value){
                        $sub_id =$this->db_model->select_data('subject_id','batch_subjects',array('batch_id'=>$batch_id),1);
                        if(!empty($sub_id)){
                            $sub_name =$this->db_model->select_data('subject_name','subjects',array('id'=>$sub_id[0]['subject_id']),1);
                            if(!empty($sub_name)){
                               // if($sub_name[0]['subject_name']==$value['subject']){
                                    $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'videoLecture'));
                                    if(empty($view_n)){
                                        $videos[$key]=$value;
                                        $url = $value['url'];
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                        $videos[$key]['videoId']=$match[1];
                                    }else{
                                        if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                            $videos[$key]=$value;
                                            $url = $value['url'];
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                                        $videos[$key]['videoId']=$match[1];
                                        }
                                    }
                            //  }
                            }
                        }
                        
                    }
                }
                
                $vacancyData = $this->db_model->select_data('id,title,description,start_date as startDate,last_date as lastDate,mode,files,status,admin_id as adminId,added_at as addedAt','vacancy use index (id)',array('admin_id'=>$admin_id,'last_date >= '=> date("Y-m-d"),'status'=>1,'added_at >='=>$lastLoginTime),'',array('id','desc'));
                $vacancy=array();
                if(!empty($vacancyData)){
                    foreach($vacancyData as $key=>$value){
                        $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'vacancy'));
                        if(empty($view_n)){
                            $vacancy[$key]=$value;
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $vacancy[$key]=$value;
                            }
                        }
                    }
                }
                
                $noticesData = $this->db_model->select_data('`id`, `title`, `description`, `notice_for` as noticeFor, `status`, `date`, `admin_id` as adminId, `student_id` as studentId, `teacher_id` as teacherId, `added_at` as addedAt, `added_by` as addedBy, `read_status` as readStatus','notices use index (id)',"admin_id = $admin_id AND status = 1 AND (notice_for = 'Student' OR notice_for = 'Both' OR student_id = $student_id) AND added_at >= '$lastLoginTime' AND date >= CURDATE()",'',array('id','desc'));
                
                $notices=array();
                if(!empty($noticesData)){
                    foreach($noticesData as $key=>$value){
                        $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'notices'));
                        if(empty($view_n)){
                            $notices[$key]=$value;
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $notices[$key]=$value;
                            }
                        }
                    }
                }
                
                $practice_paper = $this->db_model->select_data('id,name,time_duration as timeDuration, added_at as addedAt, total_question as totalQuestion','exams use index (id)',array('type'=>2,'status'=>1,'batch_id'=>$batch_id,'added_at >='=>$lastLoginTime),'',array('id','desc'));
                
                 $newexampaper_test = array();       
                if(!empty($practice_paper)){
                    foreach($practice_paper as $key=>$pexam){
                            $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id'=>$student_id,'notice_type'=>'practicePaper'));
                            $paperstatus = $this->db_model->select_data('id','practice_result use index (id)',array('admin_id' => $admin_id,'student_id' => $student_id,'paper_id' => $pexam['id']),1);
                         
                            if(empty($paperstatus) && empty($view_n)){
                               // array_push($newexampaper_test,$pexam); 
                               $newexampaper_test[$key]=$pexam;
                            }else{
                                if(!empty($view_n)){
                        
                                    if(strtotime($view_n[0]['views_time'])<strtotime($pexam['addedAt'])){
                                        $newexampaper_test[$key]=$pexam;
                                        
                                      }
                                  
                                }
                            }
                        }
                    }
                    
                    
                $mock_paper = $this->db_model->select_data('id,name,time_duration as timeDuration, added_at as addedAt, total_question as  totalQuestion,mock_sheduled_date as mockSheduledDate,mock_sheduled_time as mockSheduledTime','exams use index (id)',array('type' => 1,'admin_id' => $admin_id,'status' => 1,'batch_id' => $batch_id,'mock_sheduled_date >=' => date('Y-m-d'),'added_at >='=>$lastLoginTime),'',array('id','desc'));
               
                $newexampaper = array();          
                if(!empty($mock_paper)){
                    foreach($mock_paper as $exam){
                            $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'mockPaper'));
                            $paperstatus = $this->db_model->select_data('id','mock_result use index (id)',array('admin_id' => $admin_id,'student_id' => $student_id,'paper_id' => $exam['id']),1);
                            if($exam['mockSheduledDate']==date('Y-m-d')){
                                if(strtotime($exam['mockSheduledTime'])>strtotime(date('H:i:s'))){
                                    if(empty($paperstatus) && empty($view_n)){
                                array_push($newexampaper,$exam); 
                                    }else{
                                        if(!empty($view_n)){
                                            if(strtotime($view_n[0]['views_time'])<strtotime($exam['addedAt'])){
                                                array_push($newexampaper,$exam);
                                              }
                                          
                                        }
                                    }
                                }
                            }else{
                                if(empty($paperstatus) && empty($view_n)){
                                array_push($newexampaper,$exam); 
                                    }else{
                                        if(!empty($view_n)){
                                            if(strtotime($view_n[0]['views_time'])<strtotime($exam['addedAt'])){
                                                array_push($newexampaper,$exam);
                                              }
                                          
                                        }
                                    }
                            }
                         
                            
                        }
                    }
                    
                $addNewBook=array();
                $like = array('batch','"'.$batch_id.'"');
    		    $book_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','book_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
    		    if(!empty($book_pdf)){
    		        foreach($book_pdf as $key=>$value){
    		            $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'book_notes_paper'));
                        if(empty($view_n)){
                            $addNewBook[$key]=$value;
                            $addNewBook[$key]['url']= base_url('uploads/book/');
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $addNewBook[$key]=$value;
                                $addNewBook[$key]['url']= base_url('uploads/book/');
                            }
                        }
    		        }
    		    }
    		    
    		    $addNewNotes=array();
    		    $notes_pdf =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','notes_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
    		    if(!empty($notes_pdf)){
    		        foreach($notes_pdf as $key=>$value){
    		            
    		            $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'book_notes_paper'));
                        if(empty($view_n)){
                            $addNewNotes[$key]=$value;
                            $addNewNotes[$key]['url']= base_url('uploads/notes/');
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $addNewNotes[$key]=$value;
                                $addNewNotes[$key]['url']= base_url('uploads/notes/');
                            }
                        }
    		        }
    		    }
    		    
    		    $addOldPaper=array();
                $newexampaper =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,  status, added_by as addedBy, added_at as addedAt','old_paper_pdf use index (id)',array('status'=>1,'added_at >= '=>$lastLoginTime),'',array('id','desc'),$like);
    		    if(!empty($newexampaper)){
    		        foreach($newexampaper as $key=>$value){
    		            
    		            $view_n =$this->db_model->select_data('views_time','views_notification_student',array('student_id >= '=>$student_id,'notice_type'=>'book_notes_paper'));
                        if(empty($view_n)){
                            $addOldPaper[$key]=$value;
                            $addOldPaper[$key]['url']= base_url('uploads/oldpaper/');
                        }else{
                            if(strtotime($view_n[0]['views_time'])<strtotime($value['addedAt'])){
                                $addOldPaper[$key]=$value;
                                $addOldPaper[$key]['url']= base_url('uploads/oldpaper/');
                            }
                        }
    		        }
    		    }
    		    $classdata=array();
    		    $classdata = current($this->db_model->select_data('users.name,users.teach_image AS teachImage,subjects.subject_name as subjectName,chapters.chapter_name as chapterName,live_class_history.end_time as endTime','live_class_history',array('batch_id'=>$batch_id),'1',array('live_class_history.id','desc'),'',array('multiple',array(array('users','users.id = live_class_history.uid'),array('subjects','subjects.id = live_class_history.subject_id'),array('chapters','chapters.id = live_class_history.chapter_id')))));
                $exam = $this->db_model->select_data('id,name','exams  use index (id)',array('batch_id'=>$batch_id,'type'=>1,'mock_sheduled_date <='=>date('Y-m-d')),'1',array('id','desc'));
            $top_three = $this->db_model->select_data('mock_result.paper_name as paperName,students.name,students.image,mock_result.percentage','mock_result  use index (id)',array('paper_id'=>$exam[0]['id'],'mock_result.percentage >'=>0),'3',array('mock_result.percentage','desc'),'',array('students','students.id=mock_result.student_id'));
                $arr_dd = array(
                    'topThreeData' => $top_three,
                    'filesUrl' => base_url('uploads/students/')
                );
    		         
    		         
                $arr1[] = array(
                    'batchName'=>$batch_detail['batch_name'],
                    'batchId'=>$batch_detail['id'],
                    'extraClass'=> $extraClass,
                    'homeWork'=>$homewrkData,
                    'videoLecture'=>$videos,
                    'vacancy'=>$vacancy,
                    'notices'=>$notices,
                    'practicePaper'=>$newexampaper_test,
                    'mockPaper'=>$newexampaper,
                    'addOldPaper'=>$addOldPaper,
                    'addNewBook'=>$addNewBook,
                    'addNewNotes'=>$addNewNotes,
                    'liveClass' => ($classdata['endTime']=='' && !empty($classdata))?$classdata:null,
                    'topThree' => $arr_dd,
                ); 
                }
                $arr['status']='true';
                $arr['msg']= $this->lang->line('ltr_fetch_successfully');
                $arr['noticesCount']=count($notices) + count($extraClass) + count($homewrkData) + count($videos) + count($vacancy) + count($addNewNotes) + count($addNewBook) + count($addOldPaper) + count($newexampaper) + count($newexampaper_test);
                $arr['data']=$arr1;
                
            }else{
                $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_its_first_login'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
    
    function get_syllabus_data(){
        
          $data =	$_REQUEST;
          
        if(isset($data['batch_id'])){
            $join = array('batch_subjects',"batch_subjects.batch_id = batches.id");
            $batchData = $this->db_model->select_data('batch_subjects.*, batches.batch_name as batchName','batches use index (id)',array('status'=>1,'batch_id'=>$data['batch_id']),'',array('id','desc'),'',$join);  
           
          if(!empty($batchData)){
              
            foreach($batchData as $key => $value){
                            
            $data_arr['batchId'] = $batchData[$key]['batch_id']; 
            $data_arr['batchName'] = $batchData[$key]['batchName'];
            $data_arr['teacherId'] = $batchData[$key]['teacher_id'];
            // $data_arr['chapterStatus']=implode(', ',json_decode($batchData[$key]['chapter_status']));
             $batchSubject = $this->db_model->select_data('subjects.id,subjects.subject_name as subjectName, batch_subjects.chapter','subjects use index (id)',array('batch_id'=>$data_arr['batchId']),'',array('id','desc'),'',array('batch_subjects','batch_subjects.subject_id=subjects.id'));
				
					   if(!empty($batchSubject)){
					       
					       foreach($batchSubject as $skey=>$svalue){
					            $cid=implode(', ',json_decode($svalue['chapter']));
					            $complete_id = json_decode($value['chapter_status']);
					           
					            $con ="id in ($cid)";
					            $chapter = $this->db_model->select_data('id,chapter_name as chapterName','chapters use index (id)',$con,'',array('id','desc'));
					            
					            if(!empty($chapter)){
					                foreach($chapter as $ckey=>$cvalue){
					                    if (isset($complete_id))
                                        {
    					                    if (in_array($cvalue['id'], $complete_id))
                                            {
                                                 
                                                $chapter[$ckey]['complete'] = true;
                                            }
                                            else
                                            {
                                                $chapter[$ckey]['complete'] = false;
                                            }
                                        }
                                        else
                                        {
                                            $chapter[$ckey]['complete'] = false;
                                        }
                                        					                   
					              
					                }

					                $batchSubject[$skey]['chapter']= $chapter;
					               
					                 
					              
					            }else{
					             $batchSubject[$skey]['chapter']=array();   
					            }
					            
					       }
					       
					       $data_arr['batchSubject']= $batchSubject;
					   }else{
					     $data_arr['batchSubject'] = array();  
					   }
            }
                      
                   
              $arr = array(
                 'data' => $data_arr,
                'status'=>'True',
                'msg'=>$this->lang->line('ltr_fetch_successfully')
            ); 
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_no_record_msg')
            ); 
        }
 }
        else{  
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg')
            ); 
        }
        echo json_encode($arr);
    }
  
  
    function get_all_data(){
    $data = $_REQUEST;
    
    $subcat = $data['subcat'];
    if(!empty($subcat)){
        if(isset($data['length']) && $data['length']>0){
            if(isset($data['start']) && !empty($data['start'])){
                $limit = array($data['length'],$data['start']);
            }else{ 
                $limit = array($data['length'],0);
            }
        }else{
            $limit = '';
        }
        
        $slider_limit = $data['limit'];
        $category = $this->db_model->select_data('id as categoryId,name as categoryName','batch_category use index (id)',array('status'=>1));
        
        if(!empty($category)){
            foreach($category as $catkey=>$value){
                $cond = array('status'=>1,'cat_id'=>$value['categoryId'],'id'=>$subcat);
                $subCategory = $this->db_model->select_data('id as SubcategoryId,name as SubcategoryName','batch_subcategory use index (id)',$cond,'','');
                
                if(!empty($subCategory)){
                    foreach($subCategory as $subkey=>$value){
                        $search = trim($data['search']);
                        if(!empty($search)){
                            $like_search = array('batch_name',$search);
                            $cond_sub1='';
                        } else {
                            $like_search = '';
                            $cond_sub1 = array('status'=>1,'sub_cat_id'=>$value['SubcategoryId']);
                        }
                        
                        $batchData = $this->db_model->select_data('id, batch_name as batchName, start_date as startDate, end_date as endDate, start_time as startTime, end_time as endTime, batch_type as batchType, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice, duration_type, total_validity, validity_in, batch_expiry','batches use index (id)',$cond_sub1,$limit,array('id','desc'),$like_search);
                        
                        if(!empty($batchData)){
                            foreach($batchData as $key=>$val){
                                if(!empty($val['batchImage'])){
                                    $batchData[$key]['batchImage'] = base_url('uploads/batch_image/').$val['batchImage'];
                                }
                                $startDate = $val['startDate'];
                                $endDate = $val['endDate'];
                                $batchData[$key]['startDate'] = date('d-m-Y',strtotime($startDate));
                                $batchData[$key]['endDate'] = date('d-m-Y',strtotime($endDate));
                                
                                $batchData[$key]['durationType'] = $val['duration_type']."";
                                $batchData[$key]['totalValidity'] = $val['total_validity']."";
                                $batchData[$key]['validityIn'] = $val['validity_in']."";
                                $batchData[$key]['batchExpiry'] = $val['batch_expiry']."";
                                
                                $batch_fecherd = $this->db_model->select_data('batch_specification_heading as batchSpecification, batch_fecherd as fecherd','batch_fecherd',array('batch_id'=>$val['id']));
                                if(!empty($batch_fecherd)){
                                    $batchData[$key]['batchFecherd'] = $batch_fecherd;
                                } else {
                                    $batchData[$key]['batchFecherd'] = array();
                                }
                                
                                $batchData[$key]['paymentType'] = $this->general_settings('payment_type');
                                $batchData[$key]['currencyCode'] = $this->general_settings('currency_code');
                                $batchData[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
                            }
                        }
                    }
                }
            }
            
            $arr = array(
                'data' => $batchData,
                'status' => 'true',
                'msg' => $this->lang->line('ltr_fetch_successfully')
            );
        } else {
            $arr = array(
                'status' => 'false',
                'msg' => $this->lang->line('ltr_no_record_msg')
            );
        }
    } else {
        $arr = array(
            'status' => 'false',
            'msg' => $this->lang->line('ltr_missing_parameters_msg')
        );
    }
    echo json_encode($arr);
}
    
    function random_strings($length_of_string) 
    { 
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
        
        $rString =  substr(str_shuffle($str_result), 0, $length_of_string); 
        
        return $rString;
    } 
    
    function hasUniqueReferralCode($referralCode)
    {
    // check against database to enforce uniqueness
    $student = $this->db_model->select_data('*','students use index (id)',array('affiliate_id'=>$referralCode),1);
        if(!empty($student)){
            return false; 
        }
        return true;
    }
    
    function findReferralId($referralCode)
    {
    // check against database to enforce uniqueness
    $student = $this->db_model->select_data('*','students use index (id)',array('affiliate_id'=>$referralCode),1);
        if(!empty($student)){
            return $student[0]['id']; 
        }
        return 0;
    }
    
    function add_withdraw(){
        $data = $_REQUEST;
        $amount =(double)$data['amount'];
         $student = $this->db_model->select_data('*','students use index (id)',array('id'=>$data['student_id']),1);
        if(!empty($student) && $student[0]['wallet'] > 0){
       
        if($amount > 1000){
		if(!empty($data['student_id'])){
			
				$data_pay=array(
    					           'student_id'=>$data['student_id'],
    						       'mode'=>$data['mode'],
    							   'detail'=> !empty($data['detail'])?$data['detail']:'',
    								  'amount'=> !empty($data['amount'])?$data['amount']:''
    									);
		
				$this->db_model->insert_data('withdrawal_history',$data_pay);
				
				$this->db_model->update_data_limit('students use index (id)',array('wallet'=>0),array('id'=>$data['student_id']),1);
				
				$resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'), 'paymentData'=>$data_pay);
				
			
		}else{
			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
		}
        }else{
            $resp = array('status'=>'false','msg'=>'Minimum Amount 1000 Required'); 
        }
        }else{
            $resp = array('status'=>'false','msg'=>'wallet amount 0 or already process your withdrawal'); 
        }
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
    function get_refrrer_history(){
        $data = $_REQUEST;
		if(!empty($data['student_id'])){
			
			$payData= $this->db_model->select_data('*','withdrawal_history',array('student_id'=>$data['student_id']),'',array('id ','desc'));
			

        $refData = $this->db_model->custom_query_data('select * from `students` LEFT JOIN `student_payment_history` on `student_payment_history`.`student_id`=`students`.`id` where `students`.`referred_by` = '.$data['student_id']);
			

			$studentData= $this->db_model->select_data('*','students',array('	id'=>$data['student_id']),'',array('id ','desc'));
			
			if(!empty($payData)||!empty($refData)||!empty($studentData)){
				
				foreach($refData as $key=>$value){
				    
				    $batchData =$this->db_model->select_data('*','batches use index (id)',array('id'=>$value['batchId']),1);
					$refData[$key]['batchName'] =!empty($batchData)?$batchData[0]['batch_name']:'';
					
				}
				
				$getWalletAmount = $this->db_model->custom_query_data('SELECT SUM(comission) as commisionAmt  FROM `students` LEFT JOIN student_payment_history ON students.id = student_payment_history.student_id  WHERE `referred_by` = '.$data['student_id'].' AND  student_payment_history.transaction_id != "" ');
    		    $totalWalletAmount = $getWalletAmount[0]['commisionAmt'];
    					    
    			$getWithdrawSum = $this->db_model->custom_query_data("Select SUM(amount) as totalWithdrawl from withdrawal_history Where student_id=".$data['student_id']." AND status='1'");
    			$totalWithDrawAmount = $getWithdrawSum[0]['totalWithdrawl'];
    			
    			$walletAmount = $totalWalletAmount - $totalWithDrawAmount;
    					   
    			//$getWalletAmount = $this->db_model->custom_query_data('SELECT students.id,name,student_payment_history.transaction_id  FROM `students` LEFT JOIN student_payment_history ON students.id = student_payment_history.student_id  WHERE `referred_by` = '.$data['student_id'].' AND  student_payment_history.transaction_id != "" ');

				
				//$walletAmount = $studentData[0]['wallet'];
				
				$resp = array('status'=>'true','msg'=>$this->lang->line('ltr_fetch_successfully'),'walletAmount'=>$walletAmount,'currencyDecimalCode'=>$this->general_settings('currency_decimal_code'), 'withdrawData'=>$payData, 'ReffrelData'=>$refData);
				
			}else{
				$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_no_record_msg'));
			}
		}else{
			$resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg')); 
		} 
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
        
    }
    
    
    function get_notification(){
        
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

            $notification = $this->db_model->select_data('*','notification','',40,array('id','desc'));
            if(!empty($notification)){
                
                
                
                foreach($notification as $key=>$value){
                    
                    
				    
				     if($notification[$key]['image'] != ""){
                       $notification[$key]['image'] = base_url().'uploads/notification/'.$notification[$key]['image'];
                    }else{
                         $notification[$key]['image'] = base_url().'uploads/notification/placeholder.png';
                    }
                    
				}
				
                $arr = array(
                    'notification' => $notification,
                    'status' => 'true',
                    'msg' => $this->lang->line('ltr_fetch_successfully')
                ); 
            }else{
                $arr = array(
                    'status' => 'false',
                    'msg' => $this->lang->line('ltr_no_record_msg')
                ); 
            }
            
        
        echo json_encode($arr);
    }
    
    // Add Comment Feature 7 May
    function add_comment(){
        
//                 ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
            $data = $_REQUEST;
            if(!empty($data['video_id']) && !empty($data['student_id']) && !empty($data['message'])){
                
                	$data_comment=array(
    					'student_id'=>$data['student_id'],
    					'video_id'=>$data['video_id'],
    					'message'=> $data['message'],
    					'created_date'=> date('Y-m-d H:i:s')
    				);
    									
                $this->db_model->insert_data('tbl_comment',$data_comment);
                $resp = array('status'=>'true','msg'=>'Comment has been added');  
            }else{
               $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));  
            }
            
           echo json_encode($resp);

    }
    
    
        function get_comment(){
//                             ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

             $data = $_REQUEST;
             $isCommentEnable = 0;
             if(!empty($data['video_id'])){
                 
                $checkCommentEnable = $this->db_model->select_data('*','video_lectures',array('id' => $data['video_id']),1,'');
                if(!empty($checkCommentEnable)){
                    $getCommentEnable = $checkCommentEnable[0]['comment_status'];
                    if($getCommentEnable != null){
        				// Need to do if needed
        				$isCommentEnable = $getCommentEnable;
        			}else{
        			    $isCommentEnable = 0;
        			}
                }

                 
                 $commentList = $this->db_model->select_data('*','tbl_comment',array('video_id' => $data['video_id']),50,array('comment_id','desc'));
                if(!empty($commentList)){
                        foreach($commentList as $key=>$value){
                             
                              $studentDetail = $this->db_model->select_data('*','students',array('id' => $commentList[$key]['student_id']),1,array('id','desc'));

        				     if($studentDetail[0]['image'] != ""){
                               $commentList[$key]['image'] = base_url().'uploads/students/'.$studentDetail[0]['image'];
                            }else{
                                 $commentList[$key]['image'] = base_url().'uploads/students/student_img.png';
                            }
                             $commentList[$key]['student_name']  = $studentDetail[0]['name'];
                             $commentList[$key]['created_date']  = date('d, M, H:i',strtotime($commentList[$key]['created_date']));
        				}
        				
        			    
                        $arr = array(
                            'commentList' => $commentList,
                            'status' => 'true',
                            'isCommentEnable'=> $isCommentEnable,  
                            'msg' => $this->lang->line('ltr_fetch_successfully')
                        ); 
                }else{
                        $arr = array(
                            'status' => 'false',
                            'isCommentEnable'=> $isCommentEnable,  
                            'msg' => $this->lang->line('ltr_no_record_msg')
                        ); 
                }
             }else{
                $arr = array('status'=>'false','isCommentEnable'=> $isCommentEnable,'msg'=>$this->lang->line('ltr_missing_parameters_msg'));  
             }

        
        echo json_encode($arr);
    }
    
    
    function add_activation_batch_code(){
        
//                 ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
            $data = $_REQUEST;
            if(!empty($data['uid']) && !empty($data['activation_code'])){
                
                    $checkCode = $this->db_model->select_data('*','batch_activation_code',array('code' => $data['activation_code']));
                    if(!empty($checkCode)){
                        if($checkCode[0]['isUsed'] == 0){
                            
                           $getBatch = $this->db_model->select_data('*','batch_activation',array('id' => $checkCode[0]['batch_activation_id']));

                            $checkBatch = $this->db_model->select_data('*','sudent_batchs',array('batch_id' => $getBatch[0]['batch_id'],'student_id' => $data['uid']));
                             if(!empty($checkBatch)){
                                 $resp = array('status'=>'true','msg'=>'You already registered this batch'); 
                                 
                             }else{

                                 
                                 
                                     $data_code=array(
                    					'student_id'=>$data['uid'],
                    					'batch_id'=>$getBatch[0]['batch_id'],
                    					'status'=> 0,
                    					'added_by'=> 'student',
                    					'admin_id' => 1,
                    				);
                									
                                    $this->db_model->insert_data('sudent_batchs',$data_code);
                                    
                                    
                                    $data_update['isUsed']= 1;
        				        	$this->db_model->update_data_limit('batch_activation_code',$data_update,array('id'=>$checkCode[0]['id']),1);
        					
                                    $resp = array('status'=>'true','msg'=>'Batch has been registered!'); 
                             }
                        }else{
                            $resp = array('status'=>'false','msg'=>'Seems batch code is already used, Please try some other code!'); 
                        }
                        
                    }else{
                        $resp = array('status'=>'false','msg'=>'Please enter valid batch activation code'); 
                    }
            }else{
               $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));  
            }
            
           echo json_encode($resp);

    }
    
    
    function getFreeLecture(){
//                             ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $freeLecture = $this->db_model->select_data('*','free_recorded_video','',50,array('id','desc'));
        
        if(!empty($freeLecture)){
                foreach($freeLecture as $key=>$value){
                    $url = $value['url'];
                    if($value['video_audio_type'] == 1){
                        $freeLecture[$key]['videoId']='';
                    }else{
                        $url = $value['url'];
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)){
                            $freeLecture[$key]['videoId']=$match[1];
                        }else{
                            $pattern = '/(?<=\/live\/)[^?&]*/';
                            if (preg_match($pattern, $url, $match)) {
                                $freeLecture[$key]['videoId'] =  $matches[0]; // Return the video ID
                            }else{
                                $freeLecture[$key]['videoId'] = "";
                            }
                        } 
                    }
                    
                }
                
                $arr = array(
                'freeLecture' => $freeLecture,
                'status' => 'true',
                'msg' => $this->lang->line('ltr_fetch_successfully')
                );
            
            }else{
            $arr = array(
                'status' => 'false',
                'msg' => $this->lang->line('ltr_no_record_msg')
            ); 
        }
            
        echo json_encode($arr);
    }
    
    
    function getFreeStudyMaterial(){
            $data = $_REQUEST;
    		$sutdy_material =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,type,  status','free_study_materials use index (id)',array('status'=>1,'parent_id' => 0),50,array('id','desc'),'');
        	if(!empty($sutdy_material)){
    	        foreach($sutdy_material as $key=>$value){
                    $sutdy_material[$key]['url']= base_url('uploads/book/');
               }
           }
           $resp = array(
             'status'=>'true',
             'msg'=>$this->lang->line('ltr_fetch_successfully'),
             'bookPdf'=> $sutdy_material,
           );
    	    echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    }
    
    function getFreeStudyMaterialFileByID($id){
            $data = $_REQUEST;
    		$sutdy_material =$this->db_model->select_data('id,admin_id as adminId, title, batch, topic, subject, file_name as fileName,type,  status','free_study_materials use index (id)',array('status'=>1,'parent_id'=>$id),50,array('id','desc'),'');
        	if(!empty($sutdy_material)){
    	        foreach($sutdy_material as $key=>$value){
                    $sutdy_material[$key]['url']= base_url('uploads/book/');
               }
           }
           $resp = array(
             'status'=>'true',
             'msg'=>$this->lang->line('ltr_fetch_successfully'),
             'bookPdf'=> $sutdy_material,
           );
    	    echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    }
    
    
    function getBatchByCategory($catId=NULL){
        if($catId == NULL){
            $resp = array(
             'status'=>'false',
             'msg'=>'Parameter missing',
           );
           echo json_encode($resp,JSON_UNESCAPED_SLASHES);
           die;
           
        }
        $cond = array('status'=>1,'cat_id'=>$catId);
		$batchData = $this->db_model->select_data('id, batch_name as batchName, start_date as startDate, end_date as endDate, start_time as startTime, end_time as endTime, batch_type as batchType, duration_type, total_validity, validity_in, batch_expiry, batch_price as batchPrice, no_of_student as noOfStudent ,status,description, batch_image as batchImage, batch_offer_price as batchOfferPrice','batches use index (id)',$cond,'',array('id','desc'),'');
       	if(!empty($batchData)){
					foreach($batchData as $key=>$value){
						if(!empty($value['batchImage'])){
							$batchData[$key]['batchImage']= base_url('uploads/batch_image/').$value['batchImage'];
						}
						$startDate =$value['startDate'];
						$endDate =$value['endDate'];
                        $batchData[$key]['startDate']=date('d-m-Y',strtotime($startDate));
                        $batchData[$key]['endDate']=date('d-m-Y',strtotime($endDate));
                        
                        $batchData[$key]['durationType']=$value['duration_type']."";
                        $batchData[$key]['totalValidity']=$value['total_validity']."";
                        $batchData[$key]['validityIn']=$value['validity_in']."";
                        $batchData[$key]['batchExpiry']=$value['batch_expiry']."";
                        $batchData[$key]['description']=$value['description']."";
                       
					   // add payment type
					   $batchData[$key]['paymentType'] = $this->general_settings('payment_type');
					   $batchData[$key]['currencyCode'] = $this->general_settings('currency_code');
					   $batchData[$key]['currencyDecimalCode'] = $this->general_settings('currency_decimal_code');
					   
					   $student_batch_dtail = $this->db_model->select_data('*','sudent_batchs',array('student_id'=>$data['student_id'],'batch_id' => $value['id'] ),'');
					   if(!empty($student_batch_dtail)){
					        $batchData[$key]['purchase_condition'] = true;
					   }else{
					       $batchData[$key]['purchase_condition'] = false;
					   }
					}
					
			$resp = array(
             'status'=>'true',
             'msg'=>$this->lang->line('ltr_fetch_successfully'),
             'batchData'=> $batchData,
           );		
        				
		}else{
		    $resp = array(
             'status'=>'false',
             'msg'=>'No Record Found!',
           );
		}
		
		echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    }
    
    
     function bundle_purchase(){
        
//  ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
            $data = $_REQUEST;
            if(!empty($data['bundle_id']) && !empty($data['student_id']) && !empty($data['transaction_id'])){
                
                $bundle_data = $this->db_model->select_data('tbl_bundles.*','tbl_bundles use index (id)',array('id' => $data['bundle_id']));
                
                if(!empty($bundle_data)){
                    
                    $data_bundle_payments=array(
    					'student_id'=>$data['student_id'],
    					'bundle_id'=>$data['bundle_id'],
    					'transaction_id'=> $data['transaction_id'],
    					'price'=> $bundle_data[0]['price'],
    					'date'=> date('d-m-Y'),
    				);
        									
                    $this->db_model->insert_data('bundle_payments',$data_bundle_payments);
                    
                    $bundle_batch_list_array = $this->db_model->select_data('tbl_bundle_batches.batch_id','tbl_bundle_batches use index (id)',array('bundles_id' => $bundle_data[0]['id']));
                
                    if(!empty($bundle_batch_list_array)){
                        foreach($bundle_batch_list_array as $bundle_batch_list_array_val){
                            
                            $data_student_batch=array(
            					'student_id'=>$data['student_id'],
            					'batch_id'=>$bundle_batch_list_array_val['batch_id'],
            					'status'=> 0,
            					'added_by'=> 'student',
            					'admin_id'=> 1,
            					'batch_activation_id'=> 0,
            				);
                									
                            $this->db_model->insert_data('sudent_batchs',$data_student_batch);
  
                        }
                        $resp = array('status'=>'true','msg'=>'Bundle has been purchased');
                    }else{
                        $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));
                    }
                }else{
                    $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));
                }
                
                	 
            }else{
               $resp = array('status'=>'false','msg'=>$this->lang->line('ltr_missing_parameters_msg'));  
            }
            
           echo json_encode($resp);

    }


    
}