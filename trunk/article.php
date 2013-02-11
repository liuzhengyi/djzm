<?php
session_start();
/* 本文件通过get方式接收如下参数：
 * type == [artist|artview|article] 默认值为 'artist'
 * 当type == 'article'时，还应该通过get方式传递参数id
 * 参数id的取值范围为 [0-9]*
 *
 */
require('config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台
	require('include/console_var.php');
} else { // 非管理员	!!
}

// 根据请求类型确定SQL语句 和 head 等变量
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
if ( !isset($_GET['type']) ) { $type = 'artist'; }
switch ($_GET['type']) {
	case 'artview':
		$type = 'artview';
		$main_content_head = '艺术视角';
		$sql_select_article = "	select article_id, article_name, pub_date from Articles
					where is_hidden = FALSE AND is_artist = FALSE";
		break;
	case 'article':
		$type = 'article';
		$main_content_head = '文章';
		if ( !isset($_GET['id']) ) { $id = 1; }
		$id = intval($_GET['id']);
		$sql_select_article = "	select * from Articles where article_id = :id AND is_hidden = FALSE limit 1";
		break;
	default:
		$type = 'artist';
		$main_content_head = '名家推荐';
		$sql_select_article = "	select article_id, article_name, pub_date from Articles
					where is_hidden = FALSE AND is_artist = TRUE";
		break;
}
// read the database
$sth_select_article = $dbh->prepare($sql_select_article);
if( 'article' == $type ) {
	$sth_select_article->bindParam(':id', $id, PDO::PARAM_INT);
}
lib_pdo_if_fail( $sth_select_article->execute(), $sth_select_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
if (0 == $sth_select_article->rowCount()) {
	$articles = '没有内容';	// no data !! the page you visit is not exist !!
} else {
	$articles = $sth_select_article->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h4 id="main_content_head"><?php echo $main_content_head; ?></h4>
		<hr />
<?php
if ( 'artist' == $type || 'artview' == $type ) {
// 显示文章列表
	echo "\t".'<ul id="article_list">'."\n";
	foreach($articles as $article) {
		echo "\t\t<li><a href=\"article.php?type=article&id={$article['article_id']}\">{$article['article_name']}</a> . {$article['pub_date']}</li>\n";
	}
	echo "\t</ul>\n";
	echo "<hr class=\"clear_line\" />\n";
	// 分页栏
	echo '<p>共xx页 当前第1页。</p> <p>转至第 <u>1</u><u>2</u> <u>x</u> <u>x</u> 页。</p>';
} else {
// 显示特定某篇文章 !!
	$article = $articles[0];
	echo "<h3>{$article['article_name']}</h3>";
	echo "<p>来源：{$article['source']} | 作者：{$article['author']} | 录入时间：{$article['pub_date']}</p>";
	echo '<quote>';
	echo $article['content'];
	echo "</quote>";
}
?>

	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
