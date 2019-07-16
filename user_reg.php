<?
require("init.php");

$menu 			= "user_reg";
$base_name 		= "用户注册";
$base_en_name 	= "user_reg";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST['name']!=""&&($_POST['pass']!=""||$_POST['repass']!="")&& $_POST['phone']!="" ){
		$name	 = trim($_POST['name']);
		$pass	 = md5(trim($_POST['pass']));
		$phone	 = trim($_POST['phone']);

		$now	 = date('Y-m-d H:i:s',time());
		$id 	 = $db->getMax("member", "id") + 1;
		$sortnum = $db->getMax("member", "sortnum") + 10;

		$sql = "insert into member(id,sortnum,name,pass,realname,sex,phone,email,address,state,create_time,modify_time,login_count) values($id,$sortnum,'$name','$pass','$realname','$sex','$phone','$email','$address',0,'$now','$now',0)";
		$rst = $db->query($sql);

		if($rst){
			echo "<script>alert('注册成功！');self.location=document.referrer;</script>";
			exit;
		}else{
			echo "<script>alert('注册失败，请稍候重试！');history.back(-1);</script>";
			exit;
		}
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
<body >
<?
	require("begin.php");
?>
<div class="container">
	<div class="wrap clearfix">
	<?
		require("user_left.php");
	?>
		<div class="main">
			<div class="form-panel">
				<form class="sform" name="form_reg" method="post">
					<ul>
						<li>
							<label for="name">登录账号：</label>
							<input name="name" type="text" datatype="s5-12" nullmsg="请输入账号！" errormsg="账号至少5个字符,最多10个字符！" />
						</li>
						<li>
							<label for="pass">登录密码：</label>
							<input name="pass" type="password" datatype="k6-16" nullmsg="请设置密码！" />
						</li>
						<li>
							<label for="repass">重复密码：</label>
							<input name="repass" type="password" datatype="*" recheck="pass" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" />
						</li>
						<li>
							<label for="phone">联系电话：</label>
							<input name="phone" type="text" datatype="m" nullmsg="请输入您的电话号码！" />
						</li>
						<li><label></label><input type="submit" value="提交"><input type="reset" value="重置"></li>
					</ul>
				</form>
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