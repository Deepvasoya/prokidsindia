 <div class="container">
    <div class="login-inner-section">
            <div class="row">
             <div class="col-md-12 mb-4" style="text-align: center;">
                <?php if (isset($site_logo)) { ?>
                    <a href="#"><img style="width: 20%"; src="<?php echo base_url();?>uploads/site_data/<?php echo $site_logo; ?>" class="img-fluid" alt="Site Logo"></a>
                <?php } ?>
             </div>  
            </div>  
            <div class="row">
                <div class="col-md-6 login-form-1 text-center">
                   <img src="<?php echo base_url();?>assets/images/login-img-new.png" class="let-img"/>
                </div>
                <div class="col-md-6 right-form">
                    <form class="pt-2 pt-lg-5" method="post" action="<?php echo base_url().'front_ajax/reset_password'; ?>" data-redirect="yes" id="forgotForm">
                        <h3 class="form-title mt-3 mt-lg-0"><?php echo html_escape($this->common->languageTranslator('ltr_forgot_password'));?></h3>
                        <div class="form-group">
                            <input type="text" class="edu_form_field require" name="email" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_email_address'));?>" autocomplete="off" data-valid="email" data-error="Please enter a valid email address.">
                        </div>
                       
                       <div class="row align-items-center">
                             <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div ><a class="btnSubmit" href="<?php echo base_url('login');?>"><?php echo html_escape($this->common->languageTranslator('ltr_back_to_login'));?></a></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-md-right">
                                <div class="forgot_submit_btn">
                                    <button class="btnSubmit" id="auth_forgot" type="button" data-action="submitThisForm"><?php echo html_escape($this->common->languageTranslator('ltr_submit'));?></button>
                                </div>
                            </div>
                           
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
        </div>
</section> 