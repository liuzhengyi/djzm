<?php
session_start();
require('config.php');
require($cfg_webRoot.'lib/debug.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
	lib_delay_jump(3, '对不起，请先登录，再进行管理');
} else {
// 是管理员，提供管理员控制台变量
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
		<div id="add_article">
		<form enctype="multipart/form-data" action="action/add_article.php" method="post" >
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $cfg_max_upload_file_size; ?>" />
			<label for="input_name">文章名称<input type="text" name="article_name" id="input_name" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_content">内容<input type="text" name="article_content" id="input_content" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_source">来源<input type="text" name="article_source" id="input_source" /></label><br />
			<label for="input_author">作者<input type="text" name="article_author" id="input_author" /></label><br />
			<label for="choose_img">配图<input type="file" name="article_image" id="choose_img" /></label><br />
			类型<select name="is_artist" id="choose_type">
			<option value="1">名家推荐</option>
			<option value="0">艺术视角</option>
			</select><span class="input_hint">(*必需)</span><br />
			评论<select name="allow_comment" >
			<option value="0">不允许</option>
			<option value="1">允许</option>
			</select><br />
			隐藏<select name="is_hidden">
			<option value="0">不隐藏</option>
			<option value="1">隐藏</option>
			</select><br />
			<input type="submit" name="submit" value="添加此文章" />
		</form>
		</div><!-- end of DIV add_article -->
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
