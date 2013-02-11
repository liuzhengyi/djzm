<?php
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

if(empty($_POST['submit'])) {
// 直接访问此页面，跳转至首页
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
$name_zh = trim($_POST['type_name_zh']);
$name_en = trim($_POST['type_name_en']);
$addition = trim($_POST['type_addition']);
$added_by = $_SESSION['mid'];

if(CFG_DEBUG) {
if(empty($name_zh)) {
	echo 'empty($name_zh)';
} else if (empty($name_en)) {
	echo 'empty($name)';
} else if (empty($addition)) {
	echo 'empty($addition)';
} else {}
}

// 检测表单数据的有效性
if( empty($name_zh) || empty($name_en) ) {
	// 必需数据不全
	header("Location:../control_type.php?error=incomplete");
	exit();
} else if( false ){	 // 检测数据范围，暂时留空 !!
	// 某些数据超出预期范围
	header("Location:../control_type.php?error=outrange");
	exit();
} else {
	// 写数据库
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_insert_type = 'insert into ArtworkTypes values ( NULL, :name_en, :name_zh, :added_by, :addition)';
	$sth_insert_type = $dbh->prepare($sql_insert_type);
	$sth_insert_type->bindParam(':name_en', $name_en, PDO::PARAM_STR, 30);
	$sth_insert_type->bindParam(':name_zh', $name_zh, PDO::PARAM_STR, 30);
	$sth_insert_type->bindParam(':added_by', $added_by, PDO::PARAM_INT);
	$sth_insert_type->bindParam(':addition', $addition, PDO::PARAM_STR, 90);
	lib_pdo_if_fail(	$sth_insert_type->execute(), $sth_insert_type,
				__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
			);	// 如果出错原因是type重名，这个错误应该在插入数据库之前发现并提醒用户 !!
	// 将新分类添写入SESSION中
	$_SESSION['artwork_types'][$name_en] = $name_zh;
	lib_delay_jump(3, '艺术品分类添加成功');
}
?>
