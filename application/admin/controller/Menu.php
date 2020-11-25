<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class Menu extends Base {
	/**
    * @cc 前台菜单管理
    *    
    */
	public function index() {
		$sortdb=Db::name('sort')->where('parent_id',0)->select();
		$this->assign('sortdb',$sortdb);
		$menulist=Db::name('menu')->order('sorting asc')->select();
		$this->assign('menulist',$menulist);
		return $this -> fetch();
	}
	/**
    * @cc 添加菜单
    *    
    */
	public function getlink() {
		$request = Request::instance();
		if(input('get.type')=='pags'){
			$name=input('get.name/a');
			if($name){
				$ars=array();
				foreach($name as $k=>$v){
					if($v=='home'){
					    $ars[]=['name'=>'首页','menu_url'=>$request->domain().$request->root()];
					}elseif($v=='appstore'){
						$ars[]=['name'=>'应用商店','menu_url'=>$request->domain().URL('/index/goods')];
					}elseif($v=='allarticle'){
						$ars[]=['name'=>'所有文章','menu_url'=>$request->domain().URL('/index/article/allarticle')];
					}										
				
			    }
				return json($ars);
		    }
			
		}elseif(input('get.type')=='article'){			
			$id=input('get.id/a');
			if($id){
				$ars=array();
				foreach($id as $key=>$val){
					$sortdb=Db::name('sort')->where('id',$val)->find();
					$ars[]=['name'=>$sortdb['sort_name'],'menu_url'=>$request->domain().URL('/index/article/sorts',['id'=>$val])];
			
			    }
				
				return json($ars);
				
		    }
			
		}elseif(input('get.type')=='definelink'){
			$name=input('get.name');
			$menu_url=input('get.menu_rul');
			if($name){
				$ars=array();
				$ars[]=['name'=>$name,'menu_url'=>$menu_url];
				
				return json($ars);
		    }
			
		}
		
	}
    /**
    * @cc 保存菜单设置
    *    
    */
    function savemenu(){
    	Db::name('menu')->where('id','<>',0)->delete();
    	if(input('get.name/a')){
			$name=input('get.name/a');
			$menu_url=input('get.menu_url/a');
			if($name){
				$ars=array();
				foreach($name as $key=>$val){
					foreach($menu_url as $k=>$v){
						if($key==$k){
						    $ars[]=['name'=>$val,'menu_url'=>$v,'sorting'=>$k];	
						}
					}									
				
			    }				
				Db::name('menu')->insertAll($ars);
				return '保存成功！';
		    }
			
			return '未添加菜单！';
			
		}
		return '未添加菜单！';
    }
   
}	