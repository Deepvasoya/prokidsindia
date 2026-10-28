<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_view_paper">
	    <div class="edu_main_wrapper">				
    		<div class="edu_admin_informationdiv">
    		    <div class="question_paper_views">
    		        <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom20">
                            <div class="responsive_center">
                                <h4 class="edu_sub_title">
                                    <?php  
                    				if(!empty($paperData[0]['name'])){
                    					echo '<span>Paper Name:</span>'.$paperData[0]['name']; 
                    				} ?>
                    			</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 padderBottom20">
                             <div class="responsive_center text-right">
                                <h4 class="edu_sub_title">
                                    <?php
                    				if(!empty($paperData[0]['time_duration'])){
                    					$hr=intval($paperData[0]['time_duration']/60);
                    					$min=intval($paperData[0]['time_duration']%60);
                    					echo '<span>Time:</span> ';
                    					if($hr>0){
                    						echo  $hr.' Hr  ';
                    					}
                    					if($min>0){
                    						echo  $min.' Min';
                    					} 
                    				} ?> 
                    			</h4>
                            </div>
                        </div>
                    </div>
                    <div class="edu_questionView_section">
                        <ol>
                            <?php 
        						$cnt=1;
        						if(!empty($paperData)){
        							$questions = json_decode($paperData[0]['question_ids']);
        							foreach($questions as $ques){
        								$questionData = $this->db_model->select_data('*','questions use index (id)',array('id'=>$ques),1);
        								if(!empty($questionData)){
											$qtype = $questionData[0]['question_type'];
        								?> 
        								<li>
                                            <div class="edu_single_questionView_wrap">
                                                <div class="edu_singleView_question questionsDiv">
                									<div class="quest">Q <?php echo  $cnt; ?>.
                										<?php 
                											echo $questionData[0]['question'];
														?>
                									</div>
													<?php if($qtype==3){ ?>
														<div class="edu_questionView_options">
															<ul class="question_options">
															<?php if ($questionData[0]['answer_1']){?>
																<li><span class="optionsTag">A: <?php echo $questionData[0]['answer_1'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_2']){?>
																<li><span class="optionsTag">B: <?php echo $questionData[0]['answer_2'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_3']){?>
																<li><span class="optionsTag">C:<?php echo $questionData[0]['answer_3'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_4']){?>
																<li><span class="optionsTag">D:<?php echo $questionData[0]['answer_4'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_5']){?>
																<li><span class="optionsTag">E:<?php echo $questionData[0]['answer_5'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_6']){?>
																<li><span class="optionsTag">F:<?php echo $questionData[0]['answer_6'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_7']){?>
																<li><span class="optionsTag">G:<?php echo $questionData[0]['answer_7'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_8']){?>
																<li><span class="optionsTag">H:<?php echo $questionData[0]['answer_8'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_9']){?>
																<li><span class="optionsTag">I:<?php echo $questionData[0]['answer_9'];?></li>
															<?php }?>
															<?php if ($questionData[0]['answer_10']){?>
																<li><span class="optionsTag">j:<?php echo $questionData[0]['answer_10'];?></li>
															<?php }?>
															
															</ul>
                    									</div>	
													<?php } ?>
                									<div class="edu_questionView_options">
                    									<ul class="question_options">
                    										<?php
                    										$optionArr = json_decode($questionData[0]['options'],true);
                    										$i = 'A';
                    										foreach($optionArr as $op){
                    											echo '<li><span class="optionsTag">'.$i.'.</span>. '.$op.'</li>';
                    											$i++;
                    										}
                    										?>
                    									</ul>
                    								</div>
                								</div>
        								    </div>
        								</li>
        								<?php
        								}
        							}
        						}
        						?>
                        </ol>
                    </div>
                </div>
    		</div>
    	</div>
	</div>
</section> 