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
	#req_from{
		border: 5px solid #e6e6e6;
	}
</style>
<body>
<h2><center>Pending requests</center></h2>
<?php
$u_id = $_GET['u_id'];

	if(isset($_GET['u_id'])){
		global $con;

		$u_id = $_GET['u_id'];
		$get_trans = "select * from trades where user_to='$u_id'";
		$run_trans = mysqli_query($con,$get_trans);



		while($row_trans = mysqli_fetch_array($run_trans)) {
			$prod_id = $row_trans['post_id_to'];
			$user_from_id = $row_trans['user_from'];
			$trans_id = $row_trans['id'];
			$get_user = "select * from users where user_id='$user_from_id'";
			$run_user = mysqli_query($con,$get_user);
			$row_user = mysqli_fetch_array($run_user);
			$trade_qty = $row_trans['trade_qty_to'];
			$note = $row_trans['note'];
			$user_fname = $row_user['f_name'];
			$user_lname = $row_user['l_name'];
			$user_id = $row_user['user_id'];
			$image = $row_user['user_image'];
			$gender = $row_user['user_gender'];
			$country = $row_user['user_country'];
			$register_date = $row_user['user_reg_date'];
			$describe_user = $row_user['user_desc'];
			$get_prod = "select * from posts where post_id='$prod_id'";
			$run_prod = mysqli_query($con,$get_prod);
			$row_prod = mysqli_fetch_array($run_prod);

			$name = $row_prod['name'];
			$qty = $row_prod['qty'];
			$price = $row_prod['price'];
			$desc = $row_prod['descr'];
			$upload_image = $row_prod['upload_image'];
			$post_date = $row_prod['post_date'];
			$post_id = $row_prod['post_id'];

			if(strlen($upload_image) >= 1) {
				echo"
					<div class='row'>
						<div class='col-sm-3'>
							<div class='col-sm-2'>
							</div>
							<div>
							<div  id='req_from' class='col-sm-8'>								
								<center>
								<h4><a style='text-decoration:none; cursor:pointer; color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_fname</a> is asking for a trade</h4>
								<img class='img-circle' src='users/$image' width='150' height='150'>
								<br><br>
								<ul class='list-group'>
									<li class='list-group-item' title='Username'><strong>$user_fname $user_lname</strong></li>
									<li class='list-group-item' title='User status'><strong>$describe_user</strong></li>
									<li class='list-group-item' title='Gender'><strong>$gender</strong></li>
									<li class='list-group-item' title='Country'><strong>$country</strong></li>
									<li class='list-group-item' title='User Registration Date'><strong>$register_date</strong></li>
								</ul>
								<h4>Notes:</h4>
								<p>$note</p>
								<h4>Quantity:</h4>
								<p>$trade_qty</p>

								<br>								
							</div>
							</div>
						</div>
						<div id='posts' class='col-sm-6'>
							<div class='row'>
								<div class='col-sm-6'>
									<p><strong>Product: </strong>$name</p>
									<p><strong>Quantity: </strong>$qty</p>
									<p><strong>Price: </strong>$price €</p>
									<p><strong>Description: </strong>$desc</p>
									<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
								</div>
								<div class='col-sm-6'>
								</div>
							</div><br>
							<form action='' method='post'>
							<input type='submit' style='float:right;' name='dismiss' value='Dismiss' class='btn btn-danger'/>
							<input type='submit' style='float:right;' name='confirm' value='Confirm' class='btn btn-warning'/>	
							</form>
						</div>
						<div class='col-sm-3'>
						</div>
					</div><br><br>
					";
			}
			else {
				echo"
					<div class='row'>
						<div class='col-sm-3'>
							<div class='col-sm-2'>
							</div>
							<div>
							<div  id='req_from' class='col-sm-8'>								
								<center>
								<h4><a style='text-decoration:none; cursor:pointer; color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_fname</a> is asking for a trade</h4>
								<img class='img-circle' src='users/$image' width='150' height='150'>
								<br><br>
								<ul class='list-group'>
									<li class='list-group-item' title='Username'><strong>$user_fname $user_lname</strong></li>
									<li class='list-group-item' title='User status'><strong>$describe_user</strong></li>
									<li class='list-group-item' title='Gender'><strong>$gender</strong></li>
									<li class='list-group-item' title='Country'><strong>$country</strong></li>
									<li class='list-group-item' title='User Registration Date'><strong>$register_date</strong></li>
								</ul>
								<h4>Notes:</h4>
								<p>$note</p>
								<br>								
							</div>
							</div>
						</div>
						<div id='posts' class='col-sm-6'>
							<div class='row'>
								<div class='col-sm-6'>
									<p><strong>Product: </strong>$name</p>
									<p><strong>Quantity: </strong>$qty</p>
									<p><strong>Price: </strong>$price €</p>
									<p><strong>Description: </strong>$desc</p>
								</div>
								<div class='col-sm-6'>
								</div>
							</div><br>
							<form action='' method='post'>
							<input type='submit' style='float:right;' name='dismiss' value='Dismiss' class='btn btn-danger'/>
							<input type='submit' style='float:right;' name='confirm' value='Confirm' class='btn btn-warning'/>	
							</form>
						</div>
						<div class='col-sm-3'>
						</div>
					</div><br><br>
					";

			}
	

			}
			if(isset($_POST['confirm'])) {

				$sub = $qty-$trade_qty;
				$update_post = "update posts set qty='$sub' where post_id='$post_id'";
				$run_update = mysqli_query($con, $update_post);
				$qty = $sub;
				if($qty <= 0){
					
					$delete_product = "delete from posts where post_id='$post_id'";
					$run_delete = mysqli_query($con,$delete_product);
				}



				$delete_request = "delete from trades where id='$trans_id'";
				$run_delete = mysqli_query($con, $delete_request);
				if ($run_delete) {
					echo"<script>alert('Transaction Complete!')</script>";
					echo"<script>window.open('home.php', '_self')</script>";
				}
			}
			if(isset($_POST['dismiss'])) {
				$delete_request = "delete from trades where id='$trans_id'";
				$run_delete = mysqli_query($con, $delete_request);
				if ($run_delete) {
					echo"<script>alert('Trade offer deleted!')</script>";
					echo"<script>window.open('trade_requests.php', '_self')</script>";
				}
			}
	}
?>

</body>
</html>

