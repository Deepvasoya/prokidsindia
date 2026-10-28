 <div class="container">
    <div class="login-inner-section">
            <div class="row">
             <div class="col-md-12 mb-2 mb-lg-4 mb-md-4" style="text-align: center;">
                <?php if (isset($site_logo)) { ?>
                    <a href="#" class="tp-logo-block"><img src="<?php echo base_url();?>uploads/site_data/<?php echo $site_logo; ?>" class="img-fluid " alt="Site Logo"></a>
                <?php } ?>
             </div>  
            </div>  
            <div class="row">
                <div class="col-md-6 login-form-1 text-center d-none d-md-block d-xl-block">
                   <img src="<?php echo base_url();?>assets/images/login-img-new.png" class="let-img"/>
                </div>
               
                <div class="col-md-6 right-form">
                    <form class="pt-2 pt-lg-5" method="post" action="<?php echo base_url().'front_ajax/login'; ?>" data-redirect="yes">
                        <h3 class="form-title mt-3 mt-lg-0">Welcome<span>Login to continue</span></h3>
                        <div class="form-group">
                          <input type="text" class="edu_form_field require" name="email" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_p_email'));?>" autocomplete="off" value="<?php echo(isset($_COOKIE['UML'])) ? base64_decode(urldecode(base64_decode($_COOKIE['UML']))) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="require form-control" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_password'));?>" value="<?php echo(isset($_COOKIE['SSD'])) ? base64_decode(urldecode(base64_decode($_COOKIE['SSD']))) : ''; ?>">
                        </div>
                        <input type="hidden" name="device_id" id="device_id">
                        <input type="hidden" id="batchIdDisplay" value=''></input>   
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="loginLinks checkbox_holder">
                                        <input type="checkbox" id="auth_remember" name="remember_me" <?php echo(isset($_COOKIE['UML'])) ? 'checked':''; ?>> 
                                       
                                    <label for="auth_remember"><?php echo html_escape($this->common->languageTranslator('ltr_remember_me'));?>
                                        
                                    </label>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="form-group text-md-right">
                            <button class="btnSubmit" id="auth_login" type="button" data-action="submitThisForm"><?php echo html_escape($this->common->languageTranslator('ltr_login'));?></button>
                        </div>
                        <div class="form-group">
                      
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</section> 