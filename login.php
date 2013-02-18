<?php
session_start();
require('./config.php');
?>
<!DOCTYPE html 
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head xmlns="http://www.w3.org/1999/xhtml">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>管理员登录</title>
	<link rel="stylesheet" type="text/css" href="styles/login.css" />

</head>
<body>
<div id="error">
<?php
if( isset($_GET['error']) ) {
	$error = $_GET['error'];
	switch ($error) {
		case 'notmatch' :
			echo '<p><em>您输入的用户名或密码有误！</em></p>';
			break;
		case 'incomplete' :
			echo '<p><em>请输入用户名，密码和五位验证码！</em></p>';
			break;
		case 'wrongcode' :
			echo '<p><em>请输入正确的五位验证码，看不清楚请刷新页面！</em></p>';
			break;
	}
}
?>
</div>
</div> <!-- end of DIV header -->
<form action="action/login.php" method="post">
<span text-color="red">验证图片</span><a href="login.php?rand=<?php echo rand(); ?>"><img src="lib/verify_code.php" />点击图片换一张</a><br />
验证字符<input type="text" name="veri_code" required="required" placeholder="输入上图中字符，不分大小写" /><br />
登录名称<input type="text" name="user_name" placeholder="请输入您的用户名" /><br />
登录密码<input type="password" name="pass_word" placeholder="请输入您的密码" /><br />
<input type="submit" name="submit" value="登录" />
</form>
</body>
</html>
