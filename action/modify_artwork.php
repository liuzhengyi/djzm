<?php
session_start();
/* /action/modify_artwork.php by gipsaliu(at)gmail(dot)com on 2013-02-06
 * 
 * 本程序负责更改艺术品的两个状态属性：是否出售 和 是否隐藏
 * 本文件通过url接收两个参数：
 * type = 'sale' | 'hide'
 * id = [0-9]+
 */
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

// todo 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
if( !isset($_SESSION['mid']) ) {
	lib_delay_jump(3, '请先登录，再进行管理');
}
if( !isset($_POST['id']) || !is_numeric($_POST['id']) ) {
	$msg = '无效id，修改信息失败，请重试！';
	$url = '../control_artwork.php';
	lib_delay_jump( 3, $msg, $url );
}
$id = intval($_POST['id']);
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
// 确定id是否存在
$sql_id_exist = 'select 1 as exist from Artworks where artwork_id = :id limit 1';
$sth_id_exist = $dbh->prepare($sql_id_exist);
$sth_id_exist->bindParam(':id', $id, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_id_exist->execute(), $sth_id_exist, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
$id_exist = $sth_id_exist->fetch(PDO::FETCH_ASSOC);
if( !$id_exist['exist'] ) {
// 不存在该艺术品
	$msg = '对不起，不存在此艺术品，请查证！';
	$url = '../control_artwork.php';
	$name = '艺术品管理页面';
	lib_delay_jump( 3, $msg, $url, $name );
}
// 参数 id 没有问题
// 采集其余POST数据
// todo 此处缺少必需的数据类型及范围检测
$sess_artwork_types = $_SESSION['artwork_types'];
if( isset($_POST['name']) )	$name	= trim($_POST['name']);
if( isset($_POST['size']) )	$size	= trim($_POST['size']);
if( isset($_POST['author']) )	$author	= trim($_POST['author']);
if( isset($_POST['period']) )	$period	= trim($_POST['period']);
if( isset($_POST['intro']) )	$intro	= trim($_POST['intro']);
if( isset($_POST['detail']) )	$detail	= trim($_POST['detail']);
if( isset($_POST['price']) )	$price	= trim($_POST['price']);
if( isset($_POST['amount']) )	$amount	= trim($_POST['amount']);
if( isset($_POST['type']) )	$type	= trim($_POST['type']);
if( isset($_POST['nocomment']) )	$comment= trim($_POST['nocomment']);
if( isset($_POST['sale']) )	$sale	= trim($_POST['sale']);
if( isset($_POST['hide']) )	$hide	= trim($_POST['hide']);

// 写数据库
$sql_update_artwork = 'update Artworks set artwork_name = :name, artwork_type = :type, 
			artwork_size = :size, author = :author, period = :period, intro = :intro, 
			detail = :detail, price = :price, amount = :amount, on_sale = :sale,
			no_comment = :no_comment, is_hidden = :hide where artwork_id = :id limit 1';
$sth_update_artwork = $dbh->prepare($sql_update_artwork);
$sth_update_artwork->bindParam(':id', $id, PDO::PARAM_INT);
$sth_update_artwork->bindParam(':name', $name, PDO::PARAM_STR, 120);
$sth_update_artwork->bindParam(':type', $type, PDO::PARAM_STR, 7);
$sth_update_artwork->bindParam(':size', $size, PDO::PARAM_STR, 50);
$sth_update_artwork->bindParam(':author', $author, PDO::PARAM_STR, 90);
$sth_update_artwork->bindParam(':period', $period, PDO::PARAM_STR, 90);
$sth_update_artwork->bindParam(':intro', $intro, PDO::PARAM_STR, 90);
$sth_update_artwork->bindParam(':detail', $detail, PDO::PARAM_STR, 600);
$sth_update_artwork->bindParam(':price', $price, PDO::PARAM_INT);
$sth_update_artwork->bindParam(':amount', $amount, PDO::PARAM_INT);
$sth_update_artwork->bindParam(':sale', $sale, PDO::PARAM_INT);
$sth_update_artwork->bindParam(':no_comment', $no_comment, PDO::PARAM_INT);
$sth_update_artwork->bindParam(':hide', $hide, PDO::PARAM_INT);
lib_pdo_if_fail(	$sth_update_artwork->execute(), $sth_update_artwork,
			__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
		);	// 如果出错原因是图像重名，这个错误应该在插入数据库之前发现并提醒用户 !!
//header( "Location:{$_SERVER['HTTP_REFERER']}" );
$msg = '艺术品信息更改成功';
$url = '../control_artwork.php';
$name = '艺术品管理页面';
lib_delay_jump(3, $msg, $url, $name);
?>
