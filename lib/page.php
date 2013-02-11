<?php
/*
 * 控制分页栏的显示
 * 
 * @param string $url 给翻页链接用的url，直接在后面跟页码即可构成完整的url
 * @param int $total_page 总页数
 * @param int $current_page 当前页码
 * @param bool $middle 是否显示中间页码，为false时只显示'上一页''下一页'链接
 * 	默认为true
 * return void
 *
 * written by gipsaliu(at)gmail(dot)com on 2012-12-17
 */
function lib_dump_page_bar($url, $total_page, $current_page, $middle=TRUE)
{	if($current_page-- > 1) {
		echo '<li><a href="'.$url.$current_page.'">上一页</a>&nbsp;&nbsp;&nbsp;</li>';
	}
	$current_page++;
	if($middle) {
		for($p = 1; $p <= $total_page; $p++) {
			if($p != $current_page) {
				echo '<li><a href="'.$url.$p.'">第'.$p.'页</a>&nbsp;&nbsp;&nbsp;</li>';
			} else {
				echo "<li>第$p 页&nbsp;&nbsp;&nbsp;</li>";
			}
		}
	}
	if($current_page++ < $total_page)
	{	echo '<li><a href="'.$url.$current_page.'">下一页</a></li>';
	}
	$current_page--;
}
?>
