<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:58:"D:\wwwroot\raincms/application/admin\view\index\index.html";i:1490013763;s:60:"D:\wwwroot\raincms/application/admin\view\public\header.html";i:1490430863;s:60:"D:\wwwroot\raincms/application/admin\view\public\lefter.html";i:1490012391;s:61:"D:\wwwroot\raincms/application/admin\view\public\flooter.html";i:1490012391;}*/ ?>
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


<div class="container-fluid box-a">
	<div class="nav-c">
		<span class="glyphicon glyphicon-tag">&nbsp;<span id="">首页</span>
	</div>
	<box class="box-b">
		<div class="page-header page-a">
			<h2 style="margin-left: 50px;">欢迎使用<small>Rain验证系统&nbsp;!</small></h2>
			<div style="margin-left: 50px;">
				<span id="version">当前版本：<?php echo \think\Config::get('sysinfo.version'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="">服务器版本：<?php echo $appinfo['version']; ?></span>&nbsp;&nbsp;
				<button id="upsys" class="btn btn-primary"><?php echo $appinfo['btn']; ?></button>
			</div>
		</div>
		<div class="divs">
			<div class="row">
				<div class="col-md-3">
					<div class="bg-a metro">
						<div class="media">
							<div class="media-left">								
									<i style="color: #FFFFFF;font-size: 52px;" class="fa fa-user icon-top-15"></i>								
							</div>
							<div class="media-body">
								<h4 style="margin-top: 5px;" class="media-heading text-right">USER</h4><br />
								<h2 class="media-heading text-right"><?php echo $usernumber; ?></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-b metro">
						<div class="media">
							<div class="media-left">
								<a href="#">
									<i style="color: #FFFFFF;font-size: 52px;" class="fa fa-clone icon-top-15"></i>
								</a>
							</div>
							<div class="media-body">
								<h4 style="margin-top: 5px;" class="media-heading text-right">APP</h4><br />
								<h2 class="media-heading text-right"><?php echo $appnumber; ?></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-c metro">
						<div class="media">
							<div class="media-left">
								<a href="#">
									<i style="color: #FFFFFF;font-size: 52px;" class="fa fa-credit-card icon-top-15"></i>
								</a>
							</div>
							<div class="media-body">
								<h4 style="margin-top: 5px;" class="media-heading text-right">充值卡</h4><br />
								<h2 class="media-heading text-right"><?php echo $cardnumber; ?></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-d metro">
						<div class="media">
							<div class="media-left">
								<a href="#">
									<i style="color: #FFFFFF;font-size: 52px;" class="fa fa-address-card-o icon-top-15"></i>
								</a>
							</div>
							<div class="media-body">
								<h4 style="margin-top: 5px;" class="media-heading text-right">授权码</h4><br />
								<h2 class="media-heading text-right"><?php echo $acardnumber; ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style type="text/css">
			.table-bordered {
                border: 0px solid #dddddd;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 0px solid #dddddd;
                border-bottom: 1px solid #dddddd;
            }
		</style>
		<div class="row">
			<div class="col-md-6">
					<div class="table-responsive container-fluid diva">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th colspan="2">系统信息</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">登录用户</th>
									<td><?php echo \think\Session::get('username'); ?></td>
								</tr>
								<tr>
									<td scope="row">登录次数</td>
									<td><?php echo $logincount; ?></td>
								</tr>
								<tr>
									<td scope="row">本次登录IP</td>
									<td><?php echo \think\Request::instance()->server('remote_addr'); ?></td>
								</tr>
								<tr>
									<td scope="row">上次登录IP</td>
									<td><?php echo $lastloginip; ?></td>
								</tr>
								<tr>
									<td scope="row">上次登录时间</td>
									<td><?php echo $lastlogintime; ?></td>
								</tr>

								<tr>
									<td scope="row">版本</td>
									<td><?php echo \think\Config::get('sysinfo.version'); ?></td>
								</tr>
								<tr>
									<td scope="row">内核版本</td>
									<td><?php echo THINK_VERSION; ?></td>
								</tr>
								<tr>
									<td scope="row">联系QQ</td>
									<td><?php echo \think\Config::get('sysinfo.qq'); ?></td>
								</tr>
								<tr>
									<td scope="row">官方网址</td>
									<td><a href="<?php echo \think\Config::get('sysinfo.website'); ?>"><?php echo \think\Config::get('sysinfo.website'); ?></a></td>
								</tr>
								<tr>
									<td scope="row">版权申明</td>
									<td><?php echo \think\Config::get('sysinfo.copyright'); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				
			</div>
			<div class="col-md-6">
				<div class="table-responsive container-fluid divb">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th colspan="2">服务器信息</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">网站域名</th>
								<td><?php echo \think\Request::instance()->server('server_name'); ?></td>
							</tr>
							<tr>
								<td scope="row">服务器IP地址</td>
								<td><?php echo \think\Request::instance()->server('server_addr'); ?></td>
							</tr>
							<tr>
								<td scope="row">服务器端口</td>
								<td><?php echo \think\Request::instance()->server('server_port'); ?></td>
							</tr>
							<tr>
								<td scope="row">服务器时间</td>
								<td id="time"><?php echo time2date(time()); ?></td>
							</tr>
							<tr>
								<td scope="row">网站服务器版本</td>
								<td><?php echo \think\Request::instance()->server('server_software'); ?></td>
							</tr>
							<tr>
								<td scope="row">网站所在路径</td>
								<td><?php echo \think\Request::instance()->server('document_root'); ?></td>
							</tr>

							<tr>
								<td scope="row">服务器系统信息</td>
								<td>
									<?php echo php_uname(); ?>
								</td>
							</tr>
							<tr>
								<td scope="row">服务器当前时间</td>
								<td>
									<?php echo date('Y-m-d H:i:s',time()); ?>
								</td>
							</tr>
							<tr>
								<td scope="row">PHP版本</td>
								<td>
									<?php echo phpversion(); ?>
								</td>
							</tr>
							<tr>
								<td scope="row">MYSQL版本</td>
								<td><?php echo $mysqlv; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</box>
</div>

	</body>
	<script src="__PLUG__/jquery/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/bootstrap/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/layer/layer.js" type="text/javascript" charset="utf-8"></script>
</html>		

<script type="text/javascript">
		$(document).ready(function() {
			$('#upsys').click(function() {
				$('#upsys').html('<i class="fa fa-refresh fa-spin"></i>更新中......');	    
				$.ajax({
					type: "get",
					url: "<?php echo URL('/admin/index/upsys'); ?>",
					success: function(msg) {
						layer.msg('更新完成,请刷新页面，更新大小：'+msg.file_size);
						$('#upsys').text('更新完成');
					}
				});
				return false;
			});
			$('#ulexit').click(function() {
				var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
				parent.layer.close(index);
				return false;
			});
		});				
	</script>