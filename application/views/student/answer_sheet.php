<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder">
	    <div class"row">
	    <div id="chartContainer" style="height: 370px; width: 100%;">
	        
	    </div>
<h4><? echo  "Total Marks  :  ".$summur.'/'.$ttl_question; ?> </h4>
		<div class="edu_admin_informationdiv sectionHolder">
            <?php 
                if(!empty($result_details)){ 
                    
                    $p_pass = (float)$p_pass;
                    $p_failed = (float)$p_failed;
                    $not_attempt = (float)$not_attempt;
                    
                    
                   $dataPoints = json_encode(array(
                        array("label" => "Passed", "y" => $p_pass),
                        array("label" => "Failed", "y" => $p_failed),
                        array("label" => "Not Attempted", "y" => $not_attempt)
                    ));
                    
                    
                    
                    $results = $result_details[0];
                    $allDescQuestions=[];
                   
                    foreach ($result_details as  $value) {
                      $allDescQuestions[]=$value['questionid'];
                    }
                }

        if(isset($result_type) && !empty($result_type)){ ?>
        
        
        
                <!------- Answer Sheet Start -------->
            <div class="edu_main_wrapper answer_sheet_wrapper">
                <div class="answer_sheet_inner">
                    <?php if(!empty($results)){ ?>
                    <div class="answer_sheet_header">
                        <div class="row">
                            <?php if($this->session->userdata('role') != 'student'){ ?>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-left">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_student_name'));?> : </span><?php echo (isset($results['name']))?$results['name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-center">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php echo (isset($results['paper_name']))?$results['paper_name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_time'));?>:</span><span id="timer"><?php echo (isset($results['time_duration']))?$results['time_duration'].' Min':'';?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center">
                                        <p><span class="edu_paper_smallinfo"><?php //echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php //echo (isset($results['paper_name']))?$results['paper_name']:$results['name'];?></p>
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo"><?php //echo html_escape($this->common->languageTranslator('ltr_time'));?>:</span><span id="timer"><?php //echo (isset($results['time_duration']))?$results['time_duration'].' Min':'';?></span></li>
                                        </ul>
                                    </div>
                                </div> -->
                           <?php } ?>
                        </div>
                    </div>
                    <div class="answer_sheet_body">
                        <div class="edu_answer_sheet_section">
                            <ol>
                                <?php 

                                    //$allQuestionArr = json_decode($results['question_ids'],true);
                                    $allQuestionArr =$allDescQuestions;
                                    $allQuestions = implode(',',$allQuestionArr);
                                    $questionLists = $this->db_model->select_data('id,question,single_answer', 'questions use index (id)','id in ('.$allQuestions.')');

                                    $attemptedQuestion = (isset($results['student_answer']))?json_decode($results['student_answer'],true):'' ;
                                    
                                    if(!empty($questionLists)){
                                        $j = 1;
                                        foreach($questionLists as $quest){ //print_r($quest);
                                            $ansCheck = array($quest['id']=>$quest['single_answer']);
                                            //$optionArr = json_decode($quest['options'],true);
                                            $i = 'A';
                                            $studenAns = $this->db_model->select_data('student_answer,remarks', 'descriptive_result use index (id)',array('questionid'=>$quest['id'],'descriptive_student_id'=>$results['descriptive_student_id']));

                                            //print_r($studenAns);

                                            echo ' <li>
                                                <div class="edu_single_answer_wrap">
                                                    <div class="edu_single_questionAns">
                                                        <p><span>'.$j.'. </span> '.$quest['question'].'</p>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p>Student Ans:'.$studenAns[0]['student_answer'].'</p>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="edu_answer_wrapper">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p><i class="icofont-checked"></i>'.$quest['single_answer'].'</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p style="color:red;">'.$studenAns[0]['remarks'].'</p>
                                                                </div>
                                                            </div>
                                                            ';
                                        if(empty($attemptedQuestion)){
                                                 //echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    //<div class="edu_answer edu_wrong_answer">
                                                                       // <p>'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                    //</div>
                                                                //</div>';   
                                        }else
                                        {
                                        if(!array_key_exists($quest['id'],$attemptedQuestion) ){
                                                                //echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                   // <div class="edu_answer edu_wrong_answer">
                                                                      //  <p>'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                   // </div>
                                                               // </div>';
                                                            }else{
                                                                if($attemptedQuestion[$quest['id']] != $quest['answer']){
                                                                echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    <div class="edu_answer edu_wrong_answer">
                                                                        <p><i class="icofont-close-squared-alt"></i>'.$attemptedQuestion[$quest['id']].'</p>
                                                                    </div>
                                                                </div>';
                                                                }  
                                                            }
                                                    echo '</div>
                                                    </div>
                                                </div>
                                            </li>';
                                            $i++;
                                        }
                                        $j++;
                                        }
                                    }
                                ?>
                            </ol>
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
            <!------- Descriptv Answer Sheet End -------->


               <?php }else{?>
            <!------- Answer Sheet Start -------->
            <div class="edu_main_wrapper answer_sheet_wrapper">
                <div class="answer_sheet_inner">
                    <?php if(!empty($results)){ ?>
                    <div class="answer_sheet_header">
                        <div class="row">
                            <?php if($this->session->userdata('role') != 'student'){ ?>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-left">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_student_name'));?> : </span><?php echo (isset($results['name']))?$results['name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-center">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php echo (isset($results['paper_name']))?$results['paper_name']:'';?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center text-right">
                                        <ul class="edu_count_timer">
                                            <li><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_time'));?>:</span><span id="timer"><?php echo (isset($results['time_duration']))?$results['time_duration'].' Min':'';?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12 padderBottom30">
                                    <div class="edu_paper_info responsive_center">
                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper'));?> : </span><?php echo (isset($results['paper_name']))?$results['paper_name']:$results['name'];?></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12 padderBottom30">
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
                                    $allQuestionArr = json_decode($results['question_ids'],true);
                                    $allQuestions = implode(',',$allQuestionArr);
                                    $questionLists = $this->db_model->select_data('id,question,answer,options,description_solution', 'questions use index (id)','id in ('.$allQuestions.')');

                                    $attemptedQuestion = (isset($results['question_answer']))?json_decode($results['question_answer'],true):'' ;
                                    
                                    if(!empty($questionLists)){
                                        $j = 1;
                                        foreach($questionLists as $quest){
                                            $ansCheck = array($quest['id']=>$quest['answer']); 
                                            $optionArr = json_decode($quest['options'],true);
                                            $i = 'A';
                                            $option = '';
                                            foreach($optionArr as $op){
                                                $option .= '<li>'.$i.'. '.$op.'</li>';
                                                $i++;
                                            }
                                            echo ' <li>
                                                <div class="edu_single_answer_wrap">
                                                    <div class="edu_single_questionAns">
                                                        <p><span>'.$j.'. </span> '.$quest['question'].'</p>
                                                        <ul class="question_options">'.$option.'</ul>
                                                    </div>
                                                    <div class="edu_answer_wrapper">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p><i class="icofont-checked"></i>'.$quest['answer'].'</p>
                                                                </div>
                                                            </div>
                                                             <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p style="color:red;">'.$studenAns[0]['remarks'].'</p>
                                                                </div>
                                                            </div>';
                                        if(empty($attemptedQuestion)){
                                                 echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    <div class="edu_answer edu_wrong_answer">
                                                                        <p>'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                    </div>
                                                                </div>
                                                                 <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                    <p style="color:red;">'.$studenAns[0]['remarks'].'</p>
                                                                </div>
                                                            </div>';   
                                        }else
                                        {
                                        if(!array_key_exists($quest['id'],$attemptedQuestion) ){
                                                                echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    <div class="edu_answer edu_wrong_answer">
                                                                        <p>'.html_escape($this->common->languageTranslator('ltr_not_attempted')).'</p>
                                                                    </div>
                                                                </div>
                                                                 <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                     <div class="color: green;"><p style="color:green; width: 5%;"><b>Solution: <p style="color:black;">'.$quest['description_solution'].'</p></b></p></div>
                                                                </div>
                                                            </div>';
                                                            }else{
                                                                if($attemptedQuestion[$quest['id']] != $quest['answer']){
                                                                echo '<div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                    <div class="edu_answer edu_wrong_answer">
                                                                        <p><i class="icofont-close-squared-alt"></i>'.$attemptedQuestion[$quest['id']].'</p>
                                                                    </div>
                                                                </div>
                                                                 <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom10">
                                                                <div class="edu_answer edu_right_answer">
                                                                   <div class="color: green; "> <p style="color:green; width: 5%;"><b>Solution: <p style="color:black;">'.$quest['description_solution'].'</p></b></p></div>
                                                                </div>
                                                            </div>';
                                                                }  
                                                            }
                                                    echo '</div>
                                                    </div>
                                                </div>
                                            </li>';
                                            $i++;
                                        }
                                        $j++;
                                        }
                                    }
                                ?>
                            </ol>
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

              <?php  }
            ?>
		</div>
	</div>
	
</section>

<!--<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>-->
  <script>
        
        // // Extract labels and data from the JavaScript object
    
        const dataPoints = <?php echo $dataPoints; ?>;
        
      
        
        window.addEventListener("load", myInitFunction);
        
        function myInitFunction() {
            
            var chart = new CanvasJS.Chart("chartContainer", {
            	animationEnabled: true,
            	title: {
            		text: "Result Anylysis"
            	},
            	subtitles: [{
            		text: "Report"
            	}],
            	data: [{
            		type: "pie",
            		yValueFormatString: "#,##0.00\"%\"",
            		indexLabel: "{label} ({y})",
            		
            		
            		indexLabelFontColor: "#36454F",
            		indexLabelFontSize: 18,
            		indexLabelFontWeight: "bolder",
            		showInLegend: true,
            		legendText: "{label}",
            		
            		dataPoints: dataPoints
            	}]
            });
            
        chart.render(); 
        }
          
    //     const ctx = document.getElementById('myPieChart').getContext('3d');
 
        
    // // Extract labels and data from the JavaScript object
    //     const labels = dataPoints.map(point => point.label);
    //     const data = dataPoints.map(point => point.y);
    //     console.log(labels);
    //     console.log(data);
         
        
    //     const myPieChart = new Chart(ctx, {
    //         type: 'pie',
    //         data: {
    //             labels: labels,
    //             datasets: [{
    //                 label: 'Results',
    //                 data: data,
    //                 backgroundColor: [
    //                     'rgba(54, 162, 235, 0.2)',
    //                     'rgba(255, 99, 132, 0.2)',
    //                     'rgba(255, 206, 86, 0.2)'
    //                 ],
    //                 borderColor: [
    //                     'rgba(54, 162, 235, 1)',
    //                     'rgba(255, 99, 132, 1)',
    //                     'rgba(255, 206, 86, 1)'
    //                 ],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             responsive: true,
    //             plugins: {
    //                 legend: {
    //                     position: 'bottom',
    //                 },
    //                 title: {
    //                     display: false,
    //                     text: 'Your Result Analytic'
    //                 }
    //             }
    //         }
    //     });
            
      
    </script>