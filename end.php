<?
	$config_copyright = str_replace("{ICP备案}","<a href='http://www.miitbeian.gov.cn/' target='_blank'>".$config_icp."</a>",$config_copyright);
	$config_copyright = str_replace("{免责声明}","<a href='http://www.ibw.cn/mianze.htm' target='_blank'>免责声明</a>",$config_copyright);
	$config_copyright = str_replace("{设计制作}","网站设计制作：<a href='http://www.ibw.cn' target='_blank'>网新科技(www.ibw.cn)</a>",$config_copyright);
?>

	<div class="footer">
		<div class="wrap">
			<div class="ftNav"><a href="#">网站首页</a>|<a href="#">关于我们</a>|<a href="#">业务介绍</a>|<a href="#">新闻实讯</a>|<a href="#">成功案例</a>|<a href="#">人才招聘</a>|<a href="#">联系我们</a></div>
			<div class="copy"><?echo $config_copyright?></div>
			<div class="ftContact"><?echo $config_contact?></div>
		</div>
	</div>
</div>
<script>
	$.ajax({ url: 'hit_counter.php', data: { page: document.location.pathname } }) 
</script>
<?
$db->close();
echo $config_javascriptFoot;
?>