<?php
/*
 * 本文件是系统的基础配置文件
 *
 * 注意：在不同的服务器上开发时需要更改的信息有
 *	$cfg_hostRoot
 *	应设置为真实的本地文件目录
 * 以及
 *	本地的虚拟服务器目录和hosts文件
 *	应设置为和本配置文件中cfg_hostName,cfg_siteRoot等一致，
 **/

// debug or not
define( "CFG_DEBUG", TRUE);
//define( "CFG_DEBUG", FALSE);
if(CFG_DEBUG) {
	ini_set("display_errors", 1);
} else {
	ini_set("display_errors", 0);
}

// 本地主机名称
$cfg_hostName = 'r52/';
// 服务器上的网站根目录，包含文件路径中用这个
$cfg_webRoot = "/var/www/djzm/";
// 网站的http根目录，url中用这个
$cfg_siteRoot = "http://r52/djzm/";
// 在ucart服务器上的配置
//$cfg_webRoot = "/home/vol15/ucart.tw/ucart_11955460/djzm.ucart.tw/htdocs/";
//$cfg_siteRoot = "http://djzm.ucart.tw/";

// 数据库配置文件位置
$cfg_dbConfFile = $cfg_webRoot."dbConf.php";
// 自定义库函数目录
$cfg_lib = 'lib/';

// 上传文件配置
$cfg_max_upload_file_size = 3*1024*1024;	// 上传文件尺寸的上限，单位为字节。当前为3兆
$cfg_upload_dir = $cfg_webRoot."uploads/";
$cfg_upload_img_dir = $cfg_upload_dir."images/";
$cfg_upload_img_ar_dir = $cfg_upload_img_dir."ar/";	// 文章配图上传目录
$cfg_upload_img_aw_dir = $cfg_upload_img_dir."aw/";	// 古董图片上传目录
$cfg_la_dir = "la/";	// 古董图片大图上传目录
$cfg_mi_dir = "mi/";	// 古董图片中图上传目录
$cfg_sm_dir = "sm/";	// 古董图片小图上传目录
$cfg_upload_article_dir = $cfg_upload_dir."articles/";

// smtp  设置

// 分页配置
$cfg_aw_per_page = 4;	// 艺术品列表每页显示数量
$cfg_ar_per_page = 4;	// 文章列表每页显示数量
$cfg_ms_per_page = 6;	// 留言列表每页显示数量


?>
