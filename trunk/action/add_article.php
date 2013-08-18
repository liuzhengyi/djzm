<?php
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');
require($cfg_webRoot.$cfg_lib.'resize_image_djzm.php');

if((empty($_POST['submit'])&&empty($_POST['modify'])) || empty($_SESSION['mname'])) {
// 需要管理员权限访问此页面，否则跳转至首页
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
if(!empty($_POST['modify']) && empty($_GET['aid'])){
	lib_delay_jump(3, '对不起，参数不全或有误');
}
if(isset($_GET['aid'])) { $aid = $_GET['aid'];}
// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
$name = trim($_POST['article_name']);
//$content = trim($_POST['article_content']);
$content = ($_POST['article_content']);
$source = trim($_POST['article_source']);
$author = trim($_POST['article_author']);
if(!empty($_FILES['article_image'])) {
	$image = $_FILES['article_image'];
} else {
	$image = NULL;
}
$is_artist = ($_POST['is_artist'] == 0) ? '0' : '1';
$added_by = $_SESSION['mid'];
$no_comment = $_POST['allow_comment'] == '0' ? '1' : '0';
$is_hidden = $_POST['allow_comment'] == '0' ? '0' : '1';

if(CFG_DEBUG) {
if(empty($content)) {
	echo 'empty($content)';
} else if (empty($name)) {
	echo 'empty($name)';
} else if (!isset($is_artist)) {
	echo 'unset($is_artist)';
} else {}
}

// 检测表单数据的有效性
if( empty($name) || empty($content) || !isset($is_artist)
	|| (!empty($image['tmp_name']) && !is_uploaded_file($image['tmp_name']) )
) {
	// 必需数据不全
	header("Location:../control_article.php?error=incomplete");
	exit();
} else if( false ){	 // 检测数据范围，暂时留空 !!
	// 某些数据超出预期范围
	header("Location:../control_article.php?error=outrange");
	exit();
} else {
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	// 检测通过，将上传文件移动到指定位置
	if(isset($image['tmp_name']) && is_uploaded_file($image['tmp_name'])) {
		$upload_file = $cfg_upload_img_ar_dir.$image['name'];
		if(!move_uploaded_file($image['tmp_name'], $upload_file)) {
		// 移动文件失败，可能是客户端在进行攻击
			header("Location:../control_article.php?error=handleerror");	// 处理上传文件失败
			exit();
		}
		$src_file = $upload_file;
		$dst_file_la = $cfg_upload_img_ar_dir. 'la_'. $image['name'];
		resizeimage($src_file, $dst_file_la, 600, 450);
		$dst_file_sm = $cfg_upload_img_ar_dir. 'sm_'. $image['name'];
		resizeimage($src_file, $dst_file_sm, 200, 150);
		$la_picture = str_replace($cfg_webRoot, './', $dst_file_la);
		$sm_picture = str_replace($cfg_webRoot, './', $dst_file_sm);
	}

	// 取旧的图片
	if ( isset($aid) ) {
		$sql_query_pic	= 'select la_picture, sm_picture from Articles where article_id = "'. $aid. '" limit 1';
		$sth		= $dbh->query($sql_query_pic);
		$row		= $sth->fetch(PDO::FETCH_ASSOC);
		if ( isset($row) ) {
			$la_picture_old	= $row['$la_picture']; 
			$sm_picture_old	= $row['$sm_picture'];
		}
	}

	if ( empty($la_picture) && isset($la_picture_old) ) {
		$la_picture = $la_picture_old; 
		$sm_picture = $sm_picture_old; 
	}
	// 写数据库
	if(isset($_POST['modify']) && isset($aid)) {
		$sql_insert_article = 'update Articles set article_name=:name, content=:content,
			source=:source, author=:author, la_picture=:la_picture, sm_picture=:sm_picture, is_artist=:is_artist, added_by=:added_by, pub_date=now(), no_comment=:no_comment, is_hidden=:is_hidden where article_id='.$aid.' limit 1';
	} else {
		$sql_insert_article = 'insert into Articles values ( NULL, :name, :content,
			:source, :author, :la_picture, :sm_picture, :is_artist, :added_by, now(), :no_comment, :is_hidden)';
	}	
	$sth_insert_article = $dbh->prepare($sql_insert_article);
	if(isset($aid)) {
//		$sth_insert_article->bindParam(':aid', $aid, PDO::PARAM_INT);
	}
	$sth_insert_article->bindParam(':name', $name, PDO::PARAM_STR, 90);
	$sth_insert_article->bindParam(':content', $content, PDO::PARAM_STR, 2000);
	$sth_insert_article->bindParam(':source', $source, PDO::PARAM_STR, 90);
	$sth_insert_article->bindParam(':author', $author, PDO::PARAM_STR, 600);
	$sth_insert_article->bindParam(':la_picture', $la_picture, PDO::PARAM_STR, 255);
	$sth_insert_article->bindParam(':sm_picture', $sm_picture, PDO::PARAM_STR, 255);
	$sth_insert_article->bindParam(':is_artist', $is_artist, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':added_by', $added_by, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':no_comment', $no_comment, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':is_hidden', $is_hidden, PDO::PARAM_INT);
	lib_pdo_if_fail( $sth_insert_article->execute(), $sth_insert_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	lib_delay_jump(3, '文章添加成功');
}
?>
