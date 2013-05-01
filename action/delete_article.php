<?php
session_start();
require('../config.php');
require($cfg_webRoot.'lib/debug.php');

if(empty($_GET['aid']) || empty($_SESSION['mname'])) {
// 直接访问此页面，跳转至首页 // 只有管理员可以访问此页面
	lib_delay_jump(3, '对不起，您不应直接访问此页面');
}
// 此处需要基本的数据检验 !! 注意空字符串和NULL的区别
$aid = intval($_GET['aid']);

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
	$sql_select_article = 'select article_id from Articles where article_id = :aid ';
	$sth_select_article = $dbh->prepare($sql_select_article);
	$sth_select_article->bindParam(':aid', $aid, PDO::PARAM_INT);
	lib_pdo_if_fail( $sth_select_article->execute(), $sth_select_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
	$count_res = $sth_select_article->fetch(PDO::FETCH_ASSOC);
	if(empty($count_res)) {
		// no such article.
		//echo '<p>the specified article does not exists.</p>';
		$msg = '指定的文章不存在！';
	} else {
	// delete article $aid
		$sql_delete_article = 'delete from Articles where article_id = :aid limit 1';
		$sth_delete_article = $dbh->prepare($sql_delete_article);
		$sth_delete_article->bindParam(':aid', $aid, PDO::PARAM_INT);
		lib_pdo_if_fail( $sth_delete_article->execute(), $sth_delete_article, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		//echo '<p>the specified article has been deleted.</p>';
		$msg = '文章已经成功删除！';
	}
	//echo '<a href="../article.php">click here to return.</a>';
	$dbh = null;
	lib_delay_jump(3, $msg, '../article.php', '文章列表');
?>
