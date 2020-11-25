<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\install\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 安装模块
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Update extends Table
{
    /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {
        // 检测程序安装
        if (!is_file(APP_PATH . 'install/data/install.lock')) {
            echo '程序未安装，请先安装！';
            exit();
        }
    }

    /**
     * 安装模块默认方法
     * 前提:安装协议
     * @author tangtanglove
     */
    public function index()
    {
    	
		return $this->fetch();
    }
    public function update()
    {
    	if(input('?get.datapwd')){
    		$dbconfig=config('database');
			$db = Db::connect($dbconfig);			
    	}
		if(input('get.datapwd') != $dbconfig['password']){
			return '数据库密码错误！';
		}else{
			up_tables($db,config('database.prefix'));
			$this->cTable(config('database.prefix'));			
			copy_config(config('upfile'));
		}
		
    }
    public function cTable($prefix)//创建表
    {
    	
    	$table=[
    	    $prefix.'acard'=>'id',
    	    $prefix.'admin_menu'=>'id',
    	    $prefix.'agents'=>'id',
    	    $prefix.'agents_goods'=>'id',
    	    $prefix.'agents_type'=>'id',
    	    $prefix.'api_token'=>'uid',
    	    $prefix.'app'=>'appid',
    	    $prefix.'article'=>'id',
    	    $prefix.'article_relation'=>'id',			
    	    $prefix.'auth_group'=>'id',
    	    $prefix.'auth_group_access'=>'uid',
    	    $prefix.'auth_rule'=>'id',
    	    $prefix.'card'=>'id',
    	    $prefix.'card_type'=>'id',
    	    $prefix.'file'=>'id',
    	    $prefix.'file_user'=>'id',
    	    $prefix.'goods'=>'goods_id',
    	    $prefix.'log'=>'id',
    	    $prefix.'member'=>'uid',
    	    $prefix.'menu'=>'id',
    	    $prefix.'money'=>'id',
    	    $prefix.'order'=>'id',
    	    $prefix.'score_config'=>'id',
    	    $prefix.'score_record'=>'id',
    	    $prefix.'sort'=>'id',
    	    $prefix.'user_app'=>'uid',
    	    $prefix.'user_goods'=>'id',
    	    $prefix.'user_menu'=>'id',    	    
    	    $prefix.'userinfo'=>'id'
    	];
		$field=[
    	    $prefix.'acard'=>
 "`acard_number` varchar(255) DEFAULT NULL;
  `uid` int(11) DEFAULT NULL;
  `appid` varchar(255) DEFAULT NULL;
  `order_id` int(3) DEFAULT NULL;
  `create_time` int(11) DEFAULT NULL;
  `active_time` int(11) DEFAULT '0';
  `expire_time` int(6) DEFAULT NULL;
  `sales_time` int(11) DEFAULT NULL;
  `status` int(11) DEFAULT '1';
  `fee_count` int(6) DEFAULT '0';
  `loginip` varchar(255) DEFAULT NULL;
  `logintime` int(6) DEFAULT NULL;
  `bind` int(11) DEFAULT '0' COMMENT '绑定类弄 0:不绑定 1机器码 2:ip 3:1和2';
  `bind_mcode` varchar(255) DEFAULT NULL;
  `bind_ip` varchar(255) DEFAULT NULL;
  `bind_count` int(11) DEFAULT '5';
  `sales_status` int(11) DEFAULT '0';
  `agent_uid` int(11) NOT NULL DEFAULT '0'",
    	    $prefix.'admin_menu'=>
 "`menu_sort` int(11) DEFAULT NULL;
  `menu_name` varchar(255) DEFAULT NULL;
  `tabs` varchar(255) DEFAULT NULL;
  `menu_url` varchar(255) DEFAULT NULL;
  `menu_icon` varchar(255) DEFAULT NULL;
  `menu_types` varchar(255) NOT NULL DEFAULT 'left';
  `menu_levelid` int(11) DEFAULT NULL;
  `status` int(11) NOT NULL DEFAULT '1'",
            $prefix.'agents'=>
 "`uid` int(11) NOT NULL DEFAULT '1';
  `type` int(11) NOT NULL DEFAULT '1';
  `parent_uid` int(11) NOT NULL DEFAULT '1';
  `add_time` int(11) NOT NULL DEFAULT '0';
  `status` int(11) NOT NULL DEFAULT '1';
  `conscore` int(11) NOT NULL DEFAULT '0';
  `login_ip` varchar(20) NOT NULL DEFAULT '1.1.1.1';
  `login_time` int(11) NOT NULL DEFAULT '0';
  `login_count` int(11) NOT NULL DEFAULT '1'",
            $prefix.'agents_goods'=>
 "`uid` int(11) NOT NULL DEFAULT '1';
  `goods_id` int(11) NOT NULL DEFAULT '0';
  `add_time` int(11) NOT NULL DEFAULT '0';
  `status` int(11) NOT NULL DEFAULT '0'",
            $prefix.'agents_type'=>
            "`name` varchar(255) DEFAULT NULL;
  `discount` int(2) NOT NULL DEFAULT '80';
  `min_score` int(11) NOT NULL DEFAULT '0'",
            
    	    $prefix.'api_token'=>
    	        "`token` varchar(32) DEFAULT NULL COMMENT '令牌';
                `op_time` int(6) DEFAULT NULL COMMENT '操作时间'",
    	    $prefix.'app'=>
    	        "`appid` int(11) NOT NULL AUTO_INCREMENT;
  `app_name` varchar(255) DEFAULT NULL;
  `app_key` varchar(255) DEFAULT 'rain68';
  `app_status` int(11) DEFAULT '1';
  `create_time` varchar(255) DEFAULT NULL;
  `update_time` int(6) DEFAULT NULL;
  `free` int(11) DEFAULT NULL;
  `test_time` int(11) NOT NULL DEFAULT '0';
  `acard_time` int(11) NOT NULL DEFAULT '0';
  `app_bind` int(11) DEFAULT NULL;
  `type` int(11) DEFAULT NULL;
  `index_show` int(1) DEFAULT '1';
  `app_data` varchar(1000) DEFAULT NULL;
  `announcement` varchar(1000) DEFAULT NULL;
  `version` varchar(255) DEFAULT NULL;
  `down_url` varchar(255) DEFAULT NULL",
            $prefix.'article'=> 
                "`title` text,
                 `content` longtext,
                 `keyword` varchar(255) DEFAULT NULL;
                 `author` varchar(255) NOT NULL DEFAULT 'admin';
                 `hits` int(11) NOT NULL DEFAULT '0';
                 `post_num` int(11) NOT NULL DEFAULT '0';
                 `ontop` int(11) NOT NULL DEFAULT '0';
                 `iselite` int(11) NOT NULL DEFAULT '0';
                 `status` int(11) NOT NULL DEFAULT '1';
                 `add_time` int(11) NOT NULL DEFAULT '0';
                 `update_time` int(11) NOT NULL DEFAULT '0';
                 `thumb_img` varchar(255) DEFAULT NULL;
                 `html_status` int(11) DEFAULT '0'", 
            $prefix.'article_relation'=> 
                "`article_id` int(11) NOT NULL DEFAULT '0';
                `sort_id` int(11) NOT NULL DEFAULT '1';
                `comment_id` int(11) NOT NULL DEFAULT '0'",                      
    	    $prefix.'auth_group'=>
    	        "`title` char(100) NOT NULL DEFAULT '';
                 `description` varchar(255) DEFAULT NULL;
                 `status` tinyint(1) NOT NULL DEFAULT '1';
                 `rules` varchar(500) NOT NULL DEFAULT ''",
    	    $prefix.'auth_group_access'=>
    	        "`group_id` mediumint(8) unsigned NOT NULL",
    	    $prefix.'auth_rule'=>
    	        "`name` char(80) NOT NULL DEFAULT '';
                `title` varchar(255) NOT NULL DEFAULT '';
                `type` tinyint(1) NOT NULL DEFAULT '1';
                `status` tinyint(1) NOT NULL DEFAULT '1';
                `condition` char(100) NOT NULL DEFAULT '';
                `cond` char(100) NOT NULL DEFAULT '';
                `group` varchar(11) DEFAULT NULL",
    	    $prefix.'card'=>
    	        "`card_number` varchar(255) DEFAULT NULL;
                `uid` int(11) DEFAULT NULL;
                `use_uid` int(3) DEFAULT NULL;
                `appid` int(11) NOT NULL DEFAULT '0';
                `order_id` int(3) DEFAULT NULL;
                `create_time` int(6) NOT NULL DEFAULT '0';
                `sales_time` int(6) NOT NULL DEFAULT '0';
                `type` int(11) NOT NULL DEFAULT '0';
                `sales_status` int(2) NOT NULL DEFAULT '0';
                `status` int(11) NOT NULL DEFAULT '1';
                `agent_uid` int(11) NOT NULL DEFAULT '0'",  	   
    	    $prefix.'card_type'=>
    	        "`name` varchar(255) NOT NULL DEFAULT '';
                `day` int(11) NOT NULL DEFAULT '0';
                `status` int(11) NOT NULL DEFAULT '1';
                `create_time` int(11) NOT NULL DEFAULT '0';
                `explain` varchar(255) DEFAULT NULL",
    	    $prefix.'file'=>
    	        "`file_title` varchar(255) DEFAULT NULL;
                  `bind_id` int(11) NOT NULL DEFAULT '0';
                  `fee_body` varchar(255) DEFAULT NULL;
                  `down_url` varchar(255) DEFAULT NULL;
                  `price` decimal(10,2) NOT NULL DEFAULT '0.00';
                  `down_count` int(11) NOT NULL DEFAULT '0'",                
    	    $prefix.'file_user'=>
    	        "`uid` int(11) NOT NULL DEFAULT '1';
                  `file_id` int(11) DEFAULT NULL;
                 `buy_time` bigint(20) NOT NULL DEFAULT '0'",                   
    	    $prefix.'goods'=>
    	        "`title` varchar(255) DEFAULT NULL;
                `stitle` varchar(255) DEFAULT NULL;
                `appid` int(3) NOT NULL DEFAULT '1';
                `expimg` varchar(255) DEFAULT NULL;
                `help` text;
                `fns` text;
                `uptext` text;
                `copyright` varchar(255) DEFAULT NULL;
                `imgs` varchar(255) DEFAULT NULL;
                `count` int(3) NOT NULL DEFAULT '0';
                `create_time` int(6) DEFAULT NULL;
                `status` int(11) NOT NULL DEFAULT '1';
                `down_url` varchar(255) DEFAULT NULL;
                `buy_count` int(11) NOT NULL DEFAULT '0';
                `agent_status` int(11) NOT NULL DEFAULT '1'",
            $prefix.'log'=>
                " `log` varchar(255) DEFAULT NULL",    
    	    $prefix.'member'=>
    	        "`name` varchar(32) NOT NULL DEFAULT '';
                `password` varchar(32) NOT NULL DEFAULT '';
                `status` int(11) NOT NULL DEFAULT '1';
                `email` varchar(255) DEFAULT NULL;
                `logintime` int(1) DEFAULT NULL COMMENT '最后一次登录时间';
                `lastlogintime` int(1) DEFAULT NULL;
                `logincount` int(9) NOT NULL DEFAULT '0' COMMENT '登录次数';
                 `createtime` int(1) DEFAULT NULL COMMENT '创建时间';
                 `loginip` varchar(255) NOT NULL DEFAULT '' COMMENT '登录IP';
                 `lastloginip` varchar(255) DEFAULT NULL;
                 `usergroup` varchar(255) NOT NULL DEFAULT '';
                 `score` decimal(10,2) NOT NULL DEFAULT '0.00';
                 `comments` varchar(500) DEFAULT NULL",
            $prefix.'menu'=>
                "`sorting` int(11) NOT NULL DEFAULT '1';
                `name` varchar(255) DEFAULT NULL;
                `menu_url` varchar(255) DEFAULT NULL;
                `description` varchar(255) DEFAULT NULL;
                `type` varchar(255) DEFAULT NULL;
                `pid` int(11) NOT NULL DEFAULT '0';
                `status` int(11) NOT NULL DEFAULT '1';
                `bind_id` int(11) NOT NULL DEFAULT '0'",     
    	    $prefix.'money'=>
    	        "`goods_id` int(3) DEFAULT NULL;
                 `typeid` int(11) DEFAULT NULL;
                  `money` decimal(10,2) DEFAULT NULL",
    	    $prefix.'order'=>
    	        "`trade_no` varchar(255) DEFAULT NULL;
                  `name` varchar(255) DEFAULT NULL;
                  `sname` varchar(255) DEFAULT NULL;
                  `money` decimal(10,2) NOT NULL DEFAULT '0.00';
                  `umoney` decimal(10,2) NOT NULL DEFAULT '0.00';
                  `date` int(6) NOT NULL DEFAULT '0';
                  `body` varchar(255) DEFAULT NULL;
                  `uid` int(11) DEFAULT '0';
                  `goods_id` int(11) NOT NULL DEFAULT '0';
                  `typeid` int(11) NOT NULL DEFAULT '0';
                  `num` int(11) NOT NULL DEFAULT '1';
                  `goods_type` int(11) NOT NULL DEFAULT '1';
                  `trade_status` int(11) NOT NULL DEFAULT '0' COMMENT '0未完成，1成功'",
    	    $prefix.'score_config'=>
    	        "`name` varchar(255) DEFAULT NULL;
                `comments` varchar(255) DEFAULT NULL;
                `status` int(11) NOT NULL DEFAULT '1';
                `exchange` int(11) NOT NULL DEFAULT '1';
                `newuser_score` int(11) NOT NULL DEFAULT '0';
                `min_full` int(11) NOT NULL DEFAULT '1",
    	    $prefix.'score_record'=>
    	        "`id` int(11) NOT NULL AUTO_INCREMENT;
                 `uid` int(11) NOT NULL DEFAULT '0';
                 `score_plus` int(11) NOT NULL DEFAULT '0';
                 `score_minus` int(11) NOT NULL DEFAULT '0';
                  `date` int(11) NOT NULL DEFAULT '0';
                 `score` int(11) DEFAULT '0';
                 `body` varchar(255) DEFAULT NULL",
    	    $prefix.'sort'=>
    	         "`sort_name` varchar(255) DEFAULT NULL;
                  `description` varchar(255) DEFAULT NULL;
                  `sorts` int(11) NOT NULL DEFAULT '0';
                  `parent_id` int(11) NOT NULL DEFAULT '0';
                  `status` int(11) NOT NULL DEFAULT '1'",                                
    	    $prefix.'userinfo'=>
    	        "`uid` int(11) NOT NULL DEFAULT '0';
                  `qq` varchar(16) DEFAULT NULL;
                  `tel` varchar(16) DEFAULT NULL;
                  `alipayid` varchar(255) DEFAULT NULL;
                  `email` varchar(255) DEFAULT NULL;
                  `balance` decimal(10,2) DEFAULT '0.00'",
    	    $prefix.'user_app'=>
    	        "`appid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '软件id';
                  `active_time` int(6) DEFAULT NULL;
                  `expire_time` int(6) DEFAULT NULL;
                  `status` int(11) DEFAULT '1';
                  `fee_count` int(6) DEFAULT '0';
                  `loginip` varchar(255) DEFAULT NULL;
                  `bind` int(11) DEFAULT '0' COMMENT '绑定类弄 0:不绑定 1机器码 2:ip 3:1和2';
                  `bind_mcode` varchar(255) DEFAULT NULL;
                  `bind_ip` varchar(255) DEFAULT NULL;
                  `user_data` varchar(255) DEFAULT NULL;
                  `bind_count` int(11) DEFAULT '5'",
    	    $prefix.'user_goods'=>
    	        "`uid` int(11) DEFAULT NULL;
                  `order_id` int(6) DEFAULT NULL;
                  `type` varchar(255) DEFAULT NULL;
                  `name` varchar(255) DEFAULT NULL;
                  `body` varchar(255) DEFAULT NULL;
                  `money` decimal(10,2) DEFAULT NULL;
                  `time` int(11) DEFAULT NULL;
                  `num` int(11) DEFAULT '1'",
    	    $prefix.'user_menu'=>
    	        "`sort` int(11) NOT NULL DEFAULT '1';
                  `name` varchar(255) DEFAULT NULL;
                  `controller` varchar(255) DEFAULT NULL;
                  `url` varchar(255) DEFAULT NULL;
                  `group` int(11) NOT NULL DEFAULT '1'"
    	];
		
		foreach($table as $key=>$val){
			$this->createTable($key,$val);
			$batarr=$field[$key];
			$bats=explode(';',$batarr);
			
			
			foreach($bats as $k=>$v){
				preg_match('`\w+`',$v,$match);				
				if(!$this->checkField($key,$match[0])){
					$this->addbat($key,$v);
				}
			
			}
            echo '<p>升级表---------'.$key.'..........[成功]</p>'; 
		}
		
		$this->editbat($prefix.'acard','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');	
    	$this->editbat($prefix.'auth_group','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');
    	$this->editbat($prefix.'auth_group_access','`uid` mediumint(8) unsigned NOT NULL');	
    	$this->editbat($prefix.'auth_rule','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');	
    	$this->editbat($prefix.'user_app','`uid` mediumint(8) unsigned NOT NULL DEFAULT \'0\'');
    	$this->editbat($prefix.'agents','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');
    	$this->editbat($prefix.'agents_goods','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');
		$this->editbat($prefix.'agents_type','`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT');		
    	
		echo '升级成功！';
    }
	
    

}
