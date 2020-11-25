<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class GetApp extends controller {
	public function index() {
		$opconfig=new Opconfig();
    	if(input('?get.data') && input('get.data')){
    	    $getdata=input('get.data');
			$json_arr=$opconfig->jsonop($getdata,'de');	
			if($json_arr=='error'){
				$resdata = ['code'=>444,'message'=>'error','content'=>'提交数据有误'];				
	    		return $opconfig->jsonop($resdata,'en');
			}
            $appkey=$json_arr['app_key'];					
			$appid=$json_arr['appid'];
			if($appkey==null || $appid==null){
				$resdata=['code'=>421,'message'=>'error','content'=>'应用key或应用ID不能为空'];
				return $opconfig->jsonop($resdata,'en');				
			}
			$appdata=['appid'=>$appid,'app_key'=>$appkey];
			$resapp=Db::name('app')->where($appdata)->find($appid);			
			if(!$resapp){
				$resdata=['code'=>422,'message'=>'error','content'=>'应用不存在，或提交内容不正确'];
				return $opconfig->jsonop($resdata,'en');
			}elseif($resapp['app_status'] < 1){
				$resdata=['code'=>423,'message'=>'error','content'=>'应用已停用'];			
				return $opconfig->jsonop($resdata,'en');
			}else{
				$res=[
				    'app_name'    =>$resapp['app_name'],//应用名				   
				    'free'        =>$resapp['free'],//是否收费
				    'app_data'    =>$resapp['app_data'],//应用自定议数据
				    'announcement'=>$resapp['announcement'],//应用公告
				    'version'     =>$resapp['version'],//应用版本号
				    'down_url'    =>$resapp['down_url']//应用下载链接
				];
				$resdata=['data'=>$res,'code'=>3,'message'=>'success','content'=>'取应用信息成功'];
				return $opconfig->jsonop($resdata,'en');
		    }   
		}else{
			$resdata=['code'=>420,'message'=>'error','content'=>'基础参数错误'];
		    return $opconfig->jsonop($resdata,'en');
		}   
	}	
}
