<?php
session_start();
include('../config.php');
include($cfg_webRoot.$cfg_lib.'debug.php');
$_SESSION = array();
if(ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time()-42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
session_destroy();
$to_url = $cfg_siteRoot;
lib_delay_jump(3, '您已登出', $to_url);
header("Location: $cfg_siteRoot");
exit();
?>
