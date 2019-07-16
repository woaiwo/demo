<?
require ('init.php');

$menu = "default";
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
<title><?=$config_title?></title>
<link rel="stylesheet" href="images/base.css" />
<link rel="stylesheet" href="images/home.css" />
<link rel="stylesheet" href="images/adver.css" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.SuperSlide.2.1.2.js"></script>
<script src="js/adver.js"></script>
<script src="js/common.js?rightButton=<?=$config_rightButton?>&mobilejump=<?=$config_mobilejump?>"></script>
<?echo $config_javascriptHead;?>
</head>
<body>
<?
require ("begin.php");
?>
<div class="container">
	<div class="channel clearfix">
		<ul>
			<li class="li01"><a href="#"><i></i>
				<dl>
					<dt>项目性融资</dt>
					<dd class="i">项目融资方式有助于控制信贷风险和提高银行的经营效益，有逐步被国内商业银行采用的趋势。</dd>
					<dd class="m">查看详情</dd>
				</dl>
			</a></li>
			<li class="li02"><a href="#"><i></i>
				<dl>
					<dt>企业理财咨询</dt>
					<dd class="i">将根据您对收益、风险、期限、投资范围的不同偏好设计个性化的企业理财方案，所有方案将凸显安全性强、收益率高、产品种类齐全的特点。</dd>
					<dd class="m">查看详情</dd>
				</dl>
			</a></li>
			<li class="li03"><a href="#"><i></i>
				<dl>
					<dt>动产质押咨询</dt>
					<dd class="i">动产质权的标的物即质物，是质押合同中约定的由出质人移交给质权人占有的动产。由于实现动产质权时，要对质物予以变价。</dd>
					<dd class="m">查看详情</dd>
				</dl>
			</a></li>
			<li class="li04"><a href="#"><i></i>
				<dl>
					<dt>小额贷款</dt>
					<dd class="i">无抵押、低利率、额度高、放款快、分期还、手续简。申请小额贷款的范围和条件。</dd>
					<dd class="m">查看详情</dd>
				</dl>
			</a></li>
		</ul>
	</div>
	<div class="box02">
		<div class="wrap">
			<div class="bd clearfix">
				<?
					$sql = "select title, content, pic from info where class_id= 101101 and state > 0 and pic<>'' limit 1";
					$rst = $db->query($sql);
					while($row = $db->fetch_array($rst)){
				?>
				<div class ="pic"><a href="info.php?class_id=101101"><img src="<?=UPLOAD_PATH . $row['pic']?>" width="455" height="350" alt="<?=$row['title']?>"></a></div>
				<dl>
					<dt>关于我们 About Us</dt>
					<dd><?=utf8substr(strip_tags($row['content']),300)?></dd>
				</dl>
				<?
					}
				?>
			</div>
		</div>
	</div>
	<div class="box04">
		<div class="wrap">
			<div class="title">新闻动态 News<ul class="hd clearfix"><li>公司动态</li><li>行业动态</li></ul></div>
			<div class="bd">
				<ul class="clearfix">
				<?
					$sql = "select id, title, content, create_time, pic from info where class_id= 101101 and state > 0 order by state desc, sortnum desc limit 3";
					$rst = $db->query($sql);
					$i = 0;
					while($row = $db->fetch_array($rst)){
					$publishdate = explode(" ",$row['create_time']);
				?>
					<li class="li0<?echo i?>">
						<dl>

							<dd class="i"><?=utf8substr(strip_tags(str_replace("&nbsp;","",$row["content"])),30)?></dd>
							<dd class="m"><a href="display.php?id=<?=$row['id']?>">详　情</a></dd>
						</dl>
					</li>
				<?
					$i += 1;
					}
				?>
				</ul>
				<ul class="clearfix">
					<?
						$sql = "select id, title, content, create_time, pic from info where class_id= 103102 and state > 0 and pic<>'' order by state desc, sortnum desc limit 3";
						$rst = $db->query($sql);
						$i = 0;
						while($row = $db->fetch_array($rst)){
						$publishdate = explode(" ",$row['create_time']);
					?>
						<li class="li0<?echo i?>">
							<div class="pic"><a href="display.php?id=<?=$row['id']?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" width="382" height="279" alt="<?=$row['title']?>"></a></div>
							<dl>
								<dt><?=utf8substr(strip_tags(str_replace("&nbsp;", "replace", $row['title'])),18)?></dt>
								<dd class="d"><?=$publishdate[0]?></dd>
								<dd class="i"><?=utf8substr(strip_tags($row['content']),70)?></dd>
								<dd class="m"><a href="display.php?id=<?=$row['id']?>">详　情</a></dd>
							</dl>
						</li>
					<?
						$i += 1;
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
	$(".box04").slide({titCell:".hd li",mainCell:".bd",effect:"fold",autoPlay:false});
</script>
<div class="link">
	<div class="wrap">友情链接：
		<?
			$sql = "select name, url from link where class_id = 1 and state > 0 order by state desc, sortnum desc limit 20";
			$rst = $db->query($sql);
			while($row = $db->fetch_array($rst)){
		?>
		<a href="<?=$row['url']?>"><?=$row['name']?></a>
		<?
			$i += 1;
			}
		?>
	</div>
</div>
<?
require ("end.php");
?>
</body>
</html>