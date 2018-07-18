<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
	if(isset($_GET['msg'])){
		echo '<script>alert("'.$_GET['msg'].'")</script>';
	}
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Sửa thông tin</h4>
                            </div>
                            <div class="content">
							<?php
								if(isset($_POST['submit'])){
									$password = $_POST['password'];
									$newpassword = $_POST['newpassword'];
									$enternewpassword = $_POST['enternewpassword'];
									if(empty($password)){
										echo "<script>alert('Nhập mật khẩu cũ')</script>";
									}else if(empty($newpassword)){
										echo "<script>alert('Nhập mật khẩu mới')</script>";
									}else if(empty($enternewpassword)){
										echo "<script>alert('Nhập lại mật khẩu mới')</script>";
									}else{
										$user = $_SESSION['userinfo'];
										$id = $user['id'];
										$passwordSQL = $user['password'];
										if($passwordSQL != $password){
											echo "<script>alert('Sai mật khẩu cũ')</script>";
										}else{
											if($newpassword != $enternewpassword){
												echo "<script>alert('Mật khẩu mới không trùng khớp')</script>";
											}else{
												$query = "UPDATE user SET password = {$newpassword} WHERE id = {$id}";
												$result = $mysqli->query($query);
												if($result){
													header('location: /admin/changepass/index.php?msg=Đổi mật khẩu thành công');
												}
											}
										}
									}
									
								}
							?>
                                <form action="" method="post">
                                    <div class="row">
										<div class="col-md-11">
                                            <div class="form-group">
                                                <label>Mật khẩu cũ</label>
                                                <input type="text" name="password" class="form-control border-input" value="">
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
										<div class="col-md-11">
                                            <div class="form-group">
                                                <label>Mật khẩu mới</label>
                                                <input type="text" name="newpassword" class="form-control border-input" value="">
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
										<div class="col-md-11">
                                            <div class="form-group">
                                                <label>Nhập lại mật khẩu mới</label>
                                                <input type="text" name="enternewpassword" class="form-control border-input" value="">
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
<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/footer.php';
?>