<?
require(dirname(__FILE__) . "/init.php");
require(dirname(__FILE__) . "/isadmin.php");
require(dirname(__FILE__) . "/config.php");

$class_id	= trim($_GET["class_id"]);
$id			= trim(@$_GET["id"]);
if (empty($class_id) || !checkClassID($class_id, 1))
{
	info("参数有误！");
}

if (!empty($id) && !checkClassID($id, 2))
{
	info("参数有误！");
}

$listUrl = "second_class_list.php?class_id=$class_id&$id=$id";
$editUrl = "second_class_edit.php?class_id=$class_id&$id=$id";

//连接数据库
$db = new onlyDB($config["db_host"], $config["db_user"], $config["db_pass"], $config["db_name"]);

$sql = "select name, max_level, sub_pic from info_class where id='$class_id'";
$rst = $db->query($sql);
if ($row = $db->fetch_array($rst))
{
	$sup_class_name	 = $row["name"];
	$max_level		 = $row["max_level"];
	$sub_pic		 = $row["sub_pic"];
}
else
{
	$db->close();
	info("指定的一级分类不存在！");
}

//删除
if ($id != "")
{
	//是否允许删除
	if ($db->getTableFieldValue("info_class", "state", "where id='$id'") != 1 && $session_admin_grade != ADMIN_HIDDEN)
	{
		$db->close();
		info("分类不允许删除！");
	}

	//是否有子类
	if ($db->getCount("info_class", "id like '" . $id . CLASS_SPACE . "'") > 0)
	{
		$db->close();
		info("分类下有子类，请先删除子类！");
	}

	//是否有信息
	if ($db->getCount("info", "class_id='$id'") > 0)
	{
		$db->close();
		info("分类下有信息，请先删除信息！");
	}

	$sql = "select pic, files from info_class where id='$id'";
	$rst = $db->query($sql);
	if ($row = $db->fetch_array($rst))
	{
		$pic	= $row["pic"];
		$files	= $row["files"];
	}
	else
	{
		$db->close();
		info("指定的分类不存在！");
	}

	$sql = "delete from info_class where id='$id'";
	$rst = $db->query($sql);
	$db->close();
	if ($rst)
	{
		//删除图片、附件
		deleteFile($pic, 1);
		deleteFiles($files, 2);

		echo "<script>window.location='" . $listUrl . "';</script>";
		exit;
	}
	else
	{
		info("删除分类失败！");
	}
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>网站管理中心 v4.0</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="themes/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="themes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="themes/plugins/uniform/css/uniform.default.css" rel="stylesheet" />
<link href="themes/css/shy.css" rel="stylesheet" />
<link href="themes/css/shy-skin.css" rel="stylesheet" />
<script src="js/jquery.js"></script>
<script src="js/common.js"></script>
<script src="js/list.js" id="list" data="false"></script>
<script src="js/info.js"></script>
</head>
<body>
<?
	require_once("header.php");
?>
<div class="clearfix"></div>
<div class="page-container clearfix">
	<div class="page-content-wrapper">
		<?
		require_once("menu.php");
		?>
		<div class="page-content">
			<ul class="page-breadcrumb breadcrumb">
				<li><i class="fa fa-home"></i><a href="index.php">首页</a></li>
				<li><i class="fa fa-angle-right"></i><?=$sup_class_name?></li>
				<li><i class="fa fa-angle-right"></i><span class="active">二级分类管理</span></li>
			</ul>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="caption"><a class="btn btn-shy btn-default tooltips" href="<?=$editUrl?>" data-placement="top" data-original-title="添加信息"><i class="fa fa-plus-circle"></i></a> <a class="btn btn-shy btn-default tooltips" href="<?=$listUrl?>" data-placement="top" data-original-title="刷新列表"><i class="fa fa-eye"></i></a></div>
								</div>
								<div class="col-md-6 col-sm-6">
									 
								</div>
							</div>
						</div>
						<div class="portlet-body table-responsive">
							<table class="listTable table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="sample_1">
								<thead>
									<tr>
 										<th width="100" class="text-center hidden-xs">序号</th>
										<th class="text-center">分类名称</th>
										<?
						                if ($sub_pic == 1){
										?>
						                    <th class="text-center hidden-xs">图片</th>
						                <?
						                }
										?>
										<th class="text-center">记录状态</th>
										<?
						                if ($max_level > 2){
										?>
						                	<th class="text-center hidden-xs">子类管理</th>
						                <?
						                }
										?>
 										<th class="text-center">操作</th>
									</tr>
								</thead>
								<tbody>
									<?
									$sql = "select id, sortnum, name, info_state, pic, has_sub, state from info_class where id like '" . $class_id . CLASS_SPACE . "' order by sortnum asc";
									$rst = $db->query($sql);
									while ($row = $db->fetch_array($rst)){
									?>
									<tr class="<?if($i%2==1){echo "odd";}else{echo "even";}?>" >
										<th width="100" class="text-center hidden-xs"><?=$row["sortnum"]?></th>
										<th class="text-center "><a href="<?=$editUrl?>&id=<?=$row["id"]?>"><?=$row["name"]?></a></th>
										<?
					                    if ($sub_pic == 1){
					                    ?>
					                    	<th class="text-center hidden-xs">
												<?
							                		if (!empty($row["pic"])){
							                	?>
							                	<a id="pic<?=$row["id"]?>" href="javascript:pic('<?=$row["id"]?>', 'info_class', 'id', 'pic', '', '')" picUrl="<?=UPLOAD_PATH_FOR_ADMIN.$row["pic"]?>"><font color='#FF6600'>有</font></a></th>
							                	<?
							                		}else{
							                	?>
												<a id="pic<?=$row["id"]?>" href="javascript:pic('<?=$row["id"]?>', 'info_class', 'id', 'pic', '', '')" picUrl="">上传</a>
							                	<?
							                		}
							                	?>
					                        </th>
					                    <?
					                    }
										?>
					                    <th class="text-center ">
					                    	<?
					                        switch ($row["info_state"]){
												case "pic":
													echo "图片展示";
													break;
												case "list":
													echo "新闻列表";
													break;
												case "pictxt":
													echo "图文列表";
													break;
												case "content":
													echo "内容模式";
													break;
												case "custom":
													echo "<font color=#FF6600>自定义</font>";
													break;
												default :
													echo "<font color=#FF0000>错误</font>";
													break;
											}
											?>
					                    </th>
										<?
					                    if ($max_level > 2){
					                    ?>
				                        <th class="text-center   hidden-xs">
										<?
				                        if ($row["has_sub"] == 1){
				                        ?>
				                        	<a class="label label-sm label-primary tooltips" href="third_class_list.php?class_id=<?=$row["id"]?>" data-placement="top" data-original-title="管理">管理</a>
				                        <?
				                        }else{
			                        	?>
			                        	无
			                        	<?
				                        }
				                        ?>
				                        </th>
					                    <?
					                    }
										?>
										<th class="text-center ">
					                    	<?
					                        if ($row["state"] == 1 || $session_admin_grade == ADMIN_HIDDEN){
												if ($row["state"] == 1){
											?>
												<a class="label label-sm label-primary tooltips" href="<?=$editUrl?>&id=<?=$row["id"]?>" data-placement="top" data-original-title="编辑">编辑</a>
												<a class="label label-sm label-danger tooltips" href="<?=$listUrl?>&id=<?=$row["id"]?>" data-placement="top" data-original-title="删除" onClick="return confirm('该操作将同时删除此栏目下所有信息，删除后不能恢复。确定删除此栏目[<?=$row["name"]?>]吗？');">删</a>
					                        <?
												}else{
											?>
					                        	<a class="label label-sm label-danger tooltips" href="javascript:void(0);" data-placement="top" data-original-title="删除" onClick="return confirm('该操作将同时删除此栏目下所有信息，删除后不能恢复。确定删除此栏目[<?=$row["name"]?>]吗？');">删</a>
											<?
												}
					                        }
											?>
					                    </th>
									</tr>
									<?
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
	require_once("foot.php");
?>
</body>
</html>
