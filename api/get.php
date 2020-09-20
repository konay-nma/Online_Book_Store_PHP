<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/student.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$student = new Student($db);
 
// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
if(isset($data->student_id)){
    $student->student_id = $data->student_id;
}
$type = $data->type;
if($type == "name"){
    $exists = $student->getName();
}else if($type == "fp_id"){
    $exists = $student->getFPId();
}else if($type == "fp_id_new"){
    $exists = $student->getMaxFPId();
}
 
// generate jwt will be here
// check if email exists and if password is correct
if($exists){
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    if($type == "name"){
        echo json_encode(array("message" => $student->student_name));
    }else if($type == "fp_id"){
        echo json_encode(array("message" => $student->fingerprint_id));
    }else if($type == "fp_id_new"){
        echo json_encode(array("message" => strval($student->fingerprint_id + 1)));
    }
        
 
}
// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>