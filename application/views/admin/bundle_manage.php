
<section class="edu_admin_content"> 
	<div class="edu_admin_right sectionHolder edu_video_manager">
        <?php $role = $this->session->userdata('role');
              $super_admin = $this->session->userdata('super_admin');?>				
	    <div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
	     
                        <?php echo ($role != 'student')?'<a href="#addFolderPop" class="edu_admin_btn openPopupLink"><i class="icofont-plus"></i>Add Bundle</a>':''; ?>
                        
	    </div>
	     
        <?php if(!empty($bundle_data) && $role == 'student'){ ?>
        <div class="edu_table_wrapper mb_30">
			<div class="edu_admin_informationdiv sectionHolder">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<span>
                                <select class="form-control filter_subject edu_selectbox_with_search" name="filter_subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>" data-count="no">
                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
                                    <?php
                                    if(!empty($subject)){
                                        foreach($subject as $sub){
                                            echo '<option value="'.$sub['subject_name'].'">'.$sub['subject_name'].'</option>';
                                        }
                                    }
                                    ?> 
                                </select>
							</span>
						</div>
					</div>
                    
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<span>
								<div class="pxn_admin_btnsection">
									<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search'));?>" class="btn btn-primary searchBook"/>
								</div>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
        <?php } ?>
        <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<?php if($role != 'student'){?>
                    <button class="multiDelete btn_delete btn btn-primary"  data-placement="top" title="<?php echo html_escape($this->common->languageTranslator('ltr_delete'));?>" data-table="book_pdf" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
                    <?php }?>
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		 

	    <div class="edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/bundle_batch_manage_table">
                        <thead>
                            <tr>
                                <?php echo ($role != 'student')?'<th><input type="checkbox" class="checkAllAttendance"></th>':''; ?>
                                <th>#</th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_title'));?></th>
                                <th><?php echo 'Batch';?></th>
                                <th><?php echo 'Price';?></th>
                                <th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_status'));?></th>
                                <!--<th><?php echo html_escape($this->common->languageTranslator('ltr_actions'));?></th>-->
                            </tr>
                        </thead>
    			        <tbody>
    			        </tbody>
    		        </table> 
		        </div>
			</div> 
		</div>

	</div>
</section>

<!--view Add folder Pop Up Start  -->
<div id="addFolderPop" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1">Add Bundle</h4>
            <form method="post" class="pxn_amin form" enctype="multipart/form-data"> 
            <input type="hidden" name="id" id="bundle_batch_id">
         
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Title<sup>*</sup></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" />

                        </div>
                    </div>
                    
                    
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_batch'));?><sup>*<sup></label>
                            <select id="batch_reset" class="form-control require edu_selectbox_with_search get_teacher_subject" name="batch_id[]" multiple data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?>" >
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?></option>
                                <?php if(!empty($batch))
                                {
                                    foreach($batch as $bat){ 
                                        echo '<option value="'.$bat['id'].'" >'.$bat['batch_name'].'</option>';
                                    }
                                }?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Price<sup>*</sup></label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" />

                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Discount Price<sup>*</sup></label>
                            <input type="text" name="discount_price" id="discount_price" class="form-control" placeholder="Enter Discount Price" />

                        </div>
                    </div>
                    
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>File<sup>*</sup></label>
                             <input type="file" class="form-control" id="image" name="image" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_video_msg'));?>" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_file'));?>" data-symb="no">
                            	<p class="fileNameShow"></p>

                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group eb_batchtype">
                            <label><?php echo "Duration Type";?><sup>*</sup></label>
                            <div class="form-control">
                                <label class="font-weight-bold"><?php echo "Set Validity";?></label>
                                <input type="radio"  class="durationType setvalid" name="durationType" value="1">
                            </div>
                            <div class="form-control">
                                <br><label class="font-weight-bold"><?php echo "Set Expiry";?></label><br/>
                                <input type="radio" class="durationType setexp"  name="durationType" value="2">
                            </div>
                            <div class="form-control">
                                <label  class="font-weight-bold"><?php echo "Lifetime Validity";?></label>
                                <input type="radio" class="durationType setlifetime"  name="durationType" value="3">
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 hide_total_valid">
                            <div class="form-group">
                                <label><?php echo 'Enter Validity';?><sup>*</sup></label>
                                <input type="text" class="form-control"  placeholder="Enter Validity" name="total_validity"  id="total_validity" value="">          
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-12 col-sm-12 col-12 hide_valid_type">
                            <div class="form-group">
                                <label>Validity In <sup>*</sup></label>                             
                                <select class="form-control edu_selectbox_with_search category_dropdown" id="validity_type" name="validity_in" data-placeholder="Select Validity">
                                    <option value="">Select</option>
                                    <option value="years">Year(s)</option>
                                    <option value="months">Month(s)</option>
                                    <option value="days">Day(s)</option>
                                </select>                               
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 hide_expiry_date">
                        <div class="form-group">
                            <label><?php echo 'Set Expiry Date';?><sup>*</sup></label>
                            
                                <input type="text" class="form-control chooseDate"  name="batch_expiry"  id="set_expiry" value="">
                            
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="edu_btn_wrapper">
                            <input type="button" name="addBundle" value="ADD" class="edu_admin_btn addBundleBatch" data-id="" />
                        </div>
                    </div>
                </div>
                
            
            </form>
        </div>
    </div>
</div>
<!-- view Add folder Pop Up Start  -->