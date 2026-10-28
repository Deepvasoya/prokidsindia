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
            <h4 class="edu_title edu_logt_title padderBottom20"><?php echo html_escape($this->common->languageTranslator('ltr_are_you_logout'));?></h4>
            <button type="button" class="edu_admin_btn edu_admin_btn_black edu_btn_black logoutBtnCncl mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_cancel'));?></button>
            <button type="button" class="edu_admin_btn logOutBtn ml-2 mb-2"><?php echo html_escape($this->common->languageTranslator('ltr_yes'));?></button>
        </div>
    </div>
</div>
<!-- Logout end-->
   
</div>
<?php
$urlpg= current_url();
$findkey='add-question';
if (strpos($urlpg, $findkey) == false) { ?>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<?php } ?>
<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url();?>assets/js/timepicker/bootstrap-clockpicker.min.js"></script>
<!--<script src="<?php echo base_url();?>assets/js/datatable/jquery.dataTables.min.js"></script>
-->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>





<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/sp-2.0.0/datatables.min.js"></script>
 
 
 
 





<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url();?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/summernote.js"></script>

<script src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.1/standard-all/ckeditor.js"></script>
<script src="<?php echo base_url();?>assets/js/backend.js?<?php echo time();?>"></script>
<script src="<?php echo base_url();?>assets/js/custom.js?<?php echo time();?>"></script>
  <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>


    
    
    $(document).ready(function () {
       $(".setvalid").click(function () {
          $(".hide_total_valid").show();
          $(".hide_valid_type").show();
          $(".hide_expiry_date").hide();
          
       });
    });
    
    $(document).ready(function () {
       $(".setexp").click(function () {
          $(".hide_total_valid").hide();
          $(".hide_valid_type").hide();
          $(".hide_expiry_date").show();
          
       });
    });
    
    $(document).ready(function () {
       $(".setlifetime").click(function () {
          $(".hide_total_valid").hide();
          $(".hide_valid_type").hide();
          $(".hide_expiry_date").hide();
          
       });
    });
    
    


</script>
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

