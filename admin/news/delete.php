<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
	
	if(empty($_GET['id'])){
		header('location: /admin/news');
	}
	else{
		$id = $_GET['id'];
		$queryPicture = "SELECT picture FROM news WHERE id = {$id}";
		$resultPicture = $mysqli->query($queryPicture);
		if($resultPicture){
			$row = mysqli_fetch_assoc($resultPicture);
			$tenFile = $row['picture'];
			$path_root = $_SERVER['DOCUMENT_ROOT'];
			$path_upload = $path_root . "/files/newsIMG/" . $tenFile;
			unlink($path_upload);
		}
		$query = "DELETE FROM news WHERE id = {$id}";
		$result = $mysqli->query($query);
		if($result){
			header('location: /admin/news/index.php?msg=Xóa thành công');
		}else{
			header('location: /admin/news/index.php?msg=Xóa thất bại');
		}
	}
/*Xóa tin:
	Kiểm tra tin hiện tại đang xóa có file không???
	select *  from story where id = $_get['id'];
	$tenHinhAnh = artt['picture'];
	if($tenHinhAnh != ''){
		//có hình
		//xóa hình trong thư mục
		$path_root = $_SERVER['DOCUMENT_ROOT'];
		$path_upload = $path_root . "/files/" . $tenFile;
		unlink($path_upload);
	}*/
	
	
