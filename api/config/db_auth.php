<?php 

    // Enable us to use Headers
    ob_start();

    // Set sessions
    if(!isset($_SESSION)) {
        session_start();
    }

   $hostname = "localhost";
    $username = "id14188738_admin";
    $password = "LatteAda@1990";
    $dbname = "id14188738_apidb";
    
    $connection = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.")

?>