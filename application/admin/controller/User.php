<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class user extends Base {
	/**
    * @cc 用户管理
    *    
    */
	public function index() {
		return $this -> fetch();
	}
	/**
    * @cc 添加用户
    *    
    */
    public function add(){
    	if(input('?get.username') && input('?get.password') && input('?get.password2')){
    	    $username=input('get.username');
			$password=input('get.password');
			$password2=input('get.password2');
			if($username==null || $password==null){				
				return '用户名或密码不能为空！';
			}elseif($password != $password2){
				return '确认密码不相同！';
			}			
			$dat=Db::name('member')->where('name',$username)->find();
			if($dat){
				
				return '用户已存在！';				
			}else{
				$createtime=time();
				Db::name('member')->insert(['name' => $username, 'password' => md5($password),'status' => 1,'createtime' => $createtime]);
				$uid=Db::getLastInsID();
				Db::name('auth_group_access')->insert(['uid' => $uid, 'group_id' => 3]);
				return '用户“'.$username.'"添加成功!';
			}			
    	}
    				
    	return $this -> fetch();
    }
	/**
    * @cc 编辑用户
    *    
    */
    public function edit(){
    	if(input('?get.uid') && input('?get.password') && input('?get.password2')){
    		$uid=input('get.uid');
			$password=input('get.password');
			$password2=input('get.password2');
			$usergroup=input('get.usergroup');
			$comments=input('get.comments');	  			
    		if($password==$password2){
    			$username=Db::name('member')->where('uid',$uid)->value('name');
				if($username){
					Db::name('member')->where('uid',$uid)->setField('score',input('get.score'));
					Db::name('member')->where('uid',$uid)->setField('comments',$comments);
					if($password==null){						
    			        $username=Db::name('auth_group_access')->where('uid',$uid)->setField('group_id',$usergroup);
						return '修改成功！';
    		        }else{
    		        	$username=Db::name('member')->where('uid',$uid)->setField('password',md5($password));
					    $username=Db::name('auth_group_access')->where('uid',$uid)->setField('group_id',$usergroup);
						return '修改成功！';
    		        }
					
					
				}
				return '修改失败，用户不存在！';
    		}
			return '修改失败，确认密码不相同！';
			
    	}
		
    	if(input('?get.uid') && input('get.uid')){//修改用户密码		
		    $uid=input('get.uid');
		    if($uid!=1){
			    $userdb=Db::name('member')->where('uid',$uid)->find();
			    //$userinfo = Db::name('member') -> where('functions','in','useredit') -> select();
			    $groupinfo = Db::name('auth_group') -> where('status',1)->where('id','>',1) -> select();
				$auth = new \auth\Auth();
			    $userarray=$auth->getGroups($uid);//取用户所在组
			    $usergroup=$userarray[0]['title'];
			    $this -> assign('usergroup', $usergroup);
			    $this -> assign('userdb', $userdb);
			    $this -> assign('uid', $uid);
			    //$this -> assign('userinfo', $userinfo);
			    $this -> assign('groupinfo', $groupinfo);
			    return $this -> fetch();
		    }
		}
    }
    /**
    * @cc 启停删用户
    *    
    */
	public function set(){
		if(input('?post.userset')){
			$uid=input('post.uid');
			if(input('post.userset')=='stop' && $uid!=1){
				$username=Db::name('member')->where('uid',$uid)->value('name');
			    Db::name('member')->where('uid', $uid)->update(['status' => '0']);													
                return '用户  "'.$username.'"  已停用！';	
			}elseif(input('post.userset')=='start' && $uid!=1){
				$username=Db::name('member')->where('uid',$uid)->value('name');
			    Db::name('member')->where('uid', $uid)->update(['status' => '1']);													
	            return '用户  "'.$username.'"  已启用！';	
			}elseif(input('post.userset')=='dellist'){
				$arruser=input('post.data/a');
				$users=array();
				foreach($arruser as $k=>$v){
					$users[]=$arruser[$k]['uid'];
				}
				Db::name('member')->delete($users);
				return '删除成功！';
			}
			
		}

	}
	/**
    * @cc 编辑用户应用信息
    *    
    */
    public function appedit(){
    	if(input('?get.set') && input('get.set')=='appedit'){
    		$bindcount=input('get.bind_count');
    		if(!is_numeric($bindcount)){
    			return '绑定次数只能是数字';				
    		}elseif($bindcount < 0){
    			return '绑定次数必须大于等于0';
    		}
			if(input('get.expire_time') < 1){
				$getdata['expire_time']=0;
			}else{
				$expiretime=input('get.expire_time');
			    $getdata['expire_time']=strtotime($expiretime);	
			}    		
			$getdata['status']=input('get.status');
			$getdata['bind']=input('get.bind');
			$getdata['user_data']=input('get.user_data');
			$getdata['bind_count']=input('get.bind_count');
			DB::name('user_app')->where('uid',input('get.uid'))->where('appid',input('get.appid'))->update($getdata);
			return '修改成功!';
			
    	}
    	if(input('?get.uid') && input('?get.appid')){
    		$uid=input('get.uid');
			$appid=input('get.appid');
			$username=DB::name('member')->where('uid',$uid)->value('name');
			$appname=DB::name('app')->where('appid',$appid)->value('app_name');
    	    if($username && $appname){
    	    	$this->assign('username',$username);
    		    $this->assign('uid',$uid);
			    $this->assign('appid',$appid);
				$this->assign('app_name',$appname);
    	    	$resapp=Db::name('user_app')->where('uid',$uid)->where('appid',$appid)->find();
				$activetime=date('Y-m-d H:i',$resapp['active_time']);
				if($resapp['expire_time'] < 1){
					$expiretime=0;
				}else{
				    $expiretime=date('Y-m-d H:i',$resapp['expire_time']);	
				}

				$this->assign('resapp',$resapp);
				$this->assign('activetime',$activetime);						
			    $this->assign('expiretime',$expiretime);
			    return $this->fetch();
    	    }
			return 'error';
			
    	}elseif(input('?get.sid') && input('?get.uid')){
    		$sid=input('get.sid');
			$uid=input('get.uid');
			$exptime = strtotime(input('get.exptime'));
			Db::name('user_soft')->where('uid', $uid)->where('sid', $sid)->update(['expire_time' => $exptime]);
			return '修改成功！';
    		
    	}else{
    		return '错误，请重试！';
    	}
    }
    /**
    * @cc 用户应用信息
    *    
    */
	public function app(){
		$uid=input('get.uid');
		$this->assign('uid',$uid);
		$username=Db::name('member')->where('uid',$uid)->value('name');
		$this->assign('username',$username);				
		if(input('get.table')=='list'){
			$app=Db::name('app')->where('app_status',1)->field('appid,app_name')->select();
			$userapp=Db::name('user_app')->where('uid',$uid)->select();				
			foreach($app as $skey=>$sval){
				$app[$skey]['active']='<span style="color:#CC0000">未激活</span>';
			    $app[$skey]['active_time']=null;
				$app[$skey]['expire_time']=null;	
				foreach($userapp as $ukey=>$uval){
					if($app[$skey]['appid']==$userapp[$ukey]['appid']){
					    $app[$skey]['active']='<span style="color:#00CC00">已激活</span>';						
					    $app[$skey]['active_time']=date('Y-m-d H:i:s',$userapp[$ukey]['active_time']);
						if($userapp[$ukey]['expire_time'] < 1){
							$app[$skey]['expire_time']='0';
						}else{
						    $app[$skey]['expire_time']=date('Y-m-d H:i:s',$userapp[$ukey]['expire_time']);	
						}
						if($userapp[$ukey]['status'] < 1){
							$app[$skey]['status']='<p class="text-danger">停用<p>';
						}else{
							$app[$skey]['status']='<p class="text-primary">启用</p>';
						}
						$app[$skey]['bind_ip']=$userapp[$ukey]['bind_ip'];
						$app[$skey]['bind_mcode']=$userapp[$ukey]['bind_mcode'];					    
						$app[$skey]['bind_count']=$userapp[$ukey]['bind_count'];
						$app[$skey]['user_data']=$userapp[$ukey]['user_data'];					
					}					
				}										
		    }
			return json($app);
		}

		return $this -> fetch();
		
	}
   /**
    * @cc 激活用户应用
    *    
    */
	public function activeapp(){
		if(input('?get.appid') && input('?get.uid')){
			$uid=input('get.uid');
			$appid=input('get.appid');			
			$userapp=['uid'=>$uid,'appid'=>$appid];
			$resapp=Db::name('app')->where('appid',$appid)->find($appid);
            $resuadata=Db::name('user_app')->where($userapp)->find($uid);
			//激活应用
			if($resuadata){
				return '用户已激活，无需再激活！';
			}else{
				$test_time=$resapp['test_time'];//取试用分钟
			    $acitvetime=time();//激活时间
			    $expiretime=strtotime('+'.$test_time.' minutes');//得到试用时间				
			    $bindip=null;
			    $bindmcode=null;				
			    //激活应用
			    $acitvedata = ['uid' => $uid, 'appid' => $appid, 'active_time' => $acitvetime, 'expire_time'=>$expiretime,'bind'=>$resapp['app_bind'],'bind_mcode'=>$bindmcode,'bind_ip'=>$bindip];//激活应用
			    Db::name('user_app')->insert($acitvedata);
				return '用户激活成功！';
			}
						
		}
		
	}
	/**
    * @cc 用户列表
    *    
    */
	public function userlist(){
		//取出用户加入列表
		$auth = new \auth\Auth();
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('member')->where('uid','>',1)->count();	//计算总数						       
        $userdb=Db::name('member')-> where('uid','>',1)->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('member')->where('uid','>',1)->where('name','like',$search.'%')->count();	//计算总页数						       
            $userdb=Db::name('member')-> where('uid','>',1)->where('name','like',$search.'%')->limit($offset.','.$limit)->select();
			
		}	
									
		foreach($userdb as $key=>$val){
			$useruid=$userdb[$key]['uid'];
		    $userarray=$auth->getGroups($useruid);//取用户所在组
		    $usergroup='';
		    foreach($userarray as $k=>$v){
		    	$usergroup.=$userarray[$k]['title'].',';
		    	
            }
							
			$userdb[$key]['usergroup']=$usergroup;	
			$uscount=Db::name('user_app')->where('uid',$useruid)->count();
			$userdb[$key]['actionsoft']=$uscount;
			if(!empty($userdb[$key]['createtime'])){						
				$userdb[$key]['createtime'] = date('Y-m-d H:i:s',$val['createtime']);//格式化时间						
			}
			if(!empty($userdb[$key]['logintime'])){
				$userdb[$key]['logintime'] = date('Y-m-d H:i:s',$val['logintime']);//格式化时间
			}
			if(!empty($userdb[$key]['lastlogintime'])){
				$userdb[$key]['lastlogintime'] = date('Y-m-d H:i:s',$val['lastlogintime']);//格式化时间
			}
            if($userdb[$key]['status']==1){
                $userdb[$key]['status']='<span style="color:#0099FF">启用</span>';                  	
            }else{
                $userdb[$key]['status']='<span style="color:#CC0000">停用</span>';
            }															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$userdb;
		return json($jsondata);
	}	
}
