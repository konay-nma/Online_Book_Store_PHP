<?php

    include_once 'api/config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $row=$db->prepare('select * from key_pairs');  
      
    $row->execute();//execute the query  
    $json_data=array();//create the array  
    foreach($row as $rec)//foreach loop  
    {  
        $json_array['student_id']=$rec['student_id'];  
       // $json_array['student_name']=$rec['student_name'];  
        $json_array['password']=$rec['password'];  
        //$json_array['degree']=$rec['degree'];  
    //here pushing the values in to an array  
        array_push($json_data,$json_array);  
  
}  
  
//built in PHP function to encode the data in to JSON format  
echo json_encode($json_data);  
  
?>  