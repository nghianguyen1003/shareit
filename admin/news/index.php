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
								?>
                                <form action="" method="post">
                                	<div class="row">
                                      
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control border-input" placeholder="Tìm kiếm..." value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="friend_list" class="form-control border-input">
                                                	<option value="0">-- Chọn danh mục --</option>
                                                	<?php
														showCategories($categories);
													?>
                                                </select>
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
                                <table class="table table-striped">
                                    <thead>
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
										$query = "SELECT news.id AS newsid, \n"
												. "news.name AS newsname, \n"
												. "preview, news.picture as newspicture, \n"
												. "cat_list.name as catname, username, is_slide \n"
												. "FROM news\n"
												. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
												. "INNER JOIN user ON news.created_by = user.id\n"
												. "ORDER BY news.id DESC";
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

								<div class="text-center">
								    <ul class="pagination">
								        <li><a href="?p=0" title="">1</a></li> 
								        <li><a href="?p=1" title="">2</a></li> 
								        <li><a href="?p=1" title="">3</a></li> 
								        <li><a href="?p=1" title="">4</a></li> 
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