<?php 
    $page = "allbooks";
    $page_title = "";
    session_start();
    if(empty($_SESSION['student_id'])) {
        if(empty($_SESSION['name'])){
        //echo "Access Denied! Please Log in to access this Page!"; 
    header("Location: ./index.php");
    exit;
        }
} 
    $count = 0;
    require_once "./api/config/db_function.php";
    $conn = db_connect();

    $query = "SELECT id, book_image, book_title FROM books";
    $result = mysqli_query($conn, $query);

    if(!$result) {
        echo "Can't retrieve book data " . mysqli_error($conn);
        exit;
    }
    $title = "Welcome";
    require_once "./template/header.php";
?>

<p class = "lead text-center text-muted">All Books</p>
    <?php 
       for ($i=0; $i<mysqli_num_rows($result); $i++){?>
       <div class ="row">
            <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
                <div class = "col-md-3">
                    <a href="book.php?id=<?php echo $query_row['id']; ?>">
                    <img class="img-thumbnail" src="assets/<?php echo $query_row['book_image'];?>" alt=""  style ="width:17vw;height:22vw;margin:2px;">
                    <span class ="font-italic font-weight-normal d-inline-block text-truncate" style="max-width: 150px;" ><?php echo $query_row['book_title'];?></span>
                    </a>
                   
                </div>
            <?php 

            $count++;
            if ($count >= 4){
                $count = 0;
            break;
            }
            
            }?>
       </div>

        <?php }

        if(isset($conn)){ mysqli_close($conn);}
        require_once "./template/footer.php"
    ?>