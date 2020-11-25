<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use org;
use think\Request;
use think\Cache;

class netset extends Base {
	/**
    * @cc 网站设置
    *    
    */
	public function index() {
		if(Request::instance()->isAjax()){
			if(input('post.name')){
			$file=APP_PATH.'extra/netinfo.php';
			update_config($file, 'status', input('status'),$type='int');
			update_config($file, 'key', input('key'));
			update_config($file, 'name', input('name'));
			update_config($file, 'keyword', input('keyword'));
			update_config($file, 'description', input('description'));
			update_config($file, 'copyright', input('copyright'));
			update_config($file, 'cservice', input('cservice'));
			update_config($file, 'record', input('record'));
			$gconfig=APP_PATH.'config.php';
			
			update_config($gconfig, 'app_debug', input('app_debug'),$type='int');
			
			$access_control=APP_PATH.'extra/access_control.php';
			update_config($access_control, 'register_time', input('register_time'),$type='int');
			update_config($access_control, 'register_num', input('register_num'),$type='int');
			update_config($access_control, 'status', input('register_black_count'),$type='int');
			update_config($access_control, 'register_black_count', input('email_repwb_time'),$type='int');
			update_config($access_control, 'email_repwb_num', input('email_repwb_num'),$type='int');
			update_config($access_control, 'email_repwb_black_count', input('email_repwb_black_count'),$type='int');           
			return '修改成功!';
			}else{
			return '修改失败，请输入网站名称！';
		    }			
		}
		return $this -> fetch();


	}
	/**
    * @cc 备份数据库
    *    
    */
    public function bak(){
        $type=input("tp");
        $name=input("name");
        $sql=new \org\Baksql(\think\Config::get("database"));
        switch ($type)
        {
            case "backup": //备份
                return $sql->backup();
                break;  
            case "dowonload": //下载
                $sql->downloadFile($name);
                break;  
            case "restore": //还原
                return $sql->restore($name);
                break; 
            case "del": //删除
                return $sql->delfilename($name);
                break;          
            default: //获取备份文件列表
            return $this->fetch("db_bak",["list"=>$sql->get_filelist()]); 
          
        }
        
    }
	/**
    * @cc 数据库备份列表
    *    
    */
    public function baklist(){
    	$sql=new \org\Baksql(\think\Config::get("database"));
    	$bakfilelist=$sql->get_filelist();
		$jsondata=json($bakfilelist);	
		return $jsondata;   	   	
    }
    /**
    * @cc 清除缓存
    *    
    */
    public function delcache(){
    	Cache::clear();
    }
	

}
