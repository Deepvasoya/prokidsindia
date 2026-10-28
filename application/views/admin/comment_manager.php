<section class="edu_admin_content">
	<div class="edu_admin_right sectionHolder edu_manage_exam_wrap">
	     
    	<?php 
		if(!empty($commentCount) && $commentCount>=1){
		?>
		<div class="edu_admin_informationdiv sectionHolder">
            <div class="edu_main_wrapper edu_table_wrapper">
		        <div class="tableFullWrapper">
		           
				    <table  class="tblCommentList datatable table table-striped table-hover dt-responsive" cellspacing="0" width="100%" data-url="ajaxcall/comment_table/<?php echo $id; ?>">
    			        <thead>
                            <tr> 
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th>Actions</th>
                                
                                <!--<th>Status</th>-->
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
                                <div class="eac_text eac_page_re">No Comment Found!!</div>
                            </div>
                        </div>
                    </section>';
			} ?>
	</div>
</section>

<script>

</script>

