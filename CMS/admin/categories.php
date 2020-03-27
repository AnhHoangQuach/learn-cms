<?php 
	require_once('inc/top.php');
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	} else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author') {
		header('Location: index.php');
	}

	if(isset($_GET['edit'])) {
		$edit_id = $_GET['edit'];
	}

	if(isset($_GET['del'])) {
		$del_id = $_GET['del'];
		$del_query = "DELETE FROM categories WHERE id = '$del_id'";
		if($_SESSION['username'] && $_SESSION['role'] == 'admin') {
			if(mysqli_query($con ,$del_query)) {
				$del_msg = "Deleted success";
			} else {
				$del_error = "Error";
			}
		}
	}

	if(isset($_POST['submit'])) {
		$cat_name = mysqli_real_escape_string($con, strtolower($_POST['cat-name']));
		if(empty($cat_name)) {
			$error = "You must fill field";
		} else {
			$check_query = "SELECT * FROM categories WHERE category = '$cat_name'";

			$check_run = mysqli_query($con ,$check_query);
			if(mysqli_num_rows($check_run) > 0) {
				$error = "Category already exist";
			} else {
				$insert_query = "INSERT INTO categories (category) VALUES ('$cat_name')";
				if(mysqli_query($con, $insert_query)) {
					$msg = "Success";
				} else {
					$error = "Error";
				}
			}
		}
	}

	if(isset($_POST['update'])) {
		$cat_name = mysqli_real_escape_string($con, strtolower($_POST['cat-name']));
		if(empty($cat_name)) {
			$up_error = "You must fill field";
		} else {
			$check_query = "SELECT * FROM categories WHERE category = '$cat_name'";

			$check_run = mysqli_query($con ,$check_query);
			if(mysqli_num_rows($check_run) > 0) {
				$up_error = "Category already exist";
			} else {
				$update_query = "UPDATE `categories` SET `category` = '$cat_name' WHERE `categories`.`id` = $edit_id";
				if(mysqli_query($con, $update_query)) {
					$up_msg = "Success";
				} else {
					$up_error = "Error";
				}
			}
		}
	}
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
					<h1><i class="fas fa-folder-open"></i> Categories <small>Different Categories</small></h1><hr>
					<ol class="breadcrumb">
						<li><a href="index.html"><i class="fas fa-tachometer-alt"></i> Dashboard</li></a>
						<li class="active"><i class="fas fa-folder-open"></i> Categories</li>
					</ol>
					<div class="row">
						<div class="col-md-6">
							<form action="" method="POST">
								<div class="form-group">
									<label for="category">Category Name:</label>
									<?php
										if(isset($msg)) {
											echo "<span class='pull-right' style='color: green;'>$msg</span>";
										} else if(isset($error)) {
											echo "<span class='pull-right' style='color: red;'>$error</span>";
										}
									?>
									<input type="text" name="cat-name" placeholder="Category Name" class="form-control">
								</div>
								<input type="submit" name="submit" value="Add Category" class="btn btn-primary">
							</form>
							<?php 
								if(isset($_GET['edit'])) {
									$edit_check_query = "SELECT * FROM categories WHERE id = $edit_id";
									$edit_check_run = mysqli_query($con ,$edit_check_query);
									if(mysqli_num_rows($edit_check_run) > 0) {
										$edit_row = mysqli_fetch_array($edit_check_run);
										$up_category = $edit_row['category'];
							?>
							<hr>
							<form action="" method="POST">
								<div class="form-group">
									<label for="category">Update Category Name:</label>
									<?php
										if(isset($up_msg)) {
											echo "<span class='pull-right' style='color: green;'>$up_msg</span>";
										} else if(isset($up_error)) {
											echo "<span class='pull-right' style='color: red;'>$up_error</span>";
										}
									?>
									<input type="text" name="cat-name" value="<?php echo $up_category; ?>" placeholder="Category Name" class="form-control">
								</div>
								<input type="submit" name="update" value="Update Category" class="btn btn-primary">
							</form>
							<?php 
									}
								}
							?>
						</div>
						<div class="col-md-6">
							<?php 
								$get_query = "SELECT * FROM categories ORDER BY id DESC";
								$get_run = mysqli_query($con ,$get_query);

								if(mysqli_num_rows($get_run) > 0) {
									if(isset($del_msg)) {
										echo "<span class='pull-right' style='color: green;'>$del_msg</span>";
									} else if(isset($del_error)) {
										echo "<span class='pull-right' style='color: red;'>$del_error</span>";
									}
							?>
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr>
										<th>Sr #</th>
										<th>Category Name</th>
										<th>Posts</th>
										<th>Edit</th>
										<th>Del</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										while($get_row = mysqli_fetch_array($get_run)) {
											$category_id = $get_row['id'];
											$category_name = $get_row['category'];
										
									?>
									<tr>
										<td><?php echo $category_id;?></td>
										<td><?php echo ucfirst($category_name);?></td>
										<td>12</td>
										<td><a href="categories.php?edit=<?php echo $category_id;?>"><i class="fas fa-edit"></i></a></td>
										<td><a href="categories.php?del=<?php echo $category_id;?>"><i class="fas fa-trash-alt"></i></a></td>
									</tr>
									<?php 
										}
									?>
								</tbody>
							</table>
							<?php 
								} else {
									echo "<center><h3>No categories found</h3></center>";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once('inc/footer.php'); ?>