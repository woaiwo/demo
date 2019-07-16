<?
	require("adver.php");

	$surl = $_SERVER['HTTP_HOST'];
	$nurl = "ibw.cc";
	$boss  =  substr_count($surl, $nurl);

    if ($boss==1){
    	if ($_COOKIE["vcode"]<>$vcodeConst){
 			header("location: visit.php");
			exit;
		}
    }
?>
<div class="wrapper">
	<div class="header">
		<div class="siteNav">
			<div class="wrap clearfix">
				<div class="fav"><a onclick="setHome(this,window.location);" href="javascript:void(0);">设为首页</a>|<a onclick="addFavorite(document.location.href, document.title);" href="javascript:void(0);">收藏本站</a>|<a href="sitemap.php" target="_blank">网站地图</a><?if($_SESSION['userid'] == ""){?>|<a href="user_login.php" target="_blank">登录</a>|<a href="user_reg.php" target="_blank">注册</a><?}else{?>|<a href="user_center.php
				"><? echo $_SESSION['username']; ?></a>,欢迎您！|<a href="user_logout.php" onclick="if (confirm('确定要退出吗？')) return true; else return false;">退出</a><?}?>|<a href="m">手机版</a></div>
				<div class="search">
					<form action="search.php" method="get">
						<input type="text" name="search_keyword" placrholder="请输入关键词.." x-webkit-speech>
						<input type="submit" value="搜索">
					</form>
				</div>
			</div>
		</div>
		<div class="topArea">
			<div class="wrap clearfix">
				<?
					$sql ="select pic from banner where class_id = 1 and pic<>'' and state >0 limit 1";
					$rst = $db -> query($sql);
					while ($row = $db -> fetch_array($rst)){
				?>
				<div class="logo"><a href="default.php"><img src="<?=UPLOAD_PATH . $row['pic']?>" width="198" height="77" alt="<?=$config_name?>"></a></div>
				<?
					}
				?>
				<div class="nav">
					<dl>
						<dt <? if($menu == "default") echo "class='current'" ?>><a href="./">网站首页</a><i></i></dt>
						<?
							for($i=0; $i<4; $i++){
						?>
						<dt <? if($baseClassArray[$i]['id'] == $base_id) echo "class='current'" ?>><a href="info.php?class_id=<?=$baseClassArray[$i]['id']?>"><?=$baseClassArray[$i]['name']?></a><i></i>
							<ul class="sub">
								<?
									$sql ="select id, name from info_class where id like '". $baseClassArray[$i]['id'] ."___' order by sortnum asc";
									$rst = $db -> query($sql);
									while ($row = $db -> fetch_array($rst)){
								?>
								<li><a href="info.php?class_id=<?=$row["id"]?>"><?=$row["name"]?></a></li>
								<?
									}
								?>
							</ul>
						</dt>
						<?
							}
						?>
						<dt <? if($menu == "job") echo "class='current'" ?>><a href="job.php">人才招聘</a><i></i></dt>
						<dt <? if($menu == "message") echo "class='current'" ?>><a href="message.php">在线留言</a><i></i></dt>
						<dt <? if($class_id == "105") echo "class='current'" ?>><a href="info.php?class_id=105">联系我们</a><i></i></dt>
					</dl>
				</div>
				<script>
					$(".nav dt").hover(function(){$(this).find(".sub").stop().slideToggle(500)});
				</script>
				<div class="tel">安徽地区服务热线：<s><?=$config_hotline?></s></div>
			</div>
		</div>
		<div class="banner">
			<?
				if($menu =="default"){
			?>
			<div class="bd">
				<ul>
					<?
						$sql ="select pic, url from banner where class_id = 2 and pic<>'' and state >0 limit 5";
						$rst = $db -> query($sql);
						while($row = $db -> fetch_array($rst)){
					?>
					<li><a href="<?=$row['url']?>"><img src="<?=UPLOAD_PATH . $row['pic']?>" width="1920" height="635" /></a></li>
					<?
						}
					?>
				</ul>
			</div>
			<div class="hd"><ul></ul></div>
			<a class="prev" href="javascript:void(0)"></a>
			<a class="next" href="javascript:void(0)"></a>
			<?
				}else{
				$sql = "select pic from banner where class_id = 3 and pic<>'' and state >0 limit 1";
				$rst = $db -> query($sql);
				while($row = $db -> fetch_array($rst)){
			?>
			<img src="<?=UPLOAD_PATH . $row['pic']?>" width="1920" height="300" />
			<?
					}
				}
			?>
		</div>
		<script>
			$(".banner").slide({titCell:".hd ul",mainCell:".bd ul",autoPlay:true,autoPage:true});
			$(".banner").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeToggle()});
		</script>
	</div>