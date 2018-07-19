<?php 
	if(isset($_GET['msg'])){
		?>
		<p class="category success">
		<?php echo $_GET['msg']; ?>
		</p>
		<?php
	}
	if(!isset($_SESSION['userinfo']) || $_SESSION['userinfo']['status'] == 0) {
		header('location: /admin/auth/login.php');
		session_destroy();
	}
?>