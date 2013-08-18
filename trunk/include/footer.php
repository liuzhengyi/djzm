	<div id="clear_line" class="clear_both">
	<hr color="white" />
	</div><!-- end of DIV clear_line -->
	<div id="copyright">
	<ul class="aclinic" id="foot_menu">
	<?php
	if( !isset($_SESSION['mname']) ) {
		echo '<li><a href="login.php" >管理员登录</a></li>';
	} else {
		echo '<li><a href="./action/logout.php" >管理员登出</a></li>';
	}
	?>
	<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.php" >联系我们</a>&nbsp;&nbsp;&nbsp;&nbsp;</li>
	<li><a href="about.php" >了解我们</a>&nbsp;&nbsp;&nbsp;&nbsp;</li>
	</ul>
	<!--<p>Tel:18105163676&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email: imageink@126.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QQ: 954626665</p> -->
	<p>藻鉴堂版权所有 Copyright 2007-2013 imageink.cn All Rights Reserved</p>
	<p id="footerurl">www.imagcink.cn 苏ICP 备 13020298 号-1</p>
	<br />
	<br />
	</div> <!-- end of DIV copyright -->
	<div id="footer_logo">
	<img src="./pic/new/inner_back_new.1092.bottom.png" />
	</div>
