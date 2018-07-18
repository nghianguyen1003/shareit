<?php
	$user = $_SESSION['userinfo'];
	if($user['active'] == 2){
		$display = "none";
	}
?>
<script>
    $(document).ready(function() {
        var pathname = window.location.pathname;
        if (pathname == '/admin/comment/' || pathname == '/admin/comment/index.php'){
            $("#comment").addClass("active");
        }else if(pathname == '/admin/news/' || pathname == '/admin/news/insert.php' || pathname == '/admin/news/edit.php' || pathname == '/admin/news/index.php'){
            $("#news").addClass("active");
        }else if(pathname == '/admin/cat/' || pathname == '/admin/cat/index.php' || pathname == '/admin/cat/insert.php' || pathname == '/admin/cat/edit.php'){
            $("#cat").addClass("active");
        }else if(pathname == '/admin/user/' || pathname == '/admin/user/insert.php' || pathname == '/admin/user/edit.php' || pathname == '/admin/user/index.php'){
            $("#user").addClass("active");
        }else if(pathname == '/admin/changepass/'){
            $("#changepass").addClass("active");
        }
    });
</script>
<div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://vinaenter.edu.vn" class="simple-text">AdminCP</a>
            </div>
            <ul class="nav">
            	<li id="cat" style="display:<?php echo $display; ?>">
                    <a href="/admin/cat/">
                        <i class="ti-map"></i>
                        <p>Danh mục tin tức</p>
                    </a>
                </li>
            	 <li id="news">
                    <a href="/admin/news/">
                        <i class="ti-view-list-alt"></i>
                        <p>Danh sách tin tức</p>
                    </a>
                </li>
                <li id="comment">
                    <a href="/admin/comment/">
                        <i class="ti-panel"></i>
                        <p>Danh sách bình luận</p>
                    </a>
                </li>
                <li id="user" style="display:<?php echo $display; ?>">
                    <a href="/admin/user/">
                        <i class="ti-user"></i>
                        <p>Danh sách người dùng</p>
                    </a>
                </li>
				<li id="changepass">
                    <a href="/admin/changepass/">
                        <i class="ti-panel"></i>
                        <p>Đổi mật khẩu</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>