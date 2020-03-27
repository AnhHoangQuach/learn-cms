		<footer class="text-center">
			Copyright &copy; by <a href="https://www.facebook.com/profile.php?id=100007422227963">Hoang Anh</a> from 2020 - <?php echo date('Y'); ?>
		</footer>		
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/code.js"></script>
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script type="text/javascript">
	tinymce.init({
		selector: 'textarea#textarea',
		height: 500,
		plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table paste imagetools wordcount"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		content_css: [
		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		'//www.tiny.cloud/css/codepen.min.css'
		],
		<?php 
			$media_query = "SELECT * FROM media ORDER BY id DESC";
			$media_run = mysqli_query($con, $media_query);
			if(mysqli_num_rows($media_run) > 0) {

			
		?>
		image_list: [
		<?php 
			while($media_row = mysqli_fetch_array($media_run)) {
				$media_name = $media_row['image'];
			
		?>
	    {title: '<?php echo $media_name;?>', value: 'media/<?php echo $media_name;?>'},
	    <?php 
			}
	    ?>
  		]
  		<?php 
  			}
  		?>
	});
	</script>
</body>
</html>