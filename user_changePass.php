<?
require("init.php");

$menu 			= "user_changePass";
$base_name 		= "修改密码";
$base_en_name 	= "user_changePass";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$oldpass	= 	md5(trim($_POST["oldpass"]));
	$newpass	= 	md5(trim($_POST["pass"]));
	$newpass2	= 	md5(trim($_POST["repass"]));

	if($oldpass != $db->getTableFieldValue("member", "pass", " where name = '".$_SESSION['username']."'" )){
		$db->close();
		echo "<script>alert('原密码错误！');history.back(-1);</script>";
		exit;
	}else{
		$sql  = "update member set pass= '".$newpass."' where name = '".$_SESSION['username']."' and state > 0";
		$rst = $db->query($sql);
		$db->close();
		echo "<script>alert('密码修改成功！');history.back(-1);</script>";
		exit;
	}
}else{
	$sql = "select pass from member where name = '".$_SESSION['username']."' and state > 0";
	$rst = $db->query($sql);
	if($row = $db->fetch_array($rst)){
		$pass 	= $row['pass'];
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
									<label for="oldpass">原密码：</label>
									<input name="oldpass" type="password" value="<?= $pass ?>" placeholder="" />
								</li>
								<li>
									<label for="pass">新密码：</label>
									<input name="pass" type="password" value="" placeholder="<?if($newpass==""){echo '未设置';}?>" datatype="k6-16" nullmsg="请设置密码！" />
								</li>
								<li>
									<label for="repass">确认密码：</label>
									<input name="repass" type="password" value="" placeholder="<?if($repass==""){echo '未设置';}?>" datatype="*" recheck="pass" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" />
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