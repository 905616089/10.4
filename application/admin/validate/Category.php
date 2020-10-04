<?php


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule =[
        'cname'  => 'require',
        'cdesc'   => 'require',
        'cid'=>'require|number',
    ];
    protected $message=[

        'cname'  => '名字必填',
        'cdesc'   => '简介必填',
        'cid'=>'cid必填|cid必须为数字'

    ];
    protected $scene=[
      'read'=>'cid', 
        'add'=>'cname,cdesc',
    ];
}