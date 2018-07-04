<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';?>
<?php ob_start(); ?>
<?php
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