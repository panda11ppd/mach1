<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;
use org;

class register extends controller {
    public function index() {
    	$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){//用户注册
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
			$username=$json_arr['username'];
			$password=$json_arr['password'];
			$passworden=$json_arr['passworden'];
			if(empty($json_arr['email'])){
				$email='';
			}else{
				$email=$json_arr['email'];
			}			
			
			if($username==null || $password==null){
				$resdata=['code'=>411,'message'=>'error','content'=>'用户名或密码不能为空'];
				return $opconfig->jsonop($resdata,'en');
			}elseif($password != $passworden){
				$resdata=['code'=>412,'message'=>'error','content'=>'密码和确认密码不相同'];
				return $opconfig->jsonop($resdata,'en');
			}			
			$dat=Db::name('member')->where('name',$username)->find();
			if($dat){
				$resdata=['code'=>413,'message'=>'error','content'=>'用户已存在'];
				return $opconfig->jsonop($resdata,'en');				
			}else{
				$ipsafe = new \org\Ipsafe();
	            $safes=$ipsafe->safes(config('access_control.register_time'),config('access_control.register_num'),config('access_control.register_black_count'));
		        if($safes){
			        $resdata=['code'=>414,'message'=>'error','content'=>'禁止重复申请'];
					return $opconfig->jsonop($resdata,'en');				

		        }
				$createtime=time();
				$userfn=new \app\common\controller\UserFn();
				$scorecon=$userfn->scoreconfig();
				$update=[
				    'name' => $username,
				    'email' => $email,
				    'password' => md5($password),
				    'status' => 1,
				    'createtime' => $createtime,
				    'score'=>ceil($scorecon['newuser_score'])
				];
				Db::name('member')->insert($update);				
				$uid=Db::getLastInsID();
				Db::name('auth_group_access')->insert(['uid' => $uid, 'group_id' => 3]);
				$resdata=['username'=>$username,'uid'=>$uid];								
				$res=['data'=>$resdata,'code'=>2,'message'=>'success','content'=>'申请成功'];
				
				return $opconfig->jsonop($res,'en');
			}				
		}else{			
			$resdata=['code'=>410,'message'=>'error','content'=>'基本参数错误'];
			return $opconfig->jsonop($resdata,'en');
		}

    }
}
