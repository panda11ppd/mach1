<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use app\common\controller\Payfn;

class Rainpay extends controller {
    public function _initialize(){
    	
    	vendor('rainpay.Corefn');
		vendor('rainpay.Md5fn');
		vendor('rainpay.Notify');
		vendor('rainpay.Submit');
		
		$request = Request::instance();		
	    define('WEB_PATH', $request->root());//程序目录
		define('MODULE_NAME', $request->module());//当前模块名
        define('CONTROLLER_NAME', $request->controller());//当前控制器
		define('ACTION_NAME', $request->action());//当前操作名
		$vurl=MODULE_NAME.'/'.CONTROLLER_NAME; 	
		$vurls=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$theme=config('theme');
		$this->view->config('view_path','./public/template/'.$theme.'/');   
		$netcon=config('netinfo');
		$this -> assign('netcon', $netcon);
		$titles='';
		if($vurl=='index/Index') $titles='首页';
		if($vurls=='index/Goods/goodslist') $titles='-产品商店';
		if($vurl=='index/Login') $titles='-登录';
		if($vurl=='index/Order') $titles='-我的订单';
		if($vurl=='index/Register') $titles='-注册';
		if($vurl=='index/Repwd') $titles='-修改密码';
		if($vurl=='index/User') $titles='-用户资料';
		if($vurl=='index/score') $titles='-我的积分';
		if($vurl=='index/UserAcard') $titles='-我的授权码';
		if($vurl=='index/UserCard') $titles='-我的充值卡';
		
		$this -> assign('titles', $titles);
		if($this->loginurl($vurl)){
			$loginurl=URL('/index/login');
			echo "<script type=\"text/javascript\">window.location.href='".$loginurl."';</script>";
			exit;
		}
		$seo=[
		        'title'=>'',
		        'keywords'=>'',
		        'description'=>'',
		    ];	
		$this -> assign('seo', $seo);		
		$loginuid=Session('uid');
		$scores='';
		if($loginuid){
			$userfn=new \app\common\controller\UserFn();			
			$scorename=$userfn->tradeType();
			if($scorename){
				$score=$userfn->getScore($loginuid);
				$score=ceil($score);
				$scores=$scorename.':'.$score;
			}
		    
		}
		$fns=new \app\common\controller\Fn();		
		$newarticle=$fns->newarticle(10);
		
		foreach($newarticle as $key=>$val){
			
			$sorts=$this->getsort($newarticle[$key]['id']);			
			$s = ('t' . rand(1, 20) . '.png');
			$newarticle[$key]['simgs'] = $s;
			$newarticle[$key]['urls']=URL('/index/article/index',['id'=>$newarticle[$key]['id']]);
			if($sorts){
				$newarticle[$key]['sort']=$sorts['sort_name'];
				$newarticle[$key]['sort_id']=$sorts['id'];
				$newarticle[$key]['menu_url']=$sorts['menu_url'];
			}else{
				$newarticle[$key]['sort']='未分类';
				$newarticle[$key]['sort_id']=1;
			}
			
			$newarticle[$key]['add_time']=time2date($newarticle[$key]['add_time']);		
		}
		$this->assign('newarticle',$newarticle);
		$this->assign('scores',$scores);		
		$auth = new \auth\Auth();		
		//$res=$this->authCheck($authName, $uid);
		$loginuser = Session::get('username');
		$loginuid = Session::get('uid');
		$loginstatus = Session::get('status');
				
		$this -> assign('loginuser', $loginuser);
		$this -> assign('loginuid', $loginuid);
		$body='page-theme';
		if(CONTROLLER_NAME=='Index'){
			$body='page-theme';
		}
		if(CONTROLLER_NAME=='GoodsList'){
			$body='page-theme';
		}
		if(CONTROLLER_NAME=='Goods'){
			$body='page-theme-item';
		}
		if(CONTROLLER_NAME=='Register'){
			$body='page-register';
		}
		if(CONTROLLER_NAME=='Login'){
			$body='page-login';
		}
		$fn=new \app\common\controller\Fn();
		$menu=$fn->getMenu();
		$this -> assign('menu', $menu);
		$menuname = Db::name('user_menu') -> where('controller', '/'.MODULE_NAME.'/'.CONTROLLER_NAME) -> value('name');		
		$this -> assign('menuname', $menuname);
		$menu1 = Db::name('user_menu') -> where('group',1)-> order('sort asc')->select();
		$menu2 = Db::name('user_menu') -> where('group',2)-> order('sort asc')->select();				
		$this -> assign('menu1', $menu1);
		$this -> assign('menu2', $menu2);						
        $this -> assign('body', $body);
		$titles='-rainpay';
		
		$this -> assign('titles', $titles);
    }


	public function alipayapi() {
        
		/* *
		 * 功能：即时到账交易接口接入页
		 * 版本：3.4
		 * 修改日期：2016-03*08
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

		 *************************注意*****************

		 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
		 *1、开发文档中心（https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.KvddfJ&treeId=62&articleId=103740&docType=1）
		 *2、商户帮助中心（https://cshall.alipay.com/enterprise/help_detail.htm?help_id=473888）
		 *3、支持中心（https://support.open.alipay.com/alipay/support/index.htm）

		 *如果想使用扩展功能,请按文档要求,自行添加到parameter数组即可。
		 **********************************************
		 */

		$alipay_config = config('rainpay_config');
		/**************************请求参数**************************/
		//商户订单号，商户网站订单系统中唯一订单号，必填
		$out_trade_no = $_POST['WIDout_trade_no'];

		//订单名称，必填
		$subject = $_POST['WIDsubject'];

		//付款金额，必填
		$total_fee = $_POST['WIDtotal_fee'];

		//商品描述，可空
		$body = $_POST['WIDbody'];
		$where=['id'=>$out_trade_no,'money'=>$total_fee,'trade_status'=>0];
        $ress=Db::name('order')->where($where)->find();
		if(!$ress){
			return '订单不正确！';
		}
		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array("service" => $alipay_config['service'], "partner" => $alipay_config['partner'], "seller_id" => $alipay_config['seller_id'], "payment_type" => $alipay_config['payment_type'], "notify_url" => $alipay_config['notify_url'], "return_url" => $alipay_config['return_url'], "anti_phishing_key" => $alipay_config['anti_phishing_key'], "exter_invoke_ip" => $alipay_config['exter_invoke_ip'], "out_trade_no" => $out_trade_no, "subject" => $subject, "total_fee" => $total_fee, "body" => $body, "_input_charset" => trim(strtolower($alipay_config['input_charset']))
		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
		//如"参数名"=>"参数值"

		);

		//建立请求
		$alipaySubmit = new \AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit -> buildRequestForm($parameter, "get", "确认");
		return $html_text;

	}

	public function notifyurl() {

		/* *
		 * 功能：支付宝服务器异步通知页面
		 * 版本：3.3
		 * 日期：2012-07-23
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

		 *************************页面功能说明*************************
		 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
		 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
		 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
		 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
		 */

		//计算得出通知验证结果
		$alipay_config = config('rainpay_config');
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify -> verifyNotify();

		if ($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no     = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
			//交易金额
			$total_fee    = $_POST['total_fee'];
            //sellerid
            $seller_id    = $alipay_config['seller_id'];
            $payfn=new Payfn();
		    
		    			
			if($_POST['trade_status'] == 'TRADE_FINISHED'){
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
				//如果有做过处理，不执行商户的业务程序
                $msgs=$payfn->orderstatus($out_trade_no,$trade_no,$total_fee);
				if($msgs=='success'){
				    $payfn->sendgoods($out_trade_no);	
				}
                
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			} else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
				//如果有做过处理，不执行商户的业务程序
                $msgs=$payfn->orderstatus($out_trade_no,$trade_no,$total_fee);
				if($msgs=='success'){
				    $payfn->sendgoods($out_trade_no);	
				}
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知

				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
							    

			echo "success";
			//请不要修改或删除

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else {
			//验证失败
			echo "fail";

			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}

	}

	public function returnurl() {
        $alipay_config = config('rainpay_config');
		//计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify -> verifyReturn();		
		$order='';
		$this -> assign('loginuid', Session::get('uid'));
		$this -> assign('loginuser', Session::get('username'));
		$this -> assign('body', 'page-theme');
        
		if ($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
           
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号

			$out_trade_no = $_GET['out_trade_no'];

			//支付宝交易号

			$trade_no = $_GET['trade_no'];

			//交易状态
			$trade_status = $_GET['trade_status'];
            $order=Db::name('order')->where('id',$out_trade_no)->find();
			$order['time']=date('Y-m-d H:i:s',$order['date']);
			$this -> assign('order', $order);
			
			if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				
				$trade_status="trade_status=" . $_GET['trade_status'];
				$this -> assign('statu', '交易成功');				
				$this -> assign('trade_status', $trade_status);
		        return $this -> fetch();
			} else {
				
				$trade_status="trade_status=" . $_GET['trade_status'];
				$this -> assign('order', $order);
				$this -> assign('trade_status', $trade_status);
		        return $this -> fetch();
				
			}
			
                $trade_status="验证成功<br />";
				$this -> assign('order', $order);
				$this -> assign('trade_status', $trade_status);
		        return $this -> fetch();
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else {
			
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			$trade_status="验证失败";
			$this -> assign('order', $order);
			$this -> assign('trade_status', $trade_status);
		    return $this -> fetch();
		}

	}
    public function loginurl($vurl) {
		if(!session('?username')){
			$arrdate = array(
			    'index/User',
			    'index/Repwd',
			    'index/UserGoods',
			    'index/Order',
			);
		    return in_array($vurl,$arrdate);						
		}else{
			return FALSE;
		}
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

}
