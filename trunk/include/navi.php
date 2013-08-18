		<!-- submenu -->
		<div id="sub_menu" class="content_block">
		<ul>
			<li><a href="index.php">首页</a></li>
			<li><a href="artwork.php?type=all">藏品展示</a></li>
			<li><a href="artwork.php?type=sale">艺术品交流</a></li>
			<li><a href="article.php?type=artist">名家推荐</a></li>
			<li><a href="article.php?type=artview">艺术视角</a></li>
		<!--	<li><a href="features.php">特色服务</a></li> -->
			<li><a href="message.php">在线留言</a></li>
			<li><a href="about.php">关于我们</a></li>
		</ul>
		</div> <!-- end of DIV sub_menu -->

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

		<!-- console -->
		<?php if(isset($_SESSION['mname'])) { ?>
		<div id="header_of_console" class="header_block">
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

