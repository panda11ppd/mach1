<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class Nav extends controller{
	/**
    * @cc 菜单栏
    *    
    */
	public function leftnav() 
	{
		$request = Request::instance();
		$web_path = $request->root();
		$module_name = $request->module();
		$controller_name = $request->controller();
		$action_name = $request->action();
		if (file_exists(APP_PATH . 'agents')) {			
			$menuinfo   = Db::name('admin_menu') -> where('menu_types','left') -> where('status',1) -> order('menu_sort asc')->select();		
		    $levelid    = Db::name('admin_menu')->where('menu_url','like',$module_name.'/'.$controller_name.'/%')->value('menu_levelid');
		    $action     = Db::name('admin_menu') -> where('menu_url', $module_name.'/'.$controller_name.'/'.$action_name) -> value('menu_name');
		    $controller = Db::name('admin_menu') -> where('menu_url', $module_name.'/'.$controller_name) -> value('menu_name');
		}else{
			$where=[
			    'menu_levelid'=>['<>',188],
			    'id'=>['<>',188],
			];
			$menuinfo   = Db::name('admin_menu') ->where($where)-> where('menu_types','left') -> where('status',1) -> order('menu_sort asc')->select();		
		    $levelid    = Db::name('admin_menu')->where($where)-> where('menu_url','like',$module_name.'/'.$controller_name.'/%')->value('menu_levelid');
		    $action     = Db::name('admin_menu') ->where($where)->  where('menu_url', $module_name.'/'.$controller_name.'/'.$action_name) -> value('menu_name');
		    $controller = Db::name('admin_menu') ->where($where)->  where('menu_url', $module_name.'/'.$controller_name) -> value('menu_name');
		}	    								
	    $res=['menuinfo'=>$menuinfo,'levelid'=>$levelid,'action'=>$action,'controller'=>$controller];
	    return $res;
	}

}	