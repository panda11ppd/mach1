<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class EditPwd extends controller {
    public function index() {
    	$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){//修改用户密码
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
			$username=$json_arr['username'];
		    $password=$json_arr['password'];
			$newpwd  =$json_arr['newpwd'];
			$newpwden =$json_arr['newpwden'];			
			if(!$username || !$password || !$newpwd){
				$resdata=['code'=>431,'message'=>'error','content'=>'所有内容不能为空'];
				return $opconfig->jsonop($resdata,'en');		
			}elseif($newpwd != $newpwden){
				$resdata=['code'=>432,'message'=>'error','content'=>'两次新码密码不相同'];
				return $opconfig->jsonop($resdata,'en');
			}
			$dat=Db::name('member')->where('name',$username)->where('password',md5($password))->find();			
			if(!$dat) {
				$resdata = ['code'=>433,'message'=>'error','content'=>'用户不存在或密码不正确'];           	          			
            	return $opconfig->jsonop($resdata,'en');
			}else{
				Db::name('member')->where('uid',$dat['uid'])->setField('password', md5($newpwd));
				$res=['username'=>$username,'password'=>$newpwd];				
				$resdata=['data'=>$res,'code'=>5,'message'=>'success','content'=>'密码修改成功'];
				return $opconfig->jsonop($resdata,'en');
			}				
		}else{
			$resdata=['code'=>430,'message'=>'error','content'=>'基本参数错误'];			
			return $opconfig->jsonop($resdata,'en');
		}

    }
}
