<?php
echo "Server Software: " . htmlspecialchars($_SERVER['SERVER_SOFTWARE']) . "<br>";
echo "Server Name: " . htmlspecialchars($_SERVER['SERVER_NAME']) . "<br>";
echo "Request Method: " . htmlspecialchars($_SERVER['REQUEST_METHOD']) . "<br>";
echo "Script Filename: " . htmlspecialchars($_SERVER['SCRIPT_FILENAME']) . "<br>";
?>