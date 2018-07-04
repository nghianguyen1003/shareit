<?php
//khởi tạo đối tượng mysqli
$mysqli = new mysqli("localhost", "root", "", "shareit");

//$mysqli = new mysqli("sql101.byethost32.com", "b32_22310598", "123123", "b32_22310598_story");
//thiết lập font chữ utf8
$mysqli->set_charset("utf8");
//thông báo lỗi nếu kết nối sai
if (mysqli_connect_errno()){
	echo "Lỗi kết nối database: " . mysqli_connect_error();
	exit();
}
?>
