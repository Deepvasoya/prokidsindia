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

<section class="edu_admin_content">
	<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
	    	 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
	    	     
	    	     <p style="font-size:25px"><?php echo $batch_data[0]['batch_name'];  ?></p>

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
                                 <!--<img src="<?php echo base_url('uploads/batch_banners/LMH.png');?><?php echo $baner['banner'];?>" alt="banner-imgone" />  -->  
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
           <div class="col-12 mb-4 d-flex justify-content-center">
                <div class="col-4 mb-4">
                    <a href="<?php echo base_url()?>student/video-lecture1" class="block-link">
                        <div class="block" style="background-color: #0f4d92 !important;">
                            <div class="block-icon">
                                <img src="../assets/images/video-lecture.png" alt="Announcement Icon" class="icon-image"> 
                            </div>
                            <div class="block-name">
                                <h3 class="mb-0">Course Content</h3>
                            </div>
                            <button class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </a>
                </div>
            </div>

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