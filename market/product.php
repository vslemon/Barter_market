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
	<?php
		$user = $_SESSION['user_email'];
		$get_user = "select * from users where user_email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);

		$user_name = $row['user_name'];
	?>
	<title><?php echo "$user_name"; ?></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style>

</style>

<body>
	
	<div class="row">
		<div id="insert_post" class="col-sm-12">
			<center>
				<form action="product.php?id<?php echo $user_id; ?>" method="post" id="f" enctype="multipart/form-data">
					<h3>Product Registration</h3>
					<div id="register">
						<fieldset>
							<input placeholder="Product Name" type="text" name="name" required>
						</fieldset>
						<fieldset>
							<input placeholder="Quantity" type="number" name="qty" min="1" required  pattern="[0-9]+">
						</fieldset>
						<fieldset>
							<input placeholder="Price" type="text" name="price" required>
						</fieldset>
						<fieldset>
							<textarea placeholder="Product description" name="desc" required></textarea>
						</fieldset>
					</div>
					<br>
					<br>
					<label class="btn btn-warning" id="upload_image_button">Select Image<input type="file" name="upload_image" size="30"></label>
					<button id="btn-post" class="btn btn-success" name="sub">Post</button>
				</form>
				<?php insertPost(); ?>
			</center>
		</div>
	</div>
</body>
</html>
