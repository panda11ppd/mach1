<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
use think\Db;
use think\Request;
use auth;
class Ueditor extends controller {
	public function _initialize() {
		$request = Request::instance();
		$module_name=$request->module();
		$controller_name=$request->controller();
		$action_name=$request->action();	    
		$loginuid=Session('uid');
		$authName=$module_name.'/'.$controller_name.'/'.$action_name;		
		$auth = new \auth\Auth();
		$res=$auth -> check(strtolower($authName), $loginuid);
		if($loginuid==1){
			$res=TRUE;
		}		
		if($res==FALSE){
			$this->error('没有访问权限');
			exit;
		}
		vendor('ueditor.Uploader');
	}
    /**
    * @cc 百度编辑器权限
    *    
    */
	public function index() {
		//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
		//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
		date_default_timezone_set("Asia/chongqing");
		error_reporting(E_ERROR);
		header("Content-Type: text/html; charset=utf-8");

		$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./public/ueditor/php/config.json")), true);
		$CONFIG["imagePathFormat"]=get_root()."/public/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}";
		$CONFIG["scrawlPathFormat"]=get_root()."/public/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}";
		$CONFIG["snapscreenPathFormat"]=get_root()."/public/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}";
		$CONFIG["catcherPathFormat"]=get_root()."/public/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}";
		$CONFIG["videoPathFormat"]=get_root()."/public/uploads/video/{yyyy}{mm}{dd}/{time}{rand:6}";
		$CONFIG["filePathFormat"]=get_root()."/public/uploads/file/{yyyy}{mm}{dd}/{time}{rand:6}";		
		$CONFIG["imageManagerListPath"]=get_root()."/public/uploads/image/";
		$CONFIG["fileManagerListPath"]=get_root()."/public/uploads/file/";		
		//var_dump($CONFIG["imagePathFormat"]);
		$action = $_GET['action'];

		switch ($action) {
			case 'config' :
				$result = json_encode($CONFIG);
				break;
			/* 上传图片 */
			case 'uploadimage' :
			/* 上传涂鸦 */
			case 'uploadscrawl' :
			/* 上传视频 */
			case 'uploadvideo' :
			/* 上传文件 */
			case 'uploadfile' :
				$result = $this->upload($CONFIG,input('get.'),input('post.'));
				//include ("action_upload.php");
				break;

			/* 列出图片 */
			case 'listimage' :
				$result = $this->lists($CONFIG,input('get.'),input('post.'));
				//include ("action_list.php");
				break;
			/* 列出文件 */
			case 'listfile' :
				$result = $this->lists($CONFIG,input('get.'),input('post.'));
				//include ("action_list.php");
				break;

			/* 抓取远程文件 */
			case 'catchimage' :
				$result = $this->crawler($CONFIG,input('get.'),input('post.'));
				//include ("action_crawler.php");
				break;

			default :
				$result = json_encode(array('state' => '请求地址出错'));
				break;
		}

		/* 输出结果 */
		if (isset($_GET["callback"])) {
			if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
				echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
			} else {
				echo json_encode(array('state' => 'callback参数不合法'));
			}
		} else {
			echo $result;
		}
	}

	protected function crawler($CONFIG,$isget,$ispost) {

		set_time_limit(0);
		//include ("Uploader.class.php");

		/* 上传配置 */
		$config = array("pathFormat" => $CONFIG['catcherPathFormat'], "maxSize" => $CONFIG['catcherMaxSize'], "allowFiles" => $CONFIG['catcherAllowFiles'], "oriName" => "remote.png");
		$fieldName = $CONFIG['catcherFieldName'];

		/* 抓取远程图片 */
		$list = array();
		if (isset($ispost['fieldName'])) {
			$source = $ispost['fieldName'];
		} else {
			$source = $isget['fieldName'];
		}
		foreach ($source as $imgUrl) {
			$item = new \Uploader($imgUrl, $config, "remote");
			$info = $item -> getFileInfo();
			array_push($list, array("state" => $info["state"], "url" => $info["url"], "size" => $info["size"], "title" => htmlspecialchars($info["title"]), "original" => htmlspecialchars($info["original"]), "source" => htmlspecialchars($imgUrl)));
		}

		/* 返回抓取数据 */
		return json_encode(array('state' => count($list) ? 'SUCCESS' : 'ERROR', 'list' => $list));
	}

	protected function lists($CONFIG,$isget,$ispost) {
		/**
		 * 获取已上传的文件列表
		 * User: Jinqn
		 * Date: 14-04-09
		 * Time: 上午10:17
		 */
		//include "Uploader.class.php";

		/* 判断类型 */
		switch ($isget['action']) {
			/* 列出文件 */
			case 'listfile' :
				$allowFiles = $CONFIG['fileManagerAllowFiles'];
				$listSize = $CONFIG['fileManagerListSize'];
				$path = $CONFIG['fileManagerListPath'];
				break;
			/* 列出图片 */
			case 'listimage' :
			default :
				$allowFiles = $CONFIG['imageManagerAllowFiles'];
				$listSize = $CONFIG['imageManagerListSize'];
				$path = $CONFIG['imageManagerListPath'];
		}
		$allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

		/* 获取参数 */
		$size = isset($isget['size']) ? $isget['size'] : $listSize;
		$start = isset($isget['start']) ? $isget['start'] : 0;
		$end = $start + $size;

		/* 获取文件列表 */
		$path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
		$files = getfiles($path, $allowFiles);
		if (!count($files)) {
			return json_encode(array("state" => "no match file", "list" => array(), "start" => $start, "total" => count($files)));
		}

		/* 获取指定范围的列表 */
		$len = count($files);
		for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
			$list[] = $files[$i];
		}
		//倒序
		//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
		//    $list[] = $files[$i];
		//}

		/* 返回数据 */
		$result = json_encode(array("state" => "SUCCESS", "list" => $list, "start" => $start, "total" => count($files)));

		return $result;

	}

	protected function upload($CONFIG,$isget,$ispost) {
		/**
		 * 上传附件和上传视频
		 * User: Jinqn
		 * Date: 14-04-09
		 * Time: 上午10:17
		 */
		//include "Uploader.class.php";

		/* 上传配置 */
		$base64 = "upload";
		switch (htmlspecialchars($isget['action'])) {
			case 'uploadimage' :
				$config = array("pathFormat" => $CONFIG['imagePathFormat'], "maxSize" => $CONFIG['imageMaxSize'], "allowFiles" => $CONFIG['imageAllowFiles']);
				$fieldName = $CONFIG['imageFieldName'];
				break;
			case 'uploadscrawl' :
				$config = array("pathFormat" => $CONFIG['scrawlPathFormat'], "maxSize" => $CONFIG['scrawlMaxSize'], "allowFiles" => $CONFIG['scrawlAllowFiles'], "oriName" => "scrawl.png");
				$fieldName = $CONFIG['scrawlFieldName'];
				$base64 = "base64";
				break;
			case 'uploadvideo' :
				$config = array("pathFormat" => $CONFIG['videoPathFormat'], "maxSize" => $CONFIG['videoMaxSize'], "allowFiles" => $CONFIG['videoAllowFiles']);
				$fieldName = $CONFIG['videoFieldName'];
				break;
			case 'uploadfile' :
			default :
				$config = array("pathFormat" => $CONFIG['filePathFormat'], "maxSize" => $CONFIG['fileMaxSize'], "allowFiles" => $CONFIG['fileAllowFiles']);
				$fieldName = $CONFIG['fileFieldName'];
				break;
		}

		/* 生成上传实例对象并完成上传 */
		$up = new \Uploader($fieldName, $config, $base64);

		/**
		 * 得到上传文件所对应的各个参数,数组结构
		 * array(
		 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
		 *     "url" => "",            //返回的地址
		 *     "title" => "",          //新文件名
		 *     "original" => "",       //原始文件名
		 *     "type" => ""            //文件类型
		 *     "size" => "",           //文件大小
		 * )
		 */

		/* 返回数据 */
		return json_encode($up -> getFileInfo());

	}

}
