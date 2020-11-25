<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\UserFn;


class Order extends Base
{
    public function index()
    {       
        return $this->fetch();
    			        
    }
	
	public function _empty($oid)
	{

		$order=Db::name('order')
		    ->where('id',$oid)
		    ->where('uid',session('uid'))
		    ->where('trade_status',0)
		    ->find();
		if($order){
			$order['time']=date('Y-m-d H:i:s',$order['date']);			        
		}						 
		$goods=Db::name('goods')->where('goods_id',$order['goods_id'])->find();
		$this->assign('goods',$goods);
		$this->assign('order',$order);
		
		return $this->fetch('/pay/index');
		
	}
	
    public function create()//生成订单
    {
		if(input('?get.fileid') && input('get.fileid')){
			return hook('down_fee', ['pos'=>'filepay','fileid'=>input('get.fileid')]);			
		}	    	
		
				
    	if(input('?get.scoremoney') && input('get.scoremoney')){//充值积分
    		$money=input('get.scoremoney/d');
			$scoredb=Db::name('score_config')->where('id',1)->find();
			if($money < 1){//输入的金额有误！
				$resarr=['code'=>201,'msg'=>'error'];
				return json($resarr);
			}elseif($money < $scoredb['min_full']){//最少充值金额 min_full
				$resarr=['code'=>202,'msg'=>'error','body'=>$scoredb['min_full']];
				return json($resarr);
			}else{
				$scores=$money*$scoredb['exchange'];
				$names=$scoredb['name'];
				$indata=[			    
			    'name'        =>$scoredb['name'],
			    'sname'       =>$scoredb['comments'],
			    'money'       =>$money,
			    'umoney'      =>$money,
			    'date'        =>time(),
			    'body'        =>$scoredb['name'].':'.$scores,
			    'uid'         =>session('uid'),
			    'goods_id'    =>-1,
			    'typeid'      =>-1,
			    'num'         =>1,
			    'goods_type'  =>2,
			    'trade_status'=>0,
			    ];
				$orderid=Db::name('order')->insertGetId($indata);
			    if($orderid){
				    $tourl=URL('/index/order/'.$orderid);
				    $resarr=['code'=>1,'msg'=>'success','order'=>$tourl];
				    return json($resarr);
			    }else{
				    $resarr=['code'=>101,'msg'=>'error'];
				    return json($resarr);
			    }
			}		
    	}
		       	   	
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
			$body='类型:'.$body_type.' | 天数:'.$body_day.'天 | 数量:'.$num;	
			$trade_type=Db::name('score_config')->where('id',1)->value('status');
			if($trade_type){
				$userfn=new UserFn();
				$score=$userfn->getscore(Session::get('uid'));
				if($score < $money){
					$tourl=URL('/index/score/index');
					$resarr=['code'=>188,'msg'=>'error','recharge'=>$tourl];
				    return json($resarr);					 
				}else{
					$tourl=URL('/index/score/recharge');
					$resarr=['code'=>118,'msg'=>'score','tourl'=>$tourl,'data'=>input('get.')];
					return json($resarr);
				}
			}

			
			$indata=[			    
			    'name'        =>$name,
			    'sname'       =>$body_type,
			    'money'       =>$money,
			    'umoney'      =>$type['money'],
			    'date'        =>$date,
			    'body'        =>$body,
			    'uid'         =>$uid,
			    'goods_id'    =>$goods_id,
			    'typeid'      =>$typeid,
			    'num'         =>$num,
			    'goods_type'  =>$goods_type,
			    'trade_status'=>0
			    
			];						
			$orderid=Db::name('order')->insertGetId($indata);
			if($orderid){
				$tourl=URL('/index/order/'.$orderid);
				$resarr=['code'=>1,'msg'=>'success','order'=>$tourl];
				return json($resarr);
			}else{
				$resarr=['code'=>101,'msg'=>'error'];
				return json($resarr);
			}
        		
        }	
        $resarr=['code'=>0,'msg'=>'error'];
		return json($resarr);      
    }
    public function orderlist(){
        
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