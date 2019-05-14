<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    //跨域
    public function kuayu(){
        return view("User.kuayu");
    }
    //注册
    public function reg(){
        return view("User.reg");
    }
    public function regDo(Request $request){
        $name=$request->post("name");
        $pwd=$request->post("pwd");
        $email=$request->post("email");
        $eml=DB::table("user2")->where(["email"=>$email])->first();
        if($eml){
         die("该email已存在");
        }

        $data=[
            "name"=>$name,
            "email"=>$email,
            "pwd"=>$pwd,

        ];
        $res=DB::table("user2")->insert($data);
        if($res){
          echo "注册成功";
        }
    }


    //登录
    public function login(){
        return view("User.login");
    }
    public function loginDo(Request $request){
        $name=$request->post("name");
        $pwd=$request->post("pwd");
        $email=$request->post("email");
        $where=[
            "name"=>$name,
            "pwd"=>$pwd,
            "email"=>$email
        ];
        $res=DB::table("user2")->where($where)->first();
//        var_dump($res);die;
        if($res) {
            $data = [
                "name" => $name,
                "pwd" => $pwd,
                "email" => $email,
            ];
            $json_str = json_encode($data);
            $k = openssl_pkey_get_private('file://' . storage_path('app/keys/private.pem'));
//            var_dump($k);
            openssl_sign($json_str,$enc_data,$k);
            //  echo $enc_data;
            $b64=base64_encode($enc_data);

            echo $b64;
            $api_url = "http://lumen.gaojingxin.top/pub?sign=".urlencode($b64);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_str);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type:text/plain'
            ]);
            $response = curl_exec($ch);
            $err_code = curl_errno($ch);
            if ($err_code > 0) {
                echo "CURL 错误码：" . $err_code;
                exit;
            }
            curl_close($ch);
        }
    }





    public function register(Request $request){
        $name=$request-input("name");
        $pwd=$request->input("pwd");
        $data=[
            "name"=>$name,
            "pwd"=>$pwd
        ];
        $arr=DB::table("user2")->insert($data);
        if($arr){
            $response=[
                "code"=>1,
                "msg"=>"注册成功",
            ];
            return $response;
        }else{
            $response=[
                "code"=>2,
                "msg"=>"注册失败",
            ];
            return $response;
        }
    }
}