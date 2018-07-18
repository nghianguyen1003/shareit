<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php

	//--------------------------------------
	function getImg($status){
		if($status == 1){
			echo '/template/admin/assets/img/checked.png';
		}
		else{
			echo '/template/admin/assets/img/cancel.png';
		}
	}
	
	//-----------------------------------------------
	$user = $_SESSION['userinfo'];
	$id = $user['id'];
	if($user['active'] == 1){
		$queryTSD = "SELECT COUNT(*) AS TSD FROM comment";
		if(isset($_POST['search'])){
			$search = $_POST['searchtxt'];
			$queryTSD = "SELECT COUNT(*) AS TSD FROM comment WHERE content LIKE '%{$search}%'";
		}
	}else{
		$queryTSD = "SELECT COUNT(*) AS TSD FROM comment\n"
				. "INNER JOIN news ON news.id = comment.news_id\n"
				. "WHERE news.created_by = {$id}";
		if(isset($_POST['search'])){
			$search = $_POST['searchtxt'];
			$queryTSD = "SELECT COUNT(*) AS TSD FROM comment\n"
				. "INNER JOIN news ON news.id = comment.news_id\n"
				. "WHERE news.created_by = {$id} AND content LIKE '%{$search}%'";
		}
	}
	if(isset($_POST['search'])){
		$search = $_POST['searchtxt'];
		$queryTSD = "SELECT COUNT(*) AS TSD FROM news WHERE name LIKE '%{$search}%'";
	}
	$resultTSD = $mysqli->query($queryTSD);
	$arTmp = mysqli_fetch_assoc($resultTSD);
	$tongSoDong = $arTmp['TSD'];
	//số truyện trên 1 trang
	$row_count = ROW_COUNT;
	//Số Trang
	$tongSoTrang = ceil($tongSoDong/$row_count);
	$current_page = 1;
	if(isset($_GET['page'])){
		$current_page = $_GET['page'];
	}
	$offset = ($current_page - 1) * $row_count;
?>
<script>
	function getStatus(status, cls){
		$.ajax({
			url: '/template/admin/assets/ajax/result.php',
			type: 'POST',
			cache: false,
			data: {
				astatus: status, 
				acls: cls
			},
			success: function(result){
				$('#' + cls).html(result);
			},
			error: function (){
				alert('Có lỗi xảy ra');
			}
		});
		return false;
	}
	
	
</script>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Quản lý bình luận</h4>
                                <form action="" method="post">
                                	<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="searchtxt" class="form-control border-input" placeholder="Tìm kiếm nội dung bình luận" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        	<div class="form-group">
		                                        <input type="submit" name="search" value="Tìm kiếm" class="is" />
		                                        <input type="submit" name="reset" value="Hủy tìm kiếm" class="is" />
	                                        </div>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Nội dung</th>
                                    	<th>Tên tin tức</th>
                                    	<th>ID người dùng</th>
                                    	<th>Ngày bình luận</th>
                                    	<th>Quản lý bình luận</th>
                                    </thead>
                                    <tbody>
									<?php
										$query = "SELECT comment.id as idcomment,\n"
											. "content, news.name as newsname, comment.status AS commentstatus, \n"
											. "comment.date_create as date, comment.email AS commentemail FROM comment\n"
											. "INNER JOIN news ON news.id = comment.news_id\n"
											. "INNER JOIN user ON news.created_by = user.id\n"
											. "WHERE user.id = {$id}\n"
											. "ORDER BY comment.id DESC LIMIT {$offset}, {$row_count}";
										if($user['active'] == 1){
											$query = "SELECT comment.id as idcomment,\n"
												. "content, news.name as newsname, comment.status AS commentstatus, \n"
												. "comment.date_create as date, comment.email AS commentemail FROM comment\n"
												. "INNER JOIN news ON news.id = comment.news_id\n"
												. "INNER JOIN user ON news.created_by = user.id\n"
												. "ORDER BY comment.id DESC LIMIT {$offset}, {$row_count}";
										}
										if(isset($_POST['search'])){
											if(isset($_POST['searchtxt'])){
												$search = $_POST['searchtxt'];
												$query = "SELECT comment.id as idcomment,\n"
														. "content, news.name as newsname, comment.status AS commentstatus, \n"
														. "comment.date_create as date, comment.email AS commentemail FROM comment\n"
														. "INNER JOIN news ON news.id = comment.news_id\n"
														. "INNER JOIN user ON news.created_by = user.id\n"
														. "WHERE content LIKE '%".$search."%'\n"
														. "ORDER BY comment.id DESC LIMIT {$offset}, {$row_count}";
											}
										}
										$result = $mysqli->query($query);
										while($row = mysqli_fetch_assoc($result)){
											$id = $row['idcomment'];
											$content = $row['content'];	
											$namenews = $row['newsname'];
											$user_id = $row['commentemail'];
											$date_create = date('d-m-Y H:i:s', strtotime($row['date']));
											$status = $row['commentstatus'];
									?>
                                        <tr>
                                        	<td><?php echo $id; ?></td>
                                        	<td><?php echo $content; ?></td>
                                        	<td><?php echo $namenews ?></td>
                                        	<td><?php echo $user_id; ?></td>
                                        	<td><?php echo $date_create; ?></td>
                                        	<td id="<?php echo $id; ?>">
												<a href="javascript:void(0)" title="" onclick="return getStatus(<?php echo $status; ?>, '<?php echo $id; ?>')">
													<img src="<?php getImg($status); ?>" alt=""/>
												</a>
											</td>
                                        </tr>
                                    <?php
										}
									?>
                                    </tbody>
 
                                </table>

								<div class="text-center">
								    <ul class="pagination">
								       <?php
											for($i = 1; $i <= $tongSoTrang; $i++){
												$active = '';
												if($i == $current_page){
													$active = 'active';
												}
										?>
											<li class="<?php echo $active; ?>"><a href="index.php?page=<?php echo $i; ?>" title=""><?php echo $i; ?></a></li> 
										<?php
											}
										?>
								    </ul>
								</div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/footer.php';
?>