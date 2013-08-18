
		<!-- submenu -->
		<div id="main_menu">
		<div id="sub_menu" class="content_block">
		<ul>
			<p><li>menu 1</li></p>
			<p><li>menu 2</li></p>
			<p><li>menu 3</li></p>
			<p><li>menu 4</li></p>
			<p><li>menu 5</li></p>
			<p><li>menu 6</li></p>
		</ul>
		</div> <!-- end of DIV sub_menu -->

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
		</div> <!-- end of DIV main_menu -->
