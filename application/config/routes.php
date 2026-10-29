<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* Admin routes */
$route['admin/dashboard'] = 'admin_profile/index';
$route['admin/change-password'] = 'admin_profile/profile';
$route['admin/course-manage'] = 'admin_profile/course_manage';
$route['admin/add-batch'] = 'admin_profile/add_batch';
$route['admin/add-batch/(:any)'] = 'admin_profile/add_batch/$1';
$route['admin/batch-manage'] = 'admin_profile/batch_manage';
$route['admin/batch-cat-manage'] = 'admin_profile/batch_cat_manage';
$route['admin/batch-subcat-manage'] = 'admin_profile/batch_subcat_manage';
$route['admin/blog-cat-manage'] = 'admin_profile/blog_cat_manage';
$route['admin/blog-subcat-manage'] = 'admin_profile/blog_subcat_manage';
$route['admin/student-manage'] = 'admin_profile/student_manage';
$route['admin/add-student'] = 'admin_profile/add_student';
$route['admin/add-student/(:any)'] = 'admin_profile/add_student/$1';
$route['admin/subject-manage'] = 'admin_profile/subject_manage';
$route['admin/question-manage'] = 'admin_profile/question_manage';
$route['admin/notice-manage'] = 'admin_profile/notice_manage';
$route['admin/vacancy-manage'] = 'admin_profile/vacancy_manage';
$route['admin/video-manage'] = 'admin_profile/video_manage';
$route['admin/video-assessment/(:num)'] = 'video_assessment/index/$1';
$route['admin/enquiry'] = 'admin_profile/enquiry';
$route['admin/timezone'] = 'admin_profile/timezone';
$route['admin/teacher-manage'] = 'admin_profile/teacher_manage';
$route['admin/teacher-progress/(:any)'] = 'admin_profile/teacher_progress/$1';
$route['admin/teacher-academic-record/(:any)'] = 'admin_profile/teacher_academic_record/$1';
$route['admin/extra-classes'] = 'admin_profile/extra_classes';
$route['admin/create-paper'] = 'admin_profile/create_exam';
$route['admin/exam-manage'] = 'admin_profile/exam_manage';
$route['admin/practice-result'] = 'admin_profile/practice_result';
$route['admin/mock-result'] = 'admin_profile/mock_result';
$route['admin/view-paper/(:any)'] = 'admin_profile/view_paper/$1';
$route['admin/student-notice/(:any)'] = 'admin_profile/student_notice/$1';
$route['admin/teacher-notice/(:any)'] = 'admin_profile/teacher_notice/$1';
$route['admin/answer-sheet/(:any)/(:any)'] = 'admin_profile/answer_sheet/$1/$2';
$route['admin/facility-manage'] = 'admin_profile/facility_manage';
$route['admin/gallery-manage'] = 'admin_profile/gallery_manage';
$route['admin/signup-login-banners'] = 'admin_profile/signup_login_banners';
$route['admin/home-banners'] = 'admin_profile/home_banners';
$route['admin/batch-banners'] = 'admin_profile/batch_banners';
$route['admin/site-settings'] = 'admin_profile/site_settings';
$route['admin/contact-page'] = 'admin_profile/contact_page';
$route['admin/facility-page'] = 'admin_profile/facility_page';
$route['admin/course-page'] = 'admin_profile/course_page';
$route['admin/about-page'] = 'admin_profile/about_page';
$route['admin/home-page'] = 'admin_profile/home_page';
$route['admin/manage-student-leave'] = 'admin_profile/manage_student_leave';
$route['admin/manage-teacher-leave'] = 'admin_profile/manage_teacher_leave';
$route['admin/student-progress/(:any)'] = 'admin_profile/student_progress/$1';
$route['admin/student-academic-record/(:any)'] = 'admin_profile/student_academic_record/$1';
$route['admin/live-class'] = 'admin_profile/live_class';
$route['admin/start-class'] = 'admin_profile/start_class';
$route['admin/end_metting/(:any)'] = 'admin_profile/end_metting/$1';
$route['admin/live-class-history'] = 'admin_profile/live_class_history';
$route['admin/student-attendance/(:any)'] = 'admin_profile/student_attendance/$1';
$route['admin/student-attendance-extra-class/(:any)'] = 'admin_profile/student_attendance_extra_class/$1';

$route['admin/certificate'] = 'admin_profile/certificate';
$route['admin/privacy-policy'] = 'admin_profile/privacy_policy';
$route['admin/terms-conditions'] = 'admin_profile/terms_conditions';
$route['admin/view-certificate'] = 'admin_profile/view_certificate';
$route['admin/view-certificate/(:any)/(:any)'] = 'admin_profile/view_certificate/$1/$2';
$route['admin/doubts-class/(:any)'] = 'admin_profile/doubts_class/$1';
$route['admin/doubts-ask/(:any)'] = 'admin_profile/doubts_ask/$1';
$route['admin/payment-history'] = 'admin_profile/payment_history';
$route['admin/payment-settings'] = 'admin_profile/payment_settings';
$route['admin/language-settings'] = 'admin_profile/language_settings';
$route['admin/email-settings'] = 'admin_profile/email_settings';
$route['admin/firebase-settings'] = 'admin_profile/firebase_settings';
$route['admin/refer-settings'] = 'admin_profile/refer_settings';
$route['admin/withdrawal-history'] = 'admin_profile/withdrawal_history';
$route['admin/referral-history'] = 'admin_profile/referral_history';
$route['admin/referral-detail/(:any)'] = 'admin_profile/referral_detail_by_id/$1';
$route['admin/blog-manage'] = 'admin_profile/blog_manage';
$route['admin/blog-reply/(:any)'] = 'admin_profile/blog_reply/$1';
$route['admin/add-question'] = 'admin_profile/add_question';
$route['admin/add-question/(:any)'] = 'admin_profile/add_question/$1';
$route['admin/doubts-classes'] = 'admin_profile/student_doubts_class';
$route['admin/manage-revanue'] = 'admin_profile/manage_revanue';
//new
$route['admin/book-manage'] = 'admin_profile/book_manage';
$route['admin/notes-manage'] = 'admin_profile/notes_manage';
$route['admin/library-manage'] = 'admin_profile/library_manage';
$route['admin/book-request'] = 'admin_profile/book_request';
$route['admin/file-view/(:any)/(:any)'] = 'admin_profile/file_view/$1/$2';
$route['admin/old-paper'] = 'admin_profile/old_paper';
$route['admin/student-manage-certificate'] = 'admin_profile/manage_certificate';
$route['admin/student-manage-certificate/(:any)'] = 'admin_profile/manage_certificate/$1';
$route['admin/view-certificate-sample'] = 'admin_profile/view_certificate_demo';
$route['admin/manage-admin'] = 'admin_profile/manage_admin';
$route['admin/institute-details'] = 'admin_profile/institure_details';
$route['admin/notification'] = 'admin_profile/notification_manage';
$route['admin/comment-manage/(:any)'] = 'admin_profile/comment_manage/$1';
$route['admin/playlist-manage/(:any)'] = 'admin_profile/playlist_manage/$1';



$route['admin/folder-manage/(:any)'] = 'admin_profile/folder_manage/$1';
$route['admin/recorded-video-manage'] = 'admin_profile/recorded_video_manage';
$route['admin/study-material-manage'] = 'admin_profile/study_material_manage';
$route['admin/study-folder-manage/(:any)'] = 'admin_profile/study_material_folder_manage/$1';
$route['admin/free-quiz-manage'] = 'admin_profile/free_quiz_create';
$route['admin/free-quiz-exam-manage'] = 'admin_profile/free_quiz_exam_manage';

$route['admin/coupon-manage'] = 'admin_profile/coupon_manage';
$route['admin/coupon-student-apply-manage'] = 'admin_profile/coupon_student_apply_manage';

$route['admin/free-quiz-result'] = 'admin_profile/free_quiz_result';
$route['admin/device-manage'] = 'admin_profile/device_manage';
$route['admin/web-device-manage'] = 'admin_profile/web_device_manage';
$route['admin/device-settings'] = 'admin_profile/device_settings';
$route['admin/device-settings-save'] = 'admin_profile/device_settings_save';
$route['admin/web_device-settings-save'] = 'admin_profile/web_device_settings_save';
$route['admin/student-bulk-upload'] = 'admin_profile/student_bulk_upload';
$route['admin/student-exports'] = 'admin_profile/student_exports_data';
$route['admin/bundle-manage'] = 'admin_profile/bundle_manage';
$route['admin/audio-manage'] = 'admin_profile/audio_manage';


/* Teacher routes */
$route['teacher/add-question'] = 'teacher_profile/add_question';
$route['teacher/add-question/(:any)'] = 'teacher_profile/add_question/$1';
$route['teacher/dashboard'] = 'teacher_profile/index';
$route['teacher/profile'] = 'teacher_profile/profile';
$route['teacher/video-manage'] = 'teacher_profile/video_manage';
$route['teacher/question-manage'] = 'teacher_profile/question_manage';
$route['teacher/exam-manage'] = 'teacher_profile/exam_manage';
$route['teacher/view-paper/(:any)'] = 'teacher_profile/view_paper/$1';
$route['teacher/practice-result'] = 'teacher_profile/practice_result';
$route['teacher/mock-result'] = 'teacher_profile/mock_result';
$route['teacher/extra-classes'] = 'teacher_profile/extra_classes';
$route['teacher/homework-manage'] = 'teacher_profile/homework_manage';
$route['teacher/homework-manage/(:any)'] = 'teacher_profile/homework_manage/$1';
$route['teacher/notice'] = 'teacher_profile/notice';
$route['teacher/progress'] = 'teacher_profile/progress';
$route['teacher/academic-record'] = 'teacher_profile/academic_record';
$route['teacher/student-details'] = 'teacher_profile/student_details';
$route['teacher/student-notice/(:any)'] = 'teacher_profile/student_notice/$1';
$route['teacher/answer-sheet/(:any)/(:any)'] = 'teacher_profile/answer_sheet/$1/$2';
$route['teacher/apply-leave'] = 'teacher_profile/apply_leave';
$route['teacher/live-class'] = 'teacher_profile/live_class';
$route['teacher/start_live_class'] = 'teacher_profile/start_live_class';
$route['teacher/student-progress/(:any)'] = 'teacher_profile/student_progress/$1';
$route['teacher/student-academic-record/(:any)'] = 'teacher_profile/student_academic_record/$1';
$route['teacher/create-exam'] = 'teacher_profile/create_exam';
$route['teacher/start-class'] = 'teacher_profile/start_class';
$route['teacher/end_metting/(:any)'] = 'teacher_profile/end_metting/$1';
$route['teacher/student-attendance/(:any)'] = 'teacher_profile/student_attendance/$1';
$route['teacher/student-attendance-extra-class/(:any)'] = 'teacher_profile/student_attendance_extra_class/$1';
$route['teacher/doubts-class'] = 'teacher_profile/student_doubts_class';
$route['teacher/doubts-ask/(:any)'] = 'teacher_profile/doubts_ask/$1';
//new
$route['teacher/book-manage'] = 'teacher_profile/book_manage';
$route['teacher/notes-manage'] = 'teacher_profile/notes_manage';
$route['teacher/file-view/(:any)/(:any)'] = 'teacher_profile/file_view/$1/$2';
$route['teacher/old-paper'] = 'teacher_profile/old_paper';
$route['teacher/manage-student-leave'] = 'teacher_profile/manage_student_leave';

/* Student routes */
$route['student/dashboard'] = 'student_profile/index';
$route['student/profile'] = 'student_profile/profile';
$route['student/homework'] = 'student_profile/homework';
$route['student/video-lecture'] = 'student_profile/video_lecture';
$route['student/vacancy'] = 'student_profile/vacancy';
$route['student/extra-classes'] = 'student_profile/extra_classes';
$route['student/notice'] = 'student_profile/notice';
$route['student/notification'] = 'student_profile/notification';
$route['student/practice-paper'] = 'student_profile/practice_paper';
$route['student/mock-paper'] = 'student_profile/mock_paper';
$route['student/practice-result'] = 'student_profile/practice_result';
$route['student/mock-result'] = 'student_profile/mock_result';
$route['student/answer-sheet/(:any)/(:any)/(:any)'] = 'student_profile/answer_sheet/$1/$2/$3';
$route['student/apply-leave'] = 'student_profile/apply_leave';
$route['student/view-progress'] = 'student_profile/view_progress';
$route['student/academic-record'] = 'student_profile/academic_record';
$route['student/start-class/(:any)'] = 'student_profile/start_class/$1';
$route['student/attendance'] = 'student_profile/student_attendance';
$route['student/certificate'] = 'student_profile/certificate';
$route['student/doubts-ask'] = 'student_profile/doubts_ask';


$route['student/notice1'] = 'student_profile/notice1';
$route['student/mcq'] = 'student_profile/mcq';
$route['student/video-lecture1'] = 'student_profile/video_lecture1';
$route['student/book1'] = 'student_profile/book1';
$route['student/notes1'] = 'student_profile/notes1';
$route['student/old-paper1'] = 'student_profile/old_paper1';
$route['student/homework1'] = 'student_profile/homework1';
$route['student/doubts-ask1'] = 'student_profile/doubts_ask1';

//hans
$route['student/descriptive-paper'] = 'student_profile/descriptive_paper';
$route['student/descriptive-result'] = 'student_profile/descriptive_result';
$route['student/video-lecture1'] = 'student_profile/video_lecture1';

//new
$route['student/book'] = 'student_profile/book';
$route['student/notes'] = 'student_profile/notes';
$route['student/book-request'] = 'student_profile/book_request';
$route['student/file-view/(:any)/(:any)'] = 'student_profile/file_view/$1/$2';
$route['student/courses-data/(:any)'] = 'student_profile/courses_data/$1';
$route['student/my-course'] = 'student_profile/my_course';
$route['student/select-course/(:any)'] = 'student_profile/select_course/$1';
$route['student/old-paper'] = 'student_profile/old_paper';
$route['student/dashboard-student'] = 'student_profile/dashboard_student';
$route['student/syllabus/(:any)'] = 'student_profile/all_syllabus/$1';
$route['student/select-dashboard'] = 'student_profile/select_dashboard';
$route['student/student-certificate/(:any)'] = 'student_profile/certificate_view/$1';
$route['admin/descriptive-result'] = 'admin_profile/descriptive_result';


/* Front End Routes */
$route['login'] = 'home/login';
$route['register'] = 'home/register';
$route['batchregister/(:num)'] = 'home/purchase_register/$1';
$route['forgot-password'] = 'home/forgot_password';
$route['about-us'] = 'home/about';
$route['courses-offered'] = 'home/courses';
$route['courses-details/(:any)'] = 'home/courses_details/$1';
$route['enroll-now/(:num)'] = 'home/enroll_now/$1';
$route['success'] = 'home/paypal_success';
$route['paypal-ipn'] = 'home/paypal_ipn';
$route['cancel'] = 'home/paypal_cancel';
$route['buy-now/(:any)'] = 'home/paypal_form/$1';
$route['theme1'] = 'home/theme1';

$route['blog'] = 'home/blog';
$route['blog/(:any)'] = 'home/blog/$1';
$route['facilities'] = 'home/facilities';
$route['gallery'] = 'home/gallery';
$route['video-gallery'] = 'home/video_gallery';
$route['contact-us'] = 'home/contact';
$route['privacy-policy'] = 'home/privacypolicy';
$route['privacyandpolicy'] = 'home/privacyandpolicy';
$route['term-condition'] = 'home/termscondition';
$route['shipping-policy'] = 'home/shippingpolicy';
$route['refund-policy'] = 'home/refundpolicy';

// Update By shubham 7 April
$route['admin/batchActivation'] = 'admin_profile/batchActivation_manage';
$route['admin/batchActivationCodeList/(:any)'] = 'admin_profile/batchcodeList_manage/$1';



