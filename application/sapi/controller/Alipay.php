<?php
namespace app\sapi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\UserFn;

class Alipay extends controller {
	
	public function index (){
			//error_reporting(0);
        $key = config('netinfo.key');//通信秘钥，跟easyPay.exe上填写的接口秘钥保持一致      
        $sig = input('post.sig');//签名
        $tradeNo = input('post.tradeNo');//交易号
        $desc = input('post.desc');//交易名称（付款说明）
        $time = input('post.time');//付款时间
        $username = input('post.username');//客户名称
        $userid = input('post.userid');//客户id
        $amount = input('post.amount');//交易额
        $status = input('post.status');//交易状态
        if($status != '交易成功'){
        	return '交易未完成';
        }
        if($desc=="转账" or $desc=="消费" or $desc=="admin" or $desc=="收到群红包" or $desc=="收款"){
            return "拒绝提交";
           
        }


        //验证签名
        if(strtoupper(md5("$tradeNo|$desc|$time|$username|$amount|$status|$key")) == $sig){

	         //这里做订单业务，在下面写您的代码即可
	         /*
	         * 下面做业务处理，例如充值、开通订单等
	        * 务必注意：必须做重复交易号检测，防止重复充值、开通业务            
	          */
	        
	        $userfn=new UserFn();
			$scorecon=$userfn->scoreconfig();
			$incscore=$amount*$scorecon['exchange'];
			$score=floor($incscore);
			$inscore=$userfn->incScore($desc,$score);
			if($inscore){
				$userfn->scorerecord($desc,'plus',$score,'Visa:'.$tradeNo);
				return "ok";
			}else{
				return 'uid_error';
			}
			
	        //↓↓↓↓↓↓↓在这里写业务代码↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
            //↑↑↑↑↑↑↑业务代码结束    ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

	        
        }else{
        	return "签名错误";
        }	    
	}

}