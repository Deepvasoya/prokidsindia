 
 <head>
 <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
</head>


<style>

iframe {
pointer-events: none;
}


@media (max-width: 600px) {
        #video-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

#video-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr); /* 6 columns */
        gap: 70px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
    }
    

.plyr__video-embed iframe {
pointer-events: none !important;
}

.plyr__video-embed iframe {
position: relative;
width: 100%;
height: 100%;

}

.plyr__video-embed::after {
content: "";
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: transparent;

}


.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
 
  padding: 20px;
  justify-content: center;
}
.video-card {
   background-color: #fff;
  border-radius: 8px;
  height:20%;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
  width: 30%;
  overflow: hidden;
  transition: transform 0.2s;
  margin-left: 5px;
}
.video-card:hover {
  transform: scale(1.05);
}
.thumbnail {
  width: 100%;
  height: 55%;
  padding : 10px;
  display: block; /* Ensures proper alignment */
  margin: 0 auto;
}
.video-info {
  padding: 10px;
}
.title {
  font-size: 16px;
  text-align: center;
  font-weight: bold;
  margin: 10px 0 5px;
}
.channel-name {
  color: #606060;
  font-size: 14px;
}

      
      


 
   .block {
       height : 60px;
       
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .block-icon {
        font-size: 24px;
        margin-right: 15px;
    }
    .block-name {
        flex-grow: 1;
    }
   .arrow-btn {
background-color: white;
color: black;
border: none;
border-radius: 50%; /* Make it a circle */
width: 40px; /* Adjust size as needed */
height: 40px; /* Adjust size as needed */
display: flex;
align-items: center; /* Center content vertically */
justify-content: center; /* Center content horizontally */
cursor: pointer;
font-size: 14px;
padding: 0; /* Remove default padding */
text-align: center; /* Center text horizontally */
}

.arrow-btn i {
font-size: 18px;
 margin-right:0 !important;
}

    .arrow-btn:hover {
        background-color: #0056b3;
    }
    .block h1, .block h3 {
        margin: 0;
        color: white;
        font-size: 19px;
    }
    
    .block-icon img{
        height:45px;
    }
    
    .block-link {
display: block;
text-decoration: none; /* Remove underline from the link */
}

.list-container {
margin-top: 20px;
}

.list-container ul {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(600px, 1fr));
gap: 10px;
list-style-type: none;
padding: 0;
margin: 0;
}

@media (max-width: 1200px) {
  .video-card {
    width: 30%; /* 3 cards per row on medium screens */
  }
}

@media (max-width: 768px) {
  .video-card {
    width: 45%; /* 2 cards per row on tablets */
  }
}

@media (max-width: 480px) {
  .video-card {
    width: 90%; /* Full-width cards on small screens */
  }
}



@media (max-width: 768px) {
.list-container ul {
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
}
}

@media (max-width: 480px) {
.list-container ul {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
}
}


@media (max-width: 768px) {
.block-name ul li {
    font-size: 20px;
}
}

@media (max-width: 480px) {
.block-name ul li {
    font-size: 20px;
}
}

.list-container ul li {
height: 133px;
font-size: 35px;
background-color: #0f4d92;
color: white;
padding: 24px;
border-radius: 8px;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
text-align: center;
}

.list-container ul li:hover {
background-color: #0056b3;
}

.tableFullWrapper {
overflow-x: auto;
}

.tableFullWrapper table {
min-width: 1000px; /* Adjust this value as needed */
}

.videoIframeShow {
position: relative;
width: 100%;
height:100%;
overflow: hidden;
}

.video-overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
pointer-events: none; /* Ensures the overlay does not interfere with video interactions */
}

.animated-text {
position: absolute;
font-size: 17px; /* Adjust as needed */
color: white; /* Text color for contrast */
background-color: transparent; /* Optional: background color for better readability */
padding: 10px;
border-radius: 5px;
white-space: nowrap;
z-index: 9999; /* Ensure the text is on top of other content */
animation: moveText 40s linear infinite; /* Total duration = 4 positions * 10s per position */
}

:fullscreen .animated-text,
:-webkit-full-screen .animated-text,
:-ms-fullscreen .animated-text {
display: block; /* Ensure visibility in full-screen mode */
}

.item {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        text-align: center;
        padding: 91px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 8px;
    }


.image-container {
        display: flex;
        gap: 10px;
        overflow-x: scroll; /* Forces horizontal scrolling */
        white-space: nowrap;
        padding: 10px;
        width: 100%;
        height: 160px; /* Ensure enough space */
        border: 1px solid black; /* Just for visibility */
    }

    .image-container img {
        width: 200px;
        height: auto;
        border-radius: 10px;
        flex-shrink: 0; /* Prevents images from shrinking */
    }

    /* Show scrollbar */
    .image-container::-webkit-scrollbar {
        height: 8px; /* Set scrollbar height */
    }

    .image-container::-webkit-scrollbar-thumb {
        background: #888; /* Scrollbar color */
        border-radius: 4px;
    }

    .image-container::-webkit-scrollbar-track {
        background: #f1f1f1; /* Scrollbar track color */
    }
    
    

@keyframes moveText {
0%, 9.99% {
    opacity: 1;
    top: 100%; /* Bottom position */
    left: 50%;
    transform: translate(-50%, -100%);
}
10%, 24.99% {
    opacity: 0; /* Hide during transition */
}
25%, 34.99% {
    opacity: 1;
    top: 50%; /* Left position */
    left: 0%;
    transform: translate(0%, -50%);
}
35%, 49.99% {
    opacity: 0; /* Hide during transition */
}
50%, 59.99% {
    opacity: 1;
    top: 0%; /* Top position */
    left: 50%;
    transform: translate(-50%, 0%);
}
60%, 74.99% {
    opacity: 0; /* Hide during transition */
}
75%, 84.99% {
    opacity: 1;
    top: 50%; /* Right position */
    left: 100%;
    transform: translate(-100%, -50%);
}
85%, 100% {
    opacity: 0; /* Hide during transition */
}
}

.commentBox{
    position: sticky;
    bottom: 0; /* Stick to the bottom of the container */ 
    background-color: #f1f1f1; /* Example background color */
    padding: 10px 0; /* Example padding */
    box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1); /* Example shadow */
}

.commentInput{
    width: 73%;
}    

.commentSend{
    width: 27%;
}

.comment {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
.comment strong {
    color: #336699;
}
.comment p {
    margin: 0;
}
.comment .date {
    font-size: 0.8em;
    color: #999;
}
    
  
@media (max-width: 991px) {
.mfp-content {
    position: absolute!important;
    top: 50%!important;
    
    transform: translate(-50%,-50%)!important;
    z-index: 10!important;
}

/* Basic styling for the popup */
.edu_popup_container {
position: relative;
}


.ytp-hide-controls:not(.ytp-mweb-player) .ytp-watermark{
display: none !important;
}
}

.pcontainer {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr; /* Two equal columns */
        gap: 20px; /* Space between grid items */
        max-width: 1225px;
        margin: auto;
        padding: 20px;
    }
    .container {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Two equal columns */
        gap: 20px; /* Space between grid items */
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    .grid-item {
        display: grid;
        grid-template-columns: 1fr 2fr; /* Image takes 1 part, text takes 2 parts */
        gap: 15px;
        align-items: center;
          background-color: #0f4d92;
        padding: 15px;
        border-radius: 10px;
    }

    .image img {
        width: 100%;
        height:80px;
        border-radius: 10px;
    }

    .content {
        font-family: Arial, sans-serif;
        color:white;
    }

    @media (max-width: 768px) {
        .container {
            grid-template-columns: 1fr; /* Stack items on small screens */
        }

        .grid-item {
            grid-template-columns: 1fr; /* Stack image and text */
            text-align: center;
        }
    }



      .edu_popup_inner {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
    }
    
    .video-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }
    
    /*.video-section {*/
    /*    flex: 1;*/
    /*    padding: 10px;*/
    /*}*/
    
    .video-section {
background-size: cover;
background-position: center;
padding: 20px;
border-radius: 12px;
display: inline-block;
}

    
    .number-section {
        flex: 0.3;
        padding: 10px;
        text-align: center;
        
    }
    
    .number-title {
        margin-top:33px;
        font-size: 18px;
        margin-bottom: 15px;
        font-weight: bold;
        color: #006eff;
    }
    
    .number-grid {
        display: grid;
        gap: 23px;
        grid-template-columns: 50px 50px;
        justify-content: center;
        margin-left: 40px;    
        row-gap: 12px;
    }
    
       .number-item {
        background-image: url('https://app.prokidsindia.com/assets/images/green.jpeg');
        background-size: cover;
        background-position: center;
        /*border-radius: 8px;*/
        width: 59px;
        color: black;
        padding: 10px;
        cursor: pointer;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        transition: background-image 0.3s ease;
    }
    
    .number-item.active {
        background-image: url('https://app.prokidsindia.com/assets/images/yellow.jpeg');
        color: red;
    }

    .number-item:hover {
        background-color: #e53935;
    }

  
    






</style>  

<!-- HTML Structure -->


         <style>
         .back-btn-p {
  background: #4a90e2;
  color: #fff;
  text-decoration: none;
  padding: 10px 25px;
  border-radius: 50px;
  font-size: 18px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.back-btn-p i {
  font-size: 20px;
}

.back-btn-p:hover {
  background: #2d78c8;
  transform: scale(1.05);
}
</style>



<section class="edu_admin_content" id="subject-section">

   <div style="display:flex; justify-content:center; margin-top:10px;">
  <a class="back-btn-p" href="https://app.prokidsindia.com/student/my-course">
      <i class="fa fa-chevron-left"></i> Back
  </a>
</div>

    
    <div class="pcontainer">

    <?php
    usort($subject, function($a, $b) {

        // Function to extract number (start or end)
        $getNumber = function($text) {
            // Check number at start (e.g. "1 - WEEK")
            if (preg_match('/^\s*(\d+)/', $text, $match)) {
                return (int)$match[1];
            }
            // Else check number at end (e.g. "unit-10")
            if (preg_match('/(\d+)\s*$/', $text, $match)) {
                return (int)$match[1];
            }
            return 0;
        };

        $num1 = $getNumber($a['subject']);
        $num2 = $getNumber($b['subject']);

        return $num1 - $num2;
    });
    ?>

    
    <?php foreach ($subject as $sub): 
    
    $this->db->select('thumbnail');
    $this->db->from('subjects');
    $this->db->where('subject_name', $sub['subject']);
     
    $subjectThumbnail = $this->db->get()->result_array(); 
    

    ?>
    
          <?php if($subjectThumbnail[0]['thumbnail'] != ""){ ?> 
          <a href="#" class="block-link" onclick="fetchTopics('<?= htmlspecialchars($sub['subject']) ?>'); return false;">
            <div class="grid-item">
                <div class="image">
                    <img src="<?php echo base_url()."".$subjectThumbnail[0]['thumbnail']; ?>" alt="Image 1">
                </div>
                <div class="content">
                   <h5 style="color: white;"><?= $sub['subject']; ?></h5>

                </div>
            </div>
            </a>
        <?php } else{ ?>
        
        <a href="#" class="block-link" onclick="fetchTopics('<?= htmlspecialchars($sub['subject']) ?>'); return false;">
            <div class="grid-item">
                <div class="image">
                    <img src="https://app.prokidsindia.com/uploads/site_data/enkids_logo.png" alt="Image 1">
                </div>
                <div class="content">
                       <h5 style="color: white;"><?= $sub['subject']; ?></h5>
                </div>
            </div>
            </a>
         
        
         <?php } ?>

        <!--<div class="col-md-6 mb-4" style="--bs-gutter-x: 0;">
            <a href="#" class="block-link" onclick="fetchTopics('<?= htmlspecialchars($sub['subject']) ?>'); return false;">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                  <img src="../assets/images/subjects.png" alt="Announcement Icon" class="icon-image"> 
                </div>
                    <div class="block-name">
                        <h3 class="mb-0"><?= htmlspecialchars($sub['subject']."-".$subjectThumbnail[0]['thumbnail']) ?></h3>
                    </div>
                </div>
            </a>
        </div>-->
    <?php endforeach; ?>
    </div>



<?php
// Load the database library if not already loaded


// Get the student name from the session
$studentName = $this->session->userdata('name');

// Initialize variable for student number
$studentNumber = '';


if (!empty($studentName)) {

$this->db->select('contact_no');
$this->db->from('students');
$this->db->where('name', $studentName);
$query = $this->db->get();




// Fetch the result
if ($query->num_rows() > 0) {
    $studentNumber = $query->row()->contact_no;
}
}
?>


 <input type="hidden" id="mediaUrl" value="<?php echo $mediaUrl; ?>">

<?php /* ?><div id="view_video_popup" class="edu_popup_container mfp-hide">
<div class="edu_popup_wrapper">
    <div class="edu_popup_inner">
        <h4 class="edu_sub_title" id="viewVideoTopic">
            <?php echo html_escape($this->common->languageTranslator('ltr_view_video')); ?>
        </h4>
        <div class="video-container">
            <!-- This container is the boundary for animation -->
            <div class="video-overlay">
                <span id="animatedText" class="animated-text">
                    <?php
                    echo isset($this->session->userdata['name']) ? htmlspecialchars($this->session->userdata['name'], ENT_QUOTES, 'UTF-8') : '';
                    ?>
                    <br>
                    <?php
                    echo htmlspecialchars($studentNumber, ENT_QUOTES, 'UTF-8');
                    ?>
                </span>
            </div>
            <div class="row videoIframeShow">
                <!-- Your iframe video content -->
            </div>
        </div>
        <div class="row commentBox">
            <div class="commentInput">
                <input type="hidden" id="videox_id" name="videox_id">
                <input class="form-control" name="video_comment_inpt" id="commentInput" placeholder="<?php echo html_escape($this->common->languageTranslator('ltr_description')); ?>">
            </div>
            <div class="commentSend">
                <button id="button_sbmt_cmnt" class="btn btn-primary">Send</button>
            </div>
        </div>
        <div class="commentsSection">
        </div>
    </div>
</div>
</div>

<?php */ ?>


<div id="view_video_popup" class="edu_popup_container mfp-hide">
<div class="edu_popup_wrapper">
    <div class="edu_popup_inner">
         <!--    <?php echo html_escape($this->common->languageTranslator('ltr_view_video')); ?>-->
        <!--</h4>-->
        <div class="video-content">
            <!-- Video Section -->
            <div class="video-section">
                <div class="videoIframeShow">
                     Video will be embedded here 
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <!-- Number Grid Section -->
            <div class="number-section">
                <div class="number-title">  <h4 class="edu_sub_title" id="viewVideoTopic" >
            <?php echo html_escape($this->common->languageTranslator('ltr_view_video')); ?>
        </h4></div>
       
               <div class="number-grid" id="videoGrid">
                <?php for ($i = 1; $i <= 20; $i++): ?>
                    <div class="number-item" id="number-<?php echo $i; ?>" onclick="changeColor(this)">
                        <?php echo $i; ?>
                    </div>
                <?php endfor; ?>
                </div>

               
            </div>
        </div>
    </div>
</div>
</div>




</section>

<style>
.back-btn {
  background: #4a90e2;      /* button color */
  color: #fff;
  border: none;
  padding: 10px 25px;
  border-radius: 50px;      /* rounded button */
  font-size: 18px;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.back-btn i {
  font-size: 20px;
}

.back-btn:hover {
  background: #2d78c8;     /* darker on hover */
  transform: scale(1.05);  /* zoom effect */
}

</style>

<section class="edu_admin_content" id="topics-section" style="display: none;">
<div class="col-md-12 mb-4"> 
    <div id="subjects-section" class="list-container">
      <div style="display:flex; justify-content:center; margin-top:10px;">
  <button class="back-btn" id="backToTopics">
      <i class="fa fa-chevron-left"></i> Back
  </button>
</div>
        <div style="margin-top: 15px;">
            <a href="<?php echo base_url('student/my-course'); ?>" style="text-decoration: none; color: #333;">
                <p style="font-size:25px;"><?php echo !empty($batch_data[0]['batch_name']) ? $batch_data[0]['batch_name'] : ''; ?></p>
            </a>
        </div>
        <h4 style="padding-top:20px;">Click Chapter:</h4>
        <ul id="topics-container" style="padding-top:20px;"></ul>
    </div>
    
</div>
</section>

<style>
.backTo {
  background: #4a90e2;      /* button color */
  color: #fff;
  border: none;
  padding: 10px 25px;
  border-radius: 50px;      /* rounded button */
  font-size: 18px;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.backTo i {
  font-size: 20px;
}

.backTo:hover {
  background: #2d78c8;     /* darker on hover */
  transform: scale(1.05);  /* zoom effect */
}

</style>

<section class="edu_admin_content" id="titles-section" style="display: none;">
<div class="col-md-12 mb-4"> 
    <div id="subjects-section" class="list-container">
       
                 <div style="display:flex; justify-content:center; margin-top:10px;">
  <button class="back-btn" id="backTo">
      <i class="fa fa-chevron-left"></i> Back
  </button>
</div>
        <div style="margin-top: 15px;">
            <a href="<?php echo base_url('student/my-course'); ?>" style="text-decoration: none; color: #333;">
                <p style="font-size:25px;"><?php echo !empty($batch_data[0]['batch_name']) ? $batch_data[0]['batch_name'] : ''; ?></p>
            </a>
        </div>
        <h4 style="padding-top:20px;">Select Video:</h4>
         <ul id="titles-container" style="padding-top:20px;"></ul>
         <div class="card-container" id="video-cards"></div>
    </div>
    
</div>
</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.plyr.io/3.7.2/plyr.polyfilled.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>


<script>
var selectedSubject = '';

// Function to fetch topics based on the selected subject
function fetchTopics(subject) {
selectedSubject = subject; // Store the selected subject
$.ajax({
    url: base_url + "front_ajax/fetch_topics",
    type: 'POST',
    dataType: 'json',
    data: { subject: subject },
    success: function(response) {
        $('#subject-section').hide();
        $('#topics-section').show();
        $('#topics-container').empty();

        if (response.length > 0) {
           response.forEach(function(topic) {
// Create a new <li> element with a class and text content
var $li = $('<li></li>', {
    class: 'topic-link', // Add the desired class
    'data-topic': htmlspecialchars(topic.topic), // Add data attribute if needed
    text: htmlspecialchars(topic.topic) // Set the text content
});

// Append the <li> element to the container
$('#topics-container').append($li);
});
        } else {
            $('#topics-container').html('<li>No topics available for this subject.</li>');
        }
    },
    error: function(xhr, status, error) {
        console.error('Error fetching topics:', error);
    }
});
}

// Function to fetch titles based on the selected subject and topic
function fetchTitles(subject, topic) {
var mediaUrl = $("#mediaUrl").val();
 $.ajax({
    url: base_url + "front_ajax/fetch_titles",
    type: 'POST',
    dataType: 'json',
    data: { subject: subject, topic: topic },
    success: function(response) {
        $('#topics-section').hide();
        $('#titles-section').show();
        $('#titles-container').empty();
         $('#video-cards').empty();


        if (response.length > 0) {
            $.each(response, function(index, title) {
                
              

                // Create a clickable <li> with data attributes for the video
                if(title.thumbnail != ""){
                    const imageBaseUrl  = base_url +""+ title.thumbnail;


                    const newVideoCard = '<div class="video-card"  data-id='+title.id+' data-url='+title.url+' data-type='+title.video_type+' data-desc='+title.description+' ><img class="thumbnail" src="'+imageBaseUrl+'" alt="Video Thumbnail">'+
                    '<div class="video-info"><div class="title">' + htmlspecialchars(title.title) + '</div></div></div>';
                     // Append the new video card to the container
                     $('#video-cards').append(newVideoCard);
                }else{
                    const newVideoCard = '<div class="video-card" data-id='+title.id+' data-url='+title.url+' data-type='+title.video_type+' data-desc='+title.description+'><img class="thumbnail" src="../uploads/site_data/enkids_logo.png" alt="Video Thumbnail">'+
                    '<div class="video-info"><div class="title">' + htmlspecialchars(title.title) + '</div></div></div>';
                     // Append the new video card to the container
                     $('#video-cards').append(newVideoCard);
                }
                
                
                /*var $li = $('<li></li>', {
                    'data-url': title.url,
                    'data-type': title.video_type,
                    'data-desc': title.description,
                    'data-id': title.id,
                     html: '<img width="250" height="300" src="../assets/images/video.png" alt="Announcement Icon" class="icon-image" style="height: 30px;">' +
                          '<span style="margin-left:20px; text-align:left; width:100%;">' + htmlspecialchars(title.title) + '</span>'
                });*/
                
                
               // $('#titles-container').append($li);
            });
        } else {
            $('#titles-container').html('<li>No titles available for this topic.</li>');
        }
    },
    error: function(xhr, status, error) {
        console.error('Error fetching titles:', error);
    }
});
}
// Function to show the subjects section
function showSubjects() {
$('#topics-section').hide();
$('#titles-section').hide();
$('#subject-section').show();
}

// Function to show the topics section
function showTopics() {
$('#titles-section').hide();
$('#topics-section').show();
}


$(document).on('click', '#backToTopics', function() {
showSubjects(); // Show subjects when going back from topics
});

// Back to Titles button functionality
$(document).on('click', '#backTo', function() {
showTopics(); // Show topics when going back from titles
});

// Function to escape HTML characters
function htmlspecialchars(text) {
return text.replace(/&/g, '&amp;')
           .replace(/</g, '&lt;')
           .replace(/>/g, '&gt;')
           .replace(/"/g, '&quot;')
           .replace(/'/g, '&#039;');
}

// Event delegation for dynamically created topic links
$(document).on('click', '.topic-link', function(e) {
e.preventDefault(); // Prevent default action of anchor tag
var topic = $(this).data('topic');
fetchTitles(selectedSubject, topic); // Fetch titles using AJAX
});


function parseVideo(url, type) {

let src;
if (type === "youtube") {
    let decryptedUrl;

    // Check if url is base64 (only valid chars)
    const base64Regex = /^[A-Za-z0-9+/=]+$/;

    if (base64Regex.test(url)) {
        decryptedUrl = decryptData(url,"zJ8mL3pQvXyT1aWfB9sN5dCgKoE7RuZh");
    } else {
        decryptedUrl = url; // URL is already plain YouTube link
    }

    const YregEx = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
    const Ymatch = decryptedUrl.match(YregEx);
    if (Ymatch && Ymatch[2]) {
        src = 'https://www.youtube.com/embed/' + Ymatch[2];
    }
} else if (type === "vimeo") {
    const VregEx = /(http:|https:|)\/\/(player.|www.)?(vimeo\.com)\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)/;
    const Vmatch = url.match(VregEx);
    if (Vmatch && Vmatch[5]) {
        src = 'https://player.vimeo.com/video/' + Vmatch[5];
    }
} else if (type === "dropbox") {
     src = url.replace("dropbox.com", "dl.dropboxusercontent.com");
} else if (type === "drive") {
     src = url.replace("view?usp=sharing", "preview");
} else {
    src = url;
}
return src || '';
}


function decryptData(encryptedData, key) {
        // Decode Base64
        var rawData = atob(encryptedData);

        // Convert to WordArray
        var rawBytes = new Uint8Array([...rawData].map(c => c.charCodeAt(0)));

        // Extract IV (first 16 bytes) and encrypted content
        var iv = CryptoJS.lib.WordArray.create(rawBytes.slice(0, 16));
        var encrypted = CryptoJS.lib.WordArray.create(rawBytes.slice(16));

        // Convert key to WordArray
        var secretKey = CryptoJS.enc.Utf8.parse(key);

        // Decrypt
        var decrypted = CryptoJS.AES.decrypt(
            { ciphertext: encrypted },
            secretKey,
            {
                iv: iv,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            }
        );

        return decrypted.toString(CryptoJS.enc.Utf8);
    }






//$(document).on('click', '#titles-container li', function() {
$(document).on('click', '.video-card', function() {
const src = parseVideo($(this).attr('data-url'), $(this).attr('data-type'));

const description = $(this).attr('data-desc') || '';
const videoType = $(this).attr('data-type');
const videoTitle = $(this).text();
const videoId = $(this).attr('data-id');

// Construct the HTML for embedding the video
let html;
if (videoType === 'youtube') {
    $('#viewVideoTopic').attr('video_url',src); //setter

    html = `
        <div class="plyr__video-embed" id="player">
            <iframe 
                src="${src}?controls=1&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1" 
                allowfullscreen 
                allowtransparency 
                allow="autoplay">
            </iframe>
        </div>`;
} else {
    const vidoeURL = base_url + "" + src;
    html = `
        <video controls autoplay >
            <source src="${vidoeURL}" type="video/mp4">
        </video>`;
        
    $('#viewVideoTopic').attr('video_url',vidoeURL); //setter

}

// Update popup content
$('#view_video_popup .videoIframeShow').html(html);
$('#viewVideoTopic').text(videoTitle);
$('#videox_id').val(videoId);


// Open the video popup
$.magnificPopup.open({
    items: {
        src: '#view_video_popup',
    },
    type: 'inline',
    modal: false,
    closeBtnInside: true,
    showCloseBtn: true,
    closeOnBgClick: false,
    callbacks: {
        open: function() {
            if (videoType === 'youtube') {
                window.playerx = new Plyr('#player');
            }
        },
        close: function() {
            // Cleanup on close
            $('#view_video_popup .videoIframeShow').html('');
            if (window.playerx) {
                window.playerx.destroy();
                window.playerx = null;
            }
        }
    }
});

// Update popup with the video title and description
$('#view_video_popup #viewVideoTitle').text($(this).closest('tr').find('td:eq(1)').text());
//fetchVideoComments(videoId); // Fetch comments for the video
fetchRelatedVideo(videoId);
});


$('#viewVideoTopic').on('click', function() {
const video_url = $('#viewVideoTopic').attr("video_url");
playVideo(video_url);

});


// Comment submission handler
$('#button_sbmt_cmnt').on('click', function() {
const comment = $('#commentInput').val().trim();
const videoId = $('#videox_id').val();
if (comment !== '') {
    submit_Comment(comment, videoId); // Submit comment to the backend
    $('#commentInput').val(''); // Clear input field
}
});



  function submit_Comment(comment, v_id){
     $.ajax({
        url: base_url + 'ajaxcall/send_comments/'+ v_id +'/'+comment,
        method: 'GET',
         success: function(data) {
           
 fetchRelatedVideo(v_id);
        },
        error: function(error) {
            console.error('Error fetching comments:', error);
        }
    });
} 
 


//   function fetchRelatedVideo(videoId) {
//     $.ajax({
//         url: base_url + 'ajaxcall/fetch_related_video/'+ videoId,
//         method: 'GET',
//          success: function(data) {
//                  var relatedVideosList = JSON.parse(data);
//                  var relatedHtml = '';
//                  const placeHolderUrl  = base_url +"uploads/site_data/enkids_logo.png"; 
//                  relatedVideosList.forEach((item, index) => {
                 
//                     //const imageUrl = item.thumbnail !== "" ? base_url + ""+item.thumbnail : placeHolderUrl;
//                     const videoUrl  = base_url +""+ item.video_file;
//                     //const imageBaseUrl  =   imageUrl;
                
//                     relatedHtml += `<img class='viewVideo' data-id="${item.id}" data-url="${videoUrl}"  alt="Image ${index + 1}">`;
//                 });
            
//                 //data-id='" . $vid["id"] . "'  data-url='" . base_url($vid["url"]) . "' data-type='" . $vid["video_type"] . "' data-desc='" . $vid["description"] . "'
            
//                 //alert(relatedHtml);
//               $('.image-container').html(relatedHtml);
         
        
         
         
         
//     //         var comments = JSON.parse(data);
//     //         var commentsHtml = '<h4 style="margin-top:20px;">Comments:</h4>';
//     //         comments.forEach(function(comment) {
//     //          commentsHtml +=    `<div class="comment"><p>
//     //     <strong>${comment.student_name}</strong>
//     //     <span style="float: right;">${comment.created_date}</span>
//     // </p>
//     // <p>${comment.message}</p></div>`; 
//     //         });
//     //         $('#view_video_popup .commentsSection').html(commentsHtml);
//         },
//         error: function(error) {
//             console.error('Error fetching comments:', error);
//         }
//     });
// }


function fetchRelatedVideo(videoId) {
$.ajax({
    url: base_url + 'ajaxcall/fetch_related_video/' + videoId,
    method: 'GET',
    success: function(data) {
        var relatedVideosList = JSON.parse(data);
        var relatedHtml = '';
        const placeHolderUrl = base_url + "uploads/site_data/enkids_logo.png"; 

        // Generating numbered grid items (1 to 20) with click event
        relatedHtml += `<div class="number-grid">`;
        relatedVideosList.forEach((item, index) => {
            const videoUrl = base_url + item.video_file;
            relatedHtml += `
                <div class="number-item" onclick="playVideo('${videoUrl}'); changeColor(this);">
                    ${index + 1}
                </div>`;
        });
        relatedHtml += `</div>`;

        // Appending the generated HTML to the container
        $('#videoGrid').html(relatedHtml);
    },
    error: function(error) {
        console.error('Error fetching videos:', error);
    }
});
}

// Function to play video when clicked
function playVideo(videoUrl) {
    const videoContainer = document.querySelector('.videoIframeShow');
    videoContainer.innerHTML = `
        <video style="width: 100%; background-color: coral;" controls autoplay>
            <source src="${videoUrl}" type="video/mp4">
            Your browser does not support the video tag.
        </video>`;
}



// Function to change the background color
function changeColor(element) {
const items = document.querySelectorAll('.number-item');
items.forEach(item => item.classList.remove('active'));
element.classList.add('active');
}






// Function to fetch video comments
function fetchVideoComments(videoId) {
$.ajax({
    url: base_url + 'ajaxcall/get_comments/' + videoId,
    method: 'GET',
    success: function (data) {
        try {
            var comments = JSON.parse(data);
            var commentsHtml = '<h4 style="margin-top:20px;">Comments:</h4>';
            comments.forEach(function (comment) {
                commentsHtml += `<div class="comment">
                    <p><strong>${html_escape(comment.student_name)}</strong>
                    <span style="float: right;">${html_escape(comment.created_date)}</span></p>
                    <p>${html_escape(comment.message)}</p>
                </div>`;
            });
            $('#view_video_popup .commentsSection').html(commentsHtml);
        } catch (e) {
            console.error('Error parsing comments data:', e);
        }
    },
    error: function (error) {
        console.error('Error fetching comments:', error);
    }
});
}

// Function to escape HTML characters
function html_escape(text) {
return $('<div>').text(text).html();
}








</script>




     <!-- Subjects and Chapters Sections -->