<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:56:"D:\wwwroot\raincms/application/admin\view\pay\index.html";i:1490356367;s:60:"D:\wwwroot\raincms/application/admin\view\public\header.html";i:1490430863;s:60:"D:\wwwroot\raincms/application/admin\view\public\lefter.html";i:1490012391;s:61:"D:\wwwroot\raincms/application/admin\view\public\flooter.html";i:1490012391;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__PLUG__/webuploader/webuploader.css">
<style type="text/css">
	.webuploader-pick {   
        border-radius: 0px;    
    }
    #delexpimg {
    	height: 40px;
    	margin-left: 5px;
    	
    }
    .edui-default .edui-editor-toolbarboxouter {
		background-image: linear-gradient(to bottom, #F1F1F1, #f1f1f1);
		
    }
    .edui-default .edui-editor {
		border-radius: 0px;
    }
    
</style>
<div class="container-fluid box-a">
	<div class="nav-c">
		<span class="glyphicon glyphicon-tag">&nbsp;<span id="">支付设置</span>
	</div>
	<box class="box-b">
		<div class="divs" class="row">
			<div class="page-header page-s">
				<h3>Rain支付平台<small></small></h3>
			</div>		
			<form id="rainpay" class="form-horizontal">					
				<input type="hidden" name="name" id="name" value="rainpay" />
				<div class="form-group">
					<label for="seller_id" class="col-sm-3 col-md-3 col-lg-2 control-label">Rain平台合作者ID</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input type="text" name="seller_id" class="form-control" id="seller_id" placeholder="合作者ID" value="<?php echo $rainpay['seller_id']; ?>" />
					</div>
					<label style="color: red;" for="inputnetonoff" class="control-label">*</label>
				</div>
				<div class="form-group">
					<label for="key" class="col-sm-3 col-md-3 col-lg-2 control-label">安全检验码</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input type="text" name="key" class="form-control" placeholder="安全检验码" value="<?php echo $rainpay['key']; ?>" />
					</div>
					<label style="color: red;" for="inputnetonoff" class="control-label">*</label>
				</div>
				<div class="form-group">
					<label for="rainpay" class="col-sm-3 col-md-3 col-lg-2 control-label">支付宝帐号</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input type="text" name="seller_email" class="form-control" placeholder="支付宝帐号" value="<?php echo $rainpay['seller_email']; ?>" />
					</div>
					<label style="color: red;" for="inputnetonoff" class="control-label">*</label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-8 col-md-6 col-lg-4">																		
						<a  target="_blank" class="link text-red" href="http://pay.toaone.com">Rain支付官网</a>
						<button id="rainpayadd" class="btn btn-primary pull-right">保存设置</button>
					</div>
				</div>
				<div class="">
			<p>Rain支付使用方法：</p>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;1.进入官网<a  target="_blank" href="http://pay.toaone.com">http://pay.toaone.com</a>
				&nbsp;&nbsp;&nbsp;&nbsp;2.注册申请Rain支付用户
			    &nbsp;&nbsp;&nbsp;&nbsp;3.登录Rain平台点击上方导航 “我的账户”
			</p>
            <p>
            	&nbsp;&nbsp;&nbsp;&nbsp;4.点击左边 “账户设置”，在认证栏进行认证
            	&nbsp;&nbsp;&nbsp;&nbsp;5.等待管理员认证，一般时间24小时内
            </p>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;6.认证通过后，点击服务接入，把右边合作者PID和安全校验码(Key)，还有你的支付宝账号输入本页上方
			</p>
			
			</div>
			</form>

		</div>
		<div class="divs" class="row">
			<div class="page-header page-s">
				<h3>支付宝免签即时到账<small></small></h3>
			</div>		
			<form id="vapay" class="form-horizontal">	
				<input type="hidden" name="expimg" class="form-control" id="expimg" placeholder="pay" value="<?php echo $freevisa; ?>" />
				<div class="form-group">
					<div class="row">
					<div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-6 col-md-6 col-lg-3">
			        <div id="uploader-demos">
						<div id="fileLists" class="uploader-lists"></div>
						<?php if($freevisa != null): ?>
						<div id="divimgs" class="file-item thumbnail">
							<img id="imgids" src="__PUBLIC__<?php echo $freevisa; ?>">
						</div>
						<?php endif; ?>
						<div class="pull-left" id="filePickers">选择图片</div>
							<button type="button" id="delexpimg" class="btn btn-default">清除</button>
						</div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-sm-offset-8 col-md-offset-6 col-lg-offset-4 col-sm-8 col-md-6 col-lg-4">																		
						<button id="vapayadd" class="btn btn-primary">保存设置</button>					
				    </div>
				    </div>
				<div class="row">
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;支付宝免签即时到账使用方法：</p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传你的二维码图片，前台支付扫一扫付款</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客户扫描支付，备注输入用户的ID号(UID)积分自动到账</p> 
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;临控接口地址：http://你的域名/sapi/alipay,KEY为你的网站通讯KEY</p> 
            <h3 style="color: red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;监控端请至www.rain68.com下载</h3>
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

<script type="text/javascript" src="__PLUG__/webuploader/webuploader.js"></script>
<script type="text/javascript">
	$(document).ready(function() {		
		$('#rainpayadd').click(function() {
			var str_data = $("#rainpay").serialize();			
			$.ajax({
				type: "get",
				url: "<?php echo url('/admin/pay/saverainpay'); ?>",
				data: str_data,
				success: function(msg) {
					layer.alert(msg);					
				}
			});
			return false;
		});
		$('#vapayadd').click(function() {
			var str_data = $("#vapay").serialize();			
			$.ajax({
				type: "post",
				url: "<?php echo url('/admin/pay/vapayadd'); ?>",
				data: str_data,
				success: function(msg) {
					layer.alert(msg);					
				}
			});
			return false;
		});
	});
</script>
<script type="text/javascript">

    $("#delexpimg").click(function(){
       $('#divimgs').remove();
       $('#expimg').val('');
    });
</script>
<script type="text/javascript">
// 图片上传demo
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileLists'),
        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,

        // Web Uploader实例
        uploader;

    // 初始化Web Uploader
    uploader = WebUploader.create({

        // 自动上传。
        auto: true,

        // swf文件路径
        swf: '__PLUG__/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: 'upload',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePickers',
        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/jpg,image/jpeg,image/png'
        }
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
    	$("#divimgs").remove();
        var $li = $(
                '<div id="divimgs" class="file-item thumbnail">' +
                    '<img id="imgids">' +
                    '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
            $img = $li.find('img');

        $list.append( $li );

        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,response ) {
        $( '#'+file.id ).addClass('upload-state-done');
        var furl='/uploads/'+response._raw;
        $('#imgids').attr('src','__PUBLIC__'+furl);
        $('#expimg').val(furl);
         
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
});
</script>

