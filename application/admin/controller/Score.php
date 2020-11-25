<?php
namespace app\admin\controller;
use think\Db;
use org;
use think\Request;

class Score extends Base {
	/**
    * @cc 积分设置
    *    
    */
	public function index() {
		if (Request::instance()->isPOST()){			
			$status=input('post.status');
			$name=input('post.name');
			$comments=input('post.comments');			
			$min_full=input('post.min_full/d');
			$exchange=input('post.exchange/d');			
			$newuser_score=input('post.newuser_score/d');
			if(!$name) return '失败，积分名不能为空！';
			if($min_full < 1) return '失败，最少充值不能小于1';
			if($exchange < 1) return '失败，积分比例值不能小于1';
			if($newuser_score < 0) return '失败，积分比例值不能小于0';
			$update=[
			    'status'=>$status,
			    'name'=>$name,
			    'comments'=>$comments,
			    'min_full'=>$min_full,
			    'exchange'=>$exchange,
			    'newuser_score'=>$newuser_score,
			];
			Db::name('score_config')->where('id',1)->update($update);
			return '保存成功！';
			
        }else{
            $resscore=Db::name('score_config')->where('id',1)->find();
		    $this->assign('resscore',$resscore);
		    return $this -> fetch();	
        }
		


	}
	

}
