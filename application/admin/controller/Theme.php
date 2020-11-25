<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Theme extends Base {
	/**
    * @cc 模板主题管理
    *    
    */
	public function index() {
		$the=new \hooks\Hooks();
		$thelist=$the->ont();
		
		$this->assign('thelist',$thelist);
		return $this->fetch();
	}
	
   
}	