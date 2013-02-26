
		<!-- console -->
		<?php if(isset($_SESSION['mname'])) { ?>
		<div id="header_of_console" class="header_block">
			<!-- 标题方格的边界 border of header_block  start -->
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<!-- 标题方格的边界 border of header_block  end -->
			<p>管理员控制台</p>
		</div> <!-- end of DIV header_of_console -->
		<div id="console" class="content_block">
		<ul>
			<li><?php echo $control_artwork; ?></li>
			<li><?php echo $control_article; ?></li>
			<li><?php echo $control_type; ?></li>
			<li><?php echo $control_message; ?></li>
			<li><?php echo $master_logio; ?></li>
		</ul>
		</div> <!-- end of DIV console -->
		<?php } ?>

		<!-- submenu -->
		<div id="header_of_sub_menu" class="header_block" >
			<!-- 标题方格的边界 border of header_block  start -->
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<!-- 标题方格的边界 border of header_block  end -->
			<p>馆藏精品 </p>
		</div> <!-- end of DIV header_of_sub_menu -->
		<div id="sub_menu" class="content_block">
		<ul>
			<li>sub menu 1</li>
			<li>sub menu 2</li>
			<li>sub menu 3</li>
			<li>sub menu 4</li>
		</ul>
		</div> <!-- end of DIV sub_menu -->

		<!-- search -->
		<div id="header_of_item_search" class="header_block" >
			<!-- 标题方格的边界 border of header_block  start -->
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<!-- 标题方格的边界 border of header_block  end -->
			<p>搜索馆藏 </p>
		</div> <!-- end of DIV header_of_item_search -->
		<div id="item_search" class="content_block">
			<form action="search.php" method="POST">
				检索要素： <select name="type">
				<option value='author'>作者姓名</option>
				<option value='period'>作者时期</option>
				<option value='name'>作品名称</option>
				<option value='type'>作品类型</option>
				</select>
				关键字：<input name="key" size="10" />
				<input type="submit" value="搜索" />
			</form>
		</div> <!-- end of DIV item_search -->

		<!-- 会员注册登录模块 暂未启用
		<div id="header_of_login_reg" class="header_block" >
			<img class="header_block_left" src="pic/header_block_left.gif" />
			<img class="header_block_right" src="pic/header_block_right.gif" />
			<p>会员注册 </p>
		</div> 
		<div id="login_reg" class="content_block">
		<p>login_reg</p>
		</div>
		-->
