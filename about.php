<?php
session_start();


error_reporting(E_ERROR); //报告严重错误
/*
ini_set('display_errors', 0); //但不显示默认的错误信息
function shutdown() {
    $error = error_get_last();
    if ($error['type']==E_ERROR) { //当出现严重错误就say sorry
//        die("Sorry. The server encounters an error. We'll fix it soon.");
        var_dump("Sorry. The server encounters an error. We'll fix it soon.");
    }
}
function shutdown2() {echo 'shutdown2 is executed.';}
register_shutdown_function('shutdown');
register_shutdown_function('shutdown2');
*/

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
		<h4 id="main_content_head"> 关于我们 </h4>

		<hr />
		<p>藻鉴堂艺术网是以书画收藏和交流为目的的当代书画艺术网站。藻鉴堂艺术网本着弘扬民族传统文化，促进书画艺术的繁荣和发展，以诚信为本广交朋友；以经营现代名家书画为主，强调藏品的艺术性、观赏性及收藏价值，向广大书画爱好者和藏家提供精美的书画作品和优质的服务，所有作品均为名家真迹，货真价实，绝无赝品，具有极高的增值空间。</p>
		<p>郑重承诺</p>
		<ol>
		<li>所售的每幅作品都向画家负责，向买家负责，向后人负责。让你买的放心，使我卖的安心。</li>
		<li>依靠诚信经营，创造诚信品牌，弘扬诚信观念。   </li>
		<li>所售书画作品在无损坏的前提下，可在售后十五天内无条件退换。</li>
		<li>款到当日，作品经精心包装后，以特快专递寄往贵处</li>
		</ol>
	</div> <!-- end of DIV main_content -->
	<div id="navi" >
<?php require('./include/navi.php'); ?>
	</div> <!-- end of DIV navi -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
