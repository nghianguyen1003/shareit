<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
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
										$query = "SELECT * FROM user ORDER BY id DESC";
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
                                        		<a href="<?php echo $urlDelete; ?>" class="btn btn-danger square-btn-adjust"> Xóa</a>
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