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
 
// instantiate product object
$student = new Student($db);
 
// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$student->device_id = $data->device_id;
$student->student_id = $data->student_id;
$student->fingerprint_id = $data->fingerprint_id;
// use the create() method here
// create the user
if(
    !empty($student->student_id) &&
    !empty($student->device_id) &&
    !empty($student->fingerprint_id) &&
    !$student->checkRegister() &&
    $student->register() && $student->update()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "Registeration Complete."));
}else if($student->checkRegister()){
    http_response_code(402);
    echo json_encode(array("message" => "Already registered."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to register."));
}
?>