<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [
    //验证码设置
 
        // 验证码字符集合
        'codeSet'  => '2345678rainabcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', 
        // 验证码字体大小(px)
        'fontSize' => 18, 
        // 是否画混淆曲线
        'useCurve' => FALSE, 
         // 验证码图片高度
        'imageH'   => 34,
        // 验证码图片宽度
       // 'imageW'   => 130, 
        // 验证码位数
        'length'   => 4, 
        // 验证成功后是否重置        
        'reset'    => true,
        // 是否添加杂点
        'useNoise' => FALSE,
        // 背景颜色
        'bg'       => [255, 250, 232],
   
];
