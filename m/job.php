<?
require("../init.php");

$base_name	  = "人力资源";
$base_en_name = "Job";
$menu 		  = "job";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="skin/base.css" />
<link rel="stylesheet" href="skin/swiper.min.css" />
<link rel="stylesheet" href="skin/red/css.css" />
<script src="js/jquery.min.js"></script>
<script src="js/swiper.min.js"></script>
<? echo $config_webJavascriptHead;?>
</head>
<body>
<?
require_once("nav.php");
?>
<div id="g-wp" class="g-wp">
	<?
    require_once("begin.php");
    ?>
	<div class="u-tt box box-isd">
		<div class="hd">
			<p class="col" id="m-col"><a href="javascript:;">栏目</a></p>
			<h2><?=$base_name?></h2>
		</div>
		<div class="bd">
			<?
	        require_once("left.php");
	        ?>
           <ul class="m-list">
            <?
			$sql = "select count(*) as cnt from job where state=1";
			$rst = $db->query($sql);
			if ($row = $db->fetch_array($rst)) {
				$recordCount = $row["cnt"];
			} else {
				$recordCount = 0;
			}

			$page		= (int)$_GET["page"];
			$page		= $page > 0 ? $page : 1;
			$pageSize	= 10;
			$pageCount	= ceil($recordCount / $pageSize);
			if ($page > $pageCount) $page = $pageCount;

			$sql = "select * from job where state=1 order by sortnum desc limit ".$pageSize*($page-1).",".$pageSize;
			$rst = $db->query($sql);
			while ($row = $db->fetch_array($rst)) {
			?>
			<li><a href="job_display.php?id=<?=$row['id']?>"><?=$row['name']?></a></li>
			<?
			}
			?>
            <div class="page"><span><?=page2($page, $pageCount, "job.php?")?>
		</div>
	</div>
	<?
    require_once("end.php");
    ?>
</div>
<script>
$(function(){
	var _menu = $('.m-menu')
	$('.box-isd .col').on('click', function(){
		$('body').toggleClass('m-nav-show')
		_menu.stop().animate({right:0,opacity:1});
	})
	$('.m-mask').on('click', function(){
		$('body').removeClass('m-nav-show')
		_menu.stop().animate({right:'-50%',opacity:0});
	})
})
</script>
</body>
</html>