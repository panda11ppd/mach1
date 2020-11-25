<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Authgroup extends Base {
	/**
     * @cc 用户组管理
     *    
     */
	public function index() {
		
		
		return $this -> fetch();
	}
	/**
     * @cc 添加用户组
     *    
     */
    public function add(){
    	if(input('?get.title')){
    		if(!input('get.title')){
    			return '失败，用户组名不能为空！';
    		}
			$restitle=Db::name('auth_group')->where('title',input('get.title'))->find();
			if($restitle){
				return '失败，相同名称用户组已存在！';
			}
    		$title=input('get.title');
			$description=input('get.description');
			$rule='';
			if(input('?get.rules')){
				$rulearr=input('get.rules/a');
				$rule=implode(',',input('get.rules/a'));
            }
			$insdata=['title'=>$title,'description'=>$description,'rules'=>$rule];
			Db::name('auth_group')->insert($insdata);
			return '添加成功！';
    		
    	}else{
    		$resgroup=Db::name('auth_rule')->distinct(true)->field('group')->select();
			foreach($resgroup as $key=>$val){
				$resgroup[$key]['id']='box'.$key;
			}
		    $resrule=Db::name('auth_rule')->where('status',1)->select();				
    	    $this->assign('resgroup',$resgroup);
		    $this->assign('resrule',$resrule);		
    	    return $this -> fetch();
    	}
    	
    }
	/**
     * @cc 编辑用户组
     *    
     */
	
    public function edit(){
    	if(input('?get.title') && input('?get.g_id')){
    		if(!input('get.title')){
    			return '用户组名不能为空！';
    		}
			$restitle=Db::name('auth_group')->where('id','<>',input('get.g_id'))->where('title',input('get.title'))->find();
			if($restitle){
				return '失败，相同名称用户组已存在！';
			}
    		$title=input('get.title');
			$description=input('get.description');
			$rule='';
			if(input('?get.rules')){
				$rulearr=input('get.rules/a');
				$rule=implode(',',input('get.rules/a'));
            }
			$insdata=['title'=>$title,'description'=>$description,'rules'=>$rule];
			Db::name('auth_group')->where('id',input('get.g_id'))->update($insdata);
			return '保存成功！';
    		
    	}else if(input('?get.group_id') && input('get.group_id')){
    		$groupdb=DB::name('auth_group')->where('id',input('get.group_id'))->find();
    		$resgroup=Db::name('auth_rule')->distinct(true)->field('group')->select();
		    $resrule=Db::name('auth_rule')->where('status',1)->select();
			$rules=array();
			if($groupdb['rules']){
				$rules=explode(',',$groupdb['rules']);
			}
			foreach($resrule as $key=>$val){
				$resrule[$key]['checked']=0;
				foreach($rules as $v){
					if($resrule[$key]['id']==$v){
						$resrule[$key]['checked']=1;
					}
				}
			}
			
			$this->assign('groupdb',$groupdb);				
    	    $this->assign('resgroup',$resgroup);
		    $this->assign('resrule',$resrule);					
    	    return $this -> fetch();
    	}
    	
    }
    /**
     * @cc 启停删户组
     *    
     */
	public function set(){
		if(input('?get.gset')){
			$gid=input('get.gid');
			if(input('get.gset')=='stop'){				
			    Db::name('auth_group')->where('id', $gid)->update(['status' => '0']);													
                return '已停用！';	
			}elseif(input('get.gset')=='start'){
				
			    Db::name('auth_group')->where('id', $gid)->update(['status' => '1']);													
	            return '已启用！';	
			}elseif(input('get.gset')=='del'){
				
				Db::name('auth_group')->delete($gid);
				return '删除成功！';
			}
			
		}

	}
    
	/**
     * @cc 户组列表
     *    
     */
	
	public function grouplist(){
		//取出用户加入列表
		
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('auth_group')->where('id','>',1)->count();	//计算总数						       
        $groupdb=Db::name('auth_group')-> where('id','>',1)->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('auth_group')->where('id','>',1)->where('title','like',$search.'%')->count();	//计算总页数						       
            $groupdb=Db::name('auth_group')-> where('id','>',1)->where('title','like',$search.'%')->limit($offset.','.$limit)->select();
			
		}	
									
		
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$groupdb;
		return json($jsondata);
	}	
}
