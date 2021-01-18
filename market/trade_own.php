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

	<title>My products</title>
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
		<div class="col-sm'-12">
			<center><h2>Select your product for trading</h2></center>
				<?php 
				global $con;

				if(isset($_GET['u_id'])){
					$u_id = $_GET['u_id'];
				}

				$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 10";
				$run_posts = mysqli_query($con, $get_posts);

				while($row_posts=mysqli_fetch_array($run_posts)) {

			 		$post_id = $row_posts['post_id'];
					$user_id = $row_posts['user_id'];
					$name = $row_posts['name'];
					$qty = $row_posts['qty'];
					$price = $row_posts['price'];
					$desc = $row_posts['descr'];
					$upload_image = $row_posts['upload_image'];
					$post_date = $row_posts['post_date'];

					$user = "select * from users where user_id='$user_id' AND posts='yes'";
					$run_user = mysqli_query($con, $user);
					$row_user = mysqli_fetch_array($run_user);


					$user_fname =$row_user['f_name'];
					$user_lname = $row_user['l_name'];
					$user_name = $row_user['user_name'];
					$user_image = $row_user['user_image'];

					if(isset($_GET['u_id'])){
						$u_id = $_GET['u_id'];
					}
					$getuser = "select user_email from users where user_id='$u_id'";
					$run_user = mysqli_query($con, $getuser);
					$row = mysqli_fetch_array($run_user);

					$user_email = $row['user_email'];

					$user = $_SESSION['user_email'];
					$get_user = "select * from users where user_email='$user'";
					$run_user = mysqli_query($con, $get_user);
					$row = mysqli_fetch_array($run_user);

					$user_id = $row['user_id'];
					$u_email = $row['user_email'];
			 		

					if($u_email != $user_email){
						echo"<script>windos.open('my_post.php?u_id=$user_id','_self')</script>";
						
					}
					else {
						if(strlen($upload_image) >= 1) {
							echo"
								<div class='row'>
									<div class='col-sm-3'>
									</div>
									<div id='posts' class='col-sm-6'>
										<div class='row'>
											<div class='col-sm-2'>
											<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
											</div>
											<div class='col-sm-6'>
												<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_fname $user_lname</a></h3>
												<h4><small style='color:black;'>Updated a product on <strong>$post_date</strong></small></h4>
											</div>
											<div class='col-sm-4'>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-12'>
												<p><strong>Product: </strong>$name</p>
												<p><strong>Quantity: </strong>$qty</p>
												<p><strong>Price: </strong>$price €</p>
												<p><strong>Description: </strong>$desc</p>
												<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
											</div>
										</div><br>
									<a href='trade.php?post_id=$post_id' style='float:right;'><button class='btn btn-warning'>Trade</button></a>
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
									</div>
									<div id='posts' class='col-sm-6'>
										<div class='row'>
											<div class='col-sm-2'>
											<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
											</div>
											<div class='col-sm-6'>
												<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_fname $user_lname</a></h3>
												<h4><small style='color:black;'>Updated a product on <strong>$post_date</strong></small></h4>
											</div>
											<div class='col-sm-4'>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-12'>
												<p><strong>Product: </strong>$name</p>
												<p><strong>Quantity: </strong>$qty</p>
												<p><strong>Price: </strong>$price €</p>
												<p><strong>Description: </strong>$desc</p>
											</div>
										</div><br>
									<a href='trade.php?post_id=$post_id' style='float:right;'><button class='btn btn-warning'>Trade</button></a>	
									</div>
									<div class='col-sm-3'>
									</div>
								</div><br><br>
								";
						}

					}


				}
				?>
		</div>
	</div>
</body>
</html>
