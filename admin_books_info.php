<?php 
session_start();

if(empty($_SESSION['student_id'])) {
	if(empty($_SESSION['name'])){
	//echo "Access Denied! Please Log in to access this Page!"; 
header("Location: ./index.php");
exit;
	}
}

$title = "List Books";
$page_title = "";
$page = "book_info";
require_once "./template/header.php";
require_once "./api/config/db_function.php";
$conn = db_connect();
$result = getBooksInfo($conn);
?>

<p class ="lead">Books Information to Edit and Delete</p>
<table class="table" style="margin-top: 20px">
		<tr>
            <th>Image</th>
			<th>Title</th>
			<th>Author</th>
			<th>Description</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
            <td> <img src="assets/<?php echo $row['book_image'] ?>" alt="" style ="width:9vw;height:12vw"></td>
			<td><?php echo $row['book_title']; ?></td>
			<td><?php echo $row['book_author']; ?></td>
			<td><?php echo $row['book_desc']; ?></td>
			<td><a href="admin_edit.php?id=<?php echo $row['id']; ?>">Edit</a></td>
			<td><a href="admin_delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>

<?php 
 if(isset($conn)) {
     mysqli_close($conn);
 }
 require_once "./template/footer.php"
 
?>