<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;


class UserAcard extends Base
{
    public function index()
    {   	
        return $this->fetch();
    }

    public function acardlist(){
        
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('acard')->where('uid',session('uid'))->count();	//计算总数						       
        $acarddb=Db::name('acard')-> where('uid',session('uid'))->order('sales_time desc')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('acard')->where('uid',session('uid'))->where('name','like',$search.'%')->count();	//计算总页数						       
            $acarddb=Db::name('acard')-> where('uid',session('uid'))->where('name','like',$search.'%')->order('sales_time desc')->limit($offset.','.$limit)->select();
			
		}									
		foreach($acarddb as $key=>$val){
			$namedb=Db::name('goods')->where('appid',$val['appid'])->value('title');
			$acard_time=Db::name('app')->where('appid',$val['appid'])->value('acard_time');
			$acarddb[$key]['acard_time']=$acard_time;
			if($acarddb[$key]['sales_status']<=1) $acarddb[$key]['astatus']='未用';
			if($acarddb[$key]['sales_status']==2) $acarddb[$key]['astatus']='已用';
			if($acarddb[$key]['status'] < 1) $acarddb[$key]['astatus']='停用';
			if($acarddb[$key]['expire_time'] < time() && $acarddb[$key]['expire_time']) $acarddb[$key]['astatus']='过期';
			if($namedb){
				$acarddb[$key]['name']=$namedb;
			}				
			if(!empty($acarddb[$key]['sales_time'])){						
				$acarddb[$key]['sales_time'] = date('Y-m-d H:i:s',$val['sales_time']);//格式化时间						
			}
			if(!empty($acarddb[$key]['expire_time'])){						
				$acarddb[$key]['expire_time'] = date('Y-m-d H:i:s',$val['expire_time']);//格式化时间						
			}
			
															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$acarddb;
		return json($jsondata);
    }
    
}