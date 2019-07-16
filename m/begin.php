<?
    $sql = "select pic from banner where class_id = 3 and state>0 and pic<>'' order by sortnum desc";
    $rst = $db->query($sql);
    if ( $row = $db->fetch_array($rst) ) {
    	$logo = $row["pic"];
    }
?>
<div id="header" style="background:url(<?=UPLOAD_PATH . $logo?>) no-repeat center top; background-size:contain;">
	<div class="u-menu">
		<div class="u-menu-top"><i></i></div>
		<div class="u-menu-middle"><i></i></div>
		<div class="u-menu-bottom"><i></i></div>
	</div>
	<div class="search">
		<div class="search-o"></div>
		<div class="search-x"></div>
	</div>
</div>
<form action="search.php" method="get" class="form-search" onsubmit="if(this.search_keyword.value == '' || this.search_keyword.value == '请输入搜索关键字'){ alert('搜索关键字不能为空！'); this.search_keyword.focus(); return false; }">
	<input type="text" name="search_keyword" value="" placeholder="请输入搜索关键字" />
	<input type="submit" value="搜索" />
</form>
<div class="swiper-container swiper-container-1">
	<div class="swiper-wrapper">
		<?
		    $sql = "select url, title, pic from banner where class_id = 3 and state>0 and pic<>'' order by sortnum desc";
		    $rst = $db->query($sql);
		    while ( $row = $db->fetch_array($rst) ) {
	    ?>
		<div class="swiper-slide"><a href="<?=$row["url"]?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" alt="<?=$row["title"]?>" /></a></div>
		<?
			}
		?>
	</div>
	<div class="swiper-pagination swiper-pagination-1"></div>
</div>
<script>
var swiper1 = new Swiper('.swiper-container-1', {
	pagination: '.swiper-pagination-1',
	slidesPerView: 1,
	paginationClickable: true,
	spaceBetween: 30,
	loop: true
});
</script>