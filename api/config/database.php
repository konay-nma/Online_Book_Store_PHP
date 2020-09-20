<?php

# used to get database connection

class Database{
   # my own database credentials
    private $host = "localhost";
    private $db_name = "id14188738_apidb";
    private $username = "id14188738_admin";
    private $password="LatteAda@1990";
    public $conn;
    
    # get database connection
    public function getConnection(){
        $this->conn = null;
       // Enable us to use Headers
        // ob_start();
        // //set the session
        // if(!isset($_SESSION)){
        //     session_start();
        // }
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
}

?>