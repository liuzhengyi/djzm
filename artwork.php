<?php
session_start();
/* /artwork.php
 * by gipsaliu(at)gmail(dot)com on 2012-12-24
 * 
 * 本文件通过get方式接收如下参数：
 * type == [all|sale|work] 默认值为 'all'
 * 当type == 'work'时，还应该通过get方式传递参数id
 * 参数id的取值范围为 [0-9]*
 *
 */
include('config.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台
	require('include/console_var.php');
} else { // 非管理员	!!
}
// 错误处理函数 和 分页函数
require($cfg_webRoot.$cfg_lib.'debug.php');
require($cfg_webRoot.$cfg_lib.'page.php');

// 根据请求类型确定SQL语句 和 head 等变量
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
if ( !isset($_GET['type']) ) { $type = 'all'; }
switch ($_GET['type']) {
	case 'sale':
		// 获取出售类艺术品总数 供分页栏使用
		$sql_count = 'select count(1) as count from Artworks where on_sale = TRUE AND is_hidden = FALSE';
		$sth_count = $dbh->prepare($sql_count);
		lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
		$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
		$count = $count_res['count'];
		// 分页相关参数
		$per_page = $cfg_aw_per_page;
		$total_page = ceil($count/$per_page);
		// 获取可能存在的通过get方式传来的页码
		if(isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
			$page = intval($_GET['page']);
		} else { $page = 1; }

		$start = ($page-1)*$per_page;
		// 一些变量 和 SQL 语句
		$type = 'sale';
		$main_content_head = '艺术品交流';
		$sql_select_artwork = "	select *
					from Artworks where is_hidden = FALSE AND on_sale = TRUE
					limit :start, :per_page";
		$sth_select_artwork = $dbh->prepare($sql_select_artwork);
		$sth_select_artwork->bindParam(':start', $start, PDO::PARAM_INT);
		$sth_select_artwork->bindParam(':per_page', $per_page, PDO::PARAM_INT);
		break;
	case 'work':	// artwork
		// 获取古董类别信息
		$artwork_types = $_SESSION['artwork_types'];
		// 获取所有艺术品总数 
		$sql_count = '	select count(1) as count from Artworks where is_hidden = FALSE';
		$sth_count = $dbh->prepare($sql_count);
		lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
		$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
		$count = $count_res['count'];
		$type = 'work';
		$main_content_head = '艺术品详情';
		if ( isset($_GET['id']) ) { $id = intval($_GET['id']);
		} else { $id = 1; }
		// 获取 $prev_id, $net_id 供“上一个” “下一个”使用
		// 上一个
		$sql_prev_id = 'select artwork_id as id, artwork_name as name from Artworks where artwork_id < :id and is_hidden=false order by artwork_id desc limit 1';
		$sth_prev_id = $dbh->prepare($sql_prev_id);
		$sth_prev_id->bindParam(':id', $id, PDO::PARAM_INT);
		lib_pdo_if_fail($sth_prev_id->execute(), $sth_prev_id, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
		$prev_id_res= $sth_prev_id->fetch(PDO::FETCH_ASSOC);
		$url = $_SERVER['SCRIPT_NAME'].'?type='.$type.'&id=';
		if(empty($prev_id_res['id'])) {$prev_link = '上一个<a>没有了</a>';
		} else {$prev_link = '上一个<a href="'.$url.$prev_id_res['id'].'">'.$prev_id_res['name'].'</a>';}
		// 下一个
		$sql_next_id = 'select artwork_id as id, artwork_name as name from Artworks where artwork_id > :id and is_hidden=false order by artwork_id asc limit 1';
		$sth_next_id = $dbh->prepare($sql_next_id);
		$sth_next_id->bindParam(':id', $id, PDO::PARAM_INT);
		lib_pdo_if_fail($sth_next_id->execute(), $sth_next_id, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
		$next_id_res= $sth_next_id->fetch(PDO::FETCH_ASSOC);
		$url = $_SERVER['SCRIPT_NAME'].'?type='.$type.'&id=';
		if(empty($next_id_res['id'])) {$next_link = '下一个<a>没有了</a>';
		} else {$next_link = '下一个<a href="'.$url.$next_id_res['id'].'">'.$next_id_res['name'].'</a>';}

		// 获取艺术品详细数据
		$sql_select_artwork = "	select * from Artworks where artwork_id = :id AND is_hidden = FALSE";
		$sth_select_artwork = $dbh->prepare($sql_select_artwork);
		$sth_select_artwork->bindParam(':id', $id, PDO::PARAM_INT);
		break;
	default:
		// 获取所有艺术品总数 供分页栏使用
		$sql_count = '	select count(1) as count from Artworks where is_hidden = FALSE';
		$sth_count = $dbh->prepare($sql_count);
		lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
		$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
		$count = $count_res['count'];

		// 分页相关参数
		$per_page = $cfg_aw_per_page;
		$total_page = ceil($count/$per_page);
		// 获取可能存在的通过get方式传来的页码
		if(isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
			$page = intval($_GET['page']);
		} else { $page = 1; }
		$start = ($page-1)*$per_page;

		// 一些变量和SQL语句
		$type = 'all';
		$main_content_head = '馆藏精品';
		$sql_select_artwork = "	select *
					from Artworks where is_hidden = FALSE
					limit :start, :per_page";
		$sth_select_artwork = $dbh->prepare($sql_select_artwork);
		$sth_select_artwork->bindParam(':start', $start, PDO::PARAM_INT);
		$sth_select_artwork->bindParam(':per_page', $per_page, PDO::PARAM_INT);
		break;
}
// read the database
lib_pdo_if_fail($sth_select_artwork->execute(), $sth_select_artwork, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$artworks = $sth_select_artwork->fetchAll(PDO::FETCH_ASSOC);
if(0 == count($artworks)) {
	// no results
}
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
	if(0 == count($artworks)) {
		echo '<h4>对不起，您所访问的艺术品不存在。</h4>';
	} else {
	echo "<div class=\"big_img\" ><a href=\"{$artworks[0]['img_large']}\" target=\"_blank\"><img src=\"{$artworks[0]['img_middle']}\" width=\"500px\" /></a></div>";
	$artwork = $artworks[0];
	echo '<table>';
	echo "<tr><td>作品名称：</td><td>{$artwork['artwork_name']}</td></tr>";
	//echo "<tr><td>作品类型：</td><td>{$artwork['artwork_type']}</td></tr>";
	echo "<tr><td>作品类型：</td><td>{$artwork_types[$artwork['artwork_type']]}</td></tr>";
	echo "<tr><td>作品尺寸：</td><td>{$artwork['artwork_size']}</td></tr>";
	echo "<tr><td>作品作者：</td><td>{$artwork['author']}</td></tr>";
	echo "<tr><td>作品时期：</td><td>{$artwork['period']}</td></tr>";
	echo "<tr><td>作品简介：</td><td>{$artwork['intro']}</td></tr>";
	echo "<tr><td>作品价格：</td><td>{$artwork['price']}</td></tr>";
	echo "<tr><td>作品数量：</td><td>{$artwork['amount']}</td></tr>";
	$on_sale = $artwork['on_sale']?'是':'否';
	echo "<tr><td>是否出售：</td><td>{$on_sale}</td></tr>";
	echo '</table>';
	echo '<hr />';
	echo '<p>详细介绍：</p><br />';
	$artwork_detail_show = str_replace(" ", '&nbsp;', $artwork['detail']);
	$artwork_detail_show = str_replace("\n", '<br />', $artwork_detail_show);
	//echo $artwork['detail'];
	echo $artwork_detail_show;
	echo '<hr />';
	echo "<p> $prev_link $next_link </p>";
	echo '<hr />';
	}
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
