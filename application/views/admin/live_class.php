<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_batch_manager">
	    <?php 
	        ?>
	        <div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
	           <a href="#input_feilds_zoho" class="edu_admin_btn openPopupLink"><i class="icofont-plus"></i>Add Zoho Meeting</a>
    	        <a href="#input_feilds_android" class="edu_admin_btn openPopupLink"><i class="icofont-plus"></i>Add Youtube Live</a>
    		   <a href="#input_feilds_liveclass" class="edu_admin_btn openPopupLink addLiveclass"><i class="icofont-plus"></i><?php echo html_escape($this->common->languageTranslator('ltr_add_live_class')); ?></a>
    		</div>
	        <?php 
	    ?>
		<?php 

			if(!empty($live_data) && $live_data>=1){
			?>
		<div class="edu_main_wrapper edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
				<div class="tableFullWrapper">
    				<table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/live_class_setting_table">
    					<thead>
    						<tr>
    							<th>#</th>
    							<th><?php echo html_escape($this->common->languageTranslator('ltr_batch_name')); ?></th>
    							<th>Type</th>
    							<th>Client Id(S2S)</th>
    							<th>Client Secret(S2S)</th>
    							<th>Account Id(S2S)</th>
    							<th>Client Id(General)</th>
    							<th>Client Secret(General)</th>
    							<th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_action')); ?></th>
    							<th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_added_by')); ?></th>
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
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_live_no_data')).'</div>
                            </div>
                        </div>
                    </section>';
		} ?>
	</div>
</section>

<!-- Pop Up Start  -->
<div id="input_feilds_liveclass" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="classModalLabel"><?php echo html_escape($this->common->languageTranslator('ltr_add_live_class')); ?></h4>
            <form method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_batch')); ?><sup>*</sup></label>
							<select class="form-control require edu_selectbox_with_search" name="batch" id="batch">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
                                            <?php if(!empty($batch)){
                                                foreach($batch as $batchValue){
                                                    echo '<option value="'.$batchValue['id'].'">'.$batchValue['batch_name'].'</option>';    
                                                }
                                            } ?>
							</select>
						</div>
    				</div>
    				<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Account ID(Server 2 Server)<sup>*</sup></label>
							<input type="text" class="form-control require" name="s2s_zoom_account_id" id="s2s_zoom_account_id" placeholder="Account ID(S2S)">
						</div>
    				</div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Client ID(Server 2 Server)<sup>*</sup></label>
							<input type="text" class="form-control require" name="s2s_zoom_client_id" id="s2s_zoom_client_id" placeholder="Zoom Client ID(S2S)">
						</div>
    				</div>
    				<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Client Secret(Server 2 Server)<sup>*</sup></label>
							<input type="text" class="form-control require" name="s2s_client_secret" id="s2s_client_secret" placeholder="Zoom Client Secret(S2S)">
						</div>
    				</div>
    				
    				
    				<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Client ID (General)<sup>*</sup></label>
							<input type="text" class="form-control require" name="general_client_id" id="general_client_id" placeholder="Zoom Client ID(Genral)">
						</div>
    				</div>
    				<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Client Secret (General)<sup>*</sup></label>
							<input type="text" class="form-control require" name="general_client_secret" id="general_client_secret" placeholder="Zoom Client Secret(General)">
						</div>
    				</div>
    				
    				
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
    					    <input type="hidden" name="live_class_id" id="live_class_id" value="">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_save')); ?>" class="edu_admin_btn addLiveClassSetting" data-type="add" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>




<!-- Pop Up Start  -->
<div id="input_feilds_android" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="classModalLabel">Add Youtube Live Link</h4>
            <form method="post">
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_batch')); ?><sup>*</sup></label>
							<select class="form-control  form-control require edu_selectbox_with_search video_batch" name="batch_id" id="batch_id">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
                                            <?php
                                            if(!empty($batch)){
                                                foreach($batch as $batchName){
                                                     echo '<option value="'.$batchName['id'].'">'.$batchName['batch_name'].'</option>';    
                                                }
                                            } ?>
							</select>
						</div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_subject" name="subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>" data-count="no">
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
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_chapter'));?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_chapter" name="topic" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
                            </select>
                        </div>
    				</div>
    				
    				
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Youtube Live Link<sup>*</sup></label>
							<input type="text" class="form-control require" name="meeting_link" id="meeting_link" placeholder="Youtube Live Link" />
						</div>
    				</div>
    				
				 
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
    					    
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_save')); ?>" class="edu_admin_btn addLiveClassYoutube" data-type="add" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>



<!-- Pop Up Start  -->
<div id="input_feilds_zoho" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="classModalLabel">Add Zoho Meeting</h4>
            <form method="post">
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label><?php echo html_escape($this->common->languageTranslator('ltr_batch')); ?><sup>*</sup></label>
							<select class="form-control  form-control require edu_selectbox_with_search video_batch" name="batch_id" id="batch_id">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
                                            <?php
                                            if(!empty($batch)){
                                                foreach($batch as $batchName){
                                                     echo '<option value="'.$batchName['id'].'">'.$batchName['batch_name'].'</option>';    
                                                }
                                            } ?>
							</select>
						</div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_subject" name="subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>" data-count="no">
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
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_chapter'));?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_chapter" name="topic" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?>">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter'));?></option>
                            </select>
                        </div>
    				</div>
    				
    				
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    					<div class="form-group">
							<label>Zoho Meetine Link<sup>*</sup></label>
							<input type="text" class="form-control require" name="meeting_link" id="meeting_link" placeholder="Zoho Meeting Link" />
						</div>
    				</div>
    				
				 
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
    					    
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_save')); ?>" class="edu_admin_btn addLiveClassZoho" data-type="add" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>


<!-- Pop Up Start  -->
<div id="classSettingModal" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" ><?php echo html_escape($this->common->languageTranslator('ltr_live_class')); ?></h4>
            <form method="post" action="<?php echo base_url('admin/start-class');?>" id="classForm" autocomplete="off" >
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_subject')); ?><sup>*</sup></label>
							<select class="form-control filter_subject edu_selectbox_with_search require " name="subject_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>" id="filter_subject">
										<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subjects')); ?></option>
										 
									</select>	
    					</div>
    				</div>
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
    						<label><?php echo html_escape($this->common->languageTranslator('ltr_chapter')); ?><sup>*</sup></label>
							<select  class="form-control filter_chapter edu_selectbox_with_search require " name="chapter_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?>"> 
										<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?></option>
									</select>
    					</div>
    				</div>
    				
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="hidden" name="live_class_id" id="live_class_id" value="">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_continue')); ?>" class="edu_admin_btn liveClassSetting"  />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>