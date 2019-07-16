<?
require("../init.php");
$content_width	= 640;

$class_id	= trim($_GET["class_id"]);

if ( empty($class_id) || strlen($class_id) < 3 || (int)$db->getCount('info_class', "id='".$class_id."' limit 1") < 1 ) {
	$db->close();
	header("location: index.php");
	exit;
}

$base_id	 = substr($class_id, 0, 3);

$default_class_id = '';

if ( strlen($class_id) == 3 ) {  // 只有base_id，默认第一个子栏目ID
	if ( (int)$db->getTableFieldValue('info_class', 'has_sub', 'where id=\'' . $class_id . '\' limit 1') > 0 ) {
		$sql = "select id, name, has_sub,content from info_class where id like '".$class_id."___' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
		$base_id	 = substr($class_id, 0, 3);
		$cont		 = $row['content'];
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = $row['id'];
		$second_name = $row['name'];

		$third_id	 = '';
		$third_name	 = '';
		$default_class_id = $row['id'];
	} else {
		$db->close();
		header("location: index.php");
		exit;
	}

} elseif ( strlen($class_id) == 6 ) {
	if ( (int)$db->getTableFieldValue('info_class', 'has_sub', 'where id=\'' . $class_id . '\' limit 1') > 0 ) {
		$sql = "select id, name, has_sub,content from info_class where id like '".$class_id."___' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
		$cont		 = $row['content'];
		$base_id	 = substr($class_id, 0, 3);
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = substr($class_id, 0, 6);;
		$second_name = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $second_id . '\' limit 1');

		$third_id	 = $row['id'];
		$third_name	 = $row['name'];
		$default_class_id = $row['id'];
	} else {
		$sql = "select id, name, has_sub,content from info_class where id like '".$class_id."' order by sortnum asc limit 1";
		$rst = $db->query($sql);
		$row = $db->fetch_array($rst);

		$class_id	 = $row['id'];
		$cont		 = $row['content'];
		$base_id	 = substr($class_id, 0, 3);
		$base_name	 = $db->getTableFieldValue('info_class', 'name', 'where id=\'' . $base_id . '\' limit 1');

		$second_id	 = substr($class_id, 0, 6);;
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
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$second_name?><?=!empty($third_id) ? " - ".$third_name : ''?> - <?=$base_name?> - <?=$config_name?></title>
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
	    <?
        if ($info_state == 'content')
        {	// 内容模式
            $sql = "select id, title, content, webcontent from info where class_id like '" . $default_class_id . "%' and state>0 order by state desc, sortnum desc limit 1";
            $rst = $db->query($sql);
            if ($row = $db->fetch_array($rst)) {
                $id			= $row['id'];
                $title		= $row['title'];
                $content	= $row['content'];
                $webcontent = $row['webcontent'];

                $sql = "update info set views=views+1 where id=" . $id;
                $db->query($sql);
            }
        ?>
            <div class="article">
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
           <ul class="m-tList">
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
                $pageSize	= 10;
                $pageCount	= ceil($recordCount / $pageSize);
                if ($page > $pageCount) $page = $pageCount;

                $sql = "select id, title, pic, intro, create_time,views,content,annex from info where  class_id like '" . $default_class_id . "%'  and state>0 order by state desc, create_time desc, sortnum desc";

                $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                $rst = $db->query($sql);
                $i=1;
                while ($row = $db->fetch_array($rst)) {

                    $publishdate = explode(' ', $row['create_time']);
                ?>
                    <li>
                        <h2><a href="display.php?id=<?=$row['id']?>"  ><?=$row['title']?></a></h2>
                        <p><?=utf8substr(strip_tags(str_replace("&nbsp;","",$row["content"])),38)?></p>
                    </li>
                <?
                $i++;
                }
                ?>
                </ul>
            <p class="page"><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></p>
        <?
        }
        elseif ($info_state == 'pic')
        {	// 图片列表
        ?>
		<ul class="m-pList clearfix">
            <?
            $sql = "select count(*) as cnt from info where  class_id like '" . $default_class_id . "%' and state>0";
            $rst = $db->query($sql);
            if ($row = $db->fetch_array($rst)) {
                $recordCount = $row["cnt"];
            } else {
                $recordCount = 0;
            }

            $page		= (int)$_GET["page"];
            $page		= $page > 0 ? $page : 1;
            $pageSize	= 8;
            $pageCount	= ceil($recordCount / $pageSize);
            if ($page > $pageCount) $page = $pageCount;

            $sql = "select id, title, pic, website, content, create_time from info where class_id like '" . $default_class_id . "%'  and state>0 order by sortnum desc";
            $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
            $rst = $db->query($sql);
            $i = 0;
            while ($row = $db->fetch_array($rst)) {

                //获取编辑器图片
                $pattern = '/<img.*?src=\s*?"?([^"\s]+)(?!\/>)"?\s*?/is';
                $content=$row['content'];
                preg_match_all($pattern,$content,$match);  //这里是关键
                $tt 	= implode(',', $match[1]);

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
                <li>
                    <p class="p"><a href="display.php?id=<?=$row['id']?>"><img src="<?=UPLOAD_PATH_FOR_ADMIN . $row['pic']?>" alt="<?=$row['title']?>" /></a></p>
                    <p class="t"><a href="display.php?id=<?=$row['id']?>"><?=$row['title']?></a></p>
                </li>
             <?
                $i += 1;
                if ($i % 2 == 0) echo '<LI class="clear"></LI>';
            }
            ?>
         </ul>
        <p class="page"><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></p>

        <?
        } elseif ($info_state == 'pictxt') {  // 图文列表
        ?>
			<ul class="m-pFList clearfix">
                <?
                $sql = "select count(*) as cnt from info where class_id like '" . $default_class_id . "%'  and state>0";
                $rst = $db->query($sql);
                if ($row = $db->fetch_array($rst)) {
                    $recordCount = $row["cnt"];
                } else {
                    $recordCount = 0;
                }

                $page		= (int)$_GET["page"];
                $page		= $page > 0 ? $page : 1;
                $pageSize	= 8;
                $pageCount	= ceil($recordCount / $pageSize);
                if ($page > $pageCount) $page = $pageCount;

                $sql = "select id, title, pic, website, content, create_time from info where  class_id like '" . $default_class_id . "%'  and state>0 order by sortnum desc";
                $sql .= " limit " . ($page - 1) * $pageSize . ", " . $pageSize;
                $rst = $db->query($sql);
                $i = 0;
                while ($row = $db->fetch_array($rst)) {

                    //获取编辑器图片
                    $pattern = '/<img.*?src=\s*?"?([^"\s]+)(?!\/>)"?\s*?/is';
                    $content=$row['content'];
                    preg_match_all($pattern,$content,$match);  //这里是关键
                    $tt 	= implode(',', $match[1]);

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
                    <li>
                        <p class="p"><a href="display.php?id=<?=$row['id']?>"><img src="<?=UPLOAD_PATH_FOR_ADMIN . $row['pic']?>" alt="<?=$row['title']?>" /></a></p>
                        <div class="c">
                            <p class="t"><a href="display.php?id=<?=$row['id']?>"><?=$row['title']?></a></p>
                            <p class="i"><?=utf8substr(strip_tags(str_replace("&emsp;","",$row["content"])),28)?>...</p>
                        </div>
                    </li>
                 <?
                    $i += 1;
                }
                ?>
             </ul>
            <p class="page"><?=page2($page, $pageCount, "info.php?class_id=$class_id&")?></p>
        <?
        }
        elseif ($info_state == 'custom')
        {	// 自定义模式
        ?>

        <?
        }
        ?>
		</div>
	</div>
	<?
    require_once("end.php");
    ?>
</div>
</body>
</html>