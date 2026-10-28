
text/x-generic batch_cat_manage.php ( HTML document, ASCII text )
<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_subject_manager">			
		<div class="edu_btn_wrapper sectionHolder padderBottom30 text-right">
           <a href="<?php echo base_url(); ?>admin/batchActivation" class="edu_admin_btn"><i class="icofont-arrow-left"></i>Back</a>
	    </div>
	    <?php if($_SESSION['super_admin'] == '1'){ ?>
        <div class="edu_table_wrapper mb_30">
            <div class="edu_admin_informationdiv sectionHolder">
               
            </div>
        </div>
        <?php } ?>
	       <div class="createDivWrapper edu_add_question create_ppr_popup hide">
    		<div class="edu_admin_informationdiv sectionHolder">
    		    <div class="ppr_popup_inner">
        			<div class="row align-items-center text-center">
        			    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<button class="multiDelete btn_delete btn btn-primary"  data-table="batch_category" data-column="id"><?php echo html_escape($this->common->languageTranslator('ltr_delete'));?></button>
        		</div>
					</div>
        		</div>
    		</div>
		</div>
		<?php 
			if(!empty($batchCode)){ 
			?>
	    <div class="edu_main_wrapper edu_table_wrapper">
			<div class="edu_admin_informationdiv sectionHolder">
                <div class="tableFullWrapper">
                    
                    <table class="server_datatable datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/batchactivationcode_table/<?php echo $batch_activation_id; ?>">
                        <thead>
                            <tr>  
                                <th>#</th>
                                <th>Code</th>
                                <th>Used</th>
                                <th>Date</th>
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
                                <div class="eac_text eac_page_re">No Batch Activation Code Data</div>
                            </div>
                        </div>
                    </section>';
			} ?>
	    
	    
					</div>
			</section>
			            
			






