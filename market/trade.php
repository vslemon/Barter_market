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
	<?php
		if(isset($_GET['post_id'])) {
			
			$get_id = $_GET['post_id'];

			$get_post = "select * from posts where post_id='$get_id'";
			$run_post = mysqli_query($con, $get_post);
			$row = mysqli_fetch_array($run_post);

			$name = $row['name'];
			$qty = $row['qty'];
			$price = $row['price'];

			$user_to = $row['user_id'];
		
		}

		$user = $_SESSION['user_email'];
		$get_user = "select * from users where user_email='$user'";
		$run_user = mysqli_query($con, $get_user);
		$row = mysqli_fetch_array($run_user);
		$user_from = $row['user_id'];


	?>
	<div id="insert_post" class="col-sm-12">
		<center>
			<form action="" method="post" id="f">
				<h3>Select how many of <?php echo"$name" ?> you want to trade</h3>
				<div id="register">
					<fieldset>
						<input value="<?php echo $qty?>" type="number" name="qty" required   min="1" max="<?php echo $qty?>" pattern="[0-9]+">
					</fieldset>
					<fieldset>
						<textarea  placeholder="Add a note.." name="note"></textarea>
					</fieldset>
				</div>
				<input type="submit" name="update" value="Confirm transaction" class="btn btn-warning"/>
			</form>	
		</center>
	</div>
	<?php
		if(isset($_POST['update'])) {
			$qty = htmlentities($_POST['qty']);
			$note = htmlentities($_POST['note']);

			$insert = "insert into trades (user_to,user_from,trade_qty_to,post_id_to,note,date) values ('$user_to','$user_from','$qty','$get_id','$note',NOW())";
			$run_insert = mysqli_query($con,$insert);
			if($run_insert) {
				echo "<script>alert('Request Sent!')</script>";
				echo "<script>window.open('home.php', '_self')</script>";
			}
		}
	?>


</body>
</html>


