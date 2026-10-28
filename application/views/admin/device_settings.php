<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<!--<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">-->
  <!--         <a href="#subcategoryPopup" class="edu_admin_btn openPopupLink addsubcatPop"><i class="icofont-plus"></i><?php echo 'Add Coupon';?></a>-->
	 <!--   </div>-->
	 
	 
	 
        	<form action="device-settings-save" method="post" class="pxn_amin form" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" id="gallery_id">
            	<div class="row">
        			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <label><?php echo 'Device Setting';?><sup>*<sup></label><br>
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($deviceSetting == '1'){ echo 'checked'; } ?> type="radio" name="device_setting" value="1">
                          <label class="form-check-label" for="inlineRadio1"><?php echo 'Last Login';?></label>
                        </div>
                        
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($deviceSetting =='2'){ echo 'checked'; } ?> type="radio" name="device_setting" value="2">
                          <label class="form-check-label" for="inlineRadio2"><?php echo 'Single Device Login';?></label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($deviceSetting =='3'){ echo 'checked'; } ?> type="radio" name="device_setting" value="3">
                          <label class="form-check-label" for="inlineRadio2"><?php echo 'Multi Login';?></label>
                        </div>
                       
                    </div>

        			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
        				<input type="submit" value="Save" class="edu_admin_btn" /> 
        			</div>
        		</div>
        	</form>
			
		
		</div>
		
		<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<!--<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">-->
  <!--         <a href="#subcategoryPopup" class="edu_admin_btn openPopupLink addsubcatPop"><i class="icofont-plus"></i><?php echo 'Add Coupon';?></a>-->
	 <!--   </div>-->
	 
	 
	 
        	<form action="web_device-settings-save" method="post" class="pxn_amin form" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" id="gallery_id">
            	<div class="row">
        			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <label><?php echo 'Web Device Setting';?><sup>*<sup></label><br>
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($webdeviceSetting == '1'){ echo 'checked'; } ?> type="radio" name="web_device_setting" value="1">
                          <label class="form-check-label" for="inlineRadio1"><?php echo 'Last Login';?></label>
                        </div>
                        
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($webdeviceSetting =='2'){ echo 'checked'; } ?> type="radio" name="web_device_setting" value="2">
                          <label class="form-check-label" for="inlineRadio2"><?php echo 'Single Device Login';?></label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" <?php if($webdeviceSetting =='3'){ echo 'checked'; } ?> type="radio" name="web_device_setting" value="3">
                          <label class="form-check-label" for="inlineRadio2"><?php echo 'Multi Login';?></label>
                        </div>
                       
                    </div>

        			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
        				<input type="submit" value="Save" class="edu_admin_btn" /> 
        			</div>
        		</div>
        	</form>
			
		
		</div>
	</section>
			            

