<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
	$id = $_GET['id'];
	if(isset($_GET['msg'])){
		echo '<script>alert("'.$_GET['msg'].'")</script>';
	}
	$user = $_SESSION['userinfo'];
	if($user['active'] == 2 && $user['id'] != $id){
		header('location: /admin/');
	}
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Sửa thông tin</h4>
                            </div>
                            <div class="content">
							<?php
								
								$username = $_GET['username'];
								$fullname = $_GET['fullname'];
								$active = $_GET['active'];
								$email = $_GET['email'];
								$gender = $_GET['gender'];
								$queryGet = "SELECT * FROM user WHERE id = {$id}";
								$resultGet = $mysqli->query($queryGet);
								$rowGet = mysqli_fetch_assoc($resultGet);
								$picture = $rowGet['picture'];
								
								$dupesql1 = "SELECT * FROM user WHERE email = '{$email}' AND email<>(SELECT email FROM user WHERE id = {$id})";
								$duperaw1 = $mysqli->query($dupesql1);
								if(mysqli_num_rows($duperaw1) > 0){
									echo '<script>alert("Email đã được sử dụng")</script>';
								}
								
								if(empty($id) || empty($username) || empty($fullname) || empty($active) || empty($email) || empty($gender)){
									header('location: index.php');
								}
								if(isset($_POST['submit'])){
									$username = $_POST['username'];
									$password = $_POST['password'];
									$fullname = $_POST['fullname'];
									$active = $_POST['active'];
									$gender = $_POST['gender'];
									$email = $_POST['email'];
									if(isset($_FILES['hinhanh']['name'])) {
									$namef = $_FILES['hinhanh']['name'];
									$tmp_name = $_FILES['hinhanh']['tmp_name'];
									$myArray = explode('.', $namef);
									$duoiFile = end($myArray);
									$tenFile = 'HinhAnh-' . time(). '.' . $duoiFile;
									$path_root = $_SERVER['DOCUMENT_ROOT'];
									$path_upload = $path_root . "/files/userIMG/" . $tenFile;
									move_uploaded_file($tmp_name, $path_upload);
								}
								if(empty($_POST['fullname'])){
									echo "<script>alert('Không được để trống fullname')</script>";
								}if(empty($_POST['email'])){
									echo "<script>alert('Không được để trống email')</script>";
								}else{
									if($_FILES['hinhanh']['name'] == ''){
										$queryDelete = "SELECT * FROM user WHERE id = {$id}";
										$resultDelete = $mysqli->query($queryDelete);
										$rowDelete = mysqli_fetch_assoc($resultDelete);

										$query = "UPDATE user SET active = '{$active}', gender = '{$gender}', email = '{$email}', fullname = '{$fullname}' WHERE id = ".$id;//lệnh update
										$resutl = $mysqli->query($query);
										if($resutl){
											header('location: index.php?msg=Cập nhật thông tin người dùng thành công!');
											die();
										}
										header('location: index.php?msg=Cập nhật thông tin người dùng thất bại!');
										die();
									}else{
										$password = $_POST['password'];
										$queryDelete = "SELECT * FROM user WHERE id = {$id}";
										$resultDelete = $mysqli->query($queryDelete);
										$rowDelete = mysqli_fetch_assoc($resultDelete);
										unlink($_SERVER['DOCUMENT_ROOT']."/files/userIMG/" . $rowDelete['picture']);

										$query = "UPDATE user SET active = '{$active}', gender = '{$gender}', email = '{$email}', fullname = '{$fullname}', picture = '{$tenFile}' WHERE id = ".$id;//lệnh update
										$resutl = $mysqli->query($query);
										if($resutl){
											header('location: index.php?msg=Cập nhật thông tin người dùng thành công!');
											die();
										}
										header('location: index.php?msg=Cập nhật thông tin người dùng thất bại!');
										die();
									}
								}
							}
							?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                       
										 <div class="col-md-3">
                                            <div class="form-group">
                                                <label>username</label>
                                                <input type="text" name="username" class="form-control border-input" readonly value="<?php echo $username; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>ID</label>
                                                <input type="text" name="id" class="form-control border-input" disabled value="<?php echo $id; ?>">
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="form-group">
                                                <img src="/files/userIMG/<?php echo $picture; ?>" width="120px" alt="" />
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Họ tên</label>
												<input type="text" name="fullname" class="form-control border-input" placeholder="Họ tên" value="<?php echo $fullname; ?>">
											</div>
										</div>
										<div class="col-md-3">
                                            <div class="form-group">
                                                <label>giới tính</label>
                                                <select name="gender" class="form-control border-input">
													<?php
														if($gender == 2){
													?>
															<option selected="selected" value="2">Nữ</option>
															<option value="1">Nam</option>
													<?php
														}else{
													?>
															<option value="2">Nữ</option>
															<option selected="selected" value="1">Nam</option>
													<?php
														}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Email</label>
												<input type="text" name="email" class="form-control border-input" placeholder="Họ tên" value="<?php echo $email; ?>">
											</div>
										</div>
										<div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loại quyền</label>
                                                <select name="active" class="form-control border-input">
													<?php
														if($active == 2){
													?>
															<option selected="selected" value="2">mod</option>
															<option value="1">admin</option>
													<?php
														}else{
													?>
															<option value="2">mod</option>
															<option selected="selected" value="1">admin</option>
													<?php
														}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>	
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hình ảnh</label>
                                                <input type="file" name="hinhanh" class="form-control" placeholder="Chọn ảnh" id="profile-img"/></br>
												<img src="" width="100px"  id="profile-img-tag"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input name="submit" type="submit" class="btn btn-info btn-fill btn-wd" value="Thực hiện" />
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function(){
        readURL(this);
    });
</script>
<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/footer.php';
?>