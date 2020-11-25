<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use auth;
class Base extends controller {
	public function _initialize() {
        $request = Request::instance();		
	    $root=$request->root();//程序目录
		$module=$request->module();//当前模块名
        $controller=$request->controller();//当前控制器
		$action=$request->action();//当前操作名
		$vurls=$module.'/'.$controller;
		$vurl=$module.'/'.$controller.'/'.$action;
		$theme=config('theme');
		$this->view->config('view_path',config('template.view_path').$theme.'/');
		$netcon=config('netinfo');
		$this -> assign('netcon', $netcon);
		if (!is_file(APP_PATH . 'install/data/install.lock')) {
			$installurl=URL('/install/index');
            echo "<script language='javascript' type='text/javascript'>";  
            echo "window.location.href='".$installurl."'";  
            echo "</script>";
	        exit;	   
        }
		if($vurl === 'index/Login/index' || $vurl === 'index/Login/login' || $vurl === 'index/Login/vals'){
			
		}else{
			if($netcon['status'] != 1){
			    $loginurl=URL('/index/login');
			    echo "<script type=\"text/javascript\">window.location.href='".$loginurl."';</script>";
			    exit;
			}
		}
				
		
		
		$myurl=$request->URL(true);
		$this -> assign('myurl', $myurl);
		$seo=[
		        'title'=>'',
		        'keywords'=>'',
		        'description'=>'',
		    ];	
		$this -> assign('seo', $seo);
//		$titles='';
//		$article['title']='';
//		$this->assign('article',$article);
//		if($vurls=='index/Index/index') $titles='-首页';
//		if($vurls=='index/Goods/goodslist') $titles='-产品专题';
//		if($vurls=='index/Login/index') $titles='-登录';
//		if($vurls=='index/Order/index') $titles='-我的订单';
//		if($vurls=='index/Register/index') $titles='-注册';
//		if($vurls=='index/Repwd/index') $titles='-修改密码';
//		if($vurls=='index/User/index') $titles='-用户资料';		
//		if($vurls=='index/UserAcard/index') $titles='-我的授权码';
//		if($vurls=='index/UserCard/index') $titles='-我的充值卡';		
//		$this -> assign('titles', $titles);
		      
		if($this->loginurl($vurls)){
			$loginurl=URL('/index/login/index');
			echo "<script type=\"text/javascript\">window.location.href='".$loginurl."';</script>";
			exit;
		}				
		$loginuid=Session('uid');
		$scores='';
		if($loginuid){
			$userfn=new \app\common\controller\UserFn();			
			$scorename=$userfn->tradeType();
			if($scorename){
				$score=$userfn->getScore($loginuid);
				$score=ceil($score);
				$scores=$scorename.':'.$score;
			}
		    
		}
		$fns=new \app\common\controller\Fn();		
		$newarticle=$fns->newarticle(10);
		
		foreach($newarticle as $key=>$val){
			
			$sorts=$this->getsort($newarticle[$key]['id']);			
			$s = ('t' . rand(1, 20) . '.png');
			$newarticle[$key]['simgs'] = $s;
			$newarticle[$key]['urls']=URL('/index/article/index',['id'=>$newarticle[$key]['id']]);
			if($sorts){
				$newarticle[$key]['sort']=$sorts['sort_name'];
				$newarticle[$key]['sort_id']=$sorts['id'];
				$newarticle[$key]['menu_url']=$sorts['menu_url'];
			}else{
				$newarticle[$key]['sort']='未分类';
				$newarticle[$key]['sort_id']=1;
			}
			
			$newarticle[$key]['add_time']=time2date($newarticle[$key]['add_time']);		
		}
		$this->assign('newarticle',$newarticle);
		$this->assign('scores',$scores);		
		$auth = new \auth\Auth();		
		//$res=$this->authCheck($authName, $uid);
		$loginuser = Session::get('username');
		$loginuid = Session::get('uid');
		$loginstatus = Session::get('status');
				
		$this -> assign('loginuser', $loginuser);
		$this -> assign('loginuid', $loginuid);
		$body='page-theme';
		if($controller=='Index'){
			$body='page-home';
		}
		if($controller=='GoodsList'){
			$body='page-theme';
		}
		if($controller=='Goods'){
			$body='page-theme-item';
		}
		if($controller=='Register'){
			$body='page-register';
		}
		if($controller=='Login'){
			$body='page-login';
		}
		if($vurls=='index/Article/index'){
			$body='page-post';
		}
        $fn=new \app\common\controller\Fn();
		$menu=$fn->getMenu();
		$this -> assign('menu', $menu);
		$menuname = Db::name('user_menu') -> where('controller', '/'.$module.'/'.$controller) -> value('name');		
		$this -> assign('menuname', $menuname);
		$menu1 = Db::name('user_menu') -> where('group',1)-> order('sort asc')->select();
		$menu2 = Db::name('user_menu') -> where('group',2)-> order('sort asc')->select();
		$newar=Db::name('article')->where('status',1)->select();				
		$this -> assign('menu1', $menu1);
		$this -> assign('menu2', $menu2);						
        $this -> assign('body', $body);
		$cservice=config('netinfo.cservice');
		$comment=config('comment');
		if(!$comment){
			$comment['name']='';
			$comment['status']='0';
		}
		$this->assign('comment',$comment);		
		$this -> assign('cservice', $cservice);
        
	}

	public function authCheck($authName, $uid) {
		$auth = new \auth\Auth();
		if ($auth -> check(strtolower($authName), $uid)) {
			return true;
		} else {
			return false;
		}
	}
	
    public function loginurl($vurl) {
		if(!session('?username')){
			$arrdate = array(
			    'index/User',
			    'index/Repwd',
			    'index/UserGoods',
			    'index/Order',
			    'index/UserCard',
			    'index/UserAcard',
			);
		    return in_array($vurl,$arrdate);						
		}else{
			return FALSE;
		}
	}
    private function getsort($articleid){
		$sortid=Db::name('article_relation')->where('article_id',$articleid)->value('sort_id');		
		$res=Db::name('sort')->where('id',$sortid)->find();
		if(!$res){
			$res['sort_name']='未分类';
		    $res['id']=1;
		}			
		$res['menu_url']=URL('/index/article/sorts',['id'=>$sortid]);			
		return $res;
		
	}
}
