<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;


class Login extends Base {
    public function index()
    {
    	
        return $this->fetch();
    }
    
    //退出登录
    public function quit(){
        $request = Request::instance();
		session(null);
    	return $this->fetch();
    }
    
    public function login() {
		$request = Request::instance();

		if(input('?post.username')){			
		    $name = input('post.username/s');
		    $password = md5(input('post.password/s'));
		    $uid=Db::name('member')->where('name',$name)->where('password',$password)->value('uid');
			$status=Db::name('member')->where('uid',$uid)->value('status');
			if(session('vals')==null || input('post.vals')!= session('vals')){
			    $res=['msg'=>'error','code'=>12];
            	return json($res);
			}
            if($uid == null){
            	$res=['msg'=>'error','code'=>10];
            	return json($res);
            }
			
            if($status == 0){
        	    $res=['msg'=>'error','code'=>11];
            	return json($res);	    		    
		    }else{//登录成功设置session		        		
		    	Session::set('username',$name); //用户名写入session 
				Session::set('password',$password);	//密码写入session
				Session::set('uid',$uid);		//用户id写入session
				Session::set('status',$status);									
				$data['logintime'] = time();//取登录时间
				$data['lastlogintime']=Db::name('member')->where('uid',$uid)->value('logintime');//取上次登录时间
                $data['loginip'] = $_SERVER["REMOTE_ADDR"];//登录IP
				$data['lastloginip']=Db::name('member')->where('uid',$uid)->value('loginip');//上次登录IP
				Db::name('member')->where('uid',$uid)->update($data);//登录更新数据库
                Db::name('member')->where('uid', $uid)->setInc('logincount');//等录次数加1
                if($uid != '1'){
                	$res=['msg'=>'success','code'=>2];
                	return json($res);               
                }
				
			    $res=['msg'=>'success','code'=>1];
                	return json($res);
		    }
		}else{
			$res=['msg'=>'error','code'=>0];
            	return json($res);	
		}		
	}
    public function vals(){
    	if (Request::instance()->isAjax()){
    		$token = $this->request->token('__token__', 'sha1');
			session('vals', $token);		
		    return $token;
    	}
    	
    }	
}