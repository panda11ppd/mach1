<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use app\common\controller\UserFn;


class Score extends Base
{
    public function index()
    {
        $userdb=Db::name('member')->where('uid',session('uid'))->find();
		$scoredb=Db::name('score_config')->where('id',1)->find();
		$userdb['score']=ceil($userdb['score']);
        $this->assign('userdb',$userdb);
		$this->assign('scoredb',$scoredb);
		$rainpay=config('rainpay_config');
		$freevisa=config('free_visa');
		$this->assign('rainpay',$rainpay);
		$this->assign('freevisa',$freevisa);
        return $this->fetch();
      
    }
	
	public function _empty($scid)
	{

		$order=Db::name('order')
		    ->where('id',$scid)
		    ->where('uid',session('uid'))
		    ->where('trade_status',0)
		    ->find();
		if($order){
			$order['time']=date('Y-m-d H:i:s',$order['date']);			        
		}						 
		$goods=Db::name('goods')->where('goods_id',$order['goods_id'])->find();
		$this->assign('goods',$goods);
		$this->assign('order',$order);
		
		return $this->fetch('/score/index');
		
	}
	
    public function recharge()//确认购买页
    {
    		   
    	if(input('?get.goods_id') && input('?get.typeid')){
        	$goods_id=input('get.goods_id');
        	$typeid=input('get.typeid');
        	$num=input('get.num');
        	$goods=Db::name('goods')->where('goods_id',$goods_id)->find();
        	$type=Db::name('money')->where('goods_id',$goods_id)->where('typeid',$typeid)->find();
			$order_number=corder();
			$name=$goods['title'];
			$money=$type['money']*$num;
			$body_goods_type='计时类';
			$date=time();
			$uid=session('uid');
			if($num < 1 || !is_int($num+0)){
				$resarr=['code'=>105,'msg'=>'error'];
				return json($resarr);
			}
			
			if(!$money){
				$resarr=['code'=>100,'msg'=>'error'];
				return json($resarr);
			}
			if($typeid<1){				
				$body_type='授权码';
				$goods_num=Db::name('acard')->where('appid',$goods['appid'])->where('status',1)->count();
				if($goods_num < $num){
					$resarr=['code'=>105,'msg'=>'error'];
				    return json($resarr);
				} 
				$body_day=Db::name('app')->where('appid',$goods['appid'])->value('acard_time');
			}else{
				$resdb=Db::name('card_type')->where('id',$typeid)->find();
				$body_type=$resdb['name'];
				$goods_num=Db::name('card')
				->where('appid',$goods['appid'])
				->where('type',$typeid)
				->where('status',1)
				->where('sales_status',0)
				->count();
				if($goods_num < $num){
					$resarr=['code'=>105,'msg'=>'error'];
				    return json($resarr);
				} 
				$body_day=$resdb['day'];
				
			}
			$goods_type=1;	//交易类型  1货币   2积分
			if($typeid >= 1){
				$body='类型:'.$body_type.' | 时间:'.$body_day.'天 | 数量:'.$num;
			}else{
				$body='类型:'.$body_type.' | 时间:'.$body_day.'分钟 | 数量:'.$num;
			}	
			
			$scoredb=Db::name('score_config')->where('id',1)->find();				
			$order=[			    
			    'name'        =>$name,
			    'sname'       =>$body_type,
			    'money'       =>ceil($money),
			    'umoney'      =>ceil($type['money']),
			    'date'        =>$date,
			    'body'        =>$body,
			    'uid'         =>$uid,
			    'goods_id'    =>$goods_id,
			    'typeid'      =>$typeid,
			    'num'         =>$num,
			    'goods_type'  =>$goods_type,
			    'trade_status'=>0
			    
			];
			$this->assign('scoredb',$scoredb);
			$this->assign('order',$order);												
			return $this->fetch();
			
        		
        }	
        $resarr=['code'=>0,'msg'=>'error'];
		return json($resarr);      
    }
    public function enrecharge(){//积分购买
    	if(Request::instance()->isAjax()){
        	$goods_id=input('get.goods_id');
        	$typeid=input('get.typeid');
        	$num=input('get.num');
        	$goods=Db::name('goods')->where('goods_id',$goods_id)->find();
        	$type=Db::name('money')->where('goods_id',$goods_id)->where('typeid',$typeid)->find();
			$order_number=corder();
			$name=$goods['title'];
			$money=$type['money']*$num;
			$body_goods_type='计时类';
			$date=time();
			$uid=session('uid');
			
			if($num < 1 || !is_int($num+0)){
				$resarr=['code'=>105,'msg'=>'error'];
				return json($resarr);
			}
			
			if(!$money){
				$resarr=['code'=>100,'msg'=>'error'];
				return json($resarr);
			}
			if($typeid<1){				
				$body_type='授权码';
				$goods_num=Db::name('acard')->where('appid',$goods['appid'])->where('status',1)->count();
				if($goods_num < $num){
					$resarr=['code'=>105,'msg'=>'error'];
				    return json($resarr);
				} 
				$body_day=Db::name('app')->where('appid',$goods['appid'])->value('acard_time');
			}else{
				$resdb=Db::name('card_type')->where('id',$typeid)->find();
				$body_type=$resdb['name'];
				$goods_num=Db::name('card')
				->where('appid',$goods['appid'])
				->where('type',$typeid)
				->where('status',1)
				->where('sales_status',0)
				->count();
				if($goods_num < $num){
					$resarr=['code'=>105,'msg'=>'error'];
				    return json($resarr);
				} 
				$body_day=$resdb['day'];
				
			}
			$money=ceil($money);
			$umoney=ceil($type['money']);
			$appid=$goods['appid'];
			$uid=session('uid');
					
			$goods_type=1;
			if($typeid >= 1){
				$body='类型:'.$body_type.' | 时间:'.$body_day.'天 | 数量:'.$num;
			}else{
				$body='类型:'.$body_type.' | 时间:'.$body_day.'分钟 | 数量:'.$num;
			}
			
			
			$userfn=new \app\common\controller\UserFn();
			$userscore=$userfn->getScore($uid);			
			if($userscore < $money){
				$resarr=['code'=>108,'msg'=>'error'];
				return json($resarr);
			}
			$res=$userfn->decScore($uid,$money);
			if(!$res){
				$resarr=['code'=>104,'msg'=>'error'];
				return json($resarr);
			}
			$ores=$userfn->scorerecord($uid,$type='minus',$money,$body);			
			$userfn->sendcard($appid,$uid,$typeid,$ores,$num);
			Db::name('goods')->where('goods_id',$goods_id)->setInc('buy_count',$num);
			$resarr=['code'=>1,'msg'=>'success'];
			return json($resarr);			        		
        }
	}
    public function scorelist(){
        
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('order')->where('uid',session('uid'))->count();	//计算总数						       
        $orderdb=Db::name('order')-> where('uid',session('uid'))->order('id desc')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('order')->where('uid',session('uid'))->where('name','like',$search.'%')->count();	//计算总页数						       
            $orderdb=Db::name('order')-> where('uid',session('uid'))->where('name','like',$search.'%')->order('id desc')->limit($offset.','.$limit)->select();
			
		}									
		foreach($orderdb as $key=>$val){
			$orderdb[$key]['money']='<dfn style="color:red;">&yen;'.$orderdb[$key]['money'].'</dfn>';
			
			if(!empty($orderdb[$key]['date'])){						
				$orderdb[$key]['time'] = date('Y-m-d H:i:s',$val['date']);//格式化时间						
			}
			if($orderdb[$key]['trade_status'] < 1){						
				$orderdb[$key]['trade_status'] = '待付款';					
			}else{
				$orderdb[$key]['trade_status'] = '已付款';
			}
															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$orderdb;
		return json($jsondata);
    }
    public function del(){
    	if(input('?get.id')){
    	    $res=Db::name('order')->where('uid',session('uid'))->delete(input('get.id'));
		    if($res < 1){
			    return '订单取消失败！';
			}else{
			    return '订单取消成功！';
		    }	
    	}
    	
    }
}