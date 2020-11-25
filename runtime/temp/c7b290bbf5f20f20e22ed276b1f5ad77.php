<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:32:"./theme/default/index\index.html";i:1490012391;s:34:"./theme/default/public\header.html";i:1490165387;s:35:"./theme/default/public\flooter.html";i:1490165520;}*/ ?>
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

<main class="bs-docs-masthead" id="content" role="main">
	<div class="home-swiper">
		<div class="container">
			<div class="swiper-container swiper-container-horizontal">
				<div class="swiper-wrapper" style="transform: translate3d(-1200px, 0px, 0px); transition-duration: 0ms;">					
					<div class="swiper-slide swiper-slide-text swiper-slide-active" data-swiper-slide-index="0" style="width: 1170px; margin-right: 30px;">
						<div class="home-swiper-inner">
							<h2><i class="fa"><?php echo $netcon['name']; ?></i></h2>
							<h3><?php echo $netcon['keyword']; ?></h3>
						</div>
					</div>
					<?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['expimg'] == null): ?>
					    <div class="swiper-slide swiper-slide-text swiper-slide-active" data-swiper-slide-index="<?php echo $vo['goods_id']; ?>" style="width: 1170px; margin-right: 30px;">
						<div class="home-swiper-inner">
							<h2><i class="fa"><?php echo $vo['appname']; ?></i></h2>
							<h3><?php echo $vo['title']; ?><br><?php echo $vo['stitle']; ?></h3>
							<a href="<?php echo URL('/index/goods'); ?>?id=<?php echo $vo['goods_id']; ?>#use" class="btn" target="_blank">应用介绍</a>
							<a href="<?php echo URL('/index/goods'); ?>?id=<?php echo $vo['goods_id']; ?>" class="btn" target="_blank">演示</a>
						</div>
					    </div>
					    <?php else: ?>
					    <div class="swiper-slide" data-swiper-slide-index="<?php echo $vo['goods_id']; ?>" style="width: 1170px; margin-right: 30px;">											        					    
					        <img src="__PUBLIC__<?php echo $vo['expimg']; ?>">					    						
						    <div class="home-swiper-inner">
							    <h2><?php echo $vo['appname']; ?></h2>
							    <h3><?php echo $vo['title']; ?><br><?php echo $vo['stitle']; ?></h3>
							    <a href="<?php echo URL('/index/goods'); ?>?id=<?php echo $vo['goods_id']; ?>#use" class="btn" target="_blank">应用介绍</a>
							    <a href="<?php echo URL('/index/goods'); ?>?id=<?php echo $vo['goods_id']; ?>" class="btn" target="_blank">演示</a>
						    </div>
					    </div>
					    <?php endif; endforeach; endif; else: echo "" ;endif; ?>					
					<div class="swiper-slide swiper-slide-text swiper-slide-duplicate" data-swiper-slide-index="0" style="width: 1170px; margin-right: 30px;">
						<div class="home-swiper-inner">
							<h2><i class="fa"></i></h2>
							<h3>更好的WordPress主题2</h3>
						</div>
					</div>
				</div>

				<div class="swiper-pagination swiper-pagination-white swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>

				<div class="swiper-button-next swiper-button-white"></div>
				<div class="swiper-button-prev swiper-button-white"></div>
			</div>

		</div>
	</div>

</main>
<div class="home-firstitems">
	<div class="container">
		<ul>									
			<li>
				<a target="_blank" href="<?php echo $cservice; ?>">
					<i class="fa">&#xe631;</i>
					<strong>服务器环境安装</strong>
					<p>PHP、MYSQL、服务器环境搭建</p>
					<span class="btn btn-primary">提交请求				
					</span>
				</a>
			</li>
			<li>
				<a target="_blank" href="<?php echo $cservice; ?>">
					<i class="fa">&#xe62e;</i>
					<strong>WEB</strong>
					<p>人工设计网站简易美观</p>
					<span class="btn btn-primary">提交需求</span>
				</a>
			</li>
			<li>
				<a target="_blank" href="<?php echo $cservice; ?>">
					<i class="fa">&#xe62f;</i>
					<strong>APP</strong>
					<p>专业APP程序设计开发</p>
					<span class="btn btn-primary">提交需求</span>
				</a>
			</li>
			<li>
				<a target="_blank" href="<?php echo $cservice; ?>">
					<i class="fa">&#xe630;</i>
					<strong>支付系统</strong>
					<p>支付平台系统接入PAY</p>
					<span class="btn btn-primary">提交需求</span>
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="home-box home-news">
	<div class="container">
		<h2><?php echo $netcon['name']; ?>动态</h2>
		<h3>汇聚本站所有最新文章</h3>
		<ul>
			
			<?php if(is_array($arrys) || $arrys instanceof \think\Collection || $arrys instanceof \think\Paginator): $i = 0; $__LIST__ = $arrys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
				<a href="<?php echo $vo['urls']; ?>" title="<?php echo $vo['title']; ?>">
					<?php if($vo['thumb_img'] == null): ?>
					<img src="__PUBLIC__/static/images/tsimg/<?php echo $vo['simgs']; ?>" class="thumb" alt="<?php echo $vo['title']; ?>">
					<?php else: ?>
					<img src="__PUBLIC__<?php echo $vo['thumb_img']; ?>" class="thumb" alt="<?php echo $vo['title']; ?>">
					<?php endif; ?>
					
					<h4 style=" text-align:center;"><?php echo $vo['title']; ?></h4>
				</a>
				<div class="note"><?php echo $vo['keyword']; ?></div>
			</li>                     
            <?php endforeach; endif; else: echo "" ;endif; ?>
			
		</ul>
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