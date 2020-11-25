<?php
namespace app\common\validate;

use think\Validate;

class UserFn extends Validate
{
    protected $rule = [
        'name'      => 'require|alphaDash',
        'password'  =>'require',
        'passworden'=>'require|confirm:password',
        'email'     =>'email',
        'valcode'   =>'require',
    ];

    protected $message = [
        'name.require'      => '用户名是必须的!',
        'name.alphaDash'      => '用户名必须是 字母或数字或下划线！',
        'password.require'  =>'密码不能为空！',
        'passworden.require'=>'确认密码不能为空！',
        'passworden.confirm'=>'确认密码不相同！',
        'email.email'     => '邮箱格式不正确！',
        'valcode.require'   =>'验证无法通过！',
    ];

    protected $scene = [
        'add'   =>  ['name','password','passworden','valcode'],
        'addemail'   =>  ['name','password','passworden','email','valcode'],          
    ];
}