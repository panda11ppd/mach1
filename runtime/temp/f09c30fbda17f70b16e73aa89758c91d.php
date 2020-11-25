<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:58:"D:\wwwroot\raincms/application/admin\view\order\index.html";i:1490335331;s:60:"D:\wwwroot\raincms/application/admin\view\public\header.html";i:1490430863;s:60:"D:\wwwroot\raincms/application/admin\view\public\lefter.html";i:1490012391;s:61:"D:\wwwroot\raincms/application/admin\view\public\flooter.html";i:1490012391;}*/ ?>
<!--acardindex-->
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

<link rel="stylesheet" type="text/css" href="__PLUG__/bootstrap-table/bootstrap-table.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/table.css" />
<div class="container-fluid box-a">
	<div class="nav-c">
		<span class="glyphicon glyphicon-tag">&nbsp;</span><span>支付帐单</span>
	</div>
	<box class="box-b">
		<div class="divs">
			<div id="toolbar">
				<!--<a role="button" href="<?php echo URL('/admin/acard/add'); ?>" type="button" class="btn btn-primary">生成授权码</a>-->
			</div>
			<div class="table-responsive" data-show-refresh="true">
				<table id="table">
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

<script type="text/javascript" src="__PLUG__/bootstrap-table/bootstrap-table.js"></script>
<script type="text/javascript" src="__PLUG__/bootstrap-table/locale/bootstrap-table-zh-CN.js"></script>
<script type="text/javascript" src="__PLUG__/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
<script type="text/javascript" src="__PLUG__/bootstrap-table/extensions/export/tableExport.js"></script>



<script type="text/javascript">
    var $table = $('#table');
	$(document).ready(function() {		
		$table.bootstrapTable({
			classes: 'table table-hover',
			paginationPreText: '上一页',
			paginationNextText: '下一页',
			pagination: true,
			search: true,
			searchOnEnterKey: true,
			showColumns: true,
			showRefresh: true,
			showToggle: true,
			showPaginationSwitch: true,
			idField: 'uid',
			showexport: true,
			uniqueId: 'uid',
			toolbar: '#toolbar',
			showExport: true,
			sidePagination: 'server',
			url: '__ROOT__/admin/order/lists',
			columns: [{
				field: 'id',
				title: '订单号',
				align: 'center'
			}, {
				field: 'trade_no',
				title: '交易号',
				editable: true,
				align: 'center'
			},{
				field: 'user',
				title: '用户',
				editable: true,
				align: 'center'
			},{
				field: 'sname',
				title: '商品类型',
				editable: true,
				align: 'center'
			},{
				field: 'name',
				title: '商品名',
				editable: true,
				align: 'center'
			},{
				field: 'date',
				title: '日期',
				editable: true,
				align: 'center'
			},{
				field: 'money',
				title: '金额',
				editable: true,
				align: 'center'
			},{
				field: 'num',
				title: '数量',
				editable: true,
				align: 'center'
			},{
				field: 'trade_status',
				title: '交易状态',
				editable: true,
				align: 'center'
			},{
				field: 'op',
				title: '操作',				
				editable: true,
				formatter: oper,
				align: 'center'
			},],
		});

		function oper(value, row, index) {			
			
			var id = row.id;
			var status=row.trade_status;
			
			var opdata = '';
			    if (status=='<span style="color:#009900">未完成</span>') {
			    	opdata += '<button style="margin-right: 5px" type="button" title="删除" class="btn btn-xs btn-del" onclick="set(\'del\',\'' + id + '\')"><i class="fa fa-trash"></button>';			    	
			    } 
			    if(status=='<span style="color:red">交易成功</span>') {
			    	opdata += '<button style="margin-right: 5px" type="button" title="删除" class="btn btn-xs btn-delx" disabled><i class="fa fa-trash"></button>';
			    }			    					    				
			return opdata;
		}

		function vid(value, row, index) {
			//var row=index;
			return index;
		}
	});

	function set(sets,id) {
		var $table = $('#table');
		
		if(sets=='del'){
			layer.confirm('<i style="color:#FF6633" class="icon-warning-sign icon-2x"></i> 是否删除订单 '+id+'?', {
                btn: ['确定','取消'] //按钮
            }, function(){
            	del(id);           
            }, function(){           	
            });
		}	
			
		
	}
    function del(id){
		var $table = $('#table');
		$.get("__ROOT__/admin/order/set", {
			orderset:'del',
			id: id,
		}, function(response) {
			$table.bootstrapTable('refresh', {silent: true});
			if (response) {					
				layer.msg(response);
			} else {
                layer.alert('操作失败！请重试！');					
			}
		});
	}
    function retable(index, layero){
    	$table.bootstrapTable('refresh', {silent: true});
    }
</script>

