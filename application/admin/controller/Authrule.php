<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Authrule extends Base {
	/**
     * @cc 权限节点管理
     *    
     */
	public function index() {						
		return $this -> fetch();
	}
	/**
     * @cc 添加权限节点
     *    
     */
    public function add(){
    	if(input('?get.allrule') && input('get.allrule')=='yes'){
    		$GetAction=new \app\common\controller\GetAction();
		    $getarr=$GetAction->index('admin');		
		    $resrule=Db::name('auth_rule')->select();
		    foreach ($resrule as $key=>$val){
			    foreach ($getarr as $k=>$v){								
				    if($getarr[$k]['name'] == $resrule[$key]['title']){					
				        unset($getarr[$k]);						
				    }
                }
            }
			Db::name('auth_rule')->insertAll($getarr);
			return '导入成功！' ;   		
    	}
		
    	if(input('?get.name') && input('?get.title') && input('?get.group')){
    	    $name=input('get.name');
			$title=input('get.title');
			$group=input('get.group');
			if($name==null || $title==null){				
				return '节点名和地址不能为空！';
			}else{
				$insdb=['name'=>$name,'title'=>$title,'group'=>$group];
				Db::name('auth_rule')->insert($insdb);			    			
			    return '添加成功!';
			}			
    	}
		 
		$GetAction=new \app\common\controller\GetAction();
		$getarr=$GetAction->index('admin');		
		$resrule=Db::name('auth_rule')->select();
		foreach ($resrule as $key=>$val){
			foreach ($getarr as $k=>$v){								
				if($getarr[$k]['name'] == $resrule[$key]['name']){					
				    unset($getarr[$k]);						
				}
                
			}
            
        }
    	$resgroup=Db::name('admin_menu')->where('status',1)->where('menu_levelid','<',1)->select();
		$this->assign('getarr',$getarr);
		$this->assign('resgroup',$resgroup);			
    	return $this -> fetch();
    }
	/**
     * @cc 编辑权限节点
     *    
     */
    public function edit(){
    	if(input('?get.editrid') && input('get.editrid')){
    		$rid=input('get.editrid');			  			
    		Db::name('auth_rule')->where('id',$rid)->update(['title'=>input('get.title'),'group'=>input('get.group')]);
			return '修改成功！';
			
    	}
		
    	if(input('?get.rid') && input('get.rid')){//修改用户密码		
		    $rid=input('get.rid');
		    $ruledb=Db::name('auth_rule')->where('id',$rid)->find();
			$resgroup=Db::name('admin_menu')->where('status',1)->where('menu_levelid','<',1)->select();
			$this -> assign('ruledb', $ruledb);
		    $this -> assign('resgroup',$resgroup);			
			
			return $this -> fetch();
		    
		}
    }
/**
     * @cc 启停删权限节点
     *    
     */
	public function set(){
		if(input('?get.ruleset')){
			$rid=input('get.rid');
			if(input('get.ruleset')=='stop'){				
			    Db::name('auth_rule')->where('id', $rid)->update(['status' => '0']);													
                return '已停用！';	
			}elseif(input('get.ruleset')=='start'){				
			    Db::name('auth_rule')->where('id', $rid)->update(['status' => '1']);													
	            return '已启用！';	
			}elseif(input('get.ruleset')=='del'){				
				Db::name('auth_rule')->delete($rid);
				return '删除成功！';
			}
			
		}

	}
    
	/**
     * @cc 权限节点列表
     *    
     */
	
	public function rulelist(){
		//取出用户加入列表
		
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('auth_rule')->count();	//计算总数						       
        $ruledb=Db::name('auth_rule')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('auth_rule')->where('title','like',$search.'%')->count();	//计算总页数						       
            $ruledb=Db::name('auth_rule')->where('title','like',$search.'%')->limit($offset.','.$limit)->select();
			
		}	
									
		
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$ruledb;
		return json($jsondata);
	}	
}
