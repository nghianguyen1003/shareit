<?php 
	ob_start();
	if(isset($_GET['msg'])){
		?>
		<p class="category success">
		<?php echo $_GET['msg']; ?>
		</p>
		<?php
	}
	if(!isset($_SESSION['userinfo']) || $_SESSION['userinfo']['status'] == 0) {
		header('location: /admin/auth/login.php?msg=Tài khoản này đã bị khóa!!!');
		session_destroy();
	}
	ob_end_flush();
?>