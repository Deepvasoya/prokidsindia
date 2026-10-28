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
    height: 100%;
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




</style>
<section class="edu_admin_content">
    
	<div class="edu_admin_right sectionHolder edu_video_manager">
	    
        <?php $role = $this->session->userdata('role');?>	
        
        
        <?php if ($role != 'student'): ?>
            <div class="edu_btn_wrapper sectionHolder">
	         <div class="row">
	            
				<div class="col-lg-4 col-md-5 col-sm-8 col-12">
					<div class="form-group" style="display:flex; gap:12px; flex-wrap:wrap;">
						<span> 
							 <?php echo ($role != 'student')?'<a href="#add_video_playlist_popup" class="edu_admin_btn openPopupLink edu_admin_btn_video"><i class="icofont-plus"></i>Add Play List</a>':''; ?>
						</span>
						<span>
							<a href="javascript:void(0);" class="edu_admin_btn multiDelete" data-table="tbl_playlist" data-column="id" style="background-color:#e74c3c;">
								<i class="icofont-ui-delete"></i> Delete Selected
							</a>
						</span>
					</div>
				</div>
				
					</div>
	    </div>
	    <?php endif; ?>
	    
	    
	  
		<?php 
    		if(!empty($video_data)){
    		?> 
	    <div class="edu_table_wrapper">
    <div class="edu_admin_informationdiv sectionHolder">
        <div class="tableFullWrapper">
            <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="front_ajax/playlist_table/<?php echo $video_id; ?>">
                <thead>
                    <tr>
                        <?php echo ($role != 'student')?'<th><input type="checkbox" class="checkAllAttendance"></th>':''; ?>
                        <th>#</th>
                        <th>S. No.</th>
                        <th>Video</th>
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
			}else{ 
			    if($role=='student'){
    		        echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_video_no_data_student')).'</div>
                            </div>
                        </div>
                    </section>';
    		    }else if($role==3){
    		         echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_video_no_data_teacher')).'</div>
                            </div>
                        </div>
                    </section>';
    		    }else{
			     echo '<section class="edu_admin_content">
                        <div class="edu_admin_right sectionHolder edu_add_users">
                            <div class="edu_admin_informationdiv edu_main_wrapper">
                                <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_video_no_data_admin')).'</div>
                            </div>
                        </div>
                    </section>';
    		    }
			} ?>
	</div>
</section>



<!-- video playlist Pop Up Start  -->
<div id="add_video_playlist_popup" class="edu_popup_container mfp-hide" style="width:45%">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title">Create PlayList</h4>
            <form class="pxn_amin form" method="post" id="uploadForm">
                <input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
                <div class="row">
                    
                   	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    				    <div class="form-group video_type_video">
                            <label><?php echo html_escape($this->common->languageTranslator('ltr_file'));?><sup>*<sup></label>
                            <input type="file" class="form-control video_file"  name="video_file[]" multiple data-valid="video" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_video_msg'));?>" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_file'));?>" data-symb="no">
                            	<p class="fileNameShow"></p>
                        </div>
                         <div class="progress hide">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
                        </div>
                        <div id="uploadStatus"></div>
                    </div>
                    
                   
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    					<div class="edu_button_wrapper">
							<input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_add'));?>" class="edu_admin_btn addNewPlayList" />
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


if (!empty($studentName)) {
   
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
<div id="view_video_popup" class="edu_popup_container mfp-hide">
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
    
    /* Basic styling for the popup */
.edu_popup_container {
    position: relative;
}





</style>
<script>
$(document).ready(function(){
    $('.server_datatable').on('draw.dt', function() {
        var recordCount = $(this).DataTable().rows().count();
        if (recordCount > 0) {
            $('#deleteSelectedWrap').show();
        } else {
            $('#deleteSelectedWrap').hide();
        }
    });
});
</script>

 
 

