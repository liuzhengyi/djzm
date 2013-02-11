<?php
session_start();
/* /control_message.php
 *
 * by gipsaliu(at)gmail(dot)com on 2013-01-16
 * 
 * 本页面提供留言管理界面，对每条留言提供如下接口：
 * 	审核通过，审核不通过，回复
 *	注意，本页面只提供接口，真正的动作由action目录中程序完成
 */
require('config.php');
require($cfg_webRoot.'lib/debug.php');
require($cfg_webRoot.$cfg_lib.'page.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
	lib_delay_jump(3, '对不起，请先登录，再进行管理');
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
$sql_select_message = 'select * from Messages where parent_id IS NULL order by pub_time desc limit :start, :per_page';
$sth_select_message = $dbh->prepare($sql_select_message);
$sth_select_message->bindParam(':start', $start, PDO::PARAM_INT);
$sth_select_message->bindParam(':per_page', $per_page, PDO::PARAM_INT);
lib_pdo_if_fail( $sth_select_message->execute(), $sth_select_message, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
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
		<h4 id="main_content_head">在线留言</h4>
		<hr />
		<p class="error"><?php echo $error_msg; ?></p>
		<div id="messages">
<?php
foreach( $messages as $msg ) {
	if( 1 == $msg['is_checked'] ) {
		$checked = '已通过';
		$change = "<a href=\"action/change_message_status.php?id={$msg['message_id']}\">更改为未通过</a>";
	} else {
		$checked = '未通过';
		$change = "<a href=\"action/change_message_status.php?id={$msg['message_id']}\">更改为已通过</a>";
	}
	echo "\t\t<p>第 {$msg['message_id']} 条留言：</p>";
	echo "\t\t<p>{$msg['content']}\n";
	echo "<p>by: {$msg['pub_name']} | on: {$msg['pub_time']} | 审核状态： $checked ($change) | ";
	if( array_key_exists($msg['son_id'], $sorted_replys) ) {
		echo "<p color=\"red\"><strong>管理员回复：<br />{$sorted_replys[$msg['son_id']]['content']}</strong></p>";
	}
	if(empty($msg['son_id'])) { echo "<a href=\"control_message.php?id={$msg['message_id']}#add_reply\">回复</a></p>"; };
	echo '<hr class="clear_line" />';
}
	// 分页栏
	$url = $_SERVER['SCRIPT_NAME'].'?page=';
	lib_dump_page_bar($url, $total_page, $page, true);
?>
		</div> <!-- end of DIV messages -->
		<div id="add_reply">
		<p class="error"><?php echo $error_msg; ?></p>
		<form action="action/add_message.php?type=reply" method="post" >
			<label for="input_id">回复第<input type="text" name="id" id="input_id" value="<?php if(isset($_GET['id'])) {echo $_GET['id']; } ?>" />条留言</label><span class="input_hint">(*必填)</span><br />
			<label for="input_content">回复内容：<input type="text" name="message_content" id="input_content" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_code">验证字符：<input type="text" name="veri_code" id="input_code" /></label><span class="input_hint">(*必填  不区分大小写)</span><br />
			验证图片：<a href="./message.php?rand=<?php echo rand(); ?>#add_message"><img src="lib/verify_code.php" />看不清？</a><br />
			<input type="submit" name="submit" value="确认回复" />
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
