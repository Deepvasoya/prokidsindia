<?php

function closetags($html) {
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i=0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= '</'.$openedtags[$i].'>';
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
} 
?>

<section class="edu_page_title_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <div class="edu_page_title_text">
                    <h1>Blog Page</h1>
                    <ul>
                        <li><a href="http://192.168.0.5/e-academy/">Home</a></li>
                        <li><a href="javascript:void(0);">Blog</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



       <!--   <section class="edu_sglblog_wrapper">
    <div class="container">
        <div class="row">            
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="edu_sglblog_section">
				<?php if(!empty($blog)){ 
						foreach($blog as $value){
							
							$added_by = $this->db_model->select_data('*','users',array('id'=>$value['added_by']),1);
							$comments = count($this->db_model->select_data('*','blog_comments',array('blog_id'=>$value['id'])));
					?>
                    <div class="edu_sglblog_inner bgshadowradios mb_30">
                        <img src="<?php echo base_url('/uploads/blog/').$value['image'] ; ?>" alt="image">
                        <a href="<?php echo base_url('/blog/').$value['id']; ?>" class="edu_sglblog_title"><?php if(!empty($value['title'])){ echo $value['title'] ; } ?></a>
                        <ul class="sglblog_metapost">
                            <li>
                                <a href="<?php echo base_url('/blog/').$value['id']; ?>"> <i class="fas fa-user"></i> <?php if(!empty($added_by)){ echo $added_by[0]['name'] ; } ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('/blog/').$value['id']; ?>"> <i class="fas fa-calendar-alt"></i> <?php echo date('d-m-Y',strtotime($value['create_at'])) ; ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('/blog/').$value['id']; ?>"> <i class="fas fa-comments"></i> <?php echo $comments.' '.html_escape($this->common->languageTranslator('ltr_comments')) ; ?></a>
                            </li>
                        </ul>
                        <p class="edu_sglblog_des mb_30"><?php if(!empty($value['description'])){ if(strlen($value['description'])<250){ echo  closetags(html_entity_decode(substr($value['description'], 0, 250)),ENT_QUOTES, 'UTF-8') ;}else{ echo  closetags(html_entity_decode(substr($value['description'], 0, 250)),ENT_QUOTES, 'UTF-8'); ?> <a href="<?php echo base_url('/blog/').$value['id']; ?>"><?php echo html_escape($this->common->languageTranslator('ltr_read_more'));?> </a> <?php } } ?></p>
                    </div>
					<?php }
						}else{
							echo html_escape($this->common->languageTranslator('ltr_no_blog'));
							} ?>
				</div>		
            </div>
                  </div>
            </div>
    
</section> -->


					

<section class="edu_sglblog_wrapper">
    <div class="container" style="padding: 33px;" data-aos="fade-up" data-aos-delay="100">
        <!-- Category Dropdown Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="edu-select-category">
                    <select id="blogcategory_dropdown" style="margin-top : 10px;" class="form-control">
                        <option value="all">All Categories</option>
                        
                        <?php foreach ($category_data as $cat) { ?>
                            <option value="<?php echo htmlspecialchars($cat['id']); ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php } ?>
                        
                        <option value="other">Other</option>
                        
                    </select>
            </div>
            </div>
            <div class="col-md-4">
						<div class="form-group">
							<select class="form-control edu_selectbox_with_search blogsubcategory_dropdown" id="blogsubcategory_dropdown" style="margin-top:10px;" name="subcategory" data-placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_select_subcategory'));?>">
							     <option value="">Select Subcategory</option>
								<option value=""><?php echo html_escape($this->common->languageTranslator('ltr_select_subcategory'));?></option>
							</select>							
						</div>	
					</div>
        </div>

        <!-- Blog Section -->
        <div id="blog_section" class="row mt-4">
    <?php if (!empty($blog)) {
        foreach ($blog as $value) {
            $added_by = $this->db_model->select_data('*', 'users', array('id' => $value['added_by']), 1);
            $comments = count($this->db_model->select_data('*', 'blog_comments', array('blog_id' => $value['id'])));
    ?>
        <div class="col-lg-4 mb-4">
            <div class="h-100" style="margin-top: 20px;box-shadow: 0 0px 8px rgba(0, 0, 0, 0.2);">
                 <a href="<?php echo base_url('/blog/') . $value['slug']; ?>" class="readmore">
                <img src="<?php echo base_url('/uploads/blog/') . $value['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($value['title']); ?>" style="margin: auto;display: block;height: 250px;width: 100%;">
                <div class="card-body" style="padding: 10px;">
                    <div class="d-flex justify-content-between mb-3">
                        <div style="color: #1b1c25 !important; font-size: 14px;">
                            <span><?php echo htmlspecialchars($value['category']); ?></span>
                        </div>
                        <div style="color: #1b1c25 !important; font-size: 14px;text-align: left;">
                            
                            <span class="mt-1" style="margin-left: 245px;"><?php echo date('d-m-Y', strtotime($value['create_at'])); ?></span>
                        </div>
                        </div>
                    
                    <h5 class="card-title" style="color: black;font-weight:600; margin-top: -25px;"><?php echo htmlspecialchars($value['title']); ?></h5>
                    <div class="description" style="color: black;">
                    <p class="card-text" >
                        <?php
                            $description = html_entity_decode($value['description']);
                            echo (strlen($description) < 150) ? $description : substr($description, 0, 150) . '...';
                        ?>
                    </p>
                    </div>
                   
                        <?php echo 'Read More'; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php 
        }
    } else {
        echo '<p>' . html_escape($this->common->languageTranslator('ltr_no_blog')) . '</p>';
    } ?>
</div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    var base_url = "<?php echo base_url(); ?>"; // Ensure this is set properly

    // Function to fetch and update the blog list and subcategory dropdown
    function fetchBlogsAndSubcategories() {
        var categoryId = $('#blogcategory_dropdown').val();
        var selectedSubcategoryId = $('#blogsubcategory_dropdown').val();

        $.ajax({
            url: base_url + "ajaxcall/filterByCategory",
            type: 'POST',
            dataType: 'json',
            data: { cat_id: categoryId, subcat_id: selectedSubcategoryId },
            success: function(response) {
                // Update subcategory dropdown
                var subcategoryDropdown = $('#blogsubcategory_dropdown');
                subcategoryDropdown.html('<option value="">Select Sub Category</option>');
                
                var subcategoryOptions = '';
                $.each(response.sub_category, function(index, item) {
                    subcategoryOptions += '<option value="' + item.id + '"' + (selectedSubcategoryId == item.id ? ' selected' : '') + '>' + item.name + '</option>';
                });
                subcategoryDropdown.append(subcategoryOptions);

                // Update blog section
                $('#blog_section').html(response.blogs_html);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error); // Handle errors
            }
        });
    }

    // On category change, fetch blogs and update subcategory dropdown
    $('#blogcategory_dropdown').on('change', function() {
        fetchBlogsAndSubcategories();
    });

    // On subcategory change, fetch blogs
    $('#blogsubcategory_dropdown').on('change', function() {
        fetchBlogsAndSubcategories();
    });
});


</script>


        <!--    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="sglblog_sidebar">
                    <!--<div class="edu_sglblog_search bgshadowradios mb_30">
                        <form class="bs_search_form">
                            <input type="search" class="bs_search_field" placeholder="Search" value="" name="s">
                            <button type="submit" class="bs_search_submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div> -->
              <!--      <div class="sglblog_recent bgshadowradios mb_30">
                        <h4 class="edu_cmntitle mb_30"><?php echo html_escape($this->common->languageTranslator('ltr_blog_recent'));?></h4>
                        <ul class="blog_recent_list">
						  <?php if(!empty($recent_blog)){ 
						  foreach($recent_blog as $rvalue){ ?>
                            <li>
                                <div class="blog_thumb">
                                    <a href="<?php echo base_url('/blog/').$rvalue['id']; ?>" >
                                        <img src="<?php echo base_url('/uploads/blog/').$rvalue['image'] ; ?>" alt="image" class="img-fluid">
                                    </a>
                                </div>
                                <div class="blog_content">
                                    <a href="<?php echo base_url('/blog/').$rvalue['id']; ?>"><?php if(!empty($value['title'])){ echo substr(strip_tags($rvalue['title']), 0, 50) ; } ?></a>
                                    <span><?php echo date('d-m-Y',strtotime($rvalue['create_at'])) ; ?></span>
                                </div>
                            </li>
						  <?php 
								}
							 }else{
								echo html_escape($this->common->languageTranslator('ltr_no_blog'));
							} ?>
                    
                        </ul>
                    </div> -->
					<!-- <div class="sglblog_recent bgshadowradios mb_30">
                        <h4 class="edu_cmntitle mb_30"><?php echo html_escape($this->common->languageTranslator('ltr_blog_news'));?></h4>
                        <ul class="blog_recent_list">
						  <?php if(!empty($recent_blog)){ 
						  foreach($recent_blog as $rvalue){ ?>
                            <li>
                                <div class="blog_thumb">
                                    <a href="<?php echo base_url('/blog/').$rvalue['id']; ?>" >
                                        <img src="<?php echo base_url('/uploads/blog/').$rvalue['image'] ; ?>" alt="image" class="img-fluid">
                                    </a>
                                </div>
                                <div class="blog_content">
                                    <a href="<?php echo base_url('/blog/').$rvalue['id']; ?>"><?php if(!empty($value['title'])){ echo substr(strip_tags($rvalue['title']), 0, 50)  ; } ?></a>
                                    <span><?php echo date('d-m-Y',strtotime($rvalue['create_at'])) ; ?></span>
                                </div>
                            </li>
						  <?php 
								}
							 }else{
								echo html_escape($this->common->languageTranslator('ltr_no_news'));
							} ?>
                    
                        </ul>
                    </div> -->
                    <!-- <div class="sglblog_archive bgshadowradios mb_30">
                        <h4 class="edu_cmntitle mb_30"><?php echo html_escape($this->common->languageTranslator('ltr_archives'));?></h4>
                        <ul class="blog_archive_list">
                            <li>
                            <a href="">
                                <span> <i class="fa fa-caret-right" aria-hidden="true"></i> January</span>
                                <span>2021</span>
                            </a>                            
                            </li>
                            <li>
                            <a href="">
                                <span> <i class="fa fa-caret-right" aria-hidden="true"></i> Fabuary</span>
                                <span>2022</span>
                            </a>                            
                            </li>
                            <li>
                            <a href="">
                                <span> <i class="fa fa-caret-right" aria-hidden="true"></i> March</span>
                                <span>2019</span>
                            </a>                            
                            </li>
                            <li>
                            <a href="">
                                <span> <i class="fa fa-caret-right" aria-hidden="true"></i> May</span>
                                <span>2018</span>
                            </a>                            
                            </li>
                            <li>
                            <a href="">
                                <span> <i class="fa fa-caret-right" aria-hidden="true"></i> April</span>
                                <span>2017</span>
                            </a>                            
                            </li>
                        </ul>
                    </div> -->
            <!--       <div class="sglblog_glry bgshadowradios mb_30">
                        <h4 class="edu_cmntitle mb_30"><?php echo html_escape($this->common->languageTranslator('ltr_gallery'));?></h4>
                        <ul class="blog_glry_list">
						    <?php if(!empty($gallery)){ 
							foreach($gallery as $gvalue){?>
                            <li><a href="<?php echo base_url('gallery'); ?>"> <img src="<?php echo base_url('uploads/gallery/').$gvalue['image'] ;?>" alt="image"></a></li>
							<?php } }else{
								echo html_escape($this->common->languageTranslator('ltr_no_image'));
							} ?> 
                        </ul>
                    </div> -->
          