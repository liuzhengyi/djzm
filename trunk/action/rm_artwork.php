<?php
session_start();
/* written by gipsaliu(at)gmail(dot)com on 2013-02-16
 * 本程序负责删除艺术品
 * 需要管理员权限 (也许应该需要主管理员权限)
 *
 * 本程序通过命令行接受唯一参数 id
 *
 */
require('../config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');

if(empty($_SESSION['mid']) || empty($_SESSION['mname']) ) {
// 直接访问此页面，跳转至首页
	lib_delay_jump(3, '对不起，请先登录，再进行管理');
}
if( !$_SESSION['is_primary'] ) {
	lib_delay_jump(3, '对不起，您没有删除权限，请尝试隐藏功能或联系主管理员' );
}
if( !isset($_GET['id']) || !is_numeric($_GET['id']) ) {
	lib_delay_jump(3, '对不起，参数非法，请重试' );
}
$id = intval( $_GET['id'] );

// 写数据库
require($cfg_dbConfFile);
//require($cfg_webRoot.$cfg_lib.'debug.php');
	$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// $dbcfg_xxx initialed in dbConf.php
	$sql_confirm_artwork = 'select 1 as exist from Artworks where artwork_id = :id limit 1';
	$sth_confirm_artwork = $dbh->prepare($sql_confirm_artwork);
	$sth_confirm_artwork->bindParam(':id', $id, PDO::PARAM_INT);
	lib_pdo_if_fail(	$sth_confirm_artwork->execute(), $sth_confirm_artwork,
				__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
			);
	$exist = $sth_confirm_artwork->fetch(PDO::FETCH_ASSOC);
	if( !$exist['exist'] ) {
		lib_delay_jump(3, '对不起，您要删除的艺术品不存在，请查明');
	}
	$sql_rm_artwork = 'delete from Artworks where artwork_id = :id limit 1';
	$sth_rm_artwork = $dbh->prepare($sql_rm_artwork);
	$sth_rm_artwork->bindParam(':id', $id, PDO::PARAM_INT);
	lib_pdo_if_fail(	$sth_rm_artwork->execute(), $sth_rm_artwork,
				__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
			);
	lib_delay_jump(3, '艺术品删除成功');
	// todo
	// 从服务器上删除艺术品文件
	exit();
?>
