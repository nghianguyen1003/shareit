<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
	$query = "SELECT * FROM cat_list WHERE parent_id = 0";
	$result = $mysqli->query($query);
	$categories = array();
	while ($row = mysqli_fetch_assoc($result)){
		$categories[] = $row;
	}
	function showCategories($categories, $parent_id = 0, $char = '')
	{
		foreach ($categories as $key => $item)
		{
			// Nếu là chuyên mục con thì hiển thị
			if ($item['parent_id'] == $parent_id)
			{
					echo '<option value="'.$item['id'].'">';
						echo $char. $item['name'];
					echo '</option>';
				// Xóa chuyên mục đã lặp
				//unset($categories[$key]);
				 
				// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
			showCategories($categories, $item['id'], $char.'☺☺☺');
			}
		}
	}
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
		$queryTSD = "SELECT COUNT(*) AS TSD FROM news";
		if(isset($_GET['searchs'])){
			$search = $_GET['searchs'];
			$queryTSD = "SELECT COUNT(*) AS TSD FROM news WHERE name LIKE '%{$search}%'";
		}
	}else{
		$queryTSD = "SELECT COUNT(*) AS TSD FROM news WHERE created_by = {$id}";
		if(isset($_GET['searchs'])){
			$search = $_GET['searchs'];
			$queryTSD = "SELECT COUNT(*) AS TSD FROM news WHERE name LIKE '%{$search}%' AND created_by = {$id}";
		}
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
<script> //-----------------------------------JS---------------------------------------
	function checkDelete(id){
		if(confirm('Bạn có thực sự muốn xóa ID '+id+' không!')){
			location.href = 'delete.php?id='+id,true;
		}
		return false;
	}
	//----------------------------------------END----------------------------------------
	function getStatus(status, cls){
	$.ajax({
		url: '/template/admin/assets/ajax/resultNews.php',
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

$(document).ready(function(){
	//check /uncheck tất cả bản ghi
	$(document).on('change','#checkall',function(){
		$('.checkitem').prop('checked',this.checked).trigger('change');
	});
	//check/uncheck từng bản ghi
	$(document).on('change','.checkitem',function(){
		var dem_r = 0;
		var checked_r = 1;
		//duyệt tất cả các check item
		$('.checkitem').each(function(){
			if($(this).is(':checked'))
			{
				dem_r++;
			}
			else
			{
				checked_r = 0;
			}
		});
		$('#checkall').prop('checked',checked_r);
		if(dem_r > 0){
			$('#deleteall').show(0.5);
		}
		else
		{
			$('#deleteall').hide(0.5);
		}
	});
});
</script>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Danh sách tin tức</h4>
                               <?php
									if(isset($_GET['msg'])){
										?>
										<p class="category success">
										<?php echo $_GET['msg']; ?>
										</p>
										<?php
									}
									if(isset($_POST['search'])){
										if(isset($_POST['searchtxt'])){
											$search = $_POST['searchtxt'];
											header("location: index.php?searchs={$search}");
										}
									}
								?>
                                <form action="" method="post">
                                	<div class="row">
                                      
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="searchtxt" class="form-control border-input" placeholder="Tìm kiếm tên báo..." value="">
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
                                
                                <a href="insert.php" class="addtop"><img src="/template/admin/assets/img/add.png" alt="" /> Thêm</a>
                            </div>
                            <div class="content table-responsive table-full-width">
								<form action="" method="post">
										<table class="table table-striped">
											<thead>
												<th><input type="checkbox" id="checkall" name="checkall" ></th>
												<th>ID</th>
												<th>Tên tin tức</th>
												<th>Mô tả</th>
												<th>Hình ảnh</th>
												<th>Danh mục</th>
												<th>Bài viết của</th>
												<th>Trạng thái hiển thị</th>
												<th>Chức năng</th>
											</thead>
											<tbody>
											<?php
												if(isset($_POST['delete']))
												{
													$query = "DELETE FROM news WHERE id IN(".implode(',',$_POST['id']).")";
													$result = $mysqli->query($query);
													if($result){
														header('location: /admin/news/index.php?msg=Xóa thành công');
													}else{
														header('location: /admin/news/index.php?msg=Xóa thất bại');
													}
												}
												
												if(isset($_GET['searchs'])){
													$search = $_GET['searchs'];
													if($user['active'] == 1){
													$query = "SELECT news.id AS newsid, \n"
														. "news.name AS newsname, \n"
														. "preview, news.picture as newspicture, \n"
														. "cat_list.name as catname, username, is_slide \n"
														. "FROM news\n"
														. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
														. "INNER JOIN user ON news.created_by = user.id\n"
														. "WHERE news.name LIKE '%{$search}%'\n"
														. "ORDER BY news.id DESC LIMIT {$offset}, {$row_count}";
													}else{
														$query = "SELECT news.id AS newsid, \n"
														. "news.name AS newsname, \n"
														. "preview, news.picture as newspicture, \n"
														. "cat_list.name as catname, username, is_slide \n"
														. "FROM news\n"
														. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
														. "INNER JOIN user ON news.created_by = user.id\n"
														. "WHERE created_by = {$id} AND news.name LIKE '%{$search}%'\n"
														. "ORDER BY news.id DESC LIMIT {$offset}, {$row_count}";
													}
												}else{
													if($user['active'] == 1){
														$query = "SELECT news.id AS newsid, \n"
															. "news.name AS newsname, \n"
															. "preview, news.picture as newspicture, \n"
															. "cat_list.name as catname, username, is_slide \n"
															. "FROM news\n"
															. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
															. "INNER JOIN user ON news.created_by = user.id\n"
															. "ORDER BY news.id DESC LIMIT {$offset}, {$row_count}";
													}else{
														$query = "SELECT news.id AS newsid, \n"
														. "news.name AS newsname, \n"
														. "preview, news.picture as newspicture, \n"
														. "cat_list.name as catname, username, is_slide \n"
														. "FROM news\n"
														. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
														. "INNER JOIN user ON news.created_by = user.id\n"
														. "WHERE created_by = {$id}\n"
														. "ORDER BY news.id DESC LIMIT {$offset}, {$row_count}";
													}
												}
												
												
												$result = $mysqli->query($query);
												while($row = mysqli_fetch_assoc($result)){
													$id = $row['newsid'];
													$name = $row['newsname'];
													$mota = $row['preview'];
													$danhmuc = $row['catname'];
													$picture = $row['newspicture'];
													$nguoitao = $row['username'];
													$status = $row['is_slide'];
													$urlEdit = "edit.php?id={$id}";
											?>
												<tr>
													<td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $id;?>"></td>
													<td><?php echo $id; ?></td>
													<td class="col-md-2"><a href="<?php echo $urlEdit; ?>"><?php echo $name; ?></a></td>
													<td class="col-md-2"><?php echo $mota; ?></td>
													<td><img src="/files/newsIMG/<?php echo $picture; ?>" alt="" width="100px" /></td>
													<td><?php echo $danhmuc; ?></td>
													<td><?php echo $nguoitao; ?></td>
													<td id="<?php echo $id; ?>">
														<a href="javascript:void(0)" title="" onclick="return getStatus(<?php echo $status; ?>, '<?php echo $id; ?>')">
															<img src="<?php getImg($status); ?>" alt=""/>
														</a>
													</td>
													<td>
														<a href="<?php echo $urlEdit; ?>" class="btn btn-primary square-btn-adjust"> Sửa</a>
														<a onclick="return checkDelete(<?php echo $id ?>)" href="" class="btn btn-danger square-btn-adjust"> Xóa</a>
													</td>
												</tr>
											<?php
												}
											?>
											</tbody>
										</table>
										<tfoot>
											<td colspan="4">
												<input style="display:none;" type="submit" name="delete" class="btn" id="deleteall" value="Xóa Chọn">
											</td>
										</tfoot>
									</form>
								<div class="text-center">
								    <ul class="pagination">
										<?php
											for($i = 1; $i <= $tongSoTrang; $i++){
												$active = '';
												if($i == $current_page){
													$active = 'active';
												}
												if(isset($_GET['searchs'])){
													$search = $_GET['searchs'];
												
										?>
											<li class="<?php echo $active; ?>"><a href="index.php?page=<?php echo $i ?>&searchs=<?php echo $search; ?>" title=""><?php echo $i; ?></a></li> 
										<?php
												}else{
													?>
											<li class="<?php echo $active; ?>"><a href="index.php?page=<?php echo $i ?>" title=""><?php echo $i; ?></a></li> 
													<?php
												}
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