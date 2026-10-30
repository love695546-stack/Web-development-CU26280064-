<?php
session_start();
$_SESSION['username'] = 'student_user';
echo "Session started and user set. <a href='check_session.php'>Go to Next Page</a>";
?>