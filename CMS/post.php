<?php require_once('inc/top.php'); ?>
</head>
<body>
	<?php require_once('inc/header.php'); ?>

	<?php 
		$session_username = $_SESSION['username'];
		if(isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'];

			$views_query = "UPDATE `posts` SET `views` = views + 1 WHERE `posts`.`id` = $post_id";
			mysqli_query($con,$views_query);
			$query = "SELECT * FROM posts WHERE status = 'publish' and id = $post_id";
			$run = mysqli_query($con,$query);
			if(mysqli_num_rows($run) > 0) {
				$row = mysqli_fetch_array($run);
				$id = $row['id'];
				$date = getdate($row['date']);
				$day = $date['mday'];
				$month = $date['month'];
				$year = $date['year'];
				$title = $row['title'];
				$image = $row['image'];
				$author_image = $row['author_image'];
				$author = $row['author'];
				$categories = $row['categories'];
				$post_data = $row['post_data'];
			} else {
				header('Location: index.php');
			}
		}
	?>
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
					<div class="post">
						<div class="row">
							<div class="col-md-2 post-date">
								<div class="day"><?php echo $day;?></div>
								<div class="month"><?php echo $month;?></div>
								<div class="year"><?php echo $year;?></div>
							</div>
							<div class="col-md-8 post-title">
								<a href="post.php?post_id=<?php echo $id;?>"><h2><?php echo $title;?></h2></a>
								<p>Written by: <span><?php echo $author;?></span></p>
							</div>
							<div class="col-md-2 profile-picture">
								<img src="images/<?php echo $author_image;?>" class="img-circle">
							</div>
						</div>
						<a href="images/<?php echo $image;?>"><img src="images/<?php echo $image;?>"></a>
						<div class="desc">
							<?php echo $post_data;?>
						</div>
						<div class="bottom">
							<span class="first"><i class="fas fa-folder"></i><a href="#"><?php echo ucfirst($categories)?></a></span>|
							<span class="sec"><i class="fas fa-comments"></i><a href="#"> Comment</a></span>
						</div>
					</div>

					<div class="related-posts">
						<h3>Related Post</h3><hr>
						<div class="row">
							<?php
								$r_query = "SELECT * FROM posts WHERE status = 'publish' AND title LIKE '%$title%' LIMIT 3";
								$r_run = mysqli_query($con,$r_query);
								while($r_row = mysqli_fetch_array($r_run)) {
									$r_id = $r_row['id'];
									$r_title = $r_row['title'];
									$r_image = $r_row['image'];
							?>
							<div class="col-sm-4">
								<a href="post.php?post_id=<?php echo $r_id;?>">
									<img src="images/<?php echo $r_image;?>">
									<h4><?php echo $r_title;?></h4>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>

					<div class="author">
						<div class="row">
							<div class="col-sm-3">
								<img src="images/<?php echo $author_image;?>" class="img-circle">
							</div>
							<div class="col-sm-9">
								<h4><?php echo $author;?></h4>
								<?php 
									$bio_query = "SELECT * FROM users WHERE username = '$author'";
									$bio_run = mysqli_query($con, $bio_query);
									if(mysqli_num_rows($bio_run) > 0) {
										$bio_row = mysqli_fetch_array($bio_run);
										$author_details = $bio_row['details'];

								?>
								<p><?php echo $author_details;?></p>
								<?php 
									}
								?>
							</div>
						</div>
					</div>
					<?php
						$c_query = "SELECT * FROM comments WHERE status = 'approve' and post_id = $post_id";
						$c_run = mysqli_query($con,$c_query);
						if(mysqli_num_rows($c_run) > 0) {
					?>
					<div class="comment">
						<h3>Comments</h3>
						<?php
							while($c_row = mysqli_fetch_array($c_run)) {
								$c_id = $c_row['id'];
								$c_name = $c_row['name'];
								$c_username = $c_row['username'];
								$c_image = $c_row['image'];
								$c_comment = $c_row['comment'];								
						?>
						<hr>
						<div class="row single-comment">
							<div class="col-sm-2">
								<img src="images/<?php echo $c_image;?>" class="img-circle">
							</div>
							<div class="col-sm-10">
								<h4><?php echo ucfirst($c_name);?></h4>
								<p><?php echo $c_comment;?></p>
							</div>
						</div>
						<?php 
							} 
						?>
					</div>
					<?php
						}
						if(isset($_POST['submit'])) {
							$cs_name = $_POST['name'];
							$cs_email = $_POST['email'];
							$cs_website = $_POST['website'];
							$cs_comment = $_POST['comment'];
							$cs_date = time();
							if(empty($cs_name) || empty($cs_email) || empty($cs_comment)) {
								$error_msg = "All fields are Required";
							} else {
								$cs_query = "INSERT INTO `comments` (`id`, `date`, `name`, `username`, `post_id`, `email`, `website`, `image`, `comment`, `status`) VALUES (NULL, '$cs_date', '$cs_name', '$session_username', '$post_id', '$cs_email', '$cs_website', 'up.jpg', '$cs_comment', 'pending')";
								if(mysqli_query($con,$cs_query)) {
									$msg = "Comment submited and waiting for approve";
									$cs_name = "";
									$cs_email = "";
									$cs_website = "";
									$cs_comment = "";
								} else {
									$error_msg = "Comment has not be submited";
								}
							}
						}
					?>

					<div class="comment-box">
						<div class="row">
							<div class="col-xs-12">
								<form action="" method="POST">
									<div class="form-group">
										<label for="full-name">Full Name: </label>
										<input type="text" name="name" id="full-name" class="form-control" placeholder="Full Name" value="<?php if(isset($cs_name)) { echo $cs_name;}?>">
									</div>

									<div class="form-group">
										<label for="email">Email: </label>
										<input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php if(isset($cs_email)) { echo $cs_email;}?>">
									</div>

									<div class="form-group">
										<label for="website">Website: </label>
										<input type="text" name="website" id="website" class="form-control" placeholder="Website" value="<?php if(isset($cs_website)) { echo $cs_website;}?>">
									</div>

									<div class="form-group">
										<label for="comment">Comment: </label>
										<textarea id="comment" name="comment" cols="30" rows="10" class="form-control" placeholder="Your comment should be here"><?php if(isset($cs_comment)) { echo $cs_comment;}?></textarea>
									</div>
									<input type="submit" name="submit" value="Submit Comment" class="btn btn-primary">
									<?php 
										if(isset($error_msg)) {
											echo "<span class='pull-right' style='color:red;'>$error_msg</span>";
										} else if(isset($msg)) {
											echo "<span class='pull-right' style='color:green;'>$msg</span>";
										}
									?>
								</form>
							</div>
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