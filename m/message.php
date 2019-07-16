<?
require("../init.php");
$menu 		= "message";
$base_name  = "在线留言";

//提交表单
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name		=	trim($_POST['name']);
	$phone		=	trim($_POST['phone']);
	$email		=	trim($_POST['email']);
	$content	=	trim($_POST['content']);

	$create_time=	date("Y:m:d H:s");
	$sortnum 	= 	$db->getMax("message", "sortnum") + 10;
	$id			=	$db->getMax("message", "id") + 1;
	
	if (empty($name) || empty($phone) || empty($content)) {
		$db->close();
		echo "<script>alert('请输入必填项！');history.back(-1);</script>";
		exit;
	}

	if(preg_match('/[A-Za-z]+/',$name)){
		$db->close();
		echo "<script>alert('姓名不能含有英文！');history.back(-1);</script>";
		exit;
	}

	if(preg_match('/\d/is',$name)){
		$db->close();
		echo "<script>alert('姓名不能含有数字！');history.back(-1);</script>";
		exit;
	}

	$sql = "insert into message(id, sortnum, name, phone, email, content, create_time, state) values($id, $sortnum,  '$name', '$phone', '$email', '$content', '$create_time', 0)";
	if($rst = $db->query($sql))
	{
		$db->close();
		echo "<script>alert('提交成功，我们稍后将处理您的留言！');self.location=document.referrer;</script>";
		exit;
	}
	else
	{
		$db->close();
		echo "<script>alert('提交失败，请稍后重试！');history.back(-1);</script>";
		exit;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$base_name?> - <?=$config_name?></title>
<meta name="keywords" content="<?=$config_keyword?>" />
<meta name="description" content="<?=$config_description?>" />
<link rel="stylesheet" href="skin/base.css" />
<link rel="stylesheet" href="skin/swiper.min.css" />
<link rel="stylesheet" href="skin/blue/css.css" />
<script src="js/jquery.min.js"></script>
<script src="js/swiper.min.js"></script>
<script type="text/javascript">
	function check(form)
	{
		var phone = document.getElementById('phone').value;
		if (form.name.value == "")
		{
			alert("请输入姓名！");
			form.name.focus();
			return false;
		}
		if(form.phone.value == "")
		{
			alert("请输入您的手机号码!");
			form.phone.focus();
			return false;
		}
		if(!(/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(phone))){
	        alert("请输入正确的手机号码！");
	        form.phone.focus();
	        return false;
	    }
		if(form.content.value == "")
		{
			alert("请输入留言内容!");
			form.content.focus();
			return false;
		}
	}
</script>
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
		<h2><?=$base_name?><em></em></h2>
	</div>
	<div class="bd">
		<?
        require_once("left.php");
        ?>
		<div class="form-panel">
			<form method="post" onSubmit="return check(this);">
				<ul>
					<li class="field">
						<div class="input">
							<label for="name">姓名：</label>
							<input name="name" type="text" size="20" maxlength="10" class="text" value="" />
						</div>
					</li>
					<li class="field">
						<div class="input">
							<label for="phone">电话：</label>
							<input id="phone" name="phone" type="text" size="20" maxlength="11" class="text" value="" />
						</div>
					</li>
					<li class="field">
						<div class="input">
							<label for="email">邮箱：</label>
							<input name="email" type="text" size="20" maxlength="30" class="text"  value="" />
						</div>
					</li>
					<li class="field">
						<div class="input">
							<label for="content">留言：</label>
							<textarea name="content" cols="30" rows="6" class="textarea"><?=$content?></textarea>
						</div>
					</li>
					<li class="submit-field">
						<div class="input clearfix"><input type="submit" value="提交" class="btn-submit" /></div>
					</li>
				</ul>
			</form>
		</div>
	</div>
</div>
<?
require_once("end.php");
?>
</div>
</body>
</html>