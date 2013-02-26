<?php
session_start();
require('../config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');

if(empty($_POST['submit'])) {
// 直接访问此页面，跳转至首页
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
$sess_artwork_types = $_SESSION['artwork_types'];
$name	= trim($_POST['artwork_name']);	// !! 艺术品名称唯一性检查
$type	= trim($_POST['artwork_type']);
$size	= trim($_POST['artwork_size']);
$image	= $_FILES['artwork_image'];
$author	= trim($_POST['artwork_author']);
$period	= trim($_POST['artwork_period']);
$intro	= trim($_POST['artwork_intro']);
$detail	= trim($_POST['artwork_detail']);
$price	= trim($_POST['artwork_price']);
$amount	= trim($_POST['artwork_amount']);
$added_by	= $_SESSION['mid'];
$on_sale	= $_POST['on_sale'] == '1' ? '1' : '0';
$no_comment	= $_POST['allow_comment'] == '0' ? '1' : '0';
$is_hidden	= $_POST['is_hidden'] == '1' ? '1' : '0';

/*
if(empty($image['tmp_name'])) {
	echo 'empty($image[tmp_name])';
} else if (empty($name)) {
	echo 'empty($name)';
} else if (!array_key_exists($type, $sess_artwork_types)) {
	echo '!array_key_exists($type, $session_artwork_types)';
} else if (!is_uploaded_file($image['tmp_name'])) {
	echo '!is_uploaded_file($image[tmp_name])';
} else {
	echo 'nothing wrong.';
}
*/

if(empty($image['tmp_name']) || empty($name)
	|| !array_key_exists($type, $sess_artwork_types)		// $sess_xxx 来自SESSION
	|| !is_uploaded_file($image['tmp_name'])
) {
	header("Location:../control_artwork.php?error=incomplete");			// 必需数据不全
	exit();
} else if( false ){	// 检测数据范围，暂时留空
	header("Location:../control_artwork.php?error=outrange");			// 某些数据超出预期范围
	exit();
} else {
	// 检测通过，将上传文件移动到指定位置
	$upload_file = $cfg_upload_img_aw_dir.$image['name'];
	if(!move_uploaded_file($image['tmp_name'], $upload_file)) {
	// 移动文件失败，可能是客户端在进行攻击		// 判断错误原因 !!
		var_dump( $_FILES['artwork_image']['error']);
		exit();
		header("Location:../add_artwork.php?error=handleerror");	// 处理上传文件失败
		exit();
	}
	// 移动文件成功
	// 写数据库
	// 生成$img_large等变量。
	$path_info = pathinfo($upload_file);
	$extension = '.'.$path_info['extension'];
	$path = $path_info['dirname'];
	$relative_path = substr($path, strlen($cfg_webRoot));
	$basename = basename($path_info['basename'], $extension);
	$img_large = $relative_path.'/'.$cfg_la_dir.$basename.'_large'.$extension;
	$img_middle = $relative_path.'/'.$cfg_mi_dir.$basename.'_middle'.$extension;
	$img_small = $relative_path.'/'.$cfg_sm_dir.$basename.'_small'.$extension;
	// 生成大图，中图和小图	!!
	rename($upload_file, $cfg_webRoot.$img_large);
	copy($cfg_webRoot.$img_large, $cfg_webRoot.$img_middle);
	copy($cfg_webRoot.$img_large, $cfg_webRoot.$img_small);

require($cfg_dbConfFile);
//require($cfg_webRoot.$cfg_lib.'debug.php');
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_insert_artwork = 'insert into Artworks values ( NULL, :name, :type, 
				:size, :img_small, :img_middle, :img_large,
				:author, :period, :intro, :detail, :price,
				:amount, :added_by, :on_sale, :no_comment, :is_hidden)';
	$sth_insert_artwork = $dbh->prepare($sql_insert_artwork);
	$sth_insert_artwork->bindParam(':name', $name, PDO::PARAM_STR, 120);
	$sth_insert_artwork->bindParam(':type', $type, PDO::PARAM_STR, 7);
	$sth_insert_artwork->bindParam(':size', $size, PDO::PARAM_STR, 50);
	$sth_insert_artwork->bindParam(':img_small', $img_small, PDO::PARAM_STR, 150);
	$sth_insert_artwork->bindParam(':img_middle', $img_middle, PDO::PARAM_STR, 150);
	$sth_insert_artwork->bindParam(':img_large', $img_large, PDO::PARAM_STR, 150);
	$sth_insert_artwork->bindParam(':author', $author, PDO::PARAM_STR, 90);
	$sth_insert_artwork->bindParam(':period', $period, PDO::PARAM_STR, 90);
	$sth_insert_artwork->bindParam(':intro', $intro, PDO::PARAM_STR, 90);
	$sth_insert_artwork->bindParam(':detail', $detail, PDO::PARAM_STR, 600);
	$sth_insert_artwork->bindParam(':price', $price, PDO::PARAM_INT);
	$sth_insert_artwork->bindParam(':amount', $amount, PDO::PARAM_INT);
	$sth_insert_artwork->bindParam(':added_by', $added_by, PDO::PARAM_INT);
	$sth_insert_artwork->bindParam(':on_sale', $on_sale, PDO::PARAM_INT);
	$sth_insert_artwork->bindParam(':no_comment', $no_comment, PDO::PARAM_INT);
	$sth_insert_artwork->bindParam(':is_hidden', $is_hidden, PDO::PARAM_INT);
	lib_pdo_if_fail(	$sth_insert_artwork->execute(), $sth_insert_artwork,
				__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
			);	// todo 如果出错原因是图像重名，这个错误应该在插入数据库之前发现并提醒用户 !!
	lib_delay_jump(3, '艺术品添加成功');
	//var_dump($sth_insert_artwork->errorInfo());
	exit();
}
?>
