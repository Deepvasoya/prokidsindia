<section class="edu_admin_content">
	<?php $role = $this->session->userdata('role'); ?>
	<div class="edu_admin_right sectionHolder edu_question_manager">				
	    <div class="edu_btn_wrapper sectionHolder">
	    </div>
		<div class="edu_main_wrapper edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">					
				<div class="tableFullWrapper">
				    <ul class="nav nav-tabs" role="tablist">
							    <li class="nav-item" >
									<a class="nav-link active" href="#single" role="tab" data-toggle="tab" aria-selected="true">
										<span class="edu_tab_icons">
											<p><?php echo html_escape($this->common->languageTranslator('ltr_single_question'));?></p>
										</span>
									</a>
								</li>
								<li class="nav-item bulk_upload">
									<a class="nav-link" href="#bulk" role="tab" data-toggle="tab" aria-selected="false">
										<span class="edu_tab_icons">
											<p><?php echo html_escape($this->common->languageTranslator('ltr_bulk_upload'));?></p>
										</span>
									</a>
								</li>
						
							</ul>
							<div class="tab-content">
							     <div role="tabpanel" class="tab-pane fade active in show" id="single">
            <h4 class="edu_sub_title" id="questionPopupLabel"><?php echo html_escape($this->common->languageTranslator('ltr_add_question'));?></h4>
            <form class="pxn_amin form" enctype="multipart/form-data" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group "  >
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?><sup>*</sup></label>
							<select class="form-control filter_subject modalSubjectCls require edu_selectbox_with_search" name="subject_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>"> 
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
								<?php
									if(!empty($subject)){
										foreach($subject as $sub){ 
											$selected="";
											if(isset($single_question['subject_id'])){
												if($single_question['subject_id']==$sub['id']){
													$selected="selected";
												}
											}
											echo '<option value="'.$sub['id'].'" '.$selected.'>'.$sub['subject_name'].'</option>';
										}
									}
								?> 
							</select>
						</div>
    				</div>
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group  add_edit_question" data-id="<?=(isset($single_question['chapter_id']))?$single_question['chapter_id']:''?>">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?><sup>*</sup></label>
							<select  class="form-control filter_modal_chapter  edu_selectbox_with_search" name="chapter_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>"> 
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
							</select>
						</div>
    				</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label>Total Marks<sup>*</sup></label>
							<input type="text" placeholder="Total Marks" class="form-control require" name="total_marks" value="<?=(isset($single_question['total_marks']))?$single_question['total_marks']:""?>">
						</div>
					</div> 
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_question'));?><sup>*</sup></label>
							<span ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Note :-</b>If you want to insert a numerical equation please click on <img src="<?php echo base_url()?>assets/images/sum-sign.svg" style="width: 15px"> </span>
							<!--<textarea name="question" rows="3" placeholder="<?php //echo html_escape($this->common->languageTranslator('ltr_question'));?>" class="form-control"><?//=(isset($single_question['question']))?$single_question['question']:""?></textarea>-->
						
					    	<div id="question" rows="3" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_question'));?>" class="form-control"><?=(isset($single_question['question']))?$single_question['question']:""?></div>
						
						
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group  add_edit_question" data-id="<?=(isset($single_question['chapter_id']))?$single_question['chapter_id']:''?>">
							<label>Question Type<sup>*</sup></label>
							<select  class="form-control   edu_selectbox_with_search" name="question_type" data-placeholder="Please Select" onchange="showDiv(this)"> 
								<option value="1" <?php if($single_question['question_type']==1){echo 'selected';}?>>Single Answer</option>
								<option value="2" <?php if($single_question['question_type']==2){echo 'selected';}?> >Multi Answer</option>
								<option value="3" <?php if($single_question['question_type']==3){echo 'selected';}?>>Fill in the Blanks</option>
							</select>
						</div>
						
						
					
					
						<div class="form-group" id="singleanswer" <?php if($single_question['question_type']=='2' || $single_question['question_type']=='3' ){echo "style='display:none'";}else{?><?php echo 'style="display:block"';}?>>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="lblWordLimit">
						<div class="form-group">
							<label>Word Limit<sup>*</sup></label>
							<input type="text" placeholder="Word Limit" class="form-control" name="word_limit" value="<?=(isset($single_question['word_limit']))?$single_question['word_limit']:""?>">
						</div>
					  </div>
							<label>Answer<sup>*</sup></label>
							<span ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Note :-</b>If you want to insert a numerical equation please click on <img src="<?php echo base_url()?>assets/images/sum-sign.svg" style="width: 15px"> </span>
							<!-- <textarea name="single_answer" rows="3" id="single_answer" placeholder="Answer" class="form-control"><?//=(isset($single_question['single_answer']))?$single_question['single_answer']:""?></textarea> -->
							<div id="single_answer" rows="3" placeholder="Answer" class="form-control"><?=(isset($single_question['single_answer']))?$single_question['single_answer']:""?></div>
						</div>
						<div id="total_options" class="form-group  add_edit_question" <?php if($single_question['total_options']>0){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
							<label>Total Options<sup>* </sup></label>
							<select  class="form-control edu_selectbox_with_search" name="total_options" data-placeholder="Please Select" onchange="showAnswers(this)"> 
								<option value="">Please Select</option>
								<option value="1" <?php if($single_question['total_options']==1){echo 'selected';}?>>1</option>
								<option value="2" <?php if($single_question['total_options']==2){echo 'selected';}?>>2</option>
								<option value="3" <?php if($single_question['total_options']==3){echo 'selected';}?>>3</option>
								<option value="4" <?php if($single_question['total_options']==4){echo 'selected';}?>>4</option>
								<option value="5" <?php if($single_question['total_options']==5){echo 'selected';}?>>5</option>
								<option value="6" <?php if($single_question['total_options']==6){echo 'selected';}?>>6</option>
								<option value="7" <?php if($single_question['total_options']==7){echo 'selected';}?>>7</option>
								<option value="8" <?php if($single_question['total_options']==8){echo 'selected';}?>>8</option>
								<option value="9" <?php if($single_question['total_options']==9){echo 'selected';}?>>9</option>
								<option value="10" <?php if($single_question['total_options']==10){echo 'selected';}?>>10</option>
							</select>
						</div>
						<div class ="fill_options" id="fill_options" <?php if(($single_question['answer_1']!='' or $single_question['answer_2']!='' or $single_question['answer_3']!='' or $single_question['answer_4']!='' or $single_question['answer_5']!='' or $single_question['answer_6']!='' or $single_question['answer_7']!='' or $single_question['answer_8']!='' or $single_question['answer_9']!='' or $single_question['answer_10']!='') && $single_question['question_type']=='3'){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group" id="1answer" <?php if($single_question['answer_1']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 1<sup>*</sup></label>
									

									<div id="answer_1" rows="3" placeholder="Answer 1" class="form-control"><?php if($single_question['answer_1']){echo $single_question['answer_1'];}?></div>
								</div>
								<div class="form-group" id="2answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 2<sup>*</sup></label>
									<div id="answer_2" rows="3" placeholder="Answer 2" class="form-control"><?php if($single_question['answer_2']){echo $single_question['answer_2'];}?></div>
								</div>
								<div class="form-group" id="3answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 3<sup>*</sup></label>
									<div id="answer_3" rows="3" placeholder="Answer 3" class="form-control"><?php if($single_question['answer_3']){echo $single_question['answer_3'];}?></div>
								</div>
								<div class="form-group" id="4answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 4<sup>*</sup></label>
									<div id="answer_4" rows="3" placeholder="Answer 4" class="form-control"><?php if($single_question['answer_4']){echo $single_question['answer_4'];}?></div>
								</div>
								<div class="form-group" id="5answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 5<sup>*</sup></label>
									<div id="answer_5" rows="3" placeholder="Answer 5" class="form-control"><?php if($single_question['answer_5']){echo $single_question['answer_5'];}?></div>
								</div>
								<div class="form-group" id="6answer"  <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!='' and $single_question['answer_6']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 6<sup>*</sup></label>
									<div id="answer_6" rows="3" placeholder="Answer 6" class="form-control"><?php if($single_question['answer_1']){echo $single_question['answer_6'];}?></div>
								</div>
								<div class="form-group" id="7answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!='' and $single_question['answer_6']!='' and $single_question['answer_7']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 7<sup>*</sup></label>
									<div id="answer_7" rows="3" placeholder="Answer 7" class="form-control"><?php if($single_question['answer_7']){echo $single_question['answer_7'];}?></div>
								</div>
								<div class="form-group" id="8answer"<?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!='' and $single_question['answer_6']!='' and $single_question['answer_7']!='' and $single_question['answer_8']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 8<sup>*</sup></label>
									<div id="answer_8" rows="3" placeholder="Answer 8" class="form-control"><?php if($single_question['answer_8']){echo $single_question['answer_8'];}?></div>
								</div>
								<div class="form-group" id="9answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!='' and $single_question['answer_6']!='' and $single_question['answer_7']!='' and $single_question['answer_8']!='' and $single_question['answer_9']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 9<sup>*</sup></label>
									<div id="answer_9" rows="3" placeholder="Answer 9" class="form-control"><?php if($single_question['answer_9']){echo $single_question['answer_9'];}?></div>
								</div>
								<div class="form-group"  id="10answer" <?php if($single_question['answer_1']!='' and $single_question['answer_2']!='' and $single_question['answer_3']!='' and $single_question['answer_4']!='' and $single_question['answer_5']!='' and $single_question['answer_6']!='' and $single_question['answer_7']!='' and $single_question['answer_8']!='' and $single_question['answer_9']!='' and $single_question['answer_10']!=''){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
									<label>Answer 10<sup>*</sup></label>
									<div id="answer_10" rows="3" placeholder="Answer 10" class="form-control"><?php if($single_question['answer_10']){echo $single_question['answer_10'];}?></div>
								</div>
							</div>
							
						</div>	
    				</div>
						<div  id="question_options" class="question_options" <?php if($single_question['question_type']=='2'){echo "style='display:block'";}else{echo "style='display:none'";}?>>
						    <div  class="row">
        						<?php 
        							$op = '1';
        							$cn = 'A';
        							$option=(isset($single_question['options']))?json_decode($single_question['options']):"";
        							//print_r($option);
        							for($i=1; $i<5; $i++){
        								?>
        								<div class="col-lg-6 col-md-12 col-sm-12 col-12">
        									<div class="form-group">
        										<label>
        											<div class="ans_option"><?php echo html_escape($this->common->languageTranslator('ltr_option_'.$cn));?> <sup>*</sup></div>
        										</label>
        										<!-- <textarea type="text" class="form-control editor" name="options[]" id="option<?=$i?>" placeholder="<?php //echo html_escape($this->common->languageTranslator('ltr_option_'.$cn));?>"><?//=(isset($option[$i-1]))?$option[$i-1]:""?></textarea> -->

        											<div id="option<?=$i?>" rows="3" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_option_'.$cn));?>" class="form-control"><?=(isset($option[$i-1]))?$option[$i-1]:""?></div>


        									</div>
        								</div>
        							<?php
        								$op++;
        								$cn++;
        							} ?>
        					    </div>
						</div>
    				</div>
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12 chooserightans" id="chooserightans" <?php if($single_question['answer']!=''){echo "style='display:block'";}else{?><?php echo 'style="display:none"';}?>>

    				    <label class="ans_option"><?php echo html_escape($this->common->languageTranslator('ltr_right_answer'));?><sup>*</sup></label>
    					<div class="form-group edu_radio_holder_wrapper">
							<div class="edu_radio_holder">
							    <label for="radio"><?php echo html_escape($this->common->languageTranslator('ltr_a'));?></label>
							    <input type="radio" class="ansRadioChck" name="answer" value="A" <?php if(isset($single_question['answer']) && ($single_question['answer']=="A")){ echo "checked"; }?>>
							</div>
							<div class="edu_radio_holder">
							    <label for="radio"><?php echo html_escape($this->common->languageTranslator('ltr_b'));?></label>
							    <input type="radio" class="ansRadioChck" name="answer" value="B" <?php if(isset($single_question['answer']) && ($single_question['answer']=="B")){ echo "checked"; }?>>
							</div>
							<div class="edu_radio_holder">
							    <label for="radio"><?php echo html_escape($this->common->languageTranslator('ltr_c'));?></label>
							    <input type="radio" class="ansRadioChck" name="answer" value="C" <?php if(isset($single_question['answer']) && ($single_question['answer']=="C")){ echo "checked"; }?>>
							</div>
							<div class="edu_radio_holder">
							    <label for="radio"><?php echo html_escape($this->common->languageTranslator('ltr_d'));?></label>
							    <input type="radio" class="ansRadioChck" name="answer" value="D" <?php if(isset($single_question['answer']) && ($single_question['answer']=="D")){ echo "checked"; }?>>
							</div>
						</div>
    				</div>
    				
    				
    				
    				<!--Description-->
    				
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 quesdescription" id= "quesdescription" <?php if($single_question['question_type']=='2'){echo "style='display:block'";}else{?><?php echo 'style="display:none"';}?>>
    					<label>Solution</label>
						
						<!-- <textarea name="description_solution" rows="3" placeholder="<?php //echo "Description for the write answer.";?>" class="form-control"><?//=(isset($single_question['description']))?$single_question['description']:""?></textarea> -->
						<div id="description_solution" rows="3" placeholder="Description for the write answer." class="form-control"><?=(isset($single_question['description_solution']))?$single_question['description_solution']:""?></div>

    				</div>
    				<!--Description-->
    				
    				
    				
    				
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_add_question'));?>" class="btn btn-primary add_Newquestion" data-id="<?php if(isset($single_question['id']) && ($single_question['id']!="")){ echo $single_question['id']; }?>">
						</div>
    				</div>
				</div>
            </form>
            </div>
             <div role="tabpanel" class="tab-pane fade" id="bulk">
                 <form class="pxn_amin form" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="UTF-8">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?><sup>*</sup></label>
							<select class="form-control filter_subject modalSubjectCls require edu_selectbox_with_search" name="subject_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>"> 
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
								<?php
									if(!empty($subject)){
										foreach($subject as $sub){
											echo '<option value="'.$sub['id'].'">'.$sub['subject_name'].'</option>';
										}
									}
								?> 
							</select>
						</div>
    				</div>
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?><sup>*</sup></label>
							<select  class="form-control filter_modal_chapter require edu_selectbox_with_search" name="chapter_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>"> 
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
							</select>
						</div>
    				</div>
    				
    				<div class="form-group  add_edit_question" data-id="">
							<label>Question Type<sup>*</sup></label>
							<select class="form-control edu_selectbox_with_search select2-hidden-accessible" name="question_type" data-placeholder="Please Select" onchange="showDiv(this)" data-select2-id="7" tabindex="-1" aria-hidden="true"> 
								<option value="1" data-select2-id="9">Single Answer</option>
								<option value="2">Multi Answer</option>
								<!-- <option value="3">Fill in the Blanks</option> -->
							</select>
						</div>
						
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_excel'));?><sup>*</sup></label>
    						<input type="file" class="form-control require" name="result_file" id="result_file"  data-valid="excel" data-error="Upload xlsx format">
    						<p class="fileNameShow"></p>
						</div>
						
    				</div>
    				
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_upload_question'));?>" class="btn btn-primary upload_new_question"/>
							<a href="<?php echo base_url(); ?>uploads/demo/uploadQuestionExcel-1.xlsx" class="btn btn-primary" ><?php echo html_escape($this->common->languageTranslator('ltr_download_demo_file'));?></a>
						</div>
    				</div>
				</div>
            </form>
                 </div>
        </div>
    			</div>
			</div>
		</div>
		
	</div>
</section> 


<!-- Pop view characters Start  -->
<div id="charactersViewPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
           <h4 class="edu_sub_title" id="charaTitele"></h4>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
                        <div class="charactersViewResult"></div>
                    </div>
				</div>
			</div>
        </div>
    </div>
</div>
 <!-- <link href='https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css' rel='stylesheet'>
  <script src='https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>
  <link href='https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css' rel='stylesheet'>
  <script src='https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js'></script>-->
  
  <!-- jquery, bootstrap -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- codemirror -->

  <!-- add summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>

<style type="text/css">
	.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: relative!important;
    margin-top: 4px\9!important;
    margin-left: -20px!important;
}
</style>
