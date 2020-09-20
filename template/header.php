
<?php
    include('./api/config/db_auth.php');
?>
<!DOCTYPE html>

<html leng = "en">
    <head>
    <meta charset = "utf-8">
    <!-- <meta http-equvi="X-UA-Compatible" content ="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $title;?></title> 

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="./css/custom.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <style>
    .nav-container{
        margin : 0px;
    }
    </style>
    </head>

    <body>  
    <div class ="nav-container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <a class="navbar-brand" href="<?php 
        if(isset($_SESSION['name']) && $_SESSION['name']=='admin') {
            echo "userinfo.php";
            } 
            else if(isset($_SESSION['student_id'])){
                echo "welcome.php";}?>">
        <img src="./assets/logo-header-wytu.png" alt="logo" height="40">
        </a>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($page) && $page == "allbooks") echo "active"; ?>" href="./allbooks.php"> All Books</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php if(isset($page) && $page == "category") echo "active"; ?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category
                    </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./categorybooks.php?category=Electronic">Electronic</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Civil">Civil</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Archi">Archi</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Information Technology">Information Technology</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Electrical Power">Electrical Power</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Mechanical Power">Mechinal Power</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Mechatronics">Mechatronics</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Chemical">Chemical</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Textile">Textile</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Business">Business</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Science">Science</a>
                            <a class="dropdown-item" href="./categorybooks.php?category=Others">Others</a>
                        </div>
                </li>
                <li class="nav-item">
                <?php 
                    if(!empty($_SESSION['student_id'])) {
                    echo '<a class="nav-link" href="#">Contact Us</a>';
                    }

                    if(!empty($_SESSION['name'])) {
                        if(isset($page) && $page=="add_book") {
                        echo '<a class="nav-link active" href="./admin_books_add.php">Add New Book</a>';
                        }
                            if(!isset($page)) {
                            echo '<a class="nav-link" href="./admin_books_add.php">Add New Book</a>'; 
                            }   
                    } 
                      
                ?>
                    
                </li>
                <li class="nav-item">
                <?php 
                    if(!empty($_SESSION['student_id'])) {
                    echo '<a class="nav-link" href="#">About Us</a>';
                    }
                    if(!empty($_SESSION['name']) && $_SESSION['name'] == 'admin') {
                        if(isset($page) && $page=="book_info") {
                        echo '<a class="nav-link active" href="./admin_books_info.php">Book Informations</a>';
                        }
                        if (!isset($page)) {
                            echo '<a class="nav-link" href="./admin_books_info.php">Book Informations</a>';
                           }
                    } 
                      
                ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>

            </ul>
        </div>
            <div class="navbar-nav ml-auto">
            <?php if(!empty($_SESSION['student_id']) || !empty($_SESSION['name'])) { 
              echo  '<li  class="nav-item " ><a href="./api/logout.php" class="btn btn-danger btn-block">Logout</a></li>';
            } else {echo  '<li  class="nav-item " ><a href="./index.php" class="btn btn-danger btn-block">Login</a></li>';
            } ?>
        </div>
        </nav>

        <?php 
            if(isset($title) && $title=="Welcome"){
        ?>
        <div class ="jumbotron">
            <div class ="container">
            <h1>Welcome to the WYTU Online Library</h1>
            <p class ="lead">This site is developed for educational purpose!</p>
            <p class ="lead">Read and download the e-books free and share the others. </p>
            <p class ="lead">All contents are cridited by this site.</p>
            </div>
        </div>
            <?php }?>

            <div class="container" id="main">

            <div class="container">
 
 <?php
 // show page header for add page session
 echo "<div class='page-header'>
         <h1>{$page_title}</h1>
     </div>";
 ?>