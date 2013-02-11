<?php
session_start();
/* /message.php
 * by gipsaliu(at)gmail(dot)com on 2013-01-19
 *
 * 本页面是普通用户查看和发表留言的接口
 * 同时显示留言和留言的回复，如果有的话
 *
 */
require('config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');
require($cfg_webRoot.$cfg_lib.'page.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}

if(empty($_GET['error'])) {
// 无错误信息
	$error_msg = '';
} else {
// 有错误信息
	switch ($_GET['error']) {
		case 'incomplete':
			$error_msg = '对不起，提交失败。请将所有必需项填好，方能提交';
			break;
		case 'outrange':
			$error_msg = '对不起，请正确填写表单';
			break;
		case 'wrongcode':
			$error_msg = '对不起，请正确填写验证码';
			break;
		default:
			$error_msg = '';
			break;
	}
}
// read the database for messages
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
// 获取留言数目 供分页栏使用
$sql_msg_count = 'select count(1) as count from Messages where is_checked = 1 AND parent_id IS NULL';
$sth_msg_count = $dbh->prepare($sql_msg_count);
lib_pdo_if_fail( $sth_msg_count->execute(), $sth_msg_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
$msg_count_res = $sth_msg_count->fetch(PDO::FETCH_ASSOC);
$msg_count = $msg_count_res['count'];
// 分页相关参数
$per_page = $cfg_ms_per_page;
$total_page = ceil($msg_count/$per_page);
// 获取可能存在的通过get方式传递的页码
if( isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
	$page = intval($_GET['page']);
} else { $page = 1; }
$start = ($page-1)*$per_page;
// 检索用户留言
$sql_select_message = 'select * from Messages where is_checked = 1 AND parent_id IS NULL order by pub_time desc limit :start, :per_page';
$sth_select_message = $dbh->prepare($sql_select_message);
$sth_select_message->bindParam(':start', $start, PDO::PARAM_INT);
$sth_select_message->bindParam(':per_page', $per_page, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_select_message->execute(), $sth_select_message,  __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
if ( 0 == $sth_select_message->rowCount() ) {
	$messages = 'no content';	// no data handling !!
} else {
	$messages = $sth_select_message->fetchAll(PDO::FETCH_ASSOC);
	// 检索到用户留言，下面检索这些留言的回复
	$son_ids = '';
	foreach( $messages as $msg ) {
		$son_ids .= $msg['son_id'].', ';
	}
	$son_ids .= '0';	// 末尾填充一个0,这样可以省去去除最后一个逗号的功夫
	$sql_select_reply = "select * from Messages where message_id in ( $son_ids )";
	$sth_select_reply = $dbh->prepare($sql_select_reply);
	lib_pdo_if_fail( $sth_select_reply->execute(), $sth_select_reply, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	if( 0 < $sth_select_reply->rowCount() ) {
		$replys = $sth_select_reply->fetchAll(PDO::FETCH_ASSOC);
		$sorted_replys = array();
		foreach( $replys as $reply ) {
			$sorted_reply = $reply;
			$sorted_replys[$reply['message_id']] = $sorted_reply;
		}
	}
}
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h4 id="main_content_head">在线留言  <a href="#add_message">我要留言</a></h4>
		<hr />
		<div id="messages">
<?php
foreach( $messages as $msg ) {
	echo "\t\t<p>{$msg['content']}\n";
	echo "<p>by: {$msg['pub_name']} | on: {$msg['pub_time']}</p>";
	if( array_key_exists($msg['son_id'], $sorted_replys) ) {
		echo "<p color=\"red\"><strong>管理员回复：<br />{$sorted_replys[$msg['son_id']]['content']}</strong></p>";
	}
	echo '<hr />';
}
echo '<hr class="clear_line">'."\n";
// 分页栏
$url = $_SERVER['SCRIPT_NAME']."?page=";
lib_dump_page_bar($url, $total_page, $page, true);
?>
		</div> <!-- end of DIV messages -->
		<div id="add_message">
		<hr />
		<hr />
		<p class="error"><?php echo $error_msg; ?></p>
		<form action="./action/add_message.php" method="post" >
			<label for="input_head">留言标题：<input type="text" name="message_head" id="input_head" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_content">留言内容：<input type="text" name="message_content" id="input_content" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_author">您的称呼：<input type="text" name="message_author" id="input_author" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_contact">联系方式：<input type="text" name="message_contact" id="input_contact" /></label><span class="input_hint">(*必填 我们会为您保密)</span><br />
			<label for="input_code">验证字符：<input type="text" name="veri_code" id="input_code" /></label><span class="input_hint">(*必填  不区分大小写)</span><br />
			验证图片：<a href="./message.php?rand=<?php echo rand(); ?>#add_message"><img src="lib/verify_code.php" />看不清？</a><br />
			<input type="submit" name="submit" value="post" />
		</form>
		</div><!-- end of DIV add_message -->
		<hr class="clear_line"/>
	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body>
</html>
