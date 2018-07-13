<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
?>
<?php
	$name = $_POST['nameajax'];
	$email = $_POST['emailajax'];
	$comment = $_POST['commentajax'];
	$idnews = $_POST['idajax'];
	$queryAC = "INSERT INTO comment(name, content, email, parent_id, news_id, status) VALUES ('{$name}','{$comment}', '{$email}', 0, '{$idnews}', 0)";
	$resultAC = $mysqli->query($queryAC);
?>
	<!--<div class="cmt comment">
		<div class="media-left">
			<a href="#">
				<img alt="64x64" class="media-object" data-src="/template/public/img/reader_img1.jpg"
                     src="/template/public/img/reader_img1.jpg" data-holder-rendered="true">
			</a>
		</div>
		<div class="media-body">
			<h2 class="media-heading"><a href="#"><?php //echo $email; ?></a></h2><span>10/03/2017</span><br/>
			<?php //echo $comment; ?>

			<div class="entity_vote">
				<a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
				<a href="#"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>-->