<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Order extends Base {
	/**
    * @cc 支付订单管理
    *    
    */
	public function index() {
		
        return $this -> fetch();		
		
	}
	/**
    * @cc 支付订单列表
    *    
    */
	public function lists(){
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('order')->count();	//计算总数						       
        $orderdb=Db::name('order')->order('id desc')->page($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('order')->where('user','like',$search.'%')->count();	//计算总页数						       
            $orderdb=Db::name('order')->where('user','like',$search.'%')->order('id desc')->page($offset.','.$limit)->select();
			
		}									
		foreach($orderdb as $key=>$val){
			$orderdb[$key]['money']='<span style="color:red">'.$orderdb[$key]['money'].'</span>';			
            $trade_status=$orderdb[$key]['trade_status'];
			$user=Db::name('member')->where('uid',$orderdb[$key]['uid'])->value('name');
			$orderdb[$key]['user']=$user;
            if($trade_status < 1){
				$orderdb[$key]['trade_status']='<span style="color:#009900">未完成</span>';
			}else{
				$orderdb[$key]['trade_status']='<span style="color:red">交易成功</span>';
			}           			
			if($orderdb[$key]['date'] > 0){						
				$orderdb[$key]['date'] = date('Y-m-d H:i:s',$orderdb[$key]['date']);//格式化时间						
			}																	
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$orderdb;
		return json($jsondata);
	}
    /**
    * @cc 删除订单
    *    
    */
	public function set(){
    	if(input('?get.id')){
			if(input('get.orderset')=='del'){
               	Db::name('order')-> where('id',input('get.id'))-> delete();
				return '删除成功';
            }			
			
		}
    }
}
