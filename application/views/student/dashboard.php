<style>
     
       .block {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .block-icon {
            font-size: 24px;
            margin-right: 15px;
        }
        .block-name {
            flex-grow: 1;
        }
       .arrow-btn {
    background-color: white;
    color: black;
    border: none;
    border-radius: 50%; /* Make it a circle */
    width: 40px; /* Adjust size as needed */
    height: 40px; /* Adjust size as needed */
    display: flex;
    align-items: center; /* Center content vertically */
    justify-content: center; /* Center content horizontally */
    cursor: pointer;
    font-size: 14px;
    padding: 0; /* Remove default padding */
    text-align: center; /* Center text horizontally */
}

.arrow-btn i {
    font-size: 18px;
     margin-right:0 !important;
}

        .arrow-btn:hover {
            background-color: #0056b3;
        }
        .block h1, .block h3 {
            margin: 0;
            color: white;
            font-size: 19px;
        }
        
        .block-icon img{
            height:45px;
        }
        
        .block-link {
    display: block;
    text-decoration: none; /* Remove underline from the link */
}
   
</style>

<style>
.sd-hero {
    position: relative; overflow: hidden; display: flex; align-items: center; justify-content: space-between; gap: 24px;
    margin: 0 15px 30px; padding: 30px 34px; border-radius: 26px; color: #fff;
    background: linear-gradient(120deg, #5b6cff 0%, #8f7bff 55%, #ff8fb1 100%);
    box-shadow: 0 14px 34px rgba(91, 108, 255, .28);
}
.sd-hero:before, .sd-hero:after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.13); }
.sd-hero:before { width: 260px; height: 260px; right: -70px; top: -110px; }
.sd-hero:after { width: 150px; height: 150px; left: 42%; bottom: -90px; }
.sd-hero-text { position: relative; z-index: 1; }
.sd-hero-tag { display: inline-block; font-size: 13px; font-weight: 800; padding: 5px 14px; border-radius: 999px; background: rgba(255,255,255,.2); margin-bottom: 12px; }
.sd-hero h2 { color: #fff; font-size: 32px; font-weight: 600; margin: 0 0 8px; }
.sd-hero p { font-size: 16px; margin: 0 0 18px; padding: 0; opacity: .95; }
.sd-hero p strong { font-weight: 800; }
.sd-hero-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 999px; background: #fff; color: #5b6cff !important; font-weight: 800; text-decoration: none !important; box-shadow: 0 6px 16px rgba(31,42,77,.15); transition: transform .15s ease; }
.sd-hero-btn:hover { transform: translateY(-2px); }
.sd-hero-art { position: relative; z-index: 1; flex: 0 0 auto; width: 170px; height: 130px; border-radius: 22px; background: rgba(255,255,255,.95); display: flex; align-items: center; justify-content: center; padding: 14px; box-shadow: 0 12px 26px rgba(31,42,77,.18); transform: rotate(3deg); animation: sd-float 6s ease-in-out infinite; }
.sd-hero-art img { max-width: 100%; max-height: 100%; object-fit: contain; }
@keyframes sd-float { 0%,100% { transform: rotate(3deg) translateY(0); } 50% { transform: rotate(3deg) translateY(-8px); } }
.sd-wave { display: inline-block; animation: sd-wave 2.4s ease-in-out infinite; transform-origin: 70% 70%; }
@keyframes sd-wave { 0%,60%,100% { transform: rotate(0); } 10%,30% { transform: rotate(16deg); } 20%,40% { transform: rotate(-8deg); } }

.sd-section-title { margin: 6px 15px 16px; display: flex; align-items: center; gap: 10px; font-family: var(--pk-font-head, inherit); font-size: 21px; font-weight: 600; color: #1f2a4d; }
.sd-section-title:before { content: ""; width: 8px; height: 22px; border-radius: 999px; background: linear-gradient(180deg, #5b6cff, #9b7bff); }
.sd-tiles { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 22px; margin: 0 15px 34px; }
.sd-tile {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 22px; padding: 24px;
    border-radius: 26px; background: #fff; text-decoration: none !important; color: #1f2a4d !important;
    box-shadow: 0 8px 22px rgba(31,42,77,.07); border: 2px solid transparent;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
.sd-tile:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(31,42,77,.14); border-color: #ff9f1a; }
.sd-tile-main { background: linear-gradient(135deg, #fff8ec 0%, #ffe9d6 100%); }
.sd-tile-main:after { content: ""; position: absolute; right: -40px; bottom: -40px; width: 140px; height: 140px; border-radius: 50%; background: rgba(255, 159, 26, .14); }
.sd-tile-art { flex: 0 0 auto; width: 96px; height: 96px; border-radius: 24px; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 18px rgba(255, 138, 61, .22); transition: transform .25s ease; }
.sd-tile-art img { width: 62px; height: 62px; object-fit: contain; }
.sd-tile:hover .sd-tile-art { transform: rotate(-6deg) scale(1.05); }
.sd-tile-body { position: relative; z-index: 1; }
.sd-tile-body h3 { font-size: 23px; font-weight: 600; margin: 0 0 6px; color: #1f2a4d; }
.sd-tile-body p { margin: 0 0 14px; padding: 0; color: #7a84a3; font-size: 14.5px; font-weight: 600; }
.sd-tile-btn { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 999px; background: linear-gradient(120deg, #ff8a3d, #ff5c8a); color: #fff; font-weight: 800; box-shadow: 0 6px 14px rgba(255, 92, 138, .3); }
.sd-arrow { transition: transform .2s ease; }
.sd-tile:hover .sd-arrow { transform: translateX(4px); }

.sd-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin: -6px 15px 32px; }
.sd-stat { display: flex; align-items: center; gap: 14px; padding: 16px 18px; border-radius: 22px; background: #fff; box-shadow: 0 8px 22px rgba(31,42,77,.07); border-bottom: 4px solid var(--c); transition: transform .2s ease; }
.sd-stat:hover { transform: translateY(-3px); }
.sd-stat-icon { flex: 0 0 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 26px; background: var(--soft); }
.sd-stat strong { display: block; font-family: var(--pk-font-head, inherit); font-size: 28px; font-weight: 600; line-height: 1.1; color: var(--c); }
.sd-stat span:not(.sd-stat-icon) { font-size: 13.5px; font-weight: 700; color: #7a84a3; }
.sd-c-blue   { --c: #5b6cff; --soft: #eef0ff; }
.sd-c-orange { --c: #ff8a3d; --soft: #fff3dc; }
.sd-c-yellow { --c: #e0a100; --soft: #fff8d6; }
.sd-c-green  { --c: #16a374; --soft: #dff7ee; }
.sd-tile-alt { background: linear-gradient(135deg, #eef0ff 0%, #f3ecff 100%); }
.sd-tile-alt:hover { border-color: #8f7bff; }
.sd-tile-alt:after { content: ""; position: absolute; right: -40px; bottom: -40px; width: 140px; height: 140px; border-radius: 50%; background: rgba(91,108,255,.10); }
.sd-tile-emoji { font-size: 50px; line-height: 1; }
.sd-tile-btn-alt { background: linear-gradient(120deg, #5b6cff, #9b7bff); box-shadow: 0 6px 14px rgba(91,108,255,.3); }
.sd-recent { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 14px; margin: 0 15px 34px; }
.sd-recent-item { display: flex; align-items: center; gap: 14px; padding: 14px 18px; border-radius: 20px; background: #fff; box-shadow: 0 4px 14px rgba(31,42,77,.06); }
.sd-recent-icon { flex: 0 0 44px; height: 44px; border-radius: 14px; background: #fff3dc; display: flex; align-items: center; justify-content: center; font-size: 22px; }
.sd-recent-body { flex: 1; min-width: 0; }
.sd-recent-body strong { display: block; font-family: var(--pk-font-head, inherit); font-size: 16px; font-weight: 600; color: #1f2a4d; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sd-recent-body span { font-size: 13px; font-weight: 700; color: #7a84a3; }
.sd-stars { white-space: nowrap; font-size: 20px; }
.sd-star { color: #e6e8f2; }
.sd-star.on { color: #ffc23d; }
.sd-empty { display: flex; align-items: center; gap: 14px; margin: 0 15px 34px; padding: 18px 22px; border-radius: 20px; background: #fffbea; border: 2px dashed #ffe08a; }
.sd-empty span { font-size: 30px; }
.sd-empty p { margin: 0; padding: 0; color: #8a6a00; font-weight: 700; }

@media (max-width: 1100px) { .sd-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 767px) {
    .sd-stats { margin: -4px 0 24px; gap: 12px; }
    .sd-stat { padding: 12px; gap: 10px; }
    .sd-stat-icon { flex-basis: 40px; height: 40px; font-size: 20px; }
    .sd-stat strong { font-size: 22px; }
    .sd-recent, .sd-empty { margin: 0 0 24px; }
    .sd-recent { grid-template-columns: 1fr; }
    .sd-hero { margin: 0 0 22px; padding: 22px 20px; flex-direction: column; align-items: flex-start; }
    .sd-hero h2 { font-size: 25px; }
    .sd-hero-art { width: 120px; height: 92px; align-self: flex-end; margin-top: -10px; }
    .sd-tiles { grid-template-columns: 1fr; margin: 0 0 24px; }
    .sd-section-title { margin: 0 0 14px; }
    .sd-tile { padding: 18px; gap: 16px; }
    .sd-tile-art { width: 76px; height: 76px; }
    .sd-tile-art img { width: 48px; height: 48px; }
}
@media (prefers-reduced-motion: reduce) { .sd-wave, .sd-hero-art { animation: none; } }
</style>
<section class="edu_admin_content">
	<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
	    	 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
	    	     
	    	     <?php /* course name now shown in the welcome banner below */ ?>

    		 <!--   	<div class="form-group">-->
							<!--<span>-->
                                <!--<select class="form-control filter_stud_batches edu_selectbox_with_search" name="filter_stud_batches" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?>" data-count="no">-->
                                <!--    <option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_batch'));?></option>-->
                                    <?php
                                    // if(!empty($batch_details)){
                                    //     foreach($batch_details as $batch){
                                    //         echo '<option value="'.$batch['id'].'">'.$batch['batch_name'].'</option>';
                                    //     }
                                    // }
                                    ?>          
      <!--                          </select>-->
						<!--	</span>-->
						<!--</div>-->
						</div>
						
						
						<?php
						    $sd_name  = $this->session->userdata('name');
						    $sd_first = $sd_name ? ucwords(strtolower(strtok(trim($sd_name), ' '))) : 'there';
						    $sd_batch = !empty($batch_data[0]) ? $batch_data[0] : array();
						    $sd_image = !empty($sd_batch['batch_image']) ? base_url('uploads/batch_image/' . $sd_batch['batch_image']) : html_escape($this->common->siteLogo);

						    // "My learning" numbers
						    $sd_uid     = (int) $this->session->userdata('uid');
						    $sd_courses = $this->db->where('student_id', $sd_uid)->count_all_results('sudent_batchs');
						    $sd_quizzes = 0; $sd_stars = 0; $sd_best = null; $sd_recent = array();
						    if ($this->db->table_exists('video_assessment_attempts')) {
						        $sd_attempts = $this->db->select('a.video_id, a.score, a.total_marks, a.created_at, v.title')
						            ->from('video_assessment_attempts a')
						            ->join('video_lectures v', 'v.id = a.video_id', 'left')
						            ->where('a.student_id', $sd_uid)->order_by('a.id', 'desc')->get()->result_array();
						        $sd_best_by_video = array();
						        foreach ($sd_attempts as $at) {
						            $pct = $at['total_marks'] > 0 ? $at['score'] / $at['total_marks'] : 0;
						            if (!isset($sd_best_by_video[$at['video_id']]) || $pct > $sd_best_by_video[$at['video_id']]) {
						                $sd_best_by_video[$at['video_id']] = $pct;
						            }
						            if (count($sd_recent) < 4 && !isset($sd_recent[$at['video_id']])) {
						                $sd_recent[$at['video_id']] = $at + array('pct' => $pct);
						            }
						        }
						        $sd_quizzes = count($sd_best_by_video);
						        foreach ($sd_best_by_video as $pct) {
						            $sd_stars += $pct >= 0.9 ? 3 : ($pct >= 0.6 ? 2 : ($pct > 0 ? 1 : 0));
						        }
						        $sd_best = $sd_best_by_video ? round(max($sd_best_by_video) * 100) : null;
						    }
						    $sd_star_html = function ($pct) {
						        $n = $pct >= 0.9 ? 3 : ($pct >= 0.6 ? 2 : ($pct > 0 ? 1 : 0));
						        $out = '';
						        for ($i = 0; $i < 3; $i++) { $out .= '<span class="sd-star' . ($i < $n ? ' on' : '') . '">&#9733;</span>'; }
						        return $out;
						    };
						?>
						<div class="sd-hero">
						    <div class="sd-hero-text">
						        <span class="sd-hero-tag">&#127890; My Classroom</span>
						        <h2>Hi <?php echo html_escape($sd_first); ?>! <span class="sd-wave">&#128075;</span></h2>
						        <p>You're learning <strong><?php echo html_escape(isset($sd_batch['batch_name']) ? $sd_batch['batch_name'] : ''); ?></strong>. Let's have fun today!</p>
						        <a class="sd-hero-btn" href="<?php echo base_url('student/my-course'); ?>">&#8644; Change course</a>
						    </div>
						    <div class="sd-hero-art"><img src="<?php echo $sd_image; ?>" alt="<?php echo html_escape(isset($sd_batch['batch_name']) ? $sd_batch['batch_name'] : 'Course'); ?>"></div>
						</div>
						<div class="sd-stats">
						    <div class="sd-stat sd-c-blue"><span class="sd-stat-icon">&#127890;</span><div><strong><?php echo (int) $sd_courses; ?></strong><span>My courses</span></div></div>
						    <div class="sd-stat sd-c-orange"><span class="sd-stat-icon">&#129504;</span><div><strong><?php echo (int) $sd_quizzes; ?></strong><span>Quizzes done</span></div></div>
						    <div class="sd-stat sd-c-yellow"><span class="sd-stat-icon">&#11088;</span><div><strong><?php echo (int) $sd_stars; ?></strong><span>Stars earned</span></div></div>
						    <div class="sd-stat sd-c-green"><span class="sd-stat-icon">&#127942;</span><div><strong><?php echo $sd_best === null ? '&ndash;' : $sd_best . '%'; ?></strong><span>Best score</span></div></div>
						</div>
						<div id="student_batch_data">
						    <div class="slider-img" style="display: block;">
						        <!--  <div id="demo" class="carousel slide" data-ride="carousel"> -->

                              <!-- Indicators 
                              <ul class="carousel-indicators">
                                <li data-target="#demo" data-slide-to="0" class="active"></li>
                                <li data-target="#demo" data-slide-to="1"></li>
                                <li data-target="#demo" data-slide-to="2"></li>
                              </ul>-->
                              
                              <!-- The slideshow -->
                              <?php
                              


$this->db->select('*');
$this->db->from('batch_banners USE INDEX (id)');
$this->db->join('batch_banners_details', 'batch_banners_details.batch_banners_id = batch_banners.id');
$this->db->where('batch_banners.status', '1');
$this->db->where('batch_banners_details.batch_id', $batch_id);
$this->db->where('batch_banners.admin_id', '1');
$this->db->order_by('batch_banners.id', 'DESC');
$this->db->limit(3);

$homeBanner = $this->db->get()->result_array();


                              ?>
                              <div class="carousel-inner">
                                <!--<div class="carousel-item active">-->
                                 <?php /* <img src="uploads/batch_banners/LMH.png" alt="banner-imgone" /> */ ?>  
                                <!--</div> -->
                                   <?php  $i=1;
                                   foreach($homeBanner as $baner){ 
                                   $activeCls="";
                                   if($i==1){
                                   $activeCls=" active";
                                   }?>
                                <div class="carousel-item <?php echo $activeCls;?>">
                                 <img src="<?php echo base_url('uploads/batch_banners/');?><?php echo $baner['banner'];?>" alt="banner-imgone" />
                                </div>
                                <?php $i++;} ?>
                              </div>
                              <!-- The slideshow end-->
                              <!-- Left and right controls -->
                             <!--  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                              </a>
                              <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                              </a>-->
                            </div>
						        
						    </div>
	    <?php
	    if(!empty($paper_list)){
	        $paper=$paper_list[0];
	    $resultArr = $this->db_model->select_data('id','mock_result use index (id)',array('student_id'=>$this->session->userdata('uid'),'paper_id'=>$paper['id']),1);

                        if(empty($resultArr)){
                            $start_time = $paper['mock_sheduled_date'].' '.$paper['mock_sheduled_time'];
                            $new_dateTime = date('M d, Y h:i:s A',strtotime($start_time));
                            $end_time = date('Y-m-d H:i:s', strtotime($start_time.' +'.$paper['time_duration'].' minutes'));
                        
                            if(date('Y-m-d H:i:s') <= $end_time){
                            
                            ?>
                                <div class="sectionHolder mockPaperTimerWrapper mb_30 text-center">
                                    <span class="mock_actual_date hide"><?php echo html_escape($new_dateTime);?></span>
                                    <div class="edu_main_wrapper">
                                        <div class="edu_question_paper_infomation">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                    <div class="edu_paper_info responsive_center">
                                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_paper_name'));?>:</span><span class="paperName"><?php echo html_escape($paper['name']);?></span></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                    <div class="edu_paper_info responsive_center text-center">
                                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_total_questions'));?>:</span><span class="totalQuest"><?php echo html_escape($paper['total_question']);?></span></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                    <div class="edu_paper_info responsive_center text-right">
                                                        <p><span class="edu_paper_smallinfo"><?php echo html_escape($this->common->languageTranslator('ltr_total_time'));?>:</span><span class="totalTime"><?php echo html_escape($paper['time_duration']);?></span> Min.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mockPaperTimer hide">
                                                <ul class="edu_sub_title edu_count_timer justify-content-center">
                                                    <li><span class="remain_days"></span> :</li>
                                                    <li><span class="remain_hours"></span> :</li>
                                                    <li><span class="remain_minutes"></span> :</li>
                                                    <li><span class="remain_seconds"></span></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center paperDescriptionDiv hide">
                                                <div class="edu_btn_wrapper edu_paper_continue_btn">
                                                    <strong><?php echo html_escape($this->common->languageTranslator('ltr_continue_exam'));?></strong>
                                                    <a href="<?php echo base_url()?>student/mock-paper" class="edu_admin_btn continuePaper"><?php echo html_escape($this->common->languageTranslator('ltr_open_exam'));?></a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php 
                            }
                        }
	    }
                        ?>
      
       <!--  <div class="row">
            <div class="col-md-4 mb-4">
    <a href="<?php echo base_url()?>student/notice1" class="block-link">
        <div class="block" style="background-color: #0f4d92; !important">
            <div class="block-icon">
                <img src="../assets/images/loudspeaker.png" alt="Announcement Icon" class="icon-image"> 
            </div>
            <div class="block-name">
                <h3 class="mb-0">Announcement</h3>
            </div>
            <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </a>
</div>-->
            <!-- <div class="col-md-4 mb-4">-->
            <!--     <a <a href="<?=(!empty($this->session->userdata('batch_id')))?base_url('student/start-class/').$this->session->userdata('batch_id'):'javascript:void(0)';?>" class="block-link">-->
            <!--    <div class="block" style="background-color: #0f4d92; !important" >-->
            <!--        <div class="block-icon">-->
            <!--          <img src="../assets/images/webinar.png" alt="Announcement Icon" class="icon-image"> -->
            <!--        </div>-->
            <!--        <div class="block-name">-->
            <!--            <h3 class="mb-0">Live Class</h3>-->
            <!--        </div>-->
            <!--        <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>-->
            <!--    </div>-->
            <!--    </a>-->
            <!--</div>-->
            <!-- <div class="col-md-4 mb-4">-->
            <!--      <a href="<?php echo base_url()?>student/mcq" class="block-link">-->
            <!--    <div class="block" style="background-color: #0f4d92; !important" >-->
            <!--        <div class="block-icon">-->
            <!--          <img src="../assets/images/test.png" alt="Announcement Icon" class="icon-image"> -->
            <!--        </div>-->
            <!--        <div class="block-name">-->
            <!--            <h3 class="mb-0">MCQ</h3>-->
            <!--        </div>-->
            <!--        <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>-->
            <!--    </div>-->
            <!--     </a>-->
            <!--</div>-->
           <div class="sd-section-title">What would you like to do?</div>
           <div class="sd-tiles">
                <a href="<?php echo base_url()?>student/video-lecture1" class="sd-tile sd-tile-main">
                    <div class="sd-tile-art"><img src="<?php echo base_url('assets/images/video-lecture.png'); ?>" alt=""></div>
                    <div class="sd-tile-body">
                        <h3>Course Content</h3>
                        <p>Watch fun videos, learn step by step and answer questions.</p>
                        <span class="sd-tile-btn">Let's go <span class="sd-arrow">&rarr;</span></span>
                    </div>
                </a>
                <a href="<?php echo base_url('student/my-course'); ?>" class="sd-tile sd-tile-alt">
                    <div class="sd-tile-art"><span class="sd-tile-emoji">&#128218;</span></div>
                    <div class="sd-tile-body">
                        <h3>My Courses</h3>
                        <p>See all your courses and switch to another one.</p>
                        <span class="sd-tile-btn sd-tile-btn-alt">Open <span class="sd-arrow">&rarr;</span></span>
                    </div>
                </a>
            </div>

            <div class="sd-section-title">My recent quizzes</div>
            <?php if (!empty($sd_recent)) { ?>
            <div class="sd-recent">
                <?php foreach ($sd_recent as $rq) { ?>
                <div class="sd-recent-item">
                    <span class="sd-recent-icon">&#127916;</span>
                    <div class="sd-recent-body">
                        <strong><?php echo html_escape($rq['title'] ? $rq['title'] : 'Video'); ?></strong>
                        <span><?php echo rtrim(rtrim(number_format($rq['score'], 2), '0'), '.'); ?> / <?php echo rtrim(rtrim(number_format($rq['total_marks'], 2), '0'), '.'); ?> marks &middot; <?php echo date('d M', strtotime($rq['created_at'])); ?></span>
                    </div>
                    <div class="sd-stars"><?php echo $sd_star_html($rq['pct']); ?></div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="sd-empty">
                <span>&#127775;</span>
                <p>Watch a video in <b>Course Content</b> and answer its quiz to earn your first stars!</p>
            </div>
            <?php } ?>

             <!--<div class="col-md-4 mb-4">
                  <a href="<?php echo base_url()?>student/homework1" class="block-link">
                <div class="block" style="background-color: #0f4d92; !important" >
                    <div class="block-icon">
                      <img src="../assets/images/contract.png" alt="Announcement Icon" class="icon-image"> 
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Assighment</h3>
                    </div>
                    <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                 </a>
            </div> -->
            <!-- <div class="col-md-4 mb-4">-->
            <!--      <a href="<?php echo base_url()?>student/extra-classes" class="block-link">-->
            <!--    <div class="block" style="background-color: #0f4d92; !important" >-->
            <!--        <div class="block-icon">-->
            <!--          <img src="../assets/images/online-learning.png" alt="Announcement Icon" class="icon-image"> -->
            <!--        </div>-->
            <!--        <div class="block-name">-->
            <!--            <h3 class="mb-0">Extra Classes</h3>-->
            <!--        </div>-->
            <!--        <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>-->
            <!--    </div>-->
            <!--     </a>-->
            <!--</div>-->
             <!--<div class="col-md-4 mb-4">
                  <a href="<?php echo base_url()?>student/doubts-ask" class="block-link">
                <div class="block" style="background-color: #0f4d92; !important" >
                    <div class="block-icon">
                      <img src="../assets/images/shock.png" alt="Announcement Icon" class="icon-image"> 
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Doubts</h3>
                    </div> 
                    <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                 </a>
            </div>
             <div class="col-md-4 mb-4">
                  <a href="<?php echo base_url()?>student/book1" class="block-link">
                <div class="block" style="background-color: #0f4d92; !important" >
                    <div class="block-icon">
                      <img src="../assets/images/stack-of-books.png" alt="Announcement Icon" class="icon-image"> 
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Books</h3>
                    </div>
                    <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                 </a>
            </div> 
             <div class="col-md-4 mb-4">
                  <a href="<?php echo base_url()?>student/notes1" class="block-link">
                <div class="block" style="background-color: #0f4d92; !important" >
                    <div class="block-icon">
                      <img src="../assets/images/note.png" alt="Announcement Icon" class="icon-image"> 
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Notes</h3>
                    </div>
                    <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                 </a>
            </div>
             <div class="col-md-4 mb-4">
                  <a href="<?php echo base_url()?>student/old-paper1" class="block-link">
                <div class="block" style="background-color: #0f4d92; !important" >
                    <div class="block-icon">
                      <img src="../assets/images/old.png" alt="Announcement Icon" class="icon-image"> 
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Old Papers</h3>
                    </div>
                    <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                 </a>
            </div>-->
            <!-- <div class="col-md-4 mb-4">-->
            <!--      <a href="<?=(!empty($this->session->userdata('batch_id')))?base_url('student/syllabus/').$this->session->userdata('batch_id'):'javascript:void(0)';?>" class="block-link">-->
            <!--    <div class="block" style="background-color: #0f4d92; !important" >-->
            <!--        <div class="block-icon">-->
            <!--          <img src="../assets/images/curriculum.png" alt="Announcement Icon" class="icon-image"> -->
            <!--        </div>-->
            <!--        <div class="block-name">-->
            <!--            <h3 class="mb-0">Syllabus</h3>-->
            <!--        </div>-->
            <!--        <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>-->
            <!--    </div>-->
            <!--</div>-->
             </a>
        </div>
   
	
        <div class="sectionHolder score_info_wrap">
    		<div class="edu_admin_informationdiv">
    		    <div class="row"> 
    		       <?php
    		       if(!empty($mock_result[0]['percentage'])){
    		       ?>
    				<div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
				        <h4 class="edu_title"><?php echo html_escape($this->common->languageTranslator('ltr_my_score'));?> </h4>
				        <div class="edu_topper_wrapper text-center student-pannel-toppers"> 
    				        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">  
    				        <div class="row">
                				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            				        <div class="edu_topper_section">
                                       
                                        <img src="<?php echo base_url();?>uploads/students/<?php echo $this->session->userdata['profile_img']; ?>" alt="" />
                                        
                                        <h4 class="edu_student_name"><?php echo $this->session->userdata['name'];?></h4>
                                        <p class="edu_student_standard">
                                            <?php if(!empty($mock_result)){ $coun =(count($mock_result)-1); echo $mock_result[$coun]['paper_name'];}?>
                                        </p>
                                        <p class="edu_student_scroe">
                                           <?php if(!empty($mock_result)){$coun =(count($mock_result)-1); echo number_format((float)$mock_result[$coun]['percentage'], 2, '.', '') ; } ?> %</p>
                                        <a href="<?php if(!empty($mock_result)){ $coun =(count($mock_result)-1); echo base_url('student/answer-sheet/mock/'.$mock_result[$coun]['id']); } ?>/<?php if(!empty($mock_result[$coun]['paper_id'])){ echo $mock_result[$coun]['paper_id']; } ?>" target="_blank" class="edu_student_level"><?php echo html_escape($this->common->languageTranslator('ltr_view'));?></a>
            				        </div>
            				    </div>
            				  
            				    </div>
            				</div>
            			</div>
				    </div>
				  
    		    <?php if(!empty($top_three)){ ?>
    				<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
				        <h4 class="edu_title"><?php echo html_escape($this->common->languageTranslator('ltr_top_scorer'));?></h4>
				        <div class="edu_topper_wrapper text-center student-pannel-toppers"> 
    				        <div class="col-xl-12 col-lg-10 col-md-12 col-sm-12 col-12 p-0">  
    				        <div class="row">
    				        <?php 
    				        $i=0;
    				        foreach($top_three as $top_threes){
    				        $i++;
                            switch ($i) {
                              case "1":
                                $suffix= "st";
                                break;
                              case "2":
                                $suffix= "nd";
                                break;
                              case "3":
                               $suffix= "rd";
                                break;
                            }
    				        ?>
                				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            				        <div class="edu_topper_section">
                                       
                                        <img src="<?php echo base_url();?>uploads/students/<?php echo $top_threes['image'];?>" alt="" />
                                        
                                        <h4 class="edu_student_name"><?php echo $top_threes['name'];?></h4>
                                        <p class="edu_student_standard"><?php echo $top_threes['paper_name'];?></p>
                                        <p class="edu_student_scroe"><?php echo $top_threes['percentage'];?>%</p>
                                        <span class="edu_student_level"><?php echo $i;?><sup><?php echo $suffix;?></sup></span>
            				        </div>
            				    </div>
            				    <?php } ?>
            				    </div>
            				</div>
            			</div>
				    </div>
				    <?php } ?>
				     
				    
				</div>
			</div>
		</div>
        <div class="row">
		    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
		        
        		<div class="edu_main_wrapper edu_table_wrapper mb_30">
        			<div class="edu_admin_informationdiv sectionHolder">
        				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        					<div class="row">
        						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sdsds">
        							<canvas id="mock_paper" width="800" height="400"></canvas>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
		    </div>
		     <?php } ?>
		</div>
		</div>
	</div>
</section> 

<?php 

if(!empty($mock_result)){
	$mock_date = [];
	$mock_percentage = [];
	foreach($mock_result as $result){
		
		$label = $result['date'].'('.$result['paper_name'].')';
		array_push($mock_percentage,number_format((float)$result['percentage'], 2, '.', ''));
		array_push($mock_date, "'".$label."'");
	}
	
	$mock_label = implode(',',$mock_date);
	$mock_per = implode(',',$mock_percentage);

}
?>
<script>
	var mock_config = {
        type: 'line',
        data: {
			labels: [<?php if(!empty($mock_label)){ echo $mock_label; }?>],
			datasets: [{ 
				data: [<?php if(!empty($mock_per)){ echo $mock_per; }?>],
				label: "Percentage",
				borderColor: "#3e95cd",
				fill: true,
			}]
		},
		options: {
			legend: { display: false },
			title: {
				display: true,
				text: 'Mock Test Paper Progress Report'
			}
		}
    };
</script>