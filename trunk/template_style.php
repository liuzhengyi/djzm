<?php
session_start();
include('config.php');
?>
<!DOCTYPE html 
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- Transitional DTD可包含W3C所期望移入样式表的呈现属性和元素，如果您的读者使用了不支持层叠样式表的浏览器以至于您 -->
<!-- 不得不使用xhmtl的呈现特性的时候，请使用此类型 -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>古音数字美术馆</title>
	<link rel="stylesheet" href="<?php echo $cfg_siteRoot; ?>style.css" type="text/css" />
</head>

<body>
<div id="header">
	<div id="header_logo">
	<p>header_logo</p>
	</div> <!-- end of DIV header_logo -->
	<div id="main_menu">
	<ul>
		<li>藏品介绍</li>
		<li>书画知识</li>
		<li>收藏知识</li>
		<li>学术研究</li>
		<li>关于本馆</li>
		<li>最新公告</li>
		<li>在线留言</li>
		<li>联系我们</li>
	</ul>
	</div> <!-- end of DIV main_menu -->
	<div id="header_navi" class="header_block" >
		<!-- 标题方格的边界 border of header_block  start -->
		<img class="header_block_left" src="pic/header_block_left.gif" />
		<img class="header_block_right" src="pic/header_block_right.gif" />
		<!-- 标题方格的边界 border of header_block  end -->
		<p>您当前的位置：馆藏精品 - 山水中国 - 张大千 </p>
	</div> <!-- end of DIV header_navi -->
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
		<h4 id="main_content_head">馆藏精品</h4>
		<hr />
		<ul id="production_list">
		<li><div class="production_nail" id="work01"><img src="pic/work01.jpg" width="120" /><p>著名艺术家涂鸦</p></div> </li>
		<li><div class="production_nail" id="work02"><img src="pic/work02.jpg" width="120" /><p>XXX成名作</p></div> </li>
		<li><div class="production_nail">作品3</div> </li>
		<li><div class="production_nail">作品4</div> </li>
		<li><div class="production_nail">作品5</div> </li>
		<li><div class="production_nail">作品6</div> </li>
		<li><div class="production_nail">作品7</div> </li>
		<li><div class="production_nail">作品8</div> </li>
		<li><div class="production_nail">作品9</div> </li>
		<li><div class="production_nail">作品10</div> </li>
		<li><div class="production_nail">作品11</div> </li>
		</ul>
		<hr class="clear_line"/>
		<p>共xx页 当前第1页。</p>
		<p>转至第 <u>1</u> <u>2</u> <u>3</u> <u>x</u> <u>x</u> 页。</p>
	</div> <!-- end of DIV main_content -->
	<div id="non_main_content" >
		<div id="header_of_sub_menu" class="header_block" >
			<!-- 标题方格的边界 border of header_block  start -->
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<!-- 标题方格的边界 border of header_block  end -->
			<p>馆藏精品 </p>
		</div> <!-- end of DIV header_of_sub_menu -->
		<div id="sub_menu" class="content_block">
			<!-- 内容方格四角的装饰图案 
			<div class="content_block_bg_top"></div> <div class="content_block_bg_left"></div>
			<div class="content_block_bg_bottom"></div> <div class="content_block_bg_right"></div>
			<img class="content_block_top_left" src="pic/content_block_top_left.gif" />
			<img class="content_block_top_right" src="pic/content_block_top_right.gif" />
			<img class="content_block_bottom_left" src="pic/content_block_bottom_left.gif" />
			<img class="content_block_bottom_right" src="pic/content_block_bottom_right.gif" />
			 内容方格四角的装饰图案 -->
		<ul>
			<li>sub menu 1</li>
			<li>sub menu 2</li>
			<li>sub menu 3</li>
			<li>sub menu 4</li>
		</ul>
		</div> <!-- end of DIV sub_menu -->
		<div id="header_of_item_search" class="header_block" >
			<!-- 标题方格的边界 border of header_block  start -->
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<!-- 标题方格的边界 border of header_block  end -->
			<p>搜索馆藏 </p>
		</div> <!-- end of DIV header_of_item_search -->
		<div id="item_search" class="content_block">
			<!-- 内容方格四角的装饰图案 
			<div class="content_block_bg_top"></div> <div class="content_block_bg_left"></div>
			<div class="content_block_bg_bottom"></div> <div class="content_block_bg_right"></div>
			<img class="content_block_top_left" src="pic/content_block_top_left.gif" />
			<img class="content_block_top_right" src="pic/content_block_top_right.gif" />
			<img class="content_block_bottom_left" src="pic/content_block_bottom_left.gif" />
			<img class="content_block_bottom_right" src="pic/content_block_bottom_right.gif" />
			 内容方格四角的装饰图案 -->
			<form action="#" method="POST">
				关键字：<input size="10" />
				<input type="submit" value="搜索" />
			</form>
		</div> <!-- end of DIV item_search -->
		<p><a href="master_login.php">管理员登录</a></p>
		<!-- 会员注册登录模块 暂未启用
		<div id="header_of_login_reg" class="header_block" >
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<p>会员注册 </p>
		</div> 
		<div id="login_reg" class="content_block">
			<div class="content_block_bg_top"></div> <div class="content_block_bg_left"></div>
			<div class="content_block_bg_bottom"></div> <div class="content_block_bg_right"></div>
			<img class="content_block_top_left" src="pic/content_block_top_left.gif" />
			<img class="content_block_top_right" src="pic/content_block_top_right.gif" />
			<img class="content_block_bottom_left" src="pic/content_block_bottom_left.gif" />
			<img class="content_block_bottom_right" src="pic/content_block_bottom_right.gif" />
		<p>login_reg</p>
		</div>
		-->
	</div> <!-- end of DIV non_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
	<div id="clear_line" class="clear_line">
	<hr color="black" />
	</div><!-- end of DIV clear_line -->
	<div id="copyright">
	<p>copyright</p>
	</div> <!-- end of DIV copyright -->
</div> <!-- end of DIV footer -->
</body>
</html>
