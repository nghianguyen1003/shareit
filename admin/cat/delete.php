<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';?>
<?php 
	session_start();
	ob_start(); 
?>
<?php
	$user = $_SESSION['userinfo'];
	if($user['active'] == 2){
		header('location: /admin/');
	}
	if(empty($_GET['id'])){
		header('location: /admin/cat');
	}else{
		$id = $_GET['id'];
		
		$query = "DELETE FROM cat_list WHERE id = {$id}";
		$result = $mysqli->query($query);
		if($result){
			header('location: /admin/cat/index.php?msg=Xóa thành công');
		}else{
			header('location: /admin/cat/index.php?msg=Xóa thất bại');
		}
	}
?>
<?php ob_end_flush(); ?>