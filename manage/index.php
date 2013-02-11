<?php session_start(); 
if(isset($_SESSION['mname'])) {
	$name = $_SESSION['mname'];
} else {
	$name = '无名用户';	// 这应该引发一个错误
}
if('yes' == $_SESSION['is_primary']) {
	$master_type = '主管理员';
} else {
	$master_type = '副管理员';
}
?>

<!DOCTYPE html 
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- Transitional DTD可包含W3C所期望移入样式表的呈现属性和元素，如果您的读者使用了不支持层叠样式表的浏览器以至于您 -->
<!-- 不得不使用xhmtl的呈现特性的时候，请使用此类型 -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>古音控制台</title>
	<link rel="stylesheet" href="manage/style.css" type="text/css" />
</head>

<body>
<h2>欢迎来到网站管理中心，<?php echo $name; ?>，您是<?php echo $master_type; ?>。</h2>
<ul>
<li><a href="./artwork_list.php" >艺术品列表</a></li>
<li><a href="./article_list.php" >文章列表</a></li>
<li><a href="./message_list.php" >留言列表</a></li>
<li><a href="./master_list.php" >管理员列表</a></li>
</ul>
</body>
