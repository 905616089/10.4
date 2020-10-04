<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        echo md5(crypt(config("defaltPassword"),config("salt")));
    }
    public function lists(){

    }
}
