<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;

class Record extends Base
{
    public function index()
    {   	
        return $this->fetch();
    }

    public function recordlist(){
        
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('score_record')->where('uid',session('uid'))->count();	//计算总数						       
        $carddb=Db::name('score_record')-> where('uid',session('uid'))->order('date desc')->limit($offset.','.$limit)->select();
//		if(input('?get.search')){
//			$search=input('get.search');			
//			$total=Db::name('score_record')->where('uid',session('uid'))->where('name','like',$search.'%')->count();	//计算总页数						       
//          $carddb=Db::name('score_record')-> where('uid',session('uid'))->where('name','like',$search.'%')->order('date desc')->limit($offset.','.$limit)->select();
//			
//		}									
		
		foreach($carddb as $key=>$val){
			$carddb[$key]['date']=time2date($carddb[$key]['date']);
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$carddb;
		return json($jsondata);
	}
}