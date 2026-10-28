<?php
session_start();

// Fetch the session data
$discountAmount = isset($_SESSION['discountAmount']) ? $_SESSION['discountAmount'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Session Data</title>
</head>
<body>
    <script>
        // Embed PHP session data in JavaScript
        const sessionData = {
            discountAmount: <?php echo json_encode($discountAmount); ?>
        };

        // Log session data to the console
        console.log('Session Data:', sessionData);
    </script>
</body>
</html>