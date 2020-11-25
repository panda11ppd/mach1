<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;


class Goods extends Base
{
    public function index()
    {
    	 
    	if(input('?param.id') && input('param.id')){   		
    		$goods_id=input('param.id');
						
    		$goods=Db::name('goods')->where('status',1)->where('goods_id',$goods_id)->find();
			if(!$goods){
				return '商品不存在！';	
			}
			$app=Db::name('app')->where('appid',$goods['appid'])->find();			
    		$money=Db::name('money')->where('goods_id',$goods_id)->order('typeid asc')->select();
			
			if(!$money){
				$money==null;
			}else{
				$whe=['appid'=>$goods['appid'],'sales_status'=>0,'status'=>1,'agent_uid'=>['<',1]];					
				$acardcount=Db::name('acard')->where($whe)->count();
				
				foreach($money as $key => $val){
						$typeid=$money[$key]['typeid'];
					
					if($typeid<1){
						
						if($acardcount > 0){
							$money[$key]['count']=$acardcount;
						}else{
							$money[$key]['count']=0;
						}
						$money[$key]['time']=$app['acard_time'];
						$money[$key]['name']='授权码';					
					}else{
						$cardtype=Db::name('card_type')->where('id',$typeid)->find();
						$sldb=['appid'=>$goods['appid'],'type'=>$typeid,'status'=>1,'sales_status'=>0,'agent_uid'=>['<',1]];				
						$cardcount=Db::name('card')->where($sldb)->Count();
						$money[$key]['count']=$cardcount;
						$money[$key]['name']=$cardtype['name'];
						$money[$key]['time']=$cardtype['day'];
					}
					//$mons+=$money[$key]['money'];				
				}
												
			}
//			echo '<pre>';
//			print_r($money);
			if(!session('?'.$goods_id.'')){
				session($goods_id, 1);
				Db::name('goods')->where('goods_id', $goods_id)->setInc('count');
			}
			$userfn=new \app\common\controller\UserFn();
			$tradetype=$userfn->tradeType();
			if($tradetype){
				foreach($money as $k=>$v){
					$money[$k]['money']=ceil($money[$k]['money']);
				}
			}
			$this -> assign('app', $app);
			$this -> assign('money', $money);
			$this -> assign('goods', $goods);
			$this -> assign('tradetype', $tradetype);
			$this -> assign('titles', '-'.$goods['title']);
			$seo=[
		        'title'=>$goods['title'].'-'.config('netinfo.name'),
		        'keywords'=>$goods['stitle'],
		        'description'=>$app['app_name'],
		    ];	
		    $this -> assign('seo', $seo);
			return $this->fetch();
			
    	}else{
    		$goods=Db::name('goods')->where('status',1)->order('goods_id desc')->select();
    	    foreach ($goods as $key => $val) {
    		    $bg=rand(1,8);
    		    if($bg==1) $bgs='background-color:#384047';
    		    if($bg==2) $bgs='background-color:#0AAEEC';
    		    if($bg==3) $bgs='background-color:#FF5D51';
    		    if($bg==4) $bgs='background-color:#428AC9';
    		    if($bg==5) $bgs='background-color:##009900';
    		    if($bg==6) $bgs='background-color:#330000';
    		    if($bg==7) $bgs='background-color:#CC3300';
    		    if($bg==8) $bgs='background-color:#003366';
    		
    		    $goods[$key]['bgcode']=$bgs;
    		}		
    	    $this -> assign('goods', $goods);
			$seo=[
		        'title'=>'应用商店-'.config('netinfo.name'),
		        'keywords'=>'应用商店',
		        'description'=>'应用商店',
		    ];	
		    $this -> assign('seo', $seo);
            return $this->fetch('goods');
    	}
		   	
        
    }
    public function GoodsList()
    {   
    	
    }
}