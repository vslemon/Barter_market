<?php
	$get_id = $_GET['post_id'];

	$get_com = "select * from comments where post_id='$get_id' ORDER by 1 DESC";
	$run_com = mysqli_query($con, $get_com);
	

	

	while($row = mysqli_fetch_array($run_com)) {

		$com = $row['comment'];
		$com_name = $row['comment_author'];
		$date = $row['date'];
		$u_id = $row['user_id'];
		
		$get_user = "select * from users where user_name='$com_name'";
		$run_user = mysqli_query($con, $get_user);
		$row_user = mysqli_fetch_array($run_user);
		
		$u_fname = $row_user['f_name'];
		$u_lname = $row_user['l_name'];

		echo"
			<div class='row'>
				<div class='col-md-6 col-md-offset-3'>
					<div class='panel panel-info'>
						<div class='panel-body'>
							<div>
								<h5><strong>$u_fname $u_lname</strong><i> commented</i> on $date</h5>
								<p class='text-primary' style='margin-left:5x; font-size:15px;'>$com</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		";
	}

?>