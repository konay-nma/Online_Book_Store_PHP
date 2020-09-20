<?php
date_default_timezone_set('Asia/Yangon');
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
$student->device_id = $data->device_id;
$student->fingerprint_id = $data->fingerprint_id;
$exists = $student->exists();

// generate jwt will be here
// check if email exists and if password is correct
if($exists && password_verify($data->device_id, $student->device_id)){
    
 
    // set response code
    if($student->checkReport()){
        http_response_code(402);
        echo json_encode(array("message" => "Already reported.", "device_id"=>$data->device_id));
    }else{
        if($student->report()){
            http_response_code(200);
            echo json_encode(
                    array(
                        "message" => $student->student_name
                    )
                );
        }else{
            http_response_code(400);
            echo json_encode(array("message" => "Unable to report."));
        }
    }
 
}
else if(!$exists){
    http_response_code(401);
    echo json_encode(
            array(
                "message" => "Unregistered ID."
                )
        );
}
// login failed
else{
 
    // set response code
    http_response_code(400);
 
    // tell the user login failed
    echo json_encode(array("message" => "Report failed."));
}
?>