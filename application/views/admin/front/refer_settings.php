

<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_siteSetting_wrapper">
	    
			<div class="pxn_admin_informationdiv edu_main_wrapper">
				<form class="pxn_amin form" enctype="multipart/form-data" method="post">
					<div class="edu_site_setting_wrap edu_from_wrapper">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							    <div class="form-group">
    							    <label><?php echo html_escape($this->common->languageTranslator('ltr_refer_type'));?><sup>*</sup></label>
    							    <br>
										<input type="radio" <?php if($refer_type==1){echo 'checked';} if($refer_type!=1 && $refer_type!=2){echo 'checked';} ?> name="refer_type" value="1"><span><?php echo html_escape($this->common->languageTranslator('ltr_amount'));?></span>
										
										<input type="radio" <?php if($refer_type==2){echo 'checked';} ?> name="refer_type" value="2"><span><?php echo html_escape($this->common->languageTranslator('ltr_percentage'));?></span>
        							
							    </div>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							    <div class="form-group">
									<label><?php echo html_escape($this->common->languageTranslator('ltr_refer_type'));?><sup>*</sup></label>
									<input type="number" class="form-control require ?>" name="refer_type_amount" value="<?php if(!empty($refer_type_amount)){echo $refer_type_amount;} ?>" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_refer_type'));?>">
								</div>
							</div>
							
							<div class="edu_btn_wrapper">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12"> 
									<button type="button" class="btn btn-primary updateReferDetails"><?php echo html_escape($this->common->languageTranslator('ltr_save'));?></button>
									
									<!--<button type="button" class="btn btn-primary updateTestEmailDetails"><?php echo html_escape($this->common->languageTranslator('ltr_test_email'));?></button>-->
									
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>		
	</div>
</section>