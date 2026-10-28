
<section class="edu_admin_content"> 
	<div class="edu_admin_right sectionHolder edu_video_manager">
        <?php $role = $this->session->userdata('role');
              $super_admin = $this->session->userdata('super_admin');?>				
	    <div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
	     
                        <?php echo ($role != 'student')?'<a href="#addFolderPop" class="edu_admin_btn openPopupLink"><i class="icofont-plus"></i>Add Folder</a>':''; ?>
                        
                        <?php echo ($role != 'student')?'<a href="#addFolderImgPop" class="edu_admin_btn openPopupLink"><i class="icofont-plus"></i>Add File</a>':''; ?>
                    
            
	    </div>
	     
        <?php if(!empty($book_data) && $role == 'student'){ ?>
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
		<?php 
    		// if(!empty($book_data)){
    		?> 
    		<!--Start New filter subject and batch-->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="filter_header">
                                    <h3 class="edu_filter_title"><?php echo html_escape($this->common->languageTranslator('ltr_filter_by_subject')); ?></h3>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">    
                                <div class="form-group">
                                    <span> 
                                        <select class="form-control filter_subject edu_selectbox_with_search" name="filter_subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>">
                                            <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?></option>
                                            <?php
                                                if(!empty($subject)){
                                                    foreach($subject as $sub){
                                                                                            echo '<option value="'.$sub['id'].'">'.$sub['subject_name'].'</option>';
                                                    }
                                                }
                                            ?> 
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">    
                                <div class="form-group">
                                    <span> 
                                        <select class="form-control filter_batch edu_selectbox_with_search" name="filter_batch[]" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?>">
                                            <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
                                            <?php
                                                if(!empty($batch)){
                                                    foreach($batch as $bat){
                                                                                            echo '<option value="'.$bat['id'].'">'.$bat['batch_name'].'</option>';
                                                    }
                                                }
                                            ?> 
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <span> 
                                        <input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search')); ?>" class="edu_admin_btn filter_btach_subject"> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

            <!--End New filter subject and batch-->
	    <div class="edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/study_material_folder_table/<?php echo $folder_id; ?>">
                        <thead>
                            <tr>
                                <?php echo ($role != 'student')?'<th><input type="checkbox" class="checkAllAttendance"></th>':''; ?>
                                <th>#</th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_title'));?></th>
                                <?php //echo ($role != 'student')?'<th>'.html_escape($this->common->languageTranslator('ltr_batch')).'</th>':''; ?>
                                
                                <th><?php echo 'Type';?></th>
                                <?php echo ($role != 'student')?'<th>'.html_escape($this->common->languageTranslator('ltr_status')).'</th>':''; ?>
                                <?php echo ($role != 'student')?'<th>'.html_escape($this->common->languageTranslator('ltr_added_by')).'</th>':''; ?>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_actions'));?></th>
                            </tr>
                        </thead>
    			        <tbody>
    			        </tbody>
    		        </table> 
		        </div>
			</div> 
		</div>
		<?php 
			// }else{ 
			//     if($role=='student'){
    		//         echo '<section class="edu_admin_content">
            //             <div class="edu_admin_right sectionHolder edu_add_users">
            //                 <div class="edu_admin_informationdiv edu_main_wrapper">
            //                     <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_book_no_data_student')).'</div>
            //                 </div>
            //             </div>
            //         </section>';
    		//     }else if($role==3){
    		//          echo '<section class="edu_admin_content">
            //             <div class="edu_admin_right sectionHolder edu_add_users">
            //                 <div class="edu_admin_informationdiv edu_main_wrapper">
            //                     <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_book_no_data_admin')).'</div>
            //                 </div>
            //             </div>
            //         </section>';
    		//     }else{
			//      echo '<section class="edu_admin_content">
            //             <div class="edu_admin_right sectionHolder edu_add_users">
            //                 <div class="edu_admin_informationdiv edu_main_wrapper">
            //                     <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_book_no_data_admin')).'</div>
            //                 </div>
            //             </div>
            //         </section>';
    		//     }
			// }
             ?>
	</div>
</section>


<!-- video Pop Up Start  -->
<div id="add_book_popup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1"><?php echo html_escape($this->common->languageTranslator('ltr_add_book'));?></h4>
            <form class="pxn_amin form" method="post">
            <input type="hidden" name="id" id="book_id">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_title'));?> <sup>*<sup></label>
                            <input type="text" class="form-control require video_title" name="title" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_title'));?>">
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
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_subject'));?><sup>*<sup></label>
                            <select id="subject_id" class="form-control require edu_selectbox_with_search teacher_subject" name="subject_id" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?>" data-count="no">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>
                                
                            </select>
                        </div>
    				</div>
                   
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_file'));?><sup>*</sup></label>
                            <!-- <input type="file" class="form-control file_book require" accepts="application/pdf" name="pdf_file" data-valid="pdfimage" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_pdf_msg'));?>"> -->
                            <input type="file" class="form-control file_book require" name="pdf_file" data-valid="pdfimage" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_pdf_msg'));?>">
                            <p class="fileNameShow"></p>
                        </div>
                    </div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_button_wrapper">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addNewStudyMaterial" />
						</div>
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
            <h4 class="edu_sub_title" id="viewVideoTopic"><?php echo html_escape($this->common->languageTranslator('ltr_view_video'));?></h4>
            <div class="row videoIframeShow">
            </div>
        </div>
    </div>
</div>


<!--view Add folder Pop Up Start  -->
<div id="addFolderPop" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1">Add Folder</h4>
            <form method="post" class="pxn_amin form"> 
            <input type="hidden" name="id" id="book_id">
            <input type="hidden" name="folder_id" id="folder_id" value="<?php echo $folder_id; ?>" />
            
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>Folder Name<sup>*</sup></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Folder Name" />

                        </div>
    				</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="addfolder" value="ADD" class="edu_admin_btn addStudyMaterialFolder" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>
<!-- view Add folder Pop Up Start  -->

<!--view Add folder Image Pop Up Start  -->
<div id="addFolderImgPop" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1">Add File</h4>
            <form method="post" class="pxn_amin form"> 
            <input type="hidden" name="id" id="book_id">
            <input type="hidden" name="folder_id" id="folder_id" value="<?php echo $folder_id; ?>" />
            
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Title<sup>*</sup></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="File Name" />
                        </div>
    				</div>
    				
    				<div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label>PDF<sup>*</sup></label>
                            <input type="file" class="form-control file_book require" name="pdf_file" data-valid="pdfimage" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_pdf_msg'));?>">
                            <p class="fileNameShow"></p>
                        </div>
    				</div>
    				
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_btn_wrapper">
							<input type="button" name="addfolder" value="ADD" class="edu_admin_btn addStudyMaterialFolderImage" data-id="" />
						</div>
    				</div>
				</div>
            </form>
        </div>
    </div>
</div>
<!-- view Add folder Image Pop Up Start  -->