<style>
  /* Card Container Styles */
.card-container {
  width: 200px; /* Adjust the width as needed */
  height: 150px; /* Adjust the height as needed */
  perspective: 1000px;
}

.spacer-top {
    padding-top: 130px!important;
}



/* Card Styles */
.card {
  width: 100%;
  height: 100%;
  background-color: #f7f7f7;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  transform: rotateY(0deg);
  transition: transform 0.5s ease-in-out;
}

.card:hover {
  transform: rotateY(10deg);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

/* Card Content Styles */
.card-content {
  padding: 20px;
  text-align: center;
}

.button-container {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  padding: 10px;
}


.btns button {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

.button-container button:hover {
  background-color: #3e8e41;
}

.btns {
  background-color: transparent;
  color: #000;
  padding: 10px 20px;
  border: 1px dashed #000;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
  height: 70px; /* increased height to accommodate two lines of text */
}

.coupon-code {
  font-size: 18px;
  font-weight: bold;
  display: block;
}

.coupon-desc {
  font-size: 12px;
  color: #666; /* darker gray color for description */
}

 .btns.disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
        .btn_applied {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
        }
</style>
<section class="tp-single-enroll">
<div class="edu-courses-single-banner">    
<h1 class="edu_courses_sprice">Courses Details</h1>
<h2 class="edu_courses_title"><?php echo $singel_batches[0]['batch_name']; ?></h2>
</div>
<div class="edu-course-box">
                            <div class="edu-course-img">
                                <img src="<?php if(!empty($singel_batches[0]['batch_image'])) { echo base_url('uploads\batch_image/').$singel_batches[0]['batch_image'] ; }else{ echo base_url('uploads/site_data/'.$site_Details['0']['site_logo']); } ?>" alt="image">
                                    <?php if(!empty($free['batch_offer_price'])){ ?><span class="edu-course-offer"><?php echo html_escape($this->common->languageTranslator('ltr_offer')); ?></span><?php } ?>
                                
                            </div> 
                            <div class="edu-course-content">
                                
                                <!-- Card Container -->
                                <div style="perspective: 1000px;">
                                  <!-- Card -->
                                  <div style="width: 100%;background-color: #f7f7f7; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <!-- Card Content -->
                                    <div style="text-align: center;">
                                      <div style="display: flex; flex-wrap: nowrap; overflow-x: auto; padding: 10px;">
                                          <?php foreach ($couponListing as $coupon) { ?>
                                            <button class="btns" id="apply-coupon-btn" data-discount-percentage="<?= $coupon['discount_percentage']; ?>" data-batch-offer-price="<?= $singel_batches[0]['batch_offer_price'] ?>" >
                                              <span class="coupon-code"><?= $coupon['coupon_code'] ?></span>
                                              <span class="coupon-desc"><?= $coupon['discount_percentage'] ?>% <?= $coupon['discount_type'] ?></span>
                                            </button>
                                          <?php } ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                <a href="<?php echo base_url('courses-details/'.$free['id']); ?>" class="edu-course-title"><?php echo $free['batch_name'];?></a>
                                <p><?php echo $free['description']; ?></p>
                                
                                <h2 class="edu_courses_sprice edu-volue-offer price-display" id="price-display" >
                                    
                                <?php 
                                if($singel_batches[0]['batch_type']==2){
                                    if (!empty($singel_batches[0]['batch_offer_price'])) {
                                        echo '<s>' . $currency_decimal . ' ' . $singel_batches[0]['batch_price'] . '</s> / ' . $currency_decimal . ' ' . $singel_batches[0]['batch_offer_price']; 
                                        
                                        $originalPrice = $singel_batches[0]['batch_price'];
                                        $offerPrice = $singel_batches[0]['batch_offer_price'];
                                        $percentageDiscount = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                                        
                                        echo '<span style="color:green"> '. sprintf("%.2f", $percentageDiscount). '% Off</span>';
                                        
                                    }else{ 
                                            echo $currency_decimal.' '.$singel_batches[0]['batch_price'];
                                        
                                    } 
                                        
                                    }else{
                                        echo "Free";
                                        
                                    } ?></h2>
                                    
                                     
            
            
            <h6>Payable Amount:  <b class="finalamount"><?php echo $currency_decimal . ' ' . $singel_batches[0]['batch_offer_price'] ?></b></h6>
            
        </h2>
                                
                               <!--  <a href="<?php echo base_url('enroll-now/'.$free['id']); ?>" class="edu_courses_view"><?php echo html_escape($this->common->languageTranslator('ltr_enroll_now'));?></a> -->
                                <h2 class="edu_courses_title"><?php echo $singel_batches[0]['batch_name']; ?></h2>
                                <!-- <p class="edu_courses_des mb_30"><?php echo $singel_batches[0]['description']; ?></p> -->
                                 <?php 
                                  $purchase = $this->db_model->select_data('*', 'sudent_batchs',array('student_id' => $this->session->userdata('uid'),'batch_id'=>$singel_batches[0]['id']));
                                if(empty($purchase)){
                                 ?>
                                 
                                    
                                 	<div class="withoutMapFrm">
            							<input type="hidden" value="<?php echo base_url()?>" id="baseUrlId">
            							<form method="post">
            								<?php
            							//	print_r($singel_batches);
                								if($singel_batches){
                								    ?>
                								        <input type="hidden" name="batchId" value="<?php echo $singel_batches[0]['id'] ;?>" id="batchId">
                							    	<?php 
            								    }
            								?>
            								<div class="row">
            									<div class="col-lg-6 col-md-6 col-sm-12 col-12">
            										<div class="edu_field_holder">
            										<input value="<?php echo $user_details[0]["name"] ;?>"  type="hidden" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_name'));?> *" name="name" >
            										<input value="<?php echo $user_details[0]["name"] ;?>"  type="hidden" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_name'));?> *" name="name" >
            										<input type="hidden" value="<?php echo $user_details[0]["email"] ;?>" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_email'));?> *" data-valid="email" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_email'));?>" name="email" id="emailField">
            										<input type="hidden" value="<?php echo $user_details[0]["contact_no"] ;?>" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_phone'));?> *" data-valid="mobile" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_phone'));?>" name="mobile" maxlength="12">
            										<select  class="require form-control filter_batches edu_selectbox_with_search" name="state" data-placeholder="State" data-count="no" style="display:none;">
                                                                        <option value="<?php echo $user_details[0]["student_state"] ;?>">Please select state</option>
                                                                        <?php
                                                                        if(!empty($all_states)){
                                                                            foreach($all_states as $states){ 
                                                                                if($user_details[0]["student_state"] == $states['vStateName']){
                                                                                    echo '<option value="'.$states['vStateName'].'" active>'.$states['vStateName'].'</option>';
                                                                                }else{
                                                                                    echo '<option value="'.$states['vStateName'].'">'.$states['vStateName'].'</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                        ?> 
                                                                    </select>
                                                    <input type="hidden"  value="<?php echo $user_details[0]["student_city"] ;?>" name="city" class="require edu_form_field" placeholder="City">
                                                    <button type="button" onclick="validateForm()" class="edu_btn enrollNowSubmit"><?php echo html_escape($this->common->languageTranslator('ltr_enroll_now'));?></button> 
            										</div>
            									</div>
            									 
            									
            									 
            									
            								 
            								</div>
            								
                                            </form> 
            							<div id="paymentDetails"> </div>
            							
            						</div>
                                 
                                 
                                 
                                    
                                    
                                <?php 
                                  } else{?>
                                  <a href="#" class="edu_btn enroll-btn-view"><?php echo html_escape($this->common->languageTranslator('ltr_already_enrolled'));?></a>
                                  <?php }?>
                            </div>
                        </div>
</section>

<!----- Courses Single Section ----->
<section class="edu_courses_single">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-12 col-sm-12 col-10 padder0">
                <div class="edu_courses_section">
                    <div class="row">
                         <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 align-self-center">
                            <!-- <div class="edu_courses_box">
                                <div class="edu_courses_cntnbox">
                                <h2 class="edu_courses_sprice"><?php if($singel_batches[0]['batch_type']==2){ if(!empty($singel_batches[0]['batch_offer_price'])){ echo '<s>'.$currency_decimal.' '.$singel_batches[0]['batch_price'].'</s> / '.$currency_decimal.' '.$singel_batches[0]['batch_offer_price']; }else{ echo $currency_decimal.' '.$singel_batches[0]['batch_price'];} }else{ echo "Free";} ?></h2>
                                
                                <h2 class="edu_courses_title"><?php echo $singel_batches[0]['batch_name']; ?></h2>
                                <p class="edu_courses_des mb_30"><?php echo $singel_batches[0]['description']; ?></p>
                                 <?php 
                                  $purchase = $this->db_model->select_data('*', 'sudent_batchs',array('student_id' => $this->session->userdata('uid'),'batch_id'=>$singel_batches[0]['id']));
                                if(empty($purchase)){
                                 ?>
                                 <div class="withoutMapFrm">
            							<input type="hidden" value="<?php echo base_url()?>" id="baseUrlId">
            							<form method="post">
            								<?php
            							//	print_r($singel_batches);
                								if($singel_batches){
                								    ?>
                								        <input type="hidden" name="batchId" value="<?php echo $singel_batches[0]['id'] ;?>" id="batchId">
                							    	<?php 
            								    }
            								?>
            								<div class="row">
            									<div class="col-lg-6 col-md-6 col-sm-12 col-12">
            										<div class="edu_field_holder">
            										<input value="<?php echo $user_details[0]["name"] ;?>"  type="hidden" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_name'));?> *" name="name" >
            										<input type="hidden" value="<?php echo $user_details[0]["email"] ;?>" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_email'));?> *" data-valid="email" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_email'));?>" name="email">
            										<input type="hidden" value="<?php echo $user_details[0]["contact_no"] ;?>" class="edu_form_field require" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_enter_your_phone'));?> *" data-valid="mobile" data-error="<?php echo html_escape($this->common->languageTranslator('ltr_valid_enter_your_phone'));?>" name="mobile" maxlength="12">
            										<select  class="require form-control filter_batches edu_selectbox_with_search" name="state" data-placeholder="State" data-count="no" style="display:none;">
                                                                        <option value="<?php echo $user_details[0]["student_state"] ;?>">Please select state</option>
                                                                        <?php
                                                                        if(!empty($all_states)){
                                                                            foreach($all_states as $states){ 
                                                                                if($user_details[0]["student_state"] == $states['vStateName']){
                                                                                    echo '<option value="'.$states['vStateName'].'" active>'.$states['vStateName'].'</option>';
                                                                                }else{
                                                                                    echo '<option value="'.$states['vStateName'].'">'.$states['vStateName'].'</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                        ?> 
                                                                    </select>
                                                    <input type="hidden"  value="<?php echo $user_details[0]["student_city"] ;?>" name="city" class="require edu_form_field" placeholder="City">
                                                    <button type="button" class="edu_btn enrollNowSubmit"><?php echo html_escape($this->common->languageTranslator('ltr_submit'));?></button> 
            										</div>
            									</div> 
            								</div>
                                            </form> 
            							<div id="paymentDetails"> </div>							
            						</div>
                                    <?php } else{?>
                                  <a href="#" class="edu_btn"><?php echo html_escape($this->common->languageTranslator('ltr_already_enrolled'));?></a>
                                  <?php }?>
                                </div>
                            </div> -->
                            <p class="edu_courses_des mb_30"><?php echo $singel_batches[0]['description']; ?></p>
                        </div>
                        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 align-self-center">
                            <div class="edu_courses_imgbox">
                                <img src="<?php if(!empty($singel_batches[0]['batch_image'])) { echo base_url('uploads\batch_image/').$singel_batches[0]['batch_image'] ; }else{ echo base_url('uploads/site_data/'.$site_Details['0']['site_logo']); } ?>" alt="image">
                            </div>
                        </div> -->
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    
    <!-- course learn start -->

<div class="edu-cousre-learn spacer-top spacer-bottom edu-course-bg-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="edu-course-learn-img">
                    <img src="<?php echo base_url();?>/assets/images/learning.png" alt="images">
                </div>
            </div>
                <?php if(!empty($batch_fecherd)) { ?>
            <div class="col-md-7">
            <?php 
            for ($i=0; $i < 2 ; $i++) { 
                ?>
           
                        <!-- foreach($batch_fecherd as $feat){ ?> -->
                <div class="edu-cousre-learn-list">
                    <div class="edu-course-heading">
                        <h1><?php echo $batch_fecherd[$i]['batch_specification_heading'];?></h1>
                    </div>
                    <ul>
                       <?php
                        $fetured = json_decode($batch_fecherd[$i]['batch_fecherd']);
                       foreach($fetured as $feated){ ?>
                        <li><img src="<?php echo base_url();?>/assets/images/check.svg"> <?php echo $feated;?></li>

                       <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<!-- course learn end -->

    <!----- Recommended Course Section ----->
        
        <!--<div class="edu-course-content-wrap spacer-top spacer-bottom" id="edu-course-accordian">-->
  <!--  <div class="container">-->
  <!--      <div class="edu_heading_wrapper text-center">-->
        <!--    <h4 class="edu_subTitle"><?php $ttd =html_escape($this->common->languageTranslator('ltr_enhance')); echo !empty($frontend_details[0]['sec_crse_sub_heading'])?$frontend_details[0]['sec_crse_sub_heading']: $ttd;?></h4>-->
        <!--    <h4 class="edu_heading"><?php $cttd =html_escape($this->common->languageTranslator('ltr_our_courses')); echo !empty($frontend_details[0]['sec_crse_heading'])?$frontend_details[0]['sec_crse_heading']:$cttd ;?></h4>-->
        <!--    <img src="<?php echo base_url();?>/assets/images/border.png" alt="">-->
        <!--</div>-->
  <!--      <div class="row">-->
  <!--          <div class="col-md-6">-->
  <!--              <div class="edu-course-accordian">-->
                    <?php
    //                 if(!empty($video_lectures)){
       //         $i=0;
          //  foreach($video_lectures as $video){
          //      $like_sub = array('batch','"'.$video['batch'].'"');
             
                
          //       $video_chapter = $this->db_model->custom_slect_query("* FROM `video_lectures` WHERE  `status` = 1 AND `Batch` LIKE '%".$video['batch']."%' ESCAPE '!' GROUP BY `topic`");
                    
              
          //          foreach($video_chapter as $video_chap){
                     
          //               $video_data = $this->db_model->custom_slect_query("* FROM `video_lectures` WHERE  `topic` = '".$video_chap['topic']."' AND `Batch` LIKE '%".$video_chap['batch']."%' ESCAPE '!'");
                         
          //              echo $this->db->last_query();
          //              print_r($video_data);
          //             foreach($video_data as $videoData){
          //       $i++;
            ?>
                    <!--<div class="edu-course-accordian-list">-->
                    <!--    <p class="edu-course-accordian-title collapsed" data-toggle="collapse" data-target="#edu-course-accordian<?php echo $i;?>">-->
                    <!--       Subject : <?php echo $videoData['subject']." </br> Chapter : ".$videoData['topic'];?></p>-->
                    <!--    <div id="edu-course-accordian<?php echo $i;?>" class="collapse" data-parent="#edu-course-accordian">-->
                    <!--        <div class="edu-course-accordian-body">-->
                    <!--            <ul>-->
                    <!--                <li>            -->
                                       <?php
                                    //   echo $videoData['title'];
                                    //     echo '<span class="edu-video-preview"><a class="viewVideo btn_view" title="View" data-id="'.$videoData['id'].'" data-url="'.$videoData['url'].'" data-type="'.$videoData['video_type'].'" data-desc="'.$videoData['description'].'"><i class="fa fa-eye"></i></a></span>';
                                        ?>
                                           
                    <!--                    </span>-->
                    <!--                </li>-->
                    <!--            </ul>-->
                    <!--        </div>-->
                           
                    <!--    </div>-->
                    <!--</div>-->
                      <?php
                    //   } } }  }
                      ?>
<!--                </div>-->
<!--            </div>  -->
           
<!--        </div>-->
<!--    </div>-->
<!--</div>  -->

<div class="edu-course-content-wrap spacer-top spacer-bottom" id="edu-course-accordian">
    <div class="container">
        <div class="edu_heading_wrapper text-center">
            <h4 class="edu_subTitle"><?php $ttd =html_escape($this->common->languageTranslator('ltr_enhance')); echo !empty($frontend_details[0]['sec_crse_sub_heading'])?$frontend_details[0]['sec_crse_sub_heading']: $ttd;?></h4>
            <h4 class="edu_heading"><?php $cttd =html_escape($this->common->languageTranslator('ltr_our_courses')); echo !empty($frontend_details[0]['sec_crse_heading'])?$frontend_details[0]['sec_crse_heading']:$cttd ;?></h4>
            <img src="<?php echo base_url();?>/assets/images/border.png" alt="">
        </div>
        <div class="row">
            <div class="col-md-6">
                  
               
<?php if($getsubjectchapter){ ?>

    <div class="edu-course-accordian">

                    <?php
               
                  $i=0;
                        foreach($getsubjectchapter as $subject){
                           
                     $subname =  $this->db_model->select_data('subject_name,id','subjects use index (id)',array('id'=>$subject['subject_id'],'status'=>1));
                    //  print_r($subname);
                   
                   foreach($subname as $sub ){
                      //print_r($sub);
                            ?>
                        <div class="edu-course-accordian-list" >
                            <p class="edu-course-accordian-title collapsed"  data-toggle="collapse" data-target="#edu-course-accordian<?php echo $i;?>"> 
                            Subject : <?php echo $sub['subject_name']; ?>
                            <i class="icofont-caret-down edu-image-align"></i>
                        </p>
                            <?php
                              
                                $chapter = json_decode($subject['chapter']);
                        $video=0;
                         $y = array_reverse($chapter);
                             foreach($y as $chap){
                                
                                   $video++;
                                  $chaptername =  $this->db_model->select_data('id,chapter_name','chapters use index (id)',array('id'=>$chap,'status'=>1));
                           
                                foreach($chaptername as $chapter_name){
                                     
                                     $like = array('batch','"'.$subject['batch_id'].'"');
                                    $video_check = $this->db_model->select_data('*','video_lectures use index (id)',array('status'=>1,'subject'=>$sub['id'],'topic'=>$chapter_name['id']),'','',$like,'',''); 
                           // print_r($video_check);
                            ?>
                                    <div id="edu-course-accordian<?php echo $i;?>" class="collapse " data-parent="#edu-course-accordian">
                                        <p class="collapsed chapter-header" data-toggle="collapse" <?php if(!empty($video_check)){?> data-target="#edu-course-video<?php echo $video; }?>">
                                            <?php echo $chapter_name['chapter_name'];
                                            
                                           
                                    if(!empty($video_check)){?>
                                            
                                            <i class="icofont-caret-down edu-image-align"></i>
                                            <?php } ?>
                                        </p>


                                    </div>
                                    
                                       <div id="edu-course-video<?php echo $video;?>" class="collapse">
                                        <ul>
                                            <?php
                                $like = array('batch','"'.$subject['batch_id'].'"');
                                    $video_lecture = $this->db_model->select_data('*','video_lectures use index (id)',array('status'=>1,'subject'=>$sub['id'],'topic'=>$chapter_name['id']),'','',$like,'','');
                                  
                                            foreach ($video_lecture as $arrStrVideo){ 
                                            if($arrStrVideo['preview_type']=='preview'){?>
                                                <li class="edu-list">

                                                    <a class="viewVideo edu-video-link" data-id="<?php echo $arrStrVideo['id'];?>"  data-url="<?php echo $arrStrVideo['url'];?>" data-type="<?php echo $arrStrVideo['video_type'];?>" data-desc="<?php echo $arrStrVideo['description'];?>">
                                                      </a>  <i class="icofont-ui-video-play"></i>
                                                        <ul>
                                                            <?php
                                                            echo $arrStrVideo['title'];?>
                                                        </ul>                                           
                                                    <?php
                                                    echo '<span class="edu-video-preview">
                                                <a class="viewVideo btn_view" title="View" data-id="'.$arrStrVideo['id'].'" data-url="'.base_url($arrStrVideo['url']).'" data-type="'.$arrStrVideo['video_type'].'" data-desc="'.$arrStrVideo['description'].'"><i class="fa fa-eye"></i></a></span>'; ?>

                                                    </span>
                                                </li>
                                            <?php }else{ ?>
                                                
                                                <li class="edu-list">

                                                    <a class="viewVideo edu-video-link" data-id="<?php echo $arrStrVideo['id'];?>"  data-url="<?php echo $arrStrVideo['url'];?>" data-type="<?php echo $arrStrVideo['video_type'];?>" data-desc="<?php echo $arrStrVideo['description'];?>">
                                                      </a> <i class="icofont-ui-video-play"></i>

                                                        <ul class="edu-video-title">

                                                            <?php
                                                            echo $arrStrVideo['title'];?>
                                                        </ul>  </li>
                                                
                                           <?php }}
                                            ?>

                                        </ul>
                                    </div>
                                    
                                    
                                    

                            <?php } }?>
                        </div>
                              <?php $i++; } }
                             ?>

                </div>

<?php } ?>
            </div>  
           
        </div>
    </div>
</div>  

<input type="hidden" id="discountedPrice" name="discountedPrice" value="0">
    
            <!-- course slider start -->
<div class="edu-course-wrap spacer-top edu-course-slider edu-course-bg-wrap course-slider-">
    <div class="container">
        <div class="edu_heading_wrapper text-center">
            <h4 class="edu_subTitle"><?php $ttd =html_escape($this->common->languageTranslator('ltr_enhance')); echo !empty($frontend_details[0]['sec_crse_sub_heading'])?$frontend_details[0]['sec_crse_sub_heading']: $ttd;?></h4>
            <h4 class="edu_heading"><?php echo html_escape($this->common->languageTranslator('ltr_recod_course'));?></h4>
            <img src="<?php echo base_url();?>assets/images/border.png" alt=""/>
        </div>
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        
                            <?php 
                    if(!empty($batches)){
                                foreach($batches as $value){
                                    ?>
                        <div class="swiper-slide">
                            <div class="edu-course-box">
                                <div class="edu-course-img">
                                    <img src="<?php if(!empty($value['batch_image'])) { echo base_url('uploads\batch_image/').$value['batch_image'] ; }else{ echo base_url('uploads/site_data/'.$site_Details['0']['site_logo']); } ?>" alt="image">
                                        <?php if(!empty($value['batch_offer_price'])){ ?> <span class="edu-course-offer"><?php echo html_escape($this->common->languageTranslator('ltr_offer')); ?></span> <?php } ?>
                                    <a href="<?php echo base_url('enroll-now/'.$value['id']); ?>" class="edu-enroll-btn"><?php echo html_escape($this->common->languageTranslator('ltr_enroll_now'));?></a>
                                </div> 
                                <div class="edu-course-content">
                                    <a href="<?php echo base_url('courses-details/'.$value['id']); ?>" class="edu-course-title"><?php echo $value['batch_name'];?></a>
                                    <p><?php echo $value['description']; ?></p>
                                    <!--<ul class="edu-course-rating">-->
                                    <!--    <li><i class="fas fa-star"></i></li>-->
                                    <!--    <li><i class="fas fa-star"></i></li>-->
                                    <!--    <li><i class="fas fa-star"></i></li>-->
                                    <!--    <li><i class="fas fa-star"></i></li>-->
                                    <!--    <li><i class="fas fa-star"></i></li>-->
                                    <!--</ul>-->
                                    <div class="course-edu">
                                    <h3 class="edu-course-price"><?php if($value['batch_type']==2){ 
                                    if(!empty($value['batch_offer_price'])){ echo '<s>'.$currency_decimal.' '.$value['batch_price'].'</s> / '.$currency_decimal.' '.$value['batch_offer_price']; 
                                    $originalPrice = $value['batch_price'];
                                    $offerPrice = $value['batch_offer_price'];
                                    $percentageDiscount = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                                    echo '</h3>';
                                    echo '<span style="color:green">' .$currency_decimal.' '. sprintf("%.2f", $percentageDiscount). '% Off</span>';
                                    }else{ echo '<h3>'.$currency_decimal.' '.$value['batch_price'];} }else{ echo "Free";} ?></h3>
                                    </div>
                                    <a href="<?php echo base_url('courses-details/'.$value['id']); ?>" class="edu_courses_view"><?php echo html_escape($this->common->languageTranslator('ltr_course_view'));?></a>
                                </div>
                            </div>
                        </div>
                         <?php } } ?>
                    </div>
                    <div class="swiperTeamPagination"></div>
                </div>
            </div>
           
        </div>
    </div>
</div>          
<!--hidden Fields    -->
  
					
				 
		 




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
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const buttons = document.querySelectorAll('.btns');
const ebuttons = document.querySelectorAll('.btnsenroll');
 
localStorage.setItem('myData', null);

var sale_price = document.querySelector('#apply-coupon-btn').dataset.batchOfferPrice;
localStorage.setItem('myData', sale_price);



   $(document).ready(function() {
            let appliedCoupon = null;

            $('.btns').click(function() {
                
                // Remove the applied class and disabled state from all buttons
                $('.btns').removeClass('btn_applied disabled');
                $('#current-price').text($('#original-price').text().replace('₹ ', ''));
                $('.finalamount').text($('#original-price').text().replace('₹ ', ''));
                
                

                // Check if this button is already the applied coupon
                if (appliedCoupon === this) {
                    let batchOfferPrice = $(this).data('batch-offer-price');
                    // If the same coupon is clicked again, unapply it
                    appliedCoupon = null;
                    $('#current-price').text($('#original-price').text().replace('₹ ', ''));
                    $('.finalamount').text($('#original-price').text().replace('₹ ', ''));
                    $('.finalamount').text(batchOfferPrice.toFixed(2));
                       localStorage.setItem('myData', batchOfferPrice);
                       
                } else {
                    // Apply new coupon
                    appliedCoupon = this;
                    $(this).addClass('btn_applied');
                    
                    let discountPercentage = $(this).data('discount-percentage');
                    let batchOfferPrice = $(this).data('batch-offer-price');
                    let discountAmount = (discountPercentage / 100) * batchOfferPrice;
                    let finalPrice = batchOfferPrice - discountAmount;
                    localStorage.setItem('myData', finalPrice);
    
                    
                
                    $('#current-price').text(finalPrice.toFixed(2));
                    $('.finalamount').text(finalPrice.toFixed(2));
                }
            });
        });

// const discountManager = {
//   discountedPrice: 0,
//   currentButton: null,

//   applyDiscount: function(button) {
//     const $button = $(button);
//     const discountPercentage = parseFloat($button.data('discountPercentage'));
//     const batchOfferPrice = parseFloat($button.data('batchOfferPrice'));
//     const couponCode = $button.find('.coupon-code').text();
//     const couponDesc = $button.find('.coupon-desc').text();

//     // Remove the applied class from all buttons
//     $('.discount-button').each(function() {
//       const $btn = $(this);
//       $btn.removeClass('button-applied');
//       if ($btn[0] !== $button[0]) {
//         discountManager.resetCoupon($btn);
//       }
//     });

//     // Calculate the discount
//     const discountAmount = (batchOfferPrice * discountPercentage) / 100;
//     this.discountedPrice = batchOfferPrice - discountAmount;

//     // Update localStorage
//     localStorage.setItem('myData', this.discountedPrice);
//     console.log(`Discounted Price Stored: ₹ ${this.discountedPrice.toFixed(2)}`);

//     // Update the price display
//     const $priceDisplay = $('.edu_courses_sprice.edu-volue-offer.price-display');
//     if ($priceDisplay.length) {
//       $priceDisplay.html(`
//         <s>₹ ${batchOfferPrice.toFixed(2)}</s> / 
//         ₹ <b class="finalamount">${this.discountedPrice.toFixed(2)}</b>
//         <h6>Discount Coupon: ₹ <b>${discountAmount.toFixed(2)}</b></h6>
//         <h6>Payable Amount: ₹ <b class="finalamount">${this.discountedPrice.toFixed(2)}</b></h6>
//       `);
//     }

//     // Update the button state and style
//     $button.html(`${couponCode} Applied <i class="fas fa-check"></i>`);
//     $button.prop('disabled', true);
//     $button.addClass('button-applied'); // Add the applied class

//     // Update the current button reference
//     this.currentButton = $button;
//   },

//   resetCoupon: function($button) {
//     if ($button.length && $button.find('.coupon-code').length) {
//       const couponCode = $button.find('.coupon-code').text();
//       const couponDesc = $button.find('.coupon-desc').text();
//       const batchOfferPrice = parseFloat($button.data('batchOfferPrice'));

//       // Restore button state and style
//       $button.html(`${couponCode} <span class="coupon-desc">${couponDesc}</span> <i class="fas fa-tag"></i>`);
//       $button.prop('disabled', false);
//       $button.removeClass('button-applied'); // Remove the applied class

//       // Reset price display to the original batch offer price
//       const $priceDisplay = $('.edu_courses_sprice.edu-volue-offer.price-display');
//       if ($priceDisplay.length) {
//         $priceDisplay.html(`
//           <s>₹ ${batchOfferPrice.toFixed(2)}</s> / ₹ ${batchOfferPrice.toFixed(2)}
//         `);
//       }
//     }
//   }
// };



function validateForm() {
    var baseUrlIdx = document.getElementById('baseUrlId');
    var emailField = document.getElementById('emailField');
    var batchId = document.getElementById('batchId');
    
    // Check if all required elements are present
    if (emailField && batchId) {
        var email = emailField.value;
        var url = baseUrlIdx.value;
        var bid = batchId.value;

        // Print the email value to the console
        console.log('Email value:', email);

        if (email === null || email === '') {
            // Redirect to another page if email is empty or null
            window.location.href = url + '/batchregister/' + bid;
        } else {
            // Get the form element
            var form = document.getElementById('enrollForm');
            if (form) {
                // Submit the form if it exists
                form.submit();
            } else {
                // Handle the case where the form is not found
                console.error('Form with ID "enrollForm" not found');
            }
        }
    } else {
        console.error('Email field or batchId not found');
    }
}


// buttons.forEach(button => {
    
//   button.addEventListener('click', function() {
//     discountManager.applyDiscount(this);
//   });
// });

 
</script>