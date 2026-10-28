<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder">
		<div class="edu_admin_informationdiv sectionHolder">
            <?php 
                if(!empty($result_details)){
                    $results = $result_details[0];
                    //print_r($results);
                    //die;
                    $id = $results['id'];
                    $totalMarks = $this->db_model->custom_slect_query(" SUM(total_marks) as totalMarks FROM descriptive_result LEFT JOIN questions ON questions.id = descriptive_result.questionid
                    WHERE descriptive_student_id = $id ");
                    
                    $mTotalMarks = $totalMarks[0]['totalMarks'];
                }

                /*if(!empty($obained_marks)){
                    $obained_marks = $obained_marks[0];
                    
                }else{
                    $obained_marks = 0;
                }*/
            ?>
            <!------- Answer Sheet Start -------->
            <div class="edu_main_wrapper answer_sheet_wrapper">
                <div class="answer_sheet_inner">
                    <?php if(!empty($results)){ ?>
                    <div class="answer_sheet_header">
                        
                        <input type="hidden" id="descriptive_student_id" value="<?php echo $results['id'];?>">
                        <div class="row">
                            <?php if($this->session->userdata('role') != 'student'){ ?>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-left">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_student_name'));?> : </span><?php echo (isset($results['name']))?$results['name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-center">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php echo (isset($results['exam_name']))?$results['exam_name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_time'));?>:</span><span id="timer"><?php echo (isset($results['time_duration']))?$results['time_duration'].' Min':'';?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo">Total Marks:</span><span id="exam"><?php echo $mTotalMarks;?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--<div class="col-lg-2 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo">Obtained Marks:</span><span id="exam"><?php if($obained_marks['obtainedmarks']){echo $obained_marks['obtainedmarks'];}else{echo '0';}?></span></li>
                                        </ul>
                                    </div>
                                </div>-->
                            <?php }else{ ?>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php echo (isset($results['exam_name']))?$results['exam_name']:$results['name'];?></p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_time'));?>:</span><span id="timer"><?php echo (isset($results['time_duration']))?$results['time_duration'].' Min':'';?></span></li>
                                        </ul>
                                    </div>
                                </div>
                           <?php } ?>
                        </div>
                    </div>
                    
                    <div class="answer_sheet_body">
                        <div class="edu_answer_sheet_section">
                            <ol>
                                <?php 
                                    
                                     $id = $results['id'];
                                     $examid = $results['exam_id'];
                    
                                    $questionLists = $this->db_model->custom_query_data(" SELECT questions.*,student_answer FROM descriptive_result LEFT JOIN questions ON questions.id = descriptive_result.questionid WHERE descriptive_student_id = $id ");
                                    
                                    
                                    if(!empty($questionLists)){
                                        
                                        
                                        $j = 1;
                                        foreach($questionLists as $quest){
                                            
                                            
                                            if($quest['question_type']==1){
                                                $singleansCheck = array($quest['id']=>$quest['single_answer']);    
                                            }elseif($quest['question_type']==2){
                                                $ansCheck = array($quest['id']=>$quest['answer']);    
                                                $optionArr = json_decode($quest['options'],true);
                                            }
                                            
                                            if($quest['question_type']==3){

                                                if($quest['total_options']==1){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    }       
                                                }
                                                if($quest['total_options']==2){ 
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    }    
                                                       
                                                }
                                                if($quest['total_options']==3){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    }  
                                                }
                                                if($quest['total_options']==4){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    } 
                                                }
                                                if($quest['total_options']==5){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    } 
                                                }
                                                if($quest['total_options']==6){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5'],$quest['answer_6']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    } 
                                                }
                                                if($quest['total_options']==7){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5'],$quest['answer_6'],$quest['answer_7']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    } 
                                                }
                                                if($quest['total_options']==8){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5'],$quest['answer_6'],$quest['answer_7'],$quest['answer_8']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    } 
                                                }
                                                if($quest['total_options']==9){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5'],$quest['answer_6'],$quest['answer_7'],$quest['answer_8'],$quest['answer_9']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    }
                                                }
                                                if($quest['total_options']==10){
                                                    $singleoption = array();
                                                    array_push($singleoption,$quest['answer_1'],$quest['answer_2'],$quest['answer_3'],$quest['answer_4'],$quest['answer_5'],$quest['answer_6'],$quest['answer_7'],$quest['answer_8'],$quest['answer_9'],$quest['answer_10']);
                                                    $i=1;
                                                    $singleoptionnew='';
                                                    foreach($singleoption as $op){
                                                        $singleoptionnew .= '<li>'.$i.'. '.$op.'</li>';
                                                        $i++;
                                                    }
                                                }
                                                
                                                
                                                echo ' <li>
                                                    <div class="edu_single_answer_wrap">
                                                        <div class="edu_single_questionAns">
                                                            <p><span>'.$j.'. </span> '.$quest['question'].'</p>
                                                        
                                                            <p>Acutal Answer:</p>
                                                            <ul class="question_options">'.$singleoptionnew.'</ul>
                                                        </div>
                                                        <div class="edu_answer_wrapper">
                                                            <div class="row">';
                                                                    if(empty($quest['student_answer'])){
                                                                            echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                                                <div class="edu_answer edu_wrong_answer">
                                                                                                    <p>fff'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                                                </div>
                                                                                            </div>';   
                                                                    }else
                                                                    {   
                                                                        
                                                                        
                                                                                    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                                        <div class="edu_answer edu_single_questionAns">
                                                                                            <p>Answer From Student:</p>
                                                                                            <ul class="question_options">'.$quest['student_answer'].'</ul>
                                                                                        </div>
                                                                                    </div>';
                                                                                    
                                                                               
                                                                            
                                                                            $values = get_marksdetailrow($id,$quest['id'])->givenmarks;
                                                                            $remarks = get_marksdetailrow($id,$quest['id'])->remarks;
                                                                                echo '<p class="text-primary">Total Marks:'. $quest['total_marks'].'</p>';
                                                                                echo '<input class="form-control" type="number" name="marks" value="'.$values.'" min="0" max="'.$quest['total_marks'].'"  id="'.$quest['id'].'" placeholder="add marks for fill the blanks answer">';
                                                                               echo '<br><br>';
                                                                                echo '<textarea class="form-control" name="marks" id="rem-'.$quest["id"].'" placeholder="add remarks for answer">'.$remarks.'</textarea>';
                                                                                echo '<p class="mt-2"><button type="button" data-questionid="'.$quest['id'].'" data-maxmarks="'.$quest['total_marks'].'" class="btn btn-primary updatequestionmarks">Update Makrs</button></p>';
                                                                                    echo '</div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>';
                                                                            
                                                                    }
                                                                $j++;

                                            } 

                                            if($quest['question_type']==1){

                                                echo ' <li>
                                                    <div class="edu_single_answer_wrap">
                                                        <div class="edu_single_questionAns">
                                                            <p><span>'.$j.'. </span> '.$quest['question'].'</p>
                                                        </div>
                                                        <div class="edu_answer_wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    <div class="edu_answer edu_right_answer">
                                                                    <p>Acutal Answer:</p>
                                                                        <p><i class="icofont-checked"></i>'.$quest['single_answer'].'</p>
                                                                    </div>
                                                                </div>';
                                                               if(empty($quest['student_answer'])){
                                                                            echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                                                <div class="edu_answer edu_wrong_answer">
                                                                                                    <p>fff'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                                                </div>
                                                                                            </div>';   
                                                                    }else
                                                                    {   
                                                                        
                                                                        
                                                                                    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                                        <div class="edu_answer edu_single_questionAns">
                                                                                            <p>Answer From Student:</p>
                                                                                            <ul class="question_options">'.$quest['student_answer'].'</ul>
                                                                                        </div>
                                                                                    </div>';
                                                                                    
                                                                               
                                                                            
                                                                            $values = get_marksdetailrow($id,$quest['id'])->givenmarks;
                                                                            $remarks = get_marksdetailrow($id,$quest['id'])->remarks;
                                                                                echo '<p class="text-primary">Total Marks:'. $quest['total_marks'].'</p>';
                                                                                echo '<input class="form-control" type="number" name="marks" value="'.$values.'" min="0" max="'.$quest['total_marks'].'"  id="'.$quest['id'].'" placeholder="add marks for fill the blanks answer">';
                                                                                echo '<br><br>';
                                                                                echo '<textarea class="form-control" name="marks" id="rem-'.$quest["id"].'" placeholder="add remarks for answer">'.$remarks.'</textarea>';
                                                                                echo '<p class="mt-2"><button type="button" data-questionid="'.$quest['id'].'" data-maxmarks="'.$quest['total_marks'].'" class="btn btn-primary updatequestionmarks">Update Makrs</button></p>';
                                                                                    echo '</div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>';
                                                                            
                                                                    }
                                                                $j++;

                                            }
                                           
                                        }
                                    }
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re"><a class="btn btn-primary" onclick="releaseResult(<?php echo $id; ?>)" role="button">Release Result</a></div>
                            </div>
                    </div>
                    <?php }else{
                           echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_live_his_no_data')).'</div>
                            </div>
                        </div>
                    </section>';
                    } ?>
                </div>
            </div>
            <!------- Answer Sheet End -------->
		</div>
	</div>
</section>