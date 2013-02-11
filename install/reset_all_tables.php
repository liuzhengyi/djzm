<?php
//session_start();
require('../config.php');
require($cfg_webRoot.$cfg_lib.'install.php');
require($cfg_webRoot.$cfg_lib.'debug.php');
// if( !isset( $_SESSION['mname']) ) { $msg = '对不起，您不应直接访问此页面'; lib_delay_jump(3, $msg); }
$sql_file = $cfg_webRoot.'doc/sql/reset_all_tables.sql';
$statments = array();
$statments = lib_sql_file_to_statments($sql_file);
require($cfg_dbConfFile);
$dbh = new PDO( $dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);
	var_dump($statments);
foreach($statments as $statment) {
	$sql_reset_table = trim($statment);
	if( empty($sql_reset_table) ) {continue;}
	$sth_reset_table = $dbh->prepare($sql_reset_table);
	lib_pdo_if_fail( $sth_reset_table->execute(), $sth_reset_table, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
	echo "\n".'the following Statment is executed:'."\n";
	var_dump($sql_reset_table);
}


$sql_file = $cfg_webRoot.'doc/sql/testdata_all_tables.sql';
$statments = array();
$statments = lib_sql_file_to_statments($sql_file);
foreach($statments as $statment) {
	$sql_reset_table = trim($statment);
	if( empty($sql_reset_table) ) {continue;}
	$sth_reset_table = $dbh->prepare($sql_reset_table);
	lib_pdo_if_fail( $sth_reset_table->execute(), $sth_reset_table, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE);
	echo "\n".'the following Statment is executed:'."\n";
	var_dump($sql_reset_table);
}
?>
