<!DOCTYPE html>
<html <?php if($this->common->language_name=='arabic'){echo 'lang="ar" dir="rtl"';}else if($this->common->language_name=='french'){echo 'lang="fr" dir="ltr"';}else if($this->common->language_name=='english'){echo 'lang="en" dir="ltr"';} ?> >
<!-- Begin Head -->
  <head>
    <!----- Required MetaTags ----->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php echo html_escape($this->common->siteKeywords); ?>">
    <meta name="description" content="<?php echo html_escape($this->common->siteDescription); ?>">
    <meta name="author" content="<?php echo html_escape($this->common->siteAuthorName); ?>">
    <!----- Style css ----->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/icofont.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/toastr.min.css';?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/frontend-rtl.css?<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/frontend-style.css?<?php echo time();?>">
    
	<!----- Favicon ----->
	<link rel="shortcut icon" type="image/ico" href="<?php echo html_escape($this->common->siteFavicon); ?>" />
	<!----- Title ----->
    <title><?php echo html_escape($this->common->siteTitle).((isset($title) && !empty($title)) ? ' | '.$title:'');?></title>
	<script>
		var base_url = "<?php echo base_url();?>";
		var site_logo = "<?php echo base_url();?>assets/images/favicon.png";
		var rzp_key ="<?php echo $this->common->rzp_key ?>";
        var ltr_status_msg = "<?php echo html_escape($this->common->languageTranslator('ltr_status_msg')); ?>";
		var ltr_matching_msg = "<?php echo html_escape($this->common->languageTranslator('ltr_matching_msg')); ?>";
		var ltr_select_chapter ="<?php echo html_escape($this->common->languageTranslator('ltr_select_chapter')); ?>";
		var ltr_select_subject ="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject')); ?>";
		var ltr_subject ="<?php echo html_escape($this->common->languageTranslator('ltr_subject')); ?>";
		var ltr_teacher ="<?php echo html_escape($this->common->languageTranslator('ltr_teacher')); ?>";
		var ltr_select_teacher ="<?php echo html_escape($this->common->languageTranslator('ltr_select_teacher')); ?>";
		var ltr_start_date ="<?php echo html_escape($this->common->languageTranslator('ltr_start_date')); ?>";
		var ltr_end_date ="<?php echo html_escape($this->common->languageTranslator('ltr_end_date')); ?>";
		var ltr_start_time ="<?php echo html_escape($this->common->languageTranslator('ltr_start_time')); ?>";
		var ltr_end_time ="<?php echo html_escape($this->common->languageTranslator('ltr_end_time')); ?>";
        var ltr_cant_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_cant_msg')); ?>";
        var ltr_are_you_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_are_you_msg')); ?>";
        var ltr_add_course ="<?php echo html_escape($this->common->languageTranslator('ltr_add_course')); ?>";
        var ltr_edit_course ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_course')); ?>";
        var ltr_add_doubts_date_class ="<?php echo html_escape($this->common->languageTranslator('ltr_add_doubts_date_class')); ?>";
        var ltr_add_new_exam ="<?php echo html_escape($this->common->languageTranslator('ltr_add_new_exam')); ?>";
        var ltr_end_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_end_date_msg')); ?>";
        var ltr_subject_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_msg')); ?>";
        var ltr_characters_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_characters_msg')); ?>";
        var ltr_password_student_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_password_student_msg')); ?>";
        var ltr_enrollment_id ="<?php echo html_escape($this->common->languageTranslator('ltr_enrollment_id')); ?>";
        var ltr_password ="<?php echo html_escape($this->common->languageTranslator('ltr_password')); ?>";
        var ltr_add_another_student ="<?php echo html_escape($this->common->languageTranslator('ltr_add_another_student')); ?>";
        var ltr_select_batch_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch_msg')); ?>";
		var ltr_select_batch ="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch')); ?>";
        var ltr_changed_batch_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_changed_batch_msg')); ?>";
        var ltr_changed_password_for_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_changed_password_for_msg')); ?>";
        var ltr_confirm_password_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_confirm_password_msg')); ?>";
        var ltr_password_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_password_msg')); ?>";
        var ltr_subject_name_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_name_msg')); ?>";
        var ltr_letters_characters_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_letters_characters_msg')); ?>";
        var ltr_subject_updated_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_updated_msg')); ?>";
        var ltr_subject_add_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_add_msg')); ?>";
        var ltr_subject_exists_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_exists_msg')); ?>";
        var ltr_are_you_so_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_are_you_so_msg')); ?>";
        var ltr_subject_delete_alert_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_subject_delete_alert_msg')); ?>";
        var ltr_atleast_chapter_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_atleast_chapter_msg')); ?>";
        var ltr_add_chapter_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_add_chapter_msg')); ?>";
        var ltr_exists_chapter_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_exists_chapter_msg')); ?>";
        var ltr_chapter_name_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_chapter_name_msg')); ?>";
        var ltr_chapter_updated_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_chapter_updated_msg')); ?>";
        var ltr_chapter_delete_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_chapter_delete_msg')); ?>";
        var ltr_loading_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_loading_msg')); ?>";
        var ltr_select_subject_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject_msg')); ?>";
        var ltr_select_subject_both_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_subject_both_msg')); ?>";
        var ltr_word_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_word_msg')); ?>";
        var ltr_answer_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_answer_msg')); ?>";
        var ltr_start_date_greater_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_start_date_greater_msg')); ?>";
        var ltr_add_teacher ="<?php echo html_escape($this->common->languageTranslator('ltr_add_teacher')); ?>";
        var ltr_edit_teacher ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_teacher')); ?>";
        var ltr_update_teacher ="<?php echo html_escape($this->common->languageTranslator('ltr_update_teacher')); ?>";
        var ltr_add_extra_class ="<?php echo html_escape($this->common->languageTranslator('ltr_add_extra_class')); ?>";
        var ltr_add_class ="<?php echo html_escape($this->common->languageTranslator('ltr_add_class')); ?>";
        var ltr_edit_extra_class ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_extra_class')); ?>";
        var ltr_update_class ="<?php echo html_escape($this->common->languageTranslator('ltr_update_class')); ?>";
        var ltr_past_time_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_past_time_msg')); ?>";
        var ltr_end_greater_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_end_greater_msg')); ?>";
        var ltr_today_greater_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_today_greater_msg')); ?>";
        var ltr_class_already_added_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_class_already_added_msg')); ?>";
        var ltr_valid_time_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_valid_time_msg')); ?>";
        var ltr_select_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_date_msg')); ?>";
        var ltr_atleast_question_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_atleast_question_msg')); ?>";
        var ltr_select_year_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_year_msg')); ?>";
        var ltr_select_paper_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_paper_msg')); ?>";
        var ltr_add_facility ="<?php echo html_escape($this->common->languageTranslator('ltr_add_facility')); ?>";
        var ltr_edit_facility ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_facility')); ?>";
        var ltr_add_assignment ="<?php echo html_escape($this->common->languageTranslator('ltr_add_assignment')); ?>";
        var ltr_edit_assignment ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_assignment')); ?>";
        var ltr_update_assignment ="<?php echo html_escape($this->common->languageTranslator('ltr_update_assignment')); ?>";
        var ltr_select_from_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_from_date_msg')); ?>";
        var ltr_select_to_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_select_to_date_msg')); ?>";
        var ltr_batch_inactive_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_batch_inactive_msg')); ?>";
        var ltr_mark_complete ="<?php echo html_escape($this->common->languageTranslator('ltr_mark_complete')); ?>";
        var ltr_complete ="<?php echo html_escape($this->common->languageTranslator('ltr_complete')); ?>";
        var ltr_all_fields_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_all_fields_msg')); ?>";
        var ltr_hide_password ="<?php echo html_escape($this->common->languageTranslator('ltr_hide_password')); ?>";
        var ltr_change_password ="<?php echo html_escape($this->common->languageTranslator('ltr_change_password')); ?>";
        var ltr_new_password_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_new_password_msg')); ?>";
        var ltr_all_test_record_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_all_test_record_msg')); ?>";
        var ltr_once_deleted_alert_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_once_deleted_alert_msg')); ?>";
        var ltr_are_deleted_alert_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_are_deleted_alert_msg')); ?>";
        var ltr_updated_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_updated_msg')); ?>";
        var ltr_alert_updated_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_alert_updated_msg')); ?>";
        var ltr_category_changed_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_category_changed_msg')); ?>";
        var ltr_invalid_birth_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_invalid_birth_msg')); ?>";
        var ltr_to_greater_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_to_greater_msg')); ?>";
        var ltr_message ="<?php echo html_escape($this->common->languageTranslator('ltr_message')); ?>";
        var ltr_add_live_class ="<?php echo html_escape($this->common->languageTranslator('ltr_add_live_class')); ?>";
        var ltr_edit_live_class ="<?php echo html_escape($this->common->languageTranslator('ltr_edit_live_class')); ?>";
        var ltr_atleast_student_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_atleast_student_msg')); ?>";
        var ltr_atleast_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_atleast_date_msg')); ?>";
        var ltr_maximum40_characters_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_maximum40_characters_msg')); ?>";
        var ltr_maximum50_characters_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_maximum50_characters_msg')); ?>";
        var ltr_double_class_date_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_double_class_date_msg')); ?>";
		var ltr_ok ="<?php echo html_escape($this->common->languageTranslator('ltr_ok')); ?>";
		var ltr_cancel ="<?php echo html_escape($this->common->languageTranslator('ltr_cancel')); ?>";
		var ltr_select_student ="<?php echo html_escape($this->common->languageTranslator('ltr_select_student')); ?>";
		var ltr_description ="<?php echo html_escape($this->common->languageTranslator('ltr_description')); ?>";
		var ltr_can_remove_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_can_remove_msg')); ?>";
		var ltr_some_required ="<?php echo html_escape($this->common->languageTranslator('ltr_some_required')); ?>";
        var ltr_only_letters_msg ="<?php echo html_escape($this->common->languageTranslator('ltr_only_letters_msg')); ?>";
        var ltr_search ="<?php echo html_escape($this->common->languageTranslator('ltr_search')); ?>";
        var ltr_show ="<?php echo html_escape($this->common->languageTranslator('ltr_show')); ?>";
        var ltr_heading  ="<?php echo html_escape($this->common->languageTranslator('ltr_heading')); ?>";
        var ltr_sub_heading  ="<?php echo html_escape($this->common->languageTranslator('ltr_sub_heading')); ?>";
        var ltr_batch_speci_heading  ="<?php echo html_escape($this->common->languageTranslator('ltr_batch_speci_heading')); ?>";
        var ltr_fecherd  ="<?php echo html_escape($this->common->languageTranslator('ltr_fecherd')); ?>";
        var ltr_email  ="<?php echo html_escape($this->common->languageTranslator('ltr_email')); ?>";
        var ltr_wrong_credentials_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_wrong_credentials_msg')); ?>";
        var ltr_batch_spe_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_batch_spe_msg')); ?>";
        var ltr_you_delete  ="<?php echo html_escape($this->common->languageTranslator('ltr_you_delete')); ?>";
        var ltr_i_learn  ="<?php echo html_escape($this->common->languageTranslator('ltr_i_learn')); ?>";
        var ltr_chapters  ="<?php echo html_escape($this->common->languageTranslator('ltr_chapters')); ?>";
        var ltr_offer_price_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_offer_price_msg')); ?>";
        var ltr_batch_price_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_batch_price_msg')); ?>";
        var ltr_payment_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_payment_msg')); ?>";
        var ltr_something_msg  ="<?php echo html_escape($this->common->languageTranslator('ltr_something_msg')); ?>";
        var ltr_enter_your_name="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_name')); ?>";
        var ltr_enter_your_email="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_email')); ?>";
        var ltr_valid_enter_your_email="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_email')); ?>";
        var ltr_enter_your_phone="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_phone')); ?>";
        var ltr_valid_enter_your_phone="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_phone')); ?>";
        var ltr_enter_your_message="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_message')); ?>";
        var ltr_send="<?php echo html_escape($this->common->languageTranslator('ltr_send')); ?>";
        var ltr_no_result="<?php echo html_escape($this->common->languageTranslator('ltr_no_result')); ?>";

	</script>
	<style>
.notification-item {
    position: relative;
}

.notification-icon {
    display: inline-block;
    position: relative;
    text-decoration: none;
}

.notification-icon i {
    font-size: 18px;
    color: #333; /* Adjust color as needed */
}

.notification-count {
    position: absolute;
    top: 2px; /* Adjust position as needed */
    right: 12px; /* Adjust position as needed */
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    line-height: 1;
    font-weight: bold;
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 300px; /* Adjust width as needed */
    z-index: 1000;
    display: none; /* Ensure it is hidden by default */
    max-height: 278px; /* Set max height to accommodate 2 notifications */
    overflow-y: auto; /* Enable vertical scrolling */
    scrollbar-width: none;
}

.notification-dropdown ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.notification-dropdown li {
    border-bottom: 1px solid #ddd;
}

.notification-dropdown li:last-child {
    border-bottom: none;
}

.notification-dropdown a {
    display: block;
    padding: 10px;
    color: #333;
    text-decoration: none;
}

.notification-dropdown a:hover {
    background-color: #f1f1f1;
}
.notification-dropdown ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notification-content {
    display: flex;
    align-items: center;
    padding: 10px;
}

.notification-image {
    width: 100px;
    height: 100px;
   
    border-radius: 50%;
}

.notification-details {
    display: flex;
    flex-direction: column;
}

.notification-title {
    font-size: 14px;
    font-weight: bold;
    margin: 0;
}

.notification-description {
    font-size: 12px;
    color: #666;
    margin: 5px 0;
}

.notification-date {
    font-size: 10px;
    color: #999;
}
	</style>
  </head>
  <body class="<?php if($this->common->language_name=='arabic'){ echo 'rtl' ;}?>">
	<!----- Preloader Box ----->
	<div class="edu_preloader">
		<div class="edu_status">
			<img src="<?php echo html_escape($this->common->siteLoader); ?>" alt="loader">
		</div>
	</div>
	<!----- Preloader Box ----->
	<?php
	$timezoneDB = $this->db_model->select_data('timezone','site_details',array('id'=>1));

	if(isset($timezoneDB[0]['timezone']) && !empty($timezoneDB[0]['timezone'])){
		date_default_timezone_set($timezoneDB[0]['timezone']);
	}
	?>
	<!----- Main Wraapper ----->
	<section class="main_wrapper">
	    
		<!----- Header Start ----->
		<header>
			<div class="edu_header_top">
				<div class="container-fluid">
					<div class="row">
						<!--<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="edu_social_wrapper">
								<ul>
									<li><?php echo html_escape($this->common->languageTranslator('ltr_follow_us_on')); ?></li>
									<?php 
									if(!empty($frontend_details[0]['facebook']))
										echo ' <li><a href="'.$frontend_details[0]['facebook'].'" class="edu_social_icon" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
									
									if(!empty($frontend_details[0]['youtube']))
										echo ' <li><a href="'.$frontend_details[0]['youtube'].'" class="edu_social_icon" target="_blank"><i class="fab fa-youtube"></i></a></li>';

									if(!empty($frontend_details[0]['twitter']))
										echo ' <li><a href="'.$frontend_details[0]['twitter'].'" class="edu_social_icon" target="_blank"><i class="fab fa-twitter"></i></a></li>';

									if(!empty($frontend_details[0]['instagram']))
										echo ' <li><a href="'.$frontend_details[0]['instagram'].'" class="edu_social_icon" target="_blank"><i class="fab fa-instagram"></i></a></li>';

									if(!empty($frontend_details[0]['linkedin']))
										echo ' <li><a href="'.$frontend_details[0]['linkedin'].'" class="edu_social_icon" target="_blank"><i class="fab fa-linkedin"></i></a></li>';
									?>
                                </ul>
							</div>
						</div>-->
						<!--<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="edu_header_info">
								<ul>
									<li>
										<?php
										if(!empty($frontend_details[0]['email']))
											echo '<a href="mailto:'.$frontend_details[0]['email'].'"><i class="fas fa-envelope"></i>'.$frontend_details[0]['email'].'</a>';
										else
											echo '<a href="mailto:example@email.com"><i class="fas fa-envelope"></i>example@email.com</a>';
										?>
									</li>
									<li>
										<?php
										if(!empty($frontend_details[0]['mobile']))
											echo '<a href="tel:+'.$frontend_details[0]['mobile'].'"><i class="fas fa-phone-volume"></i>'.$frontend_details[0]['mobile'].'</a>';
										else
											echo '<a href="tel:+91 9999999999"><i class="fas fa-phone-volume"></i>+91 9999999999</a>';
										?>
									</li>
									<li>
									  <?php if(!empty($_SESSION['role'])){ ?>
									    <?php if($_SESSION['role']==1){?>
									    <li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('admin/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    <?php }elseif($_SESSION['role']=="student"){ ?>
									       	<li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('student/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									     
									    <?php }else{ ?>
									       <li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('teacher/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    
									    <?php } ?>
									    <a href="javascript:void(0);" title="<?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?>" class="cnfmlogOutBtn"><i class="icofont-logout"></i><span><?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?></span></a>
									 
									  <?php }else{ ?>
										<a href="<?php echo base_url('login');?>"><i class="fas fa-sign-in-alt"></i><?php echo html_escape($this->common->languageTranslator('ltr_login')); ?></a>
									<?php } ?>
									</li>
								</ul>
							</div>
						</div>-->
					</div>
				</div>
			</div>
			<div class="edu_header_wrapper">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-3 col-md-4 col-5 pr-0">
							<div class="edu_logo">
								<a href="<?php echo base_url();?>"><img class="front_logo" src="<?php echo html_escape($this->common->siteLogo); ?>" alt="logo" /></a>
							</div>
						</div>
					
						<div class="col-lg-9 col-md-8 col-7 text-right">
							<div class="r-btn mb-rbtn">
							<ul>
							    <li class="d-inline-block"><form class="edu-search-form">
                                    <input type="text" id="search_field" name="search_field" placeholder="Search Course">
                                    <span class="edu-search-icon">
                                       <a href="javascript:;" id="search_button" name="search_button" placeholder="Search Course"> <i class="fas fa-search"></i></a>
                                    </span>
                                 </form>
                                </li> 
<?php
// Fetch auth_id from session
$auth_id = $this->session->userdata('uid');

// Fetch all notifications from the database
$this->db->select('id, title, image, description, created_date');
$this->db->from('notification'); 
$query = $this->db->get();
$all_notifications = $query->result_array();

// Array to hold notifications that have not been recorded for the user
$unrecorded_notifications = [];

// Loop through each notification to check if it has already been recorded for the user
foreach ($all_notifications as $notification) {
    $notification_id = $notification['id'];

    // Check if this notification is already recorded for the user
    $this->db->select('id');
    $this->db->from('student_notifications');
    $this->db->where('student_id', $auth_id); // Use auth_id from the session
    $this->db->where('notification_id', $notification_id);
    $existing_notification = $this->db->get()->row_array();

    // If not recorded, add to unrecorded_notifications array
    if (!$existing_notification) {
        $unrecorded_notifications[] = $notification;
    }
}

// Count the unrecorded notifications
$notification_count = count($unrecorded_notifications);
?>
 <?php if(!empty($_SESSION['role'])){ ?>
<li class="d-inline-block notification-item">
    <a href="javascript:;" class="notification-icon">
        <i class="fas fa-bell" style="color:white;"></i>
        <?php if ($notification_count > 0): ?>
            <span class="notification-count"><?php echo $notification_count; ?></span>
        <?php endif; ?>
    </a>
    
    <div class="notification-dropdown" style="display: none;">
        <ul>
            <?php if ($notification_count > 0): ?>
                <?php foreach ($unrecorded_notifications as $notification): ?>
                    <li>
                        <a href="#" style="border-radius: 0; background-color: white;">
                            <div class="notification-content">
                                <img src="<?php echo base_url('uploads/notification/') . htmlspecialchars($notification['image']); ?>" alt="Notification Image" class="notification-image">
                                <div class="notification-details" style="margin-left: 65px;">
                                    <h6 class="notification-title"><?php echo htmlspecialchars($notification['title']); ?></h6>
                                    <p class="notification-description"><?php echo htmlspecialchars($notification['description']); ?></p>
                                    <span class="notification-date"><?php echo date('Y-m-d', strtotime($notification['created_date'])); ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <div class="notification-content">
                        <p class="no-notifications" style="text-align: center; padding: 10px; color: #555;">No notifications</p>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</li>
<?php } ?>

									  <?php if(!empty($_SESSION['role'])){ ?>
									    <?php if($_SESSION['role']==1){ ?>
									    <li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('admin/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    <?php }elseif($_SESSION['role']=="student"){ ?>
									       	<li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('student/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									     
									    <?php }else{ ?>
									       <li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('teacher/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    
									    <?php } ?>
									    <li class="d-lg-inline-block d-md-inline-block d-none"><a href="javascript:void(0);" title="<?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?>" class="cnfmlogOutBtn">
									    <i class="icofont-logout"></i><span><?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?></span></a></li>
									    
									  <?php }else{ ?>
									    <li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('login');?>"><?php echo html_escape($this->common->languageTranslator('ltr_login')); ?></a></li>
										<li class="d-lg-inline-block d-md-inline-block d-none"><a href="<?php echo base_url('register');?>"><?php echo html_escape($this->common->languageTranslator('ltr_register_now')); ?></a></li>
									<?php } ?>
								<!-- Search Course Start -->

               
        
 
<!-- Search Course End -->	
							</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</header>
		
<div class="container-fluid tp-container">
    <div class="row">
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 menu-bg">
      <div class="edu_main_menu main_menu_parent">
								<!----- Header Menus ----->
								<div class="edu_nav_items main_menu_wrapper text-right">
									<ul>
									    	<li><a href="<?php echo base_url('courses-offered');?>"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
  <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/>
  <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/></svg>Home</a></li>
  
										<!--<li><a href="<?php echo base_url();?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"></path>
</svg>Home</a></li>-->
										<li><a href="<?php echo base_url('about-us');?>"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>About Us</a></li>
									<!--	<li><a href="<?php echo base_url('courses-offered');?>"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
  <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/>
  <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/>
</svg>Courses Offered</a></li>-->
										<li><a href="<?php echo base_url('blog');?>"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" fill="currentColor" width="20" height="20" viewBox="0 0 30 30">
    <path d="M 6 4 C 4.895 4 4 4.895 4 6 L 4 24 C 4 25.105 4.895 26 6 26 L 24 26 C 25.105 26 26 25.105 26 24 L 26 6 C 26 4.895 25.105 4 24 4 L 6 4 z M 12.308594 8 L 15 8 C 17.38 8 19.325594 9.9567969 19.308594 12.341797 C 19.303594 12.923797 19.802766 13.384766 20.384766 13.384766 L 20.923828 13.384766 C 21.518828 13.384766 22 13.867891 22 14.462891 L 22 17.691406 C 22 20.061406 20.061406 22 17.691406 22 L 12.306641 22 C 9.9376406 22 8 20.061406 8 17.691406 L 8 15 L 8 12.308594 C 8 9.9385938 9.9385938 8 12.308594 8 z M 12.308594 11.230469 C 11.716594 11.230469 11.230469 11.716594 11.230469 12.308594 C 11.230469 12.900594 11.716594 13.384766 12.308594 13.384766 L 15 13.384766 C 15.592 13.384766 16.076172 12.900594 16.076172 12.308594 C 16.076172 11.716594 15.592 11.230469 15 11.230469 L 12.308594 11.230469 z M 12.306641 16.615234 C 11.714641 16.615234 11.230469 17.099406 11.230469 17.691406 C 11.230469 18.283406 11.714641 18.769531 12.306641 18.769531 L 17.691406 18.769531 C 18.283406 18.769531 18.769531 18.283406 18.769531 17.691406 C 18.769531 17.099406 18.284406 16.615234 17.691406 16.615234 L 12.306641 16.615234 z"></path>
</svg>Blog</a></li>
										<!--<li class="has_submenu">
											<a href="javascript:void(0);">Gallery</a>
											<ul class="sub_menu">
												<li><a href="<?php echo base_url('gallery');?>">Photos</a></li>
												<li><a href="<?php echo base_url('video-gallery');?>">Videos</a></li>
											</ul>
										</li>
										<li><a href="<?php echo base_url('facilities');?>">Facilities</a></li>-->
										<li><a href="<?php echo base_url('contact-us');?>"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" role="img" width="16" height="16"><path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 0v64h64V96H64zm384 0H192v64H448V96zM64 224v64h64V224H64zm384 0H192v64H448V224zM64 352v64h64V352H64zm384 0H192v64H448V352z"></path></svg>Contact Us</a></li>
									</ul>
									<?php if(!empty($_SESSION['role'])){ ?>
									    <?php if($_SESSION['role']==1){ ?>
									    <div class="user-login-btn d-lg-none d-block">
									    <li class="d-lg-inline-block d-md-inline-block"><a href="<?php echo base_url('admin/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    </div>
									    <?php }elseif($_SESSION['role']=="student"){ ?>
									    <div class="user-login-btn d-lg-none d-block">
									       	<li class="d-lg-inline-block d-md-inline-block"><a href="<?php echo base_url('student/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									     </div>
									    <?php }else{ ?>
									    <div class="user-login-btn d-lg-none d-block">
									       <li class="d-lg-inline-block d-md-inline-block"><a href="<?php echo base_url('teacher/dashboard');?>"><?php echo "Dashboard"; ?></a></li>
									    </div>
									    <?php } ?>
									<div class="user-login-btn d-lg-none d-block">
									    <li class="d-lg-inline-block d-md-inline-block"><a href="javascript:void(0);" title="<?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?>" class="cnfmlogOutBtn">
									    <i class="icofont-logout"></i><span><?php echo html_escape($this->common->languageTranslator('ltr_logout')); ?></span></a></li>
									</div>
									<?php }else{?>
									<div class="user-login-btn d-lg-none d-block">
									    <a href="<?php echo base_url('login');?>"><?php echo html_escape($this->common->languageTranslator('ltr_login')); ?></a> 
								    	<a href="<?php echo base_url('register');?>"><?php echo html_escape($this->common->languageTranslator('ltr_register_now')); ?></a>
									</div>
									<?php } ?>
								</div>
								<div class="menu_btn_wrap">
								<?php 
								if(!empty($frontend_details[0]['header_btn_txt']) && !empty($frontend_details[0]['header_btn_url'])){
									echo '<a class="edu_btn" href="'.$frontend_details[0]['header_btn_url'].'">'.$frontend_details[0]['header_btn_txt'].'</a>';
								}
								?>
									<a href="javascript:void(0);" class="menu_btn">
										<span></span>
										<span></span>
										<span></span>
									</a>
								</div>
							</div>
           
    </div>
  <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 mt-3 offset-md-2">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
          // Using jQuery
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('onlineClassModal');
    var btn = document.getElementById('onlineClassBtn');
    var span = document.getElementsByClassName('close')[0];

    console.log('Script Loaded'); // Check if the script is loading

    // Open modal when button is clicked
    btn.onclick = function() {
        console.log('Button Clicked'); // Check if the button click is detected
        modal.style.display = 'block';
    }

    // Close modal when the close button (x) is clicked
    span.onclick = function() {
        console.log('Close Clicked'); // Check if the close click is detected
        modal.style.display = 'none';
    }

    // Close modal when clicking outside of the modal content
    window.onclick = function(event) {
        if (event.target == modal) {
            console.log('Outside Clicked'); // Check if clicking outside the modal is detected
            modal.style.display = 'none';
        }
    }
});

      </script>