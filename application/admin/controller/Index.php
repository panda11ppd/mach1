<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use app\common\builder\ZBuilder;

class index extends Base {
	/**
    * @cc 管理首页
    *    
    */
	public function index() {
  
        $getser=chttp(config('sysinfo.app_url'),['app_id'=>1,'app_key'=>'raincms']);		
		$resarr=object2array(json_decode($getser));
		if($resarr){
			$appinfo=object2array($resarr['data']);
			if(config('sysinfo.version') == $appinfo['version']){
			    $appinfo['btn']='修复';			
		    }else{
			    $appinfo['btn']='更新';
		    }			
		}else{
			$appinfo['version']='Rain平台连接失败!';
			$appinfo['btn']='无法更新';
		}						
        $this -> assign('appinfo', $appinfo);		
	    $index = '管理首页';
		$this -> assign('nav', '首页');
		$this -> assign('menu', '网站信息');	        											
		$uid=Session::get('uid');
		$lastlogintime=Db::name('member')->where('uid',$uid)->value('lastlogintime');
		$lastlogintime=date('Y-m-d H:i:s',$lastlogintime);
		$this->assign('lastlogintime',$lastlogintime);
	    $lastloginip=Db::name('member')->where('uid',$uid)->value('lastloginip');
		$this -> assign('lastloginip', $lastloginip);
		$logincount=Db::name('member')->where('uid',$uid)->value('logincount');
		$this -> assign('logincount', $logincount);	
		$this -> assign('lastloginip', $lastloginip);
        $version = Db::query("select version() as ver");
        $mysqlv = $version[0]['ver'];
		$this -> assign('mysqlv', $mysqlv);
		$usernumber=Db::name('member')->where('uid','>',1)->count();
		$this -> assign('usernumber', $usernumber);
		$appnumber=Db::name('app')->count();
		$this -> assign('appnumber', $appnumber);
		$acardnumber=Db::name('acard')->where('sales_status','<',1)->where('status',1)->count();
		$this -> assign('acardnumber', $acardnumber);
		$cardnumber=Db::name('card')->where('sales_status','<',1)->where('status',1)->count();
		$this -> assign('cardnumber', $cardnumber);	
        return $this -> fetch();		
		
	}

    public function upsys(){
    	
    	$file = ROOT_PATH.'upload/update.zip'; 
        $result = @unlink ($file);
		//取软件信息 
    	$getser=chttp(config('sysinfo.app_url'),['app_id'=>1,'app_key'=>'raincms']);
		$resarr=object2array(json_decode($getser));
		if(!is_array($resarr)){
			return json(['code'=>45004,'mssages'=>'error','concent'=>'无法解析服务器']);
		}		
		
		$appinfo=object2array($resarr['data']);
    	$upres=getFile($appinfo['update_url'],ROOT_PATH.'upload','update.zip',0);
		$this->updates();
		//$reszip=get_zip_originalsize(ROOT_PATH.'upload/update.zip','./');
		return json($upres);
    	
    }
	public function updates(){
		$request = Request::instance();
		$ress=chttp( $request->domain().URL('/install/update/update'),['datapwd'=>config('database.password')]);
		return $ress;
		
	}
	/**
    * @cc 管理员修改密码页
    *    
    */
	public function uloginedit() {
		$uloginid=Session::get('uid');
		$loginuserdb=Db::name('member')->where('uid',$uloginid)->find();
		$this -> assign('uloginid', $uloginid);
		$this -> assign('loginuserdb', $loginuserdb);
		return $this -> fetch();		
	}
	/**
    * @cc 管理员确认修改密码
    *    
    */
	public function addulogin() {
        if(input('post.password') == null) return '原密码不能为空';
        if(input('post.newpassword') == null) return '新密码不能为空';
        if(input('post.newpassword2') == null) return '再次输入密码不能为空';
        if(input('post.newpassword') != input('post.newpassword2')) return '二次密码输入不相同！';
        $pwd=md5(input('post.password'));
		if($pwd != session('password')) return '原密码不正确';
		$uloginid=Session::get('uid');
		$newpwd=md5(input('post.newpassword'));
		Db::name('member')->where('uid',$uloginid)->update(['password'=>$newpwd,'email'=>input('post.email')]);
		session('password',$newpwd);
		return '修改成功!';
			
       
	}
	
}
