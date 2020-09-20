<?php
// 'student' object
class Student{
 
    // database connection and table name
    private $conn;
    private $register_table = "key_pairs";
    private $student_table = "student";
    private $report_table = "records";
    private $session_table = "session";
 
    // object properties
    public $id;
    public $student_name;
    public $device_id;
    public $student_id;
    public $fingerprint_id;
    public $period;
    public $date;
    public $password;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    // register() method will be here
        // register new student record

    public function register(){
        $this->getPass();
        // insert query
        $query = "INSERT INTO " . $this->register_table . "
                SET
                    device_id = :device_id,
                    student_id = :student_id,
                    fingerprint_id = :fingerprint_id,
                    password = :password";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->device_id=htmlspecialchars(strip_tags($this->device_id));
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
        $this->fingerprint_id=htmlspecialchars(strip_tags($this->fingerprint_id));
        $this->password=htmlspecialchars(strip_tags($this->password));
       
     
        //DEBUG
        //echo $this->student_id;
        //echo $this->fingerprint_id;
        //echo $this->conn == null;
     
        // bind the values
        $stmt->bindParam(':fingerprint_id', $this->fingerprint_id);
        $stmt->bindParam(':student_id', $this->student_id);
     
        // hash the password before saving to database
        $device_id_hash = password_hash($this->device_id, PASSWORD_BCRYPT);
        $stmt->bindParam(':device_id', $device_id_hash);
      //  $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $this->password);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        print_r($stmt->errorInfo()); // DEBUG
        return false;
    }
    
    public function add(){
        $query = "INSERT INTO " . $this->student_table . "
                SET
                    student_name = :student_name,
                    student_id = :student_id,
                    password = :password";
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->student_name=htmlspecialchars(strip_tags($this->student_name));
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
        $this->password=htmlspecialchars(strip_tags($this->password));

     
        //DEBUG
        //echo $this->student_id;
        //echo $this->fingerprint_id;
        //echo $this->conn == null;
     
        // bind the values
        $stmt->bindParam(':student_name', $this->student_name);
        $stmt->bindParam(':student_id', $this->student_id);
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password_hash);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        //print_r($stmt->errorInfo()); // DEBUG
        return false;
    }
    
    public function report(){
        $this->getName();
        $this->calcPeriod();
        
        // insert query
        $query = "INSERT INTO " . $this->report_table . "
                SET
                    student_name = :student_name,
                    student_id = :student_id,
                    period = :period,
                    created = :date";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->student_name=htmlspecialchars(strip_tags($this->student_name));
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
        $this->period=htmlspecialchars(strip_tags($this->period));
        $this->date=htmlspecialchars(strip_tags(date('Y-m-d h:i:s', time())));
     
        //DEBUG
        //echo $this->student_id;
        //echo $this->fingerprint_id;
        //echo $this->conn == null;
     
        // bind the values
        $stmt->bindParam(':student_name', $this->student_name);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':period', $this->period);
        $stmt->bindParam(':date', $this->date);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        //print_r($stmt->errorInfo()); // DEBUG
        return false;
    }
    
    function remove(){
        $query = "DELETE 
                FROM 
                    " . $this->register_table . "
                    WHERE fingerprint_id = :fingerprint_id";
                    
        $stmt = $this->conn->prepare( $query );
        
        $this->fingerprint_id = htmlspecialchars(strip_tags($this->fingerprint_id));
        
        $stmt->bindParam(':fingerprint_id', $this->fingerprint_id);
        
        if($stmt->execute())return true;
        else return false;
    }
    
    function remove_all(){
        $query = "DELETE 
                FROM 
                    " . $this->register_table;
                    
        $stmt = $this->conn->prepare( $query );
    //    echo "removing all";
        
        if($stmt->execute())return true;
        else return false;
    }
    
    function checkReport(){
        $this->calcPeriod();
        $query = "SELECT
                    *
                FROM
                    " . $this->report_table . " 
                WHERE period = :period
                AND student_id = :student_id 
                AND date(created) = :date";
                
        $stmt = $this->conn->prepare( $query );
        
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
        $this->period=htmlspecialchars(strip_tags($this->period));
        $this->date=htmlspecialchars(strip_tags(date('Y-m-d', time())));
        
        $stmt->bindParam(':period', $this->period);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':date', $this->date);
        
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }
    
    // function existReg(){
     
    //     // query to check if email exists
    //     $query = "SELECT id, student_id, password
    //             FROM " . $this->student_table . "
    //             WHERE student_id = ?
    //             LIMIT 0,1";
     
    //     // prepare the query
    //     $stmt = $this->conn->prepare( $query );
     
    //     // sanitize
    //     $this->password=htmlspecialchars(strip_tags($this->password));
    //     $this->student_id=htmlspecialchars(strip_tags($this->student_id));
    //     // bind given email value
    //     $stmt->bindParam(1, $this->student_id);
     
    //     // execute the query
    //     $stmt->execute();
     
    //     // get number of rows
    //     $num = $stmt->rowCount();
     
    //     // if email exists, assign values to object properties for easy access and use for php sessions
    //     if($num>0){
     
    //         // get record details / values
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    //         // assign values to object properties
    //         $this->password = $row['password'];
    //         $this->student_id = $row['student_id'];
     
    //         // return true because email exists in the database
    //         return true;
    //     }
        
    //    // print_r($stmt->errorInfo()); //DEBUG
    //     // return false if email does not exist in the database
    //     return false;
    // }
    
     
    // exists() method will be here
        // check if given email exist in the database
    function exists(){
     
        // query to check if email exists
        $query = "SELECT id, device_id, student_id, password, fingerprint_id
                FROM " . $this->register_table . "
                WHERE fingerprint_id = ?
                LIMIT 0,1";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->fingerprint_id=htmlspecialchars(strip_tags($this->fingerprint_id));
     
        // bind given email value
        $stmt->bindParam(1, $this->fingerprint_id);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->device_id = $row['device_id'];
            $this->student_id = $row['student_id'];
            $this->password = $row['password']; 
            $this->fingerprint_id = $row['fingerprint_id'];
     
            // return true because email exists in the database
            return true;
        }
        
       // print_r($stmt->errorInfo()); //DEBUG
        // return false if email does not exist in the database
        return false;
    }
    
    function checkRegister(){
     
        // query to check if email exists
        $query = "SELECT *
                FROM " . $this->register_table . "
                WHERE student_id = ?
                LIMIT 0,1";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->student_id=htmlspecialchars(strip_tags($this->student_id));
     
        // bind given email value
        $stmt->bindParam(1, $this->student_id);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
          // return true because email exists in the database
            return true;
        }
        
       // print_r($stmt->errorInfo()); //DEBUG
        // return false if email does not exist in the database
        return false;
    }
    
    function getPass(){
        // query to check if email exists
        $query = "SELECT id, password
                FROM " . $this->student_table . "
                WHERE student_id = ?
                LIMIT 0,1";
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->password=htmlspecialchars(strip_tags($this->password));
     
        // bind given email value
        $stmt->bindParam(1, $this->student_id);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->password = $row['password'];
     
            // return true because email exists in the database
            return true;
        }
        return false;
    }
    
    function getName(){
        // query to check if email exists
        $query = "SELECT id, student_name
                FROM " . $this->student_table . "
                WHERE student_id = ?
                LIMIT 0,1";
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->student_name=htmlspecialchars(strip_tags($this->student_name));
     
        // bind given email value
        $stmt->bindParam(1, $this->student_id);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->student_name = $row['student_name'];
     
            // return true because email exists in the database
            return true;
        }
        
        //print_r($stmt->errorInfo()); //DEBUG
        // return false if email does not exist in the database
        return false;
    }
    
    function getFPId(){
        // query to check if email exists
        $query = "SELECT id, fingerprint_id
                FROM " . $this->register_table . "
                WHERE student_id = ?
                LIMIT 0,1";
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->student_name=htmlspecialchars(strip_tags($this->student_name));
     
        // bind given email value
        $stmt->bindParam(1, $this->student_id);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->fingerprint_id = $row['fingerprint_id'];
     
            // return true because email exists in the database
            return true;
        }
        
        //print_r($stmt->errorInfo()); //DEBUG
        // return false if email does not exist in the database
        return false;
    }
    
    function getMaxFPId(){
        // query to check if email exists
        $query = "SELECT MAX(fingerprint_id)
                FROM " . $this->register_table . "
                LIMIT 0,1";
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
  
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->fingerprint_id = $row['MAX(fingerprint_id)'];
     
            // return true because email exists in the database
            return true;
        }
        
        //print_r($stmt->errorInfo()); //DEBUG
        // return false if email does not exist in the database
        return false;
    }
    
    function checkStudent(){
        // query to check if email exists
        $query = "SELECT *
                FROM " . $this->student_table . "
                WHERE student_id = ?";
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->student_id);
 
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        return ($num>0);
    }
    
    function getStudents(){
        // query to check if email exists
        $query = "SELECT id, student_name, student_id
                FROM " . $this->student_table;
                
        // prepare the query
        $stmt = $this->conn->prepare( $query );
 
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        return $stmt;
    }
    // update() method will be here
    function calcPeriod(){
        $twelveH = "12:00:00";
        if(time() <= strtotime($twelveH)){
            $this->period = "MORNING";
        }else $this->period = "AFTERNOON";
    }

    function logIn(){
            $this->getName();
            $query = "INSERT INTO " . $this->session_table . " SET 
            student_name = :student_name,
            student_id = :student_id";

            $stmt = $this->conn->prepare($query);
            $this->student_name=htmlspecialchars(strip_tags($this->student_name));
            $this->student_id=htmlspecialchars(strip_tags($this->student_id));

            $stmt->bindParam(':student_name', $this->student_name);
            $stmt->bindParam(':student_id', $this->student_id);

            if ($stmt->execute()){
                return true;
            } 

            return false;
    }

    function isLoggedIn() {
        $query = "SELECT * FROM " . $this->session_table . "
        WHERE student_id = ? ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->student_id);

        $stmt->execute();
        $num = $stmt->rowCount();

        return $num>0;
    }
}
?>