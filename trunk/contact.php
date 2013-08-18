<?php
session_start();

error_reporting(E_ERROR); //报告严重错误

include('config.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}
?>

<?php require('include/dochead.php'); ?>
<link rel="stylesheet" href="styles/newinnerpage.css" type="text/css" />
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<!-- 四角的装饰图案
		 内容方格四角的装饰图案 -->
		<h4 id="main_content_head"> 联系我们 </h4>

		<hr />
		<p>电话：18105163676</p>
		<p>Email： imageink@126.com</p>
		<p>QQ:   954626665</p>
		<p>地址：南京市苜蓿园大街77号紫金名门</p>
	</div> <!-- end of DIV main_content -->
	<div id="navi" >
<?php require('./include/navi.php'); ?>
	</div> <!-- end of DIV navi -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
