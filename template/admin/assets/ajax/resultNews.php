<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
	$status = $_POST['astatus'];
	$class = $_POST['acls'];
	
	if($status == 1){
		?>
			<a href="javascript:void(0)" title="" onclick="return getStatus(0, '<?php echo $class; ?>')"><img src="/template/admin/assets/img/cancel.png" alt=""/>
		<?php
		$query = "UPDATE news SET is_slide = 0 WHERE id = {$class}";
	}
	else if($status == 0){
		?>
			<a href="javascript:void(0)" title="" onclick="return getStatus(1, '<?php echo $class; ?>')"><img src="/template/admin/assets/img/checked.png" alt=""/>
		<?php
		$query = "UPDATE news SET is_slide = 1 WHERE id = {$class}";
	}
	$result = $mysqli->query($query);
?>