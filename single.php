<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/header.php";
?>
<section id="entity_section" class="entity_section">
<div class="container">
<div class="row">
<div class="col-md-8">
<?php
	$id = $_GET['id'];
	$queryGetCat = "SELECT cat_id FROM news WHERE id = {$id}";
	$resultGetCat = $mysqli->query($queryGetCat);
	if($rowGetCat = mysqli_fetch_assoc($resultGetCat)){
		$idGetCat = $rowGetCat['cat_id'];
	}
	if(empty($id)){
		header('location: index.php');
	}
	$query = "SELECT news.id AS newsid ,news.name AS newsname,\n"
    . "news.date_create AS newsdate, COUNT(news_id) AS countcom,\n"
    . "preview, view, news.picture AS newspicture, detail, fullname\n"
    . "FROM news\n"
    . "LEFT JOIN comment ON news.id = comment.news_id\n"
    . "INNER JOIN user ON user.id = news.created_by\n"
    . "WHERE is_slide = 1 AND news.id = {$id}";
	$result = $mysqli->query($query);
	if($row = mysqli_fetch_assoc($result)){
		$pictureMain = $row['newspicture'];
		$nameMain = $row['newsname'];
		$motaMain = $row['preview'];
		$viewMain = $row['view'];
		$dateMain = date('d-m-Y', strtotime($row['newsdate']));
		$commentMain = $row['countcom'];
		$detailMain = $row['detail'];
		$fullnameMain = $row['fullname'];
?>
<div class="entity_wrapper">
    <div class="entity_title">
        <h1><a href="#"><?php echo $nameMain; ?></a></h1>
    </div>
    <!-- entity_title -->

    <div class="entity_meta"><a href="#" target="_self"><?php echo $dateMain; ?></a>, by: <a href="#" target="_self"><?php echo $fullnameMain; ?></a>
    </div>

    <div class="entity_social">
        <a href="#" class="icons-sm sh-ic">
            <i class="fa fas fa-eye"></i>
            <b><?php echo $viewMain; ?> </b><span class="share_ic">Views</span>
        </a>
        <a href="#" class="icons-sm fb-ic"><i class="fa fa-facebook"></i></a>
        <!--Twitter-->
        <a href="#" class="icons-sm tw-ic"><i class="fa fa-twitter"></i></a>
        <!--Google +-->
        <a href="#" class="icons-sm inst-ic"><i class="fa fa-google-plus"> </i></a>
        <!--Linkedin-->
        <a href="#" class="icons-sm tmb-ic"><i class="fa fa-ge"> </i></a>
        <!--Pinterest-->
        <a href="#" class="icons-sm rss-ic"><i class="fa fa-rss"> </i></a>
    </div>
    <!-- entity_social -->

    <div class="entity_thumb">
        <img class="newsdetail" src="/files/newsIMG/<?php echo $pictureMain; ?>" alt="feature-top">
    </div>
    <!-- entity_thumb -->

    <div class="fixentity_content">
        <p>
            <?php echo $detailMain; ?>
        </p>
    </div>
    <!-- entity_content -->

    <div class="entity_footer">
        <div class="entity_tag">
		<?php
			$queryCat = "SELECT * FROM cat_list WHERE parent_id = 0";
			$resultCat = $mysqli->query($queryCat);
			while($rowCat = mysqli_fetch_assoc($resultCat)){
				$idCat = $rowCat['id'];
				$nameCat = $rowCat['name'];
		?>
            <span class="blank"><a href="#"><?php echo $nameCat;?></a></span>
		<?php
			}
		?>
        </div>
        <!-- entity_tag -->

        <div class="entity_social">
            <span><i class="fa fas fa-eye"></i><?php echo $viewMain; ?> <a href="#">Views</a> </span>
            <span><i class="fa fa-comments-o"></i><?php echo $commentMain; ?> <a href="#">Comments</a> </span>
        </div>
        <!-- entity_social -->

    </div>
    <!-- entity_footer -->

</div>
<?php
	}
	$viewMain+=1;
	$queryView = "UPDATE news SET view = {$viewMain} WHERE id = {$id}";
	$resultView = $mysqli->query($queryView);
?>

<div class="related_news">
	<?php
		$queryRelated = "SELECT news.id AS newsid,cat_list.name AS catname, cat_list.id AS catid,\n"
						. "news.name AS newsname, news.date_create AS newsdate,\n"
						. "preview, view, picture,\n"
						. "COUNT(news_id) AS countcm\n"
						. "FROM news\n"
						. "INNER JOIN cat_list ON cat_list.id = news.cat_id\n"
						. "LEFT JOIN comment ON news.id = comment.news_id\n"
						. "WHERE is_slide = 1 AND news.id <> (SELECT id FROM news WHERE date_create = (SELECT MAX(date_create) FROM news)) \n"
						. "AND cat_list.id = {$idGetCat} AND news.id <> {$id} \n"
						. "OR cat_list.parent_id = {$idGetCat} AND is_slide = 1\n"
						. "GROUP BY news.id\n"
						. "ORDER BY newsid DESC\n"
						. "LIMIT 4";
		$resultRelated1 = $mysqli->query($queryRelated);
		$resultRelated = $mysqli->query($queryRelated);
		if($rowRelated1 = mysqli_fetch_assoc($resultRelated1)){
			$catid = $rowRelated1['catid'];
	?>
	<div class="entity_inner__title header_purple">
        <h2><a href="category.php?id=<?php echo $catid; ?>">Related News</a></h2>
    </div>
    <!-- entity_title -->
	<?php
		}
	?>
	<?php
		$dem=0;
		while($rowRelated = mysqli_fetch_assoc($resultRelated)){
			$idRelated = $rowRelated['newsid'];
			$catname = $rowRelated['catname'];
			$pictureRelated = $rowRelated['picture'];
			$nameRelated = $rowRelated['newsname'];
			$motaRelated = $rowRelated['preview'];
			$viewRelated = $rowRelated['view'];
			$commentRelated = $rowRelated['countcm'];
			$dateRelated = date('d-m-Y', strtotime($rowRelated['newsdate']));
			$urlSeoChiTiet = "/chi-tiet/".utf8ToLatin($catname)."/".utf8ToLatin($nameRelated)."-{$idRelated}.html";
			$dem++;
	?>
    <div class="row">
	<?php
		
		if($dem%2 != 0){
	?>
        <div class="col-md-6">
            <div class="media">
                <div class="media-left">
                    <a href="<?php echo $urlSeoChiTiet; ?>"><img class="popularlist" src="/files/newsIMG/<?php echo $pictureRelated; ?>"
                                     alt="Generic placeholder image"></a>
                </div>
                <div class="media-body">
                    <span class="tag purple"><a href="category.php" target="_self"><?php echo $catname; ?></a></span>

                    <h3 class="media-heading"><a href="<?php echo $urlSeoChiTiet; ?>" target="_self"><?php echo $nameRelated; ?></a></h3>
                    <span class="media-date"><a href="#"><?php echo $dateRelated; ?></a></span>

                    <div class="media_social">
                        <span><a href="#"><i class="fa fas fa-eye"></i><?php echo $viewRelated; ?></a> Views</span>
                        <span><a href="#"><i class="fa fa-comments-o"></i><?php echo $commentRelated; ?></a> Comments</span>
                    </div>
                </div>
            </div>
		<?php
		}else{
		?>
			<div class="media">
                <div class="media-left">
                    <a href="single.php?id=<?php echo $idRelated; ?>"><img class="popularlist" src="/files/newsIMG/<?php echo $pictureRelated; ?>"
                                     alt="Generic placeholder image"></a>
                </div>
                <div class="media-body">
                    <span class="tag purple"><a href="category.php" target="_self"><?php echo $catname; ?></a></span>

                    <h3 class="media-heading"><a href="<?php echo $urlSeoChiTiet; ?>" target="_self"><?php echo $nameRelated; ?></a></h3>
                    <span class="media-date"><a href="#"><?php echo $dateRelated; ?></a></span>

                    <div class="media_social">
                        <span><a href="#"><i class="fa fas fa-eye"></i><?php echo $viewRelated; ?></a> Views</span>
                        <span><a href="#"><i class="fa fa-comments-o"></i><?php echo $commentRelated; ?></a> Comments</span>
                    </div>
                </div>
            </div>
        </div>
	<?php
		}
	?>
    </div>
	<?php
		}
	?>
</div>
<!-- Related news -->

<div class="widget_advertisement">
    <img class="img-responsive" src="/template/public/img/category_advertisement.jpg" alt="feature-top">
</div>
<!--Advertisement-->

<div class="readers_comment">
    <div class="entity_inner__title header_purple">
        <h2>Readers Comment</h2>
    </div>
    <!-- entity_title -->
	
	<div class="srollbar">
		<?php
			$idComment = 0;
			$queryComment = "SELECT comment.id AS cmtid, comment.parent_id AS cmtparent, \n"
						. "content, email, comment.date_create AS cmtdate, comment.name AS cmtname FROM comment\n"
						. "INNER JOIN news ON news.id = comment.news_id\n"
						. "WHERE news.id = {$id} AND comment.parent_id = 0 AND comment.status = 1 ORDER BY comment.id DESC";
			$resultComment = $mysqli->query($queryComment);
			while($rowComment = mysqli_fetch_assoc($resultComment)){
				$nameComment = $rowComment['cmtname'];
				$idComment = $rowComment['cmtid'];
				$contentComment = $rowComment['content'];
				$date_createComment = date('d-m-Y', strtotime($rowComment['cmtdate']));
		?>
		<div class="cmt comment">
			<div class="media-left">
				<a href="#">
					<img alt="64x64" class="media-object" data-src="/template/public/img/reader_img1.jpg"
						 src="/template/public/img/reader_img1.jpg" data-holder-rendered="true">
				</a>
			</div>
			<div class="media-body">
				<h2 class="media-heading"><a href="#"><?php echo $nameComment; ?></a></h2><span><?php echo $date_createComment; ?></span><br/>
				<?php echo $contentComment; ?>

				<div class="entity_vote">
					<a href="#">------------------------------------------------------</a>
					<a href="javascript:void(0)"><span class="reply_ic" onClick="return getReply(<?php echo $idComment; ?>);">Reply </span></a>
					<a href="#">------------------------------------------------------</a>
					
				</div>
				<?php
					$queryCommentChild = "SELECT * FROM `comment` WHERE parent_id = {$idComment} AND status = 1";
					$resultCommentChild = $mysqli->query($queryCommentChild);
					while($queryCommentChild = mysqli_fetch_assoc($resultCommentChild)){
						$nameCommentChild = $queryCommentChild['name'];
						$contentCommentChild = $queryCommentChild['content'];
						$date_createCommentChild = date('d-m-Y', strtotime($queryCommentChild['date_create']));
				?>
				<div class="cmt reply1">
					<div class="media-left">
						<a href="#">
							<img alt="64x64" class="media-object" data-src="/template/public/img/reader_img2.jpg"
								 src="/template/public/img/reader_img2.jpg" data-holder-rendered="true">
						</a>
					</div>
					<div class="media-body">
						<h2 class="media-heading"><a href="#"><?php echo $nameCommentChild; ?></a></h2><span><?php echo $date_createCommentChild; ?></span><br/>
						<?php echo $contentCommentChild; ?>

						<div class="entity_vote">
							<a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
							<a href="#"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
				<?php
					}
				?>
				<form class="reply-form<?php echo $idComment; ?>">
					
				</form>
			</div>

		</div>
		<?php
			}
		?>
	</div>
</div>

<!--Readers Comment-->

<div class="entity_comments" id="commentsform">
    <div class="entity_inner__title header_black">
        <h2>Add a Comment</h2>
    </div>
    <!--Entity Title -->

    <div class="entity_comment_from">
        <form id="comments" method="POST">
            <div class="form-group">
                <input required type="text" name="name" class="form-control" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input required type="text" name="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group comment">
                <textarea required class="form-control" name="comment" id="comment" placeholder="Comment"></textarea>
            </div>
            <button onClick="return getComment();" type="submit" name="submit" class="btn btn-submit red">Submit</button>
        </form>
    </div>
    <!--Entity Comments From -->

</div>
<!--Entity Comments -->

</div>
<!--Left Section-->

<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/rightsection.php";
?>

</div>
<!-- row -->

</div>
<!-- container -->

</section>

<!-- Subscriber Section -->

<script>
function getComment(){
	var name = $('#name').val();
	var email = $('#email').val();
	var comment = $('#comment').val();
	var idnews = <?php echo $id; ?>;
	if(name == ''){
		alert('Không được để trống tên');
	}else if(email == ''){
		alert('Không được để trống email');
	}else if(comment == ''){
		alert('Không được để trống comment');
	}else{
		$.ajax({
			url: '/template/public/ajax/resultComment.php',
			type: 'POST',
			cache: false,
			data: {
				nameajax: name, 
				emailajax: email,
				commentajax: comment,
				idajax: idnews,
			},
			success: function(data){
				$('.cmt:eq(0)').before(data);
			},
			error: function (){
				alert('Có lỗi xảy ra');
			}
		});
		alert('QUẢN TRỊ VIÊN ĐANG XEM XÉT BÌNH LUẬN CỦA BẠN');
	}
	return false;
}

function getReply(idComment){
	$.ajax({
		url: '/template/public/ajax/resultReply.php',
		type: 'POST',
		cache: false,
		data: {
			idCommentAjax: idComment,
		},
		success: function(data){
			$('.reply-form'+idComment).html(data);
		},
		error: function (){
			alert('Có lỗi xảy ra');
		}
	});
	return false;
}

function getReplyComment(){
	var name = $('#nameReply').val();
	var email = $('#emailReply').val();
	var comment = $('#commentReply').val();
	var idComment = <?php echo $idComment; ?>;
	var idnews = <?php echo $id; ?>;
	if(name == ''){
		alert('Không được để trống tên');
	}else if(email == ''){
		alert('Không được để trống email');
	}else if(comment == ''){
		alert('Không được để trống comment');
	}else{
		$.ajax({
			url: '/template/public/ajax/resultReplySubmit.php',
			type: 'POST',
			cache: false,
			data: {
				nameAjax: name, 
				emailAjax: email,
				commentAjax: comment,
				idCommentAjax: idComment,
				idAjax: idnews,
			},
			success: function(data){
				$('.reply1').before(data);
			},
			error: function (){
				alert('Có lỗi xảy ra');
			}
		});
		alert('QUẢN TRỊ VIÊN ĐANG XEM XÉT BÌNH LUẬN CỦA BẠN');
	}
	
	return false;
}
</script>
<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/footer.php";
?>
