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
if(isset($_GET['aid'])) {
	$aid = intval($_GET['aid']);
	// get the article
	require($cfg_dbConfFile);
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_select_article = 'select * from Articles where article_id = :aid';
	$sth_select_article = $dbh->prepare($sql_select_article);
	$sth_select_article->bindParam(':aid', $aid, PDO::PARAM_INT);
	lib_pdo_if_fail( $sth_select_article->execute(), $sth_select_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	$article = $sth_select_article->fetch(PDO::FETCH_ASSOC);
}
?>

<?php require('include/dochead.php'); ?>
<link rel="stylesheet" href="styles/newinnerpage.css" type="text/css" />
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<?php if (empty($aid)) {
			echo '<h4 id="main_content_head">添加文章</h4>';
			echo '<p>（删除和修改文章请至浏览文章页面）</p>';
		} else {
			echo '<h4 id="main_content_head">修改文章</h4>';
		}
		?>
		<hr />
		<p class="error"><?php echo $error_msg; ?></p>
		<div id="add_article">
		<form enctype="multipart/form-data" action="action/add_article.php<?php if(isset($aid)){echo "?aid=$aid";}?>" method="post" >
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $cfg_max_upload_file_size; ?>" />
			<label for="input_name">文章名称<input type="text" name="article_name" id="input_name" value="<?php if(isset($article)) echo $article['article_name']; ?>" /></label><span class="input_hint">(*必填)</span><br />
			<label for="input_content">内容<span class="input_hint">(*必填)</span><br /><textarea name="article_content" id="input_content" cols="40" rows="40" ><?php if(!empty($article['content'])){echo $article['content'];} ?></textarea></label></span><br />
			<label for="input_source">来源<input type="text" name="article_source" id="input_source" value="<?php if(!empty($article['source'])) {echo $article['source'];}?>" /></label><br />
			<label for="input_author">作者<input type="text" name="article_author" id="input_author" value="<?php if(!empty($article['author'])){echo $article['author'];} ?>" /></label><br />
			<label for="choose_img">配图<input type="file" name="article_image" id="choose_img" value="<?php if(!empty($article['picture'])){echo $article['picture'];}?>" /></label><br />
			类型<select name="is_artist" id="choose_type">
			<option value="0">艺术视角</option>
			<option value="1" <?php if($article['is_artist']) echo 'selected="selected"'; ?> >名家推荐</option>
			</select><span class="input_hint">(*必需)</span><br />
			评论<select name="allow_comment" >
			<option value="0" <?php if(!$article['allow_comment']) echo 'selected="selected"'; ?> >不允许</option>
			<option value="1">允许</option>
			</select><br />
			隐藏<select name="is_hidden">
			<option value="0" <?php if(!$article['is_hidden']) echo 'selected="selected"'; ?> >不隐藏</option>
			<option value="1">隐藏</option>
			</select><br />
			<input type="submit" name="<?php if(isset($aid)){echo 'modify';}else {echo 'submit';}?>" value="<?php if(isset($aid)){echo '修改';} else {echo '添加';} ?>此文章" />
		</form>
			<?php if (isset($aid)) {
				echo '<a href="article.php"><input type="submit" name="cancel" value="放弃修改" /></a>';
			} ?>
		</div><!-- end of DIV add_article -->
		<hr class="clear_line"/>
	</div> <!-- end of DIV main_content -->
	<div id="navi" >
<?php require('./include/navi.php'); ?>
	</div> <!-- end of DIV navi -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body>
</html>
