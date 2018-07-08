<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
	if(isset($_GET['msg'])){
		echo '<script>alert("'.$_GET['msg'].'")</script>';
	}
?>
<?php
	function reloadName(){
		if(isset($_POST['name'])){
			echo $_POST['name'];
		}
	}
	
	function reloadMoTa(){
		if(isset($_POST['mota'])){
			echo $_POST['mota'];
		}
	}
	
	function reloadChiTiet(){
		if(isset($_POST['chitiet'])){
			echo $_POST['chitiet'];
		}
	}
?>
<?php
	$query = "SELECT * FROM cat_list";
	$result = $mysqli->query($query);
	$categories = array();
	while ($row = mysqli_fetch_assoc($result)){
		$categories[] = $row;
	}
	function showCategories($categories, $parent_id = 0, $char = '')
	{
		foreach ($categories as $key => $item)
		{
			// Nếu là chuyên mục con thì hiển thị
			if ($item['parent_id'] == $parent_id)
			{
				if($item['id'] != $_GET['id']){
					echo '<option value="'.$item['id'].'">';
						echo $char. $item['name'];
					echo '</option>';
				}
				// Xóa chuyên mục đã lặp
				//unset($categories[$key]);
				 
				// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
			showCategories($categories, $item['id'], $char.'☺☺☺');
			}
		}
	}
	//--------------------------------------
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Thêm tin tức</h4>
                            </div>
                            <div class="content">
							<?php
							if(isset($_POST['submit'])){
								$name = $_POST['name'];
								$cat = $_POST['catlist'];
								$mota = $_POST['mota'];
								$chitiet = $_POST['chitiet'];
								$nguoitao = $_SESSION['userinfo']['id'];
								if(isset($_FILES['hinhanh']['name']) != "") {
									$namef = $_FILES['hinhanh']['name'];
									$tmp_name = $_FILES['hinhanh']['tmp_name'];
									$myArray = explode('.', $namef);
									$duoiFile = end($myArray);
									$tenFile = 'HinhAnh-' . time(). '.' . $duoiFile;
									$path_root = $_SERVER['DOCUMENT_ROOT'];
									$path_upload = $path_root . "/files/newsIMG/" . $tenFile;
									//move_uploaded_file($tmp_name, $path_upload);
								}
								
								$queryValidateName = "SELECT name FROM news WHERE name = '{$name}'";
								$resultValidateName = $mysqli->query($queryValidateName);
								if(mysqli_num_rows($resultValidateName)>0){
									echo '<script>alert("Tên truyện đã tồn tại")</script>';
								}
								else if($_POST['name'] == ''){
									echo '<script>alert("Không để trống tên truyện")</script>';
								}else if($_POST['catlist'] == 0){
									echo '<script>alert("Xin chọn danh mục")</script>';
								}
								else if(empty($_FILES['hinhanh']['name'])){
									echo '<script>alert("Hãy chọn ảnh")</script>';
								}
								else if($_POST['mota'] == ''){
									echo '<script>alert("Không để trống mô tả")</script>';
								}
								else if($_POST['chitiet'] == ''){
									echo '<script>alert("Không để trống nội dung truyện")</script>';
								}
								else{
									$query = "INSERT INTO news(name, preview, detail, picture, cat_id, created_by) VALUES('{$name}','{$mota}','{$chitiet}','{$tenFile}',{$cat},'{$nguoitao}')";
									$result = $mysqli->query($query);
									if($result){
										move_uploaded_file($tmp_name, $path_upload);
										header('location: index.php?msg=Thêm thành công!');
									}else{
										header('location: index.php?msg=Có lỗi trong quá trình xữ lý!');
									}
								}
								
							}
							?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên tin tức</label>
                                                <input type="text" name="name" class="form-control border-input" placeholder="Tên tin tức" value="<?php echo reloadName(); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Danh mục tin tức</label>
                                                <select name="catlist" class="form-control border-input">
                                                	<option value="0">---Chọn danh mục tin tức---</option>
                                                	<?php
														showCategories($categories);
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
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea name="mota" rows="4" class="form-control border-input" placeholder="Mô tả tóm tắt về bạn của bạn"><?php echo reloadName(); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Chi tiết</label>
                                                <textarea name="chitiet" rows="6" class="form-control border-input" placeholder="Mô tả chi tiết về bạn của bạn"><?php echo reloadName(); ?></textarea>
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
<script>
	CKEDITOR.replace('chitiet',
		{
			filebrowserBrowseUrl : 'http://shareit.vne/library/ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl : 'http://shareit.vne/library/ckfinder/ckfinder.html?type=Images',
			filebrowserFlashBrowseUrl : 'http://shareit.vne/library/ckfinder/ckfinder.html?type=Flash',
			filebrowserUploadUrl : 'http://shareit.vne/library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
			filebrowserImageUploadUrl : 'http://shareit.vne/library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserFlashUploadUrl : 'http://shareit.vne/library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
		});
</script>
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
