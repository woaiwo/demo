<?
require("init.php");

$menu 			= "user_info";
$base_name 		= "个人资料";
$base_en_name 	= "user_info";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$realname	= 	htmlspecialchars(trim($_POST["realname"]));
	$sex		= 	htmlspecialchars(trim($_POST["sex"]));
	$phone		= 	htmlspecialchars(trim($_POST["phone"]));
	$email		= 	htmlspecialchars(trim($_POST["email"]));
	$address	= 	htmlspecialchars(trim($_POST["address"]));

	$sql  = "update member set realname= '".$realname."', sex= '".$sex."', phone= '".$phone."', email= '".$email."', address= '".$address."' where name = '".$_SESSION['username']."' and state > 0";
	$rst = $db->query($sql);
	$db->close();
	echo "<script>alert('个人资料修改成功！');history.back(-1);</script>";
	exit;
}else{
	$sql = "select realname, sex, phone, email, address from member where name = '".$_SESSION['username']."' and state > 0";
	$rst = $db->query($sql);
	if($row = $db->fetch_array($rst)){
		$realname = $row['realname'];
		$sex 	  = $row['sex'];
		$phone 	  = $row['phone'];
		$email 	  = $row['email'];
		$address  = $row['address'];
	}else{
		$db->close();
		header("location: ./");
		exit;
	}
}
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
					<div class="form-panel">
						<form class="sform" action="?" method="post">
							<ul>
								<li>
									<label for="realname">真实姓名：</label>
									<input name="realname" type="text" value="<?= $realname ?>" placeholder="<?if($realname==""){echo '未设置';}?>" datatype="zh2-6" nullmsg="请输入真实姓名！" errormsg="请输入2-6个汉字！" />
								</li>
								<li>
									<label for="sex">性　别：</label>
									<input name="sex" type="text" value="<?= $sex ?>" placeholder="<?if($realname==""){echo '未设置';}?>" datatype="zh1-1" nullmsg="请输入性别！" errormsg="请输入男或女" />
								</li>
								<li>
									<label for="phone">手机号码：</label>
									<input name="phone" type="text" value="<?= $phone ?>" placeholder="<?if($realname==""){echo '未设置';}?>" datatype="m" nullmsg="请输入您的手机号码！" />
								</li>
								<li>
									<label for="email">电子邮箱：</label>
									<input name="email" type="text" value="<?= $email ?>" placeholder="<?if($realname==""){echo '未设置';}?>" datatype="e" nullmsg="请输入您的邮箱！" />
								</li>
								<li>
									<label for="address">地　址：</label>
									<input name="address" type="text" value="<?= $address ?>" placeholder="<?if($realname==""){echo '未设置';}?>" datatype="*" nullmsg="请输入您的地址！" />
								</li>
								<li><label></label><input type="submit" value="提交"><input type="reset" value="重置"></li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
	require("end.php");
?>
<script src="js/Validform/Validform_v5.3.2_min.js"></script>
<script>
	$(function(){
		$(".sform").Validform({
			tiptype:4,
		});
	})
</script>
</body>
</html>