
text/x-generic batch_cat_manage.php ( HTML document, ASCII text )
<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
           <a href="#categoryPopup" class="edu_admin_btn openPopupLink addcatPop"><i class="icofont-plus"></i>Add Notification</a>
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
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/notification_table">
                        <thead>
                            <tr>  
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
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
                                <div class="eac_text eac_page_re">No Notification Data</div>
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
            <h4 class="edu_sub_title" id="myModalLabel1">Add Notification</h4>
            <form method="post" class="pxn_amin form" action="javascript:void(0)" autocomplete="off"> 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Title<sup>*</sup></label>
                            <input type="text" name="titleName" id="titleName" class="form-control" placeholder="Title" />
                        </div>
    				</div>
    				
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Description<sup>*</sup></label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Description" />
                        </div>
    				</div>
    				
    					<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_file'));?><sup>*</sup></label>
							<input type="file" class="form-control Image require" accepts="image/*" name="image" data-valid="image" data-error="Please select jpg/png image.">
                            <p class="fileNameShow"></p>
                        </div>
                    </div>
                    
                    
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="addnotification" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addnotification" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>

