<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
function reloadUsername(){
		if(isset($_POST['username'])){
			echo $_POST['username'];
		}
	}
	
function reloadPassword(){
	if(isset($_POST['password'])){
		echo $_POST['password'];
	}
}

function reloadFullname(){
	if(isset($_POST['fullname'])){
		echo $_POST['fullname'];
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
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Thêm người dùng</h4>
                            </div>
							<?php
							if(isset($_POST['submit'])){
								$username = $_POST['username'];
								$password = md5($_POST['password']);
								$fullname = $_POST['fullname'];
								$active = $_POST['active'];
								if(isset($_FILES['hinhanh']['name']) != "") {
									$namef = $_FILES['hinhanh']['name'];
									$tmp_name = $_FILES['hinhanh']['tmp_name'];
									$myArray = explode('.', $namef);
									$duoiFile = end($myArray);
									$tenFile = 'HinhAnh-' . time(). '.' . $duoiFile;
									$path_root = $_SERVER['DOCUMENT_ROOT'];
									$path_upload = $path_root . "/files/userIMG/" . $tenFile;
									move_uploaded_file($tmp_name, $path_upload);
								}

								$dupesql = "SELECT username FROM user WHERE username = '{$username}'";
								$duperaw = $mysqli->query($dupesql);
								
								if(mysqli_num_rows($duperaw) > 0){
									echo '<script>alert("Username đã tồn tại")</script>';
								}else if($_POST['username'] == ''){
									echo '<script>alert("Không để trống Username")</script>';
								}else if($_POST['password'] == ''){
									echo '<script>alert("Không để trống Password")</script>';
								}else if(empty($_FILES['hinhanh']['name'])){
									echo '<script>alert("Hãy chọn ảnh")</script>';
								}else if($_POST['fullname'] == ''){
									echo '<script>alert("Không để trống Fullname")</script>';
								}else{
									$query = "INSERT INTO user(username,password,picture,fullname,active) VALUES('{$username}','{$password}','{$tenFile}','{$fullname}','{$active}')";
									$result = $mysqli->query($query);
									if($result){
										header('location: index.php?msg=Thêm thành công!');
									}else{
										header('location: index.php?msg=Có lỗi trong quá trình xử lý!');
									}
								}
								
							}
							?>
                            <div class="content">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
										 <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control border-input" value="<?php reloadUsername(); ?>">
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control border-input" value="<?php reloadPassword(); ?>">
                                            </div>
                                        </div>
									</div>
									<div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Họ tên</label>
                                                <input type="text" name="fullname" class="form-control border-input" placeholder="Họ tên" value="<?php reloadFullname(); ?>">
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loại quyền</label>
                                                <select name="active" class="form-control border-input">
                                                	<option value="2">mod</option>
                                                	<option value="1">admin</option>
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
                                        <input type="submit" name ="submit" class="btn btn-info btn-fill btn-wd" value="Thực hiện" />
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