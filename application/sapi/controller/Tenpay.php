<?php
namespace app\sapi\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\common\controller\UserFn;

class Tenpay extends controller {

	public function index() {
		$key = $_POST["key"];
		//对接key
		$title = $_POST["uid"];
		//用户UID
		$amount = $_POST["source"];
		//充值积分数
		$content = $_POST["content"];
		//备注
		$time = date("Y-m-d", time());
		//充值时间
		if ($key == config('netinfo.key')) {
			$userfn = new UserFn();
			$scorecon = $userfn -> scoreconfig();
			$incscore = $amount * $scorecon['exchange'];
			$score = floor($incscore);
			$inscore = $userfn -> incScore($title, $incscore);
			if ($inscore) {
				$userfn -> scorerecord($title, 'plus', $incscore, 'Visa:' . $content);
				return "ok";
			} else {
				return 'uid_error';
			}

		}else{
			return "充值积分失败！";
		}

	}

}
