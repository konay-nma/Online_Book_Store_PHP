<?php 
    //dadabase connection 
    include('./api/config/db_auth.php');
    global $userNotEXist, $idPassErr, $id_empty_err, $pass_empty_err, $welcome;

    if(isset($_POST['login'])){
        $student_id_signin = $_POST['email_signin'];
        $password_signin = $_POST['password_signin'];

        //clean the data 
        $user_id = filter_var($student_id_signin, FILTER_SANITIZE_NUMBER_INT);
        $pswd = mysqli_real_escape_string($connection, $password_signin);

        $sql = "SELECT * FROM key_pairs WHERE student_id ='{$student_id_signin}' ";
        $query = mysqli_query($connection, $sql);
        $rowCount = mysqli_num_rows($query);
            // if qury fail 
        if(!$query) {
            die("query fail: " . mysqli_error($connection));
         }

        if(!empty($student_id_signin) &&  !empty($password_signin)){
            //check user exist 
            if($rowCount <= 0){
                $userNotEXist = '<div class="alert alert-danger email-alert"> This member does not exists</div>';
            } else {
                // fetch user data and store in php session
                while($row = mysqli_fetch_array($query)){
                    $id = $row['id'];
                    $student_id = $row['student_id'];
                    $password = $row['password'];
                    $fingerprint_id = $row['fingerprint_id'];
                }

                if ($student_id_signin == $student_id && password_verify($password_signin, $password)) {
                    header("Location:./welcome.php");
                    $_SESSION['id'] = $id ;
                    $_SESSION['student_id'] = $student_id;
                    $_SESSION['fingerprint_id'] =$fingerprint_id ;
                } else {
                     $idPassErr = '<div class = "alert alert-danger"> Either Student_id or password is incorrect. </div>';
                }
            }
                
        } else {
            if (empty($student_id_signin)){
                $id_empty_err = "<div class ='alert alert-danger email_alert'> Student not provided </div>";
            }
            if (empty($password_signin)){
                $pass_empty_err  = "<div class = 'alert alert-danger email-alert'> Password not provided </div>";
            }
        }
    } 
?>