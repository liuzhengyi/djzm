<?php
session_start();
include('config.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<!-- 四角的装饰图案
		<div class="content_block_bg_top"></div> <div class="content_block_bg_left"></div>
		<div class="content_block_bg_bottom"></div> <div class="content_block_bg_right"></div>
		<img class="content_block_top_left" src="pic/content_block_top_left.gif" />
		<img class="content_block_top_right" src="pic/content_block_top_right.gif" />
		<img class="content_block_bottom_left" src="pic/content_block_bottom_left.gif" />
		<img class="content_block_bottom_right" src="pic/content_block_bottom_right.gif" />
		 内容方格四角的装饰图案 -->
		<h4 id="main_content_head"> 关于我们 </h4>

		<hr />
		<p>大将之门艺术网是以书画收藏和交流为目的的个人网站，画廊本着弘扬民族文化，促进书画艺术的繁荣和发展，以诚信为本广交朋友的原则；以经营现代名家书画为主，向广大书画爱好者和藏家提供精美的书画作品和优质的服务，同时本画廊提供字画鉴定咨询服务。</p>
		<p>郑重承诺</p>
		<ol>
		<li>所售的每幅作品都向画家负责，向买家负责，向后人负责。让你买的放心，使我卖的安心。</li>
		<li>依靠诚信经营，创造诚信品牌，弘扬诚信观念。   </li>
		<li>所售书画作品在无损坏的前提下，可在售后十五天内无条件退换。</li>
		<li>所售作品本画廊出自“收藏证书”一个，请妥善保管。是作品终生保真的一个凭证。款到当日，作品经精心包装后，以特快专递寄往贵处</li>
		</ol>
	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
