<?php 
session_start();

if (!empty($_SESSION['name'])){
    header("Location: ./userinfo.php");
}
include ('./api/admin_login.php');
$title ="Index";
//include_once "./template/header.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/custom.css">
    <title>WYTU Online Library</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
</head>

<body>
    <!-- Header-->
    <!-- <?php include ('./api/admin_login.php'); ?> -->
    <!-- Login form -->
    <div class="admin">
        <div class="vertical-center">
            <div class="inner-block">
                <form action="" method="post">
                    <h3>Login to Admin Session</h3>

                    <?php echo $userNotExist; ?>
                    <?php echo $namePassErr; ?>
                    <?php echo $nameNotExist; ?>
                    <?php echo $passNotExist; ?>

                    <div class="form-group">
                        <label >Username</label>
                        <input type="text" class="form-control" name="email_signin" id="email_signin" />
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password_signin" id="password_signin" />
                    </div>

                    <button type="submit" name="signin" id="sign_in"
                        class="btn btn-outline-primary btn-lg btn-block">Sign
                        in</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>