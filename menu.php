<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/util/DbConnectionUtil.php";
	$sql = 'SELECT * FROM cat_list';
	$result = $mysqli->query($sql);
	$categories = array();
	while ($row = mysqli_fetch_assoc($result)){
		$categories[] = $row;
	}
	
// BƯỚC 2: HÀM ĐỆ QUY HIỂN THỊ CATEGORIES

function showCategories($categories, $parent_id = 0)

{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $cate_data = array();
    foreach ($categories as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị

        if ($item['parent_id'] == $parent_id)

        {
            $cate_data[] = $item;
            //unset($categories[$key]);
        }
    }
    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_data)
    {
        echo '<ul>';
        foreach ($cate_data as $key => $item)
        {
            // Hiển thị tiêu đề chuyên mục
            echo '<li>'.$item['name'];
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($categories, $item['id']);
            echo '</li>';
        }
        echo '</ul>';
    }
}
showCategories($categories, $parent_id = 0)
?>