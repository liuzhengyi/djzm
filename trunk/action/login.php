<?php
session_start();
require('../config.php');
require($cfg_webRoot.$cfg_lib.'debug.php');
if(isset($_POST['submit'])) {
	$name = trim($_POST['user_name']);
	$pass = trim($_POST['pass_word']);
	$code = strtolower( trim($_POST['veri_code']) );
	if(empty($name) || empty($pass) || empty($code) ) {
		echo '<p class="warning">请输入用户名，密码以及验证码</p>';
		header("Location:../login.php?error=incomplete");
	} else if ( $code !== strtolower($_SESSION['verifyCode']) ) {
		echo '<p class="warning">请输入正确的验证码</p>';
		header("Location:../login.php?error=wrongcode");
	} else {
		require($cfg_dbConfFile);
		$dbh = new PDO($dbcfg_dsn, $dbcfg_dbuser, $dbcfg_dbpwd);	// inited in dbConf.php
		$sql_check_exist = "select 1 as is_exist, master_id as mid, is_primary from Masters where master_name = '$name' and master_password = sha1('$pass')";
		$sth_check_exist = $dbh->prepare($sql_check_exist);
		lib_pdo_if_fail( $sth_check_exist->execute(), $sth_check_exist, __FILE__, __LINE__, CFG_DEBUG, 'error', FALSE );
		$check_exist = $sth_check_exist->fetch();
		if($check_exist['is_exist']) {
			echo "<h2>welcome, $name .</h2>";
			$_SESSION['mname'] = $name;
			$_SESSION['mid']   = $check_exist['mid'];
			if($check_exist['is_primary']) {
				$_SESSION['is_primary'] = true;
			} else {
				$_SESSION['is_primary'] = false;
			}
			// 获取 artwork_type 写入session
			$sql_select_artwork_type = 'select type_name_en, type_name_zh from ArtworkTypes limit 100';
			$sth_select_artwork_type = $dbh->prepare($sql_select_artwork_type);
			lib_pdo_if_fail(	$sth_select_artwork_type->execute(), $sth_select_artwork_type,
						__FILE__, __LINE__, CFG_DEBUG, 'error', FALSE
					);
			$artwork_types = array();
			while($artwork_type = $sth_select_artwork_type->fetch()) {
				$artwork_types[$artwork_type['type_name_en']] = $artwork_type['type_name_zh'];
			}
			$_SESSION['artwork_types'] = $artwork_types;
//			header("Location:../index.php");	// 登录之后跳到主页
			$to_url = '../index.php';
			lib_delay_jump(3, '您已登录管理员身份', $to_url);
		} else {
			header("Location:../login.php?error=notmatch");
		}
	}
}
?>
