<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_student_manager">
	    
	    <!-- Loader (Initially Hidden) -->
<!-- Progress Bar (Initially Hidden) -->
<div id="exportProgressContainer" style="display:none; position: fixed; top: 50%; left: 50%; width: 350px; padding: 10px; background: rgba(0,0,0,0.8); color: white; border-radius: 5px; text-align: center; z-index: 9999;">
    <span>Exporting: <span id="exportProgressPercent">0</span>%</span>
    <div style="width: 100%; background: #ddd; border-radius: 5px; margin-top: 5px;">
        <div id="exportProgressBar" style="width: 0%; height: 10px; background: #4CAF50; border-radius: 5px;"></div>
    </div>
    <button id="downloadCSV" style="margin-top: 10px; display: none; background: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px;">Download CSV</button>
</div>







	    <?php $sm_has_students = !empty($student_data); ?>
	    <div class="sm-toolbar">
	        <form method="post" action="" autocomplete="off" class="sm-card sm-filters">
	            <div class="sm-card-head">
	                <h4>&#128269; Find students</h4>
	                <div class="sm-actions">
	                    <a href="<?php echo base_url('admin/add-student');?>" class="edu_admin_btn sm-btn"><i class="icofont-plus"></i><?php echo html_escape($this->common->languageTranslator('ltr_add_student'));?></a>
	                    <button type="button" id="exportCSVButton" class="btn btn-danger sm-btn">&#11015; Export All</button>
	                    <a href="student-exports" class="btn sm-btn sm-btn-ghost" title="Download the sample file for bulk upload">&#128196; Sample file</a>
	                </div>
	            </div>
	            <?php if ($sm_has_students) { ?>
	            <div class="sm-filter-row edu_manage_studer_filter">
	                <div class="sm-field">
	                    <label for="lgStatus">Login status</label>
	                    <select class="form-control edu_selectbox_without_search" id="lgStatus" name="lgStatus">
	                        <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_none'));?></option>
	                        <option value="1"><?php echo html_escape($this->common->languageTranslator('ltr_login'));?></option>
	                        <option value="0"><?php echo html_escape($this->common->languageTranslator('ltr_logout'));?></option>
	                    </select>
	                </div>
	                <div class="sm-field">
	                    <label for="user_status">Status</label>
	                    <select class="form-control edu_selectbox_without_search" id="user_status" name="user_status">
	                        <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_all'));?></option>
	                        <option value="1"><?php echo html_escape($this->common->languageTranslator('ltr_active'));?></option>
	                        <option value="0"><?php echo html_escape($this->common->languageTranslator('ltr_inactive'));?></option>
	                    </select>
	                </div>
	                <div class="sm-field sm-field-wide">
	                    <label for="user_batch">Batch</label>
	                    <select class="form-control edu_selectbox_without_search" id="user_batch" name="user_batch[]" multiple="multiple" data-placeholder="Select Batch">
	                        <?php if(!empty($batch_name)){
	                            foreach($batch_name as $batch){
	                                echo '<option value="'.$batch['id'].'">'.$batch['batch_name'].'</option>';
	                            }
	                        } ?>
	                    </select>
	                </div>
	                <div class="sm-field sm-field-btn">
	                    <input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search'));?>" class="btn btn-primary find_student">
	                </div>
	            </div>
	            <?php } ?>
	        </form>

	        <form method="post" action="student-bulk-upload" class="sm-card sm-upload pxn_amin form" enctype="multipart/form-data" autocomplete="off">
	            <div class="sm-upload-icon">&#128228;</div>
	            <div class="sm-upload-body">
	                <h4>Bulk upload students</h4>
	                <p>Upload a filled-in copy of the <a href="student-exports">sample file</a>.</p>
	            </div>
	            <div class="sm-upload-input">
	                <input type="file" name="file" id="smBulkFile" accept=".csv,.xls,.xlsx" required>
	                <div class="sm-file-preview" id="smBulkPreview" hidden>
	                    <span class="sm-file-icon" data-sm-icon>&#128196;</span>
	                    <span class="sm-file-info"><strong data-sm-name></strong><small data-sm-meta></small></span>
	                    <button type="button" class="sm-file-clear" data-sm-clear title="Remove file" aria-label="Remove file">&times;</button>
	                </div>
	            </div>
	            <input type="submit" name="submit" value="Bulk Upload" class="btn btn-primary sm-btn">
	        </form>
	    </div>

		<div class="createDivWrapper edu_add_question create_ppr_popup stdn_mng hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner student_mng_m">
        			<div class="footer_popup_inner">
        			    
						 <?php if($this->session->userdata('role')==1){ ?>
						 <div class="fp_btn_wrpa">
        			        <button class="btn btn-primary add_attendance "><?php echo html_escape($this->common->languageTranslator('ltr_add_regular_attendance'));?></button>
						 </div>
						 <div class="fp_btn_wrpa">
        			        <button class="btn btn-primary add_attendance_extra "><?php echo html_escape($this->common->languageTranslator('ltr_add_extra_class_attendance'));?></button>
						 </div>
						 <div class="fp_btn_wrpa">
						     <button class="multiDelete btn_delete btn btn-primary " data-table="students" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
						 </div> 
						
                        <?php }else{ ?>
                        <div class="fp_btn_wrpa">
        			        <button class="btn btn-primary add_attendance "><?php echo html_escape($this->common->languageTranslator('ltr_add_regular_attendance'));?></button>
						 </div>
						 <div class="fp_btn_wrpa">
        			        <button class="btn btn-primary add_attendance_extra "><?php echo html_escape($this->common->languageTranslator('ltr_add_extra_class_attendance'));?></button>
						 </div>
                        <?php }?>
                    
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		<?php 
			if($this->session->userdata('admin_id') == 1 || $this->session->userdata('super_admin') == 1 || $this->session->userdata('role') == 3){
			?>
		<div class="edu_main_wrapper edu_table_wrapper  studenedu_table_wrapper sectionHolder ">
			<div class="edu_admin_informationdiv dropdown_height">
                <div class="tableFullWrapper">
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" id="studentManager"  cellspacing="0" width="100%" data-url="ajaxcall/student_table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkAllAttendance"></th>
                                <th>#</th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_name'));?></th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_email'));?></th>
                                <th>State</th>
                               <th>City</th>

                                <th><?php echo html_escape($this->common->languageTranslator('ltr_contact_number'));?></th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_enrolment_id'));?></th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_batch'));?></th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_admission_date'));?></th>
                                <?php if($this->session->userdata('role') == 1){  echo '<th class="no-sort">'.html_escape($this->common->languageTranslator('ltr_status')).'</th>'; } ?>
                                <th class="no-sort"><?php echo html_escape($this->common->languageTranslator('ltr_actions'));?></th>
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
			    if($this->session->userdata('admin_id') == 1 || $this->session->userdata('super_admin') == 0){
			    echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_students_no_data')).'</div>
                            </div>
                        </div>
                    </section>';
			    }else{
			         echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_students_no_data_te')).'</div>
                        </div>
                    </section>';
			    }
			}
			
		 ?>
	</div>
</section> 

<!-- Pop Up Start  -->
<div id="stImgModal" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="stImgModalLabel"><?php echo html_escape($this->common->languageTranslator('ltr_student_image'));?></h4>
            <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group text-center">
						<img id="std_img" class="stdnt_proflie_img" src="" alt="Student Image"/>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<!-- Pop Up Change Password Start  -->
<div id="changePassword" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title"><?php echo html_escape($this->common->languageTranslator('ltr_change_password'));?></h4>
            <form method="post">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <input type="password" id="newPass" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_new_password'));?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <input type="password" id="confirmPass" class="form-control require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_confirm_new_password'));?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
                            <button type="button" class="edu_admin_btn updateStudPassword"><?php echo html_escape($this->common->languageTranslator('ltr_change_password'));?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Bulk upload: show the chosen file (name, type, size) with a remove button.
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('smBulkFile');
    var box = document.getElementById('smBulkPreview');
    if (!input || !box) { return; }
    function size(bytes) {
        return bytes < 1024 ? bytes + ' B' : bytes < 1048576 ? (bytes / 1024).toFixed(1) + ' KB' : (bytes / 1048576).toFixed(1) + ' MB';
    }
    function render() {
        var f = input.files && input.files[0];
        if (!f) { box.hidden = true; input.classList.remove('has-file'); return; }
        var ext = (f.name.split('.').pop() || '').toLowerCase();
        box.querySelector('[data-sm-icon]').innerHTML = (ext === 'xls' || ext === 'xlsx') ? '&#128215;' : '&#128196;';
        box.querySelector('[data-sm-name]').textContent = f.name;
        box.querySelector('[data-sm-meta]').textContent = ext.toUpperCase() + ' file \u00b7 ' + size(f.size) + ' \u00b7 ready to upload';
        box.hidden = false;
        input.classList.add('has-file');
    }
    input.addEventListener('change', render);
    box.querySelector('[data-sm-clear]').addEventListener('click', function () { input.value = ''; render(); });
    render();
});
</script>
