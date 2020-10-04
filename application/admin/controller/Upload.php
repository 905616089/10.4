<?php


namespace app\admin\controller;


class Upload
{
    public function index(){

        $file=request()->file('file');
        $info = $file->move( ROOT_PATH.'public'.DS.'uploads');
        if($info){
            $imgpath=date('Ymd').'/'.$info->getFilename();
            return json([
                'code'=>200,
                'msg'=>'图片上传成功',
                'imgurl'=>"/server/admin/public/uploads/".$imgpath
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>$info->getError()
            ]);
        }
    }
}
