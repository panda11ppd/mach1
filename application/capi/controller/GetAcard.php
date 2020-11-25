<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class GetAcard extends controller {//授权码
	public function index() {
		$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){//修改用户密码
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
			if(isset($json_arr['acard'])){
            	 $acard = $json_arr['acard'];
            }else{
            	$acard=null;
            }           
            if(isset($json_arr['appid'])){
            	 $appid = $json_arr['appid'];
            }else{
            	$appid=null;
            }           
            if(isset($json_arr['app_key'])){
            	 $appkey = $json_arr['app_key'];
            }else{
            	$appkey=null;
            }
          
			if($acard==null || $appid==null || $appkey==null){
				$resdata=['code'=>4401,'message'=>'error','content'=>'内容不完整'];
				return $opconfig->jsonop($resdata,'en');
			}	
		
			//取应用信息
			$appdata=['appid'=>$appid,'app_key'=>$appkey];
			$resapp=Db::name('app')->where($appdata)->find($appid);			
			if(!$resapp){
				$resdata=['code'=>4202,'message'=>'error','content'=>'应用不存在'];
				return $opconfig->jsonop($resdata,'en');
			}elseif($resapp['app_status'] < 1){
				$resdata=['code'=>4203,'message'=>'error','content'=>'应用已停用'];			
				return $opconfig->jsonop($resdata,'en');
			}
			$sdata=['acard_number'=>$acard,'appid'=>$appid];
            $acarddb=Db::name('acard')->where($sdata)->find();
            if(!$acarddb){
				$resdata=['code'=>4204,'message'=>'error','content'=>'授权码不存在'];
				return $opconfig->jsonop($resdata,'en');
			}
            if($acarddb['status'] < 1){
            	$resdata=['code'=>4407,'message'=>'error','content'=>'授权码已停用'];		
				return $opconfig->jsonop($resdata,'en');
            }
			if($acarddb['active_time'] < 1 || $acarddb['active_time']==null){//激活应用
				
				$inittime=$resapp['acard_time'];//取初始天数
				$acitvetime=time();//激活时间
				$expiretime=strtotime('+'.$inittime.' minutes');//得到试用时间
				if($acarddb['bind'] < 1){
					$bindip=null;
					$bindmcode=null;
				}
				if($acarddb['bind']==2){
					if($json_arr['mcode']){
						$bindmcode=$json_arr['mcode'];
						$bindip=null;
					}else{
						$resdata=['code'=>4406,'message'=>'error','content'=>'机器码参数未提交'];
						return $opconfig->jsonop($resdata,'en');
					}
					
				}elseif($resapp['app_bind']==1){
					$bindip=$this->getip();	
					$bindmcode=null;				 
				}elseif($acarddb['bind']==3){
					if($json_arr['mcode']){
						$bindip=$this->getip();
						$bindmcode=$json_arr['mcode'];
					}else{
						$resdata=['code'=>4406,'message'=>'error','content'=>'机器码参数未提交'];
						return $opconfig->jsonop($resdata,'en');
					}
				}
				//激活授权码
				$acitvedata = [
				    'active_time' => $acitvetime,
				    'expire_time'=>$expiretime,
				    'bind_mcode'=>$bindmcode,
				    'bind_ip'=>$bindip
				];
				Db::name('acard')->where('acard_number',$acard)->where('appid',$appid)->update($acitvedata);
			}
            
			if($acarddb['bind']==2 || $acarddb['bind']==3){//重新绑定
				if($json_arr['mcode']==FALSE){											
					$resdata=['code'=>4406,'message'=>'error','content'=>'机器码参数未提交'];
					return $opconfig->jsonop($resdata,'en');
				}elseif($acarddb['bind_mcode']==null && $acarddb['bind']==2){
					Db::name('acard')->where('acard_number', $acard)->where('appid', $appid)->update(['bind_mcode' => $json_arr['mcode']]);					
				}elseif($acarddb['bind_mcode']==null && $acarddb['bind']==3){
					Db::name('acard')->where('acard_number', $acard)->where('appid', $appid)->update(['bind_mcode' => $json_arr['mcode'],'bind_ip' => $this->getip()]);
				}elseif($acarddb['bind_mcode'] && $acarddb['bind']==2){
					if($acarddb['bind_mcode'] != $json_arr['mcode']){
						$resdata=['code'=>4408,'message'=>'error','content'=>'机器码不正确'];
						return $opconfig->jsonop($resdata,'en'); 
					}
				}elseif($acarddb['bind_mcode'] && $acarddb['bind']==3){
					if($acarddb['bind_mcode'] != $json_arr['mcode'] || $acarddb['bind_ip'] != $this->getip()){
						$resdata=['code'=>4409,'message'=>'error','content'=>'绑定的IP或机器码有误'];
						return $opconfig->jsonop($resdata,'en');
					}
				}								
			}elseif($acarddb['bind']==1){
				if($acarddb['bind_ip']==null){
					Db::name('acard')->where('acard_number', $acard)->where('appid', $appid)->update(['bind_ip' => $this->getip()]);
				}elseif($acarddb['bind_ip'] != $this->getip()){
					$resdata=['code'=>4500,'message'=>'error','content'=>'绑定的IP不正确'];
					return $opconfig->jsonop($resdata,'en');
				}
					
			}
			//end绑定检测
			if($resapp['free'] < 1){
				Db::name('acard')->where('acard_number', $acard)->where('appid', $appid)->update(['loginip'=>$this->getip(),'logintime'=>time(),'sales_status'=>2]);
				$audata=['expire_time'=>'no_expire','app_free'=>'0','days'=>'99999','fee_count'=>$acarddb['fee_count']];				
				$resdata=['data'=>$audata,'code'=>7,'message'=>'success','content'=>'验证成功'];
				return $opconfig->jsonop($resdata,'en');
            }
            $sdata=['acard_number'=>$acard,'appid'=>$appid];
			$acarddb=Db::name('acard')->where($sdata)->find();
			$activetime=date('Y-m-d H:i:s',$acarddb['active_time']);//激活时间
			$expiretime=date('Y-m-d H:i:s',$acarddb['expire_time']);//到期时间
			$day=$this->maktimes($expiretime);
			if($day==='expire'){
				$res=['expire_time'=>$expiretime,'app_free'=>'1','days'=>'0','fee_count'=>$acarddb['fee_count']];
		        $resdata=['data'=>$res,'code'=>4501,'message'=>'error','content'=>'授权已到期'];
				return $opconfig->jsonop($resdata,'en');	
			}else{
				Db::name('acard')->where('acard_number', $acard)->where('appid', $appid)->update(['loginip'=>$this->getip(),'logintime'=>time(),'sales_status'=>2]);
				$res=['expire_time'=>$expiretime,'app_free'=>'1','days'=>$day,'fee_count'=>$acarddb['fee_count']];
		        $resdata=['data'=>$res,'code'=>7,'message'=>'success','content'=>'验下成功'];
				return $opconfig->jsonop($resdata,'en');	
			}
            		

		}else{
			$resdata=['code'=>440,'message'=>'error','content'=>'基础参数错误'];
			return $opconfig->jsonop($resdata,'en');
		}
	}
    public function maktimes($time){//计算剩余天数
        $endtDateStr = strtotime($time);
        $now = strtotime(date('Y-m-d H:i:s'));
		if($endtDateStr <= $now){
			return 'expire';
		}else{
			$remain = $endtDateStr-$now;
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
