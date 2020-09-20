<?php 
    session_start();
    $page_title = "";
    if(empty($_SESSION['student_id'])) {
        if(empty($_SESSION['name'])){
        //echo "Access Denied! Please Log in to access this Page!"; 
    header("Location: ./index.php");
    exit;
        }
} 
   $id=$_GET['id'];
    // conntect to database 
    require_once "./api/config/db_function.php";
    $conn = db_connect();

    $query = "SELECT * FROM books WHERE id ='$id'";
    $result = mysqli_query($conn, $query);
    if(!$result) {
        echo "Can't retrieve data! Try later!";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        echo "Empty book";
        exit;
    }

    $title = $row['book_title'];
    require "./template/header.php";
?>

    <p class = "lead" style = " margin : 25px 0"><a href="allbooks.php">All Books</a> > <?php echo $row['book_title'] ?></p>
    <div class = "row">
        <div class="col-md-3 text-center" >
            <img class="img-responsive img-thumbnail" src="assets/<?php echo $row['book_image']; ?>" alt="" style ="width:16vw;height:20vw">
        </div>
        <div class ="col-md-6">
            <h4>Book Description</h4>
            <p><?php echo $row['book_desc']; ?></p>
            <h4>Book Details</h4>
            <table class= "table">
                <?php 
                    foreach ($row as $key => $value){
                        if ($key == "book_desc" || $key ==  "book_image" || $key == "download_link"){
                            continue;
                        }
                        switch($key){
                            case "id":
                                $key = "Book_ID";
                            break;
                            case "book_title":
                                $key = "Book Title";
                            break;
                            case "book_author":
                                $key = "Author";
                            break;
                            case "category":
                                $key = "Category";
                        }
                ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value;?></td>
                </tr>
                <?php 
              } 
              if(isset($conn)) {mysqli_close($conn); }
            ?>
            </table>
            <form action="<?php echo $row['download_link']; ?>">
            <input type="submit" value = "Read Online/Download" class ="btn btn-primary">
        </form>
        </div>
    </div>
    
    <?php
    require_once "./template/footer.php"
    ?>