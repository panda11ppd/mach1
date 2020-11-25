<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use org;

class Register extends Base
{
    public function index()
    {
    	
		
        if(request()->isAjax()){
    	    $username=remove_xss(input('post.username/s'));			
			$password=input('post.password/s');
			$passworden=input('post.passworden/s');
			if(input('?post.email')){
				$email=remove_xss(input('post.email/s'));
			}else{
				$email='';
			}
			if(session('vals')==null || input('post.vals')!= session('vals')){
			    $res=['message'=>'error','code'=>40001,'content'=>'验证不通过'];
            	return json($res);
			}
			if($username==null || $password==null){
				$res=['message'=>'error','code'=>40002,'content'=>'用户名或密码不能为空'];				
				return json($res);
			}elseif($password != $passworden){
				$res=['message'=>'error','code'=>40003,'content'=>'确认密码不相同'];				
				return json($res);
			}			
			$dat=Db::name('member')->where('name',$username)->find();
			if($dat){
				$res=['message'=>'error','code'=>40004,'content'=>'用户已存在'];				
				return json($res);			
			}else{
				$ipsafe = new \org\Ipsafe();
	            $safes=$ipsafe->safes(config('access_control.register_time'),config('access_control.register_num'),config('access_control.register_black_count'));
		        if($safes){
			        $res=['message'=>'error','code'=>40005,'content'=>'禁止重复申请'];				
				    return json($res);
		        }
				$createtime=time();
				$userfn=new \app\common\controller\UserFn();
				$scorecon=$userfn->scoreconfig();				
				$update=[
				    'name' => $username,
				    'email' => $email,
				    'password' => md5($password),
				    'status' => 1,
				    'createtime' => $createtime,
				    'score'=>ceil($scorecon['newuser_score'])
				];
				Db::name('member')->insert($update);
				$uid=Db::getLastInsID();
				Db::name('auth_group_access')->insert(['uid' => $uid, 'group_id' => 3]);
				
				$res=['message'=>'success','code'=>10008,'content'=>'申请成功'];				
				return json($res);
			}			
    	}
        return $this->fetch();
    }
	/**
     * tp5邮件
     * @param
     * @author staitc7 <static7@qq.com>
     * @return mixed
     */
//  public function email() {
//      $toemail='static7@qq.com';
//      $name='static7';
//      $subject='QQ邮件发送测试';
//      $content='恭喜你，邮件测试成功。';
//      dump(send_mail($toemail,$name,$subject,$content));
//  }
}