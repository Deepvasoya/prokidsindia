 
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



<style>
/* ===== Student video lecture page – friendly redesign (scoped by section id) ===== */
#subject-section, #topics-section, #titles-section { padding: 106px 15px 40px; }
#subject-section .back-btn-p,
#topics-section .back-btn,
#titles-section .back-btn {
    align-self: flex-start; padding: 9px 20px; border: 0; border-radius: 999px;
    background: #fff; color: #5b6cff !important; font-size: 15px; font-weight: 800;
    box-shadow: 0 6px 16px rgba(31,42,77,.10); text-decoration: none !important; transform: none;
}
#subject-section .back-btn-p:hover,
#topics-section .back-btn:hover,
#titles-section .back-btn:hover { background: #eef0ff; transform: translateX(-3px); }
#subject-section > div:first-child,
#topics-section .list-container > div:first-child,
#titles-section .list-container > div:first-child { justify-content: flex-start !important; margin: 0 !important; }

.vl-head {
    position: relative; overflow: hidden; margin: 18px 0 26px; padding: 26px 30px; border-radius: 24px; color: #fff;
    background: linear-gradient(120deg, #5b6cff 0%, #8f7bff 55%, #ff8fb1 100%); box-shadow: 0 14px 34px rgba(91,108,255,.25);
}
.vl-head:after { content: ""; position: absolute; width: 200px; height: 200px; border-radius: 50%; right: -50px; top: -80px; background: rgba(255,255,255,.14); }
.vl-head h2 { text-transform: none; color: #fff; font-size: 28px; font-weight: 600; margin: 6px 0 4px; position: relative; z-index: 1; }
.vl-head p { margin: 0; padding: 0; opacity: .92; font-size: 15px; position: relative; z-index: 1; }
.vl-course { display: inline-block; padding: 5px 14px; border-radius: 999px; background: rgba(255,255,255,.2); font-size: 13px; font-weight: 800; position: relative; z-index: 1; }
.vl-head-sm { margin-top: 0; padding: 20px 26px; }
.vl-head-sm h2 { font-size: 24px; margin-top: 0; }
/* the old plain course-name link above the list is replaced by the banner */
#topics-section .list-container > div:nth-child(2),
#titles-section .list-container > div:nth-child(2) { display: none; }

/* Units grid */
#subject-section .pcontainer {
    max-width: none; padding: 0; margin: 0;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 22px;
}
#subject-section .pcontainer > a { text-decoration: none !important; --c: #5b6cff; --soft: #eef0ff; }
#subject-section .pcontainer > a:nth-of-type(6n+1) { --c: #ff5c8a; --soft: #ffe6ee; }
#subject-section .pcontainer > a:nth-of-type(6n+2) { --c: #ff9f1a; --soft: #fff3dc; }
#subject-section .pcontainer > a:nth-of-type(6n+3) { --c: #22b8cf; --soft: #e2f7fb; }
#subject-section .pcontainer > a:nth-of-type(6n+4) { --c: #7c5cff; --soft: #efeaff; }
#subject-section .pcontainer > a:nth-of-type(6n+5) { --c: #22c58b; --soft: #dff7ee; }
#subject-section .pcontainer > a:nth-of-type(6n+6) { --c: #5b6cff; --soft: #eef0ff; }
#subject-section .grid-item {
    display: flex; flex-direction: column; gap: 0; padding: 0; height: 100%; overflow: hidden;
    background: #fff !important; border-radius: 22px; border: 2px solid transparent;
    box-shadow: 0 8px 22px rgba(31,42,77,.07); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
#subject-section .pcontainer > a:hover .grid-item { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(31,42,77,.14); border-color: var(--c); }
#subject-section .grid-item .image { width: 100%; height: 130px; display: flex; align-items: center; justify-content: center; background: var(--soft); padding: 14px; }
#subject-section .grid-item .image img { width: auto; max-width: 100%; height: 100%; object-fit: contain; border-radius: 14px; transition: transform .25s ease; }
#subject-section .pcontainer > a:hover .grid-item .image img { transform: scale(1.06) rotate(-2deg); }
#subject-section .grid-item .content { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 16px 18px; font-family: inherit; }
#subject-section .grid-item .content h5 { margin: 0; color: #1f2a4d !important; font-family: var(--pk-font-head, inherit); font-size: 19px; font-weight: 600; }
#subject-section .grid-item .content:after {
    content: "\2192"; flex: 0 0 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    background: var(--soft); color: var(--c); font-weight: 800; transition: transform .2s ease, background .2s ease, color .2s ease;
}
#subject-section .pcontainer > a:hover .grid-item .content:after { background: var(--c); color: #fff; transform: translateX(3px); }

/* Chapters list */
#topics-section .list-container ul {
    padding: 0 !important; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;
}
#topics-section .list-container ul li {
    position: relative; height: auto; min-height: 76px; justify-content: flex-start; text-align: left; gap: 14px;
    padding: 18px 56px 18px 18px; border-radius: 20px; background: #fff; color: #1f2a4d;
    font-family: var(--pk-font-head, inherit); font-size: 18px; font-weight: 600; line-height: 1.3;
    border: 2px solid #eef0f7; box-shadow: 0 4px 12px rgba(31,42,77,.05); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
#topics-section .list-container ul li:before {
    content: "\25B6"; flex: 0 0 40px; height: 40px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
    background: #fff3dc; color: #ff9f1a; font-size: 14px;
}
#topics-section .list-container ul li:nth-child(4n+2):before { background: #e2f7fb; color: #22b8cf; }
#topics-section .list-container ul li:nth-child(4n+3):before { background: #efeaff; color: #7c5cff; }
#topics-section .list-container ul li:nth-child(4n+4):before { background: #ffe6ee; color: #ff5c8a; }
#topics-section .list-container ul li:after { content: "\2192"; position: absolute; right: 18px; color: #b7bdd3; font-weight: 800; transition: transform .2s ease, color .2s ease; }
#topics-section .list-container ul li:hover { background: #fff; transform: translateY(-3px); border-color: #8f7bff; box-shadow: 0 12px 26px rgba(31,42,77,.10); }
#topics-section .list-container ul li:hover:after { color: #5b6cff; transform: translateX(3px); }

/* Video cards */
#titles-section .card-container { padding: 0; gap: 22px; justify-content: flex-start; display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); }
#titles-section .video-card {
    width: auto !important; height: auto; margin: 0; cursor: pointer; border-radius: 22px; background: #fff;
    box-shadow: 0 8px 22px rgba(31,42,77,.07); border: 2px solid transparent; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
#titles-section .video-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(31,42,77,.14); border-color: #ff8a3d; }
#titles-section .video-card .thumbnail { display: block; width: 100%; aspect-ratio: 16 / 10; height: auto; object-fit: cover; background: #fff8ec; }
#titles-section .video-card { position: relative; }
#titles-section .video-card:before {
    content: "\25B6"; position: absolute; top: 0; left: 0; right: 0; aspect-ratio: 16 / 10; display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 22px; background: rgba(15,23,42,0); transition: background .2s ease; pointer-events: none; z-index: 1;
    text-shadow: 0 0 0 transparent;
}
#titles-section .video-card .thumbnail[src*="enkids_logo"] { object-fit: contain; padding: 16px; }
#titles-section .video-card:hover:before { background: rgba(15,23,42,.25); }
#titles-section .video-info { padding: 14px 16px 16px; }
#titles-section .video-info .title { margin: 0; text-align: left; font-family: var(--pk-font-head, inherit); font-size: 17px; font-weight: 600; color: #1f2a4d; }
#titles-section #titles-container li { height: auto; font-size: 18px; background: #fff; color: #7a84a3; border-radius: 20px; }

@media (max-width: 767px) {
    #subject-section, #topics-section, #titles-section { padding: 92px 0 30px; }
    .vl-head { padding: 20px; }
    .vl-head h2 { font-size: 23px; }
    #subject-section .pcontainer, #titles-section .card-container { grid-template-columns: 1fr 1fr; gap: 14px; }
    #subject-section .grid-item .image { height: 96px; }
    #subject-section .grid-item .content { padding: 12px; }
    #subject-section .grid-item .content h5 { font-size: 15px; }
    #subject-section .grid-item .content:after { display: none; }
    #topics-section .list-container ul { grid-template-columns: 1fr; }
    #titles-section .video-info .title { font-size: 14px; }
}
</style>
<section class="edu_admin_content" id="subject-section">

   <div style="display:flex; justify-content:center; margin-top:10px;">
  <a class="back-btn-p" href="<?php echo base_url('student/my-course'); ?>">
      <i class="fa fa-chevron-left"></i> Back
  </a>
</div>

    
    <div class="vl-head">
        <span class="vl-course">&#127890; <?php echo !empty($batch_data[0]['batch_name']) ? html_escape($batch_data[0]['batch_name']) : ''; ?></span>
        <h2>Choose a unit <span>&#128218;</span></h2>
        <p>Tap a unit to see its chapters.</p>
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
                    <img src="<?php echo base_url()."".$subjectThumbnail[0]['thumbnail']; ?>" alt="<?= htmlspecialchars($sub['subject']) ?>" onerror="this.onerror=null;this.src='<?php echo base_url('uploads/site_data/enkids_logo.png'); ?>'">
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
                    <img src="<?php echo base_url('uploads/site_data/enkids_logo.png'); ?>" alt="<?= htmlspecialchars($sub['subject']) ?>">
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


 <input type="hidden" id="mediaUrl" value="<?php echo isset($mediaUrl) ? $mediaUrl : ''; ?>">

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
        <div class="vl-head vl-head-sm"><h2>Pick a chapter <span>&#128214;</span></h2><p>Each chapter has fun videos to watch.</p></div>
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
        <div class="vl-head vl-head-sm"><h2>Pick a video <span>&#127916;</span></h2><p>Tap a video to start watching.</p></div>
         <ul id="titles-container" style="padding-top:20px;"></ul>
         <div class="card-container" id="video-cards"></div>
    </div>
    
</div>
</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.plyr.io/3.7.2/plyr.polyfilled.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/video_assessment_student.css?v=' . filemtime(FCPATH . 'assets/css/video_assessment_student.css')); ?>">
<script src="<?php echo base_url('assets/js/video_assessment_student.js?v=' . filemtime(FCPATH . 'assets/js/video_assessment_student.js')); ?>"></script>


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


                    const newVideoCard = '<div class="video-card"  data-id='+title.id+' data-url='+title.url+' data-type='+title.video_type+' data-desc='+title.description+' ><img class="thumbnail" src="'+imageBaseUrl+'" alt="" onerror="this.onerror=null;this.src=base_url+\'uploads/site_data/enkids_logo.png\'">'+
                    '<div class="video-info"><div class="title">' + htmlspecialchars(title.title) + '</div></div></div>';
                     // Append the new video card to the container
                     $('#video-cards').append(newVideoCard);
                }else{
                    const newVideoCard = '<div class="video-card" data-id='+title.id+' data-url='+title.url+' data-type='+title.video_type+' data-desc='+title.description+'><img class="thumbnail" src="'+base_url+'uploads/site_data/enkids_logo.png" alt="">'+
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
            if (window.VAS) { VAS.start(videoId); } // quiz questions for this video
        },
        close: function() {
            if (window.VAS) { VAS.stop(); }
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