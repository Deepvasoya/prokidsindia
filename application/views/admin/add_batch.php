<?php print_r($batchData);?>
<section class="edu_admin_content">
    <div class="edu_admin_right sectionHolder edu_add_users">
        <div class="edu_admin_informationdiv edu_main_wrapper">
            <form class="form" method="post">
                <div class="row">
                    <?php if(isset($batch_data) && !empty($batch_data)){
                        $batchData = $batch_data[0];
                        
                     $this->db_model->select_data('*','batch_subcategory use index (id)',$cond,'',array('id','desc'));


                        $subjectData = $this->db_model->select_data('batch_subjects.*,subjects.subject_name','batch_subjects use index (batch_id)',array('batch_subjects.batch_id'=>$batch_id),'',array('id','asc'),'',array('subjects','subjects.id = batch_subjects.subject_id'));
                       
                        
                    }else{
                        $batchData = array();
                    }?>
                    	<div class="col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_category'));?> <sup>*</sup></label>								
							<select class="form-control edu_selectbox_with_search category_dropdown" id="category_dropdown" name="category" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_category'));?>">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_category'));?></option>
								<?php foreach($category_data as $cat){?>
									<option value="<?php echo $cat['id'];?>"<?php if(!empty($batchData['cat_id'])){if($cat['id']== $batchData['cat_id']){ echo "selected"; }} ;?>><?php echo $cat['name']; ?>	</option>
								<?php }?>
							</select>								
						</div>	 
					</div>
						<div class="col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_select_subcategory'));?> <sup>*</sup></label>								
							<select class="form-control edu_selectbox_with_search subcategory_dropdown" id="subcategory_dropdown" name="subcategory" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subcategory'));?>">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subcategory'));?></option>
							               <?php
                                        if(!empty($batchData['cat_id'])){
                                             $subcat = $this->db_model->select_data('id,name,slug','batch_subcategory use index (id)',array('cat_id'=>$batchData['cat_id'],'status'=> 1),'',array('id','desc'));
                                        // $subcat = current($this->db_model->select_data('*','batch_subcategory use index (id)', array('cat_id'=>$batchData['cat_id'])));
                                            
                                         foreach($subcat as $sub_cat){?>
                                         
                                          <option value="<?php echo $sub_cat['id'];?>"<?php if(!empty($batchData['sub_cat_id'])){if($sub_cat['id']== $batchData['sub_cat_id']){ echo "selected"; }} ;?>><?php echo $sub_cat['name']; ?>	</option>        
                                                  
                                           
                                                       <?php } } ?>
							</select>							
						</div>	
					</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_batch_name'));?><sup>*</sup></label>
    						<input type="text" class="form-control require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_batch_name'));?>" name="batch_name"  id="batchName" value="<?php echo (isset($batchData['batch_name']) && !empty($batchData['batch_name']))?$batchData['batch_name']:'';?>">			
    					</div>
    				</div>
    				<!--<div class="col-lg-6 col-md-12 col-sm-12 col-12">-->
    				<!--	<div class="form-group">-->
    				<!--		<label><?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?><sup>*</sup></label>-->
    				<!--		<input type="text" class="form-control require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?>"  name="start_date"  id="b_startDate" value="<?php echo (isset($batchData['start_date']) && !empty($batchData['start_date']))?date('d-m-Y',strtotime($batchData['start_date'])):'';?>">	-->
    				<!--	</div>-->
    				<!--</div>-->
    				<!--<div class="col-lg-6 col-md-12 col-sm-12 col-12">-->
    				<!--	<div class="form-group">-->
    				<!--		<label><?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?><sup>*</sup></label>-->
    				<!--		<input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?>" name="end_date"  id="b_endDate" value="<?php echo (isset($batchData['end_date']) && !empty($batchData['end_date']))?date('d-m-Y',strtotime($batchData['end_date'])):'';?>">-->
    				<!--	</div>-->
    				<!--</div>-->
    				
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group eb_batchtype">
    						<label><?php echo "Duration Type";?><sup>*</sup></label>
							<div class="form-control">
								<label class="font-weight-bold"><?php echo "Set Validity";?></label>
    							<input type="radio"  class="durationType setvalid" name="durationType" <?php if(!empty($batchData['duration_type']) && $batchData['duration_type']=='1'){ echo 'checked'; } ?> value="1">
    						</div>
    						<div class="form-control">
								<br><label class="font-weight-bold"><?php echo "Set Expiry";?></label><br/>
								<input type="radio" class="durationType setexp"  name="durationType" <?php if(!empty($batchData['duration_type']) && $batchData['duration_type']=='2'){ echo 'checked'; } ?> value="2">
							</div>
							<div class="form-control">
								<label  class="font-weight-bold"><?php echo "Lifetime Validity";?></label>
								<input type="radio" class="durationType setlifetime"  name="durationType" <?php if(!empty($batchData['duration_type']) && $batchData['duration_type']=='3'){ echo 'checked'; } ?> value="3">
							</div>
    					</div>
					</div>
					
					    <div class="col-lg-6 col-md-12 col-sm-12 col-12 hide_total_valid" <?php if($batchData['duration_type']==1){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
        					<div class="form-group">
        						<label><?php echo 'Enter Validity';?><sup>*</sup></label>
        						<input type="text" class="form-control"  placeholder="Enter Validity" name="total_validity"  id="total_validity" value="<?php echo (isset($batchData['total_validity']) && !empty($batchData['total_validity']))?$batchData['total_validity']:'';?>">			
        					</div>
        			    </div>
    					 <div class="col-lg-6 col-md-12 col-sm-12 col-12 hide_valid_type"  <?php if($batchData['duration_type']==1){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
						    <div class="form-group">
    							<label>Validity In <sup>*</sup></label>								
    							<select class="form-control edu_selectbox_with_search category_dropdown" id="validity_type" name="validity_in" data-placeholder="Select Validity">
    								<option value="">Select</option>
    								<option value="years" <?php if(!empty($batchData['validity_in']) && $batchData['validity_in']=='years'){ echo 'selected'; } ?>>Year(s)</option>
    								<option value="months" <?php if(!empty($batchData['validity_in']) && $batchData['validity_in']=='months'){ echo 'selected'; } ?>>Month(s)</option>
    								<option value="days" <?php if(!empty($batchData['validity_in']) && $batchData['validity_in']=='days'){ echo 'selected'; } ?>>Day(s)</option>
    							</select>								
						    </div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 hide_expiry_date" <?php if($batchData['duration_type']==2){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
    					<div class="form-group">
    						<label><?php echo 'Set Expiry Date';?><sup>*</sup></label>
    						
    							<input type="text" class="form-control chooseDate"  name="batch_expiry"  id="set_expiry" value="<?php echo (isset($batchData['batch_expiry']) && !empty($batchData['batch_expiry']))?date('d-m-Y',strtotime($batchData['batch_expiry'])):'';?>">
    						
    					</div>
    				</div>
    				
					
					
					
    				<!--Duration Type-->
    	<!--			<div class="col-lg-12 col-md-12 col-sm-12 col-12">-->
    	<!--				<div class="form-group eb_batchtype">-->
    	<!--					<label><?php echo "Duration Type";?><sup>*</sup></label><br>-->
					<!--		<div class="form-control">-->
					<!--			<label><?php echo "Fixed Duration";?></label>-->
    	<!--						<input type="radio" <?php if(!empty($batchData['duration_type']) && $batchData['duration_type']==1){ echo 'checked'; }else{ echo 'checked'; } ?> class="durationType" name="durationType" value="1">-->
					<!--			<label><?php echo "Flexible Duration";?></label>-->
					<!--			<input type="radio" class="durationType" <?php if(!empty($batchData['duration_type']) && $batchData['duration_type']==2){ echo 'checked'; }?> name="durationType" value="2">-->
					<!--		</div>-->
    	<!--				</div>-->
					<!--</div>-->
					<!--Duration Type-->
    				
    				
    				
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?><sup>*</sup></label>
    						<div class="chooseTime">
    							<input type="text" class="form-control require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?>"  name="start_time"  id="b_startTime" value="<?php echo (isset($batchData['start_time']) && !empty($batchData['start_time']))?date('h:i A',strtotime($batchData['start_time'])):'';?>">
    						</div>	
    					</div>
    				</div>
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?><sup>*</sup></label>
    						<div class="chooseTime">
    							<input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?>" name="end_time"  id="b_endTime" value="<?php echo (isset($batchData['end_time']) && !empty($batchData['end_time']))?date('h:i A',strtotime($batchData['end_time'])):'';?>">
    						</div>
    					</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group eb_batchtype">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_batch_type'));?><sup>*</sup></label><br>
							<div class="form-control">
								<label><?php echo html_escape($this->common->languageTranslator('ltr_free'));?></label>
    							<input type="radio" <?php if(!empty($batchData['batch_type']) && $batchData['batch_type']==1){ echo 'checked'; }else{ echo 'checked'; } ?> class="batchType" name="batchType" value="1">
								<label><?php echo html_escape($this->common->languageTranslator('ltr_paid'));?></label>
								<input type="radio" class="batchType" <?php if(!empty($batchData['batch_type']) && $batchData['batch_type']==2){ echo 'checked'; }?> name="batchType" value="2">
							</div>
    					</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-12 batchPrice <?php if(!empty($batchData['batch_type']) && $batchData['batch_type']==2){ echo 'show'; }else{ echo 'hide'; } ?>">
					   
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_batch_price'));?><sup>*</sup></label><br>
							<input type="text" data-valid="number" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_price_msg'));?>" maxlength="10" class="form-control"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_price')).' '. $currency_code; ?> " name="batchPrice"  id="batchPrice" data-conv="" value="<?php if(!empty($batchData['batch_price'])){ echo $batchData['batch_price'] ;} ?>">	
    					</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-12 batchPrice <?php if(!empty($batchData['batch_type']) && $batchData['batch_type']==2){ echo 'show'; }else{ echo 'hide'; } ?>">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_offer_price'));?><sup>*</sup></label><br>
							<input type="text" data-valid="number" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_price_msg'));?>" maxlength="10" class="form-control"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_price')).' '. $currency_code; ?> " name="batchOfferPrice"  id="batchOfferPrice" value="<?php if(!empty($batchData['batch_offer_price'])){ echo $batchData['batch_offer_price'] ;} ?>">	
    					</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-12 batchPrice <?php if(!empty($batchData['batch_type']) && $batchData['batch_type']==2){ echo 'show'; }else{ echo 'hide'; } ?>">
    					   
    					<div class="form-group">
    					  <input type="radio" name="payMode"value="offline" class="payModeBatch">Offline
                            <input type="radio" name="payMode"value="Online" class="payModeBatch" checked>Online
                            <span class="remove_svg"><svg data-id="1" class="svg-inline--fa fa-remove fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="remove" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><g><path fill="currentColor" d="M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z"></path><circle fill="currentColor" cx="256" cy="364" r="28"><animate attributeType="XML" repeatCount="indefinite" dur="2s" attributeName="r" values="28;14;28;28;14;28;"></animate><animate attributeType="XML" repeatCount="indefinite" dur="2s" attributeName="opacity" values="1;0;1;1;0;1;"></animate></circle><path fill="currentColor" opacity="1" d="M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z"><animate attributeType="XML" repeatCount="indefinite" dur="2s" attributeName="opacity" values="1;0;0;0;0;1;"></animate></path><path fill="currentColor" opacity="0" d="M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z"><animate attributeType="XML" repeatCount="indefinite" dur="2s" attributeName="opacity" values="0;0;1;1;0;0;"></animate></path></g></svg></span> 
    				         <div class="hint">
    					       <span >You can select the payment mode for batch from here as Online or Offline. If selected Offline then student need to purchase the batch manually.</span>
    					   </div>
    					</div>
					</div>
                </div>
                
				<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_accordion_container_heading">
                            <?php 
                            if(!empty($batch_fecherd)){
                                foreach($batch_fecherd as $value){ ?>
                                <div class="edu_accord_parent">
                                    <span class="edu_accordion_header">
										<span class="speci_heading"><?php echo isset($value['batch_specification_heading'])?$value['batch_specification_heading']: html_escape($this->common->languageTranslator('ltr_benefit'));?></span> 
										<i>
											<i class="fa fa-angle-right upDownI"></i>
											<i data-id="<?php echo isset($value['id'])?$value['id']:'';?>" class="fa fa-trash eb_removeacc removeAccHeading"></i>
										</i>
                                    </span>
                                    <div class="edu_accordion_content count_heading">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
												 <label><?php echo html_escape($this->common->languageTranslator('ltr_heading'));?></label>
                                                <input type="text" class="form-control"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_i_learn'));?>" name="batch_speci_heading[]" value="<?php echo isset($value['batch_specification_heading'])?$value['batch_specification_heading']:'';?>">
                                        <input value="<?php echo isset($value['id'])?$value['id']:'';?>" type="hidden" name="batch_speci_id[]">
                                                </div>
                                            </div>
											 <div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group">
													<label><?php echo html_escape($this->common->languageTranslator('ltr_fecherd'));?></label>
													<div class="batch_sub_heading">
											<?php if(!empty($value['batch_fecherd'])){
												$rrr = json_decode($value['batch_fecherd']);
												foreach($rrr as $key){ ?>
													<div class="sub_input">
													   <input type="text" class="form-control fecherd"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_fecherd'));?>" value="<?php echo $key; ?>" >
													   <div class="eb_subhead_icon">
    													  <i class="fa fa-plus eb_add_sheading assSubHeading"></i>
    													  <i class="fa fa-trash eb_rem_sheading removeSubHeading"></i>
    												    </div>
													</div>
												<?php }
											}else{ ?>
                                                    <div class="sub_input">
													  <input type="text" class="form-control fecherd"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_fecherd'));?>" name="batch_sub_fecherd[]" >
													  <div class="eb_subhead_icon">
    													  <i class="fa fa-plus eb_add_sheading assSubHeading"></i>
    													  <i class="fa fa-trash eb_rem_sheading removeSubHeading"></i>
    												    </div>
													</div>
												
											<?php } ?>
													</div>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                               <?php }
                            }else{ ?>
                            <div class="edu_accord_parent">
                                <span class="edu_accordion_header">
                                    <span class="speci_heading"><?php echo html_escape($this->common->languageTranslator('ltr_benefit'));?></span> 
                                    <i>
                                        <i class="fa fa-angle-right upDownI"></i>
                                        <i class="fa fa-trash eb_removeacc removeAccHeading"></i>
                                    </i>
                                </span>
                                <div class="edu_accordion_content count_heading">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_heading'));?></label>
                                                <input type="text" class="form-control"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_i_learn'));?>" name="batch_speci_heading[]" >
                                                <input value="" type="hidden" name="batch_speci_id[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_fecherd'));?></label>
                                                <div class="batch_sub_heading">
                                                    <div class="sub_input">
													  <input type="text" class="form-control fecherd"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_fecherd'));?>" name="batch_sub_fecherd[]" >
													  <div class="eb_subhead_icon">
    													  <i class="fa fa-plus eb_add_sheading assSubHeading"></i>
    													  <i class="fa fa-trash eb_rem_sheading removeSubHeading"></i>
    												    </div>
													</div>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                     </div>
					 
					 <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_image'));?></label>
    						<input type="file" class="form-control" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_image'));?>" name="batch_image" data-valid="image" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_image_msg'));?>" id="batch_image" value="">
    							<p class="fileNameShow"></p>
    					</div>
    				</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_description'));?></label>
							<textarea class="form-control" name="batch_description" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_description'));?>"><?php if(!empty($batchData['description'])){ echo $batchData['description']; } ?></textarea>
    					</div>
    				</div>
    				
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group eb_batchtype">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_module_access'));?><sup>*</sup></label><br>
                            <div class="form-control">
                               
                               
                               <?php 
                               $annoucement = 'checked';
                               $liveclass = 'checked';
                               $mcq = 'checked';
                               $upcoming_exam = 'checked';
                               $video_lecture = 'checked';
                               $assignment = 'checked';
                               $extra_classes = 'checked';
                               $doubts = 'checked';
                               $attendace = 'checked';
                               $book = 'checked';
                               $notes = 'checked';
                               $old_paper = 'checked';
                               $syllabus = 'checked';
                               $audio = 'checked';
                               
                               if(!empty($batchData['access'])){
                                    $accessData =  json_decode($batchData['access']);
                                    if($accessData->annoucement == NULL || empty($accessData->annoucement)){
                                        $annoucement = ""; 
                                    }
                                    if($accessData->liveclass == NULL || empty($accessData->liveclass)){
                                        $liveclass = ""; 
                                    }
                                    if($accessData->mcq == NULL || empty($accessData->mcq)){
                                        $mcq = ""; 
                                    }
                                    if($accessData->upcoming_exam == NULL || empty($accessData->upcoming_exam)){
                                        $upcoming_exam = ""; 
                                    }
                                    if($accessData->video_lecture == NULL || empty($accessData->video_lecture)){
                                        $video_lecture = ""; 
                                    }
                                    if($accessData->assignment == NULL || empty($accessData->assignment)){
                                        $assignment = ""; 
                                    }
                                    if($accessData->extra_classes == NULL || empty($accessData->extra_classes)){
                                        $extra_classes = ""; 
                                    }
                                    if($accessData->doubts == NULL || empty($accessData->doubts)){
                                        $doubts = ""; 
                                    }
                                    if($accessData->attendace == NULL || empty($accessData->attendace)){
                                        $attendace = ""; 
                                    }
                                    if($accessData->book == NULL || empty($accessData->book)){
                                        $book = ""; 
                                    }
                                    if($accessData->notes == NULL || empty($accessData->notes)){
                                        $notes = ""; 
                                    }
                                    if($accessData->old_paper == NULL || empty($accessData->old_paper)){
                                        $old_paper = ""; 
                                    }
                                    if($accessData->syllabus == NULL || empty($accessData->syllabus)){
                                        $syllabus = ""; 
                                    }
                                    
                                    if($accessData->audio == NULL || empty($accessData->audio)){
                                        $audio = ""; 
                                    }
                               }  ?>
                               
                               
                                 <label><?php echo html_escape($this->common->languageTranslator('ltr_annoucement'));?>
                                    <input type="checkbox" class="annoucement" name="annoucement" value="1" <?php echo $annoucement; ?>></label>
                               
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_liveclass'));?>
                                    <input type="checkbox" class="liveclass" name="liveclass" value="1" <?php echo $liveclass; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_mcq'));?>
                                    <input type="checkbox" class="mcq" name="mcq" value="1" <?php echo $mcq; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_upcoming_exam'));?>
                                    <input type="checkbox" class="upcoming_exam" name="upcoming_exam" value="1" <?php echo $upcoming_exam; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_video_lecture'));?>
                                    <input type="checkbox" class="video_lecture" name="video_lecture" value="1" <?php echo $video_lecture; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_assignment'));?>
                                    <input type="checkbox" class="assignment" name="assignment" value="1" <?php echo $assignment; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_extra_classes'));?>
                                    <input type="checkbox" class="extra_classes" name="extra_classes" value="1" <?php echo $extra_classes; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_doubts'));?>
                                    <input type="checkbox" class="doubts" name="doubts" value="1" <?php echo $doubts; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_attendace'));?>
                                    <input type="checkbox" class="attendace" name="attendace" value="1" <?php echo $attendace; ?>></label>
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_book'));?>
                                    <input type="checkbox" class="book" name="book" value="1" <?php echo $book; ?>></label>  
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_notes'));?>
                                    <input type="checkbox" class="notes" name="notes" value="1" <?php echo $notes; ?>></label>  
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_old_paper'));?>
                                    <input type="checkbox" class="old_paper" name="old_paper" value="1" <?php echo $old_paper; ?>></label> 
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_syllabus'));?>
                                    <input type="checkbox" class="syllabus" name="syllabus" value="1"  <?php echo $syllabus; ?>></label> 
                                <label>Audio
                                    <input type="checkbox" class="audio" name="audio" value="1"  <?php echo $audio; ?>></label> 
                            </div>
                        </div> 
                    </div> 
                    
                    
                </div>
				<!-- end -->

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_accordion_container">
                            <?php 
                            if(!empty($subjectData)){
                                foreach($subjectData as $sublst){ ?>
                                <div class="edu_accord_parent">
                                    <span class="edu_accordion_header">
                                        <span class="subjects_name"><?php echo isset($sublst['subject_name'])?$sublst['subject_name']:'';?></span> 
                                        <i>
                                            <i class="fa fa-angle-right upDownI"></i>
                                            <i class="fa fa-trash removeAccSub eb_removeacc"></i>
                                        </i>
                                    </span>
                                    <div class="edu_accordion_content">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?><sup>*</sup></label>
                                                    <select class="edu_selectbox_with_search form-control require filter_subject" name="batch_subject[]" data-teacher="yes" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>">
                                                        <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
                                                        <?php if(!empty($subject))
                                                        {
                                                            foreach($subject as $sub){ 
                                                                if($sub['id'] == $sublst['subject_id']){
                                                                    $sel = 'selected';
                                                                }else{
                                                                    $sel = '';
                                                                }
                                                                echo '<option value="'.$sub['id'].'" '.$sel.'>'.$sub['subject_name'].'</option>';
                                                            }
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_chapters'));?><sup>*</sup></label>
                                                    <select class="edu_selectbox_with_search form-control require filter_chapter" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>" multiple>
                                                        <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
                                                        <?php
                                                           if(isset($sublst['chapter']) && !empty($sublst['chapter'])){
                                                               $chapterIdsString = implode(',', json_decode($sublst['chapter']));
                                                                $chapters = $this->db_model->my_query_for_chapter($chapterIdsString,$sublst['subject_id']);
                                                                //print_r($chapters);
                                                                //$chapters = $this->db_model->select_data('id,chapter_name','chapters use index (id)', array('subject_id'=>$sublst['subject_id']));
                                                            }else{
                                                                $chapters = '';
                                                            }
                                                            
                                                            
                                                            if(!empty($chapters)){
                                                                foreach($chapters as $chap){
                                                                    $chaperArr = json_decode($sublst['chapter'],true);
                                                                   
                                                                    if(in_array($chap['id'],$chaperArr)){
                                                                        $sel = 'selected';
                                                                    }else{
                                                                        $sel = '';
                                                                    }
                                                                    echo '<option value="'.$chap['id'].'" '.$sel.'>'.$chap['chapter_name'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_teacher'));?><sup>*</sup></label>
                                                    <select class="edu_selectbox_with_search form-control require filter_teacher" name="batch_teacher[]" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_teacher'));?>">
                                                        <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_teacher'));?></option>
                                                        <?php
                                                            if(isset($sublst['subject_id']) && !empty($sublst['subject_id'])){
                                                                $like = array('teach_subject','"'.$sublst['subject_id'].'"');
                                                                $teacher = $this->db_model->select_data('id,name','users use index (id)', '','','',$like);
                                                                
                                                            }else{
                                                                $teacher = '';
                                                            }

                                                            if(!empty($teacher)){
                                                                foreach($teacher as $teach){
                                                                    if(isset($sublst['teacher_id']) && ($sublst['teacher_id']==$teach['id'])){
                                                                        $sel = 'selected';
                                                                    }else{
                                                                        $sel = '';
                                                                    }
                    
                                                                    echo '<option value="'.$teach['id'].'" '.$sel.'>'.$teach['name'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?><sup>*</sup></label>
                                                    <input type="text" class="form-control chooseDate require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?>" name="sub_start_date[]" value="<?php echo (isset($sublst['sub_start_date']) && !empty($sublst['sub_start_date']))?date('d-m-Y',strtotime($sublst['sub_start_date'])):'';?>">	
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?><sup>*</sup></label>
                                                    <input type="text" class="form-control chooseDate require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?>" name="sub_end_date[]" value="<?php echo (isset($sublst['sub_end_date']) && !empty($sublst['sub_end_date']))?date('d-m-Y',strtotime($sublst['sub_end_date'])):'';?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?><sup>*</sup></label>
                                                    <div class="chooseTime">
                                                        <input type="text" class="form-control require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?>" name="sub_start_time[]" value="<?php echo (isset($sublst['sub_start_time']) && !empty($sublst['sub_start_time']))?date('h:i A',strtotime($sublst['sub_start_time'])):'';?>">
                                                    </div>	
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label><?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?><sup>*</sup></label>
                                                    <div class="chooseTime">
                                                        <input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?>" name="sub_end_time[]" value="<?php echo (isset($sublst['sub_end_time']) && !empty($sublst['sub_end_time']))?date('h:i A',strtotime($sublst['sub_end_time'])):'';?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                               <?php }
                            }else{ ?>
                            <div class="edu_accord_parent">
                                <span class="edu_accordion_header">
                                    <span class="subjects_name"><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?></span> 
                                    <i>
                                        <i class="fa fa-angle-right upDownI"></i>
                                        <i class="fa fa-trash removeAccSub eb_removeacc"></i>
                                    </i>
                                </span>
                                <div class="edu_accordion_content">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?><sup>*</sup></label>
                                                <select class="edu_selectbox_with_search form-control  filter_subject" id="batch_subject_f" name="batch_subject[]" data-teacher="yes" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>">
                                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
                                                    <?php if(!empty($subject))
                                                    {
                                                        foreach($subject as $sub){ 
                                                            echo '<option value="'.$sub['id'].'" >'.$sub['subject_name'].'</option>';
                                                        }
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_chapters'));?><sup>*</sup></label>
                                                <select class="edu_selectbox_with_search form-control  filter_chapter" id="batch_chapters_f" multiple data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>">
                                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_teacher'));?><sup>*</sup></label>
                                                <select class="edu_selectbox_with_search form-control filter_teacher" id="batch_teacher_f" name="batch_teacher[]" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_teacher'));?>">
                                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_teacher'));?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?><sup>*</sup></label>
                                                <input type="text" class="form-control chooseDate require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_date'));?>" name="sub_start_date[]">	
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?><sup>*</sup></label>
                                                <input type="text" class="form-control chooseDate require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_date'));?>" name="sub_end_date[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?><sup>*</sup></label>
                                                <div class="chooseTime">
                                                    <input type="text" class="form-control require"  placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_start_time'));?>" name="sub_start_time[]">
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label><?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?><sup>*</sup></label>
                                                <div class="chooseTime">
                                                    <input type="text" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_end_time'));?>" name="sub_end_time[]">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                     </div>
                </div>
                
                <div style="margin: 15px 0px 15px 0px;padding: 20px;">
                    <b><span class="subjects_name"><?php echo 'Export Batch';?></span></b>
                    
                    <?php if(count($batch_video_data) > 0 || count($batch_old_papper_data) > 0 || count($batch_book_data) > 0 || count($batch_note_data) > 0) { ?>
                        <input type="hidden" id="edit_export_batch_status" value="<?php echo $edit_export_batch_status; ?>">
                    <?php } ?>
              
                    <span id="export_batch_disable"><input type="button" class="export_batch_disable_changeprvButton btn btn-danger" style="border-radius:25px" value="Off" > </span>
                    <span id="export_batch_enable"><input type="button" class="export_batch_enable_changeprvButton btn btn-success" style="border-radius:25px" value="On" > </span>
                    
                    <input type="hidden" id="copy_export_batch" name="copy_export_batch">
                </div>
                
                <div style="border: 1px solid black;margin: 15px 0px 15px 0px;padding: 20px;" id="hide_export_batch">
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        
                        <div class="form-group">
                            <label><?php echo 'Copy Video';?><sup></sup></label>
                            
                            <select class="form-control edu_selectbox_with_search " id="previous_video" multiple name="previous_video[]" data-placeholder="<?php echo 'Video';?>">
                                <option value=""><?php echo 'Video';?></option>

                                <?php if(!empty($batch_video_data))
                                {
                                    foreach($batch_video_data as $batch){ 
                                        
                                        $selected_batch = '';
                                        
                                        foreach($selected_batch_video_data as $selected_batch_video_data_val){
                                            
                                            if($selected_batch_video_data_val['id'] == $batch['id'] ){
                                                $selected_batch = 'selected';
                                            }
                                            
                                        }
                                        
                                        echo '<option value="'.$batch['id'].'"' .$selected_batch.'>'.$batch['title'].' (Subject:- '.$batch['subject'].') '.' (Chapter:- '.$batch['topic'].')'.' (Batch:- '.$batch['batch_name'].')'.'</option>';
                                    }
                                }?>
                                
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label><?php echo 'Copy Old Papper';?><sup></sup></label>
                            <select class="form-control edu_selectbox_with_search " id="previous_older_papper" name="previous_older_papper[]" multiple data-placeholder="<?php echo 'Old Papper';?>">
                                <option value=""><?php echo 'Old Papper';?></option>
                                
                                <?php if(!empty($batch_old_papper_data))
                                {
                                    foreach($batch_old_papper_data as $batch){ 
                                        
                                        $selected_batch = '';
                                        
                                        foreach($selected_batch_old_papper_data as $selected_batch_old_papper_data_val){
                                            
                                            if($selected_batch_old_papper_data_val['id'] == $batch['id'] ){
                                                $selected_batch = 'selected';
                                            }
                                            
                                        }

                                        echo '<option value="'.$batch['id'].'"' .$selected_batch.'>'.$batch['title'].' (Subject:- '.$batch['subject_name'].') '.' (Chapter:- '.$batch['chapter_name'].')'.' (Batch:- '.$batch['batch_name'].')'.'</option>';
                                    }
                                }?>
                                
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><?php echo 'Copy Book';?><sup></sup></label>
                            <select class="form-control edu_selectbox_with_search  " id="previous_book" multiple name="previous_book[]" data-placeholder="<?php echo 'Book';?>">
                                <option value=""><?php echo 'Book';?></option>
                                
                                <?php if(!empty($batch_book_data))
                                {
                                    foreach($batch_book_data as $batch){ 
                                        
                                        $selected_batch = '';
                                        
                                        foreach($selected_batch_book_data as $selected_batch_book_data_val){
                                            
                                            if($selected_batch_book_data_val['id'] == $batch['id'] ){
                                                $selected_batch = 'selected';
                                            }
                                            
                                        }

                                        echo '<option value="'.$batch['id'].'"' .$selected_batch.'>'.$batch['title'].' (Subject:- '.$batch['subject_name'].') '.' (Chapter:- '.$batch['chapter_name'].')'.' (Batch:- '.$batch['batch_name'].')'.'</option>';
                                    }
                                }?>
                                
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><?php echo 'Copy Notes';?><sup></sup></label>
                            <select class="form-control edu_selectbox_with_search " id="previous_notes" name="previous_notes[]" multiple data-placeholder="<?php echo 'Notes';?>">
                                <option value=""><?php echo 'Notes';?></option>
                                
                                <?php if(!empty($batch_note_data))
                                {
                                    foreach($batch_note_data as $batch){ 
                                        
                                        $selected_batch = '';
                                        
                                        foreach($selected_batch_note_data as $selected_batch_note_data_val){
                                            
                                            if($selected_batch_note_data_val['id'] == $batch['id'] ){
                                                $selected_batch = 'selected';
                                            }
                                            
                                        }

                                        echo '<option value="'.$batch['id'].'"' .$selected_batch.'>'.$batch['title'].' (Subject:- '.$batch['subject_name'].') '.' (Chapter:- '.$batch['chapter_name'].')'.' (Batch:- '.$batch['batch_name'].')'.'</option>';
                                    }
                                }?>
                                
                            </select>
                        </div>
                            
                    </div>
                </div>
                                    
                                    
                <div class="row">
                    <?php if(!empty($batch_id)){
                        echo '<input type="hidden" name="batch_id" id="batch_id" value="'.$batch_id.'">';
                        $type = 'edit';
                    }else{
                        $type = 'add';
                    }?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_btn_wrapper">
                            <div class='hide subjectArrayDiv'><?php echo json_encode($subject);?></div>
                            <button type="button" class="edu_admin_btn AssignBatchHeading">+ <?php echo html_escape($this->common->languageTranslator('ltr_assign_benefit'));?></button>
							<button type="button" class="edu_admin_btn AssignSubBatch">+ <?php echo html_escape($this->common->languageTranslator('ltr_assign_subject'));?></button>
                            <button type="button" class="edu_admin_btn addEditBatch" data-type="<?php echo $type;?>"><?php echo !empty($batch_data)? html_escape($this->common->languageTranslator('ltr_update_batch')): html_escape($this->common->languageTranslator('ltr_save_batch'));?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>