<?php
header("User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36");
header("Access-Control-Allow-Origin: http://localhost:3000");
include_once 'config/database.php';
include_once 'objects/student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents('php://input'));
 
$student->student_id = $data->student_id;
$student->password = $data->password;
//$password = password_hash($data->password
$exists = $student->getPass();

if($exists && password_verify($data->password, $student->password)){
    echo json_encode(array("success"=>true , "username"=>$student->student_id));
}else echo "not pass";

?>