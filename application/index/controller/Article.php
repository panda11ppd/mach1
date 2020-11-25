<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;


class Article extends Base
{
    public function index(){
    	hook('down_fee', ['pos'=>'enpay','fileid'=>input('get.fileid')]);    	
		$id=input('param.id');
		if(!session($id)){
			session($id,'active');
			Db::name('article')->where('id',$id)->setInc('post_num',1);
		}
						
		$article=Db::name('article')->where('id',$id)->find();
		$contentes = mb_substr($article['content'], 0, 30, 'utf-8');
		$title=$article['title'];
		$this->assign('title',$title);
		$res=strip_tags($contentes);
        $article['description']=$res;		
		$article['add_time']=time2date($article['add_time']);
		$sortinfo=$this->getsort($id);
		$this->assign('sortinfo',$sortinfo);
		$this->assign('article',$article);
		
		$seo=[
		    'title'=>$article['title'].'-'.config('netinfo.name'),
		    'keywords'=>$article['keyword'],
		    'description'=>$article['description'],
		];
		$this -> assign('seo', $seo);	
      
    	return $this->fetch();
    }	   
     
    public function allarticle()
    {
        $sortdb['sort_name']='所有文章';
		$sortdb['description']='';
			
        $this->assign('sortdb',$sortdb);	
        $article=Db::name('article')->where('status',1)->order('id desc')->paginate(10);		
		$arrys=object2array($article);				
		foreach($arrys as $key=>$val){
			$sorts=$this->getsort($arrys[$key]['id']);
			$s = ('t' . rand(1, 20) . '.png');
			$arrys[$key]['simgs'] = $s;
			$arrys[$key]['urls']=URL('/index/article/index',['id'=>$article[$key]['id']]);
			if($sorts){
				$arrys[$key]['sort']=$sorts['sort_name'];
				$arrys[$key]['sort_id']=$sorts['id'];
				$arrys[$key]['menu_url']=$sorts['menu_url'];
			}else{
				$arrys[$key]['sort']='未分类';
				$arrys[$key]['sort_id']=1;
			}
			
			$arrys[$key]['add_time']=time2date($arrys[$key]['add_time']);			
		}
		$this->assign('arrys',$arrys);			
		$this->assign('article',$article);
		$seo=[
		    'title'=>$sortdb['sort_name'].'-'.config('netinfo.name'),
		    'keywords'=>$sortdb['sort_name'],
		    'description'=>$sortdb['description'],
		];
		$this -> assign('seo', $seo);	   	
        return $this->fetch('article');
    }
	public function sorts(){
		
		$sortid=input('param.id');
		$sortdb=Db::name('sort')->where('id',$sortid)->find();
		$this->assign('sortdb',$sortdb);
		$article=Db::name('article_relation')->where('sort_id',$sortid)->column('article_id');
		if($article){
			$article=Db::name('article')->where('status',1)->where('id','in',$article)->order('id desc')->paginate(10);	
			$arrys=object2array($article);			
		}else{
			$article='';
			$arrys=array();
		}	
			
						
		foreach($arrys as $key=>$val){
			$sorts=$this->getsort($arrys[$key]['id']);
			$s = ('t' . rand(1, 20) . '.png');
			$arrys[$key]['simgs'] = $s;
			$arrys[$key]['urls']=URL('/index/article/index',['id'=>$article[$key]['id']]);
			if($sorts){
				$arrys[$key]['sort']=$sorts['sort_name'];
				$arrys[$key]['sort_id']=$sorts['id'];
				$arrys[$key]['menu_url']=$sorts['menu_url'];
				
			}else{
				$arrys[$key]['sort']='未分类';
				$arrys[$key]['sort_id']=1;
			}
			
			$arrys[$key]['add_time']=time2date($arrys[$key]['add_time']);			
		}
		$this->assign('arrys',$arrys);			
		$this->assign('article',$article);
		$seo=[
		    'title'=>$sortdb['sort_name'].'-'.config('netinfo.name'),
		    'keywords'=>$sortdb['sort_name'],
		    'description'=>$sortdb['description'],
		];	
		$this -> assign('seo', $seo); 
		return $this->fetch('article');
	}
	//取文章分类信息	
	private function getsort($articleid){
		$sortid=Db::name('article_relation')->where('article_id',$articleid)->value('sort_id');
		$res=Db::name('sort')->where('id',$sortid)->find();	
		if(!$res){
			$res['sort_name']='未分类';
		    $res['id']=1;
		}
		$res['menu_url']=URL('/index/article/sorts',['id'=>$sortid]);			
		return $res;
		
	}
	
}