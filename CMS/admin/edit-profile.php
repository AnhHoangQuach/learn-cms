<?php 
	require_once('inc/top.php'); 
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}

	$session_username = $_SESSION['username'];

	if(isset($_GET['edit'])) {
		$edit_id = $_GET['edit'];
		$edit_query = "SELECT * FROM users WHERE id = $edit_id";
		$edit_query_run = mysqli_query($con, $edit_query);
		if(mysqli_num_rows($edit_query_run) > 0) {
			$edit_row = mysqli_fetch_array($edit_query_run);
			$e_username = $edit_row['username'];
			if($e_username == $session_username) {
				$e_first_name = $edit_row['first_name'];
				$e_last_name = $edit_row['last_name'];
				$e_image = $edit_row['image'];
				$e_details = $edit_row['details'];
			} else {
				header('Location: inedx.php');
			}
		} else {
			header('Location: index.php');
		}
	} else {
		header("Location: index.php");
	}
?>
</head>
<body>
	<div id="wrapper">
		<?php require_once('inc/header.php'); ?>
		<div class="container-fluid body-section">
			<div class="row">
				<div class="col-md-3">
					<?php require_once('inc/sidebar.php');?>
				</div>
				<div class="col-md-9">
					<h1><i class="fas fa-user"></i> Edit Profile <small>Edit Profile Details</small></h1><hr>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</li></a>
						<li class="active"><i class="fas fa-user"></i> Edit Profile</li>
					</ol>
					<?php 
						if(isset($_POST['submit'])) {
							$first_name = mysqli_real_escape_string($con,$_POST['first-name']);
							$last_name = mysqli_real_escape_string($con,$_POST['last-name']);
							$password = mysqli_real_escape_string($con,$_POST['password']);
							$image = $_FILES['image']['name'];
							$image_tmp = $_FILES['image']['tmp_name'];

							$details = mysqli_real_escape_string($con,$_POST['details']);

							if(empty($image)) {
								$image = $e_image;
							}

							$salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
							$salt_run = mysqli_query($con, $salt_query);
							$salt_row = mysqli_fetch_array($salt_run);
							$salt = $salt_row['salt'];

							$insert_password = crypt($password, $salt);

							if(empty($first_name) || empty($last_name) || empty($image)) {
								$error = "All fields are required";
							} else {
								$update_query = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `image` = '$image', `details` = '$details'";
								if(isset($password)) {
									$update_query .= ",`password` = '$insert_password'";
								}
								$update_query .= " WHERE `users`.`id` = $edit_id";
								if(mysqli_query($con, $update_query)) {
									$msg = "Updated success";
									header("refresh:0; url=edit-profile.php?edit=$edit_id");
									if(!empty($image)) {
										move_uploaded_file($image_tmp, "images/$image");
									}
								} else {
									$error = "Error";
								}
							}
						}
					?>
					<div class="row">
						<div class="col-md-8">
							<form action="" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label for="first-name">First Name:</label>
									<?php 
										if(isset($error)) {
											echo "<span class='pull-right' style='color:red;'>$error</span>";
										} else if(isset($msg)) {
											echo "<span class='pull-right' style='color:green;'>$msg</span>";
										}
									?>
									<input type="text" id="first-name" name="first-name" class="form-control" placeholder="First Name" value="<?php echo $e_first_name;?>">
								</div>

								<div class="form-group">
									<label for="last-name">Last Name:</label>
									<input type="text" id="last-name" name="last-name" class="form-control" placeholder="Last Name" value="<?php echo $e_last_name;?>">
								</div>

								<div class="form-group">
									<label for="password">Password:</label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								</div>

								<div class="form-group">
									<label for="image">Profile Picture:</label>
									<input type="file" id="image" name="image" class="form-control" placeholder="First Name">
								</div>

								<div class="form-group">
									<label for="details">Details:</label>
									<textarea class="form-control" name="details" id="details" cols="30" rows="10"><?php echo $e_details;?></textarea>
								</div>
								<input type="submit" name="submit" value="Update User" class="btn btn-primary">
							</form>
						</div>
						<div class="col-md-4">
							<?php 
								echo "<img src='images/$e_image' width='100%'";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once('inc/footer.php'); ?>