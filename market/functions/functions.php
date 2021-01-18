<?php
$databaseHost = 'localhost';
$databaseName = 'marketdb';
$databaseUsername = 'lemon';
$databasePassword = '%mysqlLEMON';

$con = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die("Connection was not established"); 

//function for insterting post
function insertPost(){
	if(isset($_POST['sub'])){
		global $con;
		global $user_id;

		$name = htmlentities($_POST['name']);
		$desc = htmlentities($_POST['desc']);
		$qty = $_POST['qty'];
		$price = $_POST['price'];
		$upload_image = $_FILES['upload_image']['name'];
		$image_tmp = $_FILES['upload_image']['tmp_name'];
		$random_number = rand(1, 100);


		if(strlen($name) > 250 && strlen($desc) > 250) {
			echo "<script>alert('Please Use 250 or less than 250 characters!')</script>";
			echo "<script>window.open('home.php', '_self')</script>";
		}
		else{
			if(strlen($upload_image) >= 1) {
				move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
				$insert = "INSERT INTO posts(user_id, name, descr, qty, price, upload_image, post_date) VALUES('$user_id','$name','$desc','$qty','$price','$upload_image.$random_number',NOW())";
				$run = mysqli_query($con, $insert);
				
				if($run){
					echo "<script>alert('Your product updated a moment ago!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";

					$update = "update users set posts='yes' where user_id='$user_id'";
					$run_update = mysqli_query($con, $update);
				}
				exit();
			}
			else {
				$insert = "INSERT INTO posts(user_id, name, descr, qty, price, post_date) VALUES('$user_id','$name','$desc','$qty','$price',NOW())";
				$run = mysqli_query($con, $insert);

				if($run){
					echo "<script>alert('Your product updated a moment ago!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";

					$update = "update users set posts='yes' where user_id='$user_id'";
					$run_update = mysqli_query($con, $update);
				}
			}
		}
	}
}


function get_posts($u_id){
	global $con;
	$per_page = 4;

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page=1;
	}

	$start_from = ($page-1) * $per_page;

	$get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";

	$run_posts = mysqli_query($con, $get_posts);

	while($row_posts = mysqli_fetch_array($run_posts)){

		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$name = $row_posts['name'];
		$qty = $row_posts['qty'];
		$price = $row_posts['price'];
		$desc = $row_posts['descr'];
		$upload_image = $row_posts['upload_image'];
		$post_date = $row_posts['post_date'];

		$user = "select *from users where user_id='$user_id' AND posts='yes'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);

		$user_name = $row_user['user_name'];
		$user_fname = $row_user['f_name'];
		$user_lname = $row_user['l_name'];
		$user_image = $row_user['user_image'];
		
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
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
				";
				if ($u_id != $user_id){
						echo"<a href='trade.php?post_id=$post_id' style='float:right;'><button class='btn btn-warning'>Trade</button></a>";
				}
				echo"
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a>
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
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
							</div>
						</div><br>
			";
				if ($u_id != $user_id){
						echo"<a href='trade.php?post_id=$post_id' style='float:right;'><button class='btn btn-warning'>Trade</button></a>";
				}
				echo"
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";

		}
	}
	include("pagination.php");
}

function single_post(){

	if(isset($_GET['post_id'])){
		global $con;

		$get_id = $_GET['post_id'];
	
		$get_posts = "select * from posts where post_id='$get_id'";
		$run_posts = mysqli_query($con, $get_posts);
		$row_posts = mysqli_fetch_array($run_posts);

		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$name = $row_posts['name'];
		$qty = $row_posts['qty'];
		$price = $row_posts['price'];
		$desc = $row_posts['descr'];
		$upload_image = $row_posts['upload_image'];
		$post_date = $row_posts['post_date'];

		$user = "select * from users where user_id = '$user_id' AND posts='yes'";
		$run_user = mysqli_query($con, $user);
		$row_user = mysqli_fetch_array($run_user);

		$user_fname = $row_user['f_name'];
		$user_lname = $row_user['l_name'];
		$user_image = $row_user['user_image'];

		$user_com = $_SESSION['user_email'];
		$get_com = "select * from users where user_email='$user_com'";

		$run_com = mysqli_query($con, $get_com);
		$row_com = mysqli_fetch_array($run_com);

		$user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];

		if(isset($_GET['post_id'])){
			$post_id = $_GET['post_id'];
		}

		$get_posts = "select * from users where post_id ='$post_id'";
		$run_user = mysqli_query($con, $get_posts);

		$post_id = $_GET['post_id'];
		$post = $_GET['post_id'];
		$get_user = "select * from posts where post_id='$post_id'";
		$run_user = mysqli_query($con, $get_user);
		$row = mysqli_fetch_array($run_user);

		$p_id = $row['post_id'];
		
		if($p_id != $post_id) {
			echo "<script>alert('ERROR')</script>";
			echo "<script>window.open('home.php', '_self')</script>";
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
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
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
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
							</div>
						</div><br>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";
			}

			include("comments.php");

			echo"
			<div class='row'>
				<div class='col-md-6 col-md-offset-3'>
					<div class='panel panel-info'>
						<div class='panel-body'>
							<form action='' method='post' class='form-inline'>
								<textarea placeholder='Write your comment here!' class='pb-cmnt-textarea' name='comment'></textarea>
								<button class='btn btn-info pull-right' name='reply'>Comment</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			";

			if(isset($_POST['reply'])){
				$comment = htmlentities($_POST['comment']);

				if($comment == ""){
					echo"<script>alert('Enter your comment!')</script>";
					echo"<script>window.open('single.php?post_id=$post_id', '_self')</script>";
				}
				else {
					$insert = "INSERT INTO comments(post_id, user_id, comment, comment_author, date) values('$post_id','$user_id','$comment','$user_com_name', NOW())";
					$run = mysqli_query($con, $insert);
					if($run) {
					echo"<script>alert('Your comment was added successfully')</script>";
					echo"<script>window.open('single.php?post_id=$post_id', '_self')</script>";
					}
				}
			}
		}
	}
}

function user_posts() {
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
									<p><strong>Price: </strong>$price</p>
									<p><strong>Description: </strong>$desc</p>
									<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
								</div>
							</div><br>
							<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
							<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Edit</button></a>
							<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>	
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
									<p><strong>Price: </strong>$price</p>
									<p><strong>Description: </strong>$desc</p>
								</div>
							</div><br>
							<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
							<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Edit</button></a>
							<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>	
						</div>
						<div class='col-sm-3'>
						</div>
					</div><br><br>
					";
			}

		}


	}
}

function results() {
	global $con;

	if(isset($_GET['search'])){
		$search_query = htmlentities($_GET['user_query']);
	}

	$get_posts = "select * from posts where name like '%$search_query%' OR upload_image like '%$search_query%' or descr like '%$search_query%'";
	$run_posts = mysqli_query($con, $get_posts);
	
	while($row_posts=mysqli_fetch_array($run_posts)){
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$name = $row_posts['name'];
		$qty = $row_posts['qty'];
		$price = $row_posts['price'];
		$desc = $row_posts['descr'];
		$upload_image = $row_posts['upload_image'];
		$post_date = $row_posts['post_date'];

		$user = "select * from users where user_id='$user_id' AND posts='yes'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);

		$user_namne = $row_user['user_name'];
		$first_name = $row_user['f_name'];
		$last_name = $row_user['l_name'];
		$user_image = $row_user['user_image'];
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
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
								<h4><small style='color:black;'>Updated a product on <strong>$post_date</strong></small></h4>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
								<p><strong>Product: </strong>$name</p>
								<p><strong>Quantity: </strong>$qty</p>
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px; '>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
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
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
								<h4><small style='color:black;'>Updated a product on <strong>$post_date</strong></small></h4>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
								<p><strong>Product: </strong>$name</p>
								<p><strong>Quantity: </strong>$qty</p>
								<p><strong>Price: </strong>$price</p>
								<p><strong>Description: </strong>$desc</p>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";

		}


	}
}


function search_user() {
	global $con;

	if (isset($_GET['search_user_btn'])) {
		$search_query = htmlentities($_GET['search_user']);
		$get_user = "select * from users where f_name like '%$search_query%' OR l_name like '%$search_query%' OR user_name like '%$search_query%'";
	}
	else {
		$get_user = "select * from users ORDER by 2 ASC";
	}

	$run_user = mysqli_query($con, $get_user);

	while ($row_user = mysqli_fetch_array($run_user)) {

		$user_id = $row_user['user_id'];
		$f_name = $row_user['f_name'];
		$l_name = $row_user['l_name'];
		$username = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		echo"
		<div class='row'>
			<div class='col-sm-3'>
			</div>
				<div class='col-sm-6'>
					<div class='row' id='find_people'>
						<div class='col-sm-4'>
							<a href='user_profile.php?u_id=$user_id'>
							<img src='users/$user_image' width='150px' height='140px' title='$username' style='float:left; margin:1px;'/>
							</a>
						</div><br><br>
						<div class='col-sm-6'>
							<a style='text-decoration:none; cursor:pointer; color:#3897f0;' href='user_profile.php?u_id=$user_id'>
							<h3>$f_name $l_name</h3>
							</a>
						</div>
						<div class='col-sm-3'>
						</div>
					</div>
				</div>
				<div class='col-sm-4'>
				</div>
			</div><br>
		<!--prosoxi mallon leipei ena </div>-->
		";
	}
}
?>

