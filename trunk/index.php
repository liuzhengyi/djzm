<?php
session_start();
include('config.php');
if(isset($_SESSION['mname'])) { // 已登录管理员
// 是管理员，提供管理员控制台变量
	require('include/console_var.php');
} else { // 非管理员
	$add_artwork	= '';
	$master_logio	= '(<a href="master_login.php">管理员登录</a>)';
	$add_article	= '';
	$add_type	= '';
}
?>

<?php require('include/dochead.php'); ?>
<link rel="stylesheet" href="styles/newmain.css" type="text/css" />
<script src="scripts/slide_show.js" type="text/javascript" ></script>
<link rel="stylesheet" href="styles/slide_show.css" type="text/css" />
<link rel="stylesheet" href="styles/index.css" type="text/css" />
<!--
<style>
img#indeximg {
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; /* ie8  */
    filter:alpha(opacity=50);    /* ie5-7  */
    opacity: 0.5;    /* css standard, currently it works in most modern browsers  */
}
</style>
-->
</head>
<body>
<div id="body" >
<!--	<img id="indeximg" src="../pic/new/mainback.png" usemap="#indexmap" style="z-index:-1; position:absolute;" /> -->
<!--	<img id="indeximg" src="../pic/new/index_with_menus.png" /> -->
	<img id="indeximg" src="./pic/new/index_final.png" align="middle" usemap="#indexmap" />
	<map name="indexmap" id="indexmap" >
	<area shape="rect" coords="950,624,1020,647" href="article.php?type=artview" alt="艺术视角" />
	<area shape="rect" coords="850,624,920,647" href="article.php?type=artist" alt="名家推荐" />
	<area shape="rect" coords="730,624,820,647" href="artwork.php?type=sale" alt="艺术品交流" />
	<area shape="rect" coords="630,624,705,647" href="artwork.php?type=all" alt="精品典藏" />
	<area shape="rect" coords="530,624,605,647" href="about.php" alt="关于我们" />
	<area shape="rect" coords="465,624,500,647" href="index.php" alt="首页" />
	</map>
</div> <!-- end of DIV body -->

<div id="footer">
<?php require('./include/footer.index.php'); ?>
</div> <!-- end of DIV footer -->
</body>
</html>
