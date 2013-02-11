<?php
/* dbConf.php
 * 数据库配置文件
 * 在我的环境中是放在网站根目录之外的
 * 不管在何处，它的未知应该在系统配置
 * 文件config.php中用$dbConfFile指明。
 */
	$dbcfg_dbhost = 'localhost';
//	$dbcfg_dbhost = 'sql111.ucart.tw';
	$dbcfg_dbname = 'guyin';
//	$dbcfg_dbname = 'ucart_11955460_djzm';
	$dbcfg_dbuser = 'guyin_user';
//	$dbcfg_dbuser = 'ucart_11955460';
	$dbcfg_dbpwd = 'asguyin_user';
//	$dbcfg_dbpwd = 'ucart2gipsa';
	$dbcfg_dsn="mysql:dbname=$dbcfg_dbname;host=$dbcfg_dbhost";

	global $dbcfg_dbServs;
	$dbcfg_dbServs = array($dbcfg_dbhost, $dbcfg_dbname, $dbcfg_dbuser, $dbcfg_dbpwd);
?>
