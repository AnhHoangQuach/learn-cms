<?php 
	require_once('inc/top.php'); 
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	} else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author') {
		header('Location: index.php');
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
					<h1><i class="fas fa-user-plus"></i> Add User <small>Add New User</small></h1><hr>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</li></a>
						<li class="active"><i class="fas fa-user-plus"></i> Add New User</li>
					</ol>
					<?php 
						if(isset($_POST['submit'])) {
							$date = time();
							$first_name = mysqli_real_escape_string($con,$_POST['first-name']);
							$last_name = mysqli_real_escape_string($con,$_POST['last-name']);
							$username = mysqli_real_escape_string($con,strtolower($_POST['username']));
							$username_trim = preg_replace('/\s+/', '', $username);
							$email = mysqli_real_escape_string($con,strtolower($_POST['email']));
							$password = mysqli_real_escape_string($con,$_POST['password']);
							$role = $_POST['role'];
							$image = $_FILES['image']['name'];
							$image_tmp = $_FILES['image']['tmp_name'];

							$check_query = "SELECT * FROM users WHERE username = '$username' or email = '$email'";
							$check_run = mysqli_query($con, $check_query);

							$salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
							$salt_run = mysqli_query($con, $salt_query);
							$salt_row = mysqli_fetch_array($salt_run);
							$salt = $salt_row['salt'];

							$password = crypt($password, $salt);

							if(empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($image)) {
								$error = "All fields are required";
							} else if($username != $username_trim) {
								$error = "Don't use spaces in username";
							} else if(mysqli_num_rows($check_run) > 0) {
								$error = "Username or Email is already";
							} else {
								$insert_query = "INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`) VALUES (NULL, '$date', '$first_name', '$last_name', '$username', '$email', '$image', '$password', '$role')";
								if(mysqli_query($con, $insert_query)) {
									$msg = "Register completed";
									move_uploaded_file($image_tmp, "images/$image");
									$image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
									$image_run = mysqli_query($con, $image_check);
									$image_row = mysqli_fetch_array($image_run);
									$check_image = $image_row['image'];

									$first_name = "";
									$last_name = "";
									$email = "";
									$username = "";
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
									<input type="text" id="first-name" name="first-name" class="form-control" placeholder="First Name" value="<?php if(isset($first_name)) { echo $first_name;}?>">
								</div>

								<div class="form-group">
									<label for="last-name">Last Name:</label>
									<input type="text" id="last-name" name="last-name" class="form-control" placeholder="Last Name" value="<?php if(isset($last_name)) { echo $last_name;}?>">
								</div>

								<div class="form-group">
									<label for="username">Username:</label>
									<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php if(isset($username)) { echo $username;}?>">
								</div>

								<div class="form-group">
									<label for="email">Email::</label>
									<input type="text" name="email" id="email" class="form-control" placeholder="Email Address" value="<?php if(isset($email)) { echo $email;}?>">
								</div>

								<div class="form-group">
									<label for="password">Password:</label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								</div>

								<div class="form-group">
									<label for="role">Role:</label>
									<select name="role" id="role" class="form-control">
										<option value="author">Author</option>
										<option value="admin">Admin</option>
									</select>
								</div>

								<div class="form-group">
									<label for="image">Profile Picture:</label>
									<input type="file" id="image" name="image" class="form-control" placeholder="First Name">
								</div>
								<input type="submit" name="submit" value="Add User" class="btn btn-primary">
							</form>
						</div>
						<div class="col-md-4">
							<?php 
								if(isset($check_image)) {
									echo "<img src='images/$check_image' width='100%'";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once('inc/footer.php'); ?>