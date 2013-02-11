<?php
session_start();
require('config.php');
require($cfg_webRoot.'lib/debug.php');
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
		default:
			$error_msg = '';
			break;
	}
}
// 读session
if(empty($_SESSION['artwork_types'])) {
	echo '出错了，SESSION中没有艺术品分类信息 line:' . __LINE__ . '  file:'.__FILE__; // error occured 此处需要一个错误处理 !!
	exit();
} else {
	$artwork_types = $_SESSION['artwork_types'];
}
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h4 id="main_content_head">添加文章</h4>
		<hr />
		<p class="error"><?php echo $error_msg; ?></p>
		<div id="cur_types">
		<h3>已有艺术品分类</h3>
		<ul>
<?php
foreach($artwork_types as $name_en => $name_zh) {
	echo "<li>$name_zh($name_en)</li>\n";
}
?>
		</ul>
		</div> <!-- end of DIV cur_types -->
		<div id="add_type">
		<form action="action/add_type.php" method="post" >
			<label for="input_name_zh">艺术品分类中文名称<input type="text" name="type_name_zh" id="input_name_zh" /></label><span class="input_hint">(*必填，用于页面显示)</span><br />
			<label for="input_name_en">艺术品分类英文名称<input type="text" name="type_name_en" id="input_name_en" /></label><span class="input_hint">(*必填，可以用拼音)</span><br />
			<label for="input_addition">辅助说明<input type="text" name="type_addition" id="input_addition" /></label><span class="input_hint">(非必填，简介该分类)</span><br />
			<input type="submit" name="submit" value="添加此分类" />
		</form>
		</div><!-- end of DIV add_type -->
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
