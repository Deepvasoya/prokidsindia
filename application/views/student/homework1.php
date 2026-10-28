<style>

.edu_admin_content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%; /* Full width container */
}

.calendar-container {
    display: flex;
    justify-content: center;
    width: 100%;
    margin: 20px 0;
}

.calendar {
    overflow: hidden;
    width: 100%;
}

.dates {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    transition: transform 0.3s ease;
    justify-content: center;
}

.date-item {
    min-width: 150px;
    padding: 10px 20px;
    text-align: center;
    background-color: #f1f1f1;
    cursor: pointer;
    white-space: nowrap;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 14px;
}

.date-item .day {
    font-size: 18px;
    font-weight: bold;
}

.date-item .month {
    font-size: 16px;
}

.date-item .year {
    font-size: 14px;
    color: #777;
}

.today {
    background-color: #4caf50;
    color: white;
    font-weight: bold;
}

#homework-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.homework-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
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
    height: 130px;
    font-size: 17px;
    background-color: #0f4d92;
    color: white;
    padding: 24px;
    border-radius: 8px;
    cursor: pointer;
    align-items: center;
}

.list-container ul li:hover {
    background-color: #0056b3;
}

</style>







<section class="edu_admin_content">
    <div class="calendar-container">
        <div class="calendar">
            <ul class="dates" id="dates-list">
                <!-- Dates will be populated dynamically by JavaScript -->
            </ul>
        </div>
    </div>
    
     <div id="category-content" class="col-md-6 mb-4">
    <div id="homework-list" class="list-container">
        <!-- Homework details will be populated dynamically by JavaScript -->
        <ul id="homework-items"></ul>
    </div>
    </div>
</section>



<script>
document.addEventListener("DOMContentLoaded", function() {
    const datesList = document.getElementById("dates-list");
    const homeworkList = document.getElementById("homework-items");

    // Get today's date
    const today = new Date();
    let selectedDate = new Date(today);  // Start at today

    // Function to format the date components
    function formatDateComponents(date) {
        const optionsDay = { day: '2-digit' };
        const optionsMonth = { month: 'short' };
        const optionsYear = { year: 'numeric' };

        const day = date.toLocaleDateString('en-GB', optionsDay);
        const month = date.toLocaleDateString('en-GB', optionsMonth);
        const year = date.toLocaleDateString('en-GB', optionsYear);

        return { day, month, year };
    }

    // Function to generate a range of dates centered on the selected date
    function generateDates(centerDate) {
        datesList.innerHTML = '';  // Clear the existing dates

        for (let i = -10; i <= 10; i++) {  // Generate 21 dates (10 before and 10 after today)
            const date = new Date(centerDate);
            date.setDate(centerDate.getDate() + i);
            
            const { day, month, year } = formatDateComponents(date);

            const li = document.createElement("li");
            li.className = "date-item";
            
            li.innerHTML = `
                <div class="day">${day}</div>
                <div class="month">${month}</div>
                <div class="year">${year}</div>
            `;
            
            if (i === 0) {
                li.classList.add("today");  // Highlight the centered date
            }
            
            // Add click event listener to each date item
            li.addEventListener("click", function() {
                selectedDate = new Date(centerDate);
                selectedDate.setDate(centerDate.getDate() + i);  // Set the selected date to the clicked date
                generateDates(selectedDate);  // Regenerate dates centered on the selected date
                fetchHomework(selectedDate);  // Fetch homework for the selected date
            });
            
            datesList.appendChild(li);
        }
    }

    // Function to fetch homework data for a specific date
   function fetchHomework(date) {
    const formattedDate = date.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
    
    $.ajax({
        url: base_url + "front_ajax/fetch_homework",
        method: 'POST',
        data: { date: formattedDate },
        dataType: 'json',
        success: function(response) {
            console.log("AJAX Success:", response); // Log the response data for debugging

            // Clear the previous homework list
            homeworkList.innerHTML = '';

            if (!response || response.length === 0) {
                homeworkList.innerHTML = '<li>No homework for this date.</li>';
                return;
            }

            // Generate HTML for homework items
            let homeworkHtml = '<ul style="padding-top:20px;">';
            response.forEach(homework => {
                homeworkHtml += `
                    <li class="homework-item" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <div  style="padding: 5px 0px 5px 40px;"><i class="fa fa-user" aria-hidden="true"></i>  ${homework.teacher_name}</div>
                        <div style="padding: 5px 0px 5px 40px;"><i class="fa fa-book" aria-hidden="true"></i>  ${homework.subject_name}</div>
                        <div style="padding: 5px 0px 5px 40px;"> ${homework.description}</div>
                    </li>
                `;
            });
            homeworkHtml += '</ul>';

            // Append the generated HTML to the homework list
            homeworkList.innerHTML = homeworkHtml;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching homework:', error);
            console.error('Status:', status);
            console.error('XHR:', xhr);
            homeworkList.innerHTML = '<li>Error fetching homework data.</li>';
        }
    });
}


    // Initialize the calendar with today's date in the middle
    generateDates(today);

    // Fetch and display homework for today's date on page load
    fetchHomework(today);
});




</script>