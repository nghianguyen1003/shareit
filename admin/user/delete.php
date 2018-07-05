<?php
	session_start();
	ob_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
	$id = $_GET['id'];
	
	$query2 = 'SELECT * FROM user WHERE id = '.$id;
	$result2 = $mysqli->query($query2);
	$arUser = mysqli_fetch_assoc($result2);
	if($_SESSION['userinfo']['active'] != 1){
		header('location: index.php');
		die();
	}else{
		if(empty($id)){
		header('location: index.php');
		die();
		}
		
		$query = 'DELETE FROM user WHERE id = '.$id;
		$result = $mysqli->query($query);
		if($result){
			unlink($_SERVER['DOCUMENT_ROOT']."/files/userIMG/" . $arUser['picture']);
			header("location:index.php?msg=Xóa thành công!");
			die();
		}else{
			header("location:index.php?msg=Xóa thất bại!");
			die();
		}
	}
	
	
	
	ob_end_flush();
?>