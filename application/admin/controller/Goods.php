<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use org;

class Goods extends Base {
	/**
     * @cc 应用商品管理
     *    
     */
	public function index() {
		return $this -> fetch();
	}
	/**
     * @cc 应用商品列表
     *    
     */
	public function goodslist() {
				//取出商品加入列表
		$auth = new \auth\Auth();
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('goods')->count();	//计算总数						       
        $goodsdb=Db::name('goods')->page($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('goods')->where('title','like',$search.'%')->count();	//计算总页数						       
            $goodsdb=Db::name('goods')->where('title','like',$search.'%')->page($offset.','.$limit)->select();
			
		}									
		foreach($goodsdb as $key=>$val){
			$goodsid=$goodsdb[$key]['goods_id'];				
			$appname=Db::name('app')->where('appid',$goodsdb[$key]['appid'])->value('app_name');
			if($appname){
				$goodsdb[$key]['app_name']=$appname;
			}				
			if(!empty($goodsdb[$key]['create_time'])){						
				$goodsdb[$key]['create_time'] = date('Y-m-d H:i:s',$goodsdb[$key]['create_time']);//格式化时间						
			}
			if($goodsdb[$key]['status'] < 1){
				$goodsdb[$key]['status']='<span style="color:#CC0000">停用</span>';
			}else{
				$goodsdb[$key]['status']='<span style="color:#666666">启用</span>';
			}
														
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$goodsdb;
		return json($jsondata);
	}
    /**
     * @cc 添加应用商品
     *    
     */
	public function add() {
		if(input('?post.title') && input('?post.appid')){
			if(!input('post.title')){
				return '标题不能为空！';
			}else{
				$goodsup['title']=input('post.title');
			}			
			if(input('post.appid') < 1){
				return '请选择要发布的应用商品！';
			}else{
				$goodsup['appid']=input('post.appid');
			}
			$res=Db::name('goods')->where('appid',input('post.appid'))->find();
			if($res){
				return '商品应用已存在！';
			}
			if(input('post.stitle')){
				$goodsup['stitle']=input('post.stitle');
			}
			if(input('post.copyright')){
				$goodsup['copyright']=input('post.copyright');
			}
			if(input('post.copyright')){
				$goodsup['copyright']=input('post.copyright');
			}
			if(input('post.expimg')){
				$goodsup['expimg']=input('post.expimg');
			}
			if(input('post.imgs')){
				$goodsup['imgs']=input('post.imgs');
			}
			if(input('?post.help')){
				$goodsup['help']=input('post.help');
			}
			if(input('?post.fns')){
				$goodsup['fns']=input('post.fns');
			}
			if(input('?post.uptext')){
				$goodsup['uptext']=input('post.uptext');
			}
			if(input('post.down_url')){
				$goodsup['down_url']=input('post.down_url');
			}
			$goodsup['create_time']=time();
			$goodsid=Db::name('goods')->insertGetId($goodsup);
			
			$respost=input('post.');
			$in=1;
			$updata[0]=['typeid'=>0,'money'=>input('post.acardmoney'),'goods_id'=>$goodsid];
			foreach($respost as $key => $val){
				$sa=strpos($key,'peid_');						
				if($sa  > 1){					
					$mos=explode('_',$key);						
					$data = [$mos[0] => $mos[1], 'money' => $val,'goods_id'=>$goodsid];
					$updata[$in]=$data;
					$in++;
					
				}
				
			}
			
			Db::name('money')->insertAll($updata);
			return '商品添加成功！';
		}
		
	    $resgoods=Db::name('goods')->field('appid')->select();
	    $res='';
	    foreach($resgoods as $key=>$val){
	    	foreach($resgoods[$key] as $k=>$v){
	    		$res.=$v.',';
	    	}
	    }
		$resapp=Db::name('app')->where('app_status',1)->where('appid','not in',$res)->field('appid,app_name,free')->select();
        $this -> assign('resapp', $resapp);     
        $card_type=Db::name('card_type')->where('status',1)->field('id,name')->select();     
        $this -> assign('card_type', $card_type);
		return $this -> fetch();
	}
	/**
     * @cc 应用商品图片上传
     *    
     */
	public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
             $imgurl=str_replace("\\","/",$info->getSaveName());
            return $imgurl;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
	 /**
     * @cc 启停删应用商品
     *    
     */
    public function set(){
    	if(input('?get.goodsset') && input('get.goodsid')){
    		if(input('get.goodsset')=='stop'){
    			Db::name('goods')->where('goods_id',input('get.goodsid'))->update(['status' => '0']);
    		    return '停用成功!';
    		}elseif(input('get.goodsset')=='start'){
    			Db::name('goods')->where('goods_id',input('get.goodsid'))->update(['status' => '1']);
    	        return '启用成功!';
    		}elseif(input('get.goodsset')=='del'){
    			Db::name('goods')->where('goods_id',input('get.goodsid'))->delete();
    			Db::name('money')->where('goods_id',input('get.goodsid'))->delete();
    	        return '删除成功!';
    		}else{
    			return '操作失败!';
    		}   		
    	}
    	return '操作失败!';
    }
	 /**
     * @cc 编辑应用商品
     *    
     */
    public function edit() {
		if(input('?post.title') && input('?post.goodsid')){
			if(!input('post.title')){
				return '标题不能为空！';
			}else{
				$goodsup['title']=input('post.title');
			}			
			if(input('post.appid')<1){
				return '请选择要修改的应用商品！';
			}else{
				$goodsup['appid']=input('post.appid');
			}
			$ress=Db::name('goods')->where('appid',input('post.appid'))->find();
			if(!$ress){
				return '商品应用不存在，无法编辑！';
			}
			if(input('post.stitle')){
				$goodsup['stitle']=input('post.stitle');
			}
			if(input('post.copyright')){
				$goodsup['copyright']=input('post.copyright');
			}
			if(input('post.expimg')){
				$goodsup['expimg']=input('post.expimg');
			}else{
				$goodsup['expimg']='';
			}
			if(input('post.imgs')){
				$goodsup['imgs']=input('post.imgs');
			}else{
				$goodsup['imgs']='';
			}
			if(input('?post.help')){
				$goodsup['help']=input('post.help');
			}
			if(input('?post.fns')){
				$goodsup['fns']=input('post.fns');
			}
			if(input('?post.uptext')){
				$goodsup['uptext']=input('post.uptext');
			}
			if(input('post.down_url')){
				$goodsup['down_url']=input('post.down_url');
			}
			$goodsup['create_time']=time();
			$goodsid=input('post.goodsid');
			Db::name('goods')->where('goods_id',$goodsid)->update($goodsup);
			$resin=input('post.');
			$inu=1;
			$datas[0]=['typeid' => 0, 'money'=>input('post.acardmoney'), 'goods_id' =>$goodsid];
			foreach($resin as $ku => $vu){
				$sas=strpos($ku,'peid_');
				if($sas > 1){
					$moa=explode('_',$ku);
					$dbs = [$moa[0] => $moa[1],'money' => $vu,'goods_id' => $goodsid];
					$datas[$inu]=$dbs;
					$inu++;
				}
				
			}
			
			Db::name('money')->where('goods_id',$goodsid)->delete();
			Db::name('money')->insertAll($datas);
			return '商品编辑成功！';
		}
		if(input('?get.goodsid') && input('get.goodsid')){
			$this -> assign('goodsid', input('get.goodsid'));
			$goods=Db::name('goods')->where('goods_id',input('get.goodsid'))->find();
			if(!$goods){
				return '商品不存在!';
			}
			$this -> assign('goods', $goods);
			$appname=Db::name('app')->where('appid',$goods['appid'])->value('app_name');
			if(!$appname){
				return 'APP不存在！';		
			}else{
				$this -> assign('appname', $appname);
				$this -> assign('appid', $goods['appid']);
			}
			$money=Db::name('money')->where('goods_id',input('get.goodsid'))->select();	
            $acardmoney=Db::name('money')->where('goods_id',input('get.goodsid'))->where('typeid',0)->value('money');
            
            $card_type=Db::name('card_type')->where('status',1)->field('id,name')->select();
            foreach($card_type as $key=>$val){
            	//print_r($card_type[$key]);
            	$card_type[$key]['money']='';
            	foreach($money as $k=>$v){           		
            		if($card_type[$key]['id']==$money[$k]['typeid']){
            			$card_type[$key]['money']=$money[$k]['money'];
            		}
            	}           	
            }
			$userfn=new \app\common\controller\UserFn();
			$tradetype=$userfn-> tradeType();
			if($tradetype){
				$acardmoney=ceil($acardmoney);
				foreach($card_type as $k=>$v){
					$card_type[$key]['money']=ceil($card_type[$key]['money']);
				}
			}
			$this -> assign('acardmoney', $acardmoney);             
            $this -> assign('card_type', $card_type);
		    return $this -> fetch();		
		}
	    
	}
}
