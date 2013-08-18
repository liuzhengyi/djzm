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
require($cfg_webRoot.$cfg_lib.'page.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台
	require('include/console_var.php');
} else { // 非管理员	!!
}

// 根据请求类型确定SQL语句 和 head 等变量
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
if ( !isset($_GET['type']) ) { $type = 'artist'; } else {$type = $_GET['type'];}
//switch ($_GET['type']) {
switch ($type) {
	case 'artview':
		$type = 'artview';
		$main_content_head = '艺术视角';
		$sql_select_article = "	select article_id, article_name, sm_picture, pub_date from Articles
					where is_hidden = FALSE AND is_artist = FALSE";
		$sql_count_article = "select count(1) as count from Articles where is_hidden = FALSE AND
					is_artist = FALSE";
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
		$sql_select_article = "	select article_id, article_name, sm_picture, pub_date from Articles
					where is_hidden = FALSE AND is_artist = TRUE";
		$sql_count_article = "select count(1) as count from Articles where is_hidden = FALSE AND
					is_artist = TRUE";
		break;
}
// read the database for article counts used in page bar
if('artist' == $type || 'artview' == $type) {
	$sth_count_article = $dbh->prepare($sql_count_article);
	lib_pdo_if_fail( $sth_count_article->execute(), $sth_count_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	$msg_count_res = $sth_count_article->fetch(PDO::FETCH_ASSOC);
	$msg_count = $msg_count_res['count'];
	// 分页相关参数
	$per_page = $cfg_ms_per_page;
	$total_page = ceil($msg_count/$per_page);
	// 获取可能存在的通过get方式传递的页码
	if( isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
		$page = intval($_GET['page']);
	} else { $page = 1; }
	$start = ($page-1)*$per_page;

	// read the database for article(s)
	$sql_select_article .= ' limit :start, :per_page';
	$sth_select_article = $dbh->prepare($sql_select_article);
	$sth_select_article->bindParam(':start', $start, PDO::PARAM_INT);
	$sth_select_article->bindParam(':per_page', $per_page, PDO::PARAM_INT);
} else {
	$sth_select_article = $dbh->prepare($sql_select_article);
}
if( 'article' == $type ) {
	$sth_select_article->bindParam(':id', $id, PDO::PARAM_INT);
}
lib_pdo_if_fail( $sth_select_article->execute(), $sth_select_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
if (0 == $sth_select_article->rowCount()) {
	$articles = '';	// no data !! the page you visit is not exist !!
} else {
	$articles = $sth_select_article->fetchAll(PDO::FETCH_ASSOC);
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
		<h4 id="main_content_head"><?php echo $main_content_head; ?></h4>
		<hr />
<?php
if ( 'artist' == $type || 'artview' == $type ) {
// 显示文章列表
	if ( !is_array($articles) ) {
		echo '<h3>暂无数据，请等待管理员上传。</h3>';
	} else {
		echo "\t".'<ul id="article_list">'."\n";
		foreach($articles as $article) {
		//	echo "\t\t<li><a href=\"article.php?type=article&id={$article['article_id']}\">{$article['article_name']}</a> . {$article['pub_date']}</li>\n";
	//		echo "<img src=\"{$article['sm_picture']}\" />";
			echo "\t\t<li><a href=\"article.php?type=article&id={$article['article_id']}\">
			<div class=\"production_nail\" >
			<img src=\"{$article['sm_picture']}\" class=\"sm_img\" />
			<p>{$article['article_name']} . {$article['pub_date']}</p>
			</div></a>
			</li>\n";
		}
		echo "\t</ul>\n";
		echo "<hr class=\"clear_line\" />\n";
		// 分页栏
		$url = $_SERVER['SCRIPT_NAME']."?type=$type&page=";
		echo '<ul class="aclinic">';
		lib_dump_page_bar($url, $total_page, $page, true);
		echo '</ul>';
	}
} else {
// 显示特定某篇文章 !!
	if(empty($articles)) {
		echo '<p>对不起，您所访问的文章不存在。</p>';
		echo '<p><a href="./article.php">点此返回文章列表</a></p>';
	} else {
		$article = $articles[0];
		echo "<h3>{$article['article_name']}</h3>";
		if(isset($_SESSION['mname'])) {
			echo '<div class="article_control">';
			echo '<ul class="aclinic">';
			echo '<li><a href="./control_article.php?aid='.$article['article_id'].'">修改文章</a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<li><a href="action/delete_article.php?aid='.$article['article_id'].'">删除文章(谨慎操作)</a></li>';
			echo '</ul></div>';
		}
		if(!$article['is_artist']) {
			echo "<p>来源：{$article['source']} | 作者：{$article['author']} | 录入时间：{$article['pub_date']}</p>";
		}
		echo "<img src=\"{$article['la_picture']}\" />\n";
		echo '<p class="auto-break">';
		$article_content_show = str_replace(" ", '&nbsp;', $article['content']);
		$article_content_show = str_replace("\n", '</p></p>', $article_content_show);
		echo $article_content_show;
		echo '</p>';
	}
}
?>

	</div> <!-- end of DIV main_content -->
	<div id="navi" >
<?php include('./include/navi.php'); ?>
	</div> <!-- end of DIV navi -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
