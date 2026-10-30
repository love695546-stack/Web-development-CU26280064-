<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apache Test Page</title>
</head>
<body>

    <h1>It Works!</h1>
    <p>Your Apache web server and PHP are configured and running successfully.</p>
    
    <hr>

    <!-- PHP Code Section -->
    <?php
        echo "<p><strong>Current PHP Version:</strong> " . phpversion() . "</p>";
        echo "<p><strong>Server Time:</strong> " . date("Y-m-d H:i:s") . "</p>";
    ?>

</body>
</html>