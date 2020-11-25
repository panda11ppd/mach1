<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\wwwroot\raincms/application/install\view\index\step3.html";i:1490012391;s:62:"D:\wwwroot\raincms/application/install\view\public\header.html";i:1490012391;}*/ ?>
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
			<li class="nav-item active">
				<span class="nav-link">——————></span>
			</li>
			<li class="nav-item active">
				<a class="nav-link">创建数据</a>
			</li>
			<li class="nav-item active">
				<span class="nav-link">——————></span>
			</li>
			<li class="nav-item active">
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
			<h3>安装ing.....</h3>
		</div>
		<div class="body-box">
			<div class="col-md-9">
                 <p><b style="color:green">正在安装程序，请稍后...</b></p>
			</div>
            <div class="col-md-9" id="show-list">
                 <p></p>
			</div>
		</div>
	</div>
</div>
<div class="container" style="margin-top: 20px;">
	<p class="text-right">版权所有 (c) 2016，www.rain68.com。</p>
</div>

</body>
<script type="text/javascript">
        var list   = document.getElementById('show-list');
        function showmsg(msg, classname){
            var li = document.createElement('p'); 
            li.innerHTML = msg;
            classname && li.setAttribute('class', classname);
            list.appendChild(li);
            list.scrollTop += 30;
        }
</script>
</html>
