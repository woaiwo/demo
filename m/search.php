<?
require("../init.php");

$menu			= "search";
$base_name		= "信息搜索";
$second_name	= "信息搜索";

$search		= htmlspecialchars(trim($_GET["search_keyword"]));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="skin/base.css" />
<link rel="stylesheet" href="skin/swiper.min.css" />
<link rel="stylesheet" href="skin/color<?=$config_color?>/css.css" />
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
			<h2><?=$second_name?></h2>
		</div>
		<div class="bd">
           <ul class="m-list">
                <?
				$sql = "select count(*) as cnt from info where title like '%$search%' and state>0  ";
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

				$sql = "select id, title, pic, create_time, content from info where title like '%$search%' and state>0  order by sortnum desc";
				$sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
				$rst = $db->query($sql);
				$i=1;
				while ($row = $db->fetch_array($rst)) {
					$publishdate = explode(' ', $row['create_time']);
				?>
				<li><a href="display.php?id=<?=$row['id']?>"><?=$row['title']?></a></li>
				<?
				$i++;
				}
				?>
            </ul>
            <p class="page"><?=page2($page, $pageCount, "search.php")?></p>
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