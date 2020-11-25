<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class Comment extends Base {
	/**
    * @cc 评论设置
    *    
    */
	public function index() {
		if (Request::instance()->isAjax()){
		    $name=input('post.name');
			$status=input('post.status');			
			$file=APP_PATH.'extra/comment.php';
			update_config($file, 'status', $status,$type='int');
			
			update_config($file, 'name', $name);
			
			return '更新成功！';
		}
		$comment=config('comment');

		$this->assign('comment',$comment);
		return $this->fetch();
	}
	
   
}	