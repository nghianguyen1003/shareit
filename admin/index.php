<?php require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php'; ?>
<?php
	$queryQLDM = "SELECT\n"
			. "  (SELECT COUNT(*) FROM cat_list) as DDM, \n"
			. "  (SELECT COUNT(*) FROM news) as DT,\n"
			. "  (SELECT COUNT(*) FROM user) as DU,\n"
			//. "  (SELECT COUNT(*) FROM slides) as DS, \n"
			. "  (SELECT COUNT(*) FROM comment) as DT";
			$resultQLDM = $mysqli->query($queryQLDM);
			if($rowDDM = mysqli_fetch_assoc($resultQLDM)){
				
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="panel panel-back noti-box">
									<span class="icon-box bg-color-green set-icon">
										<i class="fas fa-th-list"></i>
									</span>
									<div class="text-box">
										<p class="main-text"><a href="/admin/cat/" title="">Quản lý danh mục</a></p>
										<p>Có <?php echo $rowDDM['DDM']; ?> danh mục</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="panel panel-back noti-box">
									<span class="icon-box bg-color-blue set-icon">
										<i class="fas fa-newspaper"></i>
									</span>
									<div class="text-box">
										<p class="main-text"><a href="/admin/news/" title="">Quản lý tin tức</a></p>
										<p>Có <?php echo $rowDDM['DT']; ?> tin tức</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="panel panel-back noti-box">
									<span class="icon-box bg-color-red set-icon">
										<i class="fas fa-users"></i>
									</span>
									<div class="text-box">
										<p class="main-text"><a href="/admin/user/" title="">Quản lý người dùng</a></p>
										<p>Có <?php echo $rowDDM['DU']; ?> người dùng</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="panel panel-back noti-box">
									<span class="icon-box bg-color-yellow set-icon">
										<i class="fas fa-comments"></i>
									</span>
									<div class="text-box">
										<p class="main-text"><a href="/admin/comment/" title="">Quản lý bình luận</a></p>
										<p>Có <?php echo $rowDDM['DT']; ?> bình luận</p>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
			}
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/footer.php';
?>