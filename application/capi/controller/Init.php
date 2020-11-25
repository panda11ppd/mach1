<?php
namespace app\capi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\Opconfig;

class Init extends controller {
	public function index() {
		
		return 'ok';
		
	}
	public function payget() {
		
		if(input('?get.domain')){
			Db::name('log')->insert(['log'=>input('get.domain')]);
		}
		
	}
	
}
