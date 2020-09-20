<?php 
session_start();
require_once "./api/config/db_function.php";
if(empty($_SESSION['student_id'])) {
    if(empty($_SESSION['name'])){
    //echo "Access Denied! Please Log in to access this Page!"; 
header("Location: ./index.php");
exit;
    }
}
$title = "Add Book";
$page_title ="";
$page ="add_book";
require_once "./template/header.php";

$conn = db_connect();

if(isset($_POST['add'])) {

    $book_title =trim($_POST['book_title']);
    $book_title = mysqli_real_escape_string($conn, $book_title);

    $book_author =trim($_POST['book_author']);
    $book_author = mysqli_real_escape_string($conn, $book_author);

    // $book_image =trim($_POST['book_image']);
    // $book_image = mysqli_real_escape_string($conn, $book_image);

    $book_desc =trim($_POST['book_desc']);
    $book_desc = mysqli_real_escape_string($conn, $book_desc);

    $download_link =trim($_POST['download_link']);
    $download_link = mysqli_real_escape_string($conn, $download_link);

    $category =trim($_POST['category']);
    $category = mysqli_real_escape_string($conn, $category);

    if(isset($_FILES['book_image']) && $_FILES['book_image']['name'] !="") {
        $book_image = $_FILES['book_image']['name'];
        $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "assets/";
        $uploadDirectory .= $book_image;
        move_uploaded_file($_FILES['book_image']['tmp_name'], $uploadDirectory);
    }

    $query = "INSERT INTO books (book_title, book_author, book_image, book_desc, download_link, category)
              VALUES ('$book_title', '$book_author', '$book_image', '$book_desc', '$download_link', '$category')";
    $result = mysqli_query($conn,$query);
    if(!$result) {
        echo "Can't add new book to database " . mysqli_error($conn);
    exit;
    } else {
        header("Location: admin_books_info.php");
    }
}
?>

<form method="post" action="admin_books_add.php" enctype="multipart/form-data" >
    <table class="table">
        <tr>
            <th>Book-Tile</th>
            <td><input type="text" name="book_title" required></td>
        </tr>
        <tr>
            <th>Book-Author</th>
            <td><input type="text" name="book_author" required></td>
        </tr>
        <tr>
            <th>Image</th>
            <td><input type="file" name="book_image" required></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><textarea name="book_desc" cols="40" rows="10"></textarea></td>
        </tr>
        <tr>
            <th>Donload-link</th>
            <td><input type="text" name = "download_link" required></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><input type="text" name = "category" required></td>
        </tr>
    </table>
    <input type="submit" name="add" value = "Add new book" class = "btn btn-primary">
    <input type="reset" value="Cancel" class ="btn btn-default"> 
</form>
<br/>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>