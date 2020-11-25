<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Request;
use think\Db;

class Agents extends Base {
	/**
    * @cc 代理商
    *    
    */
    
	public function index() {
		if(input('?get.limit')){
			
			$limit=input('get.limit');
		    $offset=input('get.offset');			
		    $total=Db::name('agents')->where('status',1)->count();	//计算总数						       
            $agents=Db::name('agents')->where('status',1)->page($offset.','.$limit)->select();
		    
			foreach($agents as $k=>$v){
				$agents[$k]['add_time']=time2date($agents[$k]['add_time']);
				$user=$this->getuser($agents[$k]['uid']);
				$agents[$k]['name']=$user['name'];
				$agents[$k]['score']=ceil($user['score']);
				$agents[$k]['email']=$user['email'];
				$appdb=$this->getagentgoods($agents[$k]['uid']);				
				if($agents[$k]['status']){
					$agents[$k]['status']='<span style="color:#00cc00">已启用</span>';
				}else{
					$agents[$k]['status']='<span style="color:#CC0000">已停用</span>';
				}				
				$agents[$k]['app_num']=count($appdb);
				$types=$this->gettypes($agents[$k]['type']);
				if($types){
					$agents[$k]['type_name']=$types['name'];
				}else{
					$agents[$k]['type_name']='';
				}
				
				
			}
			$jsondata['total']=$total;				
		    $jsondata['rows']=$agents;
		    return json($jsondata);
			
		}
		
		return $this -> fetch();
	}
    /**
    * @cc 启停删代理
    *    
    */
	public function set(){
		if(input('?get.userset')){
			$uid=input('get.uid');
			if(input('get.userset')=='stop' && $uid!=1){
			    Db::name('agents')->where('uid', $uid)->update(['status' => '0']);													
                return '已停用！';	
			}elseif(input('get.userset')=='start' && $uid!=1){
			    Db::name('agents')->where('uid', $uid)->update(['status' => '1']);													
	            return '已启用！';	
			}elseif(input('get.userset')=='dellist'){
				$arruser=input('get.data/a');
				$users=array();
				foreach($arruser as $k=>$v){
					$users[]=$arruser[$k]['uid'];
				}
				Db::name('agents')->where('uid','in',$users)->delete();
				return '删除成功！';
			}
			
		}

	}	  
    /**
    * @cc 代理商祥细信息
    *    
    */
	public function agentsinfo(){
		if(request()->isAjax()){
			if(input('?get.atype')){
				$type=input('get.atype');
			    Db::name('agents')->where('uid',input('get.uid'))->setField('type',$type);
			    return '修改成功';
			}else if(input('?get.score')){
				$userfn=new \app\common\controller\UserFn();
				$scores=$userfn->incScore(input('get.uid'),input('get.score/d'));
				$userfn->scorerecord(input('get.uid'),$type='plus',input('get.score/d'),'系统增加代理积分');
				return '修改成功';
			}
			
		}
		if(input('?get.uid')){
			$uid=input('get.uid');		
			$acard=Db::name('acard')->where('agent_uid',$uid)->count();
			$acardun=Db::name('acard')->where('agent_uid',$uid)->where('sales_status',1)->count();
			$card=Db::name('card')->where('agent_uid',$uid)->count();
			$cardun=Db::name('card')->where('agent_uid',$uid)->where('sales_status',1)->count();
			$userdb=$this->getuser($uid);
			$userdb['score']=ceil($userdb['score']);			
			$this->assign('userdb',$userdb);
			$goodsdb=$this->getagentgoods($uid);			
			$this->assign('goodsdb',$goodsdb);			
			$agentsdb=$this->getagents($uid);
			$agentsdb['login_time']=time2date($agentsdb['login_time']);
			$agentsdb['add_time']=time2date($agentsdb['add_time']);	
			$this->assign('agentsdb',$agentsdb);					
			$this->assign('agenttype',$this->agenttype($uid));
			$this->assign('acard',$acard);
			$this->assign('acardun',$acardun);
			$cardtype=Db::name('card_type')->select();
			$this->assign('cardtype',$cardtype);
			$this->assign('card',$card);
			$this->assign('cardun',$cardun);
			$this->assign('alltype',$this->gettypes('all'));
			
			return $this -> fetch();
		}
	
	}
   /**
    * @cc 代理商卡列表
    *    
    */	

	public function agentslist(){
		if(request()->isAjax()){
		    if(input('?get.appid') && input('?get.cardtype') && input('?get.uid')){		    	
		    	$limit=input('get.limit');
		        $offset=input('get.offset')-1;
		    	if(input('get.cardtype')==='acard'){
		    		$where=['agent_uid'=>input('get.uid'),'appid'=>input('get.appid'),'status'=>1];
		    		$total=Db::name('acard')->where($where)->count();	//计算总数	
		    		$listdb=Db::name('acard')-> where($where)->page($offset.','.$limit)->select();
					foreach($listdb as $k=>$v){
						$listdb[$k]['type']='授权码';
						$listdb[$k]['number']=$listdb[$k]['acard_number'];
						if($listdb[$k]['sales_status'] < 1){
							$listdb[$k]['sales_status']='未出售';
						}else if($listdb[$k]['sales_status'] > 1){
							$listdb[$k]['sales_status']='已使用';
						}else{
							$listdb[$k]['sales_status']='已出售';
						}
						
					}
		    	}else{		    		
		    		$where=['agent_uid'=>input('get.uid'),'appid'=>input('get.appid'),'type'=>input('get.cardtype'),'status'=>1];
		    		$total=Db::name('card')->where($where)->count();	//计算总数	
		    		$listdb=Db::name('card')-> where($where)->page($offset.','.$limit)->select();
		    	    foreach($listdb as $k=>$v){
		    	    	$listdb[$k]['type']='充值卡';
						$listdb[$k]['number']=$listdb[$k]['card_number'];					
						if($listdb[$k]['sales_status'] < 1){
							$listdb[$k]['sales_status']='未出售';
						}else if($listdb[$k]['sales_status'] > 1){
							$listdb[$k]['sales_status']='已使用';
						}else{
							$listdb[$k]['sales_status']='已出售';
						}
						
					}
				}
				
				$jsondata['total']=$total;
		        $jsondata['rows']=$listdb;
		        return json($jsondata);		        
		    }
	
		}
	
	}
	/**
    * @cc 取消分配
    *    
    */
    public function setdist(){
    	if(input('get.sets')=='dellist'){
			$arrdb=input('get.data/a');
			$cid=array();
			$type='';
			foreach($arrdb as $k=>$v){
				$cid[]=$arrdb[$k]['id'];
				if($arrdb[$k]['type']==='授权码'){
					$type='acard';
				}else{
					$type='card';
				}
			}
			Db::name($type)->where('id','in',$cid)->setField('agent_uid',1);
			return '取消分配成功！';
		}
	}
    /**
    * @cc 代理商认证
    *    
    */
	public function wait() {
		if(input('?get.limit')){			
			$limit=input('get.limit');
		    $offset=input('get.offset');			
		    $total=Db::name('agents_goods')->where('status',0)->count();	//计算总数						       
            $agents=Db::name('agents_goods')->where('status',0)->page($offset.','.$limit)->select();		    
			foreach($agents as $k=>$v){
				$agents[$k]['add_time']=time2date($agents[$k]['add_time']);
				$user=$this->getuser($agents[$k]['uid']);
				$agents[$k]['name']=$user['name'];
				$agents[$k]['score']=ceil($user['score']);
				$agents[$k]['email']=$user['email'];
				$goodsdb=$this->getgoods($agents[$k]['goods_id']);				
				$agents[$k]['goods_name']=$goodsdb['title'];
				if($agents[$k]['status']){
					$agents[$k]['status']='<span style="color:#00cc00">已启用</span>';
				}else{
					$agents[$k]['status']='<span style="color:#CC0000">已停用</span>';
				}								
				$types=$this->agenttype($agents[$k]['uid']);
				if($types){
					$agents[$k]['agent_type']=$types['name'];
				}else{
					$agents[$k]['anget_type']='';
				}
				
				
			}
			$jsondata['total']=$total;				
		    $jsondata['rows']=$agents;
		    return json($jsondata);
			
		}
		
		return $this -> fetch();
	}
   /**
    * @cc 代理商认证设置
    *    
    */
    public function waitset(){
    	if(request()->isAjax()){
    		if(input('get.aset') === 'add'){
    			db('agents_goods')->where('id',input('get.aid'))->setField('status',1);    			
				return '操作成功';
    		}else if(input('get.aset') === 'del'){
    			db('agents_goods')->delete(input('get.aid'));
				return '删除成功';
    		}else if(input('get.aset') === 'alladd'){
    			$arrdb=input('get.data/a');
			    $cid=array();			    
			    foreach($arrdb as $k=>$v){
				    $cid[]=$arrdb[$k]['id'];
				    
			    }
			    Db::name('agents_goods')->where('id','in',$cid)->setField('status',1);
				return '操作成功';
    		}
			return 'error';
    	}
		return 'error';
    }
	/**
    * @cc 代理类型管理
    *    
    */
	public function types(){
		if(request()->isAjax()){			
		    $limit=input('get.limit');
		    $offset=input('get.offset');			
		    $total=Db::name('agents_type')->count();	//计算总数						       
            $type=Db::name('agents_type')->page($offset.','.$limit)->select();				
			$jsondata['total']=$total;				
		    $jsondata['rows']=$type;
		    return json($jsondata);
		}
		return $this -> fetch();
	}
	
	/**
    * @cc 删除代理类型
    *    
    */
	public function typeset(){
		if(request()->isAjax()){
			if(input('post.id')==1) return '系统默认代理,不许删除';
			db('agents_type')->where('id',input('post.id'))->delete();			
		    return '删除成功 ！';
		    
		}
		
	}
	/**
    * @cc 添加代理类型
    *    
    */
	public function addtype(){
		if(request()->isAjax()){			
		    $name=input('post.name/s'); 
			$discount=input('post.discount/d');
			$resdb=Db::name('agents_type')->where('name',$name)->find();
			if($resdb){
				return '同类名称已存在！';
			}
			
			if($name && $discount){
				Db::name('agents_type')->insert(['name'=>$name,'discount'=>$discount]);
				return '添加成功';
			}else{
				return '请填写完整信息';
			}   
		    
		}
		return $this -> fetch();
	}
	/**
    * @cc 编辑代理类型
    *    
    */
	public function edittype(){
		if(request()->isAjax()){
			$typeid=input('post.typeid');			
		    $name=input('post.name/s'); 
			$discount=input('post.discount/d');
			$resdb=Db::name('agents_type')->where('id','<>',$typeid)->where('name',$name)->find();
			if($resdb){
				return '同类名称已存在！';
			}
			
			if($name && $discount){
				Db::name('agents_type')->where('id',$typeid)->update(['name'=>$name,'discount'=>$discount]);
				return '修改成功';
			}else{
				return '请填写完整信息';
			}   
		    
		}
		$typeid=input('get.typeid');
		$typedb=db('agents_type')->where('id',$typeid)->find();
		$this->assign('typedb',$typedb);
		return $this -> fetch();
	}
	/**
    * @cc 代理商品相关
    *    
    */
    public function goods(){
    	if(request()->isAjax()){			
		    $limit=input('get.limit');
		    $offset=input('get.offset');
		    $total=Db::name('goods')->count();	//计算总数						       
            $type=Db::name('goods')->limit($offset.','.$limit)->select();
			foreach($type as $k=>$v){				
				$type[$k]['agent_count']=$this->agentcount($type[$k]['goods_id']);
			}				
			$jsondata['total']=$total;				
		    $jsondata['rows']=$type;
		    return json($jsondata);
		}
		return $this -> fetch();
    }
	/**
    * @cc 启停代理商品
    *    
    */
	public function goodsset(){
		if(request()->isAjax()){
			if(input('get.goodsop')=='stop'){
				db('goods')->where('goods_id',input('get.goods_id'))->setField('agent_status',0);
			}else{
				db('goods')->where('goods_id',input('get.goods_id'))->setField('agent_status',1);
			}
			
			return '-操作成功';
		}
		
	}
	//取代理商数量
	private function agentcount($goodsid){
    	$res=Db::name('agents_goods')->where('goods_id',$goodsid)->where('status',1)->count();
			
		return $res;
    }
    private function getgoods($goodsid){
    	$res=Db::name('goods')->where('goods_id',$goodsid)->find();
		return $res;
    }
    private function agenttype($uid){
    	$types=Db::name('agents')->where('uid',$uid)->value('type');
		
		return $this->gettypes($types);
	}
	private function gettypes($types){
		if($types==='all'){
			$types=Db::name('agents_type')->select();
			return $types;
		}
		$types=Db::name('agents_type')->where('id',$types)->find();
		return $types;
	}
	private function getagentgoods($uid){
		$agentgoods=Db::name('agents_goods')->where('uid',$uid)->select();
		
		$reg=array();
		if($agentgoods){
			foreach($agentgoods as $k => $v){
			    $app=Db::name('goods')->where('goods_id',$agentgoods[$k]['goods_id'])->find();
				if($app) $reg[$k]=array_merge($agentgoods[$k],$app); 
		    }
			
			return $reg;
		}else{
			return FALSE;
		}
	}
	private function getagents($uid){
		$res=Db::name('agents')->where('uid',$uid)->find();
		return $res;
	}
    private function getuser($uid){
	    $user=Db::name('member')->where('uid',$uid)->find();
	    if($user){
		    return $user;
	    }else{
		    return FALSE;
	    }
    }	
	

}
