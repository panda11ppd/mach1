<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class UnBind extends controller {
    public function index() {
    	$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}//解除绑定
			if(isset($json_arr['username'])){
            	 $username = $json_arr['username'];
            }else{
            	$username=null;
            }
            if(isset($json_arr['acard'])){
            	$acard = $json_arr['acard'];
            }else{
            	$acard=null;
            }
            if(isset($json_arr['password'])){
            	$password = $json_arr['password'];
            }else{
            	$password=null;
            }
            if(isset($json_arr['appid'])){
            	$appid = $json_arr['appid'];
            }else{
            	$appid=null;
            }
            if($username){
            	if($appid==null || $password==null){
	    		    $resdata = ['code'=>461,'message'=>'error','content'=>'应用id或密码不能为空'];           	          			
            	    return $opconfig->jsonop($resdata,'en');
                }
			    $uid=Db::name('member')->where('name',$username)->where('password',md5($password))->value('uid');
			    if($uid==null){
				    $resdata = ['code'=>462,'message'=>'error','content'=>'用户不存在'];           	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }
			    $uabc=Db::name('user_app')->where('uid',$uid)->where('appid',$appid)->find($appid);
			    if($uabc==null){
				    $resdata = ['code'=>464,'message'=>'error','content'=>'未激活应用,请登录后自动激活'];   //未激活软件        	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }
			    if($uabc['bind_count'] < 1){
				    $resdata = ['code'=>463,'message'=>'error','content'=>'解绑次数不足'];     //绑定次数0      	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }			
                if($uabc['bind_ip']==null && $uabc['bind_mcode']==null || $uabc['bind'] < 1){
				    $resdata = ['code'=>465,'message'=>'error','content'=>'没有绑定,无须解绑']; //没有绑定          	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }
            
			    Db::name('user_app')->where('uid',$uid)->where('appid',$appid)->setDec('bind_count');
			    Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['bind_mcode' => null,'bind_ip' => null]);			
			    $uabc=Db::name('user_app')->where('uid',$uid)->where('appid',$appid)->value('bind_count');
			    $resdata=['username'=>$username,'appid'=>$appid,'bind_count'=>$uabc];
			    $res=['data'=>$resdata,'code'=>8,'message'=>'success','content'=>'解绑定功'];
			    return $opconfig->jsonop($res,'en');           	
            }				   
	    	if($acard){
            	if($appid==null){
	    		    $resdata = ['code'=>4601,'message'=>'error','content'=>'应用id不能为空'];           	          			
            	    return $opconfig->jsonop($resdata,'en');
                }
			    $acarddb=Db::name('acard')->where('acard_number',$acard)->where('appid',$appid)->find();
			    if($acarddb==null){
				    $resdata = ['code'=>4602,'message'=>'error','content'=>'授权码不存在'];           	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }			    
			    if($acarddb['bind_count'] < 1){
				    $resdata = ['code'=>4603,'message'=>'error','content'=>'解绑次数不足'];     //绑定次数0      	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }
			    if($acarddb['status'] < 1){
				    $resdata = ['code'=>4604,'message'=>'error','content'=>'授权已被管理员禁用'];     //授权码禁用     	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }			
                if($acarddb['bind_ip']==null && $acarddb['bind_mcode']==null || $acarddb['bind'] < 1){
				    $resdata = ['code'=>4605,'message'=>'error','content'=>'未绑定,无须解绑']; //没有绑定无需解绑          	          			
            	    return $opconfig->jsonop($resdata,'en');
			    }
            
			    Db::name('acard')->where('acard_number',$acard)->where('appid',$appid)->setDec('bind_count');
			    Db::name('acard')->where('acard_number',$acard)->where('appid', $appid)->update(['bind_mcode' => null,'bind_ip' => null]);			
			    $uabc=Db::name('acard')->where('acard_number',$acard)->where('appid',$appid)->value('bind_count');
			    $bindcount=['acard'=>$acard,'appid'=>$appid,'bind_count'=>$uabc];
			    $res=['data'=>$bindcount,'code'=>8,'message'=>'success','content'=>'解绑成功'];
			    return $opconfig->jsonop($res,'en');           	
            }else{
            	$resdata=['code'=>460,'message'=>'error','content'=>'解绑类型错误'];			
			    return $opconfig->jsonop($resdata,'en');
            }		
		}else{
			$resdata=['code'=>460,'message'=>'error','content'=>'基础数据错误'];			
			return $opconfig->jsonop($resdata,'en');
		}

    }
}
