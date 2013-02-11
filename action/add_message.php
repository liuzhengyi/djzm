<?php
session_start();
/* /action/add_message.php
 * by gipsaliu(at)gmail(dot)com on 2013-01-19
 *
 * 本文件完成添加留言功能，
 * 留言可以是用户发表的留言，也可以是管理员对某条用户发表的留言的回复
 * 
 * 本文件通过GET方式接收可选的参数对，键名为type，键值为reply(管理员回复)
 * 当通过GET方式传递键值对(type=reply)时，将向数据库写入一条回复，同时更新被回复留言的son_id
 * 其他情况下，直接向数据库写入一条留言
 */
require('../config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');

if(empty($_POST['submit'])) {
// 直接访问此页面，跳转至首页
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
if( isset($_GET['type']) &&  'reply' == $_GET['type'] ) {
	if( !isset($_SESSION['mname']) ) {
		lib_delay_jump(3, '对不起，请先登录，再进行管理');
	}
	$parent_id = trim($_POST['id']);
	$author = $_SESSION['mname'];
	$contact = $author;
} else {
	// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
	$head = trim($_POST['message_head']);
	$author = trim($_POST['message_author']);	// pub_name
	$contact = trim($_POST['message_contact']);	// pub_email_or_tel
}
$content = trim($_POST['message_content']);
$veri_code = trim($_POST['veri_code']);

if(CFG_DEBUG) {	// 调试信息
if(empty($content)) {
	echo 'empty($content)';
} else if (empty($author)) {
	echo 'empty($author)';
} else if (empty($contact)) {
	echo 'empty($contact)';
} else {}
}

// 检测验证码的有效性
$verify_code = $_SESSION['verifyCode'];
if( empty($veri_code) && ($verify_code !== $veri_code) ) {
	if( isset($_GET['type']) && 'reply' == $_GET['type'] ) {
		$url = $cfg_siteRoot.'control_message.php?error=wrongcode#add_reply';
	} else {
		$url = $cfg_siteRoot.'message.php?error=wrongcode#add_message';
	}
	$name = '发表留言页面';
	$msg = '对不起，验证码错误，请重新填写';
	lib_delay_jump(3, $msg, $url, $name);
}
// 检测表单数据的有效性
if( empty($contact) || empty($content) || empty($author)  ||  (isset($_GET['type']) && 'reply' == $_GET['type'] && empty($parent_id)) ) {
	// 必需数据不全	!! 此处可以使用 lib_delay() 跳转
	if( isset($_GET['type']) && 'reply' == $_GET['type'] ) {
		$url = $cfg_siteRoot.'control_message.php?error=incomplete#add_reply';
	} else {
		$url = $cfg_siteRoot.'message.php?error=incomplete#add_message';
	}
	$name = '发表留言页面';
	$msg = '对不起，您没有将必需数据填写完整';
	lib_delay_jump(3, $msg, $url, $name);
} else if( false ){	 // 检测数据范围，暂时留空 !!
	// 某些数据超出预期范围 !! 同上，可以使用lib_delay() 跳转
	if( isset($_GET['type']) && 'reply' == $_GET['type'] ) {
		$url = $cfg_siteRoot.'control_message.php?error=outrange#add_reply';
	} else {
		$url = $cfg_siteRoot.'message.php?error=outrange#add_message';
	}
	$name = '发表留言页面';
	$msg = '对不起，您填写的数据不正确，请重新填写';
	lib_delay_jump(3, $msg, $url, $name);
} else {
}

	// 检测通过， 写数据库
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	if( isset($_GET['type']) && 'reply' == $_GET['type'] ) {
	// 这是一条管理员回复，将回复以已审核状态写入数据库的同时，还要更新所回复的留言的son_id
		$sql_insert_reply = 'insert into Messages values (NULL, "reply", :content,
					now(), :author, :contact, 0, :parent_id, TRUE, :user_id)';
		$sth_insert_reply = $dbh->prepare($sql_insert_reply);
		$sth_insert_reply->bindParam(':content', $content, PDO::PARAM_STR, 300);
		$sth_insert_reply->bindParam(':author', $author, PDO::PARAM_STR, 30);
		$sth_insert_reply->bindParam(':contact', $contact, PDO::PARAM_STR, 255);
		$sth_insert_reply->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
		$sth_insert_reply->bindParam(':user_id', $_SESSION['mid'], PDO::PARAM_INT);
		lib_pdo_if_fail( $sth_insert_reply->execute(), $sth_insert_reply, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		$son_id = $dbh->lastInsertId();
		$sql_update_message = 'update Messages set son_id = :son_id where message_id = :parent_id limit 1';
		$sth_update_message = $dbh->prepare($sql_update_message);
		$sth_update_message->bindParam(':son_id', $son_id, PDO::PARAM_INT);
		$sth_update_message->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
		lib_pdo_if_fail( $sth_update_message->execute(), $sth_update_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		$to_url = $cfg_siteRoot.'message.php';
		$to_name = '留言列表';
		lib_delay_jump(3, '回复成功', $to_url, $to_name);
	} else {
	// 这是一条用户留言，直接以未审核状态写入数据库即可
		$sql_insert_message = 'insert into Messages values ( NULL, :head, :content,
					now(), :author, :contact, 0, NULL, FALSE, NULL)';
		$sth_insert_message = $dbh->prepare($sql_insert_message);
		$sth_insert_message->bindParam(':head', $head, PDO::PARAM_STR, 60);
		$sth_insert_message->bindParam(':content', $content, PDO::PARAM_STR, 300);
		$sth_insert_message->bindParam(':author', $author, PDO::PARAM_STR, 30);
		$sth_insert_message->bindParam(':contact', $contact, PDO::PARAM_STR, 255);
		lib_pdo_if_fail( $sth_insert_message->execute(), $sth_insert_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		// !! send mail to master
		lib_delay_jump(3, '留言成功，请耐心等待管理员审核');
	}
?>
