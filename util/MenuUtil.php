<?php
require_once $_SERVER['DOCUMENT_ROOT']."/util/DbConnectionUtil.php";
$query = "SELECT * FROM cat_list WHERE parent_id = 0 ORDER BY id ASC";
$results = $mysqli->query($query);
echo '<ul class="nav navbar-nav main-nav">';
if (mysqli_num_rows($results) > 0) {
	while ($row = mysqli_fetch_assoc($results)) {
		echo '<li class="dropdown m-menu-fw"><a href="category.php?id='.$row['id'].'"dropdown-toggle">' . $row['name'] . '<span><i class="fa fa-angle-down"></i></span></a>';
		getSubmenu($row['id']);
		echo '</li>';
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
			echo '<li><a href="category.php?id='.$obj['id'].'">' . $obj['name'] . '</a>';
			getSubmenu($obj['id']);
			echo '</li>';
		}
		echo '</ul>';
	}
}
?>