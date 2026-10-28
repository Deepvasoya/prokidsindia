 <style>
     
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
    height: 50px;
    font-size: 20px;
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

</style>  



<section class="edu_admin_content" id="subject-section">
    <div class="row" style="width:100%; padding:30px; padding-top:50px;">
        <?php foreach ($subject as $sub): ?>
            <div class="col-md-6 mb-4">
                <a href="#" class="block-link" data-subject-name="<?= htmlspecialchars($sub['subject_name']) ?>" onclick="fetchTopics('<?= htmlspecialchars($sub['subject_name']) ?>'); return false;">
                    <div class="block" style="background-color: #0f4d92;">
                        <div class="block-icon">
                            <img src="../assets/images/subjects.png" alt="Announcement Icon" class="icon-image"> 
                        </div>
                        <div class="block-name">
                            <h3 class="mb-0"><?= htmlspecialchars($sub['subject_name']) ?></h3>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="edu_admin_content" id="chapters-section" style="display: none;">
    <div class="col-md-12 mb-4">
        <div id="subjects-section" class="list-container">
            <ul id="chapters-list" style="padding-top:20px;"></ul>
        </div>
    </div>
</section>

<section class="edu_admin_content" id="titles-section" style="display: none;">
    <div class="col-md-12 mb-4">
        <div id="titles-container" class="list-container">
            <ul id="titles-list" style="padding-top:20px;"></ul>
        </div>
    </div>
</section>

<section class="edu_admin_content" id="pdf-section" style="display: none;">
    <div class="col-md-12 mb-4">
        <div id="pdf-container" class="list-container">
            <iframe id="pdf-viewer" style="width: 100%; height: 600px;" frameborder="0"></iframe>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var currentSubjectName = '';
var currentChapterName = ''; // Variable to store the current subject name

function fetchTopics(subjectName) {
    currentSubjectName = subjectName;  // Store the current subject name
    $.ajax({
        url: base_url + "front_ajax/fetch_noteschapter",  // Ensure base_url is defined correctly
        method: 'POST',
        data: { subject_name: subjectName },
        dataType: 'json',
        success: function(response) {
            $('#chapters-list').empty();
            if (response.chapters && response.chapters.length > 0) {
                $.each(response.chapters, function(index, chapter) {
                    $('#chapters-list').append(
                        '<li class="chapter-item" data-chapter-name="' + chapter.chapter_name + '">' + chapter.chapter_name + '</li>'
                    );
                });
            } else {
                $('#chapters-list').append('<li>No chapters available</li>');
            }

            // Hide the subjects section and show the chapters section
            $('#subject-section').hide();
            $('#chapters-section').show();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching chapters:', error);
        }
    });
}

// Bind click event to chapters
function fetchTitles(chapterName, subjectName) {
    $.ajax({
        url: base_url + "front_ajax/fetch_notetitles",
        method: 'POST',
        data: { chapter_name: chapterName, subject_name: subjectName },
        dataType: 'json',
        success: function(response) {
            $('#titles-list').empty();
            if (response.titles && response.titles.length > 0) {
                $.each(response.titles, function(index, title) {
                    $('#titles-list').append(
                        '<li class="title-item" data-title="' + title.title + '">' + title.title + '</li>'
                    );
                });
                // Hide the chapters section and show the titles section
                $('#chapters-section').hide();
                $('#titles-section').show();
            } else {
                $('#titles-list').append('<li>No titles available</li>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching titles:', error);
        }
    });
}


// Bind click event to chapters
 // Variable to store the current chapter name

$(document).on('click', '.chapter-item', function() {
    var chapterName = $(this).data('chapter-name');
    currentChapterName = chapterName;  // Store the current chapter name
    fetchTitles(chapterName, currentSubjectName);  // Pass the current subject name and selected chapter
});


$(document).on('click', '.title-item', function() {
    var title = $(this).data('title');
    
    fetchPDF(title);  // Pass the selected title to fetch and display the PDF
});

function fetchPDF(title) {
    $.ajax({
        url: base_url + "front_ajax/fetch_notepdf",
        method: 'POST',
        data: {
            title: title,
            chapter_name: currentChapterName,  // Ensure currentChapterName is defined and updated
            subject_name: currentSubjectName  // Pass current subject name
        },
        dataType: 'json',
        success: function(response) {
            var fileName = response.file_name;
            if (fileName) {
                $('#pdf-viewer').attr('src', base_url + 'uploads/notes/' + fileName);
                // Hide the titles section and show the PDF section
                $('#titles-section').hide();
                $('#pdf-section').show();
            } else {
                $('#pdf-viewer').attr('src', ''); // Clear the PDF viewer if no file is found
                $('#pdf-section').hide();
                alert('No PDF available for this title');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching PDF:', error);
        }
    });
}





// Fetch PDF function

</script>


