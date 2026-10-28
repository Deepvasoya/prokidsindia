
text/x-generic batch_cat_manage.php ( HTML document, ASCII text )
<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
           <a href="#categoryPopup" class="edu_admin_btn openPopupLink addcatPop"><i class="icofont-plus"></i>Add Batch Activation Code</a>
	    </div>
	    <?php if($_SESSION['super_admin'] == '1'){ ?>
        <div class="edu_table_wrapper mb_30">
            <div class="edu_admin_informationdiv sectionHolder">
               
            </div>
        </div>
        <?php } ?>
	       <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<button class="multiDelete btn_delete btn btn-primary"  data-table="batch_category" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		<?php 
			if(!empty($all_notification)){ 
			?>
	    <div class="edu_main_wrapper edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/batchactivation_table">
                        <thead>
                            <tr>  
                                <th>#</th>
                                <th>Batch</th>
                                <th>Number of Codes</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> 
                </div>
			</div>
		</div>
		<?php 
			}else{ 
			echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">No Batch Activation Data</div>
                            </div>
                        </div>
                    </section>';
			} ?>
	    
	    
					</div>
			</section>
			            
			
<!-- Add Category Pop Up Start  -->
<div id="categoryPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1">Add Batch Activation Code</h4>
            <form method="post" class="pxn_amin form" action="javascript:void(0)" autocomplete="off"> 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Title<sup>*</sup></label>
                            <select class="form-control filter_subject modalSubjectCls require edu_selectbox_with_search" id="batch_id" name="batch_id" data-placeholder="Select Batch"> 
								<option value="">Select Batch</option>
								<?php
									if(!empty($batch)){
										foreach($batch as $sub){
											echo '<option value="'.$sub['id'].'">'.$sub['batch_name'].'</option>';
										}
									}
								?> 
							</select>
                        </div>
    				</div>
    				
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Number of Coupon<sup>*</sup></label>
                            <input type="text" name="number_coupon" id="number_coupon" class="form-control" placeholder="Number of Coupon" />
                        </div>
    				</div>
    				
                    
                    
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="addbatchactivation" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addbatchactivation" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>


<div id="batchEditPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1">Update Batch Activation Code</h4>
            <form method="post" class="pxn_amin form" action="javascript:void(0)" autocomplete="off"> 
                <input type="hidden" name="batch_activation_id" id="batch_activation_id" />

                <div class="row">
                   	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Number of Coupon<sup>*</sup></label>
                            <input type="text" name="edit_number_coupon" id="edit_number_coupon" class="form-control" placeholder="Number of Coupon" />
                        </div>
    				</div>
    				
                    
                    
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="updatebatchactivation" value="<?php echo html_escape($this->common->languageTranslator('ltr_update'));?>" class="edu_admin_btn updatebatchactivation" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>


