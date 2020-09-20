<?php 
session_start();
$title = "Edit";
$page_title = "";
require_once "./template/header.php";
require_once "./api/config/db_function.php";
$conn = db_connect();
$result = getBooksInfo($conn);
$book_id = $_GET['id']
?>
<p class ="lead">Fill book's informations</p>
<table class="table" style="margin-top: 20px">
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Author</th>
			<th>Image</th>
			<th>Description</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['book_title']; ?></td>
			<td><?php echo $row['book_author']; ?></td>
			<td> <img src="<?php echo $row['book_image'] ?>" alt="" style ="width:10vw;height:auto"></td>
			<td><?php echo $row['book_desc']; ?></td>
			<td><a href="admin_edit.php?bookisbn=<?php echo $row['book_isbn']; ?>">Edit</a></td>
			<td><a href="admin_delete.php?bookisbn=<?php echo $row['book_isbn']; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>

<?php 
 if(isset($conn)) {
     mysqli_close($conn);
 }
?>