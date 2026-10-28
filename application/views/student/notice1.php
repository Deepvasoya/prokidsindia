<style>
    .profile_setting {
  font-family:system-ui ;       
}

.profile_setting .Profile_img_g {
  background-image: url('img/app_cover_img.jfif');
  height: 150px;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  /* background-size: cover; */
  background-repeat: no-repeat;
}

.profile_setting .img_profile {
  width: 80px;
  height: 80px;
  border-radius: 50%;
}

.profile_setting .button_personal button {
  width: 100%;
  border: none;
  outline: none;
  text-transform: uppercase;
  font-size: 20px;
  font-weight: 600;
  background-color: #0f4d92;
  color: white;
  height: 45px;
}

.profile_setting .button_business button {
  width: 100%;
  border: none;
  outline: none;
  text-transform: uppercase;
  font-size: 20px;
  font-weight: 600;
  background-color: #00008B;
  color: white;
  height: 45px;
}
.profile_setting .cilent_id {
  margin-top: 20px;
  text-align: center;
  text-transform: capitalize;
}

.profile_setting .cilent_id h1 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 1px;
}

.profile_setting .cilent_id h5 {
  font-weight: 400;
  font-size: 18px;
}
.profile_setting .p_setting_tebale 
{
  display: flex;
  justify-content: center;
  align-items: center;
}
.profile_setting form .Personal_detal_buton
{
  display: flex;
} 

.profile_setting form .personal_info
{
 width: 70%;
}
.profile_setting .personal_icon
{
  width: 30%;
  display: flex;
  justify-content: end;
}
.profile_setting .personal_icon button
{
  padding: 1px 10px;
  border: 1px solid #0358f4;
  border-radius: 20px;
  font-size: 15px;
  color: #0358f4;
  background-color: transparent;

}
@media(max-width:767px)
{
  .profile_setting .personal_icon button 
  {
    padding: 1px 3px;
    height: 30px;
  }
  
  .profile_setting .button_personal button{
      font-size: 14px;
  }
  
  .profile_setting .button_business button{
      font-size: 14px;
  }
      
  }
  
  
}
.profile_setting .p_setting_tebale  form .personal_icon button i
{
  margin-right: 5px;
}



.profile_setting  form table {
 
  white-space: nowrap;
}
.profile_setting form  h3
{
  font-size: 22px;
  color:#ff830f;
  text-transform: capitalize;
  font-weight: 500;
}
.profile_setting form
{
  margin-top: 10px;
  width: 80%;
  padding: 10px;
  
}

.profile_setting  form table tr td {
  text-transform: capitalize;

  padding-right: 20px;
  /* margin-right: 20px; */
  font-size: 17px;
  font-weight: 400;
  color:#6d6d6d;
  padding: 10px 10px;
}


.profile_setting  form table tr th {
  word-wrap: break-word;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: normal;
  font-weight: 600;
  font-size: 17px;
  padding: 10px 15px;


}
.profile_setting .perimanent_b
{
  color:#6d6d6d ;
  font-size: 16px;
text-transform: capitalize;
margin-bottom: -5px;
}
.profile_setting .perimanent_ba
{
 font-size: 18px;
 color:#000 ;
 font-size: 600;

}

.profile_setting .bacd
{
  display: flex;
  justify-content: center;
  align-items: center;
}

.profile_anbcd
{
position: relative;
width: 250px;
display: flex;
margin: auto;
height: 8px;
border-radius: 10px;
background-color: rgb(231, 231, 231);


}
.prig_profile_avc
{
position: absolute;
left: 0px;
top: 0px;
content: "";
width: 100%;
height: 100%;
background-color: #cf731d;
border-radius: 10px;
animation: productabc 4.5s normal forwards;

}
@keyframes productabc{
0%{width: 0px;}
100%{width: 100%;}
}
@media(max-width:676px)
{
.profile_setting form table tr th
{
padding: 3px 3px;
max-width: 200px;
font-size: 13px;
}
.profile_setting form table tr td
{
padding: 3px 3px;  
font-size: 13px; 
}
}

@media(max-width:476px)
{
.profile_setting form table tr th
{
padding: 3px 3px;
max-width: 120px;
font-size: 10px;
}
.profile_setting form table tr td
{
padding: 3px 3px;  
font-size: 10px; 
}
}

.block {
    height: 130px;
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
        
        .title {
            color: white;
    font-size: 22px;
    position: absolute;
    top: 10px; /* Adjust as needed */
    left: 6%;
   
    
}

.block-name {
    font-size:20px;
    color: white;
    position: absolute;
    bottom: 57px; /* Adjust as needed */
    left: 6%; /* Adjust as needed */
    text-align: left;
}

.date {
    color: white;
    font-size: 20px;
    position: absolute;
    bottom: 10px; /* Adjust as needed */
    left: 6%; /* Adjust as needed */
    text-align: left;
}
</style>




<section class="edu_admin_content">
    
      <div class="col-12">
                    <div class='dashboard-app'>
                       
                        <div class='dashboard-content'>
                            <div class='container'>
                                <div class="personat">
                                    <div class="chart">
                                        <div class="profile_setting">
                                            <div class="row" style="padding:10px;">
                                               
                                                <div class="col-6 button_personal m-0 p-0">
                                                    <button id="personalBtn">Personal Notice</button>
                                                </div>
                                                <div class="col-6 button_business m-0 p-0">
                                                    <button id="businessBtn">Common Notice</button>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-12 p_setting_tebale">
                                               
                                                    <form action="" id="formTable">
    <div class="row">
        <?php if (!empty($personal_notices)): ?>
            <?php foreach ($personal_notices as $index => $notice): ?>
                <div class="col-md-12 mb-4">
                    <a href="#" class="block-link">
                        <div class="block" style="background-color: white; !important">
                            <div class="title">
                                <!-- Displaying sequential number -->
                                <?= ($index + 1) . '. ' . $notice['title']; ?>
                            </div>
                            <div class="block-name">
                                <?= $notice['description']; ?>
                            </div>
                            <div class="date">
                                <!-- Using an icon for calendar and displaying formatted date -->
                                <i class="fa fa-calendar"></i>
                                <?= date('d-m-Y', strtotime($notice['date'])); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12 text-center">
                <img src="../assets/images/nodata.jpg" alt="No Notices Available" class="img-fluid" style="max-width: 300px; margin-top: 84px;">
            </div>
        <?php endif; ?>
    </div>
</form>

                                                </div>


                                            </div>


                                            <div class="row Main_2" id="mainContent">
                                                <div class="col-12">
                                                    <div class="bacd">

                                                       <form action="">
    <div class="row">
        <?php if (!empty($common_notices)): ?>
            <?php foreach ($common_notices as $index => $notice): ?>
                <div class="col-md-12 mb-4">
                    <a href="#" class="block-link">
                        <div class="block" style="background-color: #0f4d92; !important">
                            <div class="title">
                                <!-- Displaying sequential number -->
                                <?= ($index + 1) . '. ' . $notice['title']; ?>
                            </div>
                            <div class="block-name">
                                <?= $notice['description']; ?>
                            </div>
                            <div class="date">
                                <!-- Using an icon for calendar and displaying formatted date -->
                                <i class="fa fa-calendar"></i>
                                <?= date('d-m-Y', strtotime($notice['date'])); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No common notices available.</p>
        <?php endif; ?>
    </div>
</form>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section> 
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://alexandrebuffet.fr/codepen/slider/slick-animation.min.js"></script>
    
     <script>
            const mobileScreen = window.matchMedia("(max-width: 990px )");
            $(document).ready(function () {
                $(".dashboard-nav-dropdown-toggle").click(function () {
                    $(this).closest(".dashboard-nav-dropdown")
                        .toggleClass("show")
                        .find(".dashboard-nav-dropdown")
                        .removeClass("show");
                    $(this).parent()
                        .siblings()
                        .removeClass("show");
                });
                $(".menu-toggle").click(function () {
                    if (mobileScreen.matches) {
                        $(".dashboard-nav").toggleClass("mobile-show");
                    } else {
                        $(".dashboard").toggleClass("dashboard-compact");
                    }
                });

                // Initial setup
                $("#mainContent").hide();

                // Toggle visibility on button click
                $("#personalBtn").click(function() {
                    $("#mainContent").hide();
                    $("#formTable").show();
                });

                $("#businessBtn").click(function() {
                    $("#formTable").hide();
                    $("#mainContent").show();
                });
            });
        </script>