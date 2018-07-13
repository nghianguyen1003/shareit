<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
?>
<?php
	$idComment = $_POST['idCommentAjax'];
	$name = $_POST['nameAjax'];
	$email = $_POST['emailAjax'];
	$comment = $_POST['commentAjax'];
	$idnews = $_POST['idAjax'];
	
	$queryAC = "INSERT INTO comment(name, content, email, parent_id, news_id, status) VALUES ('{$name}','{$comment}', '{$email}', {$idComment}, '{$idnews}', 0)";
	$resultAC = $mysqli->query($queryAC);
?>