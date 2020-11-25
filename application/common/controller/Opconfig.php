<?php
namespace app\common\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
class Opconfig extends controller {
	public function _initialize() {
        
	}

	public function instoken($username,$uid) {//令牌生成与更新
		$countdata=Db::name('api_token')->where('uid',$uid)->value('op_time');					
		if($countdata==FALSE){//如果不存在，生成
		    $reskey=TRUE;
		    while($reskey){
		    	$token = $this->request->token($username, $uid);//生成令牌 
		    	$res=Db::name('api_token')->where('token',$token)->value('uid');
				if($res==FALSE){
					$reskey=FALSE;
				}
		    }		    
		    $countins=['uid'=>$uid,'token'=>$token,'op_time'=>time()];												
		    Db::name('api_token')->insert($countins);
		    return $token;
		}else{
			$contime=time()-$countdata;
			if($contime > 7200){//令牌过期，过期时间7200秒
			    $reskey=TRUE;
				while($reskey){
		    	    $token = $this->request->token($username, $uid);//生成令牌 
		    	    $res=Db::name('api_token')->where('token',$token)->value('uid');
				    if($res==FALSE){
					    $reskey=FALSE;
					}
				}
				$update=['token'=>$token,'op_time'=>time()];
				Db::name('api_token')->where('uid',$uid)->update($update);
				return $token;
			}else{
				$token=Db::name('api_token')->where('uid',$uid)->value('token');					
		        Db::name('api_token')->where('uid',$uid)->where('token',$token)->setField('op_time', time());	
				return $token;
			}		    
		}
		
	}
	public function uptoken($uid,$token){//刷新令牌时间
		$countdata=Db::name('api_token')->where('uid',$uid)->where('token',$token)->value('op_time');
		$contime=time()-$countdata;
		if(!$countdata){
			return 'token_non';
		}
		if($contime > 7200){
			return 'token_expire';
		}else{
			Db::name('api_token')->where('uid',$uid)->where('token',$token)->setField('op_time', time());
			
		}
				
	}
    public function jsonop($string,$op){
    	$key=config('netinfo.key');
		if($op=='de'){//解密
		    $data=base64_decode($string);
			$dedata=authcode($data,'DECODE',$key);
					
			$json_str = str_replace('\\', '', $dedata);
			$out_arr = array();
			preg_match('/{.*}/', $json_str, $out_arr);
			if (!empty($out_arr)) {
                $result = json_decode($out_arr[0], TRUE);
				return $result;
            }else{
				return 'error';
			}			
			
		}elseif($op=='en'){//加密
			$jsondata=json_encode($string);
			$data=authcode($jsondata,'ENCODE',$key);           		
			return base64_encode($data);;	
		}else{
			return 'error';
			
		}
		
    	
    }

}
