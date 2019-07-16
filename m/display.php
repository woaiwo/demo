<?
require("../init.php");
$content_width	= 640;

$id	= (int)$_GET["id"];
if ($id < 1) {
	$db->close();
	header("location: index.php");
	exit;
}

$sql = "select id, class_id, title, pic, annex, source, author, views, content, webcontent, create_time from info where id=$id and state>0 limit 1";
$rst = $db->query($sql);
if ($row = $db->fetch_array($rst)) {
	$title			= $row["title"];
	$source			= $row["source"];
	$class_id		= $row["class_id"];
	$_three 		= substr($row["class_id"],0,3);//pierce add
	$content		= $row["content"];
	$webcontent		= $row["webcontent"];
	$create_time	= $row["create_time"];
	$publishdate	= explode(' ', $create_time);
	$views			= $row['views'];
	$author			= $row['author'];
	$pic			= $row['pic'];
	$annex			= $row['annex'];
	$share			= $row['share'];

	$sql = "update info set views=views+1 where id=$id";
	$db->query($sql);
} else {
	$db->close();
	header("location: index.php");
	exit;
}

$base_id	 = substr($class_id, 0, 3);

if ( strlen($class_id) == 3 ) {  // 只有base_id，默认第一个子栏目ID
	$base_id	= substr($class_id, 0, 3);
	$second_id	= '';
	$third_id	= '';
	$base_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

	$cont = $db->getTableFieldValue('info_class', 'content', 'where id=\'' . $second_id . '\' limit 1');
	$second_name = '';
	$third_name = '';

} elseif ( strlen($class_id) == 6 ) {
	$base_id	= substr($class_id, 0, 3);
	$second_id	= substr($class_id, 0, 6);
	$third_id	= '';
	$base_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');
	$cont = $db->getTableFieldValue('info_class', 'content', 'where id=\'' . $second_id . '\' limit 1');
	$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');
	$third_name = '';
} elseif ( strlen($class_id) == 9 ) {
	$base_id	= substr($class_id, 0, 3);
	$second_id	= substr($class_id, 0, 6);
	$third_id	= substr($class_id, 0, 9);
	$base_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');
	$cont = $db->getTableFieldValue('info_class', 'content', 'where id=\'' . $second_id . '\' limit 1');
	$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');
	$third_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $third_id . '\' limit 1');
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$config_name?> - <?=$base_name?> - <?=$second_name?><?=!empty($third_id) ? " - ".$third_name : ''?></title>
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
		<p class="col" id="m-col"><a href="javascript:;">栏目</a></p>
		<h2><?=$second_name?></h2>
	</div>
	<div class="bd">
		<?
		require_once("left.php");
		?>
		<div class="article">
			<div class="mt">
				<h1><?=$title?></h1>
				<p class="titBar"><?=$publishdate[0]?></p>
			</div>
			<div class="mc">
				<?
                    if($webcontent!=""){
                ?>
                <?= $webcontent;?>
                <?
                    }else{
                ?>
                <?= $content;?>
                <?
                    }
                ?>
			</div>
		</div>
	</div>
</div>
<?
require_once("end.php");
?>
</div>
</body>
</html>