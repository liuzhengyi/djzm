<?php
session_start();
/* /modify_artwork.php
 * by gipsaliu(at)gmail(dot)com on 2013-02-06
 * 
 * 本文件通过get方式接收如下参数：
 * 参数id的取值范围为 [0-9]*
 *
 */
include('config.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台
	require('include/console_var.php');
} else { // 非管理员	!!
	lib_delay_jump();
}
// 错误处理函数 和 分页函数
require($cfg_webRoot.$cfg_lib.'debug.php');
require($cfg_webRoot.$cfg_lib.'page.php');

// 根据请求类型确定SQL语句 和 head 等变量
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
// 获取所有艺术品总数 供“上一个” “下一个”使用
$sql_count = '	select count(1) as count from Artworks where is_hidden = FALSE';
$sth_count = $dbh->prepare($sql_count);
lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
$count = $count_res['count'];
$type = 'work';
$main_content_head = '艺术品详情';
if ( !isset($_GET['id']) || ($_GET['id'] < 1) || ($_GET['id'] > $count)) {
	lib_delay_jump(3, '您所管理的艺术品不存在');
}
$id = intval($_GET['id']);
$sql_select_artwork = "	select * from Artworks where artwork_id = :id AND is_hidden = FALSE";
$sth_select_artwork = $dbh->prepare($sql_select_artwork);
$sth_select_artwork->bindParam(':id', $id, PDO::PARAM_INT);
// read the database
lib_pdo_if_fail($sth_select_artwork->execute(), $sth_select_artwork, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$artworks = $sth_select_artwork->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require('include/dochead.php'); ?>
</head>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h4 id="main_content_head"><?php echo $main_content_head; ?></h4>
		<hr />
<?php
if ( 'sale' == $type || 'all' == $type ) {
// 显示艺术品列表
	// 显示艺术品
	echo "\t".'<ul id="production_list">'."\n";
	if(0 == count($artworks)) { echo '<h4>暂无数据，请等待管理员上传数据</h4>';  }
	foreach($artworks as $work) {
		echo "	\t\t<li><a href=\"artwork.php?type=work&id={$work['artwork_id']}\">
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
} else {
// 显示特定艺术品详细信息 !!
	echo "<div class=\"big_img\" ><a href=\"{$artworks[0]['img_large']}\" target=\"_blank\"><img src=\"{$artworks[0]['img_middle']}\" width=\"500px\" /></a></div>";
	$artwork = $artworks[0];
	echo '<table>';
	echo "<tr><td>作品名称：</td><td>{$artwork['artwork_name']}</td></tr>";
	echo "<tr><td>作品类型：</td><td>{$artwork['artwork_type']}</td></tr>";
	echo "<tr><td>作品尺寸：</td><td>{$artwork['artwork_size']}</td></tr>";
	echo "<tr><td>作品作者：</td><td>{$artwork['author']}</td></tr>";
	echo "<tr><td>作品时期：</td><td>{$artwork['period']}</td></tr>";
	echo "<tr><td>作品简介：</td><td>{$artwork['intro']}</td></tr>";
	echo "<tr><td>作品数量：</td><td>{$artwork['amount']}</td></tr>";
	$on_sale = $artwork['on_sale']?'是':'否';
	echo "<tr><td>是否出售：</td><td>{$on_sale}</td></tr>";
	echo '</table>';
	echo '<hr />';
	$prev_id = ($id > 1 && $id <= $count) ? ($id-1) : $count;
	$next_id = ($id >= 0 && $id < $count-1) ? ($id+1) : 1;
	$url = $_SERVER['SCRIPT_NAME'].'?type='.$type.'&id=';
	echo '<p><a href="'.$url.$prev_id.'">上一个</a><a href="'.$url.$next_id.'">下一个</a></p>';
	echo '<hr />';
	echo '<p>详细介绍：</p><br />';
	echo $artwork['detail'];
	echo '<hr />';
}
?>
	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content">
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>