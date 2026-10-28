<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/CreatorJwt.php';

class Exam extends CI_Controller {

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
		
		$this->objOfJwt = new CreatorJwt();


    }
    
    
    

     function mytoken($liveSettingId = NULL){
         
//                   ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



         $data = $_REQUEST;
             
             $zoomDetail =  ""; 
             if($liveSettingId == NULL){
                 $zoomDetail = $this->db_model->select_data('*','live_class_setting','',1);
             }else{
                 $zoomDetail = $this->db_model->select_data('*','live_class_setting',array('id' => $liveSettingId),1);
             }
             
             $meeting_client_key = $zoomDetail[0]['meeting_client_key'];
             $meeting_secret_key = $zoomDetail[0]['meeting_secret_key'];
             
             //$meeting_client_key = 'k6z_C_zrSWyw_QJ2s4M9Wg';
             //$meeting_secret_key = 'm2wkUVkPMRZXMextg4OURJYm9JPUu4m2';
            
             $tokenex =  time()+9000;
            $data = array(
            "appKey" => $meeting_client_key,
            "iat" => time(),
            "exp" => $tokenex,
            "tokenExp" => $tokenex
            );
            
            
            
            $token = $this->objOfJwt->GenerateToken($data,$meeting_secret_key);
            echo $token;
    }
 
    function general_settings($key_text=''){
        $data = $this->db_model->select_data('*','general_settings',array('key_text'=>$key_text),1);
        return $data[0]['velue_text'];
    }
    
    function free_quiz(){
        $data = $_REQUEST;
        if(isset($data['student_id'])){
            $exam_type = $data['exam_type'];
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            
            $subject_id = $data['subject_id'];
            $chapter_id = $data['chapter_id'];
            
                $where = "";
                if($subject_id != "" && $chapter_id != ""){
                    $where =  array('type'=>2,'status'=>1,'subject_id'=>$subject_id,'chapter_id'=>$chapter_id);
                }else{
                   $where =  array('type'=>2,'status'=>1,'batch_id'=>$batch_id);
                }
            
            
                $examPaper = $this->db_model->select_data('id,name,time_duration as timeDuration,total_question as totalQuestion,"practice" AS examType','free_quizs use index (id)',
                $where,'',array('id','asc'));
                if(!empty($examPaper)){
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_record_fetch'),
                        'examPaper'=>$examPaper,
                        'mockInfo'=>'false'
                    );
                }else{
                    $arr 	=	array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
                } 
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
        echo json_encode($arr);
    }



    function get_exam_free_quiz(){
        
//                 ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;
            if(isset($data['paper_id']) && isset($data['admin_id'])){
            $paper_id = $data['paper_id'];
            $admin_id = $data['admin_id'];
            $paperDetails = $this->db_model->select_data('id,admin_id as adminId, name,type,format,batch_id as batchId,total_question as totalQuestion, time_duration as timeDuration,question_ids as questionIds,mock_sheduled_date as mockSheduledDate,mock_sheduled_time as mockSheduledTime,status,added_by as addedBy,added_at as addedAt','free_quizs use index (id)',array('id'=>$paper_id),1);
            if(!empty($paperDetails)){
                $time =$paperDetails[0]['timeDuration'];
                // if((strtotime($paperDetails[0]['mockSheduledDate'])<=strtotime(date('Y-m-d'))) && $paperDetails[0]['type']==1 && (strtotime(date('H:i:s')) >= strtotime('+'.$time. 'minutes', strtotime($paperDetails[0]['mockSheduledTime'])))){
                //     $arr = array(
                //             'status'=>'false',
                //             'msg'=>$this->lang->line('ltr_exam_over'),
                //             );
                //     echo json_encode($arr);
                //     die(); 
                // }
                $allQuestionArr = json_decode($paperDetails[0]['questionIds'],true);
                
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                $chunkSize = isset($_GET['limit']) ? (int)$_GET['limit'] : 1;
                //$chunkSize = 20; // Number of records per page
                // Split the array into chunks
                $chunks = array_chunk($allQuestionArr, $chunkSize);
                // Check if the requested page exists
                if ($page > count($chunks) || $page < 1) {
                    $arr = array(
                        'status'=>'false',
                        'msg'=>'No Record Found!',
                    );
                    echo json_encode($arr);
                    die();
                }
                
                // Get the chunk for the current page
                $currentChunk = $chunks[$page - 1];
                // Create a comma-separated string from the chunk
                $idList = implode(',', $currentChunk);
                
                
                
                if(!empty($allQuestionArr)){
                    $questionData = $this->db_model->select_data('id,question,total_marks,options,answer,word_limit','questions use index (id)',"id in ($idList)",'',array('id','desc'));
                    if($paperDetails[0]['format'] == 1){
                      //$questionData = $this->shuffle_array($questionData);
                    }
                    

                    $paperDetails[0]['questionDetails'] = array_values($questionData);
                    $arr = array(
                        'status'=>'true',
                        'currentTime' => date('h:i:s A'),
                        'msg'=>$this->lang->line('ltr_question_fetch'),
                        'totalExamData'=>$paperDetails,
                        'allQuestion' => $allQuestionArr
                    );
                }else{
                    $arr =	array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_question_no')
                    );
                }
            }else{
                $arr =	array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_no_record_msg')
                    );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
		echo json_encode($arr);
    }




    function exam_paper(){
        $data = $_REQUEST;
        if(isset($data['exam_type']) && isset($data['batch_id']) && isset($data['admin_id']) && isset($data['student_id'])){
            $exam_type = $data['exam_type'];
            $batch_id = $data['batch_id'];
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            
            $subject_id = $data['subject_id'];
            $chapter_id = $data['chapter_id'];
            
            
            if($exam_type == 'practice'){
                
                $where = "";
                if($subject_id != "" && $chapter_id != ""){
                    $where =  array('type'=>2,'status'=>1,'batch_id'=>$batch_id,'subject_id'=>$subject_id,'chapter_id'=>$chapter_id);
                }else{
                   $where =  array('type'=>2,'status'=>1,'batch_id'=>$batch_id);
                }
            
            
                if(!empty($data['student_id'])){
                    $this->viewNotificationStatus($data['student_id'],'practicePaper');
                 }
                
                $examPaper = $this->db_model->select_data('id,name,time_duration as timeDuration,total_question as totalQuestion,"practice" AS examType','exams use index (id)',
                $where,'',array('id','asc'));
                if(!empty($examPaper)){
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_record_fetch'),
                        'examPaper'=>$examPaper,
                        'mockInfo'=>'false'
                    );
                }else{
                    $arr 	=	array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
                } 
            }else if($exam_type == 'descriptive_test'){
                if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'practicePaper');
                 }
                 
                 $where = "";
                if($subject_id != "" && $chapter_id != ""){
                    $where =  array('type'=>3,'status'=>1,'batch_id'=>$batch_id,'subject_id'=>$subject_id,'chapter_id'=>$chapter_id);
                }else{
                   $where =  array('type'=>3,'status'=>1,'batch_id'=>$batch_id);
                }
                
                $examPaper = $this->db_model->select_data('id,name,time_duration as timeDuration,total_question as totalQuestion,"practice" AS examType','exams use index (id)',
                $where,'',array('id','asc'));
                if(!empty($examPaper)){
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_record_fetch'),
                        'examPaper'=>$examPaper,
                        'mockInfo'=>'false'
                    );
                }else{
                    $arr 	=	array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
                }
            }else if($exam_type == 'mock_test'){
                
                $where = "";
                if($subject_id != "" && $chapter_id != ""){
                    $where =  array('type'=>1,'status'=>1,'batch_id'=>$batch_id,'subject_id'=>$subject_id,'chapter_id'=>$chapter_id);
                }else{
                   $where =  array('type'=>1,'status'=>1,'batch_id'=>$batch_id);
                }
                
                if(!empty($data['student_id'])){
                $this->viewNotificationStatus($data['student_id'],'mockPaper');
                 }
                $str_date =	strtotime(date("d-M-Y"));
                $datesss = date('Y-m-d');
                $dateTimeee = date('Y-m-d H:i:s');  
                
                $examPaper = $this->db_model->select_data('id,name,time_duration as timeDuration,total_question as totalQuestion,mock_sheduled_date as mockSheduledDate,mock_sheduled_time as mockSheduledTime','exams use index (id)',
                $where,'',array('id','asc'));
               
                $newexampaper = array();          
                if(!empty($examPaper)){
                    foreach($examPaper as $exam){
                        $scheduled_time = $exam['mockSheduledDate'].' '.$exam['mockSheduledTime'];
                        $minutes_to_add = $exam['timeDuration'];
                        $time = new DateTime($scheduled_time);
                        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                        $stamp = $time->format('Y-m-d H:i');
                       // if($stamp >= date('Y-m-d H:i')){
                            $paperstatus = $this->db_model->select_data('id','mock_result use index (id)',array('admin_id' => $admin_id,'student_id' => $student_id,'paper_id' => $exam['id']),1);
                            $exam['currentTime'] = date('Y-m-d H:i:s');
                            $exam['examType'] = "mock_test";
                            if(empty($paperstatus)){
                                $exam['isReattempt'] = "0";
                                array_push($newexampaper,$exam); 
                            }else{
                                $exam['isReattempt'] = "1";
                                array_push($newexampaper,$exam); 
                            }
                       // }
                    }

                    if(!empty($newexampaper)){
                        $arr = array(
                            'status' => 'true',
                            'msg' => $this->lang->line('ltr_record_fetch'),
                            'examPaper' => $newexampaper,
                            'mockInfo' => 'true',
                            'serverTime' => date('Y-m-d H:i:s'),
                        );
                    }else{
                        $arr = array(
                            'status'=>'false'
                        );
                    }
                }else{
                    $arr = array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
                }
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
        echo json_encode($arr);
    }

    function get_exam_paper(){
        
//                 ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;
            if(isset($data['paper_id']) && isset($data['admin_id'])){
            $paper_id = $data['paper_id'];
            $admin_id = $data['admin_id'];
            $paperDetails = $this->db_model->select_data('id,admin_id as adminId, name,type,format,batch_id as batchId,total_question as totalQuestion, time_duration as timeDuration,question_ids as questionIds,mock_sheduled_date as mockSheduledDate,mock_sheduled_time as mockSheduledTime,status,added_by as addedBy,added_at as addedAt','exams use index (id)',array('id'=>$paper_id),1);
            if(!empty($paperDetails)){
                $time =$paperDetails[0]['timeDuration'];
                // if((strtotime($paperDetails[0]['mockSheduledDate'])<=strtotime(date('Y-m-d'))) && $paperDetails[0]['type']==1 && (strtotime(date('H:i:s')) >= strtotime('+'.$time. 'minutes', strtotime($paperDetails[0]['mockSheduledTime'])))){
                //     $arr = array(
                //             'status'=>'false',
                //             'msg'=>$this->lang->line('ltr_exam_over'),
                //             );
                //     echo json_encode($arr);
                //     die(); 
                // }
                $allQuestionArr = json_decode($paperDetails[0]['questionIds'],true);
                
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                $chunkSize = isset($_GET['limit']) ? (int)$_GET['limit'] : 1;
                //$chunkSize = 20; // Number of records per page
                // Split the array into chunks
                $chunks = array_chunk($allQuestionArr, $chunkSize);
                // Check if the requested page exists
                if ($page > count($chunks) || $page < 1) {
                    $arr = array(
                        'status'=>'false',
                        'msg'=>'No Record Found!',
                    );
                    echo json_encode($arr);
                    die();
                }
                
                // Get the chunk for the current page
                $currentChunk = $chunks[$page - 1];
                // Create a comma-separated string from the chunk
                $idList = implode(',', $currentChunk);
                
                
                
                if(!empty($allQuestionArr)){
                    $questionData = $this->db_model->select_data('id,question,total_marks,options,answer,word_limit','questions use index (id)',"id in ($idList)",'',array('id','desc'));
                    if($paperDetails[0]['format'] == 1){
                      //$questionData = $this->shuffle_array($questionData);
                    }
                    

                    $paperDetails[0]['questionDetails'] = array_values($questionData);
                    $arr = array(
                        'status'=>'true',
                        'currentTime' => date('h:i:s A'),
                        'msg'=>$this->lang->line('ltr_question_fetch'),
                        'totalExamData'=>$paperDetails,
                        'allQuestion' => $allQuestionArr
                    );
                }else{
                    $arr =	array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_question_no')
                    );
                }
            }else{
                $arr =	array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_no_record_msg')
                    );
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
		echo json_encode($arr);
    }
    
    function shuffle_array($array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        return $new;
    }
    
    
        function exam_result_free_quiz(){
        
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;
        if(isset($data['student_id'])){
            $exam_type = $data['exam_type'];
            $admin_id = $data['admin_id']; 
            $student_id = $data['student_id'];
            $batch_id = $data['batch_id'];
            $currnt_mnth                 =   date('m');
            $currnt_yrs                  =   date('y');
           
            if(isset($data['month']) && isset($data['year']) && !empty($data['month']) && !empty($data['year'])){
                $year = $data['year'];
                $month = $data['month'];  
                $datefiltr = $year.'-'.$month;
                $like = array('date',$datefiltr); 
                
            }else{
                $datefiltr = $currnt_yrs.'-'.$currnt_mnth;
                $like = array('date',$datefiltr);  
            }
           

            $table = 'free_practice_result';
            $like1 = array('date(date)',$datefiltr); 
            $new_condition= array('type'=>2);
            
           
            
           $exam_Data = $this->db_model->select_data('*', 'free_quizs use index (id)',$new_condition,'',array('id','asc'));
           
		  //   echo $this->db->last_query();
           if(!empty($exam_Data)){
               $mCountResult = 0;
               foreach($exam_Data as $exams){
                $result_data = $this->db_model->select_data('*', $table.' use index (id)',array('student_id'=>$student_id,'paper_id'=>$exams['id']),'',array('id','desc'),$like1);
          
                    if(!empty($result_data)){
                        $mCountResult = $mCountResult + 1;
                        foreach($result_data as $result){
                            $attemptedQuestion = json_decode($result['question_answer'],true);
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
                            $time_taken = '';
                            if($result['start_time']!="" || $result['submit_time']!=""){
                                $stime=strtotime($result['start_time']);
                                $etime=strtotime($result['submit_time']);
                                $elapsed = $etime - $stime;
                                $time_taken = gmdate("H:i", $elapsed);
                            }
                           
                            $dataarray[] = array(
                                'resultId' => $result['id'],
                                'paperId' => $result['paper_id'],
                                'paperName' => $result['paper_name'],
                                'date' => date('d-m-Y',strtotime($result['date'])),
                                'startTime' => date('h:i A',strtotime($result['start_time'])),
                                'submitTime' => date('h:i A',strtotime($result['submit_time'])),
                                'totalQuestion' => $result['total_question'],
                                'attemptedQuestion' => $result['attempted_question'],
                                'totalTime' => gmdate("H:i", $result['time_duration']*60),
                                'timeTaken' => $time_taken,
                                'rightAns' => $rightCount,
                                'percentage' => $result['percentage'],
                                'totalScore'=>$total_score,
                            ); 
        					
                        }
        
                        $arr = array(
                            'status'=>'true',
                            'msg'=>$this->lang->line('ltr_record_fetch'),
                            'resultData'=>$dataarray
                        );
        		  //  echo json_encode($arr);
                    }
               }
               if($mCountResult == 0){
                    $arr=	array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
               }
           }else{
                    $arr=	array(
                        'status'=>'false',
                        'msg'=>$this->lang->line('ltr_no_record_msg'),
                    );
                // echo json_encode($arr);
           }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
            
        }
         echo json_encode($arr);
        
    }


    function exam_result(){
        
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;
        if(isset($data['student_id']) && isset($data['batch_id'])){
            $exam_type = $data['exam_type'];
            $admin_id = $data['admin_id']; 
            $student_id = $data['student_id'];
            $batch_id = $data['batch_id'];
            $currnt_mnth                 =   date('m');
            $currnt_yrs                  =   date('y');
           
            if(isset($data['month']) && isset($data['year']) && !empty($data['month']) && !empty($data['year'])){
                $year = $data['year'];
                $month = $data['month'];  
                $datefiltr = $year.'-'.$month;
                $like = array('date',$datefiltr); 
                
            }else{
                $datefiltr = $currnt_yrs.'-'.$currnt_mnth;
                $like = array('date',$datefiltr);  
            }
           

            if($exam_type == 'practice'){
                $table = 'practice_result';
                $like1 = array('date(date)',$datefiltr); 
                $new_condition= array('type'=>2,'batch_id'=>$batch_id);
            }else{
                $table = 'mock_result';
                $like1 =  array('date(date)',$datefiltr); 
                $adm_id = $this->db_model->select_data('admin_id', 'exams use index (id)',array('type'=>1,'batch_id'=>$data['batch_id']));
                $new_condition= array('type'=>1,'batch_id'=>$batch_id);

                //$        $getAllQuestions = $this->db_model->select_data('id,question,answer,options,description_solution as description', 'questions use index (id)','id in ('.$allQusersIds.')');
                foreach($getAllQuestions as $quest){
                    $ansCheck = array($quest['id']=>$quest['answer']);
                    $optionArr = json_decode($quest['options'],true);
                    if(!array_key_exists($quest['id'],$attemptedQuestion)){
                        $totalNotAttempted = $totalNotAttempted + 1;
                    }else if($attemptedQuestion[$quest['id']] != $quest['answer']){
                        $totalWrong = $totalWrong + 1;
                    }else{
                        $totalRight = $totalRight + 1;
                    }
                }
                
                
                $results['totalNotAttempted'] = $totalNotAttempted;
                $results['totalRight'] = $totalRight;
                $results['totalWrong'] = $totalWrong;
               
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_record_fetch'),
                );
            }else{
                $result_details = $this->db_model->select_data("*",'free_quizs use index (id)',array("id"=>$data['paper_id']),1,'','');
                $results['id']=0;
                $results['adminId']=$result_details[0]['admin_id'];
                $results['studentId']=0;
                $results['paperId']=$result_details[0]['id'];
                $results['paperName']=$result_details[0]['name'];
                $results['date']='';
                $results['startTime']=0;
                $results['submitTime']=0;
                $results['totalQuestion']=$result_details[0]['total_question'];
                $results['timeDuration']=0;
                $results['attemptedQuestion']=0;
                $results['questionAnswer']="";
                $results['percentage']=0;
                $results['addedOn']=$result_details[0]['added_at'];
                $results['questionIds']=$result_details[0]['question_ids'];
                $mQuestionIds = json_decode($results['questionIds'],true);
                $allQuestions = implode(',',$mQuestionIds);
                $questionLists = $this->db_model->select_data('id,question,answer,options,"notattempt" as rightAnswer,"" as studentAnswer', 'questions use index (id)','id in ('.$allQuestions.')');
                $results['allQuestions'] = $questionLists;
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_record_fetch'),
                );
            } 
        }else{ 
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
        echo json_encode($arr);
    }

    
    
    function view_ans_sheet(){
        
        
//          ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

        $data = $_REQUEST;
        if(isset($data['exam_type']) && isset($data['result_id'])){
            $paper_type = $data['exam_type']; 
            $result_id = $data['result_id'];
            if($paper_type == 'practice'){
                $type = 2;
                $table = 'practice_result';
            }else{
                $type = 1;
                $table = 'mock_result';
            }
            
            $result_details = $this->db_model->select_data("$table.id,$table.admin_id as adminId,$table.student_id as studentId,$table.paper_id as paperId,$table.paper_name as paperName,$table.date,$table.start_time as startTime,$table.submit_time as submitTime,$table.total_question as totalQuestion,$table.time_duration as timeDuration,$table.attempted_question as attemptedQuestion, $table.question_answer as questionAnswer,$table.percentage, $table.added_on as addedOn,exams.question_ids as questionIds",$table.' use index (id)',array("$table.id"=>$result_id),1,'','',array('exams',"exams.id = $table.paper_id",'LEFT'));
          // echo $this->db->last_query();
          // die;
            if(!empty($result_details)){
                $results = $result_details[0];
                $allQuestionArr = json_decode($results['questionIds'],true);

                // Pagination parameters
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                $chunkSize = isset($_GET['limit']) ? (int)$_GET['limit'] : 1;
                //$chunkSize = 20; // Number of records per page
                // Split the array into chunks
                $chunks = array_chunk($allQuestionArr, $chunkSize);
                // Check if the requested page exists
                if ($page > count($chunks) || $page < 1) {
                    die('Invalid page number');
                }
                
                // Get the chunk for the current page
                $currentChunk = $chunks[$page - 1];
                // Create a comma-separated string from the chunk
                $idList = implode(',', $currentChunk);
                
                $questionLists = $this->db_model->select_data('id,question,answer,options,description_solution as description', 'questions use index (id)','id in ('.$idList.')');
                $attemptedQuestion = json_decode($results['questionAnswer'],true);
                $results['allQuestions'] = $questionLists;
                
                //echo "<pre>";
                //print_r($results['allQuestions']);
                //die;
                
                $i = 0;
                foreach($results['allQuestions'] as $quest){
                    $ansCheck = array($quest['id']=>$quest['answer']);
                    $optionArr = json_decode($quest['options'],true);
                    if(!array_key_exists($quest['id'],$attemptedQuestion)){
                        $results['allQuestions'][$i]['studentAnswer'] = '';
                        $results['allQuestions'][$i]['rightAnswer'] = 'notattempt';
                    }else if($attemptedQuestion[$quest['id']] != $quest['answer']){
                        $results['allQuestions'][$i]['studentAnswer'] = $attemptedQuestion[$quest['id']];
                        $results['allQuestions'][$i]['rightAnswer'] = 'wrong';
                    }else{
                        $results['allQuestions'][$i]['studentAnswer'] = $attemptedQuestion[$quest['id']];
                        $results['allQuestions'][$i]['rightAnswer'] = 'right';
                    }
                    $i++;
                    
                }
                
                // For manage Chart
                $totalNotAttempted = 0;
                $totalRight = 0;
                $totalWrong = 0;
                $allQusersIds  = implode(',',$allQuestionArr);
                $getAllQuestions = $this->db_model->select_data('id,question,answer,options,description_solution as description', 'questions use index (id)','id in ('.$allQusersIds.')');
                foreach($getAllQuestions as $quest){
                    $ansCheck = array($quest['id']=>$quest['answer']);
                    $optionArr = json_decode($quest['options'],true);
                    if(!array_key_exists($quest['id'],$attemptedQuestion)){
                        $totalNotAttempted = $totalNotAttempted + 1;
                    }else if($attemptedQuestion[$quest['id']] != $quest['answer']){
                        $totalWrong = $totalWrong + 1;
                    }else{
                        $totalRight = $totalRight + 1;
                    }
                }
                
                
                $results['totalNotAttempted'] = $totalNotAttempted;
                $results['totalRight'] = $totalRight;
                $results['totalWrong'] = $totalWrong;
               
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_record_fetch'),
                );
            }else{
                $result_details = $this->db_model->select_data("*",'exams use index (id)',array("id"=>$data['paper_id']),1,'','');
                $results['id']=0;
                $results['adminId']=$result_details[0]['admin_id'];
                $results['studentId']=0;
                $results['paperId']=$result_details[0]['id'];
                $results['paperName']=$result_details[0]['name'];
                $results['date']='';
                $results['startTime']=0;
                $results['submitTime']=0;
                $results['totalQuestion']=$result_details[0]['total_question'];
                $results['timeDuration']=0;
                $results['attemptedQuestion']=0;
                $results['questionAnswer']="";
                $results['percentage']=0;
                $results['addedOn']=$result_details[0]['added_at'];
                $results['questionIds']=$result_details[0]['question_ids'];
                $mQuestionIds = json_decode($results['questionIds'],true);
                $allQuestions = implode(',',$mQuestionIds);
                $questionLists = $this->db_model->select_data('id,question,answer,options,"notattempt" as rightAnswer,"" as studentAnswer', 'questions use index (id)','id in ('.$allQuestions.')');
                $results['allQuestions'] = $questionLists;
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_record_fetch'),
                );
            } 
        }else{ 
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
        echo json_encode($arr);
    }
    
    
    function view_descriptive_ans_sheet(){
        
//          ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

        $data = $_REQUEST;
        if(isset($data['result_id'])){
            $result_id = $data['result_id']; 
             $table = 'descriptive_result';
            
            $allAnswer = $this->db_model->select_data("descriptive_result.questionid as id,student_answer as studentAnswer,remarks,single_answer as answer,descriptive_result.givenmarks,descriptive_result.maxmarks,questions.question",$table.' use index (id)',array("$table.descriptive_student_id"=>$result_id),'','','',array('questions',"questions.id = $table.questionid",'LEFT'));
           // echo $this->db->last_query(); die;
            if(!empty($allAnswer)){
                
                $result_details = $this->db_model->select_data("*",'descriptive_student use index (id)',array("id"=>$result_id),1,'','');
                $results['id']=0;
                $results['adminId']=$result_details[0]['admin_id'];
                $results['studentId']=0;
                $results['paperId']=$result_details[0]['exam_id'];
                $results['paperName']=$result_details[0]['exam_name'];
                $results['date']='';
                $results['startTime']=0;
                $results['submitTime']=0;
                $results['totalQuestion']=$result_details[0]['total_question'];
                $results['timeDuration']=0;
                $results['attemptedQuestion']=0;
                $results['questionAnswer']="";
                
                $givenMark = 0;
                $maxMark = 0;
                for ($x = 0; $x <= count($allAnswer); $x++) {
                    $maxMark = $maxMark + $allAnswer[$x]['maxmarks'];
                    $givenMark = $givenMark + $allAnswer[$x]['givenmarks'];
                }
                
                $percData = ($givenMark*100)/$maxMark;

                $results['percentage']=round($percData, 2);
                $results['addedOn']=$result_details[0]['added_on'];
                $results['questionIds']=$result_details[0]['admin_id'];
                $results['allQuestions'] = $allAnswer;
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_record_fetch'),
                );
                
                
            }else{
                $arr = array(
                    'status'=>'true',
                    'resultData'=>$results,
                    'msg'=>$this->lang->line('ltr_no_record_msg'),
                );
            } 
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
        echo json_encode($arr);
    }

    function submit_paper(){
            
//             ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;

        if(isset($data['exam_type']) && isset($data['admin_id']) && isset($data['student_id']) && isset($data['question_answer']) && isset($data['paper_id']) && isset($data['paper_name']) && isset($data['total_question']) && isset($data['start_time']) && isset($data['time_duration'])){
           $this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
            $paper_type = $data['exam_type'];
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            $date = date('Y-m-d');
            $question_answer = $data['question_answer'];
            $attempted_question = count(json_decode($data['question_answer'],true));
            
            $paper_id = $data['paper_id'];
            $paper_name = $data['paper_name'];
            $total_question = $data['total_question'];
            $start_time = date('H:i', strtotime($data['start_time']));
            $submit_time = date('H:i');
            $time_duration = $data['time_duration'];
            $attemptedQuestion = json_decode($question_answer,true);
            
                    $rightCount = 0;
                    $wrongCount = 0;
                    $rightMarks = 0;
                    $wrongMarks = 0;
                    $totalMarksPaper = 0;
                    $c = 0;
                    
                    $adm_id = $this->db_model->select_data('admin_id,id,negative_marking,question_ids','exams use index (id)',array('id'=>$data['paper_id']));
                    
                    
                        foreach($attemptedQuestion as $key=>$value){
                            $right_ansrs = $this->db_model->select_data('id,answer,total_marks', 'questions use index (id)',array('id'=>$key));
                            if(($key == $right_ansrs[0]['id']) && ($value == $right_ansrs[0]['answer'])){
                                $rightCount++;
                                $rightMarks = $rightMarks + $right_ansrs[0]['total_marks'];
                            }else{
                                $wrongCount++;
                                $negativeMark = $right_ansrs[0]['total_marks'] * $adm_id[0]['negative_marking'];
                                $wrongMarks = $wrongMarks + $negativeMark;
                            }
                            $c++;
                        }
                  
                    
                   
                    $total_score = $rightMarks - $wrongMarks;
                    
                    $getAllQuestion = $adm_id[0]['question_ids'];
                    $var = json_decode($getAllQuestion, TRUE);

                    foreach($var as $value){
                        $fetchTotalMakrs = $this->db_model->select_data('id,total_marks', 'questions use index (id)',array('id'=>$value));
                        $totalMarksPaper = $totalMarksPaper + $fetchTotalMakrs[0]['total_marks'];
                    }
                    
                    
                    $percentage = 0;
                    if($totalMarksPaper != 0){
                        $percentage = ($total_score*100)/$totalMarksPaper;
                    }
                    
                  
                $data_arr =	array(
                    // 'admin_id'=>$admin_id,
                    'admin_id'=>$adm_id[0]['admin_id'],
                    'student_id'=>$student_id,
                    'paper_id'=>$paper_id,
                    'paper_name'=>$paper_name,
                    'date'=>$date,
                    'start_time'=>$start_time,
                    'submit_time'=>$submit_time,
                    'total_question'=>$total_question,
                    'time_duration'=>$time_duration,
                    'attempted_question'=>$attempted_question, 
                    'question_answer'=>$question_answer,
                    'percentage'=>number_format($percentage, 2, '.', '')
                );
         
            if($paper_type=='practice'){
                $table = 'practice_result';
                $prevdata = array();
            }else{
                $table = 'mock_result';
                 $prevdata = array();
                //$prevdata = $this->db_model->select_data('id','mock_result use index (id)',array('student_id'=>$student_id,'admin_id'=>$admin_id,'paper_id'=>$paper_id),1);
            }
   
            if(empty($prevdata)){
               
                $ins = $this->db_model->insert_data($table,$data_arr);
                if(!empty($ins)){
                    $time_taken = '';
                    if($start_time!="" || $submit_time!=""){
                        $stime=strtotime($start_time);
                        $etime=strtotime($submit_time);
                        $elapsed = $etime - $stime;
                        $time_taken = gmdate("H:i", $elapsed);
                    } 
    
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_paper_submitted'),
                        'totalQuestion'=>$total_question,
                        'totalAttempt'=>$attempted_question,
                        'attemptQuestion'=>$attempted_question,
                        'correctAns'=>$rightCount,
                        'wrongAns'=>$wrongCount,
                        'totalScore'=>number_format($total_score, 2, '.', ''),
                        'totalMarksPaper'=>number_format($totalMarksPaper, 2, '.', ''),
                        'percentage'=>number_format($percentage, 2, '.', ''),
                        'startTime'=>$start_time,
                        'submitTime'=>$submit_time,
                        'date'=>$date,
                        'timeTaken'=>$time_taken
                    );
                }else{
                    $arr = array(
                        'status'=>'false'
                    );
                }
            }else{
                $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_paper_this_test'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
      
        echo json_encode($arr);
    }

    
    function submit_descriptive_paper(){
        $data = $_REQUEST;
        
        // echo "<pre>"; 
        // print_r($data);
        // die;
        
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        if(isset($data['admin_id']) && isset($data['student_id']) && isset($data['question_answer']) && isset($data['exam_id']) && isset($data['exam_name']) && isset($data['total_question']) && isset($data['start_time']) && isset($data['time_duration'])){
           $this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            $date = date('Y-m-d');
            $question_answer = $data['question_answer'];
            $attempted_question = count(json_decode($data['question_answer'],true));
            
            $exam_id = $data['exam_id'];
            $batch_id = $data['batch_id'];
            $exam_name = $data['exam_name'];
            $total_question = $data['total_question'];
            $start_time = date('H:i', strtotime($data['start_time']));
            $submit_time = date('H:i');
            $time_duration = $data['time_duration'];
            $attemptedQuestion = json_decode($question_answer,true);
            
            $table = 'descriptive_student';
            $prevdata = $this->db_model->select_data('admin_id,id','descriptive_student use index (id)',array('student_id'=>$student_id,'admin_id'=>$admin_id,'exam_id'=>$exam_id),1);
            
             $data_arr =	array(
                    'admin_id'=>$admin_id,
                    'student_id'=>$student_id,
                    'batch_id'=>$batch_id,
                    'exam_id'=>$exam_id,
                    'exam_name'=>$exam_name,
                    'date'=>$date,
                    'start_time'=>$start_time,
                    'submit_time'=>$submit_time,
                    'total_question'=>$total_question,
                    'time_duration'=>$time_duration
                    );
                
               $ins = $this->db_model->insert_data($table,$data_arr);
               
                if(!empty($ins)){
                    $attmpt = 0;
                    foreach($attemptedQuestion as $key=>$value){
                        $questionDetail = $this->db_model->select_data('id,total_marks','questions use index (id)',array('id'=>$key,'admin_id'=>$admin_id),1);
                        $insert_data_arr =	array(
                        'descriptive_student_id'=>$ins,
                        'questionid'=>$key,
                        'student_answer'=>$value,
                        'maxmarks'=>$questionDetail[0]['total_marks'],
                        'givenmarks'=>0
                        );
                        
                        if($value != ""){
                            $attmpt = $attmpt +1;
                        }
                        
                        $this->db_model->insert_data('descriptive_result',$insert_data_arr);
                    }
                    
                    $this->db_model->update_data_limit($table,array('attempted_question'=>$attmpt),array('id'=>$ins),1);

                    
                    $time_taken = '';
                    if($start_time!="" || $submit_time!=""){
                        $stime=strtotime($start_time);
                        $etime=strtotime($submit_time);
                        $elapsed = $etime - $stime;
                        $time_taken = gmdate("H:i", $elapsed);
                    } 
    
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_paper_submitted'),
                        'totalQuestion'=>$total_question,
                        'startTime'=>$start_time,
                        'submitTime'=>$submit_time,
                        'totalAttemptQuestion'=>$attmpt,
                        'date'=>$date,
                        'timeTaken'=>$time_taken
                    );
               }else{ 
                   $arr = array(
                        'status'=>'false'
                    );
               }
           
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
      
        echo json_encode($arr);
    }
    
    
        function submit_paper_free_quiz(){
            
//             ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

        $data = $_REQUEST;

        if(isset($data['exam_type']) && isset($data['admin_id']) && isset($data['student_id']) && isset($data['question_answer']) && isset($data['paper_id']) && isset($data['paper_name']) && isset($data['total_question']) && isset($data['start_time']) && isset($data['time_duration'])){
           $this->db_model->insert_data('temp_data',array('temp'=>json_encode($data)));
            $paper_type = $data['exam_type'];
            $admin_id = $data['admin_id'];
            $student_id = $data['student_id'];
            $date = date('Y-m-d');
            $question_answer = $data['question_answer'];
            $attempted_question = count(json_decode($data['question_answer'],true));
            
            $paper_id = $data['paper_id'];
            $paper_name = $data['paper_name'];
            $total_question = $data['total_question'];
            $start_time = date('H:i', strtotime($data['start_time']));
            $submit_time = date('H:i');
            $time_duration = $data['time_duration'];
            $attemptedQuestion = json_decode($question_answer,true);
            
                    $rightCount = 0;
                    $wrongCount = 0;
                    $rightMarks = 0;
                    $wrongMarks = 0;
                    $totalMarksPaper = 0;
                    $c = 0;
                    
                    $adm_id = $this->db_model->select_data('admin_id,id,negative_marking,question_ids','free_quizs use index (id)',array('id'=>$data['paper_id']));
                    
                    
                        foreach($attemptedQuestion as $key=>$value){
                            $right_ansrs = $this->db_model->select_data('id,answer,total_marks', 'questions use index (id)',array('id'=>$key));
                            if(($key == $right_ansrs[0]['id']) && ($value == $right_ansrs[0]['answer'])){
                                $rightCount++;
                                $rightMarks = $rightMarks + $right_ansrs[0]['total_marks'];
                            }else{
                                $wrongCount++;
                                $negativeMark = $right_ansrs[0]['total_marks'] * $adm_id[0]['negative_marking'];
                                $wrongMarks = $wrongMarks + $negativeMark;
                            }
                            $c++;
                        }
                  
                    
                   
                    $total_score = $rightMarks - $wrongMarks;
                    
                    $getAllQuestion = $adm_id[0]['question_ids'];
                    $var = json_decode($getAllQuestion, TRUE);

                    foreach($var as $value){
                        $fetchTotalMakrs = $this->db_model->select_data('id,total_marks', 'questions use index (id)',array('id'=>$value));
                        $totalMarksPaper = $totalMarksPaper + $fetchTotalMakrs[0]['total_marks'];
                    }
                    
                    
                    $percentage = 0;
                    if($totalMarksPaper != 0){
                        $percentage = ($total_score*100)/$totalMarksPaper;
                    }
                    
                  
                $data_arr =	array(
                    // 'admin_id'=>$admin_id,
                    'admin_id'=>$adm_id[0]['admin_id'],
                    'student_id'=>$student_id,
                    'paper_id'=>$paper_id,
                    'paper_name'=>$paper_name,
                    'date'=>$date,
                    'start_time'=>$start_time,
                    'submit_time'=>$submit_time,
                    'total_question'=>$total_question,
                    'time_duration'=>$time_duration,
                    'attempted_question'=>$attempted_question, 
                    'question_answer'=>$question_answer,
                    'percentage'=>number_format($percentage, 2, '.', '')
                );
         
             $table = 'free_practice_result';
            $prevdata = array();
   
            if(empty($prevdata)){
               
                $ins = $this->db_model->insert_data($table,$data_arr);
                if(!empty($ins)){
                    $time_taken = '';
                    if($start_time!="" || $submit_time!=""){
                        $stime=strtotime($start_time);
                        $etime=strtotime($submit_time);
                        $elapsed = $etime - $stime;
                        $time_taken = gmdate("H:i", $elapsed);
                    } 
    
                    $arr = array(
                        'status'=>'true',
                        'msg'=>$this->lang->line('ltr_paper_submitted'),
                        'totalQuestion'=>$total_question,
                        'totalAttempt'=>$attempted_question,
                        'attemptQuestion'=>$attempted_question,
                        'correctAns'=>$rightCount,
                        'wrongAns'=>$wrongCount,
                        'totalScore'=>number_format($total_score, 2, '.', ''),
                        'totalMarksPaper'=>number_format($totalMarksPaper, 2, '.', ''),
                        'percentage'=>number_format($percentage, 2, '.', ''),
                        'startTime'=>$start_time,
                        'submitTime'=>$submit_time,
                        'date'=>$date,
                        'timeTaken'=>$time_taken
                    );
                }else{
                    $arr = array(
                        'status'=>'false'
                    );
                }
            }else{
                $arr = array('status'=>'false','msg'=>$this->lang->line('ltr_paper_this_test'));
            }
        }else{
            $arr = array(
                'status'=>'false',
                'msg'=>$this->lang->line('ltr_missing_parameters_msg'),
            );
        }
      
        echo json_encode($arr);
    }

    
    function viewNotificationStatus($student_id='',$notice_type=''){
            $data = $_REQUEST;
            if(!empty($student_id) && !empty($notice_type)){
                
               
                 $data_arr=array();
                 $cu_date = date('Y-m-d h:i:s');
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
}