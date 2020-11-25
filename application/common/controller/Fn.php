<?php
namespace app\common\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class Fn extends controller
{
	//取前端菜单数据	
	public function getMenu(){
		$res=Db::name('menu')->where('status',1)->order('id asc')->select();		
		return $res;
	}
	//取最新文章
	public function newarticle($num){
		$res=Db::name('article')->where('status',1)->order('id desc')->limit($num)->select();
		return $res;
	}
    
}
