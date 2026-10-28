
<section class="edu_admin_content">
    <div class="edu_admin_right sectionHolder edu_add_users">
        <div class="edu_admin_informationdiv edu_main_wrapper edu_add_student_wrapper">
            <form class="form" id="add_student_form" method="post" enctype="multipart/form-data" autocomplete="off" >
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_title_wrapper">
                            <h4 class="edu_sub_title"><?php echo html_escape($this->common->languageTranslator('ltr_PERSONAL_INFORMATION'));?></h4>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group edu_file_upload">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_image'));?></label>
                            <input type="file" id="file" name="stu_pic" value="<?php echo !empty($student_data)?base_url('uploads/students').$student_data[0]['image']:'';?>">
                            <p class="fileNameShow"></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_name'));?><sup>*</sup></label>
                            <input type="text" class="form-control require alphaField" name="name" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_name'));?>" value="<?php echo !empty($student_data)?$student_data[0]['name']:'';?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_father_name'));?></label>
                           <input type="text" class="form-control alphaField" name="father_name" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_father_name'));?>" value="<?php echo !empty($student_data)?$student_data[0]['father_name']:'';?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_father_occupation'));?></label>
                            <input type="text" class="form-control" name="father_designtn" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_father_occupation'));?>" value="<?php echo !empty($student_data)?$student_data[0]['father_designtn']:'';?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_gender'));?><sup>*</sup></label>
                            <select class="form-control require edu_selectbox_with_search" name="gender" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_gender'));?>">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_gender'));?> </option>
                                <option value="male" <?php echo (!empty($student_data) && $student_data[0]['gender']=='male')?'selected':'';?>><?php echo html_escape($this->common->languageTranslator('ltr_male'));?></option>
                                <option value="female" <?php echo (!empty($student_data) && $student_data[0]['gender']=='female')?'selected':'';?>><?php echo html_escape($this->common->languageTranslator('ltr_female'));?></option>
                                <option value="other" <?php echo (!empty($student_data) && $student_data[0]['gender']=='other')?'selected':'';?>><?php echo html_escape($this->common->languageTranslator('ltr_other'));?></option>
                            </select>
                        </div>
                    </div>
                    
            
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label>State<sup>*</sup></label>
                            <select class="form-control require edu_selectbox_with_search" name="student_state" data-placeholder="State">
                                <option value="">Select State </option>
                                <option value="Andhra Pradesh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Andhra Pradesh')?'selected':'';?>>Andhra Pradesh</option>
                                <option value="Andaman and Nicobar Islands" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Andaman and Nicobar Islands')?'selected':'';?>>Andaman and Nicobar Islands</option>
                                <option value="Arunachal Pradesh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Arunachal Pradesh')?'selected':'';?>>Arunachal Pradesh</option>
                                <option value="Assam" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Assam')?'selected':'';?>>Assam</option>
                                <option value="Bihar" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Bihar')?'selected':'';?>>Bihar</option>
                                <option value="Chandigarh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Chandigarh')?'selected':'';?>>Chandigarh</option>
                                <option value="Chhattisgarh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Chhattisgarh')?'selected':'';?>>Chhattisgarh</option>
                                <option value="Dadra and Nagar Haveli" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Dadra and Nagar Haveli')?'selected':'';?>>Dadra and Nagar Haveli</option>
                                <option value="Daman and Diu" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Daman and Diu')?'selected':'';?>>Daman and Diu</option>
                                <option value="Delhi" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Delhi')?'selected':'';?>>Delhi</option>
                                <option value="Goa" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Goa')?'selected':'';?>>Goa</option>
                                <option value="Gujarat" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Gujarat')?'selected':'';?>>Gujarat</option>
                                <option value="Haryana" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Haryana')?'selected':'';?>>Haryana</option>
                                <option value="Himachal Pradesh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Himachal Pradesh')?'selected':'';?>>Himachal Pradesh</option>
                                <option value="Jammu and Kashmir" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Jammu and Kashmir')?'selected':'';?>>Jammu and Kashmir</option>
                                <option value="Jharkhand" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Jharkhand')?'selected':'';?>>Jharkhand</option>
                                <option value="Karnataka" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Karnataka')?'selected':'';?>>Karnataka</option>
                                <option value="Kerala" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Kerala')?'selected':'';?>>Kerala</option>
                                <option value="Lakshadweep" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Lakshadweep')?'selected':'';?>>Lakshadweep</option>
                                <option value="Ladakh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Ladakh')?'selected':'';?>>Ladakh</option>
                                <option value="Madhya Pradesh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Madhya Pradesh')?'selected':'';?>>Madhya Pradesh</option>
                                <option value="Maharashtra" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Maharashtra')?'selected':'';?>>Maharashtra</option>
                                <option value="Manipur" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Manipur')?'selected':'';?>>Manipur</option>
                                <option value="Meghalaya" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Meghalaya')?'selected':'';?>>Meghalaya</option>
                                <option value="Mizoram" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Mizoram')?'selected':'';?>>Mizoram</option>
                                <option value="Nagaland" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Nagaland')?'selected':'';?>>Nagaland</option>
                                <option value="Odisha" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Odisha')?'selected':'';?>>Odisha</option>
                                <option value="Paducherry" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Paducherry')?'selected':'';?>>Paducherry</option>
                                <option value="Punjab" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Punjab')?'selected':'';?>>Punjab</option>
                                <option value="Rajasthan" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Rajasthan')?'selected':'';?>>Rajasthan</option>
                                <option value="Sikkim" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Sikkim')?'selected':'';?>>Sikkim</option>
                                <option value="Tamil Nadu" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Tamil Nadu')?'selected':'';?>>Tamil Nadu</option>
                                <option value="Telangana" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Telangana')?'selected':'';?>>Telangana</option>
                                <option value="Tripura" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Tripura')?'selected':'';?>>Tripura</option>
                                <option value="Uttar Pradesh" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Uttar Pradesh')?'selected':'';?>>Uttar Pradesh</option>
                                <option value="Uttarakhand" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='Uttarakhand')?'selected':'';?>>Uttarakhand</option>
                                <option value="West Bengal" <?php echo (!empty($student_data) && $student_data[0]['student_state']=='West Bengal')?'selected':'';?>>West Bengal</option>
                            </select>
                        </div>
                    </div>
                    
                    
                      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label>City</label>
                            <input type="text" class="form-control" name="student_city" placehityolder="City" value="<?php echo !empty($student_data)?$student_data[0]['student_city']:'';?>">
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_date_birth'));?><sup>*</sup></label>
                            <span class="select-date">
                                <input type="text" class="form-control chooseDate dobpicker" name="dob" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_dob'));?>" value="<?php echo !empty($student_data)?date('d-m-Y',strtotime($student_data[0]['dob'])):'';?>">
                            </span> 
                        </div>
                    </div>
                    <div class="offset-lg-6 offset-md-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <span>
                            <?php
                                if(!empty($student_data)){
                                    $date1 = new DateTime($student_data[0]['dob']);
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $diff = $date1->diff($date2);
                                    $y = $diff->y.' Years';
                                    $m = $diff->m.' Months';
                                    $d = $diff->d.' Days';
                                }else{
                                    $y = '';
                                    $m = '';
                                    $d = '';
                                }
                                
                            ?>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_year'));?>" id="age_year" value="<?php echo  $y;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_month'));?>" id="age_month" value="<?php echo  $m;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_day'));?>"  id="age_day" value="<?php echo  $d;?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </span> 
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_title_wrapper">
                            <h4 class="edu_sub_title"><?php echo html_escape($this->common->languageTranslator('ltr_CONTACT_INFORMATION'));?></h4>
                        </div>
                    </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_contact_number'));?><sup>*</sup></label>
                             <input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_contact_number'));?>"  name="contact_no" maxlength="12" value="<?php echo !empty($student_data)?$student_data[0]['contact_no']:'';?>" data-valid="mobile" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_contact_msg'));?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_email'));?><sup>*</sup></label>
                             <input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_email'));?>" name="email" value="<?php echo !empty($student_data)?$student_data[0]['email']:'';?>" data-valid="email" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_email_msg'));?>" <?php echo !empty($student_data)?'readonly':'';?>>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_address'));?></label>
                            <textarea name="address" rows="3" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_address'));?>" class="form-control"><?php echo !empty($student_data)?$student_data[0]['address']:'';?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" >
                        <div class="edu_title_wrapper">
                            <h4 class="edu_sub_title"><?php echo html_escape($this->common->languageTranslator('ltr_BATCH_INFORMATION'));?></h4>
                            <input type="radio" name="payMode"value="offline" class="payMode">Offline
                            <input type="radio" name="payMode"value="Online" class="payMode" checked>Online
                        </div>
                    </div>                              
                         <div class="col-lg-6 col-md-6 col-sm-12 col-12 multibatchAdd">
                        <div class="form-group"> 
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_batch'));?><sup>*</sup></label>
                            <select class="form-control edu_selectbox_with_search multibatchr" name="multi_batch_id[]" multiple data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?>">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?></option>
                                <?php
                            
                            if(!empty($batch_name_online)){
                                
                                 
                                // print_r($student_batch_dtail);
                                  foreach($batch_name_online as $batch){
                                     $student_batch_dtail = $this->db_model->select_data('batch_id','sudent_batchs',array('student_id'=>$student_id,'batch_id'=>$batch['id']));
                                 
                                    if(!empty($student_batch_dtail))
                                      {
                                      $selected = 'selected';
                                      }
                                    else
                                      {
                                      $selected = "";
                                      }
                              
                                    echo '<option value="'.$batch['id'].'" '.$selected.'>'.$batch['batch_name'].'</option>';
                              
                                
                            }
                        }
                          
                            ?>
                            </select>
                        </div>
                    </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 edit_batch_hide_fileds" >
                            <div class="form-group" > 
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_batch'));?><sup>*</sup></label>
                                <select class="form-control edu_selectbox_with_search get_batch_price" name="batch_id[]" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?>">
                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?></option>
                                    <?php
                                
                                    if(!empty($batch_name_offline)){
                                        
                                         
                                        // print_r($batch_name);
                                          foreach($batch_name_offline as $batch){
                                            //  $student_batch_dtail = $this->db_model->select_data('batch_id','sudent_batchs',array('student_id'=>$student_id,'batch_id'=>$batch['id']));
                                         
                                            // if(!empty($student_batch_dtail))
                                            //   {
                                            //   $selected = 'selected';
                                            //   }
                                            // else
                                            //   {
                                            //   $selected = "";
                                            //   }
                                      
                                            echo '<option value="'.$batch['id'].'" '.$selected.'>'.$batch['batch_name'].'</option>';
                                        }
                                    }
                                  
                                    ?>
                                </select>
                            </div>
                            <!--<div class='hide subjectArrayDiv'><?php echo json_encode($batch_name);?></div>-->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 batchPrice">
                            <div class="form-group bt">                                  
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_price'));?><sup>*</sup></label>
                                 <input type="text" class="form-control batch_price" maxlength="5" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_price'));?>" name="price" value="">
                            </div>
                        </div>
                    <div class="batch_new_fields_add col-lg-12 col-md-12 col-sm-12 col-12">                   
                    </div>
                </div>
                <?php if(!empty($student_id)){
                    echo '<input type="hidden" value="'.$student_id.'" name="student_id">';
                    $type = 'edit';
                }else{
                    $type = 'add';
                }
                $ltr_add_student = html_escape($this->common->languageTranslator('ltr_add_student'));
                $ltr_update_student = html_escape($this->common->languageTranslator('ltr_update_student'));
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                    <input type="button" value="<?php echo !empty($student_data)? $ltr_update_student : $ltr_add_student ;?>" class="edu_admin_btn addNewStudent" data-type="<?php echo html_escape($type);?>" />
                </div>
               
        </div>
    </div>
</section>