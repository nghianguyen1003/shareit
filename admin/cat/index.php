<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<script> //-----------------------------------JS---------------------------------------
	function checkDelete(id){
		if(confirm('Bạn có thực sự muốn xóa ID '+id+' không!')){
			location.href = 'delete.php?id='+id,true;
		}
		return false;
	}
	//----------------------------------------END----------------------------------------
</script>
<?php
	$query = "SELECT * FROM cat_list";
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
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Danh mục tin tức</h4>
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
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" name="id" class="form-control border-input" value=""  placeholder="ID">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="fullname" class="form-control border-input" placeholder="Tên danh mục" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="friend_list" class="form-control border-input">
                                                	<option value="0">Không</option>
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
                                    	<th>Tên danh mục</th>
                                    	<th>ID danh mục cha</th>
                                    	<th>Chức năng</th>
                                    </thead>
                                    <tbody>
										<?php
											$query = "SELECT * FROM cat_list";
											$result = $mysqli->query($query);
											while($row = mysqli_fetch_assoc($result)){
												$id = $row['id'];
												$name = $row['name'];
												$parent_id = $row['parent_id'];
												$urlEdit = "/admin/cat/edit.php?id={$id}&name={$name}";
										?>
                                        <tr>
                                        	<td><?php echo $id; ?></td>
                                        	
											<td>
												<?php echo $name.'<ul>';   // Tra lai tat ca cac Menu cha
													$queryCatCon ="SELECT * FROM cat_list WHERE parent_id = {$id}"; 
													$resultCatCon = $mysqli->query($queryCatCon);
													while($rowCatCon = mysqli_fetch_assoc($resultCatCon)){
														echo '<li><a href="">'.$rowCatCon['name'].'</a>';
														echo '<a href="/admin/cat/edit.php?id='.$rowCatCon['id'].'&name='.$rowCatCon['name'].'">&nbsp;<i class="fas fa-edit"></i></a>&nbsp;||&nbsp;';
														echo '<a href="/admin/cat/delete.php?id='.$rowCatCon['id'].'" onclick="return checkDelete('.$rowCatCon['id'].')"><i class="fas fa-trash"></i></a>';
														echo '</li>';
													}
													echo '</ul>';
												?>
											</td>
                                        	<td><?php echo $parent_id; ?></td>
                                        	<td>
                                        		<a href="<?php echo $urlEdit;?>"><img src="/template/admin/assets/img/edit.gif" alt="" /> Sửa</a> &nbsp;||&nbsp;
                                        		<a onclick="return checkDelete(<?php echo $id; ?>);" href=""><img src="/template/admin/assets/img/del.gif" alt="" /> Xóa</a>
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