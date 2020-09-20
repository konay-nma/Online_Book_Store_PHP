<?php 
session_start();
if (!empty($_SESSION['student_id'])) {
    header("Location: ./welcome.php");
}

include ('./api/login.php');
$title ="Index";
 ?>
<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
     <title>WYTU Online Library</title>
     <!-- jQuery + Bootstrap JS  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Header-->
    <!-- <?php include ('./api/login.php'); ?> -->
    
    <!-- Login form -->
    <div class="App">
        <div class="vertical-center">
            <div class="inner-block">
                <form action="" method="post">
                    <h3>Login to the online library</h3>

                    <?php echo $userNotEXist; ?>
                    <?php echo $idPassErr; ?> <!-- userNotEXist, $idPassErr, $id_empty_err, $pass_empty_err -->
                    <?php echo $id_empty_err; ?>
                    <?php echo $pass_empty_err; ?>
                    <?php echo $welcome; ?>

                    <div class="form-group">
                        <label>Student Id</label>
                        <input type="text" class="form-control" name="email_signin" id="email_signin" />
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password_signin" id="password_signin" />
                    </div>

                    <button type="submit" name="login" id="sign_in"
                        class="btn btn-outline-primary btn-lg btn-block">Sign
                        in</button>
                    <div class = "signup-text">
                        <span><a href="add.php">If you don't don't have Student ID?</a></span>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>

</body>

</html>