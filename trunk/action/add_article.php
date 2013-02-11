<?php
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

if(empty($_POST['submit'])) {
// 直接访问此页面，跳转至首页
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
$name = trim($_POST['article_name']);
$content = trim($_POST['article_content']);
$source = trim($_POST['article_source']);
$author = trim($_POST['article_author']);
if(empty($_FILES['article_image'])) {
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
} else if (empty($is_artist)) {
	echo 'empty($is_artist)';
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
	// 检测通过，将上传文件移动到指定位置
	if(isset($image['tmp_name']) && is_uploaded_file($image['tmp_name'])) {
	$upload_file = $cfg_upload_img_ar_dir.$image['name'];
	if(!move_uploaded_file($image['tmp_name'], $upload_file)) {
	// 移动文件失败，可能是客户端在进行攻击
		header("Location:../control_article.php?error=handleerror");	// 处理上传文件失败
		exit();
	}
	}
	// 写数据库
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_insert_article = 'insert into Articles values ( NULL, :name, :content,
				:source, :author, :picture, :is_artist, :added_by, now(), :no_comment, :is_hidden)';
	$sth_insert_article = $dbh->prepare($sql_insert_article);
	$sth_insert_article->bindParam(':name', $name, PDO::PARAM_STR, 90);
	$sth_insert_article->bindParam(':content', $content, PDO::PARAM_STR, 2000);
	$sth_insert_article->bindParam(':source', $source, PDO::PARAM_STR, 90);
	$sth_insert_article->bindParam(':author', $author, PDO::PARAM_STR, 600);
	$sth_insert_article->bindParam(':picture', $picture, PDO::PARAM_STR, 255);
	$sth_insert_article->bindParam(':is_artist', $is_artist, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':added_by', $added_by, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':no_comment', $no_comment, PDO::PARAM_INT);
	$sth_insert_article->bindParam(':is_hidden', $is_hidden, PDO::PARAM_INT);
	lib_pdo_if_fail( $sth_insert_article->execute(), $sth_insert_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	lib_delay_jump(3, '文章添加成功');
}
?>
