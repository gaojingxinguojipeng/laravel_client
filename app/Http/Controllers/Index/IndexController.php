<?php


namespace App\Http\Controllers\Index;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
//    注册
    public function regpass(){
        return view("Index.reg");
    }
    public function regpassDo(Request $request){
       $name=$request->input("name");
       $shui=$request->input("shui");
       $dui=$request->input("dui");
       $img=$request->input("img");
       $data=[
           "name"=>$name,
           "shui"=>$shui,
           "dui"=>$dui,
           "img"=>$img,
           "APPID"=>time(),
           "key"=>time()+30,
           "status"=>1,
       ];
       $arr=DB::table("regpass")->insert($data);
       if($arr){
           $response=[
               "code"=>1,
               "msg"=>"申请成功",
           ];
           return $response;
       }


    }
//    注册列表
    public function regpasslist(){
        $data=DB::table("regpass")->get();
        return view("Index.regpasslist",["data"=>$data]);
    }
    public function loginpass(){
        return view("Index.login");
    }
//    登录执行
    public function loginpassDo(Request $request){
        $name=$request->input("name");
        $shui=$request->input("shui");
        $dui=$request->input("dui");
        $where=[
            "name"=>$name,
            "shui"=>$shui,
            "dui"=>$dui,
        ];
        $res=DB::table("regpass")->where($where)->first();
        if($res){
            if($res->status==1){
                $response = [
                    "code" => 2,
                    "msg" => "未申请成功",
                ];
                return $response;
            }else {
                $response = [
                    "code" => 1,
                    "APPID" => $res->APPID,
                    "key"=>$res->key,
                ];
                return $response;
            }
        }
    }
    //修改注册状态 审核
    public function regstatus(Request $request){
        $id=$request->input("id");
        $where=[
            "id"=>$id,
        ];
        $res=DB::table("regpass")->where($where)->update(['status'=>2]);
        if($res){
            $response = [
                "code" => 1,
                "msg" => "审核通过",
            ];
            return $response;
        }

    }
    //上传图片接口
    public function uploadImg(Request $request){             //图片上传
        if($request->isMethod('POST')){
            $fileCharater=$request->file('goods_img');               // 使用request 创建文件上传对象
//            var_dump($fileCharater);die;

            if($fileCharater->isValid()){                            //是否有效
                $ext=$fileCharater->getClientOriginalExtension();   //获取图片的后缀
                $path=$fileCharater->getRealPath();               //获取临时文件的路径
                $filename=date('Ymdhis').'.'.$ext;
                Storage::disk('public')->put($filename,file_get_contents($path));
                $file_path="./public/".$filename;

            }
        }
        return json_encode($file_path);
    }
//获取accesstoken接口
    public function accessToken(){
        $APPID=$_GET['APPID'];
        $key=$_GET["key"];
        $where=[
            "APPID"=>$APPID,
            "key"=>$key,
        ];
        $res=DB::table('regpass')->where($where)->first();
        if($res){
            $accessToken="$APPID"+"$key";
            $id=Redis::incr("id");
            $key="loginpass_token".$id;
            Redis::set($key,$accessToken);
            Redis::expire($key,86400);
            $accessToken=Redis::get($key);
            if(!empty($accessToken)){
                $response=[
                    "code" => 1,
                    "msg" => "token:".$accessToken,
                ];
                return $response;
            }
        }else{
            $response=[
                "code" => 2,
                "msg" => "参数错误",
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }

    }
    //获取ua接口
    public function uaShow(){
        $accessToken=$_GET["accessToken"];
        $key="loginpass_token1";
        $accesstoken=Redis::get($key);
        if($accessToken==$accesstoken){
            $ua = $_SERVER['HTTP_USER_AGENT'];
            if ($ua) {
                $response = [
                    "code" => 1,
                    "msg" => $ua,
                ];
                return $response;
            }
        }else{
            $response=[
                "code" => 2,
                "msg" => "参数错误",
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    //ip接口
    public function ipShow(){
        $accessToken=$_GET["accessToken"];
        $key="loginpass_token1";
        $accesstoken=Redis::get($key);
        if($accessToken==$accesstoken){
            $ip = $_SERVER['SERVER_ADDR'];
            if ($ip) {
                $response = [
                    "code" => 1,
                    "msg" => $ip,
                ];
                return $response;
            }
        }else{
            $response=[
                "code" => 2,
                "msg" => "参数错误",
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    //显示个人信息接口
    public function userinfo(){
        $accessToken=$_GET["accessToken"];
        $key="loginpass_token1";
        $accesstoken=Redis::get($key);
        if($accessToken==$accesstoken){
            $id=$_GET['id'];
            $where=[
                "id"=>$id,
            ];
            $res=DB::table("regpass")->where($where)->first();
            if($res){
                $response=[
                    "code"=>1,
                    "msg"=>$res
                ];
                return $response;
            }

        }else{
            $response=[
                "code" => 2,
                "msg" => "参数错误",
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function qiandao(){
        $data=date("Ymd");
        $key="qiandao".$data;
        $qian=Redis::bitcount($key);


        return view("Index.qiandao",['qian'=>$qian]);
    }
    //签到
    public function qiandaoDo(){
        $data=date("Ymd");
        $key="qiandao".$data;
        $qian=Redis::setbit($key,7,1);
        if($qian){
            $response=[
                "code"=>1,
                "msg"=>"签到成功"
            ];
            return $response;
        }

    }
}