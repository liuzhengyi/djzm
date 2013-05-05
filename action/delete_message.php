<?php
/* action/delete_message.php?mid=xxx
 * delete specified message
 *
 * 2013-05-05
 * gipsaliu(at)gmail(dot)com
 */
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

if(empty($_GET['mid']) || empty($_SESSION['mname'])) {
// 直接访问此页面，跳转至首页 // 只有管理员可以访问此页面
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
$mid = intval($_GET['mid']);

if(CFG_DEBUG) {
	if(empty($content)) {
		echo 'debug : empty($content)';
	} else if (empty($name)) {
		echo 'debug : empty($name)';
	} else if (empty($is_artist)) {
		echo 'debug : empty($is_artist)';
	} else {}
}

	// 查询并写数据库
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_select_message = 'select message_id from Messages where message_id = :mid ';
	$sth_select_message = $dbh->prepare($sql_select_message);
	$sth_select_message->bindParam(':mid', $mid, PDO::PARAM_INT);
	lib_pdo_if_fail( $sth_select_message->execute(), $sth_select_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	$count_res = $sth_select_message->fetch(PDO::FETCH_ASSOC);
	if(empty($count_res)) {
		// no such message.
		//echo '<p>the specified message does not exists.</p>';
		$msg = '指定的message不存在！';
	} else {
	// delete message $mid
		$sql_delete_message = 'delete from Messages where message_id = :mid limit 1';
		$sth_delete_message = $dbh->prepare($sql_delete_message);
		$sth_delete_message->bindParam(':mid', $mid, PDO::PARAM_INT);
		lib_pdo_if_fail( $sth_delete_message->execute(), $sth_delete_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		//echo '<p>the specified message has been deleted.</p>';
		$msg = 'message已经成功删除！';
	}
	//echo '<a href="../message.php">click here to return.</a>';
	$dbh = null;
	lib_delay_jump(3, $msg, '../control_message.php', 'message列表');
?>
