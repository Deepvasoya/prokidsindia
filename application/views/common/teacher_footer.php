<!-- Pop view characters Start  -->
<div id="charactersViewPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
           <h4 class="edu_sub_title" id="charaTitele"></h4>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
                        <div class="charactersViewResult"></div>
                    </div>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="edu_admin_footer hide">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p><?php echo html_escape($this->common->copyrightText); ?>
        	<img style="width: 20%"; src="<?php echo base_url()?>assets/images/IMG-20240316-lmh.jpg" alt=""></p></p>
    </div>
</div>

<!-- Logout start-->
<div id="logoutPopup" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner text-center">
            <h4 class="edu_title edu_logt_title padderBottom20"><?php echo html_escape($this->common->languageTranslator('ltr_already_logout'));?></h4>
            <button type="button" class="edu_admin_btn edu_admin_btn_black edu_btn_black logoutBtnCncl mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_cancel'));?></button>
            <button type="button" class="edu_admin_btn logOutBtn ml-2 mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_yes'));?></button>
        </div>
    </div>
</div>
<!-- Logout end-->
   
</div>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url();?>assets/js/timepicker/bootstrap-clockpicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.1/standard-all/ckeditor.js"></script>
<script src="<?php echo base_url();?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/summernote.js"></script>
<script src="<?php echo base_url();?>assets/js/backend.js?<?php echo time();?>"></script>
<script src="<?php echo base_url();?>assets/js/custom.js?<?php echo time();?>"></script>
 <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>
<script>
   
    function showDiv(select){
        if(select.value==1){
            document.getElementById('question_options').style.display = "none";
            document.getElementById('chooserightans').style.display = "none";
            document.getElementById('quesdescription').style.display = "none";
            document.getElementById('total_options').style.display = "none";
            document.getElementById('fill_options').style.display = "none";
            document.getElementById('singleanswer').style.display = "block";
            
        }else if(select.value==2){
            document.getElementById('question_options').style.display = "block";
            document.getElementById('chooserightans').style.display = "block";
            document.getElementById('quesdescription').style.display = "block";
            document.getElementById('total_options').style.display = "none";
            document.getElementById('fill_options').style.display = "none";
            document.getElementById('singleanswer').style.display = "none";
        }else if(select.value==3){
            document.getElementById('question_options').style.display = "none";
            document.getElementById('chooserightans').style.display = "none";
            document.getElementById('quesdescription').style.display = "none";
            document.getElementById('singleanswer').style.display = "none";
            document.getElementById('total_options').style.display = "block";
            document.getElementById('fill_options').style.display = "block";
        }
    } 

    function showAnswers(select){
        
        if(select.value==1){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "none";
            document.getElementById('3answer').style.display = "none";
            document.getElementById('4answer').style.display = "none";
            document.getElementById('5answer').style.display = "none";
            document.getElementById('6answer').style.display = "none";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
            
        }else if(select.value==2){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "none";
            document.getElementById('4answer').style.display = "none";
            document.getElementById('5answer').style.display = "none";
            document.getElementById('6answer').style.display = "none";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==3){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "none";
            document.getElementById('5answer').style.display = "none";
            document.getElementById('6answer').style.display = "none";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==4){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "none";
            document.getElementById('6answer').style.display = "none";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==5){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "none";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==6){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "block";
            document.getElementById('7answer').style.display = "none";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==7){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "block";
            document.getElementById('7answer').style.display = "block";
            document.getElementById('8answer').style.display = "none";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==8){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "bloc";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "block";
            document.getElementById('7answer').style.display = "block";
            document.getElementById('8answer').style.display = "block";
            document.getElementById('9answer').style.display = "none";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==9){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "block";
            document.getElementById('7answer').style.display = "block";
            document.getElementById('8answer').style.display = "block";
            document.getElementById('9answer').style.display = "block";
            document.getElementById('10answer').style.display = "none";
        }else if(select.value==10){
            document.getElementById('1answer').style.display = "block";
            document.getElementById('2answer').style.display = "block";
            document.getElementById('3answer').style.display = "block";
            document.getElementById('4answer').style.display = "block";
            document.getElementById('5answer').style.display = "block";
            document.getElementById('6answer').style.display = "block";
            document.getElementById('7answer').style.display = "block";
            document.getElementById('8answer').style.display = "block";
            document.getElementById('9answer').style.display = "block";
            document.getElementById('10answer').style.display = "block";
        }
        
    } 
    
</script>
</body>
</html>
