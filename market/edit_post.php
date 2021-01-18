<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
?>
<html>
<head>
	<title>Edit Product</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
	<div class="row">
		<div id="insert_post" class="col-sm-12">
			<center>
				<?php
				if(isset($_GET['post_id'])) {
					$get_id = $_GET['post_id'];

					$get_post = "select * from posts where post_id='$get_id'";
					$run_post = mysqli_query($con, $get_post);
					$row = mysqli_fetch_array($run_post);

					$name = $row['name'];
					$qty = $row['qty'];
					$price = $row['price'];
					$desc = $row['descr'];
				}
				?>
				<form action="" method="post" id="f">
					<h3>Edit your product:</h3>
					<div id="register">
						<fieldset>
							<input value="<?php echo $name?>" type="text" name="name" required>
						</fieldset>
						<fieldset>
							<input value="<?php echo $qty?>" type="number" name="qty" required  min="1" pattern="[0-9]+">
						</fieldset>
						<fieldset>
							<input value="<?php echo $price?>" type="text" name="price" required>
						</fieldset>
						<fieldset>
							<textarea  value="<?php echo $desc?>"name="desc" required><?php echo $desc?></textarea>
						</fieldset>
					</div>
					<input type="submit" name="update" value="Update Product" class="btb btn-info"/>
				</form>
				<?php
				if(isset($_POST['update'])){
					

					$name = $_POST['name'];
					$qty = $_POST['qty'];
					$price = $_POST['price'];
					$desc = $_POST['desc'];
				
					$update_post = "update posts set name='$name', qty='$qty', price='$price', descr='$desc' where post_id='$get_id'";
					$run_update = mysqli_query($con, $update_post);

					if($run_update) {
						echo "<script>alert('Your product has been updated!')</script>";
						echo "<script>window.open('home.php', '_self')</script>";
					}
				}
				?>
			</center>
	</div>
</body>
</html>


