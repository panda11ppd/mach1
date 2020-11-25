<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\View;
use app\common\controller\Payfn;

class Sendm extends Base {
	//测试用的，二B说是后门，我特意留着，让会PHP的人来了解！不会的不要再胡说，林子大什么鸟都有，你这种叫无知鸟！
	//还有，邮箱配置的才是发件人的功能，不配置发个毛邮件！
	//防自已的邮箱被乱试乱发，会被禁的
	public function index(){
		$res=send_mail('xxxxx@qq.com','raiaaan','tesfdsafdsatss','xxxxx');
		
	}

}
