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
<script src="scripts/slide_show.js" type="text/javascript" ></script>
<link rel="stylesheet" href="styles/slide_show.css" type="text/css" />
<link rel="stylesheet" href="styles/index.css" type="text/css" />
</head>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
	<!--
		<h4 id="main_content_head">馆藏精品</h4>
		<hr />
		-->
		<div id="main_recom" name="main_recom">
		<h3>公告</h3>
		<p>大将之门艺术网是以书画收藏和交流为目的的个人网站，画廊本着弘扬民族文化，促进书画艺术的繁荣和发展，以诚信为本广交朋友的原则；以经营现代名家书画为主，向广大书画爱好者和藏家提供精美的书画作品和优质的服务，同时本画廊提供字画鉴定咨询服务。</p>
		<h3>精品推荐</h3>
		<p>大将之门艺术网是以书画收藏和交流为目的的个人网站，画廊本着弘扬民族文化，促进书画艺术的繁荣和发展，以诚信为本广交朋友的原则；以经营现代名家书画为主，向广大书画爱好者和藏家提供精美的书画作品和优质的服务，同时本画廊提供字画鉴定咨询服务。</p>
		</div> <!--main_recom-->
		<div id="box1" name="slide" class="slide_show">
			<ul class="list">
				<li class="current"><img src="./uploads/images/aw/la/佛教艺术品_large.jpg" width="290" height="370" /></li>
				<li><img src="./uploads/images/aw/la/蓝瓶_large.jpg" width="290" height="370" /></li>
				<li><img src="./uploads/images/aw/la/元青花“鬼谷子下山”_large.jpg" width="290" height="370" /></li>
			</ul>
			<ul class="count">
				<li class="current">1</li>
				<li>2</li>
				<li>3</li>
			</ul>
		</div>
		<!--
		<div id="box2" name="slide" class="slide_show">
			<ul class="list">
				<li class="current"><img src="./uploads/images/aw/la/抵柱铭_large.jpg" width="290" height="370" /></li>
				<li><img src="./uploads/images/aw/la/平定西域献俘礼图_large.jpg" width="290" height="370" /></li>
				<li><img src="./uploads/images/aw/la/局事贴_large.jpg" width="290" height="370" /></li>
			</ul>
			<ul class="count">
				<li class="current">1</li>
				<li>2</li>
				<li>3</li>
			</ul>
		</div>
		-->
		<hr class="clear_line"/>
	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>