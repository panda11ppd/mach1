<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class Mail extends Base {
	/**
    * @cc 邮件设置
    *    
    */
	public function index() {
		if (Request::instance()->isAjax()){
		    $host=input('post.host');
			$port=input('post.port/d');
			$username=input('post.username');
			$password=input('post.password');
			$replyemali=input('post.replyemali');
			$replyuser=input('post.replyuser');			
			$file=APP_PATH.'extra/emailcon.php';
			update_config($file, 'host', $host);
			update_config($file, 'port', $port,$type='int');			
			update_config($file, 'username', $username);
			update_config($file, 'password', $password);
			update_config($file, 'replyemali', $replyemali);
			update_config($file, 'replyuser', $replyuser);
			
			return '更新成功！';
		}
		$mail=config('emailcon');

		$this->assign('mail',$mail);
		return $this->fetch();
	}
	public function testmail(){
		
		$status = send_mail ($to,$username,$title,$content );
		
	}
   
}	