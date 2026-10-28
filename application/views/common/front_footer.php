</div>
</div>
<!-- Logout start-->
<div id="logoutPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner text-center">
            <h4 class="edu_title edu_logt_title padderBottom20"><?php echo html_escape($this->common->languageTranslator('ltr_are_you_logout'));?></h4>
            <button type="button" class="edu_btn edu_admin_btn edu_admin_btn_black edu_btn_black logoutBtnCncl mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_cancel'));?></button>
            <button type="button" class="edu_btn edu_admin_btn logOutBtn ml-2 mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_yes'));?></button>
        </div>
    </div>
</div>
<!-- Logout end-->
<footer class="edu_footer_wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-12 col-12 mb_30">
					<div class="edu_widgets edu_footer_about">
						<img class="footer_logo" src="<?php echo html_escape($this->common->siteLogo); ?>" alt=""/>
						<p><?php echo !empty($frontend_details[0]['abt_frst_desc'])?substr($frontend_details[0]['abt_frst_desc'],0,180):'Consectetur adipiscing elttid do eiuid tempor incididunt ut labereore maeet dolore magna aliqua. Qweeuis ium suspen edisse ultrices.Consectetur adipiscing elttid do eiuid tempor incididunt ut labereore maeet dolore magna aliqua. Qweeuis ium suspen edisse ultrices.';?></p>
						<a class="edu_readMoreBtn" href="<?php echo base_url('about-us');?>"><?php echo html_escape($this->common->languageTranslator('ltr_read_more')); ?></a>
					</div>
				</div>
			<!--	<div class="col-lg-2 col-md-3 col-sm-4 col-12">
					<div class="edu_widgets mb_30">
						<div class="edu_footer_title">
							<h4 class="edu_footer_heading"><?php echo html_escape($this->common->languageTranslator('ltr_our_courses')); ?></h4>
							<img src="<?php echo base_url()?>assets/images/half_border.png" alt="">
						</div>
						<ul>
						<?php 
						$batches = $this->db_model->select_data('*','batches use index (id)',array('status'=>'1','admin_id'=>'1'),6);
							if(!empty($batches)){
								// foreach($batches as $crs){ 
								    for($i=0;$i<6;$i++){
									echo '<li><a href="'.base_url('courses-details/'.$batches[$i]['id']).'"><span>'.$batches[$i]['batch_name'].'</span></a></li>';							
								}
							}
							?>
						</ul>
					</div>
				</div>-->
				<!--<div class="col-lg-2 col-md-3 col-sm-4 col-12">
					<div class="edu_widgets mb_30">
						<div class="edu_footer_title">
							<h4 class="edu_footer_heading"><?php echo html_escape($this->common->languageTranslator('ltr_facilities')); ?></h4>
							<img src="<?php echo base_url()?>assets/images/half_border.png" alt="">
						</div>
						<ul>
						<?php 
						if(!empty($facilities)){
							foreach($facilities as $facility){ ?>
								<li><span><?php echo html_escape($facility['title'])?></span></li>
							<?php 
							}
						}
						?>
						
						</ul>
					</div>
				</div>-->
				
				<div class="col-lg-2 col-md-6 col-sm-4 col-12">
					<div class="edu_widgets mb_30">
						<div class="edu_footer_title">
							<h4 class="edu_footer_heading"><?php echo html_escape($this->common->languageTranslator('ltr_our_links')); ?></h4>
							<img src="<?php echo base_url();?>assets/images/half_border.png" alt="">
						</div>
						<ul>
						    	<li><a href="<?php echo base_url();?>courses-offered"><span><?php echo html_escape($this->common->languageTranslator('ltr_home')); ?></span></a></li>
							<!--<li><a href="<?php echo base_url();?>"><span><?php echo html_escape($this->common->languageTranslator('ltr_home')); ?></span></a></li>-->
							<li><a href="<?php echo base_url();?>about-us"><span><?php echo html_escape($this->common->languageTranslator('ltr_about_us')); ?></span></a></li>
						<!--	<li><a href="<?php echo base_url();?>courses-offered"><span><?php echo html_escape($this->common->languageTranslator('ltr_courses_offered')); ?></span></a></li>-->
							<!--<li><a href="<?php echo base_url();?>gallery"><span><?php echo html_escape($this->common->languageTranslator('ltr_gallery')); ?></span></a></li>
							<li><a href="<?php echo base_url();?>facilities"><span><?php echo html_escape($this->common->languageTranslator('ltr_facilities')); ?></span></a></li>-->
						    <li><a href="<?php echo base_url();?>contact-us"><span><?php echo html_escape($this->common->languageTranslator('ltr_contact_us')); ?></span></a></li>
						    <li><a href="<?php echo base_url();?>privacy-policy"><span><?php echo html_escape($this->common->languageTranslator('ltr_privacy_policy')); ?></span></a></li>
						    <li><a href="<?php echo base_url();?>term-condition"><span><?php echo html_escape($this->common->languageTranslator('ltr_terms_conditions')); ?></span></a></li>
						    <li><a href="<?php echo base_url();?>shipping-policy"><span>Shipping Policy</span></a></li>
						    <li><a href="<?php echo base_url();?>refund-policy"><span>Refund Policy</span></a></li>
						</ul>
					</div>
				</div>
				
				<?php
// Database connection (Make sure $this->db is initialized properly in your setup)
$this->load->database();

// Fetch site details from the database
$query = $this->db->get('site_details');
$site_details = $query->row_array();
?>

				
				<div class="col-lg-3 col-md-6 col-sm-12 col-12 mb_30">
					<div class="edu_widgets edu_footer_address">
						<div class="edu_footer_title">
							<h4 class="edu_footer_heading"><?php echo html_escape($this->common->languageTranslator('ltr_contact_us')); ?></h4>
							<img src="<?php echo base_url()?>assets/images/half_border.png" alt="">
						</div>
						<ul>
							<li>
								<div class="edu_footer_info">
									<span>Office Address:</span>
									<?php
                                if(!empty($site_details['gst_address']))
                                    echo '<a>' . html_escape($site_details['gst_address']) . '</a>';
                                else
                                    echo '<a>04 A, Agroha Nagar, Dewas, Madhya Pradesh 455001</a>';
                                ?>
								</div>
							</li>
							<li>
								<div class="edu_footer_info">
									<span>Contact Number:</span>
										<?php
                                if(!empty($site_details['phone_number']))
                                    echo '<a href="tel:+' . html_escape($site_details['phone_number']) . '">' . html_escape($site_details['phone_number']) . '</a>';
                                else
                                    echo '<a href="tel:+91 9999999999">+91 9999999999</a>';
                                ?>
								</div>
							</li>
							<li>
								<div class="edu_footer_info">
									<span>Email Address:</span>
										 <?php
                                if(!empty($site_details['support_email']))
                                    echo '<a href="mailto:' . html_escape($site_details['support_email']) . '">' . html_escape($site_details['support_email']) . '</a>';
                                else
                                    echo '<a href="mailto:example@email.com">example@email.com</a>';
                                ?>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="edu_copyright_wrapper">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
				<p> <a style="color:#006eff" href="<?php echo base_url();?>" target="_blank"><?php echo html_escape($this->common->copyrightText); ?></a>
                
			</div>
			
		</div>
		
		
	</footer>	
	<!---------- GO To Top ------------>
	<a href="javascript:void(0);" id="scroll"><span class="icofont-swoosh-up"></span></a>
    <!----- Script Start ----->
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/swiper.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/wow.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.appear.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.countTo.js"></script>
	<script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/tilt.js"></script>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script src="<?php echo base_url();?>assets/js/front-custom.js?<?php echo time();?>"></script>
	<?php
$admin_id = $this->session->userdata('admin_id');
if(isset($admin_id) && !empty($admin_id)){ ?>
<script>
// SRART code stop ctrl+U and right click

document.addEventListener("contextmenu", function(e){ e.preventDefault(); }, false); 
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            ( e.keyCode === 85 || 
             e.keyCode === 117)) {
            return false;
        } else {
            return true;
        }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});

// END code stop ctrl+U and right click
</script>
<?php } ?>
  </body>
</html>