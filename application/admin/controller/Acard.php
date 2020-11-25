<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Acard extends Base {
	/**
     * @cc 授权码管理
     *    
     */
	
	public function index() {
	    $appdb=Db::name('app')->where('app_status',1)->select();
		$this->assign('appdb',$appdb);
		return $this -> fetch();
	}
    /**
     * @cc 生成授权码
     *    
     */
    public function add(){
    	if(input('?get.set') && input('get.set')=='create'){
    		$appid=input('get.appid');
			$number=input('get.number');
			if($number > 100 || $number < 1) return '一次生成不能超过100或小于1';						
			$bind=input('get.bind');
			$res=makeacard(16,$number,$appid,$bind);
    		$resdb=Db::name('acard')->insertAll($res);
			if($resdb){
			    return '添加成功！';	
			}else{
				return '添加失败！';	
			}
			 
    	}
    	$resapp=Db::name('app')->where('app_status',1)->select();
		$this -> assign('resapp', $resapp);		
    	return $this -> fetch();
    }
    /**
     * @cc 增删改授权码
     *    
     */
	public function set(){
		if(input('?post.acardset')){
			
			if(input('post.acardset')=='stop'){				
			    Db::name('acard')->where('id', input('post.id'))->update(['status' => '0']);													
                return '已停用！';	
		    }elseif(input('post.acardset')=='start'){				
		        Db::name('acard')->where('id', input('post.id'))->update(['status' => '1']);													
	            return '已启用！';	
		    }elseif(input('post.acardset')=='del'){				
		        Db::name('acard')->where('id', input('post.id'))->delete();													
	            return '删除成功！';	
		    }elseif(input('post.acardset')=='dellist'){
			    $arracard=input('post.data/a');
			    $acards=array();
			    foreach($arracard as $k=>$v){
				    $acards[]=$arracard[$k]['id'];
			    }
			    Db::name('acard')->delete($acards);
			    return '删除成功！';
		    }									
		}
	}
	/**
     * @cc 编辑授权码
     *    
     */
    public function edit(){
    	if(input('?get.set') && input('get.set')=='edit'){
    		$bindcount=input('get.bind_count');
    		if(!is_numeric($bindcount)){
    			return '绑定次数只能是数字';				
    		}elseif($bindcount < 0){
    			return '绑定次数必须大于等于0';
    		}
			if(input('get.expire_time') < 1){
				$getdata['expire_time']=0;
			}else{
				$expiretime=input('get.expire_time');
			    $getdata['expire_time']=strtotime($expiretime);	
			}    		
			
			$getdata['bind']=input('get.bind');
			
			$getdata['bind_count']=$bindcount;
			DB::name('acard')->where('id',input('get.id'))->where('acard_number',input('get.acard'))->update($getdata);
			return '授权码修改成功!';
			
    	}
    	if(input('?get.id') && input('?get.acard')){
    		$id=input('get.id');
			$acard=input('get.acard');
			$appid=DB::name('acard')->where('id',$id)->where('acard_number',$acard)->value('appid');			
			$appname=DB::name('app')->where('appid',$appid)->value('app_name');
			$uid=DB::name('acard')->where('id',$id)->where('acard_number',$acard)->value('uid');
			if($uid){
				$user=DB::name('member')->where('uid',$uid)->value('name');
			    $this->assign('user',$user);
			}else{
				$this->assign('user',null);
			}
			
    	    if($appid && $appname){
				$this->assign('app_name',$appname);
    	    	$res=Db::name('acard')->where('id',$id)->where('acard_number',$acard)->find();
    	    	if($res['active_time'] < 1){
    	    		$activetime=0;
    	    	}elseif($res['active_time']==null){
    	    		$activetime=null;
    	    	}else{
    	    		$activetime=date('Y-m-d H:i',$res['active_time']);
    	    	}
    	    	
				
				if($res['expire_time'] < 1){
					$expiretime=0;
				}elseif($res['expire_time']==null){
					$expiretime=null;
				}else{
				    $expiretime=date('Y-m-d H:i',$res['expire_time']);	
				}
				if($res['sales_status'] < 1){
					$sales_status='未出售';
				}elseif($res['sales_status']==1){
					$sales_status='已出售';
				}else{
					$sales_status='已使用';
				}
                
				$this->assign('res',$res);
				$this->assign('activetime',$activetime);						
			    $this->assign('expiretime',$expiretime);
				$this->assign('sales_status',$sales_status);				
			    return $this->fetch();
    	    }
			return 'error';
			
    	}
    }
    
	/**
     * @cc 授权码列表
     *    
     */
	
	public function acardlist(){
		//取出加入列表
		$auth = new \auth\Auth();
		$limit=input('get.limit');
		$offset=input('get.offset');
		if(input('?get.appid') && input('?get.status') && input('?get.sales_status')){
			$where=['appid'=>input('get.appid'),'status'=>input('get.status'),'sales_status'=>input('get.sales_status')];
			$total=Db::name('acard')->where($where)->count();	//计算总数								       
            $acarddb=Db::name('acard')->where($where)->page($offset.','.$limit)->select();
		    if(input('?get.search')){
			    $search=input('get.search');			
			    $total=Db::name('acard')->where($where)->where('acard_number','like',$search.'%')->count();	//计算总页数						       
                $acarddb=Db::name('acard')->where($where)->where('acard_number','like',$search.'%')->page($offset.','.$limit)->select();			
		    }
		}else{
			$total=Db::name('acard')->count();	//计算总数								       
            $acarddb=Db::name('acard')->page($offset.','.$limit)->select();
		    if(input('?get.search')){
			    $search=input('get.search');			
			    $total=Db::name('acard')->where('acard_number','like',$search.'%')->count();	//计算总页数						       
                $acarddb=Db::name('acard')->where('acard_number','like',$search.'%')->page($offset.','.$limit)->select();			
		    }	
		}			
										
		foreach($acarddb as $key=>$val){
			$acardid=$acarddb[$key]['id'];
			
			$user=Db::name('member')->where('uid',$acarddb[$key]['uid'])->value('name');
			$acarddb[$key]['app_name'] = Db::name('app')->where('appid',$acarddb[$key]['appid'])->value('app_name');
			if($acarddb[$key]['uid']){
				$acarddb[$key]['user']=$user;
			}
			if(!empty($acarddb[$key]['sales_time'])){
				$sales_time=$acarddb[$key]['sales_time'];						
				$acarddb[$key]['sales_time'] = date('Y-m-d H:i:s',$sales_time);//格式化时间						
			}
			if(!empty($acarddb[$key]['logintime'])){
				$logintimes=$acarddb[$key]['logintime'];						
				$acarddb[$key]['logintime'] = date('Y-m-d H:i:s',$logintimes);//格式化时间						
			}
			if(!empty($acarddb[$key]['expire_time'])){
				$expire_time=$acarddb[$key]['expire_time'];						
				$acarddb[$key]['expire_time'] = date('Y-m-d H:i:s',$expire_time);//格式化时间						
			}
			if(!empty($acarddb[$key]['create_time'])){
				$createtimes=$acarddb[$key]['create_time'];						
				$acarddb[$key]['create_time'] = date('Y-m-d H:i:s',$createtimes);//格式化时间						
			}
			if($acarddb[$key]['sales_status']<1){
                $acarddb[$key]['sales_status']='<span style="color:#00CC00">未出售</span>';                  	
            }elseif($acarddb[$key]['sales_status']==1){
                $acarddb[$key]['sales_status']='<span style="color:#0066CC">已出售</span>';                  	
            }else{
            	$acarddb[$key]['sales_status']='<span style="color:#CC9900">已使用</span>';
            }			
            if($acarddb[$key]['status']==1){
                $acarddb[$key]['status']='<span style="color:#009900">启用</span>';                  	
            }else{
            	$acarddb[$key]['status']='<span style="color:#666666">停用</span>';
            }															
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$acarddb;
		return json($jsondata);
	}	
}
