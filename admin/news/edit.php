<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/template/admin/inc/header.php';
?>
<?php
	if(isset($_GET['msg'])){
		echo '<script>alert("'.$_GET['msg'].'")</script>';
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
					echo '<option value="'.$item['id'].'">';
						echo $char. $item['name'];
					echo '</option>';
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
                                <h4 class="title">Sửa thông tin tin tức</h4>
                            </div>
                            <div class="content">
							<?php
								$id = $_GET['id'];
								if(empty($id)){
									header('location: index.php');
								}
								$queryGet = "SELECT * FROM news WHERE id = {$id}";
								$resultGet = $mysqli->query($queryGet);
								$rowGet = mysqli_fetch_assoc($resultGet);
								$name = $rowGet['name'];
								$date_create = date('d-m-Y H:i:s', strtotime($rowGet['date_create']));
								$view = $rowGet['view'];
								$anhcu = $rowGet['picture'];
								$mota = $rowGet['preview'];
								$chitiet = $rowGet['detail'];
								
								if(isset($_POST['submit'])){
									$name = $_POST['name'];
									$cat = $_POST['catlist'];
									$mota = $_POST['mota'];
									$chitiet = $_POST['chitiet'];
									if(isset($_FILES['hinhanh']['name'])) {
										$namef = $_FILES['hinhanh']['name'];
										$tmp_name = $_FILES['hinhanh']['tmp_name'];
										$myArray = explode('.', $namef);
										$duoiFile = end($myArray);
										$tenFile = 'HinhAnh-' . time(). '.' . $duoiFile;
										$path_root = $_SERVER['DOCUMENT_ROOT'];
										$path_upload = $path_root . "/files/newsIMG/" . $tenFile;
										//move_uploaded_file($tmp_name, $path_upload);
									}
									$queryValidateName = "SELECT name FROM news WHERE name = '{$name}' AND name<>(SELECT name FROM news WHERE id = {$id})";
									$resultValidateName = $mysqli->query($queryValidateName);
									if(mysqli_num_rows($resultValidateName)>0){
										echo '<script>alert("Tên tin tức")</script>';
									}
									else if($_POST['name'] == ''){
										echo '<script>alert("Không để trống tên tin tức")</script>';
									}
									else if($_POST['catlist'] == 0){
										echo '<script>alert("Chọn danh mục tin tức")</script>';
									}
									else if($_POST['mota'] == ''){
										echo '<script>alert("Không để trống mô tả")</script>';
									}
									else if($_POST['chitiet'] == ''){
										echo '<script>alert("Không để trống chi tiết")</script>';
									}
									else{
										if($_FILES['hinhanh']['error'] <= 0 && !isset($_POST['delete_picture'])){
											$queryDelete = "SELECT * FROM news WHERE id = {$id}";
											$resultDelete = $mysqli->query($queryDelete);
											$rowDelete = mysqli_fetch_assoc($resultDelete);
											
											$queryUpdate = "UPDATE news SET name = '{$name}', preview = '{$mota}', detail = '{$chitiet}', picture = '{$tenFile}', cat_id = {$cat} WHERE id = {$id}";
											$resultUpdate = $mysqli->query($queryUpdate);
											if($resultUpdate){
												//thực hiện thành công
												move_uploaded_file($tmp_name, $path_upload);
												header("location:index.php?msg=Sửa thành Công !");
											}else {
												header("location:edit.php?msg=Sửa thất bại !");
											}
										}
										else if($_FILES['hinhanh']['error'] <= 0 && isset($_POST['delete_picture'])){
											$queryDelete = "SELECT * FROM news WHERE id = {$id}";
											$resultDelete = $mysqli->query($queryDelete);
											$rowDelete = mysqli_fetch_assoc($resultDelete);
											unlink($_SERVER['DOCUMENT_ROOT']."/files/newsIMG/" . $rowDelete['picture']);
											
											$queryUpdate = "UPDATE news SET name = '{$name}', preview = '{$mota}', detail = '{$chitiet}', picture = '{$tenFile}', cat_id = {$cat} WHERE id = {$id}";
											$resultUpdate = $mysqli->query($queryUpdate);
											if($resultUpdate){
												//thực hiện thành công
												move_uploaded_file($tmp_name, $path_upload);
												header("location:index.php?msg=Sửa thành Công !");
											}else {
												header("location:edit.php?msg=Sửa thất bại !");
											}
										}
										else{
											$queryUpdate = "UPDATE news SET name = '{$name}', preview = '{$mota}', detail = '{$chitiet}', cat_id = {$cat} WHERE id = {$id}";
											$resultUpdate = $mysqli->query($queryUpdate);
											if($resultUpdate){
												//thực hiện thành công
												header("location:index.php?msg=Sửa thành Công !");
											}else {
												header("location:edit.php?msg= Sửa thất bại !");
											}
										}
									}
							
								}
							?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên tin tức</label>
                                                <input type="text" name="name" class="form-control border-input" placeholder="Tên tin tức" value="<?php echo $name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Ngày tạo</label>
                                                <input type="text" name="date" class="form-control border-input" placeholder="Ngày tạo" value="<?php echo $date_create; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="read">Lượt đọc</label>
                                                <input type="text" name="read" value="<?php echo $view; ?>" class="form-control border-input" disabled placeholder="Lượt đọc">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Danh mục bạn bè</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ảnh cũ</label>
                                                <img src="/files/newsIMG/<?php echo $anhcu; ?>" width="120px" alt="" /> Xóa <input type="checkbox" name="delete_picture" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea name="mota" rows="4" class="form-control border-input" placeholder="Mô tả tóm tắt về bạn của bạn"><?php echo $mota; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Chi tiết</label>
                                                <textarea name="chitiet" rows="6" class="form-control border-input" placeholder="Mô tả chi tiết về bạn của bạn"><?php echo $chitiet; ?></textarea>
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
	CKEDITOR.replace('mota');
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

