<?php
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
if( !isset($_SESSION['mid']) ) {
	lib_delay_jump(3, '请先登录，再进行管理');
}
$id = intval($_GET['id']);
$checked_by = $_SESSION['mid'];

require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
// 查询该id是否存在
$sql_confirm_id = 'select 1 as is_exist from Messages where message_id = :id';
$sth_confirm_id = $dbh->prepare($sql_confirm_id);
$sth_confirm_id->bindParam(':id', $id, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_confirm_id->execute(), $sth_confirm_id, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
$is_exist = $sth_confirm_id->fetch(PDO::FETCH_ASSOC);
if (!$is_exist['is_exist']) {
// 不存在该条留言
	$msg = '对不起，您所管理的留言不存在！';
	$url = '../control_message.php'; $name = '管理留言页面';
	lib_delay_jump(3, $msg, $url, $name);
}
// 写数据库
$sql_update_message = 'update Messages set is_checked = !is_checked, checked_by = :mid where message_id = :id limit 1';
$sth_update_message = $dbh->prepare($sql_update_message);
$sth_update_message->bindParam(':id', $id, PDO::PARAM_INT);
$sth_update_message->bindParam(':mid', $checked_by, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_update_message->execute(), $sth_update_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
//header( "Location:{$_SERVER['HTTP_REFERER']}" );
$msg = '留言状态更改成功'; $url = '../control_message.php'; $name = '管理留言页面';
lib_delay_jump(2, $msg, $url, $name);
exit();
?>
