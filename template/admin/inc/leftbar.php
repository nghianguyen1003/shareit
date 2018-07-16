<?php
	$user = $_SESSION['userinfo'];
	if($user['active'] == 2){
		$display = "none";
	}
?>
<div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://vinaenter.edu.vn" class="simple-text">AdminCP</a>
            </div>
            <ul class="nav">
            	<li class="active" style="display:<?php echo $display; ?>">
                    <a href="/admin/cat/">
                        <i class="ti-map"></i>
                        <p>Danh mục tin tức</p>
                    </a>
                </li>
            	 <li>
                    <a href="/admin/news/">
                        <i class="ti-view-list-alt"></i>
                        <p>Danh sách tin tức</p>
                    </a>
                </li>
                <li>
                    <a href="/admin/comment/">
                        <i class="ti-panel"></i>
                        <p>Danh sách bình luận</p>
                    </a>
                </li>
                <li style="display:<?php echo $display; ?>">
                    <a href="/admin/user/">
                        <i class="ti-user"></i>
                        <p>Danh sách người dùng</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>