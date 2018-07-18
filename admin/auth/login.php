<!DOCTYPE html>
<?php session_start();?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/sendmail/class.smtp.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/sendmail/class.phpmailer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/sendmail/functions.php'; ?>
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
				if(isset($_SESSION['userinfo'])) {
					header("location: /admin/");
				}
				if(isset($_POST['submit'])){
					$username = $_POST['username'];
					$password = $_POST['password'];
					$query = "SELECT * FROM user WHERE username = '{$username}' AND password = '{$password}'";
					$result = $mysqli->query($query);
					$arLogin = mysqli_fetch_assoc($result);
					if($arLogin){
						$_SESSION['userinfo'] = $arLogin;
						header('location:/admin/');
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
						<button type="submit" class="login100-form-btn" name="submit">Đăng nhập</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1" data-toggle="modal" data-target="#myModal">
							Quên mật khẩu?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php

		function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
		}

		if(isset($_POST['forgot'])){
			$mail = $_POST['email'];
			$newPass = generateRandomString();
			$queryMail = "SELECT * FROM user WHERE email = '{$mail}'";
			$resultMail = $mysqli->query($queryMail);
			if($rowMail = mysqli_fetch_assoc($resultMail)){
				$hoTen = $rowMail['fullname'];
			}
			if(mysqli_num_rows($resultMail) == 0){
				echo '<script>alert("Email không tồn tại")</script>';
			}else{
				$title = "Lấy lại mật khẩu từ Shareit.vne-Admin";
				$content = "Mật khẩu mới của bạn là: <strong>{$newPass}</strong>";
				$nTo = $hoTen;
				$mTo = $rowMail['email'];
				$diachicc = 'shareit@gmail.com';
				//test gui mail
				$mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
				if($mail==1){
					$queryFP = "UPDATE user SET user.password = '{$newPass}' WHERE email = '{$mTo}'";
					$resultFP = $mysqli->query($queryFP);
					echo '<script>alert("mail của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả.")</script>';
				}else{
					echo '<script>alert("Có lỗi!")</script>';
				} 
			}
		}
	?>
	<form method="POST">
		<div id="myModal" class="modal fade" role="dialog" style="background-image: url('/template/admin/assets/img/img-01.jpg');">
		  <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<h4 style="margin-left: 132px;" class="modal-title">Quên mật khẩu</h4>
			  </div>
			  <div class="modal-body">
				<div class="wrap-input100 m-b-10">
					<input required class="input100" type="email" name="email" placeholder="Email">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-envelope"></i>
					</span>
				</div>
			  </div>
			  <div class="modal-body">
				<div class="container-login100-form-btn p-t-10">
					<button type="submit" class="login100-form-btn" name="forgot">Gửi<button>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
	</form>
	
	

	
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