<?php
/* /lib/install.php
 * written by gipsaliu(at)gmail(dot)com on 2013-01-24
 * 
 * 本文件存放一些和安装有关的函数
 */

function lib_sql_file_to_statments($path) {
	if( !file_exists($path) || !$file_content = file_get_contents( $path ) ) {
		echo 'lib_sql_to_statments() 指定文件不存在或无法打开';
		exit();
	}
	$pattern = '/\/\*[^\/]+\*\//';
	$sub_strs = preg_split($pattern, $file_content, -1);
	$re_cat_str = implode($sub_strs);
	$re_split_str = explode(";",  $re_cat_str);
	return $re_split_str;
}

?>
