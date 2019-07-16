<?
require("init.php");

$menu		= "search";
$base_name	= "信息搜索";
$search		= htmlspecialchars(trim($_GET["search_keyword"]));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="renderer" content="webkit">
<meta name="wap-font-scale" content="no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="keywords" content="<?=$config_keyword?>" />
<meta name="description" content="<?=$config_description?>" />
<title><?=!empty($search) ? $search : '' ?> - <?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="images/base.css" />
<link rel="stylesheet" href="images/inside.css" />
<link rel="stylesheet" href="images/adver.css" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.SuperSlide.2.1.2.js"></script>
<script src="js/adver.js"></script>
<script src="js/common.js?rightButton=<?=$config_rightButton?>&mobilejump=<?=$config_mobilejump?>"></script>
<? echo $config_javascriptHead; ?>
</head>
<body>
<?
require_once("begin.php");
?>
<div class="container">
    <div class="location">
        <div class="wrap clearfix">
            <div class="breadcrumbs"><a href="./" class="u-home">网站首页</a> &gt; <a href="javascript:;"><?=$base_name?></a><?=!empty($search) ? " &gt; <a href='?search_keyword=". $search ."'>". $search ."</a>" : '' ?></div>
            <h3><?=$base_name?></h3>
        </div>
    </div>
	<div class="wrap clearfix">
    	<?
        require_once("left.php");
        ?>
		<div class="main">
			<div class="list">
				<ul>
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

                    $sql = "select id, title, create_time from info where title like '%$search%' and state>0  order by state desc, sortnum desc";
                    $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                    $rst = $db->query($sql);
                    while ($row = $db->fetch_array($rst)) {
                        $publishdate = explode(' ', $row['create_time']);
                    ?>
                    <li><a href="display.php?id=<?=$row['id']?>"><?=$row['title']?></a><span><?=$publishdate[0]?></span></li>
                    <?
                    }
                    ?>
				</ul>
			</div>
            <div class="page"><span><?=page2($page, $pageCount, "")?></span></div>
		</div>
	</div>
</div>
<?
require_once("end.php");
?>
</body>
</html>