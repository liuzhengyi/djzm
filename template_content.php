<?php
session_start();
include('config.php');
?>

<?php require('include/dochead.php'); ?>
</head>
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
		<h4 id="main_content_head">馆藏精品</h4>
		<hr />
		<ul id="production_list">
		<li><div class="production_nail" id="work01"><div class="nail_img"><img src="uploads/images/aw/la/抵柱铭_large.jpg" width="120" /></div><hr class="divide_img_txt" color="red" /><div class="nail_txt"><p>著名艺术家涂鸦</p></div></div> </li>
		<li><div class="production_nail" id="work02"><div class="nail_img"><img src="pic/work02.jpg" width="120" /></div><div class="nail_txt"><p>XXX成名</p></div></div> </li>
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
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
