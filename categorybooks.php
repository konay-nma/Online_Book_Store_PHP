<?php 
   $page ="category";
   $page_title = "";
   session_start();
   $count=0;
   if(empty($_SESSION['student_id'])) {
    if(empty($_SESSION['name'])){
    //echo "Access Denied! Please Log in to access this Page!"; 
header("Location: ./index.php");
exit;
    }
} 

   $category = $_GET['category'];

    //connect to database
    require_once "./api/config/db_function.php";
    $conn = db_connect();

    $query = "SELECT id, book_image, book_title FROM books WHERE category='$category'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Can't retrieve Book data " . mysqli_error($conn);
        exit;
    }
    $title='';
    switch($category){
        case "Electronic":
            $title="$category";
        break;
        case "Civil":
            $title="$category";
        break;
        case "Archi":
            $title="$category";
        break;
        case "Information Technology":
            $title="$category";
        break;
        case "Electrical Power":
            $title="$category";
        break;
        case "Mechanical Power":
            $title="$category";
        break;
        case "Mechatronics":
            $title="$category";
        break;
        case "Chemical":
            $title="$category";
        break;
        case "Textile":
            $title="$category";
        break;
        case "Business":
            $title="$category";
        break;
        case "Science":
            $title="$category";
        break;
        case "Others":
            $title="$category";
        break;
    }
    require_once "./template/header.php";
?>

<p class = "lead text-muted" ><?php echo $title;?></p>
    <?php for($i=0; $i<mysqli_num_rows($result); $i++) { ?>
        <div class ="row">
            <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
            <div class ="col-md-3" >
                <a href="book.php?id=<?php echo $query_row['id']; ?>">
                <img class ="img-thumbnail" src="assets/<?php echo $query_row['book_image'];?>" alt=""  style ="width:17vw;height:22vw;margin:2px;">
                <span class ="font-italic font-weight-normal d-inline-block text-truncate" style="max-width: 150px;" ><?php echo $query_row['book_title'];?></span>
                </a>
            </div>
            <?php
             $count++;
             if($count >= 4){
                 $count = 0;
                 break;
               }
            } ?>

        </div>
    <?php 
        }
    if(isset($conn)){ mysqli_close($conn);}
    require_once "./template/footer.php"
    ?>