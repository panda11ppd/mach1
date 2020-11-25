<?php
	
	return [	
	    'view_replace_str'       => [
            '__PUBLIC__' => \think\request::instance()->root().'/public',
            //'__ROOT__'   => '/',
            '__ROOT__'=> \think\request::instance()->root(),
            '__PLUG__' => \think\request::instance()->root().'/public/static/plug',
            '__CSS__' => \think\request::instance()->root().'/public/static/admin/css',
            '__JS__' => \think\request::instance()->root().'/public/static/admin/JS',
        ],
        'dispatch_success_tmpl'  => 'public/message',
        'dispatch_error_tmpl'    => 'public/message',
               
	];
