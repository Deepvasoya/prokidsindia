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
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/device_manage_table">
                        <thead>
                            <tr>
                                <?php echo ($role != 'student')?'<th><input type="checkbox" class="checkAllAttendance"></th>':''; ?>
                                <th>#</th>
                                <th><?php echo 'Student Name';?></th>
                                <th><?php echo 'Enrollment Id';?></th>
                                <th><?php echo 'Device Name';?></th>
                                <th><?php echo 'Device Version';?></th>
                                <th><?php echo 'Time';?></th>
                                <th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_actions'));?></th>
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
			            

