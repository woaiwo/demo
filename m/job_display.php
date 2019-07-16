<?
require("../init.php");

$base_name	  = "人力资源";
$base_en_name = "Job";
$menu 		  = "job";

$id		=  $_GET['id'];

$sql = "select * from job where id='$id'";
$rst = $db->query($sql);
$record_arr=array();
$row = $db->fetch_array($rst);

$showForm    = $row["showForm"];
$job_name 	 = $row["name"];
$job_content = $row["content"];

//提交表单
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name			=	trim($_POST['name']);
	$sex			=	trim($_POST['sex']);
	$age			=	trim($_POST['age']);
	$major			=	trim($_POST['major']);
	$graduate_time	=	trim($_POST['graduate_time']);
	$college		=	trim($_POST['college']);
	$phone			=	trim($_POST['phone']);
	$email			=	trim($_POST['email']);
	$resumes		=	trim($_POST['resumes']);
	$appraise		=	trim($_POST['appraise']);

	$create_time	=	date("Y-m-d H:i:s");
	$sortnum 		= 	$db->getMax("job_apply", "sortnum") + 10;
	$aid			=	$db->getMax("job_apply", "id") + 1;
	$sql = "insert into job_apply(id, name, job_id, sortnum, sex, age, major, graduate_time, college, phone, email, resumes, appraise, create_time, state) values($aid, '$name', $id, $sortnum, '$sex', '$age', '$major', '$graduate_time', '$college', '$phone', '$email', '$resumes', '$appraise', '$create_time', 0)";
	if($rst = $db->query($sql))
	{
		//$db->close();
		//echo "<script>alert('提交成功，我们稍后将处理您的申请！'); window.location.href='hr_display.php?id=$id'; </script>";
		//exit;
		$tip="提交成功,我们稍后将处理您的申请！";
	}
	else
	{
		$tip="提交失败，请稍后重试！";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?=$base_name?> - <?=$config_name?></title>
<link rel="stylesheet" href="skin/base.css" />
<link rel="stylesheet" href="skin/swiper.min.css" />
<link rel="stylesheet" href="skin/red/css.css" />
<script src="js/jquery.min.js"></script>
<script src="js/swiper.min.js"></script>
<script type="text/javascript">
	function check(form)
	{
		var phone = document.getElementById('phone').value;
		if (form.name.value == "")
		{
			alert("请输入您的姓名！");
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
		if (form.resumes.value == "")
		{
			alert("请输入您的个人履历！");
			form.resumes.focus();
			return false;
		}
	}
</script>
<? echo $config_webJavascriptHead;?>
</head>
<body>
<?
require_once("nav.php");
?>
<div id="g-wp" class="g-wp">
	<?
    require_once("begin.php");
    ?>
	<div class="u-tt box box-isd">
		<div class="hd">
			<h2><?=$base_name?></h2>
		</div>
		<div class="bd">
			<div class="hr">
				<dl class="hr-list">
					<dt class="title"><?=$job_name?></dt>
					<dd class="info"><?=$job_content?></dd>
				</dl>
			</div>
			<?
				if ($showForm == 1){
			?>
			<div class="form-panel">
				<h4 style="display:none;">在线填写应聘资料</h4>
				<div class="tips"><font color="#FF0000"><?=$tip?></font></div>
				<form action="" id="form_job" name="form_job" method="post" onSubmit="return check(this);">
					<ul>
						<li class="field">
							<div class="input">
								<input name="name" type="text" size="20" maxlength="50" class="text" placeholder="姓名" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input type="radio" name="sex" value="男" checked />&nbsp;男&nbsp;<input type="radio" name="sex" value="女" />&nbsp;女&nbsp;
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input name="age" type="text" size="5" maxlength="2" class="text" placeholder="年龄" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input name="major" type="text" size="40" maxlength="20" class="text" placeholder="专业" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input name="graduate_time" type="text" size="40" maxlength="30" class="text" placeholder="毕业时间" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input name="college" type="text" size="40" maxlength="20" class="text" placeholder="毕业院校" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input id="phone" name="phone" type="text" size="20" maxlength="11" class="text" placeholder="电话" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<input name="email" type="text" size="40" maxlength="30" class="text" placeholder="邮箱" />
							</div>
						</li>
						<li class="field">
							<div class="input">
								<textarea name="resumes" cols="60" rows="6" class="textarea" placeholder="个人履历"></textarea>
							</div>
						</li>
						<li class="field">
							<div class="input">
								<textarea name="appraise" cols="60" rows="6" class="textarea" placeholder="自我评价"></textarea>
							</div>
						</li>
						<li class="submit-field">
							<div class="input clearfix"><input type="submit" value="提交" class="btn-submit" /></div>
						</li>
					</ul>
				</form>
			</div>
			<?
				}
			?>
		</div>
	</div>
	<?
    require_once("end.php");
    ?>
</div>
<script>
$(function(){
	var _menu = $('.m-menu')
	$('.box-isd .col').on('click', function(){
		$('body').toggleClass('m-nav-show')
		_menu.stop().animate({right:0,opacity:1});
	})
	$('.m-mask').on('click', function(){
		$('body').removeClass('m-nav-show')
		_menu.stop().animate({right:'-50%',opacity:0});
	})
})
</script>
</body>
</html>