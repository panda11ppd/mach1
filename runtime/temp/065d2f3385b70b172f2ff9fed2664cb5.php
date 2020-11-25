<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"D:\wwwroot\raincms/application/admin\view\netset\db_bak.html";i:1490012391;s:60:"D:\wwwroot\raincms/application/admin\view\public\header.html";i:1490430863;s:60:"D:\wwwroot\raincms/application/admin\view\public\lefter.html";i:1490012391;s:61:"D:\wwwroot\raincms/application/admin\view\public\flooter.html";i:1490012391;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="renderer" content="webkit">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
		<title>RainManager</title>
		<link rel="stylesheet" type="text/css" href="__PLUG__/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="__PLUG__/font-awesome-4.7.0/css/font-awesome.min.css"/>
	    <link rel="stylesheet" type="text/css" href="__CSS__/style.css"/>
	    
       
        
   

		<!-- Bootstrap -->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
        <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>

	<body>
		<nav class="navbar navbar-default" style="background-color: #373D41;">
			<div class="container-fluid" style="background-color: #373D41;">
				<div class="navbar-header">
					<a style="color: #FFFFFF;" href="<?php echo URL('/index/login/quit'); ?>" type="button" class="navbar-toggle collapsed">
						<i class="fa fa-sign-out"></i>
                    </a>
					<a class="navbar-brand" style="background: #373D41;font-size: 24px;width: 50px;" href=""><i class="fa fa-codepen"></i></a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="border-left nav-li"><a href="<?php echo URL('/admin/index'); ?>" style="font-size: 14px;">管理控制台</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown nav-li">
                        <a href="#" class="dropdown-toggle useredit" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-user"></i>&nbsp;<?php echo $loginuser; ?><span class="caret"></span>&nbsp;</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL('/admin/index/uloginedit'); ?>">编辑资料</a></li>                            
                        </ul>
                       </li>							                    
                            <li class="nav-li"><a href="<?php echo URL('/'); ?>">&nbsp;&nbsp;<span class="glyphicon glyphicon-home"></span>&nbsp;网站首页</a></li>
                            <li class="nav-li"><a href="<?php echo URL('/index/login/quit'); ?>">&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;退出</a></li>
					</ul>
				</div>
			</div>
		</nav>	
		
 
<div class="nav-left">
	<div class="menu-a">
		<ul class="nav nav-pills nava nav-stacked">
        <li><a id="lefttop"><span style="font-size: 12px;" class="fa fa-reorder"></span></a></li>        
        </ul>
	</div>
	<?php if(is_array($leftinfo) || $leftinfo instanceof \think\Collection || $leftinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $leftinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($vo['menu_levelid'] == 0)): ?>
	    <ul class="nav navs <?php if(($vo['id'] == $levelid)): ?>nav-action<?php endif; ?> nav-pills nav-stacked meun-b">				
		    <li class="hidden-xs">
			    <a href="#<?php echo $vo['tabs']; ?>" class="nav-header collapsed in" aria-expanded="true" data-toggle="collapse">				
			        <i class="fa fa-caret-down icon-w">&nbsp;</i><?php echo $vo['menu_name']; ?><i class="<?php echo $vo['menu_icon']; ?> m-ico pull-right">&nbsp;</i>
			    </a>
		    </li>
		    <li class="visible-xs">
			    <a href="#<?php echo $vo['tabs']; ?>" class="nav-header collapsed in" aria-expanded="true" data-toggle="collapse">				
			        &nbsp;</i><i class="<?php echo $vo['menu_icon']; ?>">&nbsp;</i>
			    </a>
		    </li>
            <li class="">
	            <ul id="<?php echo $vo['tabs']; ?>" class="nav nav-pills nav-stacked meun-c collapse <?php if(($vo['id'] == $levelid)): ?>in<?php endif; ?>" aria-expanded="false">		
		        <?php if(is_array($leftinfo) || $leftinfo instanceof \think\Collection || $leftinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $leftinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i;if(($mo['menu_levelid'] == $vo['id'])): ?>		           
		            <li class="hidden-xs <?php if(($action == $mo['menu_name']) or ($controller == $mo['menu_name'])): ?>active<?php endif; ?>"><a href="<?php echo url($mo['menu_url']); ?>"><i class="<?php echo $mo['menu_icon']; ?> fa-lg icon-x"></i><?php echo $mo['menu_name']; ?></a></li>
		            <li class="visible-xs <?php if(($action == $mo['menu_name']) or ($controller == $mo['menu_name'])): ?>active<?php endif; ?>"><a href="<?php echo url($mo['menu_url']); ?>"><i class="<?php echo $mo['menu_icon']; ?> fa-lg"></i></a></li>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </li>
        </ul>	    
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>		
</div>
<!--<div class="nav-left-2">
	<div class="menu-a-2">&nbsp;&nbsp;&nbsp;&nbsp;
		<span style="font-size:12px;margin-top:0px ;font-weight: bold;">标题</span>        
    </div>
    <ul class="nav nav-x nav-pills nav-pills-x nav-stacked meun-c">		
		<li class=""><a href="">&nbsp;&nbsp;&nbsp;&nbsp;添加文章</a></li>
		<li class="active"><a href="">&nbsp;&nbsp;&nbsp;&nbsp;编辑文章</a></li>
		<li class=""><a href="">&nbsp;&nbsp;&nbsp;&nbsp;添加分类</a></li>
    </ul>
</div>-->

<link rel="stylesheet" type="text/css" href="__PLUG__/bootstrap-table/bootstrap-table.css"/>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/table.css" />
<div class="container-fluid box-a">
	<div class="nav-c">
		<span class="glyphicon glyphicon-tag">&nbsp;</span><span>数据备份</span>
	</div>
	<box class="box-b">
		<div class="divs">		
			<div id="toolbar">
			    <button id="addbak" type="button" class="btn btn-primary" onclick="handle('backup')">添加备份</button>
			</div>			
			<div class="table-responsive">
				<table id="dbbak" class="table table-striped" data-url="baklist">
				</table>
			</div>
		</div>		
	</box>
</div>
<!--<a class="btn btn-xs btn-success" href="/index.php/admin/netset/bak/tp/dowonload/name/20160517154306.sql.html">下载</a>-->
	</body>
	<script src="__PLUG__/jquery/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/bootstrap/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/layer/layer.js" type="text/javascript" charset="utf-8"></script>
</html>		

<script src="__PLUG__/bootstrap-table/bootstrap-table.js" type="text/javascript" charset="utf-8"></script>
<script src="__PLUG__/bootstrap-table/locale/bootstrap-table-zh-CN.js" type="text/javascript" charset="utf-8"></script>
<script src="__PLUG__/layer/layer.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    var $dbtable = $('#dbbak');
	$(document).ready(function() {		
		$dbtable.bootstrapTable({
			classes: 'table-hover',
			pagination: true,
			search: true,
			searchOnEnterKey: true,
			showColumns: true,
			showRefresh: true,
			showToggle: true,
			showPaginationSwitch: true,
			idField: 'id',
			uniqueId: 'name',
			toolbar: '#toolbar',
			columns: [{
				field: 'id',
				title: '序号',
				formatter: vid,
				align: 'center'
			}, {
				field: 'name',
				title: '备份名称',
				sortable: true,
				editable: true,				
				align: 'center'
			}, {
				field: 'time',
				title: '备份时间',
				sortable: true,
				editable: true,				
				align: 'center'
			}, {
				field: 'size',
				title: '备份大小',
				sortable: true,
				editable: true,
				align: 'center'
			}, {
				field: 'op',
				title: '操作',
				editable: true,
				formatter: oper,
				align: 'center'
			}],
			url: 'baklist',
			//url: 'http://www.app.com/ss.txt',
			//data: [{"name":"20160524163020.sql","time":"2016-05-24 16:30:20","size":"14.05KB"},{"name":"20160524163619.sql","time":"2016-05-2416:36:19","size":"14.05KB"},{"name":"20160524165738.sql","time":"2016-05-24 16:57:38","size":"14.05KB"}]
		});

		function oper(value, row, index) {
			var durl = '<?php echo URL("/admin/netset/bak/tp/dowonload/name/'+row.name+'"); ?>';
			
			var opf = row.name;
			var opdata = '<a style="margin-right: 5px" class="btn btn-xs btn-success" href="' + durl + '">下载</a>';
			opdata += '<button style="margin-right: 5px" type="button" class="btn btn-xs btn-warning" onclick="handle(\'restore\',\'' + opf + '\')">还原</button>';
			opdata += '<button type="button" class="btn btn-xs btn-danger" onclick="handle(\'del\',\'' + opf + '\')">删除</button>';
			return opdata;
		}

		function vid(value, row, index) {
			
			return index;
		}
	});

	function handle(tp, name) {
		var $dbtable = $('#dbbak');
		if (tp) {
			if (tp=='del'){
				$dbtable.bootstrapTable('removeByUniqueId', name);
			}			
			$.post("<?php echo url('bak'); ?>", {
				tp: tp,
				name: name
			}, function(response) {
				$dbtable.bootstrapTable('refresh', {silent: true});
				if(response) {
					
					mes(response);
				} else {
                    mes("操作失败，请重试!!");					
				}
			});
		}
	}

	function mes(res) {        
       layer.msg(res,{
            time: 1000,});
       }
</script>