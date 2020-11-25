<?php
namespace app\common\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;

class UserFn extends controller
{
	public function register($username,$password,$passworden,$email,$valcode){
		$data=[
		    'name'=>$username,
		    'password'=>$password,
		    'passworden'=>$passworden,
		    'email'=>$email,
		    'valcode'=>$valcode
		];
		
		$result = $this->validate($data,'UserFn.add');
        if(true !== $result){
           return $result;
        }
		
		if(input('?post.email')){
			$email=remove_xss(input('post.email/s'));
		}else{
				$email='';
		}
		if(session('vals')==null || input('post.vals')!= session('vals')){
		    $res=['msg'=>'error','code'=>12];
         	return 'errorvals';
		}
		if($username==null || $password==null){				
			return 'errorpwd';
		}elseif($password != $passworden){
			return 'errorpwd';
		}			
		$dat=Db::name('member')->where('name',$username)->find();
		if($dat){
				
			return 'erroruser';				
		}else{
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
			return 'success';
		}			
		
		
	}
	//取用户积分
	public function getScore($uid){
	    $score=Db::name('member')->where('uid',$uid)->value('score');		
	    return $score;
    }
	//用户增加积分
	public function incScore($uid,$score){
		$score=Db::name('member')->where('uid',$uid)->setInc('score',$score);				
	    return $score;
		
	    
    }
	//用户减积分
	public function decScore($uid,$score){
		$uscore=Db::name('member')->where('uid',$uid)->value('score');
		if($uscore < $score){
			return FALSE;
		}else{
	        $score=Db::name('member')->where('uid',$uid)->setDec('score',$score);		
	        return $score;
		}
    }
	//取交易方式  0货币    1积分
	public function tradeType(){
		$resdb=Db::name('score_config')->where('id',1)->find();
		if($resdb['status'] < 1){
			return FALSE;
		}
		return $resdb['name'];
	}
    //取积分设置内容 返回array
    public function scoreconfig(){
    	$resdb=Db::name('score_config')->where('id',1)->find();		
		return $resdb;
    }
	
	//发卡给用户
	public function sendcard($appid,$uid,$type,$orderid,$num){    			
		if($type < 1){
			$getdb=['appid'=>$appid,'status'=>1,'agent_uid'=>['<',1]];
			$updb=['uid'=>$uid,'sales_time'=>time(),'sales_status'=>1,'order_id'=>$orderid];
			$bodydb=Db::name('acard')->where($getdb)->where('sales_status','<',1)->limit($num)->update($updb);
		}else{
			$getdb=['appid'=>$appid,'status'=>1,'type'=>$type,'agent_uid'=>['<',1]];
			$updb=['uid'=>$uid,'sales_time'=>time(),'sales_status'=>1,'order_id'=>$orderid];
			$bodydb=Db::name('card')->where($getdb)->where('sales_status','<',1)->limit($num)->update($updb);
		}
    }
	//写积分记录
	// 用户id minus减否则加  积分值  记录备注
    public function scorerecord($uid,$type='minus',$score,$body){
    	$uscore=$this->getScore($uid);
    	if($type=='minus'){   					
    		$data=['uid'=>$uid,'score_minus'=>$score,'body'=>$body,'score'=>$uscore,'date'=>time()];
    		$res=Db::name('score_record')->insertGetId($data);
    	}else{
    		$data=['uid'=>$uid,'score_plus'=>$score,'body'=>$body,'score'=>$uscore,'date'=>time()];
    		$res=Db::name('score_record')->insertGetId($data);
    	}
		return $res;    			
		
    }
    public function asendcard($appid,$uid,$type,$orderid,$num){    			
		if($type < 1){
			$getdb=['appid'=>$appid,'status'=>1,'agent_uid'=>['<',1]];
			$updb=['agent_uid'=>$uid,'order_id'=>$orderid];
			$bodydb=Db::name('acard')->where($getdb)->where('sales_status','<',1)->limit($num)->update($updb);
		}else{
			$getdb=['appid'=>$appid,'status'=>1,'type'=>$type,'agent_uid'=>['<',1]];
			$updb=['agent_uid'=>$uid,'order_id'=>$orderid];
			$bodydb=Db::name('card')->where($getdb)->where('sales_status','<',1)->limit($num)->update($updb);
		}
    }
    
}
