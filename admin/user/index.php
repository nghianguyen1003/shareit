<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<script>
function checkDelete(id){
	if(confirm('Bạn có thực sự muốn xóa ID '+id+' không!')){
		location.href = 'delete.php?id='+id,true;
	}
	return false;
}
</script>
<?php
	$queryTSD = "SELECT COUNT(*) AS TSD FROM user";
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
	
	//-----------------------------------------
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
                                <h4 class="title">Danh sách người dùng</h4>
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
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="fullname" class="form-control border-input" placeholder="Họ tên" value="">
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
                                    	<th>Username</th>
                                    	<th>Tên đầy đủ</th>
                                    	<th>Ảnh đại diện</th>
                                    	<th>Chức năng</th>
                                    </thead>
                                    <tbody>
									<?php
										$query = "SELECT * FROM user ORDER BY id DESC LIMIT {$offset}, {$row_count}";
										$result = $mysqli->query($query);
										while($row = mysqli_fetch_assoc($result)){
											$id = $row['id'];
											$username = $row['username'];
											$fullname = $row['fullname'];
											$picture = $row['picture'];
											$active = $row['active'];
											$urlEdit = "edit.php?id={$id}&username={$username}&fullname={$fullname}&active={$active}";
											$urlDelete = "delete.php?id={$id}";
									?>
                                        <tr>
                                        	<td><?php echo $id; ?></td>
                                        	<td><?php echo $username; ?></td>
                                        	<td><?php echo $fullname; ?></td>
                                        	<td><img src="/files/userIMG/<?php echo $picture; ?>" alt="" width="100px" /></td>
											<?php
												if($_SESSION['userinfo']['active'] == '1'){
											?>
                                        	<td>
                                        		<a href="<?php echo $urlEdit; ?>" class="btn btn-primary square-btn-adjust"> Sửa</a>
                                        		<a onclick="checkDelete(<?php echo $id ?>)" class="btn btn-danger square-btn-adjust"> Xóa</a>
                                        	</td>
											<?php
												}else if($row['username'] == $_SESSION['userinfo']['username']){
											?>
											<td>
												<a href="<?php echo $urlEdit; ?>" class="btn btn-primary square-btn-adjust"> Sửa</a>
											</td>
											<?php
												}
											?>
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