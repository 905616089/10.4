<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;


class Category extends Controller
{
    //添加
    function add(){
        if(!$this->request->isPost()){
            return json([
                "code"=>400,
                "msg"=>"请求错误",
                "type"=>$this->request
            ]);
        }
            $data=$this->request->post();
            $validate=validate("Category");
            $flag=$validate->scene('add')->check($data);
            if(!$flag){
                return json([
                    "code"=>400,
                    "msg"=>$validate->getError(),
                ]);
            }

            $db=Db::table("category")->insert($data);
            if($db){
                return json([
                    "code"=>200,
                    "msg"=>"添加成功",
                ]);
            }else{
                return json([
                    "code"=>400,
                    "msg"=>"添加失败",
                ]);
            }
    }
    function Fuzzyquery(){
        if(!$this->request->isPost()){
            return json([
                "code"=>400,
                "msg"=>"请求错误"
            ]);
        }
        $data=$this->request->post();
        $cname="%".$data["cname"]."%";
        $db=Db::table("category")->where("cname","like",$cname)->order("cid","desc")->select();
        if(empty($db)){
            return json([
                "code"=>200,
                "msg"=>"未能找到",
            ]);
        }else{
            return json([
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$db
            ]);
        }
    }
    //查询条件
    function index(){
        $data=$this->request->get();
        if(isset($data['page'])&&!empty($data['page'])){
            $page=$data['page'];
        }else{
            $page=1;
        }
        if(isset($data['limit'])&&!empty($data['limit'])){
            $limit=$data['limit'];
        }else{
            $limit=5;
        }
        $where=[];
        if(isset($data['cname'])&&!empty($data['cname'])){
            $where['cname']=['like','%'.$data['cname'].'%'];
        }

        $category=Db::table('category')->field('cid,cname,cdesc')->where($where)->page($page)->limit($limit)->select();
        $count=Db::table("category")->where($where)->count();
        if($category&&$count){
            return json([
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$category,
                "total"=>$count,
            ]);
        }else{
            return json([
                "code"=>200,
                "msg"=>"未找到数据",

            ]);
        }
    }
    //查询所有
    function indexall(){
        if(!$this->request->isGet()){
            return json([
                "code"=>400,
                "msg"=>"请求方式不对",
            ]);
        }
        $db=Db::table("category")->select();
        if($db){
            return json([
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$db
            ]);
        }else{
            return json([
                "code"=>200,
                "msg"=>"未找到选项",

            ]);
        }

    }


    //获取数据
    function read(){
        checkToken();
        if(!$this->request->isPost()){
            return json([
                "code"=>400,
                "msg"=>"请求错误"
            ]);
        }
        $data=$this->request->post();
        $validate=validate("Category");
        $flag=$validate->scene("read")->check($data);
        if(!$flag){
            return json([
                "code"=>400,
                "msg"=>$validate->getError(),
            ]);
        }
        $cid=$data['cid'];

        $request=Db::table("category")->where('cid',$cid)->find();
        if($request){
            return json([
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$request,
            ]);
        }else{
            return json([
                "code"=>200,
                "msg"=>"没有数据",
                "data"=>$request,
            ]);
        }
    }
    //更新数据
    function update(){
       // checkToken();
        if(!$this->request->isPost()){
            return json([
                "code"=>400,
                "msg"=>"请求错误"
            ]);
        }
        $data=$this->request->post();
        $validate=validate("Category");
        $flag=$validate->check($data);
        if(!$flag){
            return json([
                "code"=>400,
                "msg"=>$validate->getError(),
            ]);
        }
        $cid=$data["cid"];
        unset($data["cid"]);
        $request=Db::table("category")->where("cid",$cid)->update($data);
        if($request){
            return json([
                "code"=>200,
                "msg"=>"更新成功",
            ]);
        }else{
            return json([
                "code"=>400,
                "msg"=>"更新失败",
            ]);
        }
    }
    //删除数据
    function delete(){
        if(!$this->request->isGet()){
            return json([
                'code'=>400,
                'msg'=>'请求方式错误',
            ]);
        }
        $data=$this->request->get();
        $cid=$data[0];
        $request=Db::table("category")->where("cid",$cid)->delete();
        if($request){
            return json([
                "code"=>200,
                "msg"=>"删除成功",
            ]);
        }else{
            return json([
                "code"=>400,
                "msg"=>"删除失败",
            ]);
        }
    }


}