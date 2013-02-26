<?php
session_start();
require('config.php');
require($cfg_webRoot.'lib/debug.php');
require($cfg_webRoot.'lib/page.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
	lib_delay_jump(3, '对不起，请先登录，再进行管理');
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}
// 获取古董类别信息
$artwork_types = $_SESSION['artwork_types'];

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
require($cfg_dbConfFile);
$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
$sql_count = 'select count(1) as count from Artworks';
$sth_count = $dbh->prepare($sql_count);
lib_pdo_if_fail($sth_count->execute(), $sth_count, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$count_res = $sth_count->fetch(PDO::FETCH_ASSOC);
$count = $count_res['count'];
// 分页相关参数
$per_page = $cfg_aw_per_page;
$total_page = ceil($count/$per_page);
// 获取可能存在的通过get方式传来的页码
if( isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $total_page ) {
	$page = intval( $_GET['page'] );
} else { $page = 1; }
$start = ($page - 1)*$per_page;
$sql_select_artwork = '	select * from Artworks limit :start, :per_page ';
$sth_select_artwork = $dbh->prepare($sql_select_artwork);
$sth_select_artwork->bindParam(':start', $start, PDO::PARAM_INT);
$sth_select_artwork->bindParam(':per_page', $per_page, PDO::PARAM_INT);
lib_pdo_if_fail($sth_select_artwork->execute(), $sth_select_artwork, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
$artworks = $sth_select_artwork->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h4 id="main_content_head">管理艺术品 &nbsp;&nbsp;&nbsp;(<a href="#add_artwork">添加艺术品</a>)</h4>
		<hr />
<?php
echo "\t".'<ul id="production_list">'."\n";
if(0 == count($artworks)) { echo '<h4>暂无数据，请等待管理员上传数据</h4>';  }
foreach($artworks as $work) {
	$is_hidden = ($work['is_hidden'] ? '已隐藏' : '未隐藏' );
	$on_sale = ($work['on_sale'] ? '出售' : '不出售' );
	echo "	\t\t<li><a href=\"artwork.php?type=work&id={$work['artwork_id']}\">
		<div class=\"production_nail\" id=\"{$work['artwork_id']}\">
		<img src=\"{$work['img_small']}\" title=\"{$work['artwork_name']}\" width=\"120\" /></a>
		<table border=\"1\">
			<tr> <td colspan=\"2\" align=\"center\">{$work['artwork_name']}</td> </tr>
			<tr> <td>$is_hidden</td><td><a href=\"action/change_artwork_status.php?id={$work['artwork_id']}&type=hide\">更改</a></td> </tr>
			<tr> <td>$on_sale</td><td><a href=\"action/change_artwork_status.php?id={$work['artwork_id']}&type=sale\">更改</a></td> </tr>
			<tr> <td><a href=\"modify_artwork.php?id={$work['artwork_id']}\">修改信息(u)</a></td><td><a href=\"action/rm_artwork.php?id={$work['artwork_id']}\">删除(谨慎操作)</a></td> </tr>
		</table></div></li>\n";
}
echo "\t</ul>\n";
echo "<hr class=\"clear_line\" />\n";
	$url = $_SERVER['SCRIPT_NAME']."?page=";
	echo '<ul class="aclinic" >';
	lib_dump_page_bar($url, $total_page, $page, true);
	echo '</ul>';
?>
		<hr />
		<h4 >添加艺术品</h4>
		<hr />
		<p class="error"><?php echo $error_msg; ?></p>
		<div id="add_artwork">
		<form enctype="multipart/form-data" action="action/add_artwork.php" method="post" >
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $cfg_max_upload_file_size; ?>" />
			<label for="choose_img">图片<input type="file" name="artwork_image" id="choose_img" /></label><br />
			<label for="input_name">名称<input type="text" name="artwork_name" id="input_name" /></label><span class="input_hint">(*必需)</span><br />
			<label for="input_size">尺寸<input type="text" name="artwork_size" id="input_size" /></label><br />
			<label for="input_author">作者<input type="text" name="artwork_author" id="input_author" /></label><br />
			<label for="input_period">时期<input type="text" name="artwork_period" id="input_period" /></label><br />
			<label for="input_intro">简介<input type="text" name="artwork_intro" id="input_intro" /></label><br />
			<label for="input_detail">详细<input type="text" name="artwork_detail" id="input_detail" /></label><br />
			<label for="input_price">价格<input type="text" name="artwork_price" id="input_price" /></label><br />
			<label for="input_amount">数量<input type="text" name="artwork_amount" id="input_amount" /></label><br />
			类型<select name="artwork_type" id="choose_type">
			<?php foreach($artwork_types as $key => $value) { ?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php } ?>
			</select><span class="input_hint">(*必需)</span><br />
			评论<select name="allow_comment" >
			<option value="1">允许</option>
			<option value="0">不允许</option>
			</select><br />
			出售<select name="on_sale" >
			<option value="0">否</option>
			<option value="1">是</option>
			</select><br />
			隐藏<select name="is_hidden" >
			<option value="0">否</option>
			<option value="1">是</option>
			</select><br />
			<input type="submit" name="submit" value="添加此艺术品" />
		</form>
		</div><!-- end of DIV add_artwork -->
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
