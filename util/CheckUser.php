<?php 
	ob_start();
	if(!isset($_SESSION['userinfo'])) {
		header('location: /admin/auth/login.php');
	}
	ob_end_flush();
?>