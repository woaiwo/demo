<div class="sidebar">
	<h2 class="leftTitle"><i><?=$base_name?></i><s><?=$base_en_name?></s></h2>
	<div class="menu">
		<dl>
			<?
				if($_SESSION['userid'] == ""){
			?>
			<dt><a <?if($menu=="user_login"){echo "class='current'";}?> href="user_login.php">会员登录</a></dt>
			<dt><a <?if($menu=="user_reg"){echo "class='current'";}?> href="user_reg.php">会员注册</a></dt>
			<?
			}else{
			?>
			<dt><a <?if($menu=="user_center"){echo "class='current'";}?> href="user_center.php">会员中心</a></dt>
			<dt><a <?if($menu=="user_info"){echo "class='current'";}?> href="user_info.php">会员资料</a></dt>
			<dt><a <?if($menu=="user_changePass"){echo "class='current'";}?> href="user_changePass.php">修改密码</a></dt>
			<dt><a href="user_logout.php" onClick="if (confirm('您确定要退出吗？')) return true; else return false;">退出登录</a></dt>
			<?
			}
			?>
		</dl>
	</div>
</div>