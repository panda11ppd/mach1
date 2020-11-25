<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use org;

class Article extends Base {
	/**
     * @cc 文章管理
     *    
     */
	public function index() {
		return $this -> fetch();
	}
	/**
     * @cc 文章分类
     *    
     */
	public function sorts() {
		$sortdb=Db::name('sort')->select();
		$this->assign('sortdb',$sortdb);
		return $this -> fetch();
				
	}
	/**
     * @cc 文章分类设置
     *    
     */
	public function sortset() {
		if(input('get.sort_id')==1){
			return '默认分类，不允许操作！';
		}
		if(input('get.sortset')=='stop'){
			Db::name('sort')->where('id',input('get.sort_id'))->setField('status', 0);
			Db::name('menu')->where('type','article')->where('bind_id',input('get.sort_id'))->setField('status',0);
			return '分类停址成功！';
		}elseif(input('get.sortset')=='start'){
			Db::name('sort')->where('id',input('get.sort_id'))->setField('status', 1);
			Db::name('menu')->where('type','article')->where('bind_id',input('get.sort_id'))->setField('status',1);
			return '分类启用成功！';
		}elseif(input('get.sortset')=='del'){
			$res=Db::name('sort')->where('parent_id',input('get.sort_id'))->find();
			if($res){
				return '删除失败，该分类中有子分类，请先删除子分类！';
			}
			Db::name('sort')->delete(input('get.sort_id'));
			Db::name('menu')->where('type','article')->where('bind_id',input('get.sort_id'))->delete();
			return '分类删除成功！';
		}else{
			return '操作失败！';
		}
				
	}
	/**
     * @cc 添加文章分类
     *    
     */
	public function addsort() {
		if(input('?get.sort_name') && input('?get.description')){
			$res=Db::name('sort')->where('sort_name',input('get.sort_name'))->find();
			if($res){
				return '分类已存在，添加失败！';
			}
			$data=['sort_name'=>input('get.sort_name'),'description'=>input('get.description'),'parent_id'=>input('get.parent_id')];
			$sid=Db::name('sort')->insertGetId($data);
			
			if(input('get.parent_id') >= 1){
			    return '分类添加成功！';	
			}
			
			
		}else{
			return '分类添加失败！';
		}
						
	}
	/**
     * @cc 编辑文章分类
     *    
     */
	public function editsort() {
		if(input('?get.sort_id') && input('?get.sort_name')){
			$res=Db::name('sort')->where('id','<>',input('get.sort_id'))->where('sort_name',input('get.sort_name'))->find();
			if($res){
				return '分类名已存在，修改失败！';
			}
			$updb=['sort_name'=>input('get.sort_name'),'description'=>input('get.description'),'parent_id'=>input('get.parent_id')];
			Db::name('sort')->where('id',input('get.sort_id'))->update($updb);
			
			return '分类修改成功！';
		}else{
			$sort=Db::name('sort')->where('id',input('get.sort_id'))->find();
			$pid=Db::name('sort')->where('id',input('get.sort_id'))->value('parent_id');						
			$sortdb=Db::name('sort')->select();
			$sortree=$this->getSonNode($sortdb,input('get.sort_id'));
			$sdb=Db::name('sort')->where('id','not in',$sortree)->select();	
			$trees=$this->sortOut($sdb);		
			$this->assign('sort',$sort);
			$this->assign('sortdb',$sortdb);
			$this->assign('sdb',$trees);
			return $this -> fetch();
		}
						
	}
	protected function getSonNode($data,$pid=0,$SonNode = array()){//递归取下级分类
        $SonNode[] = $pid;
        foreach($data as $k=>$v){
            if($v['parent_id'] == $pid){
                $SonNode = self::getSonNode($data,$v['id'],$SonNode);
            }
        }
        return $SonNode;
    }
	/**
     * @cc 文章分类列表
     *    
     */     
	public function sortlist(){						       
        $sortdb=Db::name('sort')->select();
		foreach ($sortdb as $key => $value) {
			$sortdb[$key]['count']=Db::name('article_relation')->where('sort_id',$sortdb[$key]['id'])->count();
		}	    
		$tree=$this->sortOut($sortdb);		
		$jsondata['data']=$tree;
		return json($jsondata);  
	}
	protected function sortOut($cate, $parent_id = 0, $level = 0, $html = '—&nbsp') {//递归分类排列
	    $tree = array();
            foreach($cate as $v){               	
                if($v['parent_id'] == $parent_id){
                    $v['level'] = $level + 1;
                    $v['sort_name'] = str_repeat($html, $level).$v['sort_name'];
                    $tree[] = $v;
                    $tree = array_merge($tree, self::sortOut($cate,$v['id'],$level+1,$html));
                }
            }
            return $tree;
	   
    }
    /**
     * @cc 文章列表
     *    
     */
	public function articlelist() {
				//取出文章列表		
		$limit=input('get.limit');
		$offset=input('get.offset');			
		$total=Db::name('article')->count();	//计算总数						       
        $articledb=Db::name('article')->limit($offset.','.$limit)->select();
		if(input('?get.search')){
			$search=input('get.search');			
			$total=Db::name('article')->where('title','like',$search.'%')->count();	//计算总页数						       
            $articledb=Db::name('article')->where('title','like',$search.'%')->limit($offset.','.$limit)->select();
			
		}									
		foreach($articledb as $key=>$val){
			$sortid=Db::name('article_relation')->where('article_id',$articledb[$key]['id'])->column('sort_id');
			if($sortid==null){
				$articledb[$key]['sort']='未分类..';
			}else{							
			    $sortdb=Db::name('sort')->where('id','in',$sortid)->select();				
			    $sort='';
			    foreach($sortdb as $k=>$v){
			        $sort.=	$sortdb[$k]['sort_name'].',';
			    }
			    $articledb[$key]['sort']=$sort;
			}
							
			if(!empty($articledb[$key]['add_time'])){						
				$articledb[$key]['add_time'] = date('Y-m-d H:i:s',$articledb[$key]['add_time']);//格式化时间						
			}
			if($articledb[$key]['status'] < 1){
				$articledb[$key]['status']='<span style="color:#CC0000">停用</span>';
			}else{
				$articledb[$key]['status']='<span style="color:#666666">启用</span>';
			}
														
		}
        $jsondata['total']=$total;
				//$jsondata['page']=$page;
		$jsondata['rows']=$articledb;
		return json($jsondata);
	}
    /**
     * @cc 添加文章
     *    
     */
	public function add() {
		if(input('?post.title')){												
			$indata=[
			    'title'=>input('post.title'),
			    'keyword'=>input('post.keyword'),
			    'content'=>input('post.content'),
			    'author'=>Session('username'),
			    'add_time'=>time(),
			    'thumb_img'=>input('post.thumb_img')
			    			    
			];
			
			
			$resid=Db::name('article')->insertGetId($indata);
			
			if(input('post.sort/a')){
				$sort=input('post.sort/a');
				$reldata=array();
				foreach($sort as $k=>$v){
				    $reldata[]=['article_id'=>$resid,'sort_id'=>$v];				    	
				}
				
			}else{
				$reldata=[['article_id'=>$resid,'sort_id'=>1]];
			}
			
			Db::name('article_relation')->insertAll($reldata);
			hook('down_fee', ['pos'=>'indate','aid'=>$resid,'isget'=>input('post.')]);
			if(!$resid){
				return 'error';
			}
			return $resid;
		}
		
		$sortdb=Db::name('sort')->select();
		foreach ($sortdb as $key => $value) {
			$sortdb[$key]['count']=Db::name('article')->count();
		}	    
		$tree=$this->sortOut($sortdb);	    
        $this -> assign('tree', $tree);
		return $this -> fetch();
	}
	/**
     * @cc 文章文件上传
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
     * @cc 文章停删设置
     *    
     */
    public function set(){
    	if(input('?get.arset')){
    		if(input('get.arset')=='stop'){
    			Db::name('article')->where('id',input('get.arid'))->update(['status' => '0']);
    		    return '停用成功!';
    		}elseif(input('get.arset')=='start'){
    			Db::name('article')->where('id',input('get.arid'))->update(['status' => '1']);
    	        return '启用成功!';
    		}elseif(input('get.arset')=='del'){
    			Db::name('article')->where('id',input('get.arid'))->delete();
				Db::name('article_relation')->where('article_id',input('get.arid'))->delete();  			
    	        return '删除成功!';
    		}elseif(input('get.arset')=='dellist'){
				$arrar=input('get.data/a');
				$ars=array();
				foreach($arrar as $k=>$v){
					$ars[]=$arrar[$k]['id'];
				}
				Db::name('article')->delete($ars);
				Db::name('article_relation')->where('article_id','in',$ars)->delete();
				return '删除成功！';
			}else{
    			return '操作失败!';
    		}   		
    	}
    	return '操作失败!';
    }
	/**
     * @cc 编辑文章
     *    
     */
    public function edit() {
    	if(input('?get.aid')){
    		$adb=Db::name('article')->where('id',input('get.aid'))->find();
			$adb_sort=Db::name('article_relation')->where('article_id',input('get.aid'))->column('sort_id');;
			$sortdb=Db::name('sort')->select();		    	    
		    $tree=$this->sortOut($sortdb);	                
			$this->assign('adb',$adb);						
			$this->assign('adb_sort',$adb_sort);
			$this -> assign('tree', $tree);			
			return $this -> fetch();
    	}
		if(input('?post.title') && input('?post.content') && input('?post.arid')){
												
			$updata=[
			    'title'=>input('post.title'),
			    'keyword'=>input('post.keyword'),
			    'content'=>input('post.content'),
			    'update_time'=>time(),
			    'thumb_img'=>input('post.thumb_img')
			    			    
			];
			
			
			Db::name('article')->where('id',input('post.arid'))->update($updata);
			if(input('post.sort/a')){
				$sort=input('post.sort/a');
				$reldata=array();
				foreach($sort as $k=>$v){
				    $reldata[]=['article_id'=>input('post.arid'),'sort_id'=>$v];				    	
				}
				
			}else{
				$reldata=[['article_id'=>input('post.arid'),'sort_id'=>1]];
			}
			Db::name('article_relation')->where('article_id',input('post.arid'))->delete();
			Db::name('article_relation')->insertAll($reldata);
			hook('down_fee', ['pos'=>'indate','aid'=>input('post.arid'),'isget'=>input('post.')]);
			if(!input('post.arid')){
				return 'error';
			}
			return input('post.arid');
		}
	    
	}
}
