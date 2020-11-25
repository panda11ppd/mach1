<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:59:"D:\wwwroot\raincms/application/admin\view\netset\index.html";i:1490186629;s:60:"D:\wwwroot\raincms/application/admin\view\public\header.html";i:1490430863;s:60:"D:\wwwroot\raincms/application/admin\view\public\lefter.html";i:1490012391;s:61:"D:\wwwroot\raincms/application/admin\view\public\flooter.html";i:1490012391;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__PLUG__/bootstrapvalidator/css/bootstrapValidator.min.css" />
<div class="container-fluid box-a">
	<div class="nav-c">
		<span class="glyphicon glyphicon-tag">&nbsp;</span><span>网站设置</span>
	</div>
	<box class="box-b">
		<div class="divs" class="col-sm-6">
			<div class="page-header page-s">
				<h3>网站设置<small></small></h3>
			</div>
			<ul id="myTab" class="nav nav-tabs nav-div">
				<li class="active">
					<a href="#home" data-toggle="tab">基本设置</a>
				</li>
				<li>
					<a href="#regs" data-toggle="tab">注册与访问控制</a>
				</li>
			</ul>
			<form style="margin-top: 20px;" id="netform" class="form-horizontal" action="" method="post">
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade in active" id="home">
						<div class="form-group">
							<label for="inputnetonoff" class="col-sm-2 col-md-2 col-lg-1 control-label">调试模式</label>
							<div class="col-sm-2 col-lg-2">
								<label class="radio-inline">
                        <input type="radio" name="app_debug" id="inlineneton" value="TRUE" <?php if(config('app_debug') == TRUE): ?>checked<?php endif; ?>> 开
                    </label>
								<label class="radio-inline">
                        <input type="radio" name="app_debug" id="inlinenetoff" value="FALSE" <?php if(config('app_debug') == FALSE): ?>checked<?php endif; ?>> 关
                    </label>
							</div>
							<label class="control-label" style="color: red;" for="inputnetname">正式运营后请关闭此项</label>
						</div>
						<div class="form-group">
							<label for="inputnetonoff" class="col-sm-2 col-md-2 col-lg-1 control-label">网站开关</label>
							<div class="col-sm-8">
								<label class="radio-inline">
                        <input type="radio" name="status" id="inlineneton" value="1" <?php if(config('netinfo.status') == 1): ?>checked<?php endif; ?>> 开
                    </label>
								<label class="radio-inline">
                        <input type="radio" name="status" id="inlinenetoff" value="0" <?php if(config('netinfo.status') == 0): ?>checked<?php endif; ?>> 关
                    </label>
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">通讯KEY</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="key" class="form-control" id="inputname" placeholder="rain" value="<?php echo \think\Config::get('netinfo.key'); ?>" />
							</div>
							<label style="color: red;" for="inputnetname" class="control-label">设置后请不要更改，以免验证出现问题！</label>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">网站名称</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="name" class="form-control" id="inputname" placeholder="rain" value="<?php echo \think\Config::get('netinfo.name'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">网站关键词</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="keyword" class="form-control" id="inputname" placeholder="验证,软件,应用" value="<?php echo \think\Config::get('netinfo.keyword'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputdesc" class="col-sm-2 col-md-2 col-lg-1 control-label">网站描述</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<textarea class="form-control textarea" rows="5" name="description" placeholder="rain网络验证"><?php echo \think\Config::get('netinfo.description'); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">版权信息</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="copyright" class="form-control" id="inputname" placeholder="Rain版权所有" value="<?php echo \think\Config::get('netinfo.copyright'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">客服链接</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="cservice" class="form-control" id="inputname" placeholder="客户链接http://~~~~~~" value="<?php echo \think\Config::get('netinfo.cservice'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">备案号</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="record" class="form-control" id="inputname" placeholder="闽ICP备xxxxxx号" value="<?php echo \think\Config::get('netinfo.record'); ?>" />
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="regs">
						<div class="row">
							<div class="page-header page-s col-md-6">
						        <h4>用户注册控制</h4>
						    </div>
						</div>
						
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">每IP/*秒</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="register_time" class="form-control" id="inputname" placeholder="一般为20秒" value="<?php echo \think\Config::get('access_control.register_time'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">注册用户数</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="register_num" class="form-control" id="inputname" placeholder="一般为1个用户" value="<?php echo \think\Config::get('access_control.register_num'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">超出次数拉黑</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="register_black_count" class="form-control" id="inputname" placeholder="一般为20" value="<?php echo \think\Config::get('access_control.register_black_count'); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="page-header page-s col-md-6">
						        <h4>找回密码提交限制</h4>
						    </div>
						</div>
						
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">每IP/*秒</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="email_repwb_time" class="form-control" id="inputname" placeholder="一般为60秒" value="<?php echo \think\Config::get('access_control.email_repwb_time'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">提交次数</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="email_repwb_num" class="form-control" id="inputname" placeholder="一般为1次" value="<?php echo \think\Config::get('access_control.email_repwb_num'); ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputnetname" class="col-sm-2 col-md-2 col-lg-1 control-label">超出次数拉黑</label>
							<div class="col-sm-8 col-md-5 col-lg-3">
								<input type="text" name="email_repwb_black_count" class="form-control" id="inputname" placeholder="一般为10" value="<?php echo \think\Config::get('access_control.email_repwb_black_count'); ?>" />
							</div>
						</div>
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-sm-8 col-md-5 col-lg-3">
						<button id="subnet" type="submit" style="width: 80px;height: 40px;" class="btn btn-primary">保&nbsp;存</button>
					</div>
				</div>
			</form>

		</div>
	</box>
</div>
	</body>
	<script src="__PLUG__/jquery/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/bootstrap/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PLUG__/layer/layer.js" type="text/javascript" charset="utf-8"></script>
</html>		

<script type="text/javascript" src="__PLUG__/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script>
   $(function(){
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      // Get the name of active tab
      var activeTab = $(e.target).text(); 
      // Get the name of previous tab
      var previousTab = $(e.relatedTarget).text(); 
      $(".active-tab span").html(activeTab);
      $(".previous-tab span").html(previousTab);
   });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#netform').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                message: '网站名称无效！',
                validators: {
                    notEmpty: {
                        message: '名称是必需的，并且不能是空的'
                    },
                    stringLength: {
                        min: 1,
                        max: 30,
                        message: '名称必须大于1，小于30个字符长'
                    },
//                  regexp: {
//                      regexp: /^[a-zA-Z0-9_]+$/,
//                      message: 'The username can only consist of alphabetical, number and underscore'
//                  }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            }
        }
    });
});
</script>

<script type="text/javascript">
$(function(){
	$('#subnet').click(function(){	
	    var str_data = $("#netform").serialize();        
        $.ajax({   	
		    type: "POST",
		    url: "",
		    data: str_data,
		    success: function(msg) {			
			    layer.msg(msg);
		    }
	    });
	    return false;	
   });	
});
</script>