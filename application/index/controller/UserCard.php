<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;

class UserCard extends Base
{
    public function index()
    {   	
        return $this->fetch();
    }

    public function cardlist(){
        
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('card')->where('uid',session('uid'))->count();	//计算总数						       
        $carddb=Db::name('card')-> where('uid',session('uid'))->order('sales_time desc')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('card')->where('uid',session('uid'))->where('name','like',$search.'%')->count();	//计算总页数						       
            $carddb=Db::name('card')-> where('uid',session('uid'))->where('name','like',$search.'%')->order('sales_time desc')->limit($offset.','.$limit)->select();
			
		}									
		foreach($carddb as $key=>$val){
			$namedb=Db::name('goods')->where('appid',$val['appid'])->value('title');
			$card_db=Db::name('card_type')->where('id',$val['type'])->find();
			$carddb[$key]['day']=$card_db['day'];
			$carddb[$key]['type']=$card_db['name'];
			if($carddb[$key]['sales_status']==1) $carddb[$key]['cstatus']='未用';
			if($carddb[$key]['sales_status']==2) $carddb[$key]['cstatus']='已用';
			if($carddb[$key]['status'] < 1) $carddb[$key]['cstatus']='停用';
			if($namedb){
				$carddb[$key]['name']=$namedb;
			}				
			if(!empty($carddb[$key]['sales_time'])){						
				$carddb[$key]['sales_time'] = date('Y-m-d H:i:s',$val['sales_time']);//格式化时间						
			}
			
			
															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$carddb;
		return json($jsondata);
	}
}