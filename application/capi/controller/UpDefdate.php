<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class UpDefdate extends controller {
	public function index() {
		$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>2444,'message'=>'error','content'=>'提交的数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
			$uid=$json_arr['uid'];
			$token=$json_arr['token'];
			$appid=$json_arr['appid'];
			$appkey=$json_arr['app_key'];
			$defdate=$json_arr['defdate'];          
			if(!$uid || !$token || !$appid || !$appkey){
				$resdata=['uid'=>$uid,'token'=>$token,'appid'=>$appid,'appkey'=>$appkey,'code'=>2441,'code'=>2441,'message'=>'error','content'=>'提交的内容不完整'];
			
				return $opconfig->jsonop($resdata,'en');
			}	
            //刷新令牌
			$tokenop=new Opconfig();
			$resdata=$tokenop->uptoken($uid,$token);
			if($resdata=='token_non' || $resdata=='token_expire'){
				$resdata=['code'=>2445,'message'=>'error','content'=>'令牌错误或已过期'];
			    return $opconfig->jsonop($resdata,'en');
			}			
			//提交数据
			$appdata=['appid'=>$appid,'app_key'=>$appkey];
			$resapp=Db::name('app')->where($appdata)->find($appid);			
			if(!$resapp){
				$resdata=['code'=>2422,'message'=>'error','content'=>'应用不存在'];
				return $opconfig->jsonop($resdata,'en');
			}elseif($resapp['app_status'] < 1){
				$resdata=['code'=>2423,'message'=>'error','content'=>'应用已停用'];			
				return $opconfig->jsonop($resdata,'en');
			}

			$userapp=['uid'=>$uid,'appid'=>$appid];
            $resuadata=Db::name('user_app')->where($userapp)->find();			
			if($resuadata['status'] == 1){				
				Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['user_data'=>$defdate]);			
		        $resdata=['data'=>$defdate,'code'=>27,'message'=>'success','content'=>'数据提交成功'];
				return $opconfig->jsonop($resdata,'en');	
			}else{
				$resdata=['uid'=>$uid,'appid'=>$appid,'code'=>2424,'message'=>'error','content'=>'用户已被停用些应用'];			
				return $opconfig->jsonop($resdata,'en');
			}
            		

		}else{
			$resdata=['code'=>2440,'message'=>'error','content'=>'基础数据错误'];
			return $opconfig->jsonop($resdata,'en');
		}
	}

	
}
