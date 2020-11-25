<?php
namespace app\ capi\ controller;
use think\ Session;
use think\ Controller;
use think\ Db;
use app\ common\ controller\ Opconfig;


class Recharge extends controller {
    public function index() { //充值
        $opconfig = new Opconfig();
        if (input('?get.data') && input('get.data')) {
            $getdata = input('get.data');
            $json_arr = $opconfig -> jsonop($getdata, 'de');
            if ($json_arr == 'error') {
                $resdata = ['code' => 444, 'message' => 'error','content'=>'提交数据有误'];
                return $opconfig -> jsonop($resdata, 'en');
            }
            if(isset($json_arr['username'])){
            	 $username = $json_arr['username'];
            }else{
            	$username=null;
            }
            if(isset($json_arr['acard'])){
            	$acard = $json_arr['acard'];
            }else{
            	$acard=null;
            }
            if(isset($json_arr['card'])){
            	$cardnumber = $json_arr['card'];
            }else{
            	$cardnumber=null;
            }
            if(isset($json_arr['appid'])){
            	$appid = $json_arr['appid'];
            }else{
            	$appid=null;
            }                                   
            if ($username) {
                if ($cardnumber == null || $appid == null) {
                    $resdata = ['code' => 471, 'message' => 'error','content'=>'充值卡或应用ID不能为空'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $uid = Db::name('member') -> where('name', $username) -> value('uid');
                if (!$uid) {
                    $resdata = ['code' => 472, 'message' => 'error','content'=>'用户不存在'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $card = Db::name('card') -> where('card_number', $cardnumber) -> where('appid', $appid) -> find();
                if (!$card) {
                    $resdata = ['code' => 473, 'message' => 'error','content'=>'充值卡不存在'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                if($card['status'] < 1) {
                    $resdata = ['code' => 474, 'message' => 'error','content'=>'充值卡已停用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }               
               
                if($card['sales_status']==2){
                	$resdata = ['code' => 477, 'message' => 'error','content'=>'充值卡已被使用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $userapp=Db::name('user_app') -> where('uid', $uid) -> where('appid', $appid)->find();
                if(!$userapp){
                	$resdata = ['code' => 476, 'message' => 'error','content'=>'用户未激活应用,请先登录后自动激活'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                if($userapp['status'] < 1){
                	$resdata = ['code' => 478, 'message' => 'error','content'=>'用户被管理员停用此应用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }               
                $day=Db::name('card_type')->where('id',$card['type'])->value('day');
                if(empty($day)){
                	$resdata = ['code' => 475, 'message' => 'error','content'=>'卡天数错误,请联系管理员'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                
                if($userapp['expire_time'] >= time()){
                	$daytime = (86400 * $day + $userapp['expire_time']); 
                }else{
                	$daytime = (86400 * $day + time());
                }                               
                Db::name('card') -> where('card_number', $cardnumber) -> where('appid', $appid) -> update(['use_uid'=>$uid, 'sales_time'=>time(),'sales_status'=>2]);
                Db::name('user_app') -> where('uid', $uid) -> where('appid', $appid) -> setField('expire_time',$daytime);
                Db::name('user_app') -> where('uid', $uid) -> where('appid', $appid) -> setInc('fee_count');               
                $ress = ['username' => $username, 'appid' => $appid,'day'=>$day];
                $resdata=['data' => $ress, 'code' => 9, 'message' => 'success','content'=>'充值成功'];
                return $opconfig -> jsonop($resdata, 'en');
            }           
            if ($acard) {
                if ($cardnumber == null || $appid == null) {
                    $resdata = ['code' => 481, 'message' => 'error','content'=>'充值卡号与应用ID不能为空'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $acarddb=Db::name('acard') -> where('acard_number', $acard) -> where('appid', $appid)->find();
                if (!$acarddb['id']) {
                    $resdata = ['code' => 482, 'message' => 'error','content'=>'授权不存在'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $card = Db::name('card') -> where('card_number', $cardnumber) -> where('appid', $appid) -> find();
                if (!$card) {
                    $resdata = ['code' => 483, 'message' => 'error','content'=>'充值卡不存在'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                if($card['status'] < 1) {
                    $resdata = ['code' => 484, 'message' => 'error','content'=>'充值卡已停用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }
                $uid=$acarddb['uid'];               
                if($card['sales_status']==2){
                	$resdata = ['code' => 487, 'message' => 'error','content'=>'充值卡已被使用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }               
               
                if($acarddb['status'] < 1){
                	$resdata = ['code' => 488, 'message' => 'error','content'=>'授权已被管理员停用'];
                    return $opconfig -> jsonop($resdata, 'en');
                }               
                $day=Db::name('card_type')->where('id',$card['type'])->value('day');
                if(empty($day)){
                	$resdata = ['code' => 485, 'message' => 'error','content'=>'充值卡类天数错误,请联系管理员'];
                    return $opconfig -> jsonop($resdata, 'en');
                }             
                if($acarddb['expire_time'] >= time()){
                	$daytime = (86400 * $day + $acarddb['expire_time']); 
                }else{
                	$daytime = (86400 * $day + time());
                }
                if($acarddb['active_time'] < 1 || $acarddb['active_time']==null){
                	Db::name('acard') -> where('acard_number', $acard) -> where('appid', $appid) ->update(['active_time'=>time()]);
					$initday=Db::name('app')->where('appid',$appid)->value('acard_day');
					$daytime = (86400 * ($day+$initday) + time());
				    Db::name('acard') -> where('acard_number', $acard) -> where('appid', $appid) -> setField('expire_time',$daytime);
                }else{
                	Db::name('acard') -> where('acard_number', $acard) -> where('appid', $appid) -> setField('expire_time',$daytime);
                }
                $salestime=time();                           
                Db::name('card') -> where('card_number', $cardnumber) -> where('appid', $appid) -> update(['uid'=>$uid,'sales_time'=>$salestime,'sales_status'=>2]);
                Db::name('acard') -> where('acard_number', $acard) -> where('appid', $appid) -> setInc('fee_count');               
                $ress = ['day'=>$day];
                $resdata=['data' => $ress, 'code' => 9, 'message' => 'success','content'=>'充值成功'];
                return $opconfig -> jsonop($resdata, 'en');
            }else{
            	$resdata = ['code' => 480, 'message' => 'error','content'=>'充值类型错误'];
                return $opconfig -> jsonop($resdata, 'en');
            }
        } else {
            $resdata = ['code' => 480, 'message' => 'error','content'=>'基础数据错误'];
            return $opconfig -> jsonop($resdata, 'en');
        }


    }
}