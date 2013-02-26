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
require($cfg_webRoot.$cfg_lib.'debug.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台
	require('include/console_var.php');
} else { // 非管理员	!!
	lib_delay_jump(3, '对不起，请先登录，再进行管理');
}
// 错误处理函数 和 分页函数
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
$main_content_head = '艺术品详情修改';
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
	echo '<form action="action/modify_artwork.php" method="post" >';
	echo '<label for="id"><input id="id" name="id" value="'.$artwork['artwork_id'].'" type="hidden" /></label><br />';
	echo '<label for="name">作品名称：<input id="name" name="name" value="'.$artwork['artwork_name'].'" /></label><br />';
	echo '<label for="size">作品尺寸：<input id="size" name="size" value="'.$artwork['artwork_size'].'" /></label><br />';
	echo '<label for="author">作品作者：<input id="author" name="author" value="'.$artwork['author'].'" /></label><br />';
	echo '<label for="period">作品时期：<input id="period" name="period" value="'.$artwork['period'].'" /></label><br />';
	echo '<label for="intro">作品简介：<input id="intro" name="intro" value="'.$artwork['intro'].'" /></label><br />';
	echo '<label for="detail">详细介绍：<textarea id="detail" name="detail" wrap="virtual" >'.$artwork['detail'].'</textarea></label><br />';
	echo '<label for="intro">作品价格：<input id="price" name="price" value="'.$artwork['price'].'" /></label><br />';
	echo '<label for="amount">作品数量：<input id="amount" name="amount" value="'.$artwork['amount'].'" /></label><br />';
	echo '作品类型：<select id="type" name="type" >';
	foreach( $_SESSION['artwork_types'] as $key => $value ) {
		$selected = ($key == $artwork['artwork_type']) ? ('selected="selected"') : ('');
		echo "<option value=\"$key\" $selected >$value</option>";
	}
	echo '</select><br />';
	echo '允许评论：<select name="nocomment" ><option value="1">不允许</option><option value="0">允许</option></select><br />';
	echo '是否出售：<select name="sale"><option value="0">不出售</option><option value="1">出售</option></select><br />';
	echo '是否隐藏：<select name="hide"><option value="0">不隐藏</option><option value="1">隐藏</option></select><br />';
	// $on_sale = $artwork['on_sale']?'是':'否';
	/*
	 * 上一个 and 下一个 链接，在此页面暂时取消
	$prev_id = ($id > 1 && $id <= $count) ? ($id-1) : $count;
	$next_id = ($id >= 0 && $id < $count-1) ? ($id+1) : 1;
	$url = $_SERVER['SCRIPT_NAME'].'?type='.$type.'&id=';
	echo '<p><a href="'.$url.$prev_id.'">上一个</a><a href="'.$url.$next_id.'">下一个</a></p>';
	*/
	echo '<input type="submit" value="提交更改" />';
	echo '</form>';
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
