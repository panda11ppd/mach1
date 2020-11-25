<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use think\Db;


class User extends Base
{
 
    public function index()
    {        
        $createtime=Db::name('member')->where('uid',Session::get('uid'))->value('createtime');
        $createtime=date('Y-m-d H:i:s', $createtime);
        $this -> assign('createtime', $createtime);	
        return $this->fetch();
    }
    
}

