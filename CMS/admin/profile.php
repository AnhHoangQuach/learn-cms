<?php 
	require_once('inc/top.php'); 
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}

	$session_username = $_SESSION['username'];
	$query = "SELECT * FROM users WHERE username = '$session_username'";
	$run = mysqli_query($con ,$query);
	$row = mysqli_fetch_array($run);

	$image = $row['image'];
	$id = $row['id'];
	$date = getdate($row['date']);
	$day = $date['mday'];
	$month = substr($date['month'],0,3);
	$year = $date['year'];
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$username = $row['username'];
	$email = $row['email'];
	$role = $row['role'];
	$details = $row['details'];
	$password = $row['password'];
?>
</head>
<body>
	<div id="wrapper">
		<?php require_once('inc/header.php'); ?>
		<div class="container-fluid body-section">
			<div class="row">
				<div class="col-md-3">
					<?php require_once('inc/sidebar.php'); ?>
				</div>
				<div class="col-md-9">
					<h1><i class="fas fa-user"></i> Profile <small>Personal Details</small></h1><hr>
					<ol class="breadcrumb">
						<li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
						<li class="active"><i class="fas fa-user"></i> Profile</li>
					</ol>
					<div class="row">
						<div class="col-xs-12">
							<center><img src="images/<?php echo $image;?>" width="200px" class="img-circle img-thumbnail"></center><br>
							<a href="edit-profile.php?edit=<?php echo $id;?>" class="btn btn-primary pull-right">Edit Profile</a><br>
							<center>
								<h3>Profile Details</h3>
							</center>
							<table class="table table-bordered">
								<tr>
									<td><b>User ID:</b></td>
									<td><?php echo $id;?></td>
									<td><b>Signup date</b></td>
									<td><?php echo "$day $month $year";?></td>
								</tr>

								<tr>
									<td><b>First Name:</b></td>
									<td><?php echo $first_name;?></td>
									<td><b>Last Name:</b></td>
									<td><?php echo $last_name;?></td>
								</tr>

								<tr>
									<td><b>Username</b></td>
									<td><?php echo $username;?></td>
									<td><b>Email:</b></td>
									<td><?php echo $email;?></td>
								</tr>

								<tr>
									<td><b>Role:</b></td>
									<td><?php echo $role;?></td>
									<td><b>Password:</b></td>
									<td><?php echo $password;?></td>
								</tr>
							</table>
							<div class="row">
								<div class="col-lg-8 col-sm-12">
									Details:
									<div><?php echo $details;?></div>
								</div>
							</div><br>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once('inc/footer.php'); ?>