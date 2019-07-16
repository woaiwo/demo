<?
require("init.php");

$menu 			= "user_center";
$base_name 		= "用户中心";
$base_en_name 	= "user_center";
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
<title><?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="images/base.css" />
<link rel="stylesheet" href="images/inside.css" />
<link rel="stylesheet" href="images/adver.css" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.SuperSlide.2.1.2.js"></script>
<script src="js/common.js?rightButton=<?=$config_rightButton?>&mobilejump=<?=$config_mobilejump?>"></script>
<script src="js/adver.js"></script>
<? echo $config_javascriptHead; ?>
</head>
<body>
<?
	require("begin.php");
?>
<div class="container">
	<div class="wrap clearfix">
		<?
			require("user_left.php");
		?>
		<div class="main">
			<div class="art-box">
				<div class="success">
					<h2>您好，<? echo $_SESSION['username']; ?>，欢迎您的登录。</h2>
					<div>
						<a href="user_info.php">个人资料</a>|<a href="user_changePass.php">修改密码</a>|<a href="./">返回主页</a>|<a href="user_logout.php" onClick="if (confirm('您确定要退出吗？')) return true; else return false;">退出登录</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
	require("end.php");
?>
</body>
</html>