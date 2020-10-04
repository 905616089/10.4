<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate 
{
    protected $rule = [
        'username'  => 'require|max:20',
        'psd'   => 'require',
    ];
    protected $message = [
        'username'  => '用户名必填|不可超过20个字符',
        'psd'   => '密码必填',
    ];
}

