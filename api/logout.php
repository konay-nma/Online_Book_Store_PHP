<?php 
 session_start();
 session_destroy();
if (!empty($_SESSION['name'])) {
 header("Location: /adminform.php");
} else if(!empty($_SESSION['student_id'])) {
    header("Location: /index.php");
} else {exit;}
?>