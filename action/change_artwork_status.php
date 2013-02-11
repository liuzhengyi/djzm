<?php
/* /action/change_artwork_status.php by gipsaliu(at)gmail(dot)com on 2013-02-05
 * 
 * 本程序负责更改艺术品的两个状态属性：是否出售 和 是否隐藏
 * 本文件通过url接收两个参数：
 * type = 'sale' | 'hide'
 * id = [0-9]+
 */
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
if( !isset($_SESSION['mid']) ) {
	lib_delay_jump(3, '请先登录，再进行管理');
}
$id = intval($_GET['id']);
$checked_by = $_SESSION['mid'];
if( !isset($_GET['type']) || ('sale' != $_GET['type'] && 'hide' != $_GET['type']) ) {
	$msg = '对不起，请不要手工设定参数';
	$url = '../control_artwork.php';
	$name = '艺术品管理页面';
	lib_delay_jump( 3, $msg, $url, $name );
}
// 参数 type 没有问题
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
	$msg = '对不起，您所管理的艺术品不存在';
	$url = '../control_artwork.php';
	$name = '艺术品管理页面';
	lib_delay_jump( 3, $msg, $url, $name );
}
// 参数 id 没有问题

// 写数据库
$change = ('sale' == $_GET['type']) ? 'on_sale' : 'is_hidden' ;
$sql_update_artwork = 'update Artworks set '.$change.' = ! '.$change.' where artwork_id = :id limit 1';
$sth_update_artwork = $dbh->prepare($sql_update_artwork);
$sth_update_artwork->bindParam(':id', $id, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_update_artwork->execute(), $sth_update_artwork, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
//header( "Location:{$_SERVER['HTTP_REFERER']}" );
$msg = '艺术品状态更改成功';
$url = '../control_artwork.php';
$name = '艺术品管理页面';
lib_delay_jump(3, $msg, $url, $name);
?>
