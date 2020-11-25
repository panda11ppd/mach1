<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class GetUserApp extends controller {
	public function index() {
		$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
			$uid=$json_arr['uid'];
			$token=$json_arr['token'];
			$appid=$json_arr['appid'];
			$appkey=$json_arr['app_key'];           
			if(!$uid || !$token || !$appid || !$appkey){
				$resdata=['uid'=>$uid,'token'=>$token,'appid'=>$appid,'appkey'=>$appkey,'code'=>441,'message'=>'error','content'=>'提交数据内容不完整'];
			
				return $opconfig->jsonop($resdata,'en');
			}	
            //刷新令牌
			$tokenop=new Opconfig();
			$resdata=$tokenop->uptoken($uid,$token);
			if($resdata=='token_non' || $resdata=='token_expire'){
				$resdata=['code'=>445,'message'=>'error','content'=>'令牌错误或已过期'];
			    return $opconfig->jsonop($resdata,'en');
			}			
			//取应用信息
			$appdata=['appid'=>$appid,'app_key'=>$appkey];
			$resapp=Db::name('app')->where($appdata)->find($appid);			
			if(!$resapp){
				$resdata=['code'=>422,'message'=>'error','content'=>'应用不存在'];
				return $opconfig->jsonop($resdata,'en');
			}elseif($resapp['app_status'] < 1){
				$resdata=['code'=>423,'message'=>'error','content'=>'应用已被停用'];			
				return $opconfig->jsonop($resdata,'en');
			}

			$userapp=['uid'=>$uid,'appid'=>$appid];
            $resuadata=Db::name('user_app')->where($userapp)->find();
			if($resuadata==FALSE){//激活应用
				$test_time=$resapp['test_time'];//取试用分钟
				$acitvetime=time();//激活时间
				$expiretime=strtotime('+'.$test_time.' minutes');//得到试用时间
				if($resapp['app_bind'] < 1){
					$bindip=null;
					$bindmcode=null;
				}
				if($resapp['app_bind']==2){
					if($json_arr['mcode']){
						$bindmcode=$json_arr['mcode'];
						$bindip=null;
					}else{
						$resdata=['bind'=>2,'code'=>446,'message'=>'error','content'=>'机器码未提交'];
						return $opconfig->jsonop($resdata,'en');
					}
					
				}elseif($resapp['app_bind']==1){
					$bindip=$this->getip();	
					$bindmcode=null;				 
				}elseif($resapp['app_bind']==3){
					if($json_arr['mcode']){
						$bindip=$this->getip();
						$bindmcode=$json_arr['mcode'];
					}else{
						$resdata=['bind'=>3,'code'=>446,'message'=>'error','content'=>'机器码未提交'];
						return $opconfig->jsonop($resdata,'en');
					}
				}
				//激活应用
				$acitvedata = ['uid' => $uid, 'appid' => $appid, 'active_time' => $acitvetime, 'expire_time'=>$expiretime,'bind'=>$resapp['app_bind'],'bind_mcode'=>$bindmcode,'bind_ip'=>$bindip];//激活应用
				Db::name('user_app')->insert($acitvedata);
			}
            $resuadata=Db::name('user_app')->where($userapp)->find();
			if($resuadata['status'] < 1){
				$resdata=['code'=>447,'message'=>'error','content'=>'用户已被管理员禁止使用此应用'];		
				return $opconfig->jsonop($resdata,'en');			
			}
			if($resuadata['bind']==2 || $resuadata['bind']==3){
				if($json_arr['mcode']==FALSE){											
					$resdata=['bind'=>23,'code'=>446,'message'=>'error','content'=>'机器码不能为空'];
					return $opconfig->jsonop($resdata,'en');
				}elseif($resuadata['bind_mcode']==null && $resuadata['bind']==2){
					Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['bind_mcode' => $json_arr['mcode']]);					
				}elseif($resuadata['bind_mcode']==null && $resuadata['bind']==3){
					Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['bind_mcode' => $json_arr['mcode'],'bind_ip' => $this->getip()]);
				}elseif($resuadata['bind_mcode'] && $resuadata['bind']==2){
					if($resuadata['bind_mcode'] != $json_arr['mcode']){
						$resdata=['code'=>448,'message'=>'error','content'=>'机器码不正确'];
						return $opconfig->jsonop($resdata,'en'); 
					}
				}elseif($resuadata['bind_mcode'] && $resuadata['bind']==3){
					if($resuadata['bind_mcode'] != $json_arr['mcode'] || $resuadata['bind_ip'] != $this->getip()){
						$resdata=['code'=>449,'message'=>'error','content'=>'IP或机器码不正确'];
						return $opconfig->jsonop($resdata,'en');
					}
				}								
			}elseif($resuadata['bind']==1){
				if($resuadata['bind_ip']==null){
					Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['bind_ip' => $this->getip()]);
				}elseif($resuadata['bind_ip'] != $this->getip()){
					$resdata=['code'=>450,'message'=>'error','content'=>'绑定的IP不正确'];
					return $opconfig->jsonop($resdata,'en');
				}
					
			}
			//end绑定检测
			if($resapp['free'] < 1){
				Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['loginip'=>$this->getip()]);
				$uadata=['expire_time'=>'no_expire','app_free'=>'0','fee_count'=>$resuadata['fee_count'],'user_data'=>$resuadata['user_data']];				
				$resdata=['data'=>$uadata,'code'=>7,'message'=>'success','content'=>'数据读取成功'];
				return $opconfig->jsonop($resdata,'en');
            }
		
			$activetime=date('Y-m-d H:i:s',$resuadata['active_time']);//激活时间
			$expiretime=date('Y-m-d H:i:s',$resuadata['expire_time']);//到期时间
			$day=$this->maktimes($resuadata['expire_time']);
			if($day === 'exp'){
				$resuadata=['expire_time'=>$expiretime,'app_free'=>'1','days'=>'0','fee_count'=>$resuadata['fee_count'],'user_data'=>$resuadata['user_data']];
		        $resdata=['data'=>$resuadata,'code'=>451,'message'=>'error','content'=>'用户已到期'];
				return $opconfig->jsonop($resdata,'en');	
			}else{
				Db::name('user_app')->where('uid', $uid)->where('appid', $appid)->update(['loginip'=>$this->getip()]);
				$resuadata=['expire_time'=>$expiretime,'app_free'=>'1','days'=>$day,'fee_count'=>$resuadata['fee_count'],'user_data'=>$resuadata['user_data']];
		        $resdata=['data'=>$resuadata,'code'=>7,'message'=>'success','content'=>'数据读取成功'];
				return $opconfig->jsonop($resdata,'en');	
			}
            		

		}else{
			$resdata=['code'=>440,'message'=>'error','content'=>'基础数据不完整'];
			return $opconfig->jsonop($resdata,'en');
		}
	}
    public function maktimes($times){//计算剩余天数   
        $now = time();		
		$remain = $times-$now;			             
		if($remain < 1){
			return 'exp';
		}else{
			
		    $endday = round($remain/(3600*24));
            return $endday; 
		}		
          
    } 
    public function getip(){
        global $ip;
        if (getenv("HTTP_CLIENT_IP")){
        	$ip = getenv("HTTP_CLIENT_IP");
        }elseif(getenv("HTTP_X_FORWARDED_FOR")){
        	$ip = getenv("HTTP_X_FORWARDED_FOR");
        }elseif(getenv("REMOTE_ADDR")){
        	$ip = getenv("REMOTE_ADDR");
        }else{
        	$ip = "Unknow";
        }
        return $ip;
    }
	
}
