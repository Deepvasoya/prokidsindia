<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_teacher_manager">
		<!--<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
	        <a href="#input_feilds_teacher" class="edu_admin_btn ml-2 add_doubt_ask"><i class="icofont-plus"></i>Add Doubt Ask</a>
	    </div>-->
	     <!--<div class="edu_table_wrapper mb_30">-->
      <!--      <div class="edu_admin_informationdiv sectionHolder">-->
      <!--          <div class="row">-->
                  
      <!--              <div class="col-lg-3 col-md-3 col-sm-6 col-12">-->
                        
      <!--                  <div class="form-group">-->
      <!--                      <span>-->
      <!--                          <input type="text" Class="form-control chooseDate from_date" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_from_date'));?>"> -->
      <!--                      </span>-->
      <!--                  </div>-->
                       
      <!--              </div>-->
      <!--              <div class="col-lg-3 col-md-3 col-sm-6 col-12">-->
                        
      <!--                  <div class="form-group">-->
      <!--                      <span>-->
      <!--                          <input type="text" Class="form-control chooseDate to_date" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_to_date'));?>"> -->
      <!--                      </span>-->
      <!--                  </div>-->
                        
      <!--              </div>-->
      <!--              <div class="col-lg-3 col-md-3 col-sm-6 col-12">-->
                        
      <!--                  <div class="form-group">-->
      <!--                      <span> -->
      <!--                          <input type="button" value="<?php echo html_escape($this->common->languageTranslator('ltr_search'));?>" Class="btn btn-primary filter_payment_history"> -->
      <!--                      </span>-->
      <!--                  </div>-->
                       
      <!--              </div>-->
                    
      <!--          </div>-->
      <!--      </div>-->
      <!--  </div>-->
		<?php 
			if(!empty($refrel_history)){
				
			?>
		<div class="edu_main_wrapper edu_table_wrapper sectionHolder ">
			<div class="edu_admin_informationdiv">
                <div class="tableFullWrapper">
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" id="withdrawManager"  cellspacing="0" width="100%" data-url="ajaxcall/referral_history">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo html_escape($this->common->languageTranslator('ltr_name'));?></th>
                                <th>phone</th>
                                <th>email</th>
                                <th>refer id</th>
                                <th>total referred</th>
                                <th>total earning</th>
                                <th class="no-sort">total withdrawal</th>
                            </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
		<?php 
			}else{ 
			    
		         echo '<section class="edu_admin_content">
                    <div class="edu_admin_right sectionHolder edu_add_users">
                        <div class="edu_admin_informationdiv edu_main_wrapper">
                            <div class="eac_text eac_page_re">'.html_escape($this->common->languageTranslator('ltr_no_record')).'</div>
                    </div>
                </section>';
			    
			} ?>
	</div>
</section> 

<!-- Pop Up Start  -->
<div id="stImgModal" class="edu_popup_container mfp-hide">
    <div class="edu_popup_wrapper">
        <div class="edu_popup_inner">
            <h4 class="edu_sub_title" id="stImgModalLabel"><?php echo html_escape($this->common->languageTranslator('ltr_student_image'));?></h4>
            <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group text-center">
						<img id="std_img" class="stdnt_proflie_img" src="" alt="Student Image"/>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
    
     $('.dataTable').on('click', 'tbody td', function() {

  //get textContent of the TD
  console.log('TD cell textContent : ', this.textContent)

  //get the value of the TD using the API 
  console.log('value by API : ', table.cell({ row: this.parentNode.rowIndex, column : this.cellIndex }).data());
})
</script>
