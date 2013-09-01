<?php
session_start();
include('./config.php');
include($cfg_webRoot.$cfg_lib.'debug.php');
require($cfg_webRoot.$cfg_lib.'page.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}
/*
 * 本程序负责检索艺术品(或其他类型数据，后期增强的话)
 * 通过POST方式接收两个参数：
 * type ：检索要素 ，值可以是。。。
 * key  : 检索关键词
 */

$types = array(
		'author'=>'author',
		'period'=>'period',
		'name'=>'artwork_name',
		'type'=>'artwork_type',
		);
$view_types = array(
		'name'=>'作品名称',
		'author'=>'作者姓名',
		'type'=>'作品类型',
		'period'=>'作品时期',
		);
if( empty($_POST['type']) || !array_key_exists($_POST['type'], $types) ) {
	$type = 'name';
} else {
	$type = substr(trim($_POST['type']), 0, 300);
}

if( empty($_POST['key']) ) {
	$key = '_';
} else {
	$key = substr(trim($_POST['key']), 0, 300);
}
$key = '%'. $key. '%';

// 数据验证完毕，开始检索数据库
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);

$sql_count = 'select count(1) as count from Artworks where is_hidden = 0 and '.$types[$type].' like :key';
$sth_count = $dbh->prepare($sql_count);
$sth_count->bindParam(':key', $key, PDO::PARAM_STR, 90);
lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
$count = $count_res['count'];
$per_page = $cfg_aw_per_page;
$total_page = ceil($count/$per_page);
if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
	$page = intval($_GET['page']);
} else { $page = 1; }
$start = ($page - 1)*$per_page;

$sql_search_artwork = 'select * from Artworks where is_hidden = 0 and '.$types[$type].' like :key '. 'limit '. $start. ' , '. $per_page;
$sth_search_artwork = $dbh->prepare($sql_search_artwork);
$sth_search_artwork->bindParam(':key', $key, PDO::PARAM_STR, 90);
lib_pdo_if_fail( $sth_search_artwork->execute(), $sth_search_artwork, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
$artworks = $sth_search_artwork->fetchAll(PDO::FETCH_ASSOC);


// 显示页面
include($cfg_webRoot.'include/dochead.php');
echo '<link rel="stylesheet" href="styles/newinnerpage.css" type="text/css" />';
echo '</head><body><div id="header">';
include($cfg_webRoot.'include/header.php');
echo '<div id="body">';
echo '<div id="main_content" class="content_block">';
echo '<h4 id="main_content_head"></h4>';

echo '<h3>站内搜索</h3><hr />';
	// 显示搜索框
?>
		<form action="#" method="POST">
			类型：
			<select>
				<?php
				foreach ( $view_types as $name => $value ) {
					echo '<option name="'. $name. '">'. $value. '</option>';
				}
				?>
			</select>
			关键词：
			<input type="text" name="key" value="<?php echo (empty($_POST['key'])) ? '': $_POST['key'];?>" />
			<input type="submit" name="submit" value="搜索" />
		</form>
<?php
	// 显示艺术品
	echo "\t".'<ul id="production_list">'."\n";
	if(0 == count($artworks)) { echo '<h4> 没有检索到任何结果，请更换检索词重新检索或联系管理员</h4>';  }
	foreach($artworks as $work) {
		echo "	\t\t<li><a href=\"artwork.php?type=work&id={$work['artwork_id']}\" target=\"_blank\">
			<div class=\"production_nail\" id=\"{$work['artwork_id']}\">
			<img src=\"{$work['img_small']}\" title=\"{$work['artwork_name']}\" width=\"120\" />
			<p>{$work['artwork_name']}({$work['artwork_id']} {$work['period']} {$work['author']})</p></div></a> </li>\n";
	}
	echo "\t</ul>\n";
	echo "<hr class=\"clear_line\" />\n";
	// 分页栏
	$url = $_SERVER['SCRIPT_NAME']."?type=$type&page=";
	echo '<ul class="aclinic">';
	lib_dump_page_bar($url, $total_page, $page, true);
	echo '</ul>';
?>
	</div> <!-- end of DIV main_content -->
	<div id="navi">
<?php include('./include/navi.php'); ?>
	</div> <!-- end of DIV navi -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php include('./include/footer.php'); ?>
</div>	<!-- end of DIV footer -->
</body> </html>
