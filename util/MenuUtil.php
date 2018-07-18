<?php
require_once $_SERVER['DOCUMENT_ROOT']."/util/DbConnectionUtil.php";
require_once $_SERVER['DOCUMENT_ROOT'].'/util/Utf8ToLatinUtil.php';
$query = "SELECT * FROM cat_list WHERE parent_id = 0 ORDER BY id ASC";
$results = $mysqli->query($query);
echo '<ul class="nav navbar-nav main-nav">';
if (mysqli_num_rows($results) > 0) {
	$i = 1;
	while ($row = mysqli_fetch_assoc($results)) {
		$query1 = "SELECT * FROM cat_list WHERE parent_id = ".$row['id'];
		$submenu = $mysqli->query($query1);
		if(mysqli_num_rows($submenu) == 0){
			echo '<li id="'.utf8ToLatin($row['name']).'" class="'.$i.' dropdown m-menu-fw"><a href="/tin-tuc/'.utf8ToLatin($row['name']).'-'.$row['id'].'.html" class="dropdown-toggle">' . $row['name'] . '<span><i></i></span></a>';
			getSubmenu($row['id']);
			echo '</li>';
		}else{
			echo '<li id="'.utf8ToLatin($row['name']).'" class="'.$i.' dropdown m-menu-fw"><a href="/tin-tuc/'.utf8ToLatin($row['name']).'-'.$row['id'].'.html" class="dropdown-toggle">' . $row['name'] . '<span><i class="fa fa-angle-down"></i></span></a>';
			getSubmenu($row['id']);
			echo '</li>';
		}
		$i++;
	}
}
echo '</ul>';
function getSubmenu($parent_id) {
	global $mysqli;
	$query1 = "SELECT * FROM cat_list WHERE parent_id = ".$parent_id;
	$submenu = $mysqli->query($query1);
	if (mysqli_num_rows($submenu) > 0) {
		echo '<ul class="dropdown-menu">';
		while ( $obj = mysqli_fetch_assoc($submenu) ) {
			echo '<li id="'.utf8ToLatin($obj['name']).'"><a href="/tin-tuc/'.utf8ToLatin($obj['name']).'-'.$obj['id'].'.html">' . $obj['name'] . '</a>';
			getSubmenu($obj['id']);
			echo '</li>';
		}
		echo '</ul>';
	}
}
?>