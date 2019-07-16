<div class="m-copy">
	<p>&copy; <?=$config_name?> 版权所有 <a href="http://www.miitbeian.gov.cn" target="_blank"><?=$config_icp?></a></p>
	<p>网站设计制作：<a href="http://www.ibw.cn" target="_blank">网新科技(www.ibw.cn)</a></p>
</div>
<ul id="fixed-foot">
	<li><a class="tel" href="./"><span class="fixed-button li-01"></span>主页</a></li>
	<li><a href="sitemap.php"><span class="fixed-button li-02"></span>分类</a></li>
	<li><a href="message.php"><span class="fixed-button li-03"></span>留言</a></li>
	<li><a href="###"><span class="fixed-button li-04"></span>联系</a></li>
</ul>
<div class="u-mask hide"></div>
<script>
$(function(){
	$('.search-o').bind('click', function () {
		$(this).css({"left":-50,"opacity":0}).next('.search-x').css({"left":0,"opacity":1});
		$('.form-search').css({"top":78,"opacity":1});
	})
	$('.search-x').bind('click', function () {
		$(this).css({"left":-50,"opacity":0}).prev('.search-o').css({"left":0,"opacity":1});
		$('.form-search').css({"top":-100,"opacity":0});
	})
	$('.u-menu').bind('click', function () {
		$('body').addClass('z-open');
		$('.u-mask').removeClass('hide');
	})
	$('.box-isd .col').bind('click', function () {
		$('body').toggleClass('m-nav-show');
		$('.u-mask').removeClass('hide');
		$('.m-menu').stop().animate({right:0,opacity:1});
	})
	$('.u-mask').bind('click', function () {
		$('body').removeClass('z-open');
		$('body').removeClass('m-nav-show');
		$('.u-mask').addClass('hide');
		$('.m-menu').stop().animate({right:'-50%',opacity:0});
	})
})
</script>
<?
$db->close();
echo $config_webJavascriptFoot;
?>