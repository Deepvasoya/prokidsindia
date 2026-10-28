 <div class="container">
    <div class="login-inner-section">
            <div class="row">
             <div class="col-md-12 mb-4" style="text-align: center;">
                <!-- <a href="#"><img src="<?php //echo base_url();?>assets/images/logo.png" class="logo-size" /> </a> -->
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
                    <form class="pt-2 pt-lg-5" method="post" action="<?php echo base_url().'front_ajax/register'; ?>" data-redirect="yes">
                        <h4 class="form-title"><?php echo html_escape($this->common->languageTranslator('ltr_p_register_continue'));?></h4>
                        <div class="form-group">
                             <input type="text" name="name" id="name" class="require edu_form_field" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_name'));?>">
                        </div>
                        <div class="form-group">
                              <input type="text" id="email" class="edu_form_field require" name="email" data-valid="email" data-error="Please enter a valid email address." placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_email'));?>" autocomplete="off">
                        </div>
                         <div class="form-group">
                               <input type="text" id="mobile" name="mobile" class="require edu_form_field" data-valid="mobile" data-error="Please enter a valid contact number." placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_mobile'));?>">
                        </div>
                        <div class="form-group">
                              <select class="require form-control filter_batches edu_selectbox_with_search" id="state" name="states" data-placeholder="State" data-count="no">
                                                <option value="">Please select state</option>
                                                <?php
                                                if(!empty($all_states)){
                                                    foreach($all_states as $states){
                                                        echo '<option value="'.$states['vStateName'].'">'.$states['vStateName'].'</option>';
                                                    }
                                                }
                                                ?> 
                                            </select>
                        </div>
                          <input type="hidden" name="batchIdDisplay" id="batchIdDisplay"></input>   
                        <div class="form-group">
                               <input type="text" name="student_city" id="city" class="require edu_form_field" placeholder="City">
                        </div>
                        
                        
                        <div class="form-group text-md-right">
                            <button type="button" onclick="validateForm()" class="edu_btn enrollNowSubmit"><?php echo html_escape($this->common->languageTranslator('ltr_enroll_now'));?></button> 
                            <button class="btnSubmit edu_btn_black" id="auth_login" type="button" data-action="submitThisForm"><?php echo html_escape($this->common->languageTranslator('ltr_register'));?></button>
                        </div>
                        <div class="form-group">
                         <p class="text-continue"><?php echo html_escape($this->common->languageTranslator('ltr_already_account'));?><span><a href="<?php echo base_url().'home/login';?>"> <?php echo html_escape($this->common->languageTranslator('ltr_login_now'));?></a></span></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</section> 
<script>
    
    // Function to get the batchId from the URL
    function getBatchIdFromUrl() {
        var url = window.location.href;
        var urlParts = url.split('/');
        var batchId = urlParts[urlParts.length - 1]; // Assuming the batchId is the last part of the URL
        return batchId;
    }
    
    // Use the function to get the batchId
    var batchId = getBatchIdFromUrl();
    
    
    // You can now use the batchId as needed
    // For example, you can display it or use it in an API call
    document.getElementById('batchIdDisplay').textContent = 'Batch ID: ' + batchId;
    document.getElementById('batchIdDisplay').value = batchId;
    
    
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


