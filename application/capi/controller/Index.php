<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class index extends controller {
	public function index() {
		$opconfig=new Opconfig();
		if(input('?get.de')){
			$data=input('get.de');
			$resdat=$opconfig->jsonop($data,'de');
			return var_dump($resdat);
		}
		if(input('?get.en')){
			$data=input('get.en');
			return $opconfig->jsonop($data,'en');
		}
		if(input('?get.des')){
			$data=input('get.des');
			$datas=base64_decode($data);
			return authcode($datas,'DECODE','rain');
		}
		if(input('?get.ens')){
			$data=input('get.ens');			
			return base64_encode(authcode($data,'ENCODE','rain'));
		}						          
		
		//return $res;
		
	}
	
}
