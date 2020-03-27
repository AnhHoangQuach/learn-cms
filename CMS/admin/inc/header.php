<?php 
	$session_role2 = $_SESSION['role'];
	$session_username2 = $_SESSION['username'];
?>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">SK Blog</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.php"><i class="fas fa-user"></i> Hello, <?php echo ucfirst($session_username2);?></a></li>
				<li><a href="add-post.php"><i class="fas fa-plus-square"></i> Add Post</a></li>
				<?php 
					if($session_role2 == 'admin') {
				?>
				<li><a href="add-user.php"><i class="fas fa-user-plus"></i> Add User</a></li>
				<?php 
					}
				?>
				<li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
				<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>