
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `rain_acard`;
CREATE TABLE `rain_acard` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `acard_number` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `order_id` int(3) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `active_time` int(11) DEFAULT '0',
  `expire_time` int(6) DEFAULT NULL,
  `sales_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `fee_count` int(6) DEFAULT '0',
  `loginip` varchar(255) DEFAULT NULL,
  `logintime` int(6) DEFAULT NULL,
  `bind` int(11) DEFAULT '0' COMMENT '绑定类弄 0:不绑定 1机器码 2:ip 3:1和2',
  `bind_mcode` varchar(255) DEFAULT NULL,
  `bind_ip` varchar(255) DEFAULT NULL,
  `bind_count` int(11) DEFAULT '5',
  `sales_status` int(11) DEFAULT '0',
  `agent_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`acard_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


DROP TABLE IF EXISTS `rain_admin_menu`;
CREATE TABLE `rain_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_sort` int(11) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `tabs` varchar(255) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `menu_types` varchar(255) NOT NULL DEFAULT 'left',
  `menu_levelid` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1886 DEFAULT CHARSET=utf8;


INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1','1','系统','system','','fa fa-gear','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('8','8','应用(APP)','app','','fa fa-clone','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('10','11','网站设置','','admin/netset/index','glyphicon glyphicon-cog','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('12','14','数据备份','','admin/netset/bak','fa fa-database','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('13','91','用户管理','','admin/user/index','glyphicon glyphicon glyphicon-user','left','9','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('15','81','应用设置','','admin/app/index','glyphicon glyphicon-tasks','left','8','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('16','85','授权卡','','admin/acard/index','fa fa-address-card-o','left','8','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('53','53','菜单','','admin/menu/index','fa fa-maxcdn','left','5','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('101','86','充值卡','','admin/card/index','fa fa-credit-card','left','8','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('3','3','文章','article','','fa fa-edit','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('103','777','支付帐单','','admin/order/index','fa fa-yen','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('104','888','支付设置','','admin/pay/index','fa fa-paypal','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('105','88','应用销售','','admin/goods/index','fa fa-shopping-cart','left','8','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('106','31','文章列表','','admin/article/index','glyphicon glyphicon-list','left','3','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('107','32','撰写文章','','admin/article/add','glyphicon glyphicon-pencil','left','3','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('108','33','分类目录','','admin/article/sorts','glyphicon glyphicon-folder-open','left','3','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('9','9','用户','auth','','fa fa-gears','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('109','92','用户组管','','admin/authgroup/index','fa fa-users','left','9','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('110','93','权限节点','','admin/authrule/index','fa fa-connectdevelop','left','9','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('5','5','外观','ui','','fa fa-th-large','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('52','52','模板主题','','admin/theme/index','fa fa-window-restore','left','5','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('18','18','积分设置','','admin/score/index','fa fa-scribd','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('54','54','评论设置','','admin/comment/index','fa fa-comments-o','left','5','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('60','13','邮件设置','','admin/mail/index','fa fa-at','left','1','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('188','188','代理平台','agents','','fa fa-paw','left','0','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1881','1881','代理商','','admin/agents/index','fa fa-user-secret','left','188','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1882','1882','待认证','','admin/agents/wait','fa fa-user-o','left','188','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1883','1883','代理分类','','admin/agents/types','fa fa-map','left','188','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1884','1884','商品相关','','admin/agents/goods','fa fa-th-large','left','188','1');
INSERT INTO `rain_admin_menu` (`id`,`menu_sort`,`menu_name`,`tabs`,`menu_url`,`menu_icon`,`menu_types`,`menu_levelid`,`status`) VALUES ('1885','83','卡类管理','','admin/card/type','fa fa-cubes','left','8','1');



DROP TABLE IF EXISTS `rain_agents`;
CREATE TABLE `rain_agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL DEFAULT '1',
  `parent_uid` int(11) NOT NULL DEFAULT '1',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `conscore` int(11) NOT NULL DEFAULT '0',
  `login_ip` varchar(20) NOT NULL DEFAULT '1.1.1.1',
  `login_time` int(11) NOT NULL DEFAULT '0',
  `login_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_agents_goods`;
CREATE TABLE `rain_agents_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '1',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_agents_type`;
CREATE TABLE `rain_agents_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `discount` int(2) NOT NULL DEFAULT '80',
  `min_score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


INSERT INTO `rain_agents_type` (`id`,`name`,`discount`,`min_score`) VALUES ('1','普通','100','0');



DROP TABLE IF EXISTS `rain_api_token`;
CREATE TABLE `rain_api_token` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) DEFAULT NULL COMMENT '令牌',
  `op_time` int(6) DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户令牌信息';


DROP TABLE IF EXISTS `rain_app`;
CREATE TABLE `rain_app` (
  `appid` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(255) DEFAULT NULL,
  `app_key` varchar(255) DEFAULT 'rain68',
  `app_status` int(11) DEFAULT '1',
  `create_time` varchar(255) DEFAULT NULL,
  `update_time` int(6) DEFAULT NULL,
  `free` int(11) DEFAULT NULL,
  `test_time` int(11) NOT NULL DEFAULT '0',
  `acard_time` int(11) NOT NULL DEFAULT '0',
  `app_bind` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `index_show` int(1) DEFAULT '1',
  `app_data` varchar(1000) DEFAULT NULL,
  `announcement` varchar(1000) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `down_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_article`;
CREATE TABLE `rain_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `content` longtext,
  `keyword` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'admin',
  `hits` int(11) NOT NULL DEFAULT '0',
  `post_num` int(11) NOT NULL DEFAULT '0',
  `ontop` int(11) NOT NULL DEFAULT '0',
  `iselite` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `thumb_img` varchar(255) DEFAULT NULL,
  `html_status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_article_relation`;
CREATE TABLE `rain_article_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL DEFAULT '0',
  `sort_id` int(11) NOT NULL DEFAULT '1',
  `comment_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_auth_group`;
CREATE TABLE `rain_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


INSERT INTO `rain_auth_group` (`id`,`title`,`description`,`status`,`rules`) VALUES ('1','超级管理员','','1','');
INSERT INTO `rain_auth_group` (`id`,`title`,`description`,`status`,`rules`) VALUES ('2','管理员','管理基本功能','1','1,2,3,4,5,6,7,8,9,31,32,33,34,35,36,37,38,39,40,41,42,43,44,10,11,12,13,14,15,16,17,18,19,20,58,21,22,23,24,25,26,27,28,29,30,59,60,61,62,63,64,65,66,45,46,47,48,49,50,51,52,53,54,55,56,57');
INSERT INTO `rain_auth_group` (`id`,`title`,`description`,`status`,`rules`) VALUES ('3','普通用户','普通用户','1','');



DROP TABLE IF EXISTS `rain_auth_group_access`;
CREATE TABLE `rain_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `rain_auth_group_access` (`uid`,`group_id`) VALUES ('1','1');



DROP TABLE IF EXISTS `rain_auth_rule`;
CREATE TABLE `rain_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `cond` char(100) NOT NULL DEFAULT '',
  `group` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;


INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('1','admin/Acard/index','授权卡管理','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('2','admin/Acard/add','生成授权卡','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('3','admin/Acard/set','增删改授权卡','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('4','admin/Acard/edit','编辑授权卡','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('5','admin/Acard/acardlist','授权卡列表','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('6','admin/App/index','应用管理','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('7','admin/App/add','添加应用','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('8','admin/App/edit','编辑应用','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('9','admin/App/set','应用启停删','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('10','admin/Article/index','文章管理','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('11','admin/Article/sorts','文章分类','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('12','admin/Article/sortset','文章分类设置','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('13','admin/Article/addsort','添加文章分类','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('14','admin/Article/editsort','编辑文章分类','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('15','admin/Article/sortlist','文章分类列表','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('16','admin/Article/articlelist','文章列表','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('17','admin/Article/add','添加文章','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('18','admin/Article/upload','文章文件上传','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('19','admin/Article/set','文章停删设置','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('20','admin/Article/edit','编辑文章','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('21','admin/Authgroup/index','用户组管理','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('22','admin/Authgroup/add','添加用户组','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('23','admin/Authgroup/edit','URL','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('24','admin/Authgroup/set','URL','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('25','admin/Authgroup/grouplist','URL','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('26','admin/Authrule/index','权限节点管理','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('27','admin/Authrule/add','添加权限节点','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('28','admin/Authrule/edit','编辑权限节点','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('29','admin/Authrule/set','启停删权限节点','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('30','admin/Authrule/rulelist','权限节点列表','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('31','admin/Card/index','充值卡管理','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('32','admin/Card/add','生成充值卡','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('33','admin/Card/set','启停删充值卡','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('34','admin/Card/cardlist','充值卡列表','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('35','admin/Card/type','充值卡类型管理','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('36','admin/Card/typelist','充值卡类型列表','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('37','admin/Card/typeadd','添加充值卡类型','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('38','admin/Card/typeset','启停删充值卡类型','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('39','admin/Goods/index','应用商品管理','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('40','admin/Goods/goodslist','应用商品列表','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('41','admin/Goods/add','添加应用商品','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('42','admin/Goods/upload','应用商品图片上传','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('43','admin/Goods/set','启停删应用商品','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('44','admin/Goods/edit','编辑应用商品','1','1','','','应用管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('45','admin/Index/index','管理首页','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('46','admin/Index/uloginedit','管理员修改密码页','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('47','admin/Index/addulogin','管理员确认修改密码','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('48','admin/Netset/index','网站设置','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('49','admin/Netset/bak','备份数据库','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('50','admin/Netset/baklist','数据库备份列表','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('51','admin/Netset/delcache','清除缓存','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('52','admin/Order/index','支付订单管理','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('53','admin/Order/lists','支付订单列表','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('54','admin/Order/set','删除订单','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('55','admin/Pay/index','支付设置页','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('56','admin/Pay/saverainpay','保存支付设置','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('57','admin/Pay/savealipay','URL','1','1','','','系统管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('58','admin/Ueditor/index','百度编辑器权限','1','1','','','文章管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('59','admin/User/index','用户管理','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('60','admin/User/add','添加用户','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('61','admin/User/edit','编辑用户','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('62','admin/User/set','启停删用户','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('63','admin/User/appedit','编辑用户应用信息','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('64','admin/User/app','用户应用信息','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('65','admin/User/activeapp','激活用户应用','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('66','admin/User/userlist','用户列表','1','1','','','权限管理');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('67','admin/Agents/index','代理管理','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('68','admin/Agents/set','启停删代理','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('69','admin/Agents/agentsinfo','代理商祥细信息','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('70','admin/Agents/agentslist','代理商卡列表','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('71','admin/Agents/setdist','取消分配代理卡','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('72','admin/Agents/wait','代理商认证','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('73','admin/Agents/waitset','代理商认证','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('74','admin/Agents/types','代理类型管理','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('75','admin/Agents/typeset','代理平台','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('76','admin/Agents/addtype','添加代理类型','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('77','admin/Agents/edittype','编辑代理类型','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('78','admin/Agents/goods','代理商品相关','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('79','admin/Agents/goodsset','启停代理商品','1','1','','','代理平台');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('80','admin/Comment/index','评论设置','1','1','','','系统');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('81','admin/Mail/index','邮件设置','1','1','','','系统');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('82','admin/Menu/index','前台菜单管理','1','1','','','外观');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('83','admin/Menu/getlink','添加菜单','1','1','','','外观');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('84','admin/Nav/leftnav','菜单栏','1','1','','','外观');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('85','admin/Score/index','积份设置','1','1','','','系统');
INSERT INTO `rain_auth_rule` (`id`,`name`,`title`,`type`,`status`,`condition`,`cond`,`group`) VALUES ('86','admin/Theme/index','模板主题管理','1','1','','','外观');



DROP TABLE IF EXISTS `rain_card`;
CREATE TABLE `rain_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `use_uid` int(3) DEFAULT NULL,
  `appid` int(11) NOT NULL DEFAULT '0',
  `order_id` int(3) DEFAULT NULL,
  `create_time` int(6) NOT NULL DEFAULT '0',
  `sales_time` int(6) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `sales_status` int(2) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `agent_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card` (`card_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_card_type`;
CREATE TABLE `rain_card_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `day` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `explain` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_file`;
CREATE TABLE `rain_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_title` varchar(255) DEFAULT NULL,
  `bind_id` int(11) NOT NULL DEFAULT '0',
  `fee_body` varchar(255) DEFAULT NULL,
  `down_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `down_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_file_user`;
CREATE TABLE `rain_file_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '1',
  `file_id` int(11) DEFAULT NULL,
  `buy_time` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_goods`;
CREATE TABLE `rain_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `stitle` varchar(255) DEFAULT NULL,
  `appid` int(3) NOT NULL DEFAULT '1',
  `expimg` varchar(255) DEFAULT NULL,
  `help` text,
  `fns` text,
  `uptext` text,
  `copyright` varchar(255) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL,
  `count` int(3) NOT NULL DEFAULT '0',
  `create_time` int(6) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `down_url` varchar(255) DEFAULT NULL,
  `buy_count` int(11) NOT NULL DEFAULT '0',
  `agent_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_log`;
CREATE TABLE `rain_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_member`;
CREATE TABLE `rain_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) DEFAULT NULL,
  `logintime` int(1) DEFAULT NULL COMMENT '最后一次登录时间',
  `lastlogintime` int(1) DEFAULT NULL,
  `logincount` int(9) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `createtime` int(1) DEFAULT NULL COMMENT '创建时间',
  `loginip` varchar(255) NOT NULL DEFAULT '' COMMENT '登录IP',
  `lastloginip` varchar(255) DEFAULT NULL,
  `usergroup` varchar(255) NOT NULL DEFAULT '',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `comments` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COMMENT='管理员表';


INSERT INTO `rain_member` (`uid`,`name`,`password`,`status`,`email`,`logintime`,`lastlogintime`,`logincount`,`createtime`,`loginip`,`lastloginip`,`usergroup`,`score`,`comments`) VALUES ('1','admin','e10adc3949ba59abbe56e057f20f883e','1','xxx@qq.com','1487846709','1487685629','130','1476088039','127.0.0.1','127.0.0.1','administrator','339.00','');



DROP TABLE IF EXISTS `rain_menu`;
CREATE TABLE `rain_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sorting` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `bind_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_money`;
CREATE TABLE `rain_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(3) DEFAULT NULL,
  `typeid` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_order`;
CREATE TABLE `rain_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `umoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` int(6) NOT NULL DEFAULT '0',
  `body` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '1',
  `goods_type` int(11) NOT NULL DEFAULT '1',
  `trade_status` int(11) NOT NULL DEFAULT '0' COMMENT '0未完成，1成功',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `rain_score_config`;
CREATE TABLE `rain_score_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `exchange` int(11) NOT NULL DEFAULT '1',
  `newuser_score` int(11) NOT NULL DEFAULT '0',
  `min_full` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `rain_score_config` (`id`,`name`,`comments`,`status`,`exchange`,`newuser_score`,`min_full`) VALUES ('1','Rain积分','系统默认积分','1','100','55','1');



DROP TABLE IF EXISTS `rain_score_record`;
CREATE TABLE `rain_score_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `score_plus` int(11) NOT NULL DEFAULT '0',
  `score_minus` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `score` int(11) DEFAULT '0',
  `body` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_setting`;
CREATE TABLE `rain_setting` (
  `k` varchar(255) NOT NULL DEFAULT 'k',
  `v` text,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `rain_setting` (`k`,`v`) VALUES ('comment','{"id":"2123025","status":"1"}');



DROP TABLE IF EXISTS `rain_sort`;
CREATE TABLE `rain_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sorts` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_user_app`;
CREATE TABLE `rain_user_app` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `appid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '软件id',
  `active_time` int(6) DEFAULT NULL,
  `expire_time` int(6) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `fee_count` int(6) DEFAULT '0',
  `loginip` varchar(255) DEFAULT NULL,
  `bind` int(11) DEFAULT '0' COMMENT '绑定类弄 0:不绑定 1机器码 2:ip 3:1和2',
  `bind_mcode` varchar(255) DEFAULT NULL,
  `bind_ip` varchar(255) DEFAULT NULL,
  `user_data` varchar(1000) DEFAULT NULL,
  `bind_count` int(11) DEFAULT '5',
  UNIQUE KEY `udi_sid` (`uid`,`appid`),
  KEY `sid` (`appid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_user_goods`;
CREATE TABLE `rain_user_goods` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `order_id` int(6) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rain_user_menu`;
CREATE TABLE `rain_user_menu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('1','1','我的订单','/index/order','/index/order','1');
INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('2','2','我的充值卡','/index/usercard','/index/user_card','1');
INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('3','99','个人资料','/index/user','/index/user','2');
INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('4','100','修改密码','/index/repwd','/index/repwd','2');
INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('5','3','我的授权卡','/index/useracard','/index/user_acard','1');
INSERT INTO `rain_user_menu` (`Id`,`sort`,`name`,`controller`,`url`,`group`) VALUES ('6','3','我的积分','/index/score','/index/score','2');



DROP TABLE IF EXISTS `rain_userinfo`;
CREATE TABLE `rain_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `alipayid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `qq` varchar(16) DEFAULT NULL,
  `tel` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



