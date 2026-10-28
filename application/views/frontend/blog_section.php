
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
