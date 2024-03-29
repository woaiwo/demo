<?
require(dirname(__FILE__) . "/init.php");
require(dirname(__FILE__) . "/isadmin.php");
require(dirname(__FILE__) . "/config.php");

//高级管理权限
if ($session_admin_grade != ADMIN_HIDDEN && $session_admin_grade != ADMIN_SYSTEM && hasInclude($session_admin_advanced, COUNTER_ADVANCEDID) == false)
{
	info("没有权限！");
}

$id		= trim($_GET["id"]);
$tt		= trim($_GET["tt"]);

$page = (int)$_GET["page"] > 0 ? (int)$_GET["page"] : 1;

$listUrl = "counter_list.php?page=$page&tt=$tt";

//连接数据库
$db = new onlyDB($config["db_host"], $config["db_user"], $config["db_pass"], $config["db_name"]);

if($id !=""){
	$sql = "delete from hit_counter where id =$id";
	if (!$db->query($sql))
	{
		$db->close();
		info("删除失败！");
	}
	else
	{
		$db->close();
		header("location: $listUrl");
		exit();
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id_array = $_POST["ids"];
	if (!is_array($id_array))
	{
		$id_array = array($id_array);
	}

	$db->query("begin");

	$sql = "delete from hit_counter where id in (" . implode(",", $id_array) . ")";
	$rst = $db->query($sql);

	if ($rst)
	{
		$db->query("commit");
		$db->close();
		header("Location: $listUrl");
		exit();
	}
	else
	{
		$db->query("rollback");
		$db->close();
		info("删除失败！");
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
<script src="js/list.js" id="list" data="true"></script>
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
                <li><i class="fa fa-angle-right"></i>高级功能</li>
                <li><i class="fa fa-angle-right"></i><span class="active">访问日志</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light  ">
                        <div class="portlet-title">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="caption"><a class="btn btn-shy btn-default tooltips" href="<?=$listUrl?>" data-placement="top" data-original-title="刷新列表"><i class="fa fa-eye"></i></a> <a class="btn btn-shy btn-default tooltips" href="javascript:if (CheckSomeConfirm('确定删除选中的记录吗？')){document.listForm.action.value='delete';document.listForm.submit();}" data-placement="top" data-original-title="批量删除"><i class="fa fa-remove"></i></a></div>
                                </div>
                                <div class="col-md-6 col-sm-6"> </div>
                            </div>
                        </div>
                        <div class="portlet-body table-responsive">
                            <form name="listForm" method="post">
                                <input type="hidden" name="action" value="" />
                                <table class="listTable table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="sample_1">
                                    <thead>
                                    	<tr class="heaer">
                                    		<th width="50" class="text-center table-checker"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkbox" /></th>
                                     		<th class="text-center">访问IP</th>
                                    		<th class="text-center">访问页面</th>
                                    		<th class="text-center">访问次数</th>
                                    		<th class="text-center">访问日期</th>
 											<th class="text-center">操作</th>
                                    	</tr>
                                    </thead>
                                    <tbody>
                                    	<?
										//设置每页数
					                    $page_size = DEFAULT_PAGE_SIZE;
					    				//总记录数

										$SQL_ ="where 1=1 ";
											switch ($tt){
												case 1:
													$SQL_ = $SQL_." and to_days(date) = to_days(now())";
													break;
												case 2:
													$SQL_ = $SQL_." and  YEARWEEK(date_format(date,'%Y%m%d'),1) = YEARWEEK(now(),1)";
													break;
												case 3:
													$SQL_ = $SQL_. " and  DATE_FORMAT( date, '%Y%m' ) = DATE_FORMAT( CURDATE(),'%Y%m' )";
													break;
												default:
													$SQL_ = "";
													break;
											}

					                    $sql = "select count(*) as cnt from hit_counter $SQL_";
					                    $rst = $db->query($sql);
					                    $row = $db->fetch_array($rst);
					                    $record_count = $row["cnt"];
					                    $page_count = ceil($record_count / $page_size);

					                    $page_str = page($page, $page_count, $pageUrl);
					                    // echo $page_str;

						                $sql = "select * from hit_counter $SQL_ order by id desc";
										// echo $sql;
						                $sql .= " limit " . ($page - 1) * $page_size . ", " . $page_size;
						                $rst = $db->query($sql);
						                while ($row = $db->fetch_array($rst)){
						                ?>
                                    	<tr class="<?if($i%2==1){echo "odd";}else{echo "even";}?>">
							                <th width="50" class="text-center table-checker"><input class="checkbox"  type="checkbox" name="ids[]" value="<?=$row["id"]?>" /></th>

					                        <th class="text-center"> <?=$row["ip"]?> </th>
					                        <th class="text-center"><?=$row["page"]?></th>
					                        <th class="text-center"><?=$row["counter"]?></th>
					                        <th class="text-center"><?=$row["date"]?></th>
 											<th class="text-center"> <a class="label label-sm label-danger tooltips" href="<?=$listUrl?>&id=<?=$row['id']?>" data-placement="top" data-original-title="删除信息"  onClick="return DeleteConfirm();">删</a></th>
                                    	</tr>
                                    	<?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
						<div class="row">
							<div class="col-md-5 col-sm-5 hidden-xs">
								<div class="records">第<?=$page?>页 共<?=$page_count?>页 共<?=$record_count?>条记录</div>
							</div>
							<div class="col-md-7 col-sm-7">
								<?=genPaginationBar($page, $page_count)?>
							</div>
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