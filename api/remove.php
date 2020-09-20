<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
$passward_hash = '$2y$10$ZobHbIIjPoYNRRqtl/QpCOnGpNSwZ8ZnsyzoeJxkX.GPwqIcmWCvG';
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
$student->fingerprint_id = $data->fingerprint_id;
$exists = $student->exists();

if(
    !empty($student->fingerprint_id) &&
    !empty($student->device_id) &&
    $exists &&
    password_verify($data->device_id, $student->device_id) &&
    $student->remove()
){
    http_response_code(200);
    
    echo json_encode(array("message" => "Remove Complete."));
}else if(
    empty($student->fingerprint_id) &&
    password_verify($data->device_id, $passward_hash) &&
    $student->remove_all()
){
    http_response_code(200);
    
    echo json_encode(array("message" => "Remove all Complete."));
}else if(!$exists){
    http_response_code(401);
    
    echo json_encode(array("message" => "Haven't registered yet."));
}else{

    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to remove."));
}
?>