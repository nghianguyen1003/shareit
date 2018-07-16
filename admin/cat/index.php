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
			showCategories($categories, $item['id'], $char.'☺☺☺');
			}
		}
	}
	$user = $_SESSION['userinfo'];
	if($user['active'] == 2){
		header('location: /admin/');
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control border-input" placeholder="Tên danh mục" value="">
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
                                    	<th>Chức năng</th>
                                    </thead>
                                    <tbody>
										<?php
											$query = "SELECT * FROM cat_list WHERE parent_id = 0 ORDER BY id DESC";
											if(isset($_POST['search'])){
												if(isset($_POST['name'])){
													$search = $_POST['name'];
													$query = "SELECT * FROM cat_list WHERE name LIKE '%".$search."%' OR id LIKE '%".$search."%'";
												}
											}
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
                                        	<td>
                                        		<a href="<?php echo $urlEdit;?>" class="btn btn-primary square-btn-adjust"> Sửa</a> &nbsp;||&nbsp;
                                        		<a onclick="return checkDelete(<?php echo $id; ?>);" href="" class="btn btn-danger square-btn-adjust"> Xóa</a>
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