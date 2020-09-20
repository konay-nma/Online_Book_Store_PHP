<?php 

    include('./api/config/db_admin.php');
    
    global $userNotExist, $namePassErr, $nameNotExist, $passNotExist; 
    
    if(isset($_POST['signin'])){
        $login_name = $_POST['email_signin'];
        $login_pass = $_POST['password_signin'];
    

    $username = filter_var($login_name, FILTER_SANITIZE_NUMBER_INT);
    $userpass = mysqli_real_escape_string($connection, $login_pass);

    $query = "SELECT * FROM admin WHERE name ='{$login_name}' ";
    $result = mysqli_query($connection, $query);
    $rowCount = mysqli_num_rows($result);

    if(!$result) {
        echo "Can't retrieve data " . mysqli_error($connection);
        exit;
    }

    if(!empty($login_name) && !empty($login_pass)){

        if($rowCount <= 0) {
            $userNotExist = '<div class = "alert alert-danger email-alert">Admin info does not exist</div>';
        } else {
            while ($row = mysqli_fetch_array($result)){
            $name = $row['name'];
            $pass = $row['pass'];
            }

            if ($login_name == $name && password_verify($login_pass, $pass)) {
                header("Location: ./userinfo.php");
                $_SESSION['name'] = $name;
                $_SESSION['pass'] = $pass;

            } else {
                $namePassErr = '<div class="alert alert-danger email-alert">Your name or password is not correct!</div>';
            }
        }
	

    } else {
        if (empty($login_name)) {
            $nameNotExist = '<div class="alert alert-danger email=elert">Name is not provided!</div>';
        }
        if (empty($login_pass)) {
            $passNotExist = '<div class="alert alert-danger email=elert">Password is not provided!</div>';
        }
    }
}
?>
