<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\wwwroot\raincms/application/install\view\index\step1.html";i:1490012391;s:62:"D:\wwwroot\raincms/application/install\view\public\header.html";i:1490012391;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RainCMS安装向导</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="__PLUG__/bootstrap4/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/static/install/css/style.css"/>
	<script src="__PLUG__/jquery/jquery.min.js"></script>
	<script src="__PLUG__/bootstrap4/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>	
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-dark" style="background-color: rgb(34, 37, 42);height: 61px; ">
	<div class="container" style="margin-top: 5px;">
		<a class="navbar-brand">RainCMS</a>
	<ul class="nav navbar-nav">
		<li class="nav-item active">
			<a class="nav-link">安装协议 <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
			<span class="nav-link active">——————></span>
		</li>
		<li class="nav-item active">
			<a class="nav-link">环境检测</a>
		</li>
		<li class="nav-item">
			<span class="nav-link">——————></span>
		</li>
		<li class="nav-item">
			<a class="nav-link">创建数据</a>
		</li>
		<li class="nav-item">
			<span class="nav-link">——————></span>
		</li>
		<li class="nav-item">
			<a class="nav-link">安装</a>
		</li>
		<li class="nav-item">
			<span class="nav-link">——————></span>
		</li>
		<li class="nav-item">
			<a class="nav-link">完成</a>
		</li>
	</ul>
		
	</div>	
</nav>
<div class="container" style="margin-top: 80px;">
	<div class="row">
		<div class="body-box" style="border-bottom: 0px;">
			<h3>环境检测</h3>
		</div>
		<div class="body-box">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>检测项目</th>
							<th>最低需求</th>
							<th>当前配置</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($env) || $env instanceof \think\Collection || $env instanceof \think\Paginator): $i = 0; $__LIST__ = $env;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$env): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><?php echo $env['0']; ?></td>
							<td><?php echo $env['1']; ?></td>
							<td><?php echo $env['2']; ?></td>
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="body-box" style="border-bottom: 0px;">
			<h3>文件权限检测</h3>
		</div>
		<div class="body-box">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>目录/文件</th>
							<th>运行要求</th>
							<th>当前状态</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($dirfile) || $dirfile instanceof \think\Collection || $dirfile instanceof \think\Paginator): $i = 0; $__LIST__ = $dirfile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dirfile): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><?php echo $dirfile['3']; ?></td>
							<td>可写</td>
							<td><?php echo get_write_color($dirfile['1']); ?></td>
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="body-box" style="border-bottom: 0px;">
			<h3>运行函数检测</h3>
		</div>
		<div class="body-box">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>函数名称</th>
							<th>运行要求</th>
							<th>检测结果</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($fun) || $fun instanceof \think\Collection || $fun instanceof \think\Paginator): $i = 0; $__LIST__ = $fun;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fun): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><?php echo $fun['0']; ?></td>
							<td>支持</td>
							<td><?php echo get_fun_color($fun['1']); ?></td>
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="body-box" style="border-top: 0px;height: 66px;">
		<a href="<?php echo url('index/step2'); ?>" type="button" class="btn btn-primary pull-right">下一步</a>
		<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<a href="<?php echo url('/install/index'); ?>" type="button" class="btn btn-primary pull-right">上一步</a>
	</div>

	<div class="container" style="margin-top: 20px;">
		<p class="text-right">版权所有 (c) 2016，www.rain68.com。</p>
	</div>

</body>

</html>
