<?php 
    session_start();

    if(empty($_SESSION['student_id'])) {
        //echo "Access Denied! Please Log in to access this Page!"; 
    header("Location: ./index.php");
    exit;}
    $count = 0 ;
    $title = "Welcome";
    $page_title = "";
    require_once "./template/header.php";
    require_once "./api/config/db_function.php";
    $conn = db_connect();
    $row = select4LatestBooks($conn);   
?>


<!--row of colums -->
<p class="lead text-center text-muted">Recently Added Books</p>
<div class ="row">
    <?php foreach($row as $book) { ?>
    <div class ="col-md-3">
        <a href="book.php?id=<?php echo $book['id']; ?>">
        <img class="img-thumbnail" src="./assets/<?php echo $book['book_image'];?>" alt="bookimg" style ="width:17vw;height:22vw">
        </a>
        <span class =" lead font-italic font-weight-normal d-inline-block text-truncate" style="max-width: 150px;" ><?php echo $book['book_title'];?></span>
    </div>
    <?php }?>
</div>

<?php 
    if(isset($conn)) {
        mysqli_close($conn);
    }
    
    require_once "./template/footer.php"
?>