<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class GetToken extends controller {
	public function index(){
		$opconfig=new Opconfig();				
	    if(input('?get.data') && input('get.data')){									    	
	    	$getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
	    	if($json_arr['username'] == null || $json_arr['password'] == null){
	    		$resdata = ['code'=>401,'message'=>'error','content'=>'用户名或密码不能为空'];				
	    		return $opconfig->jsonop($resdata,'en');
	    	}else{
	    		$username = $json_arr['username'];
		        $password = md5($json_arr['password']);								
			    $uid=Db::name('member')->where('name',$username)->where('password',$password)->value('uid');
	    		if($uid == null){
	    			$resdata = ['code'=>402,'message'=>'error','content'=>'用户名或称密错误'];           	          			
            	    return $opconfig->jsonop($resdata,'en');
                }
				$status=Db::name('member')->where('uid',$uid)->value('status');
				if($status == 0){
					$resdata = ['code'=>403,'message'=>'error','content'=>'用户已被管理员停用'];
					return $opconfig->jsonop($resdata,'en');
				}else{//登录成功设置session
				          
                    Session::set('username',$username); //用户名写入session 
				    Session::set('password',$password);	//密码写入session
				    Session::set('uid',$uid);//用户id写入session                   
				    $data['logintime'] = time();//取登录时间
				    $data['lastlogintime']=Db::name('member')->where('uid',$uid)->value('logintime');//取上次登录时间
                    $data['loginip'] = $_SERVER["REMOTE_ADDR"];//登录IP
				    $data['lastloginip']=Db::name('member')->where('uid',$uid)->value('loginip');//上次登录IP
				    //令牌操作
				    $token = $opconfig->instoken($username,$uid);					
				    Db::name('member')->where('uid',$uid)->update($data);//登录更新数据库
                    Db::name('member')->where('uid', $uid)->setInc('logincount');//等录次数加1
                    $auth = new \auth\Auth();
                    $groups=$auth->getGroups($uid);
					$groupid=$groups[0]['group_id'];
                    $res = ['username'=>$username,'uid'=>$uid,'group_id'=>$groupid,'token'=>$token];
					$resdata = ['data'=>$res,'code'=>1,'message'=>'success','content'=>'取用户令牌成功'];					
	    		    return $opconfig->jsonop($resdata,'en');
			      
		        }
	    	}
		}else{
			$resdata = ['code'=>400,'message'=>'error','content'=>'基础参数错误'];
			return $opconfig->jsonop($resdata,'en');
		}		
		
	}
}
