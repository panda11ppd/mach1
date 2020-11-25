<?php
namespace app\common\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use auth;
class UserAuth extends controller {
	public function _initialize() {
        $request = Request::instance();		
	    define('WEB_PATH', $request->root());//程序目录
		define('MODULE_NAME', $request->module());//当前模块名
        define('CONTROLLER_NAME', $request->controller());//当前控制器
		define('ACTION_NAME', $request->action());//当前操作名
		$vurl=MODULE_NAME.'/'.CONTROLLER_NAME;
		$netcon=config('netinfo');
		$this -> assign('netcon', $netcon);
		if($netcon['status'] < 1){
			echo '网站关闭维护中！';
			exit;
		}
		
		$titles='';
		if($vurl=='index/Index') $titles='首页-';
		if($vurl=='index/GoodsList') $titles='产品商店-';
		if($vurl=='index/Login') $titles='登录-';
		if($vurl=='index/Order') $titles='我的订单-';
		if($vurl=='index/Register') $titles='注册-';
		if($vurl=='index/Repwd') $titles='修改密码-';
		if($vurl=='index/User') $titles='用户资料-';
		
		if($vurl=='index/UserAcard') $titles='我的授权码-';
		if($vurl=='index/UserCard') $titles='我的充值卡-';
		
		$this -> assign('titles', $titles);
		if($vurl=='index/Aliapy') {			
			vendor('alipay.Corefn');
		    vendor('alipay.Md5fn');
		    vendor('alipay.Notify');
		    vendor('alipay.Submit');
		}      
		if($this->loginurl($vurl)){
			$loginurl=URL('/index/login');
			echo "<script type=\"text/javascript\">window.location.href='".$loginurl."';</script>";
			exit;
		}
				
		$loginuid=Session('uid');		
		$auth = new \auth\Auth();		
		//$res=$this->authCheck($authName, $uid);
		$loginuser = Session::get('username');
		$loginuid = Session::get('uid');
		$loginstatus = Session::get('status');
				
		$this -> assign('loginuser', $loginuser);
		$this -> assign('loginuid', $loginuid);
		$body='page-theme';
		if(CONTROLLER_NAME=='Index'){
			$body='page-theme';
		}
		if(CONTROLLER_NAME=='GoodsList'){
			$body='page-theme';
		}
		if(CONTROLLER_NAME=='Goods'){
			$body='page-theme-item';
		}
		if(CONTROLLER_NAME=='Register'){
			$body='page-register';
		}
		if(CONTROLLER_NAME=='Login'){
			$body='page-login';
		}
        
		$menuname = Db::name('user_menu') -> where('controller', '/'.MODULE_NAME.'/'.CONTROLLER_NAME) -> value('name');		
		$this -> assign('menuname', $menuname);
		$menu1 = Db::name('user_menu') -> where('group',1)-> order('sort asc')->select();
		$menu2 = Db::name('user_menu') -> where('group',2)-> order('sort asc')->select();				
		$this -> assign('menu1', $menu1);
		$this -> assign('menu2', $menu2);						
        $this -> assign('body', $body);
        
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
			);
		    return in_array($vurl,$arrdate);						
		}else{
			return FALSE;
		}
	}
}
