<?php
namespace app\common\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
class Payfn extends controller {
	public function _initialize() {
        
	}
    
	
    public function orderstatus($out_trade_no,$trade_no,$total_fee){//修改订单状态
    	$free=Db::name('order')->where('id',$out_trade_no)->value('money');
		if($free==$total_fee){
			$update=['trade_no'=>$trade_no,'trade_status'=>1,];
			Db::name('order')->where('id',$out_trade_no)->update($update);
			return 'success';
		}else{
			return 'error';
		}
		
    }
    
    public function sendgoods($out_trade_no){//取订单发商品或积分
    
    	$orderdb=Db::name('order')->where('id',$out_trade_no)->find();       
		if($orderdb['typeid'] == -1 && $orderdb['goods_id'] == -1 && $orderdb['goods_type'] == 2){//加积分                  
			$exchange=Db::name('score_config')->where('id',1)->value('exchange');
			$scorepull=ceil($orderdb['money']*$exchange)	;					
			Db::name('member')->where('uid',$orderdb['uid'])->setInc('score', $scorepull);
			$this->scorerecord($orderdb['uid'],'pull',$orderdb['uid'],$orderdb['body']);		
		}else{
			$appid=Db::name('goods')->where('goods_id',$orderdb['goods_id'])->value('appid');		
		    if($orderdb['typeid'] < 1){
			    $getdb=['appid'=>$appid,'status'=>1];
			    $updb=['uid'=>$orderdb['uid'],'sales_time'=>time(),'sales_status'=>1,'order_id'=>$out_trade_no];
			    $bodydb=Db::name('acard')->where($getdb)->where('sales_status','<',1)->limit($orderdb['num'])->update($updb);
		    }else{
			    $getdb=['appid'=>$appid,'status'=>1,'type'=>$orderdb['typeid']];
			    $updb=['uid'=>$orderdb['uid'],'sales_time'=>time(),'sales_status'=>1,'order_id'=>$out_trade_no];
			    $bodydb=Db::name('card')->where($getdb)->where('sales_status','<',1)->limit($orderdb['num'])->update($updb);
		    }
		}				
    }
    //写积分记录
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
	//取用户积分
	public function getScore($uid){
	    $score=Db::name('member')->where('uid',$uid)->value('score');		
	    return $score;
    }

}
