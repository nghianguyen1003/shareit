<!DOCTYPE html>
<?php session_start();?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php'; ?>
<?php ob_start();?>
<html lang="en">
<head>
	<title>Login V12</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/template/admin/assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="/template/admin/assets/css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
	if(isset($_GET['msg'])){
		echo '<script>alert("'.$_GET['msg'].'")</script>';
	}
?>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/template/admin/assets/img/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
			<?php
				if(isset($_POST['submit'])){
					$username = $_POST['username'];
					$password = $_POST['password'];
					$query = "SELECT * FROM user WHERE username = '{$username}' AND password = '{$password}'";
					$result = $mysqli->query($query);
					$arLogin = mysqli_fetch_assoc($result);
					if($arLogin){
						$_SESSION['userinfo'] = $arLogin;
						header('location:/admin/cat/index.php');
					}else{
						header('location:/admin/auth/login.php?msg=Tên đăng nhập hoặc mật khẩu sai!!!');
					}
				}
			?>
				<form class="login100-form validate-form" method="POST">
					<div class="login100-form-avatar">
						<img src="/template/admin/assets/img/avatar-01.jpg" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Nguyễn Trọng Nghĩa
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Tên đăng nhập">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Mật khẩu">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<input type="submit" class="login100-form-btn" name="submit" value="Đăng nhập"/>	
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1">
							Quên mật khẩu?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="/template/admin/assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/template/admin/assets/vendor/bootstrap/js/popper.js"></script>
	<script src="/template/admin/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/template/admin/assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/template/admin/assets/js/main.js"></script>

</body>
</html>
<?php ob_end_flush();?>