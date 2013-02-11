	<div id="clear_line" class="clear_line">
	<hr color="black" />
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
	<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="message.php" >联系我们</a>&nbsp;&nbsp;&nbsp;&nbsp;</li>
	<li><a href="about.php" >了解我们</a>&nbsp;&nbsp;&nbsp;&nbsp;</li>
	</ul>
	<p>copyright Justice NJAU CS91</p>
	</div> <!-- end of DIV copyright -->
