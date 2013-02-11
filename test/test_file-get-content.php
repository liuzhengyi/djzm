<?php
$path = '../doc/sql/reset_all_tables.sql';
$file_content = file_get_contents($path);

$content = '	e...

		blank line is splited...
		/*hello*/
		there;
		/*
		 * hi
		*/
		/**/
		this
		is
		/* gipsa */
		this is the end line;';
$sub_strs = array();
$pattern = '/\/\*[^\/]+\*\//';
//$sub_strs = preg_split($pattern, $file_content, -1);
$sub_strs = preg_split($pattern, $content, -1);
$re_cat_str = implode($sub_strs);
$re_split_str = explode(";",  $re_cat_str);
foreach($re_split_str as $str) {
	if( empty($str ) ) {
		continue;
	}
	var_dump($str);
	echo "\n";
}
echo "\n";
?>
