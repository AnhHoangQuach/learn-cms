<?php require_once('inc/top.php'); ?>
</head>
<body>
	<?php require_once('inc/header.php'); ?>
	<div class="jumbotron">
		<div class="container">
			<div id="details" class="animated fadeInLeft">
				<h1>SK <span>Blog</span></h1>
				<p>Page for all people want to share knowledge</p>
			</div>
		</div>
		<img src="images/blog-banner.jpg">
	</div>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12 contact-form">
							<?php
								if(isset($_POST['submit'])) {
									$name = mysqli_real_escape_string($con, $_POST['name']);
									$email = mysqli_real_escape_string($con, $_POST['email']);
									$website = mysqli_real_escape_string($con, $_POST['website']);
									$comment = mysqli_real_escape_string($con, $_POST['comment']);

									$to = "skyahq13@gmail.com";
									$header = "From: $name<$email>";
									$subject = "Message from $name";

									$message = "Name: $name \n\nEmail: $email \n\nWebsite: $website \n\nMessage: $comment";

									if(empty($name) || empty($email) || empty($comment)) {
										$error = "All fields must fill";
									} else {
										if(mail($to,$subject,$message,$header)) {
											$msg = "Message send success";
										} else {
											$error = "Error";
										}
									}
								}
							?>
							<h2>Contact Form</h2><hr>
							<form action="" method="POST">
								<div class="form-group">
									<label for="full-name">Full Name: </label>
									<?php 
										if(isset($error)) {
											echo "<span class='pull-right' style='color: red'>$error</span>";
										} else if(isset($msg)) {
											echo "<span class='pull-right' style='color: green'>$msg</span>";
										}
									?>
									<input type="text" name="name" id="full-name" class="form-control" placeholder="Full Name">
								</div>

								<div class="form-group">
									<label for="email">Email: </label>
									<input type="email" name="email" id="email" class="form-control" placeholder="Email">
								</div>

								<div class="form-group">
									<label for="website">Website: </label>
									<input type="text" name="website" id="website" class="form-control" placeholder="Website">
								</div>

								<div class="form-group">
									<label for="message">Messages: </label>
									<textarea id="message" cols="30" rows="10" class="form-control" placeholder="Your message should be here" name="comment"></textarea>
								</div>
								<input type="submit" name="submit" value="Submit" class="btn btn-primary">
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<?php require_once('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
	</section>
<?php require_once('inc/footer.php'); ?>