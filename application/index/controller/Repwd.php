<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;


class Repwd extends Base
{
    public function index()
    {   	
        return $this->fetch();
    }
    public function edit(){
    	if(session('?username') && input('?post.password') && input('?post.passwordnew')){

			$password=input('post.password');
			$passwordnew=input('post.passwordnew');
			$passworden=input('post.passworden');
  			$suid=session('uid');
    		if($passwordnew!=$passworden){
    			$res=['code'=>11,'msg'=>'error'];
    			return json($res);
    		}
    		$username=Db::name('member')->where('uid',$suid)->value('name');
    		if(!$username){
    			$res=['code'=>12,'msg'=>'error'];
    			return json($res);
    		}
    		$pwd=Db::name('member')->where('uid',$suid)->where('password',md5($password))->value('name');
    		if(!$pwd){
    			$res=['code'=>13,'msg'=>'error'];
    			return json($res);
    		}
    		
		    $username=Db::name('member')->where('uid',$suid)->setField('password',md5($passwordnew));
            
			$res=['code'=>1,'msg'=>'success'];
    		return json($res);
			
    	}
    	$res=['code'=>0,'msg'=>'error'];
    	return json($res);
    }
}