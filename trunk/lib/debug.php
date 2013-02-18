<?php
/*
 * 本文件包含跟错误处理以及调试有关的自定义函数
 */

/**
 * 写日志函数
 * written by gipsaliu(at)gmail(dot)com on 2012-12-17
 *
 * @param string $msg   要写入日志的信息
 * @param string log_file     日志文件路径，相对于根目录$siteRoot
 * 尚未完成
 */
function lib_write_log($msg, $log_file='doc/log_file')
{
    global $webRoot;
    $log_path = $webRoot.'doc/log_file';
    $log_msg = 'error message:'.$msg."\n";
    $log_fh = fopen($log_path, 'a');    // write without read, create if need
    if(!$log_fh = fopen($log_path, 'a')) {
    // cant open log file for writing
    }
    if(FALSE === fwrite($log_fh, $log_msg)) {
    // cant write log msg into log file
    }
    fclose($log_fh);
}

/**
 * 调试函数
 * written by gipsaliu(at)gmail(dot)com on 2012-12-17
 *
 * @param string $debug_msg DEBUG信息
 * @param bool $to_user 当不处于DEBUG模式时，是否要向用户提示出错，默认为TURE
 * @param string $level 错误级别，记录日志时使用，默认为'error'('fatal', 'notice')
 *          notice: 可能是错误，不影响程序继续执行
 *          error:  错误，程序可以继续执行下去
 *          fatal:  严重错误，程序不能继续执行，需要退出或跳转
 * @return 
 * 注意：正式运行时，有些错误信息应该发送到管理员邮箱和/或写入日志
 */
function lib_debug($debug_msg, $file=NULL, $line=NULL, $to_user=TRUE, $level="error")
{	
    $debug_msg = 'debug: '.'file:'.$file .' line: ' . $line .$debug_msg.' Time:'.date('Y-m-d H:i:s');
    lib_write_log($debug_msg);
    if(DEBUG) {
		echo $debug_msg;
		exit();
	} else if($to_user) {
		echo "<p>something wrong, please wait for a moment.</p>";
	} else {
		echo "";
	}
    if('fatal' == $level) {
        global $siteRoot;
        header("Location:$siteRoot");
        exit();
    }
}


/*
 * 延迟跳转函数
 * written by gipsaliu(at)gmail(dot)com on 2012-12-17
 * 
 * 作用： 输出跳转提示信息，利用header，若干秒后跳转。
 *
 * 用处：一般用在action中，因为本身没有产生新页面，而跳转后会exit当前页面。
 * 注意：不应用于debug函数，因为debug函数不会仅用于action中。
 *
 */
function lib_delay_jump($seconds=0, $msg, $to_url='http://r52/djzm/', $to_name='系统主页', $color='blue')
//function lib_delay_jump($seconds=0, $msg, $to_url='http://r52/guyin/', $to_name='系统主页', $color='blue')
//function lib_delay_jump($seconds=0, $msg, $to_url='http://djzm.ucart.tw/', $to_name='系统主页', $color='blue')
{
    $seconds = intval($seconds);
    header("refresh:$seconds;url=$to_url");
//    header("Content-Type:text/html;charset=utf8");
	echo '<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8" /></head>';
//    echo '<html><head><link ref="stylesheet" href="http://vdl.viivtech.com/style/page_control.css" type="text/css" /></head>';
    echo '<body><h2>友情提示</h2>';
    echo "<p>$msg</p>";
    echo '<hr />';
    echo "<p>$seconds 秒钟后返回 $to_name 页面，或<a href=\"$to_url\">点此</a>立即返回。</p></body></html>";
    exit();
}

/*
 * 数据库错误(PDO)处理函数
 * written by gipsaliu(at)gmail(dot)com on 2013-01-07
 *
 * 作用： 当检测到数据库调用(using PDO MySQL )出错时，根据要求输出提示或调试信息
 * @param boolean $is_succ PDOStatement::execute()的返回值
 * @param source(PDOStatement) $sth PDOStatement对象
 * @param bool $to_user 当不处于DEBUG模式时，是否要向用户提示出错，默认为TURE
 * @param string $level 错误级别，记录日志时使用，默认为'error'('fatal', 'notice')
 *          notice: 不重要错误，不影响程序继续执行
 *          error:  普通错误，程序可以继续执行下去
 *          fatal:  严重错误，程序不能继续执行，需要退出或跳转
 * @return 
 */
function lib_pdo_if_fail($is_succ, $sth, $file=NULL, $line=NULL, $debug=FALSE, $level='error', $to_user=FALSE ) {
	if(!$is_succ) {
		if($debug) {
			echo "<h3>pdo execute 失败 at line $file on line $line <h3>";
			echo '<p>errorInfo:</p>';
			echo '<pre>'; var_dump($sth->errorInfo()); echo '</pre>';
			echo '<p>debugDumpParams:</p>';
			echo '<pre>'; $sth->debugDumpParams(); echo '</pre>';
			exit();
		} else {	// !!
			$msg = "<h3>对不起，您所访问的页面出错了，3秒后跳回至主页（暂时实现）</h3>";
			lib_delay_jump(3, $msg);
			
		}
	} else {
		return $is_succ;
	}
}

?>
