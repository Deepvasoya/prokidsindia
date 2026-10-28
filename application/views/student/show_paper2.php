       
     <style>
     
       .block {
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

.list-container ul li {
    height: 60px;
    font-size: 22px;
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

.test-container {
    margin-top: 20px;
}

.test-container ul {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(600px, 1fr));
    gap: 10px;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

@media (max-width: 768px) {
    .test-container ul {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
    
    .test-container ul li{
        font-size: 20px;
    }
        
    
}

@media (max-width: 480px) {
    .test-container ul {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
    
    .test-container ul li{
        font-size: 20px;
    }
}

.test-container ul li {
    height: 130px;
    font-size: 17px;
    background-color: #0f4d92;
    color: white;
    padding: 24px;
    border-radius: 8px;
    cursor: pointer;
    align-items: center;
    
}

.test-container ul li:hover {
    background-color: #0056b3;
}
   
</style>  

<section class="edu_admin_content">
    <div class="row" style="width:100%; padding:30px; padding-top:50px">
        <div class="col-md-6 mb-4">
            <a href="#" class="block-link paper-link" data-category="practice-paper" data-type="2">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/old.png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Practice Paper</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="<?php echo base_url()?>student/practice-result" class="block-link">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/research.png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Practice Result</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="#" class="block-link paper-link" data-category="mock-paper" data-type="1">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/test (1).png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Mock Test Paper</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="<?php echo base_url()?>student/mock-result" class="block-link">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/result.png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Mock Test Result</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="#" class="block-link paper-link" data-category="descriptive-paper" data-type="3">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/contract.png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Descriptive Paper</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="<?php echo base_url()?>student/descriptive-result" class="block-link">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/results (1).png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Descriptive Result</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="<?php echo base_url()?>student/view-progress" class="block-link">
                <div class="block" style="background-color: #0f4d92;">
                    <div class="block-icon">
                        <img src="../assets/images/results.png" alt="Announcement Icon" class="icon-image">
                    </div>
                    <div class="block-name">
                        <h3 class="mb-0">Academic Record</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Subjects and Chapters Sections -->
    <div id="category-content" class="col-md-12 mb-4">
        <div id="subjects-section" class="list-container" style="display: none;">
            <h4 style="padding-top:20px;">Select Subject:</h4>
            <ul id="subjects-list" style="padding-top:20px;"></ul>
        </div>
        <div id="chapters-section" class="list-container" style="display: none;">
            <h4 style="padding-top:20px;">Select Chapter:</h4>
            <ul id="chapters-list" style="padding-top:20px;"></ul>
        </div>
        <div id="papers-section" class="test-container" style="display: none;">
            <h4 style="padding-top:20px;">Select Test Paper:</h4>
            <ul id="papers-list" style="padding-top:20px;"></ul>
        </div>
    </div>
</section>
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.block-link').on('click', function(e) {
        var category = $(this).data('category');
        var type = $(this).data('type');
        var batchId = '<?= $this->session->userdata('batch_id') ?>';

        // Check if the link is meant to trigger dynamic content loading
        if (type === 1 || type === 2 || type === 3) {
            e.preventDefault();
            
            // Hide all categories and show category content
            $('.row').hide();
            $('#category-content').show();
            $('#subjects-section').show();

            // Fetch and display subjects
            $.ajax({
                url: base_url + "ajaxcall/get_subject",
                type: 'GET',
                data: {
                    batch_id: batchId,
                    type: type
                },
                dataType: 'json',
                success: function(response) {
                    $('#subjects-list').empty();
                    if (response.subjects && response.subjects.length > 0) {
                        $.each(response.subjects, function(index, subject) {
                            $('#subjects-list').append('<li class="subject-item" data-subject-id="' + subject.id + '">' + subject.subject_name + '</li>');
                        });
                    } else {
                        $('#subjects-list').append('<li>No subjects available</li>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching subjects:', error);
                    $('#subjects-section').html('<p>An error occurred while fetching subjects.</p>');
                }
            });

            // Handle subject selection
            $('#subjects-list').off('click').on('click', '.subject-item', function() {
                var subjectId = $(this).data('subject-id');

                // Mark the selected subject
                $('.subject-item').removeClass('active');
                $(this).addClass('active');

                // Hide subjects and show chapters
                $('#subjects-section').hide();
                $('#chapters-section').show();

                // Fetch and display chapters
                $.ajax({
                    url: base_url + "ajaxcall/get_chapters",
                    type: 'GET',
                    data: {
                        subject_id: subjectId,
                        batch_id: batchId,
                        type: type
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#chapters-list').empty();
                        if (response.chapters && response.chapters.length > 0) {
                            $.each(response.chapters, function(index, chapter) {
                                $('#chapters-list').append('<li class="chapter-item" data-chapter-id="' + chapter.id + '">' + chapter.chapter_name + '</li>');
                            });
                        } else {
                            $('#chapters-list').append('<li>No chapters available</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching chapters:', error);
                        $('#chapters-section').html('<p>An error occurred while fetching chapters.</p>');
                    }
                });
            });

            // Handle chapter selection
            $('#chapters-list').off('click').on('click', '.chapter-item', function() {
                var chapterId = $(this).data('chapter-id');
                var subjectId = $('#subjects-list .subject-item.active').data('subject-id');

                // Ensure subjectId is defined before making the AJAX call
                if (!subjectId) {
                    alert('Subject ID is missing.');
                    return;
                }

                // Call paper_list function
                $.ajax({
                    url: base_url + "front_ajax/paper_list",
                    type: 'POST',
                    data: {
                        subject_id: subjectId,
                        chapter_id: chapterId,
                        type: type
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            var papersHtml = '<ul style="padding-top:20px;">';
                            $.each(response.papers, function(index, paper) {
                                papersHtml += '<li class="paper-item" data-paper-id="' + paper.id + '">' +
                                    paper.name + '<br>' +
                                    '<i class="fa fa-clock" aria-hidden="true"></i> Duration: ' + paper.time_duration + ' minutes<br>' +
                                    '<i class="fa fa-question-circle" aria-hidden="true"></i> Total Questions: ' + paper.total_question + '<br>' +
                                    '</li>';
                            });
                            papersHtml += '</ul>';
                            $('#papers-section').html(papersHtml).show(); // Show the papers section

                            // Hide chapters section
                            $('#chapters-section').hide();
                            totalTime = response.papers[0].time_duration * 60;

                            // Handle paper detail view
                            $('.paper-item').off('click').on('click', function(e){
                                e.preventDefault();
                                var paperId = $(this).data('paper-id');

                                // Fetch and display paper details
                                $.ajax({
                                    url: base_url + "front_ajax/get_paper_details1",
                                    type: 'POST',
                                    data: {
                                        id: paperId,
                                        paper_type: type
                                    },
                                    success: function(resp) {
                                        var resp = $.parseJSON(resp);
                                        $('.edu_preloader').fadeOut()
                                        if (resp['status'] == '1') {
                                            $('.showQuestionPaperWrapper').html(resp['html']);
                                            totalTime = resp['totalTime'] * 60;
                                            paper_type = resp['paper_type'];
                                        } else {
                                            toastr.error(ltr_something_msg);
                                        }
                                        if (typeof MathJax !== 'undefined') { MathJax.Hub.Queue(["Typeset", MathJax.Hub]); }
                                    },
                                    error: function(resp) {
                                        $('.edu_preloader').fadeOut()
                                        toastr.error(ltr_something_msg);
                                    },
                                    complete: function(data) {
                                        var dt = new Date();
                                        var time = dt.getHours() + ":" + dt.getMinutes();
                                        $('.question_paper_footer #start_time').val(time);
                                        timeInterval = setInterval(paper_count_down, 1000);
                                    }
                                });
                            });
                        } else {
                            // Handle error
                            $('#papers-section').html('<p>' + response.message + '</p>').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching papers list:', error);
                        $('#papers-section').html('<p>An error occurred while fetching papers list.</p>').show();
                    }
                });
            });
        } else {
            // Allow default behavior for links without type 1, 2, or 3
            return true;
        }
    });
});

function paper_count_down() {
    totalTime = --totalTime;
    if (totalTime > 0) {
        update_time(totalTime);
    } else {
        clearInterval(timeInterval);
        update_time(totalTime);
        time_completed();
    }
}

function update_time(totalTime) {
    var hours = parseInt(totalTime / 3600) % 24;
    var minutes = parseInt(totalTime / 60) % 60;
    var seconds = totalTime % 60;

    var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);

    $('#timer').html(result);
}

function time_completed() {
    $('.question_paper_wrapper').css('background', 'rgba(255, 110, 102, 0.19)');
    if (paper_type == 'mock') {
        clearInterval();
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes();
        $('.question_paper_footer #submit_time').val(time);
        $.magnificPopup.open({
            items: {
                src: '#autoSubmitPopup',
            },
            type: 'inline',
            closeOnBgClick: false
        });
        $('#autoSubmitPopup .mfp-close').hide();
        $('#autoSubmitPopup .SubmitPaperForm').hide();
        $('#autoSubmitPopup .nomarginbtm').css('margin-bottom', '0');
        setTimeout(function() {
            $('.SubmitPaperForm').trigger('click');
        }, 500);
    }
}
</script>





        
        