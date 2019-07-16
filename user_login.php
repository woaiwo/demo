<?
require("init.php");

$menu			="user_login";
$base_name 		= "用户登录";
$base_en_name 	= "user_login";

if($_SESSION['userid'] != ""){
	echo "<script>alert('您已登录，请先退出！');history.back(-1);</script>";
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$name	= 	htmlspecialchars(trim($_POST["name"]));
	$pass	= 	md5(trim($_POST["pass"]));

	if (empty($name) || empty($pass)){
		$db->close();
		echo "<script>alert('用户名或密码不能为空！');history.back(-1);</script>";
		exit;
	}

	if(isset($_POST["code"])){
		$code = $_POST["code"];
		if(strtolower($code) != strtolower($_SESSION["img_code"])){
			echo "<script>alert('验证码错误或未填写！');history.back(-1);</script>";
			exit;
		}
	}

	$sql = "select * from member where name='". $name ."' limit 1";
	$rst = $db->query($sql);
	$row = $db->fetch_array($rst);
	if(!empty($row["name"])) {
		if($row["pass"] == $pass) {
			if($row["state"]!=0) {
				//加密COOKIE，防止COOKIE伪造
				setcookie("username",$row["name"],time()+7200);
				setcookie("userpass",$row["pass"],time()+7200);
				setcookie("userphone",$row["phone"],time()+7200);
				setcookie("loginIp",$_SERVER['REMOTE_ADDR'],time()+7200);
				setcookie("loginTime",date("Y-m-d H:i:s"),time()+7200);
				// echo $_SERVER['REMOTE_ADDR'] . $_SERVER["HTTP_HOST"] ;

				$_SESSION['userid']    = $row['id'];
				$_SESSION['username']  = $row['name'];
				$_SESSION['userphone'] = $row['phone'];
				$login_count  = $row["login_count"] + 1;

				$sql = "update member set login_count= $login_count, login_ip = '$loginIp', login_time = '$loginTime' where name='" . $row["name"] ."' limit 1";
				$rst = $db->query($sql);
				header("location:user_center.php");
				exit;
			} else {
				echo "<script>alert('用户状态异常，请联系管理员！');history.back(-1);</script>";
				exit;
			}
		} else {
			echo "<script>alert('用户名或密码错误！');history.back(-1);</script>";
			exit;
		}
	} else {
		echo "<script>alert('用户名不存在！');history.back(-1);</script>";
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
		require_once("user_left.php");
		?>
		<div class="main">
			<div class="form-panel">
				<form class="sform" name="form_reg" method="post" >
					<ul>
						<li>
							<label for="name">登录账号：</label>
							<input name="name" type="text" datatype="*" nullmsg="请输入账号！" />
						</li>
						<li>
							<label for="pass">登录密码：</label>
							<input name="pass" type="password" datatype="*" nullmsg="请输入密码！" />
						</li>
						<li>
							<label for="code">验证码：</label>
							<input class="text" type="text" maxlength="4" size="10" id="code" name="code" />
							<img title="点击刷新" style="cursor:pointer;margin-left:8px;" src="include/code.php" onclick="this.src='include/code.php?'+Math.random();">
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