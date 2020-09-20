<?php
// set page header
session_start();
$title = "ADD MEMBERS";
$page_title = "ADD MEMBERS";
include_once "template/header.php";
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='student_name' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Year</td>
            <td>
                <select class='form-control' name='year'>
                    <option value='1'>I</option>
                    <option value='2'>II</option>
                    <option value='3'>III</option>
                    <option value='4'>IV</option>
                    <option value='5'>V</option>
                    <option value='6'>VI</option>
                    <option value='7'>Other</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Major</td>
            <td>
                <select class='form-control' name='major'>
                    <option value='1'>EC</option>
                    <option value='2'>Archi</option>
                    <option value='3'>Civil</option>
                    <option value='4'>EP</option>
                    <option value='5'>ME</option>
                    <option value='6'>MC</option>
                    <option value='7'>IT</option>
                    <option value='8'>Other</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Roll Number</td>
            <td><input type='number' name='roll_num' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Create Your Password</td>
            <td><input type='password' name='password' class='form-control'/></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Add</button>
            </td>
        </tr>
 
    </table>
</form>

<?php
// contents will be here
// include database and object files
include_once 'api/config/database.php';
include_once 'api/objects/student.php';
 
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

if(isset($_GET['year']) && isset($_GET['major']) && isset($_GET['roll_num'])){
    if(strlen($_GET['roll_num']) > 3){
        echo "<div class='alert alert-danger'>Roll Number must be less than 3 digit.</div>";
    }else{
        $student->student_id = '0' . $_GET['year'] . $_GET['major'];
        for($i = strlen($_GET['roll_num']); $i < 3; $i++){
            $student->student_id .= '0';
        }
        $student->student_id .= $_GET['roll_num'];
    }
}


if(isset($_GET['student_name']) && isset($_GET['password'])){
    $student->password = $_GET['password'];
    $student->student_name = $_GET['student_name'];
    if(empty($student->student_name)){
        echo "<div class='alert alert-danger'>Please fill your name.</div>";
    }else if(strlen($student->student_id) != 6){
        echo "<div class='alert alert-danger'>Student ID must be 6 digit.</div>";
    }else if(strlen($_GET['password']) < 8){
        echo "<div class='alert alert-danger'>Password must be at least 8 charators.</div>";
    }else if($student->checkStudent()){
        echo "<div class='alert alert-danger'>Unable to add student. User has been registered.</div>";
    }else {
        if($student->add()){
            echo "<div class='alert alert-success'>Student was added. Your ID is ";
            echo $student->student_id;
            echo "</div>";
        }else echo "<div class='alert alert-danger'>Unable to add student.</div>";
    }
}

// set page footer
include_once "layout_footer.php";
?>
