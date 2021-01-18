<!DOCTYPE html>
<html>
<head>
	<title>Barter Market login and signup</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
	body {
		overflow-x: hidden;
	}
	#signup {
	    background-color :  #196f3d;
		width: 60%;
		border-radius: 30px;
		border: 1px solid  #196f3d;
	}
	#login {
		width: 60%;
		background-color: #fff;
		border: 1px solid  #196f3d;
		color: #196f3d;
		border-radius: 30px;
	}
	#login:hover{
		width: 60%;
		background-color: #fff;
		color: #196f3d;
		border: 2px solid #196f3d;
		border-radius: 30px;
	}
	.well {
		background-color:   #196f3d ;
	}

</style>
<body>
	<div class="row">
		<div class="col-sm-12">
			<div class="well">
				<center><h1 style="color: white;">Barter Market</h1></center>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6" style="left:0.5%;">
			<img src="images/barter.jpg" class="img-rounded" title="Coding cafe" width="650px" height="565px">
		</div>
		<div class="col-sm-6" style="left:8%:">
			<img src="images/handshake.png" class="img-rounded" title="Coding cafe" width="157px" height="80px">
			<h2><strong>The meeting point for individuals who want to trade what they have for what they need</strong></h2><br><br>
			<h4><strong>Join Barter Market</strong></h4>
			<form method="post" action="">
				<button id="signup" class="btn btn-info btn-lg" name="signup">Sign up</button><br><br>
				<?php
				if(isset($_POST['signup'])){
					echo "<script>window.open('signup.php','_self')</script>";
				}
				?>
				<button id="login" class="btn btn-info btn-lg" name="login">Login</button><br><br>
				<?php
				if(isset($_POST['login'])){
					echo "<script>window.open('signin.php','_self')</script>";
				}
				?>
			</form>
		</div>
	</div>
</body>
</html>
