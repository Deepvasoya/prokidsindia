<style>
.tableFullWrapper {
    overflow-x: auto;
}

.tableFullWrapper table {
    min-width: 1000px; /* Adjust this value as needed */
}



#view_video_popup {
  max-width: 90vw; /* or 100% */
  width: 100%;
}

.videoIframeShow {
    position: relative;
    width: 100%;
    height: 90%;
    overflow: hidden;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none; /* Ensures the overlay does not interfere with video interactions */
}

.animated-text {
    position: absolute;
    font-size: 17px; /* Adjust as needed */
    color: white; /* Text color for contrast */
    background-color: transparent; /* Optional: background color for better readability */
    padding: 10px;
    border-radius: 5px;
    white-space: nowrap;
    z-index: 9999; /* Ensure the text is on top of other content */
    animation: moveText 40s linear infinite; /* Total duration = 4 positions * 10s per position */
}

:fullscreen .animated-text,
:-webkit-full-screen .animated-text,
:-ms-fullscreen .animated-text {
    display: block; /* Ensure visibility in full-screen mode */
}

 .image-container {
            display: flex;
            gap: 10px;
            overflow-x: scroll; /* Forces horizontal scrolling */
            white-space: nowrap;
            padding: 10px;
            width: 100%;
            height: 160px; /* Ensure enough space */
            border: 1px solid black; /* Just for visibility */
        }

        .image-container img {
            width: 200px;
            height: auto;
            border-radius: 10px;
            flex-shrink: 0; /* Prevents images from shrinking */
        }

        /* Show scrollbar */
        .image-container::-webkit-scrollbar {
            height: 8px; /* Set scrollbar height */
        }

        .image-container::-webkit-scrollbar-thumb {
            background: #888; /* Scrollbar color */
            border-radius: 4px;
        }

        .image-container::-webkit-scrollbar-track {
            background: #f1f1f1; /* Scrollbar track color */
        }



@keyframes moveText {
    0%, 9.99% {
        opacity: 1;
        top: 100%; /* Bottom position */
        left: 50%;
        transform: translate(-50%, -100%);
    }
    10%, 24.99% {
        opacity: 0; /* Hide during transition */
    }
    25%, 34.99% {
        opacity: 1;
        top: 50%; /* Left position */
        left: 0%;
        transform: translate(0%, -50%);
    }
    35%, 49.99% {
        opacity: 0; /* Hide during transition */
    }
    50%, 59.99% {
        opacity: 1;
        top: 0%; /* Top position */
        left: 50%;
        transform: translate(-50%, 0%);
    }
    60%, 74.99% {
        opacity: 0; /* Hide during transition */
    }
    75%, 84.99% {
        opacity: 1;
        top: 50%; /* Right position */
        left: 100%;
        transform: translate(-100%, -50%);
    }
    85%, 100% {
        opacity: 0; /* Hide during transition */
    }
}

.edu_admin_informationdiv .table tr td:last-child {
  border-right: 1px solid #e7e7e9 !important;
  border-radius: 0 5px 5px 0 !important;
  transition: all 0.3s !important;
  white-space: nowrap !important;
  display: flex !important;
  align-items: center !important;
  gap: 12px !important; /* space between buttons */
  padding: 8px 12px !important;
}





</style>
<section class="edu_admin_content">


     <input type="hidden" id="batchID" >
     <input type="hidden" id="subjectID" >
       <input type="hidden" id="chapterID" >


	<div class="edu_admin_right sectionHolder edu_video_manager">

        <?php $role = $this->session->userdata('role'); ?>


         <?php if ($role != 'student'): ?>
    <div class="edu_btn_wrapper sectionHolder">
	         <div class="row">
	            <div class="col-lg-2 col-md-2 col-sm-6 col-12">
	            	<div class="form-group">
						<span>
							<select id="videoBatch" class="form-control edu_selectbox_with_search" name="batch" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?>">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
								<?php

                                    if (! empty($batch)) {
                                        foreach ($batch as $bat) {
                                            echo '<option value="' . $bat['id'] . '">' . $bat['batch_name'] . '</option>';
                                        }
                                    }
                                ?>
							</select>
						</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-6 col-12">
					<div class="form-group">
						<span>
							<select id="videoSubject"   class="form-control edu_selectbox_with_search" name="subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>">
								<!--<option value=""><?php //echo html_escape($this->common->languageTranslator('ltr_select_subject'));?></option>-->
							</select>
						</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-6 col-12">
				 	<div class="form-group">
						<span>
							<select id="videoChapter" class="form-control edu_selectbox_with_search" name="video_chapter" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?>">
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?></option>
							</select>
						</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-6 col-12">
					<div class="form-group">
						<span>
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search')); ?>" Class="btn btn-primary filter_videos" data-toggle="tooltip" title="Search">
						</span>
					</div>
				</div>

				<div class="col-lg-2 col-md-2 col-sm-6 col-12">
					<div class="form-group">
						<span>
							 <?php echo($role != 'student') ? '<a href="#add_video_popup" class="edu_admin_btn openPopupLink edu_admin_btn_video"><i class="icofont-plus"></i>' . html_escape($this->common->languageTranslator('ltr_add_video')) . '</a>' : ''; ?>
						</span>
					</div>

				</div>

					</div>
	    </div>
	    <?php endif; ?>





        <!--<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">-->

        <!--                <?php //echo ($role != 'student')?'<a href="#add_video_popup" class="edu_admin_btn openPopupLink edu_admin_btn_video"><i class="icofont-plus"></i>'.html_escape($this->common->languageTranslator('ltr_add_video')).'</a>':''; ?>-->

        <!--</div>-->

        <?php if (! empty($video_data) && $role == 'student') {?>

        <div class="edu_table_wrapper mb_30">

			<div class="edu_admin_informationdiv sectionHolder">

				<div class="row">

					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

						<div class="form-group">
							<span>
                                <select class="form-control video_subject filter_subject edu_selectbox_with_search" name="filter_subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>" data-count="no">
                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?></option>
                                    <?php
                                        if (! empty($subject)) {
                                            foreach ($subject as $sub) {
                                                echo '<option value="' . $sub['id'] . '">' . $sub['subject_name'] . '</option>';
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
                                <select  class="form-control filter_chapter  get_chapter edu_selectbox_with_search" name="topic" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?>">
                                    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?></option>
                                </select>
							</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<span>
								<div class="pxn_admin_btnsection">
									<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search')); ?>" class="btn btn-primary searchVideo"/>
								</div>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
        <?php }?>
        <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<?php if ($role != 'student') {?>
                        <button class="multiDelete btn_delete btn btn-primary"  data-placement="top" title="Delete" data-table="video_lectures" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete')); ?>
                        </button>
                        <button class="paidPreviewVideo btn_delete btn btn-primary"  data-placement="top" title="Delete" data-table="video_lectures" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_not_preview')); ?>
                        </button>
                        <button class="freePreviewVideo btn_delete btn btn-primary"  data-placement="top" title="Delete" data-table="video_lectures" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_preview')); ?>
                        </button>
                    <?php }?>
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		<?php
            if (! empty($video_data)) {
            ?>
	    <div class="edu_table_wrapper">
    <div class="edu_admin_informationdiv sectionHolder">
        <div class="tableFullWrapper">
            <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/video_table" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <?php echo($role != 'student') ? '<th><input type="checkbox" class="checkAllAttendance"></th>' : ''; ?>
                        <th width="30">#</th>
                        <th width="30">Sort</th>
                        <th><?php echo html_escape($this->common->languageTranslator('ltr_title')); ?></th>
                        <?php echo($role != 'student') ? '<th>' . html_escape($this->common->languageTranslator('ltr_batch')) . '</th>' : ''; ?>
                        <th><?php echo html_escape($this->common->languageTranslator('ltr_subject')); ?></th>
                        <th><?php echo html_escape($this->common->languageTranslator('ltr_chapter')); ?></th>
                        <?php echo($role != 'student') ? '<th>' . html_escape($this->common->languageTranslator('ltr_Source')) . '</th>' : ''; ?>
                        <?php echo($role != 'student') ? '<th>' . html_escape($this->common->languageTranslator('ltr_status')) . '</th>' : ''; ?>
                        <th><?php echo html_escape($this->common->languageTranslator('ltr_actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
		<?php
            } else {
                if ($role == 'student') {
                    echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">' . html_escape($this->common->languageTranslator('ltr_video_no_data_student')) . '</div>
                            </div>
                        </div>
                    </section>';
                } else if ($role == 3) {
                    echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">' . html_escape($this->common->languageTranslator('ltr_video_no_data_teacher')) . '</div>
                            </div>
                        </div>
                    </section>';
                } else {
                    echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">' . html_escape($this->common->languageTranslator('ltr_video_no_data_admin')) . '</div>
                            </div>
                        </div>
                    </section>';
                }
        }?>
	</div>
</section>


<!-- video Pop Up Start  -->
<div id="add_video_popup" class="edu_popup_container_logout mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="myModalLabel1"><?php echo html_escape($this->common->languageTranslator('ltr_add_video')); ?></h4>
            <form class="pxn_amin form" method="post" id="uploadForm">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="preview_type" value="not_preview">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_batch')); ?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search video_batch " name="batch[]"  data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?>" multiple>
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?></option>
                                <?php
                                    if (! empty($batch)) {
                                        foreach ($batch as $bat) {
                                            echo '<option value="' . $bat['id'] . '" >' . $bat['batch_name'] . '</option>';
                                        }
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_subject')); ?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_subject" name="subject" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>" data-count="no">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?></option>
                                <?php if (! empty($subject)) {
                                        foreach ($subject as $sub) {
                                            echo '<option value="' . $sub['id'] . '" >' . $sub['subject_name'] . '</option>';
                                        }
                                }?>
                            </select>
                        </div>
    				</div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
    					<div class="form-group">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_chapter')); ?><sup>*<sup></label>
                            <select class="form-control require edu_selectbox_with_search filter_chapter" name="topic" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?>">
                                <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?></option>
                            </select>
                        </div>
    				</div>


    				<!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <label><?php echo 'Thumbnail (550px X 240px)'; ?></label><br>
                        <div class="form-group">
                          <input class="form-control" type="file"  name="thumbnail[]" multiple id="thumbnail" />
                          <p class="fileNameShow"></p>

                        </div>
                    </div> -->

             

                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <label><?php echo html_escape($this->common->languageTranslator('ltr_Source')); ?><sup>*<sup></label><br>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" type="radio" name="video_type" id="inlineRadio1" value="youtube">
                          <label class="form-check-label" for="inlineRadio1"><?php echo html_escape($this->common->languageTranslator('ltr_youtube')); ?></label>
                        </div>
                        <div class="form-check form-check-inline" style="display: none;">
                          <input class="form-check-input require" type="radio" name="video_type" id="inlineRadio2" value="vimeo">
                          <label class="form-check-label" for="inlineRadio2"><?php echo html_escape($this->common->languageTranslator('ltr_vimeo')); ?></label>
                        </div>
                        <div class="form-check form-check-inline" style="display: none;">
                          <input class="form-check-input require" type="radio" name="video_type" id="inlineRadio3" value="dropbox">
                          <label class="form-check-label" for="inlineRadio3"><?php echo html_escape($this->common->languageTranslator('ltr_dropbox')); ?></label>
                        </div>
                        <div class="form-check form-check-inline" style="display: none;">
                          <input class="form-check-input require" type="radio" name="video_type" id="inlineRadio4" value="embed">
                          <label class="form-check-label" for="inlineRadio4"><?php echo html_escape($this->common->languageTranslator('ltr_embed')); ?></label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input require" checked type="radio" name="video_type" id="inlineRadio5" value="video">
                          <label class="form-check-label" for="inlineRadio5"><?php echo html_escape($this->common->languageTranslator('ltr_upload')); ?></label>
                        </div>

                    </div>
    				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="form-group hide video_type_all">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_url')); ?><sup>*<sup></label>
                            <input type="text" class="form-control require video_url"  name="url" data-valid="youtube" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_url_msg')); ?>" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_url')); ?>" data-symb="no">
                        </div>
                        <div class="form-group  video_type_video">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_file')); ?><sup>*<sup></label>
                            <input type="file" class="form-control video_file"  name="video_file[]" multiple accept=".mp4,.mp3,video/mp4,video/mp3,audio/mp3,audio/mpeg" data-valid="video" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_video_msg')); ?>" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_file')); ?>" data-symb="no">
                            	<p class="fileNameShow"></p>
                        </div>

                        <div id="videoTitleContainer">

                            <div class="form-group">
                                <label><?php echo html_escape($this->common->languageTranslator('ltr_title')); ?> <sup>*<sup></label>
                                <input type="text" class="form-control require video_title" name="title" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_title')); ?>">

                            </div>

                            <div class="form-group">
                                <label>Thumbnail (550px X 240px)</label>
                                <input type="file" class="form-control thumbnail_file" name="thumbnail[]" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                <p class="fileNameShow"></p>
                            </div>

                        </div>

                         <div class="progress hide">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
                        </div>
                        <div id="uploadStatus"></div>
                    </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" 
     style="display:flex; justify-content:center; align-items:center;">
    <div class="edu_button_wrapper" style="display:flex; justify-content:center; align-items:center; width:100%;">
        <input type="button" 
               value="<?php echo html_escape($this->common->languageTranslator('ltr_add')); ?>" 
               class="edu_admin_btn addNewVideo"
               style="min-width:50%; height:100px; display:flex; justify-content:center; align-items:center; text-align:center;" />
    </div>
</div>



					
				</div>
            </form>
        </div>
    </div>
</div>



<?php
    // Load the database library if not already loaded

    // Get the student name from the session
    $studentName = $this->session->userdata('name');

    // Initialize variable for student number
    $studentNumber = '';

    if (! empty($studentName)) {

        $this->db->select('contact_no');
        $this->db->from('students');
        $this->db->where('name', $studentName);
        $query = $this->db->get();

        // Fetch the result
        if ($query->num_rows() > 0) {
            $studentNumber = $query->row()->contact_no;
        }
    }
?>

<!-- view Pop Up Start  -->
<div id="view_video_popup" class="edu_popup_container mfp-hide" style="padding:10px 40px 26px">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="viewVideoTopic">
                <?php echo html_escape($this->common->languageTranslator('ltr_view_video')); ?>
            </h4>
            <div class="video-container">
                <!-- This container is the boundary for animation -->
                <div class="video-overlay">
                    <span id="animatedText" class="animated-text">
                        <?php
                            echo isset($this->session->userdata['name']) ? htmlspecialchars($this->session->userdata['name'], ENT_QUOTES, 'UTF-8') : '';
                        ?>
                        <br>
                        <?php
                            echo htmlspecialchars($studentNumber, ENT_QUOTES, 'UTF-8');
                        ?>
                    </span>
                </div>
                <div class="row videoIframeShow">
                    <!-- Your iframe video content -->
                </div>
            </div>







            <!--<div class="row commentBox">-->
            <!--    <div class="commentInput">-->
            <!--        <input type="hidden" id="videox_id" name="videox_id">-->
            <!--        <input class="form-control" name="video_comment_inpt" id="commentInput" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_description')); ?>">-->
            <!--    </div>-->
            <!--    <div class="commentSend">-->
            <!--        <button id="button_sbmt_cmnt" class="btn btn-primary">Send</button>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="commentsSection">-->
            <!--</div>-->
        </div>
    </div>
</div>









<style>


    .commentBox{
        position: sticky;
        bottom: 0; /* Stick to the bottom of the container */
        background-color: #f1f1f1; /* Example background color */
        padding: 10px 0; /* Example padding */
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1); /* Example shadow */
    }

    .commentInput{
        width: 73%;
    }

    .commentSend{
        width: 27%;
    }

   .comment {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .comment strong {
        color: #336699;
    }
    .comment p {
        margin: 0;
    }
    .comment .date {
        font-size: 0.8em;
        color: #999;
    }


@media (max-width: 991px) {
    .mfp-content {
        position: absolute!important;
        top: 50%!important;

        transform: translate(-50%,-50%)!important;
        z-index: 10!important;
    }

    }

    /* Basic styling for the popup */
.edu_popup_container {
    position: relative;
}


#add_video_popup::-webkit-scrollbar,
#view_video_popup::-webkit-scrollbar {
    width: 30px !important;
}

/* Target scrollbar in form elements */
.pxn_amin form::-webkit-scrollbar {
    width: 15px !important;
}

.video-title-row:hover::before {
    left: 100%;
}

.video-title-row:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 45px rgba(0, 123, 255, 0.2);
}

/* Label with cool effect */
.video-title-row label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 17px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: inline-block;
    position: relative;
    padding-left: 15px;
}

.video-title-row label::before {
    content: '▶';
    position: absolute;
    left: 0;
    color: #007bff;
    font-size: 12px;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; transform: translateX(3px); }
}

/* Stylish text input */
.video-title-row input[type="text"] {
    background: #ffffff;
    border: 2px solid #e7e7e9;
    border-radius: 12px;
    color: #000000;
    font-size: 15px;
    padding: 14px 18px;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
}

.video-title-row input[type="text"]:focus {
    border-color: #006eff;
    box-shadow: 0 0 10px rgba(0, 110, 255, 0.2), inset 0 2px 5px rgba(0,0,0,0.05);
    outline: none;
    background: #ffffff;
}

.video-title-row input[type="text"]::placeholder {
    color: rgba(0, 0, 0, 0.6);
    font-style: italic;
}

.video-title-row input[type="file"]:hover {
    border-color: #006eff;
    background: #f9f9f9;
    transform: scale(1.02);
}

/* Style for file input button */
.video-title-row input[type="file"]::-webkit-file-upload-button {
    background: linear-gradient(45deg, #4a90e2, #007bff);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    margin-right: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.video-title-row input[type="file"]::-webkit-file-upload-button:hover {
    background: linear-gradient(45deg, #007bff, #4a90e2);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

/* File name display with style */
.fileNameShow {
    margin-top: 12px;
    padding: 10px 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    color: white;
    font-weight: 500;
    font-size: 14px;
    display: inline-block;
    animation: slideIn 0.4s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Add file icon before filename */
.fileNameShow::before {
    content: '📁 ';
    font-size: 16px;
    margin-right: 5px;
}

/* For Firefox compatibility */
.video-title-row input[type="file"]::file-selector-button {
    background: linear-gradient(45deg, #4a90e2, #007bff);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    margin-right: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.video-title-row input[type="file"]::file-selector-button:hover {
    background: linear-gradient(45deg, #007bff, #4a90e2);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}


/* Responsive design */
@media (max-width: 768px) {
    .video-title-row {
        padding: 15px;
    }
    
    .video-title-row input[type="file"]::-webkit-file-upload-button {
        display: block;
        margin: 10px 0;
        width: 100%;
    }
}


/* Thumbnail container styling - ADD THIS */
.thumbnail-container {
    position: relative;
    width: 100%;
}

/* Hide default file input - ADD THIS */
.thumbnail-container input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 3;
    left: 0;
    top: 0;
}

/* Custom file input display - BLACK BACKGROUND - ADD THIS */
.custom-file-display {
    background: #ffffff !important;
    border: 2px solid #e7e7e9 !important;
    border-radius: 8px !important;
    color: rgba(0, 0, 0, 0.6) !important;
    font-size: 15px;
    padding: 12px 15px;
    width: 100%;
    transition: all 0.3s ease;
    pointer-events: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-style: italic;
    box-sizing: border-box;
}

/* When file selected - show filename in WHITE - ADD THIS */
.thumbnail-container.file-selected .custom-file-display {
    color: #000000 !important;
    border-color: #006eff !important;
    background: #ffffff !important;
    font-style: normal;
}

/* Hover effect - ADD THIS */
.thumbnail-container:hover .custom-file-display {
    border-color: #006eff !important;
    transform: translateY(-2px);
}

/* Video file name display styling */
.video_type_video .fileNameShow {
    display: block !important;
    margin-top: 8px;
    padding: 8px 12px;
    background: #ffffff;
    border: 1px solid #e7e7e9;
    border-radius: 6px;
    color: #000000;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.video_type_video .fileNameShow::before {
    content: '🎬 ';
    margin-right: 5px;
}

/* For multiple files */
.video_type_video .fileNameShow.multiple-files {
    white-space: normal;
    word-break: break-all;
    max-height: 80px;
    overflow-y: auto;

</style>





</style>




