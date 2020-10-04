<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\JWT;


/* 1验证权限
 * 2验证请求方式
 * 3接受前台数据
 * 4前台数据验证
 * 5通过后 进行业务逻辑
 * */
class Login extends Controller{
    function check(){
        $method=$this->request->method();
        if($method !="POST"){
            return json([
               "code"=>400,
            ]);
        }
        $data=$this->request->post();
        $vildate=validate("Login");
        $flag=$vildate->check($data);
       if(!$flag){
           return json([
               'code'=>400,
               'msg'=>$vildate->getError(),
           ]);
       }
        $usename=$data["username"];
        $psd= md5(crypt($data["psd"],config("salt")));
        $use=['username'=>$usename];
        $request=Db::table("admin")->where($use)->select();
        if($request) {
            $pad1 = $request[0]["psd"];
            if ($psd === $pad1) {
                $payload=[
                    'id'=>$request[0]["id"],
                    'username'=>$request[0]["username"],
                    'avator'=>$request[0]["avator"],
                ];
                $token=JWT::getToken($payload,config("jwtkey"));
                return json([
                    "code" => 200,
                    "msg" => "登陆成功",
                    'token'=>$token,
                    'payload'=>$payload,
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "用户名和密码不匹配",
                ]);
            }
        }else{
            return json([
                "code" => 400,
                "msg" => "用户名不存在",
            ]);
        }
    }
}