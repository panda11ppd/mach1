<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class App extends Base {
	/**
     * @cc 应用管理
     *    
     */
	public function index() {
		$auth = new \auth\Auth();//实列化auth	
		if (input('?get.appset') && Input('get.appset')=='list') {			
		    $applist = Db::name('app') -> select();				
		    foreach ($applist as $key => $val) {
			    if (!empty($applist[$key]['create_time'])) {
				    $applist[$key]['create_time'] = date('Y-m-d H:i:s', $val['create_time']);
						//格式化时间
			    }
			    if (!empty($applist[$key]['update_time'])) {
				    $applist[$key]['update_time'] = date('Y-m-d H:i:s', $val['update_time']);
						//格式化时间
			    }
			    if ($applist[$key]['free'] == 1) {
				    $applist[$key]['free'] = '<span class="label label-primary">收费软件</span>';
			    } else {
				    $applist[$key]['free'] = '<span class="label label-success">免费软件</span>';
			    }
			    if ($applist[$key]['app_status'] == 1) {
				    $applist[$key]['app_status'] = '<span style="color:#0099FF">已启用</span>';
			    } else {
				    $applist[$key]['app_status'] = '<span style="color:#CC0000">已停用</span>';
			    }
		    }
		    $jsonsoft = json($applist);
		    return $jsonsoft;			
		}
		return $this -> fetch();
	}
    /**
     * @cc 添加应用
     *    
     */
	public function add() {//添加软件		
		if (input('?get.appset')) {
			$ops = Input('get.appset');
			$appname = Input('get.app_name');
			$app_key = Input('get.app_key');						
			if ($ops == 'add') {
				if ($appname == null) {
					return '应用名称不能为空';
				} 
				if($app_key==null){
					return '应用KEY不能为空';
				}
				$dat = Db::name('app') -> where('app_name', $appname) -> find();
                if ($dat) {
					return '已存在相同软件名！请修改！';
				}else {
					$indata = array();
					$indata['app_name'] = Input('get.app_name');
					$indata['app_key'] = Input('get.app_key');					
					$indata['version']=input('get.version');
					$indata['down_url'] = Input('get.downurl');
					$indata['free'] = Input('get.free');
					$indata['test_time'] = Input('get.test_time');
					$indata['acard_time'] = Input('get.acard_time');
					$indata['app_data'] = Input('get.app_data');
					$indata['app_bind'] = Input('get.app_bind');
					$indata['announcement']=input('get.announcement');
					$indata['create_time'] = time();
					$indata['update_time'] = time();
					Db::name('app') -> insert($indata);
					return '添加成功';
				}
			} elseif ($ops == 'edit') {

			}
		}
		return $this -> fetch();
	}
    /**
     * @cc 编辑应用
     *    
     */
	public function edit() {//编辑软件
	    if (input('?get.appset') && input('get.appset')=='edit') {//修改软件
			$appid = Input('get.appid');
		    $appname = Input('get.app_name');
			$appkey = Input('get.app_key');
			$resid = Db::name('app') -> where('app_name', $appname) -> value('appid');
			if ($appname == null) {
				return '软件名称不能为空';
			} elseif ($appid != $resid && $resid) {
				return '已存在相同软件名！请修改！';
			} elseif($appkey==null) {
				return 'KEY不能为空！';					
			}else{
			    $updata =[
			    	'app_name'    => Input('get.app_name'),
			    	'app_key'     => Input('get.app_key'),
			    	'free'        => Input('get.free'),
			    	'test_time'     => Input('get.test_time'),
			    	'acard_time'   => Input('get.acard_time'),
			    	'app_bind'    => Input('get.app_bind'),
			    	'app_data'    => Input('get.app_data'),
			    	'announcement'=> Input('get.announcement'),
			    	'version'     => Input('get.version'),
			    	'down_url'    => Input('get.down_url'),
			    	'update_time' => time(),
			    	
                ];
				Db::name('app') -> where('appid',$appid)-> update($updata);
				return '修改成功';
			}
		
		}
	    
		if(input('?get.appid') && input('get.appid')){
			$appid=input('get.appid');
			$appdata=Db::name('app')->where('appid',$appid)->find();
			$this->assign('appid',$appid);
			$this->assign('appdata',$appdata);			
		    return $this -> fetch();			
		}		
	}
    /**
     * @cc 应用启停删
     *    
     */
    public function set(){
    	if(input('?get.appop')){
			$appid=input('get.appid');
			if(input('get.appop')=='stop'){
				Db::name('app') -> where('appid',$appid)-> setField('app_status',0);
				Db::name('goods') -> where('appid',$appid)-> setField('status',0);
				return '禁用成功！';
            }elseif(input('get.appop')=='start'){
               	Db::name('app') -> where('appid',$appid)-> setField('app_status',1);
				Db::name('goods') -> where('appid',$appid)-> setField('status',1);
			    return '启用成功！';              	
            }elseif(input('get.appop')=='del'){
               	Db::name('app') -> where('appid',$appid)-> delete();
				$goods_id=Db::name('goods')->where('appid',$appid)->value('goods_id');
				if($goods_id){
					Db::name('goods') -> where('appid',$appid)-> delete();
					Db::name('goods') -> where('goods_id',$goods_id)-> delete();
				}								
				return '删除成功';
            }			
			
		}
    }

}
