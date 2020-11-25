<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use org;

class Respassword extends Base
{
    public function index()
    {
      	   	
        return $this->fetch();
    }
    public function sentemail($toemail,$name,$subject,$content){
    	send_mail($toemail,$name,$subject,$content);
    }
	public function findpwd() {
		if(Request::instance()->isPost()){
        	$map ['email'] =input('post.user_email');
			$info=Db::name('member')->where('email',$map ['email'])->find();
			if ($info) {
				$ipsafe = new \org\Ipsafe();
	            $safes=$ipsafe->safes(config('access_control.email_repwb_time'),config('access_control.email_repwb_num'),config('access_control.email_repwb_black_count'));
		        if($safes){
			        $res=['message'=>'error','code'=>40004,'content'=>'禁止重复提交'];				
				    return json($res);
		        }
			    $key = md5 ( $info ['name'] . '+' . $info ['password'] ); // MD5不可逆，验证$string中username，防止URL更改username
			    $string = base64_encode ( $info ['name'] . '+' . $key ); // 加密，可解密
			    $time = time ();
			    $code=md5 ( 'mytime'.$time );
				// 生成URL			
			    $findpwd = URL('index/respassword/editpwd','','',true) . '?key=' . $key . '&info=' . $string . '&time='.$time.'&code=' .$code; // code是用来检验time是否有修改过
			    $username = $info ['name'];
			    $title="找回密码";
			
			    $content="<h3>亲爱的：$username 用户</h3>
			    <br><br>
			    <br><br>$findpwd 
			    <br><br><br><h4>有效期30分钟</h4>
			    <br><br>";			
			    $from=config('emailcon.replyemali'); //修改为你的发送邮箱
			    $to=$info ['email'];			
			    $status = send_mail ($to,$username,$title,$content );
			    if($status==1){
			    	$res=['code'=>40001,'message'=>'success','content'=>'密码重置邮件发送成功'];
				    return json($res);
			    }else{
				    $res=['code'=>40002,'message'=>'error','content'=>'邮件发送失败，请联系管理员'];
				    return json($res);
				    
			    }
			} else {
			    $res=['code'=>40003,'message'=>'error','content'=>'邮件发送失败，邮箱不正确'];
				return json($res);

		    }
			
        }
		
	}
	public function editpwd() {
		session('key',input('get.key'));
		session('info',input('get.info'));
		session('code',input('get.code'));
		session('time',input('get.time'));					
		return $this->fetch ();
	}
	public function doeditpwd() {
		$str = base64_decode (session('info'));
		$arr = explode ( '+', $str );
		$user ['name'] = $arr [0];
		$reinfo = Db::name ( 'member' )->where ($user)->find ();
		
		// 判断是否在有效期，这里用时间戳判断，还可以用SESSION有效期判断,这里设置为30分钟
		$retime = time ();
		if ((session('code') == md5 ( 'mytime' . session('time'))) && (((session('time')) + (60 * 30)) >= $retime)) {
			
			if (md5 ( $reinfo ['name'] . '+' . $reinfo ['password'] ) == session('key')) { // 判断URL传输中username是否更改
				
				$upid ['id'] = $reinfo ['uid'];
				
				
				if (input('post.password') == input('post.passworden') && input('post.password') != '') {
					
					$data = ['password'=>md5 ( trim ( $_POST ['password'] ))];
					$edit = Db::name ( 'member' )->where ('uid',$upid ['id'])->update ($data);
					if ($edit) {
						
						session(null);
						$res=['code'=>1,'msg'=>'success'];
				        return json($res);
					} else {
						$res=['code'=>2,'msg'=>'error'];
				        return json($res);
					}
				} else {
					$res=['code'=>3,'msg'=>'error'];
				    return json($res);
				}
			} else {
				$res=['code'=>5,'msg'=>'error'];
				return json($res);
			}
		} else {
			
			// session_destroy();
			$res=['code'=>5,'msg'=>'error'];
			return json($res);
		}
		
	}
}
