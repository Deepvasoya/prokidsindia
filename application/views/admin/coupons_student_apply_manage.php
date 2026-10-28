<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<!--<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">-->
  <!--         <a href="#subcategoryPopup" class="edu_admin_btn openPopupLink addsubcatPop"><i class="icofont-plus"></i><?php echo 'Add Coupon';?></a>-->
	 <!--   </div>-->
	   
	       <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        					<button class="multiDelete btn_delete btn btn-primary" data-placement="top" title="Delete" data-table="coupons" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
                		</div>
					</div>
        		</div>
    		</div>
		</div>
		

		<div class="edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/student_coupon_apply_table">
                        <thead>
                            <tr>
                                <?php //echo ($role != 'student')?'<th><input type="checkbox" class="checkAllAttendance"></th>':''; ?>
                                <th>#</th>
                                <th><?php echo 'Student Name';?></th>
                                <th><?php echo 'Coupon Code';?></th>
                                
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
			            
			
<!-- Add SubCategory Pop Up Start  -->
<div id="subcategoryPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1"><?php echo 'Add Coupon';?></h4>
            <form method="post" class="pxn_amin form" action="javascript:void(0)" autocomplete="off"> 
                <div class="row">

					<div class="col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label><?php echo 'Discount Type';?> <sup>*</sup></label>								
							<select class="form-control require edu_selectbox_with_search" name="discount_type" data-placeholder="<?php echo 'Discount Type';?>">
								<option value=""><?php echo 'Select Discount Type';?></option>
								<option value="discount"><?php echo 'Discount Percentage';?></option>
								<option value="flat"><?php echo 'Flat Price Discount';?></option>
								 
							</select>								
						</div>	
					</div>
					
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Discount Percentage (%)';?><sup>*</sup></label>
                            <input type="text" name="discount_percentage" id="discount_percentage" class="form-control" placeholder="<?php echo 'Discount Percentage';?>" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Coupon Code';?><sup>*</sup></label>
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="<?php echo 'Coupon Code';?>" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Start Date';?><sup>*</sup></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="<?php echo 'Start Date';?>" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Expiry Date';?><sup>*</sup></label>
                            <input type="date" name="expiry_date" id="expiry_date" class="form-control" placeholder="<?php echo 'Expiry Date';?>" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Max Discount Upto (use -1 for no limit)';?><sup>*</sup></label>
                            <input type="text" name="max_discount_upto" id="max_discount_upto" class="form-control" placeholder="<?php echo 'Max Discount Up To';?>" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label><?php echo 'Batch';?> <sup>*</sup></label>								
							<select class="form-control require edu_selectbox_with_search" name="batch[]" multiple data-placeholder="<?php echo 'Batch';?>">
								<option value=""><?php echo 'Select Batch';?></option>
								<?php foreach($batche_data as $cat){
									echo '<option value="'.$cat['id'].'">'.$cat['batch_name'].'</option>';
								}?>
							</select>								
						</div>	
					</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo 'Max Count';?><sup>*</sup></label>
                            <input type="text" name="max_count" id="max_count" class="form-control" placeholder="<?php echo 'Max Count';?>" />
                        </div>
    				</div>
    				
    				
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="addcoupon" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addCoupon" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>

<!-- Edit SubCategory Pop Up Start  -->

<div id="subcategoryEditPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1"><?php echo html_escape($this->common->languageTranslator('ltr_edit_subcategory'));?></h4>
            <form method="post" class="pxn_amin form" action="" autocomplete="off"> 
                <div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_category'));?> <sup>*</sup></label>								
							<select class="form-control require edu_selectbox_with_search" id="categoryData" name="category" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_category'));?>">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_category'));?></option>
								<?php foreach($category_data as $cat){
									echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
								}?>
							</select>								
						</div>	
					</div>
                    	
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_subCategory_name'));?><sup>*</sup></label>
                            <input type="text" name="subcategory" id="subcategoryEditName" class="form-control" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_subCategory_name'));?>" />
                        </div>
    				</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_update'));?>" class="edu_admin_btn editCoupon"/>
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>