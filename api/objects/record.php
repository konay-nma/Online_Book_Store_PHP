<?php
// 'student' object
class Record{
 
    // database connection and table name
    private $conn;
    private $register_table = "key_pairs";
    private $student_table = "student";
    private $records_table = "records";
 
    // object properties
    public $id;
    public $student_name;
    public $student_id;
    public $period;
    public $date;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    
 
    function readAll($student_id, $start_date, $end_date, $period){
     
        $query = "SELECT
                    *
                FROM
                    " . $this->records_table . " 
                WHERE student_id = ? 
                AND period = ?
                AND created BETWEEN 
                ? AND ? 
                ORDER BY created ASC";
     
        $stmt = $this->conn->prepare( $query );
        
        $end_date=htmlspecialchars(strip_tags($end_date . " 23:59:59"));
        
        $stmt->bindParam(1, $student_id);
        $stmt->bindParam(2, $period);
        $stmt->bindParam(3, $start_date);
        $stmt->bindParam(4, $end_date);
        
        $stmt->execute();
     
        return $stmt;
    }
}
?>