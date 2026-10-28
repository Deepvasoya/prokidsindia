<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_gallery_manager">
	    <div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
	      
                        <a href="#add_image_video" class="edu_admin_btn openPopupLink addGalleryPop"><i class="icofont-plus"></i>Add Banner</a>
        </div>
	    
	    <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<button class="multiDelete btn_delete btn btn-primary"  data-placement="top" title="Delete" data-table="gallery" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		<?php 
    		if(!empty($gallery)){
    		?> 
	    <div class="edu_main_wrapper edu_table_wrapper">
		    <div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/home_banners_table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkAllAttendance"></th>
                                <th>#</th>
                                <th>Type</th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_status'));?></th>
                                <th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_action'));?></th>
                                <th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_added_by'));?></th>
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
                                <div class="eac_text eac_page_re">You have not added any Banner yet, feel free to add Banner by clicking on "Add Banner" button.</div>
                            </div>
                        </div>
                    </section>';
			} ?>
	</div>
</section>

<!-- Pop Up Start  -->
<div id="add_image_video" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel11">Add Banner</h4>
            <form class="pxn_amin form" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" id="gallery_id">
		    	<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12 galleryImgFld">
						<div class="form-group">
							<label>Banner<sup>*</sup></label>
							<input type="file" class="form-control Image require" accepts="image/*" name="image" data-valid="image" data-error="Please select jpg/png image.">
							<p class="fileNameShow"></p>
						</div>
					</div>
					
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <label><?php echo 'Click Action';?><sup>*<sup></label><br>
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" checked type="radio" name="click_action" value="url_type" id="url_type">
                          <label class="form-check-label" for="inlineRadio1"><?php echo 'URL';?></label>
                        </div>
                        
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" type="radio" name="click_action" value="batch_type" id="batch_type">
                          <label class="form-check-label" for="inlineRadio2"><?php echo 'Select Batch';?></label>
                        </div>
                        
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" type="radio" name="click_action" value="none_type" id="none_type">
                          <label class="form-check-label" for="inlineRadio1"><?php echo 'None';?></label>
                        </div>
                        
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" id="hide_url">
    						<div class="form-group">
    							<label><?php echo 'URL';?> <sup>*</sup></label>								
    							<input type="text" class="form-control" name="url" id="url_home_banner">						
    						</div>	
    					</div>
    					
    					
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" id="hide_batch">
    						<div class="form-group">
    							<label><?php echo 'Batch';?> <sup>*</sup></label>								
    							<select class="form-control edu_selectbox_with_search" name="batch" id="batch_home_banner" data-placeholder="<?php echo 'Batch';?>">
    								<option value=""><?php echo 'Select Batch';?></option>
    								<?php 
    								foreach($batche_data as $cat){
    								    
    									echo '<option value="'.$cat['id'].'">'.$cat['batch_name'].'</option>';
    								}?>
    							</select>								
    						</div>	
    					</div>
    					
                       
                    </div>
                    
                
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addhomebanner" /> 
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
<!-- view Pop Up Start  -->
<div id="view_video_popup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="viewVideoTopic">View Banner</h4>
            <div class="row videoIframeShow">
            </div>
        </div>
    </div>
</div>
<!-- view image start-->
<div id="view_image_popup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel11">View Banner</h4>
             <form class="pxn_amin form" method="post">
               <img src="" alt="">
             </form>
        </div>
    </div>
</div>
<!-- view image end-->