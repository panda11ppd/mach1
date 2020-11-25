<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:32:"./theme/default/login\index.html";i:1490012391;s:34:"./theme/default/public\header.html";i:1490165387;s:35:"./theme/default/public\flooter.html";i:1490165520;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="renderer" content="webkit">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
		<title><?php echo $seo['title']; ?></title>
		<meta name="keywords" content="<?php echo $seo['keywords']; ?>">
        <meta name="description" content="<?php echo $seo['description']; ?>">
		<link rel="stylesheet" type="text/css" href="__THEME__/default/css/app.css" />
        <script src="__PLUG__/jquery/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<!-- Bootstrap -->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
        <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>

	<body class="<?php echo $body; ?>">    
		<header class="header">
			<div class="container">
				<h1 class="logo"><a href="<?php echo URL('/index'); ?>"><?php echo $netcon['name']; ?></a></h1>
				<div class="site-navbar">
					<ul>
						<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<li class="">
							<a href="<?php echo $vo['menu_url']; ?>"><?php echo $vo['name']; ?></a>

						</li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
												
						<!--<li class="">
					<a href="<?php echo URL('/index/article_list'); ?>">客户服务</a>					
				</li>
				<li class="">
					<a href="<?php echo URL('/index/help'); ?>">常见问题</a>
				</li>-->
					</ul>
				</div>
				<?php if(($loginuid == null)): ?>
				<div class="wel-login">
					<a href="<?php echo URL('/index/register'); ?>" class="btn">注册</a>
					<a href="<?php echo URL('/index/login'); ?>" class="btn btn-primary">登录</a>
				</div>

				<div class="m-wel">
					<div class="m-wel-login">
						<img class="avatar" src="__PUBLIC__/static/images/tb.png">
						<a class="m-wel-login" href="<?php echo URL('/index/login'); ?>">登 录</a>
						<a class="m-wel-register" href="<?php echo URL('/index/register'); ?>">注册新用户</a>
					</div>
				</div>
                <?php else: ?>
                
                <div class="wel">
					<img class="avatar" src="__PUBLIC__/static/images/user.png"> <span class="wel-name"><?php echo $loginuser; ?></span>
					<div class="sub-menu">
						<ul>
							<?php if(($loginuid == 1)): ?>
							<li><a href="<?php echo url('/admin/index'); ?>">后台管理</a></li> 
							<?php endif; if(is_array($menu1) || $menu1 instanceof \think\Collection || $menu1 instanceof \think\Paginator): $i = 0; $__LIST__ = $menu1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i;?>
		                    <li><a href="<?php echo url($mo['url']); ?>"><?php echo $mo['name']; ?></a></li>                          
                            <?php endforeach; endif; else: echo "" ;endif; if(is_array($menu2) || $menu2 instanceof \think\Collection || $menu2 instanceof \think\Paginator): $i = 0; $__LIST__ = $menu2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ma): $mod = ($i % 2 );++$i;?>
		                    <li><a href="<?php echo url($ma['url']); ?>"><?php echo $ma['name']; ?></a></li>                          
                            <?php endforeach; endif; else: echo "" ;endif; ?>
							
							<li>
								<a href="<?php echo URL('/index/login/quit'); ?>">退出</a>
							</li>
						</ul>						 
					</div>					
				</div>                	
				<div class="m-wel">
					<header>
						<img class="avatar" src="__PUBLIC__/static/images/user.png">
						<h4>d-14126926598254630</h4>
						<h5>80692285@qq.com</h5>
					</header>
					<div class="m-wel-content">
						<ul>
							<?php if(($loginuid == 1)): ?>
							<li><a href="<?php echo url('/admin/index'); ?>">后台管理</a></li> 
							<?php endif; if(is_array($menu1) || $menu1 instanceof \think\Collection || $menu1 instanceof \think\Paginator): $i = 0; $__LIST__ = $menu1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i;?>
		                    <li><a href="<?php echo url($mo['url']); ?>"><?php echo $mo['name']; ?></a></li>                          
                            <?php endforeach; endif; else: echo "" ;endif; if(is_array($menu2) || $menu2 instanceof \think\Collection || $menu2 instanceof \think\Paginator): $i = 0; $__LIST__ = $menu2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ma): $mod = ($i % 2 );++$i;?>
		                    <li><a href="<?php echo url($ma['url']); ?>"><?php echo $ma['name']; ?></a></li>                          
                            <?php endforeach; endif; else: echo "" ;endif; ?>
							<li>
								<a href="<?php echo URL('/index/login/quit'); ?>">退出</a>
							</li>
						</ul>
						
					</div>
					<footer>
						<a href="<?php echo URL('/index/login/quit'); ?>">退出当前账户</a>
					</footer>
			    </div>
                   
                <?php endif; ?>
								
			<div class="m-navbar-start"><i class="fa">&#xe624;</i></div>
			<div class="m-wel-start"><i class="fa">&#xe632;</i></div>
			<div class="m-mask"></div>
			</div>

		</header>
<div class="sign-container">
<link rel="stylesheet" type="text/css" href="__PLUG__/slock/slide-unlock-index.css"/>
<link rel="stylesheet" type="text/css" href="__PLUG__/rainfont/iconfont.css"/>

    <span class="sign-tips" id="msgbox">密码错误</span>
    <?php if($netcon['status'] == 0): ?>
    <h1 style="color: red;">网站关闭维护中......</h1>
    <?php endif; ?>
	<form class="sign-form"id="login" name="loginform"> 
	    <h1>用户登录</h1>
	    <div class="item">
	        <label for="inputEmail">用户名</label>
	        <input class="ipt" type="text" name="username" required class="ipt" id="inputusername" placeholder="登录用户名">
	    </div>
	    <div class="item">
	        <label for="inputPassword">密码</label>
	        <input type="password" name="password" class="ipt" id="inputPassword" placeholder="登录密码" required>
	    </div>
	    <div class="item">
	        <label for="inputPassword"> </label>
	        <input type="hidden" name="vals" id="vals" value="" />
            <div id="slider">
                <div id="slider_bg"></div>	                                
	            <span id="label">>></span> <span id="labelTip">拖动滑块验证</span> 
			</div> 
	    </div>
	    <div class="sign-sign">
	        <input id="subadd" type="submit" class="btn btn-primary btn-block" value="登 录">	        
	    </div>
	    <div style="margin-top: 10px;" class="sign-info">
		    <input type="hidden" name="user" value="login">
		    <a href="<?php echo URL('/index/respassword'); ?>">找回密码？</a>
	    </div>
	</form>

</div>
<div class="register-verification" id="info" style="display:none">
	<div class="auth-form auth-form-text">
		<h1 id="ht" class="title">登录成功</h1>
		<p id="hp" class="text-center">！</p>
	</div>
</div>

<section class="service-show">
    <div class="container">
        <ul>
            <li>
                <i class="fa">&#xe617</i>
                <h3>高端专业的开发团队</h3>
                <p>拥有多年企业建站/网络商城开发经验，独树一帜的设计，提供最专业的界面设计方案；原创的主题标签语义化，增强程序优化效果。</p>
            </li>
            <li>
                <i class="fa">&#xe618</i>
                <h3>独一无二的视觉冲击</h3>
                <p>增强用户体验、提高品牌形象给人留下深刻的印象，那就选择我们，我们的每一款产品都是独一无二的，都有自己的灵魂，每款主题都有各自的配色方案。</p>
            </li>
            <li>
                <i class="fa">&#xe615</i>
                <h3>完美的响应式布局</h3>
                <p>遵循现代网页设计的趋势，所有主题都提供完整的响应式布局，优化大桌面显示器以及对平板和智能手机的支持，从而提供一致性的用户体验。</p>
            </li>
            <li>
                <i class="fa">&#xe617</i>
                <h3>强大产品的售后服务</h3>
                <p>长期及时地在线售后服务和升级更新，确保您的APP始终运行在最佳状态，在线沟通方式免去您的后顾之忧，替您节省维护成本。</p>
            </li>
        </ul>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <p class="footer-logo">
            <i class="fa">RainVerify</i>
        </p>
        <p class="footer-navs">
            <a href="/about">关于我们</a><a href="/ads">广告合作</a><a href="/disclaimer">免责声明</a>
        </p>
        <p class="footer-links">
            <a target="_blank" href="">Rain</a><a target="_blank" href="">网络验证</a>
            <a target="_blank" href="">中文主题</a>
            <a target="_blank" href="">教程</a>
            <a target="_blank" href="">博客导航</a>
            <a target="_blank" href="">推荐云服务器</a>
        <p class="footer-copyright">
            &copy; 2016 <a href="http://www.rain68.com"><?php echo \think\Config::get('sysinfo.copyright'); ?></a> 强大的<a href="http://www.rain68.com">网络验证</a>
            <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo \think\Config::get('netinfo.record'); ?></a>
        </p>
    </div>
</footer>

<script>
// baidu tongji
//var _hmt = _hmt || [];
//(function() {
//var hm = document.createElement("script");
//hm.src = "__THEME__/default/js/hm.js";
//var s = document.getElementsByTagName("script")[0]; 
//s.parentNode.insertBefore(hm, s);
//})();

// push to baidu
/*(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();*/
</script>

<script>
var TBUI={
    URL: '',
    STATIC: '__THEME__/default',
    VERSION: '4.0.0708',
};
</script>

<script src="__THEME__/default/js/loader.js"></script>



</body>
</html>
<script src="__PLUG__/slock/jquery.slideunlock.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function () {
        var slider = new SliderUnlock("#slider",{
				successLabelTip : "验证通过"	
			},function(){
				$.ajax({   
                url:'login/vals',   
                type:'post',   
                data:'set=val',
                error:function(){
                	
                },
                success:function(data){   
                $('#vals').val(data);
                var width=$("#slider_bg").width();
                
                $("#label").replaceWith('<span id="label" style="left: '+width+'px;"><i style="color: #71B402;" class="fa">&#xe619</span>'); 
              
                }
            });
            	
        	});
        slider.init();
    })
</script> 

<script type="text/javascript">
	$(document).ready(function() {		
		$('#subadd').click(function() {
			var str_data = $("#login").serialize();			
			$.ajax({
				type: "post",
				url: "<?php echo URL('/index/login/login'); ?>",
				data: str_data,
				success: function(msg) {
					
					if(msg.code==10){						
						$('#msgbox').text('用户名或密码错误！');
						$('#msgbox').attr('style','height: 29px; overflow: hidden;');
					}
					if(msg.code==11){
						
						$('#msgbox').text('用户已被禁用！请联系管理员！');
						$('#msgbox').attr('style','height: 29px; overflow: hidden;');
					}
					if(msg.code==12){
						
						$('#msgbox').text('验证未通过！');
						$('#msgbox').attr('style','height: 29px; overflow: hidden;');
					}
					if(msg.msg=='success'){
						$('#ht').text('登录成功');
						$('#hp').text('正在为您跳转页面！');
						$('#info').attr('style','');
						$('.sign-container').attr('style','display:none');
						if(msg.code==1){
							location.href = "<?php echo URL('/admin/index'); ?>";
						}
						if(msg.code==2){
							location.href = "<?php echo URL('/index/order'); ?>";
						}
						
					}
					
				}
			});
			return false;
		});
		
	});
</script>