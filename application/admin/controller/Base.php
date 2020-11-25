<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use auth;

class Base extends controller {
	
	public function _initialize() {
		
        $request = Request::instance();
		$web_path = $request->root();
		$module_name = $request->module();
		$controller_name = $request->controller();
		$action_name = $request->action();	    
		$loginuid = Session('uid');
		$authName = $module_name.'/'.$controller_name.'/'.$action_name;		
		$auth = new \auth\Auth();
		$res=$auth -> check(strtolower($authName), $loginuid);
		
		if($loginuid==1){
			$res=TRUE;
		}
		if($controller_name == 'Login'){
			$res=TRUE;
		}		
		if($res==FALSE){
			if (Request::instance()->isAjax()){
				echo '没有权限！';
				exit;
			}else{
				$this->error('没有访问权限');
			    exit;
			}
			
		}
		if(!checkmodul('agents') && $controller_name == 'Agents'){
			$this->error('您未购买代理模块，请至 www.rain68.com 购买');
			    exit;
		}
		$agenttype=Db::name('agents_type')->where('id',1)->find();
		if(!$agenttype){
			$data = [
			    'id' => 1,
			    'name' => '普通',
			    'discount' => '100',
			    'min_score' => '0',
			];
			Db::name('agents_type')->insert($data);
		}
		
		$nav=new Nav();
		$leftnav=$nav->leftnav();
				
		$this -> assign('controller', $leftnav['controller']);
		$this -> assign('action', $leftnav['action']);																									
		$this -> assign('leftinfo', $leftnav['menuinfo']);
		$this -> assign('levelid', $leftnav['levelid']);
		$loginuser = Session::get('username');		
		$this -> assign('loginuser', $loginuser);
		$this -> assign('loginuid', $loginuid);
		

	}
    
	

}
