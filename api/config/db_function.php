<?php 
    function db_connect(){
        $conn = mysqli_connect("localhost", "id14188738_admin_bookstore", "LatteAda@1990", "id14188738_bookstore");
        if(!$conn){
            echo "Can't connect to the database" . 
            mysqli_connect_error($conn);
            exit;
        }

        return $conn;
    }

    function select4LatestBooks($conn){
        $row = array();

        $query = "SELECT id, book_image, book_title FROM books ORDER BY id DESC";
        $result = mysqli_query($conn,$query);
        if(!$result){
            echo "Can't retrieve data " . 
            mysqli_error($conn);
            exit;
        }
        for ($i = 0; $i < 4; $i++) {
            array_push($row, mysqli_fetch_assoc($result));
        }

        return $row;
    }

    function categoryBooks($conn){
        
    }

    function getBooksInfo($conn) {
        $query = "SELECT * FROM books ORDER BY id DESC";
        $result = mysqli_query($conn,$query);
        if(!$result) {
            echo "Can't retrieve books data " . mysqli_error($conn);
        exit;
        }
        return $result;
    }
?>