<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\wwwroot\raincms/application/install\view\index\step2.html";i:1490421625;s:62:"D:\wwwroot\raincms/application/install\view\public\header.html";i:1490012391;}*/ ?>
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
			<h3>安装数据库</h3>
		</div>
		<div class="body-box">
			<form id="form">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-2 form-control-label text-right">数据库类型</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="DATA TYPE" type="text" name="db[]" value="mysql">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库地址</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="HOST" type="text" name="db[]" value="127.0.0.1">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库名</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="DATA NAME" type="text" name="db[]" value="">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库用户名</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="DATA USERNAME" type="text" name="db[]" value="root">
					</div>
				</div>

				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库密码</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="PASSWORD" type="password" name="db[]">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库端口</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="PORT" type="text" name="db[]" value="3306">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">数据库表前缀</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="PREFIX" type="text" name="db[]" value="rain_">
					</div>
				</div>

				<div style="border-bottom: 1px solid #F1F1F1; margin: 20px;">
			    <h3>管理员信息</h3>
		        </div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">管理员邮箱</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="admin@admin.com" type="text" name="admin[]" value="admin@admin.com">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">用户名</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="username" type="text" name="admin[]" value="admin">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">密码</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="password" type="text" name="admin[]" value="123456">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 form-control-label text-right">密码</label>
					<div class="col-sm-6">
						<input class="form-control" placeholder="password" type="text" name="admin[]" value="123456">
					</div>
				</div>
				<!--<input type="hidden" id="input10" name="admin[]" value="admin">
				<input type="hidden" id="input11" name="admin[]" value="123456">
				<input type="hidden" id="input10" name="admin[]" value="123456">
				<input type="hidden" id="input11" name="admin[]" value="88888888@qq.com">-->
				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-6">
						<a href="<?php echo url('index/step1'); ?>" role="button" class="btn btn-primary">上一步</a>
						<button type="button" id="but" class="btn btn-warning">安装	</button>											
					</div>
				</div>
			</form>			
		</div>
	</div>
</div>
<div class="container" style="margin-top: 20px;">
	<p class="text-right">版权所有 (c) 2016，www.rain68.com。</p>
</div>

</body>
<script src="__PLUG__/layer/layer.js"></script>
<script>

$('#but').click(function(event) {
		index = layer.load(1, {
			offset: ['50%', '50%'],
			shade: [0.1,'#fff'] //0.1透明度的白色背景
		});
		// $('form').submit();
		$.ajax({
        cache:true,
        type :"POST",
        url  :'<?php echo url('index/step2'); ?>',
        data :$('#form').serialize(),
        async:false,
           success:function(data){
           	layer.close(index);
            if(data.code){
                location.href=data.url;
            } else {
            	layer.msg(data.msg);
             
            }
           },
           error:function(request){
           	layer.close(index);
           	layer.msg("数据库创建失败，请检查数据库信息是否填写正确");
            
           }
      }); 
	});
</script>
</html>