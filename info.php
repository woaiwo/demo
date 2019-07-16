<?
require("init.php");

$class_id	= trim($_GET["class_id"]);

if ( empty($class_id) || strlen($class_id) < 3 || (int)$db->getCount('info_class', "id='".$class_id."' limit 1") < 1 ) {
	$db->close();
	header("location: ./");
	exit;
}

$base_id	 = substr($class_id, 0, 3);

$default_class_id = '';

if ( strlen($class_id) == 3 ) {  // 只有base_id，默认第一个子栏目ID
	if ( (int)$db->getTableFieldValue('info_class', 'has_sub', 'where id=\'' . $class_id . '\' limit 1') > 0 ) {
		$sql = "select id, name, has_sub, keyword, description, content from info_class where id like '".$class_id."___' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
		$base_id	 = substr($class_id, 0, 3);
		$cont		 = $row['content'];
        $keyword     = $row['keyword'];
        $description = $row['description'];
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = $row['id'];
		$second_name = $row['name'];

		$third_id	 = '';
		$third_name	 = '';
		$default_class_id = $row['id'];
	} else {
		$db->close();
		header("location: ./");
		exit;
	}

} elseif ( strlen($class_id) == 6 ) {
	if ( (int)$db->getTableFieldValue('info_class', 'has_sub', 'where id=\'' . $class_id . '\' limit 1') > 0 ) {
		$sql = "select id, name, has_sub, keyword, description, content from info_class where id like '".$class_id."___' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
        $keyword     = $row['keyword'];
        $description = $row['description'];
		$cont		 = $row['content'];
		$base_id	 = substr($class_id, 0, 3);
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = substr($class_id, 0, 6);
		$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');

		$third_id	 = $row['id'];
		$third_name	 = $row['name'];
		$default_class_id = $row['id'];
	} else {
		$sql = "select id, name, has_sub, keyword, description, content from info_class where id like '".$class_id."' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
        $keyword     = $row['keyword'];
        $description = $row['description'];
		$cont		 = $row['content'];
		$base_id	 = substr($class_id, 0, 3);
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = substr($class_id, 0, 6);
		$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');

		$third_id	 = '';
		$third_name	 = '';
		$default_class_id = $second_id;
	}
} elseif ( strlen($class_id) == 9 ) {
	$base_id	= substr($class_id, 0, 3);
	$second_id	= substr($class_id, 0, 6);
	$third_id	= substr($class_id, 0, 9);
	$base_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');
	$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');
	$third_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $third_id . '\' limit 1');
	$default_class_id = $third_id;
}

$info_state  = $db->getTableFieldValue('info_class', 'info_state', 'where id=\'' . $default_class_id . '\' limit 1');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="renderer" content="webkit">
<meta name="wap-font-scale" content="no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="keywords" content="<?=!empty($keyword) ? $keyword : $config_keyword?>" />
<meta name="description" content="<?=!empty($description) ? $description : $config_description?>" />
<title><?=!empty($third_id) ? $third_name." - " : ''?><?=$second_name?> - <?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="images/base.css" />
<link rel="stylesheet" href="images/inside.css" />
<link rel="stylesheet" href="images/adver.css" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.SuperSlide.2.1.2.js"></script>
<script src="js/adver.js"></script>
<script src="js/common.js?rightButton=<?=$config_rightButton?>&mobilejump=<?=$config_mobilejump?>"></script>
<? echo $config_javascriptHead;?>
</head>
<body>
<?
require_once("begin.php");
?>
<div class="container">
    <div class="location">
        <div class="wrap clearfix">
            <div class="breadcrumbs"><a href="./" class="u-home">网站首页</a> &gt; <a href="?class_id=<?=$base_id?>"><?=$base_name?></a> &gt; <a href="?class_id=<?=$class_id?>"><?=$second_name?></a><?= !empty($third_id) ? " &gt; <a href='?class_id=". $third_id ."'>". $third_name ."</a>" : '' ?></div>
            <h3><?= !empty($third_id) ? "". $third_name ."" : "". $second_name ."" ?></h3>
        </div>
    </div>
	<div class="wrap clearfix">
        <?
        require_once("left.php");
        ?>
		<div class="main">
        <?
        if ($info_state == 'content')
        {	// 内容模式
            $sql = "select id, title, content from info where class_id like '" . $default_class_id . "%' and state>0 order by state desc, sortnum desc";
            $rst = $db->query($sql);
            if ($row = $db->fetch_array($rst)) {
                $id			= $row['id'];
                $title		= $row['title'];
                $content	= $row['content'];

                $sql = "update info set views=views+1 where id=" . $id;
                $db->query($sql);
            }
        ?>
            <div class="article">
                <?=$content;?>
            </div>
            <script language="javascript">
                var content_width;
                var imgObj = $(".article").find("img");
                if (imgObj.length > 0)
                {
                    for (var i = 0; i < imgObj.length; i++)
                    {
                        if (imgObj[i].width > <?=$content_width?>) imgObj[i].width = <?=$content_width?>;
                    }
                }
            </script>
            <?
            }
            elseif ($info_state == 'list')
            {	// 新闻列表
            ?>
            <div class="hotNews">
                <?
	                $sql = "select id, title, pic, content from info where class_id like '".$default_class_id."%' and state>0 and pic<>'' order by state desc, sortnum desc";
	                $rst = $db->query($sql);
	                if ($row = $db->fetch_array($rst)) {
                ?>
                    <div class="pic">
                        <a href="display.php?id=<?=$row['id']?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" width="240" height="180" alt="<?=$row["title"]?>" /></a>
                    </div>
                    <dl>
                        <dt><a href="display.php?id=<?=$row['id']?>"><?=$row['title']?></a></dt>
                        <dd class="i"><?=utf8substr(strip_tags(str_replace("&nbsp;","",$row["content"])),80)?></dd>
                        <dd class="m"><a href="display.php?id=<?=$row['id']?>">了解详细</a></dd>
                    </dl>
                <?
                	}
                ?>
            </div>
            <ul class="list">
                <?
                $sql = "select count(*) as cnt from info where  class_id like '" . $default_class_id . "%'  and state>0";
                $rst = $db->query($sql);
                if ($row = $db->fetch_array($rst)) {
                    $recordCount = $row["cnt"];
                } else {
                    $recordCount = 0;
                }

                $page		= (int)$_GET["page"];
                $page		= $page > 0 ? $page : 1;
                $pageSize	= 15;
                $pageCount	= ceil($recordCount / $pageSize);
                if ($page > $pageCount) $page = $pageCount;

                $sql = "select id, title, pic, content, create_time, website from info where class_id like '" . $default_class_id . "%' and state>0 order by state desc, create_time desc, sortnum desc";

                $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                $rst = $db->query($sql);
                $i=1;
                while ($row = $db->fetch_array($rst)) {

				if(!empty($row['website']))
                {
                    $website = $row['website'];
                }
                else
                {
                    $website = 'display.php?id=' . $row['id'];
                }
                    $publishdate = explode(' ', $row['create_time']);
                ?>
                    <li><a href="<?=$website?>"><?=$row['title']?></a><span><?=formatDate("Y-m-d",$publishdate[0])?></span></li>
                <?
                $i++;
                }
                ?>
            </ul>
            <div class="page"><span><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></span></div>
            <?
            }
            elseif ($info_state == 'pic')
            {	// 图片列表
            ?>
			<div class="piList">
				<div class="pic-item-list clearfix">
                   <?
                    $sql = "select count(*) as cnt from info where class_id like '" . $default_class_id . "%' and state>0";
                    $rst = $db->query($sql);
                    if ($row = $db->fetch_array($rst)) {
                        $recordCount = $row["cnt"];
                    } else {
                        $recordCount = 0;
                    }

                    $page		= (int)$_GET["page"];
                    $page		= $page > 0 ? $page : 1;
                    $pageSize	= 12;
                    $pageCount	= ceil($recordCount / $pageSize);
                    if ($page > $pageCount) $page = $pageCount;

                    $sql = "select id, title, pic, website, content from info where class_id like '" . $default_class_id . "%' and state>0 order by state desc, sortnum desc";
                    $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                    $rst = $db->query($sql);
                    $i = 0;
                    while ($row = $db->fetch_array($rst)) {

                        //获取编辑器图片
                        $pattern = '/<img.*?src=\s*?"?([^"\s]+)(?!\/>)"?\s*?/is';
                        $content=$row['content'];
                        preg_match_all($pattern,$content,$match);  //这里是关键
                        $tt 	= implode(',', $match[1]);

                        //print_r($match[1][0]);
	                    //exit;

	                    //$tts = str_replace("'","",$tt);
	                    //$tts = explode(',', $tts);

                        $publishdate = explode(' ', $row['create_time']);
                        if(!empty($row['website']))
                        {
                            $website = $row['website'];
                        }
                        else
                        {
                            $website = 'display.php?id=' . $row['id'];
                        }
                    ?>
                    <div class="pic-item">
                        <div class="list-pic">
                            <?
                            if(!empty($row['pic'])){
                            ?>
                            <a href="<?=$website?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" alt="<?=$row["title"]?>" /></a>
                            <?
                            }else{
                            ?>
                            <a href="<?=$website?>">暂无图片</a>
                            <?
                            }
                            ?>
                        </div>
                        <dl>
                            <dt><a href="<?=$website?>"><?=$row["title"]?></a></dt>
                        </dl>
                    </div>
                    <?
                        $i += 1;
                    }
                    ?>
                </div>
        	</div>
            <div class="page"><span><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></span></div>
        <?
        } elseif ($info_state == 'pictxt') {  // 图文列表
        ?>
            <ul class="pothoItem">
               <?
                $sql = "select count(*) as cnt from info where  class_id like '" . $default_class_id . "%'  and state>0";
                $rst = $db->query($sql);
                if ($row = $db->fetch_array($rst)) {
                    $recordCount = $row["cnt"];
                } else {
                    $recordCount = 0;
                }

                $page		= (int)$_GET["page"];
                $page		= $page > 0 ? $page : 1;
                $pageSize	= 5;
                $pageCount	= ceil($recordCount / $pageSize);
                if ($page > $pageCount) $page = $pageCount;

                $sql = "select id, title, pic, website, content, create_time from info where class_id like '" . $default_class_id . "%'  and state>0 order by state desc, sortnum desc";
                $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                $rst = $db->query($sql);
                $i = 0;
                while ($row = $db->fetch_array($rst)) {

                    //获取编辑器图片
                    $pattern = '/<img.*?src=\s*?"?([^"\s]+)(?!\/>)"?\s*?/is';
                    $content = $row['content'];
                    preg_match_all($pattern, $content, $match);  //这里是关键
                    $tt 	= implode(',', $match[1]);

                    //print_r($match[1][0]);
                    //exit;

                    //$tts = str_replace("'","",$tt);
                    //$tts = explode(',', $tts);

                    $publishdate = explode(' ', $row['create_time']);
                    if(!empty($row['website']))
                    {
                        $website = $row['website'];
                    }
                    else
                    {
                        $website = 'display.php?id=' . $row['id'];
                    }
                ?>
                <li class="item clearfix">
                    <div class="pic">
                    	<?
                        if(!empty($row['pic'])){
                        ?>
                        <a href="<?=$website?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" alt="<?=$row["title"]?>" /></a>
                        <?
                        }else{
                        ?>
                        <a href="<?=$website?>">暂无图片</a>
                        <?
                        }
                        ?>
                    </div>
                    <dl>
                        <dt><a href="<?=$website?>"><?=utf8substr(strip_tags(str_replace("&nbsp;","",$row["title"])),25)?></a></dt>
                        <dd class="d"><?=$publishdate[0]?></dd>
                        <dd class="i"><?=utf8substr(strip_tags(str_replace("&nbsp;","",$row["content"])),135)?></dd>
                        <dd class="m"><a href="<?=$website?>">了解更多</a></dd>
                    </dl>
                </li>
                <?
                    $i += 1;
                }
                ?>
            </ul>
            <div class="page"><span><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></span></div>
        <?
        }
        elseif ($info_state == 'custom')
        {	// 自定义模式
        ?>
            <!-- 11 -->
        <?
        }
        ?>
		</div>
	</div>
</div>
<?
require_once("end.php");
?>
</body>
</html>