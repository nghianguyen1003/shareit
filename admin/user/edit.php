<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="/template/admin/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/template/admin/assets/img/favicon.png">
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


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/template/admin/assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/template/admin/assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
	<div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://vinaenter.edu.vn" class="simple-text">AdminCP</a>
            </div>

            <ul class="nav">
            	<li>
                    <a href="index.php">
                        <i class="ti-map"></i>
                        <p>Danh mục bạn bè</p>
                    </a>
                </li>
            	 <li class="active">
                    <a href="index.php">
                        <i class="ti-view-list-alt"></i>
                        <p>Danh sách bạn bè</p>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="ti-panel"></i>
                        <p>Danh sách video</p>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="ti-user"></i>
                        <p>Danh sách người dùng</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

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
                            <a href="http://vinenter.edu.vn">
								<i class="ti-settings"></i>
								<p>Settings</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Sửa thông tin</h4>
                            </div>
                            <div class="content">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>ID</label>
                                                <input type="text" name="id" class="form-control border-input" disabled value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Họ tên</label>
                                                <input type="text" name="fullname" class="form-control border-input" placeholder="Họ tên" value="Trần Nguyễn Gia Huy">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Ngày tạo</label>
                                                <input type="text" name="date" value="20/12/2016" class="form-control border-input" placeholder="Ngày tạo">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="read">Lượt đọc</label>
                                                <input type="text" name="read" value="20" class="form-control border-input" placeholder="Lượt đọc">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Danh mục bạn bè</label>
                                                <select name="friend_list" class="form-control border-input">
                                                	<option value="">Bạn quen thời phổ thông</option>
                                                	<option>Bạn quen thời đại học</option>
                                                	<option>Bạn tâm giao</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hình ảnh</label>
                                                <input type="file" name="picture" class="form-control" placeholder="Chọn ảnh" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ảnh cũ</label>
                                                <img src="/template/admin/assets/img/tim_80x80.png" width="120px" alt="" /> Xóa <input type="checkbox" name="delete_picture" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea rows="4" class="form-control border-input" placeholder="Mô tả tóm tắt về bạn của bạn"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Chi tiết</label>
                                                <textarea rows="6" class="form-control border-input" placeholder="Mô tả chi tiết về bạn của bạn"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <input type="submit" class="btn btn-info btn-fill btn-wd" value="Thực hiện" />
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="/">Dự án được phát triển bởi: Trần Nguyễn Gia Huy - Khóa ABC</a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://vinaenter.edu.vn">VinaEnter Edu</a>
                </div>
            </div>
        </footer>


    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="/template/admin/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="/template/admin/assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="/template/admin/assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="/template/admin/assets/js/demo.js"></script>


</html>
