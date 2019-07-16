<?
require("../init.php");
$menu = "default";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$config_title?></title>
<meta name="keywords" content="<?=$config_keywords?>" />
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
	require("begin.php");
	?>
	<div class="u-tt box">
		<div class="hd">
			<h2>集团概况<span>group profile</span></h2>
		</div>
		<div class="bd">
			<div class="m-art">
				<h3><?=$config_title?></h3>
				<div class="intro">
					<?
					    $sql = "select content from info where class_id = '101101' and state>0";
					    $rst = $db->query($sql);
					    if ( $row = $db->fetch_array($rst) ) {
				    ?>
					<p><?=utf8substr(strip_tags(str_replace("&emsp;","",$row["content"])),150)?>...</p>
					<?
						}
					?>
				</div>
			</div>
			<p class="about_more more-common-01"><a href="info.php?class_id=101">查看更多</a></p>
		</div>
	</div>
	<div class="u-tt box">
		<div class="hd">
			<h2>资讯列表<span>news center</span></h2>
		</div>
		<div class="bd">
			<ul class="m-list">
				<?
				    $sql = "select id, title, pic from info where class_id = '101101' and state>0 and pic<>'' order by state desc, sortnum desc limit 5";
				    $rst = $db->query($sql);
				    $i=1;
				    while ( $row = $db->fetch_array($rst) ) {
			    ?>
				<li><a href="display.php?id=<?=$row["id"]?>"><?=utf8substr(strip_tags(str_replace("&emsp;","",$row["title"])),26)?>...</a></li>
				<?
					$i+=1;
					}
				?>
			</ul>
			<p class="about_more more-common-01"><a href="info.php?class_id=101">查看更多</a></p>
		</div>
	</div>
	<div class="u-tt box">
		<div class="hd">
			<h2>公司动态<span>news center</span></h2>
		</div>
		<div class="bd">
			<ul class="m-pFList clearfix">
				<?
				    $sql = "select id, title, pic, content from info where class_id = '101101' and state>0 and pic<>'' order by state desc, sortnum desc limit 3";
				    $rst = $db->query($sql);
				    $i=1;
				    while ( $row = $db->fetch_array($rst) ) {
			    ?>
				<li class="clearfix">
					<p class="p"><a href="display.php?id=<?=$row["id"]?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" alt="<?=$row["title"]?>"></a></p>
					<div class="c">
						<p class="t"><a href="display.php?id=<?=$row["id"]?>"><?=$row["title"]?></a></p>
						<p class="i"><?=utf8substr(strip_tags(str_replace("&emsp;","",$row["content"])),28)?>...</p>
					</div>
				</li>
				<?
					$i+=1;
					}
				?>
			</ul>
			<p class="about_more more-common-01"><a href="info.php?class_id=101">查看更多</a></p>
		</div>
	</div>
	<div class="u-tt box">
		<div class="hd">
			<h2>静安产业<span>CORE BUSINESS</span></h2>
		</div>
		<div class="bd">
			<ul class="m-pList clearfix">
				<?
				    $sql = "select id, title, pic from info where class_id = '101101' and state>0 and pic<>'' order by state desc, sortnum desc limit 4";
				    $rst = $db->query($sql);
				    $i=1;
				    while ( $row = $db->fetch_array($rst) ) {
			    ?>
				<li>
					<p class="p"><a href="display.php?id=<?=$row["id"]?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" alt="<?=$row["title"]?>" /></a></p>
					<p class="t"><a href="display.php?id=<?=$row["id"]?>"><?=$row["title"]?></a></p>
				</li>
				<?
					$i+=1;
					}
				?>
			</ul>
			<p class="about_more more-common-01"><a href="info.php?class_id=101">查看更多</a></p>
		</div>
	</div>
    <?
	require("end.php");
	?>
</div>
</body>
</html>