<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Card extends Base {
	/**
     * @cc 充值卡管理
     *    
     */
	public function index() {
		$appdb=Db::name('app')->where('app_status',1)->select();
		$cardtypedb=Db::name('card_type')->where('status',1)->select();
		$this->assign('appdb',$appdb);
		$this->assign('cardtypedb',$cardtypedb);
		return $this -> fetch();
	}
    /**
     * @cc 生成充值卡
     *    
     */
    public function add(){
    	if(input('?get.set') && input('get.set')=='create'){
    		$appid=input('get.appid');
			$number=input('get.number');
			if($number > 100 || $number < 1) return '一次生成不能超过100或小于1';
			$type=input('get.type');						
			$res=makecard(18,$number,$appid,$type);
    		$resdb=Db::name('card')->insertAll($res);
			if($resdb){
			    return '添加成功！';	
			}else{
				return '添加失败！';	
			}
			 
    	}
    	$resapp=Db::name('app')->where('app_status',1)->select();
    	$restype=Db::name('card_type')->where('status',1)->select();
		$this -> assign('resapp', $resapp);
		$this -> assign('restype', $restype);			
    	return $this -> fetch();
    }
    /**
     * @cc 启停删充值卡
     *    
     */
	public function set(){
		if(input('?post.cardset')){
			if(input('post.cardset')=='stop'){				
			    Db::name('card')->where('id', input('post.id'))->update(['status' => '0']);													
                return '已停用！';	
			}elseif(input('post.cardset')=='start'){				
			    Db::name('card')->where('id', input('post.id'))->update(['status' => '1']);													
	            return '已启用！';	
			}elseif(input('post.cardset')=='del'){				
			    Db::name('card')->where('id', input('post.id'))->delete();													
	            return '删除成功！';	
			}elseif(input('post.cardset')=='dellist'){
			    $arrcard=input('post.data/a');
			    $cards=array();
			    foreach($arrcard as $k=>$v){
				    $cards[]=$arrcard[$k]['id'];
			    }
			    Db::name('card')->delete($cards);
			    return '删除成功！';
		    }																
		}
	}
    /**
     * @cc 充值卡列表
     *    
     */	
	public function cardlist(){
		
		$limit=input('get.limit');
		$offset=input('get.offset');
		if(input('?get.appid') && input('?get.status') && input('?get.sales_status') && input('?get.typeid')){
			$where=['appid'=>input('get.appid'),'status'=>input('get.status'),'sales_status'=>input('get.sales_status'),'type'=>input('get.typeid')];
			$total=Db::name('card')->where($where)->count();	//计算总数								       
            $carddb=Db::name('card')->where($where)->page($offset.','.$limit)->select();
		    if(input('?get.search')){
			    $search=input('get.search');			
			    $total=Db::name('card')->where($where)->where('card_number','like',$search.'%')->count();	//计算总页数						       
                $carddb=Db::name('card')->where($where)->where('card_number','like',$search.'%')->page($offset.','.$limit)->select();			
		    }
		}else{
			$total=Db::name('card')->count();	//计算总数						       
            $carddb=Db::name('card')->page($offset.','.$limit)->select();
		    if(input('?get.search')){
			    $search=input('get.search');			
			    $total=Db::name('card')->where('card_number','like',$search.'%')->count();	//计算总页数						       
                $carddb=Db::name('card')->where('card_number','like',$search.'%')->page($offset.','.$limit)->select();			
		    }
		}			
											
		foreach($carddb as $key=>$val){
			$cardid=$carddb[$key]['id'];
			$carddb[$key]['type']=Db::name('card_type')->where('id',$carddb[$key]['type'])->value('name');			
			$user=Db::name('member')->where('uid',$carddb[$key]['use_uid'])->value('name');
			$carddb[$key]['app_name'] = Db::name('app')->where('appid',$carddb[$key]['appid'])->value('app_name');
			if($carddb[$key]['use_uid']){
				$carddb[$key]['user']=$user;
			}
			
			if(!empty($carddb[$key]['sales_time'])){
				$sales_time=$carddb[$key]['sales_time'];						
				$carddb[$key]['sales_time'] = date('Y-m-d H:i:s',$sales_time);//格式化时间						
			}
			if(!empty($carddb[$key]['create_time'])){
				$createtimes=$carddb[$key]['create_time'];						
				$carddb[$key]['create_time'] = date('Y-m-d H:i:s',$createtimes);//格式化时间						
			}
			if($carddb[$key]['sales_status']<1){
                $carddb[$key]['sales_status']='<span style="color:#00CC00">未出售</span>';                  	
            }elseif($carddb[$key]['sales_status']==1){
                $carddb[$key]['sales_status']='<span style="color:#0066CC">已出售</span>';                  	
            }else{
            	$carddb[$key]['sales_status']='<span style="color:#CC9900">已使用</span>';
            }			
            if($carddb[$key]['status']==1){
                $carddb[$key]['status']='<span style="color:#009900">启用</span>';                  	
            }else{
            	$carddb[$key]['status']='<span style="color:#666666">停用</span>';
            }															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$carddb;
		return json($jsondata);
	}
    /**
     * @cc 充值卡类型管理
     *    
     */
	public function type() {
		
		return $this -> fetch();
	}
	/**
     * @cc 充值卡类型列表
     *    
     */
	public function typelist(){
		//取出用户加入列表
		$auth = new \auth\Auth();
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('card_type')->count();	//计算总数						       
        $typedb=Db::name('card_type')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('card_type')->where('name','like',$search.'%')->count();	//计算总页数						       
            $typedb=Db::name('card_type')->where('name','like',$search.'%')->limit($offset.','.$limit)->select();
			
		}									
		foreach($typedb as $key=>$val){
			$typeid=$typedb[$key]['id'];
			
			if(!empty($typedb[$key]['create_time'])){
				$createtimes=$typedb[$key]['create_time'];						
				$typedb[$key]['create_time'] = date('Y-m-d H:i:s',$createtimes);//格式化时间						
			}
						
            if($typedb[$key]['status']==1){
                $typedb[$key]['status']='<span style="color:#009900">启用</span>';                  	
            }else{
            	$typedb[$key]['status']='<span style="color:#666666">停用</span>';
            }															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$typedb;
		return json($jsondata);
	}
    /**
     * @cc 添加充值卡类型
     *    
     */
	public function typeadd(){
    	if(input('?get.add') && input('get.add')=='type'){
    		$name=input('get.name');
			$day=input('get.day');
			if(!$name && !$day) return '名称和天数必须真写！';
            $res=Db::name('card_type')->where('name',$name)->find();
            if($res) return '添加失败--相同名称已存在！';
            if($day < 1) return '添加失败--天数必须是大于 0 的整数！';
            	
            $data=['name'=>$name,'day'=>$day,'create_time'=>time()];
    		$resdb=Db::name('card_type')->insert($data);;
			if($resdb){
			    return '卡类' .$name. '添加成功！';	
			}else{
				return '卡类' .$name. '添加失败！';	
			}
			 
    	}
    	
    }
	/**
     * @cc 启停删充值卡类型
     *    
     */
    public function typeset(){
		if(input('?get.typeset') && input('?get.id')){
			$id=input('get.id');
			$types=Db::name('card_type')->where('id',$id)->value('name');
			if($types){
				$status=Db::name('card_type')->where('id',$id)->value('status');				
				if(input('get.typeset')=='stop'){				
			        Db::name('card_type')->where('id', $id)->update(['status' => '0']);													
                    return '卡类型  "'.$types.'"  已停用！';	
			    }elseif(input('get.typeset')=='start'){				
			        Db::name('card_type')->where('id', $id)->update(['status' => '1']);													
	                return '卡类型  "'.$types.'"  已启用！';	
			    }elseif(input('get.typeset')=='del'){
			    	$cardtype=Db::name('card')->where('type',$id)->select();
			    	if($cardtype) return '存在此类型卡,无法删除！';			
			        Db::name('card_type')->where('id', $id)->where('name', input('get.type'))->delete();													
	                return '卡类型  "'.$types.'"  已删除！';	
			    }						
			}else{
				return '卡类型不存在！';
			}						
		}

	}		
}
