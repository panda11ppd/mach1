<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;

class Pay extends Base {
	/**
    * @cc 支付设置页
    *    
    */
	public function index() {
		$rainpay['seller_id']=config('rainpay_config.seller_id');
		$rainpay['key']=config('rainpay_config.key');
		$rainpay['seller_email']=config('rainpay_config.seller_email');
		$freevisa=config('free_visa.imgs');
		$this->assign('freevisa',$freevisa);
		$this->assign('rainpay',$rainpay);
		return $this -> fetch();
	}
	/**
    * ccc 免签支付设置
    *    
    */
	public function vapayadd(){
		if(input('post.expimg')){
			$file=APP_PATH.'extra/free_visa.php';
			update_config($file, 'imgs', input('expimg'));
			return '保存成功';
		}else{
			$file=APP_PATH.'extra/free_visa.php';
			update_config($file, 'imgs', '');
			return '保存成功';
		}	
	}
	/**
    * ccc 保存Rain支付设置
    *    
    */
	public function saverainpay() {
		
	    if(input('get.name')=='rainpay'){
	    	$confile=APP_PATH.'extra/rainpay_config.php';			
			$seller_id=input('get.seller_id');
			$partner=input('get.seller_id');
			$key=input('get.key');
			$seller_email=input('get.seller_email');
			update_config($confile,'partner',$partner);
			update_config($confile,'seller_id',$seller_id);
			update_config($confile,'key',$key);
			update_config($confile,'seller_email',$seller_email);
	    	return '修改成功！';
			
	    }
	}
	/**
    * ccc 保存支付宝设置
    *    
    */
	public function savealipay() {
		
	    if(input('get.name')=='alipay'){
	    	$confile=APP_PATH.'extra/alipay_config.php';			
			$seller_id=input('get.seller_id');
			$partner=input('get.seller_id');
			$key=input('get.key');
			$seller_email=input('get.seller_email');
			update_config($confile,'partner',$partner);
			update_config($confile,'seller_id',$seller_id);
			update_config($confile,'key',$key);
			update_config($confile,'seller_email',$seller_email);
	    	return '修改成功！';
			
	    }
	}
	/**
     * ccc 扫码支付上传
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
}	