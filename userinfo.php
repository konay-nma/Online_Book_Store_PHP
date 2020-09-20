<?php
session_start();
if(empty($_SESSION['name'])) {
    header("Location: ./adminform.php");
    exit;
}
// page given in URL parameter, default page is one
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
$start_date = $date . '-01';
$end_date = $date . '-' . cal_days_in_month(CAL_GREGORIAN, explode("-", $date)[1], explode("-", $date)[0]);
 
// retrieve records here

// set page header
// $page_title = "RECORDS";
// include_once "layout_header.php";
$title = "Welcome";
$page_title = "";
include_once "./template/header.php";
 
// contents will be here
// include database and object files
include_once 'api/config/database.php';
include_once 'api/objects/record.php';
include_once 'api/objects/student.php';
 
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
 
$record = new Record($db);

// Start date
//$start_date = '2019-10-01';
// End date
//$end_date = '2019-10-31';

?>
<!-- HTML form for creating a product -->
<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method='get'>
 
    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>DATE</td>
        </tr>
 
        <tr>
            <td>
                <select class='form-control' name='date'>
                    <option value='2020-01' <?php if($date == '2020-01')echo 'selected' ?> >January</option>
                    <option value='2020-02' <?php if($date == '2020-02')echo 'selected' ?> >February</option>
                    <option value='2020-03' <?php if($date == '2020-03')echo 'selected' ?> >March</option>
                    <option value='2020-04' <?php if($date == '2020-04')echo 'selected' ?> >April</option>
                    <option value='2019-05' <?php if($date == '2020-05')echo 'selected' ?> >May</option>
                    <option value='2020-06' <?php if($date == '2020-06')echo 'selected' ?> >June</option>
                     <option value='2020-07' <?php if($date == '2020-07')echo 'selected' ?> >July</option>
                    <option value='2020-08' <?php if($date == '2020-08')echo 'selected' ?> >August</option>
                    <option value='2020-09' <?php if($date == '2020-09')echo 'selected' ?> >September</option>
                     <option value='2020-10' <?php if($date == '2020-10')echo 'selected' ?> >October</option>
                    <option value='2020-11' <?php if($date == '2020-11')echo 'selected' ?> >November</option>
                    <option value='2020-12' <?php if($date == '2020-12')echo 'selected' ?> >December</option>
                </select>
            </td>
            <td>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </td>
        </tr>
 
    </table>
</form>

<?php

$num_present = 0;
$total = 0;

// generation of students
$student_ids = array();
$student_names = array();
$student = new Student($db);
$stmt = $student->getStudents();
$num = $stmt->rowCount();
if($num>0){
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        array_push($student_ids, $student_id);
        array_push($student_names, $student_name);
    }
}

$periods = array("MORNING", "AFTERNOON");

echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<colgroup>";
echo    '<col span="';
echo 2 + date('d', time());
echo '" style="background-color:white">';
echo    '<col style="background-color:#444444">';
echo '</colgroup>';
    echo "<tr bgcolor='#dddddd'>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Period</th>";

    $date = $start_date;
	while (strtotime($date) <= strtotime($end_date)) {
	    $day = date("d", strtotime($date));
        echo "<th>$day</th>";
        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	}
        echo "<th>Access</th>";
    echo "</tr>";

foreach($student_ids as $key=>$student_id){
    echo "<tr>";
    echo "<td rowspan='2' nowrap>$student_id</td>";
    echo "<td rowspan='2' nowrap>$student_names[$key]</td>";

    foreach($periods as $p){
        $num_present = 0;
        $total = 0;
        
        $stmt = $record->readAll($student_id, $start_date, $end_date, $p);
        $num = $stmt->rowCount();
    
    //if($num>0){
     
        echo "<td>$p</td>";
        
        $date = $start_date;
        $equal = true;
        while (strtotime($date) <= strtotime($end_date)) {
            $total++;
    	    if($equal){
    	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    	    }
    	    
    	    if($row){
	            extract($row);
	            if(explode(" ", $created)[0] == $date){
	                $num_present++;
	                echo "<td style='color:green'>IN</td>";
	                $equal = true;
	            }
	            else{
	                echo "<td style='color:red'>IN</td>";
	                $equal = false;
	            } 
	        }else{
	            echo "<td style='color:red'>IN</td>";
	            $equal = false;
	        }
    	    
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    	}
        echo "<td>";
        echo floor(($num_present/$total)*100);
        echo "%</td>";
        echo "</tr>";
     
        // paging buttons will be here
    //}
    // tell the user there are no products
    // else{
    //     print_r($stmt->errorInfo());
    //     echo "<div class='alert alert-info'>No data for this student.</div>";
    // }
    }
}
echo "</table>";
 
// query products
// $stmt = $record->readAll('111111', "2019-10-27", "2019-10-31", "M");
// $num = $stmt->rowCount();

// if($num>0){
 
//     // Start date
// 	$date = '2019-10-01';
// 	// End date
// 	$end_date = '2019-10-31';
	
// 	echo "<table class='table table-hover table-responsive table-bordered'>";
//         echo "<tr>";
//             echo "<th>ID</th>";
//             echo "<th>Name</th>";
//             echo "<th>Period</th>";

//     	while (strtotime($date) <= strtotime($end_date)) {
//     	    $day = date("d", strtotime($date));
//             echo "<th>$day</th>";
//             $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
//     	}
    
//         echo "</tr>";
 
//         echo "<tr>";
//         echo "<td rowspan='2'>111111</td>";
//         echo "<td rowspan='2'>Min Hein Khant</td>";
//         echo "<td>M</td>";
        
//         $date = '2019-10-01';
//         $equal = true;
//         while (strtotime($date) <= strtotime($end_date)) {
//     	    if($equal){
//     	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     	    }
    	    
//     	    if($row){
// 	            extract($row);
// 	            if(explode(" ", $created)[0] == $date){
// 	                echo "<td>True</td>";
// 	                $equal = true;
// 	            }
// 	            else{
// 	                echo "<td>False</td>";
// 	                $equal = false;
// 	            } 
// 	        }else{
// 	            echo "<td>False</td>";
// 	            $equal = false;
// 	        }
    	    
//             $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
//     	}
//         echo "</tr>";
        
//     echo "</table>";
 
//     // paging buttons will be here
// }
 
// // tell the user there are no products
// else{
//     print_r($stmt->errorInfo());
//     echo "<div class='alert alert-info'>No data for this student.</div>";
// }
 
// set page footer
require_once "./template/footer.php"
?>