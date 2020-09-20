<?php 
$id = $_GET['id'];
require_once "./api/config/db_function.php";
$conn = db_connect();

$query = "DELETE FROM books WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if(!$result) {
    echo "Can't detete " . mysqli_error($conn);
    exit;
}
header("Location: admin_books_info.php");
?>
