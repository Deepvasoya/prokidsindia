<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
  .yash-slider {
      width: 100%;
      height: 50vh;
      background-image: url(assets/images/backhome.webp);
      background-repeat: no-repeat;
      background-size: contain;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
  }

  .yash-slider .outer-slider {
      width: 90%;
      height: 100%;
      position: relative;
      overflow: hidden; /* Hide overflowing slides */
  }

  .yash-slider #slider {
      display: flex;
      transition: transform 0.5s ease; /* Smooth sliding effect */
  }

  .yash-slider #slider img {
      width: 100%;
      height: 100%;
      flex-shrink: 0;
  }

  .yash-slider .controls {
      width: 100%;
      position: absolute;
      top: 0;
      height: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      pointer-events: none;
  }

  .yash-slider .controls i {
      color: grey;
      font-size: 24px;
      padding: 0 10px;
      cursor: pointer;
      pointer-events: all;
  }

  .yash-slider .controls i:hover {
      background-color: rgba(0, 0, 0, 0.293);
      line-height: 20;
  }
  
  
  .slider-wrapper {
  position: relative;
}

.slider-wrapper .slide-button {
  position: absolute;
  top: 38%;
  outline: none;
  border: none;
  height: 35px;
  width: 35px;
  z-index: 5;
  color: black;
  display: flex;
  cursor: pointer;
  background: white;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transform: translateY(-50%);
  box-shadow: 0px 0px 0px 1px #80808070;
}

.slider-wrapper .slide-button#prev-slide {
  left: 10px;
  display: none;
}

.slider-wrapper .slide-button#next-slide {
  right: 10px;
}

.slider-wrapper .image-list {
  display: flex;
  gap: 18px;
  list-style: none;
  margin-bottom: 30px;
  overflow-x: auto;
  scrollbar-width: none;
}

.slider-wrapper .image-list::-webkit-scrollbar {
  display: none;
}

.slider-wrapper .image-list .card {
  min-width: 197px;
  border-radius: 10px;
  width: 200px;
  cursor: pointer;
}
.slider-wrapper .image-list .card:hover .card-content::after {
    background-color: #5569bd;
    width: 100%;
    border-radius: 10px;
  }
.slider-wrapper .image-list .card .card-content::after {
  / background-color: #5569bd; /
  left: 0px;
  bottom: 0px;
  content: "";
  height: 3px;
  transition: 0.3s;
  position: absolute;
}

.card.image-list-section:hover .card-content p {
  color: #5569bd;
}

.card .card-content p {
  font-size: 14px;
  font-weight: 500;
}
.card .card-content-para .para-1 {
  font-size: 13px;
  font-weight: 700;
  background-color: rgb(51, 208, 103);
  color: white;
  border-radius: 15px;
  text-align: center;
  width: 70px;
  padding: 2px 0;
  margin: 5px 0;
}
.card .card-content-para .para-2 .h5 {
  color: #4b566b;
}
.card .card-content-para .para-2 .ps-2 {
  color: #5569bd;
}
.slider-wrapper .image-list .image-item {
  width: 100%;
  height: 218px;
  object-fit: inherit;
  border-radius: 10px;
}
.image-list .card .card-content p {
  padding-top: 5px;
  color: black;
  margin: 0;
}

@media only screen and (max-width: 992px) {
    .slider-wrapper .image-list .card {
        border-radius: 10px;
        cursor: pointer;
        min-width: auto;
      }
    .slider-wrapper .image-list .image-item {
      max-width: 200px !important;
      height: auto;
      object-fit: contain;
    }
    .card .card-content p {
        font-size: 13px;
      }
      .slider-wrapper h4{
        font-size: 19px;
      }
  }
@media only screen and (max-width: 1023px) {
  .slider-wrapper .image-list {
    gap: 10px;
    margin-bottom: 15px;
    scroll-snap-type: x mandatory;
  }
}

  
  
</style>




 <div class="container">
  <div class="yash-slider">
      <div class="outer-slider">
          <div id="slider">
              <?php 
                  // Fetch banner data from the database
                  $homeBaner = $this->db_model->select_data('*', 'home_banners use index (id)', array('status'=>'1','admin_id'=>'1'), 3, array('id', 'DESC'));
                  
                  // Loop through each banner and create image elements dynamically
                  foreach($homeBaner as $index => $baner) { 
              ?>
                  <img class="slides <?php echo ($index == 0) ? 'active' : ''; ?>" 
                       src="<?php echo base_url('uploads/home_banners/') . $baner['banner']; ?>" 
                       alt="" 
                       width="100%">
              <?php 
                  } 
              ?>	
          </div>
          <div class="controls">
              <i onclick="imageSlides(-1)" class="fa fa-chevron-left"></i>
              <i onclick="imageSlides(1)" class="fa fa-chevron-right"></i>
          </div>
      </div>
  </div>
</div>

<div class="row">
    <div class="container" style="padding-left : 10px;">
        <div class="slider-wrapper" data-bs-ride="carousel">
            <h4 class="text-center pb-4 fw-bold">Explore Our Top Selling Courses</h4>
            <button id="prev-slide" class="slide-button material-symbols-rounded" style="margin-top: 58px;">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <ul class="image-list" style="padding: 0;">
                <?php
                // Loop through the batches to create slider items
                if (!empty($batches)) {
                    foreach ($batches as $batch) {
                        $originalPrice = $batch['batch_price'];
                        $offerPrice = $batch['batch_offer_price'];

                        // Calculate percentage discount if price is not free and offer price is lower
                        if (!empty($offerPrice) && !empty($originalPrice) && $originalPrice > $offerPrice && $originalPrice > 0) {
                            $percentageDiscount = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                            $percentageDiscount = round($percentageDiscount); // Round to nearest whole number
                        }
                ?>
                <div class="card image-list-section">
                    <img src="<?php echo !empty($batch['batch_image']) ? base_url('uploads/batch_image/') . $batch['batch_image'] : base_url('uploads/site_data/' . $site_Details[0]['site_logo']); ?>" class="image-item" alt="" width="100%">
                    <div class="card-content px-2">
                        <p><?php echo $batch['batch_name']; ?></p>
                        <div class="card-content-para">
                            <div class="para-1">
                                <?php if (isset($percentageDiscount)) {
                                    echo $percentageDiscount . '% off'; // Display calculated discount percentage
                                } ?>
                            </div>
                            <div class="para-2 d-flex">
                                <h5 class="h5">
                                    <?php if (!empty($offerPrice) && $originalPrice > 0) { ?>
                                        <del><?php echo html_escape($originalPrice); ?></del>
                                    <?php } ?>
                                </h5>
                                <h4 class="ps-2"><?php echo html_escape(!empty($offerPrice) ? $offerPrice : ($originalPrice > 0 ? $originalPrice : 'Free')); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        // Unset discount for next iteration
                        unset($percentageDiscount);
                    }
                }
                ?>
            </ul>
            <button id="next-slide" class="slide-button material-symbols-rounded" style="margin-top: 58px;">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        <div class="slider-scrollbar">
            <div class="scrollbar-track">
                <div class="scrollbar-thumb"></div>
            </div>
        </div>
    </div>
</div>





<div style="width: 100%; margin-top:10px">
<a href="https://lmh.graceify.in/"><img src="https://app.lmh-ai.in/uploads/app_download/app_download.jpg" alt="Image" style="width: 100%; height: 100%; object-fit: fit; border-radius: 10px; margin-top : 20px; margin-bottom : 20px;"></a>
</div>


<div class="container pt-5">
    <div class="row">
        <div class="container" style="padding : 10px;">
            <h4 class="text-center pb-4 fw-bold">Explore Our Trending Course</h4>
            
            <ul class="nav edu-nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="active" id="home-tab" data-toggle="tab" href="#trending" role="tab" aria-selected="true">Trending</a>
                </li>
                <li class="nav-item">
                    <a id="profile-tab" data-toggle="tab" href="#free" role="tab" aria-selected="false">Free</a>
                </li>
                <li class="nav-item">
                    <a id="contact-tab" data-toggle="tab" href="#new" role="tab" aria-selected="false">New</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Trending Courses Tab -->
                <div class="tab-pane fade show active" id="trending" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <?php
                        if (!empty($trending_courses)) {
                            foreach ($trending_courses as $trend) { 
                        ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card image-list-section"  style = "border-radius : 10px;">
                                    <img src="<?php echo !empty($trend['batch_image']) ? base_url('uploads/batch_image/') . $trend['batch_image'] : base_url('uploads/site_data/' . $site_Details[0]['site_logo']); ?>" class="image-item" alt="Course Image" width="100%" style="border-radius: 10px 10px 0 0; height: 200px;">
                                    <div class="card-content px-2" style="height: 98px;">
                                        <p><?php echo html_escape($trend['batch_name']); ?></p>
                                        <div class="card-content-para">
                                            <div class="para-1">
                                                <?php
                                                if (!empty($trend['batch_offer_price']) && !empty($trend['batch_price'])) {
                                                    $originalPrice = $trend['batch_price'];
                                                    $offerPrice = $trend['batch_offer_price'];
                                                    $discountPercentage = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                                                    echo '<span class="text-success">' . round($discountPercentage) . '% off</span>';
                                                }
                                                ?>
                                            </div>
                                            <div class="para-2 d-flex">
                                                <h5 class="h5">
                                                    <?php if (!empty($trend['batch_offer_price'])) { ?>
                                                        <del><?php echo html_escape($trend['batch_price']); ?></del>
                                                    <?php } ?>
                                                </h5>
                                                <h4 class="ps-2"><?php echo html_escape(!empty($trend['batch_offer_price']) ? $trend['batch_offer_price'] : $trend['batch_price']); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            } 
                        } 
                        ?>
                    </div>
                </div>

                <!-- Free Courses Tab -->
                <div class="tab-pane fade" id="free" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <?php
                        if (!empty($free_courses)) {
                            foreach ($free_courses as $free) { 
                        ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card image-list-section">
                                    <img src="<?php echo !empty($free['batch_image']) ? base_url('uploads/batch_image/') . $free['batch_image'] : base_url('uploads/site_data/' . $site_Details[0]['site_logo']); ?>" class="image-item" alt="Course Image" width="100%" style="height: 200px;">
                                    <div class="card-content px-2" style="height: 98px;">
                                        <p><?php echo html_escape($free['batch_name']); ?></p>
                                        <div class="card-content-para">
                                            <div class="para-1">
                                                <?php
                                                if (!empty($free['batch_offer_price']) && !empty($free['batch_price'])) {
                                                    $originalPrice = $free['batch_price'];
                                                    $offerPrice = $free['batch_offer_price'];
                                                    $discountPercentage = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                                                    echo '<span class="text-success">' . round($discountPercentage) . '% off</span>';
                                                }
                                                ?>
                                            </div>
                                            <div class="para-2 d-flex">
                                                <h5 class="h5">
                                                    <?php if (!empty($free['batch_offer_price'])) { ?>
                                                        <del><?php echo html_escape($free['batch_price']); ?></del>
                                                    <?php } ?>
                                                </h5>
                                                <h4 class="ps-2"><?php echo html_escape(!empty($free['batch_offer_price']) ? $free['batch_offer_price'] : $free['batch_price']); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            } 
                        } 
                        ?>
                    </div>
                </div>

                <!-- New Courses Tab -->
                <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <?php
                        if (!empty($new_courses)) {
                            foreach ($new_courses as $new) { 
                        ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card image-list-section">
                                    <img src="<?php echo !empty($new['batch_image']) ? base_url('uploads/batch_image/') . $new['batch_image'] : base_url('uploads/site_data/' . $site_Details[0]['site_logo']); ?>" class="image-item" alt="Course Image" width="100%" style="height: 200px;">
                                    <div class="card-content px-2" style="height: 98px;">
                                        <p><?php echo html_escape($new['batch_name']); ?></p>
                                        <div class="card-content-para">
                                            <div class="para-1">
                                                <?php
                                                if (!empty($new['batch_offer_price']) && !empty($new['batch_price'])) {
                                                    $originalPrice = $new['batch_price'];
                                                    $offerPrice = $new['batch_offer_price'];
                                                    $discountPercentage = (($originalPrice - $offerPrice) / $originalPrice) * 100;
                                                    echo '<span class="text-success">' . round($discountPercentage) . '% off</span>';
                                                }
                                                ?>
                                            </div>
                                            <div class="para-2 d-flex">
                                                <h5 class="h5">
                                                    <?php if (!empty($new['batch_offer_price'])) { ?>
                                                        <del><?php echo html_escape($new['batch_price']); ?></del>
                                                    <?php } ?>
                                                </h5>
                                                <h4 class="ps-2"><?php echo html_escape(!empty($new['batch_offer_price']) ? $new['batch_offer_price'] : $new['batch_price']); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            } 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



  <script>
     let slideIndex = 0;
const slider = document.getElementById("slider");
const slides = document.getElementsByClassName("slides");

function showSlides(n) {
    // Normalize the slide index
    if (n >= slides.length) {
        slideIndex = 0;
    } else if (n < 0) {
        slideIndex = slides.length - 1;
    } else {
        slideIndex = n;
    }

    // Calculate the translate value for right-to-left sliding
    const translateValue = -slideIndex * 100;
    slider.style.transform = `translateX(${translateValue}%)`;
}

function imageSlides(n) {
    showSlides(slideIndex + n);
}

function autoSlide() {
    slideIndex++;
    if (slideIndex >= slides.length) slideIndex = 0;
    showSlides(slideIndex);
    setTimeout(autoSlide, 5000); // Change slide every 3 seconds
}

// Start auto slide when the page loads
window.onload = function() {
    autoSlide();
};


const initSlider = () => {
        const imageList = document.querySelector(".slider-wrapper .image-list");
        const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
        const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
        const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
        const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
    
        scrollbarThumb.addEventListener("mousedown", (e) => {
            const startX = e.clientX;
            const thumbPosition = scrollbarThumb.offsetLeft;
            const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;
    
            const handleMouseMove = (e) => {
                const deltaX = e.clientX - startX;
                const newThumbPosition = thumbPosition + deltaX;
    
                const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
                const scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;
                
                scrollbarThumb.style.left = `${boundedPosition}px`;
                imageList.scrollLeft = scrollPosition;
            }
    
            const handleMouseUp = () => {
                document.removeEventListener("mousemove", handleMouseMove);
                document.removeEventListener("mouseup", handleMouseUp);
            }
    
            document.addEventListener("mousemove", handleMouseMove);
            document.addEventListener("mouseup", handleMouseUp);
        });
    
        slideButtons.forEach(button => {
            button.addEventListener("click", () => {
                const direction = button.id === "prev-slide" ? -1 : 1;
                const scrollAmount = imageList.clientWidth * direction;
                imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
            });
        });
    
        const handleSlideButtons = () => {
            slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "block";
            slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "block";
        }
    
        const updateScrollThumbPosition = () => {
            const scrollPosition = imageList.scrollLeft;
            const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
            scrollbarThumb.style.left = `${thumbPosition}px`;
        }
    
        imageList.addEventListener("scroll", () => {
            updateScrollThumbPosition();
            handleSlideButtons();
        });
    }
    
    window.addEventListener("resize", initSlider);
    window.addEventListener("load", initSlider);
  </script>