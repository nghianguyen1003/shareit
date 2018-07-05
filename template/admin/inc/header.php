<?php
	ob_start();
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/CheckUser.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="/template/admin/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/template/admin/assets/img/favicon.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>AdminCP - VinaEnter</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="/template/admin/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="/template/admin/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="/template/admin/assets/css/paper-dashboard.css" rel="stylesheet"/>
	 <!--   Core JS Files   -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script type="text/javascript" src="/template/admin/assets/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="/template/admin/assets/js/jquery.validate.min.js"></script>
	<script src="/template/admin/assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="/template/admin/assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="/template/admin/assets/js/demo.js"></script>
	<script type="text/javascript" src="/library/ckeditor/ckeditor.js"></script>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/template/admin/assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/template/admin/assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
	<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/leftbar.php';
		$id = $_SESSION['userinfo']['id'];
		$username = $_SESSION['userinfo']['username'];
		$fullname = $_SESSION['userinfo']['fullname'];
		$active = $_SESSION['userinfo']['active'];
	?>
    <div class="main-panel">
		<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="/admin">Trang quản lý</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                            <a href="<?php echo "/admin/user/edit.php?id={$id}&username={$username}&fullname={$fullname}&active={$active}"?>">
								<i class="ti-settings"></i>
								Xin chào, <b><?php echo $_SESSION['userinfo']['username']; ?></b> &nbsp; <a href="/admin/auth/logout.php" class="btn btn-danger square-btn-adjust">Đăng xuất</a>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>