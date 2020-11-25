<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\View;
use app\common\controller\Payfn;
use think\Request;
class Index extends Base {
	public function index() {
				      		
		$goods = Db::name('goods') -> where('status', 1) -> order('count desc') -> limit(4) -> select();
		foreach ($goods as $key => $val) {
			$goods[$key]['appname'] = Db::name('app') -> where('appid', $goods[$key]['appid']) -> value('app_name');
			$s = ('t' . rand(1, 20) . '.png');
			$goods[$key]['simgs'] = $s;

		}
		$article=Db::name('article')->where('status',1)->order('id desc')->paginate(12);		
		$arrys=object2array($article);				
		foreach($arrys as $key=>$val){
			$s = ('t' . rand(1, 20) . '.png');
			$arrys[$key]['simgs'] = $s;
			$arrys[$key]['urls']=URL('/index/article/index',['id'=>$article[$key]['id']]);
			
			
			$arrys[$key]['add_time']=time2date($arrys[$key]['add_time']);			
		}
		$this->assign('arrys',$arrys);			
		$this->assign('article',$article);      
		$this -> assign('goods', $goods);
		$seo=[
		    'title'=>config('netinfo.name'),
		    'keywords'=>config('netinfo.keyword'),
		    'description'=>config('netinfo.description'),
		];
		$this -> assign('seo', $seo);
		return $this -> fetch();
	}
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
	public function sendmail(){
		$res=send_mail('3718217@qq.com','raiaaan','tesfdsafdsatss','xxxxx');
		
	}
    public function test(){
    	$userfn=new \app\common\controller\UserFn();
		$register=$userfn->register('a2>','123456','123456','123','1');
		return $register;
    }
	public function ress(){
		// 是否为 GET 请求

if (Request::instance()->isMobile()) echo "当前为手机访问";

	}
}
