<?
require("../init.php");
$menu 		= "sitemap";
$base_name  = "分类信息";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$base_name?> - <?=$config_name?></title>
<meta name="keywords" content="<?=$config_keyword?>" />
<meta name="description" content="<?=$config_description?>" />
<link rel="stylesheet" href="skin/base.css" />
<link rel="stylesheet" href="skin/swiper.min.css" />
<link rel="stylesheet" href="skin/blue/css.css" />
<script src="js/jquery.min.js"></script>
<script src="js/swiper.min.js"></script>
<? echo $config_webJavascriptHead;?>
</head>
<body>
<?
require("nav.php");
?>
<div id="g-wp" class="g-wp">
<?
require_once("begin.php");
?>
<div class="u-tt box box-isd">
	<div class="hd">
		<h2>栏目分类</h2>
	</div>
	<div class="bd">
		<?
		require_once("left.php");
		?>
		<div class="webmap">
			<dl>
				<dt><a href="./">网站首页</a></dt>
			</dl>
			<?
				for($i=0; $i<5; $i++){
			?>
			<dl>
				<dt><a href="info.php?class_id=<?=$baseClassArray[$i]['id']?>"><?=$baseClassArray[$i]['name']?></a></dt>
				<dd class="clearfix">
					<?
						$sql ="select id, name from info_class where id like '". $baseClassArray[$i]['id'] ."___' order by sortnum asc";
						$rst = $db -> query($sql);
						while ($row = $db -> fetch_array($rst)){
					?>
					<a href="info.php?class_id=<?=$row["id"]?>"><?=$row["name"]?></a>
					<?
						}
					?>
				</dd>
			</dt>
			<?
				}
			?>
		</div>
	</div>
</div>
<?
require_once("end.php");
?>
</div>