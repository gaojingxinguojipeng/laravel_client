<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    //跨域
    public function kuayu()
    {
        return view("User.kuayu");
    }

    //注册
    public function reg()
    {
        return view("User.reg");
    }

    public function regDo(Request $request)
    {
        $name = $request->post("name");
        $pwd = $request->post("pwd");
        $email = $request->post("email");
        $eml = DB::table("user2")->where(["email" => $email])->first();
        if ($eml) {
            die("该email已存在");
        }

        $data = [
            "name" => $name,
            "email" => $email,
            "pwd" => $pwd,

        ];
        $res = DB::table("user2")->insert($data);
        if ($res) {
            echo "注册成功";
        }
    }


    //登录
    public function login()
    {
        return view("User.login");
    }

    public function loginDo(Request $request)
    {
        $name = $request->post("name");
        $pwd = $request->post("pwd");
        $email = $request->post("email");
        $where = [
            "name" => $name,
            "pwd" => $pwd,
            "email" => $email
        ];
        $res = DB::table("user2")->where($where)->first();
//        var_dump($res);die;
        if ($res) {
            $data = [
                "name" => $name,
                "pwd" => $pwd,
                "email" => $email,
            ];
            $json_str = json_encode($data);
            $k = openssl_pkey_get_private('file://' . storage_path('app/keys/private.pem'));
//            var_dump($k);
            openssl_sign($json_str, $enc_data, $k);
            //  echo $enc_data;
            $b64 = base64_encode($enc_data);

            echo $b64;
            $api_url = "http://vm.two.api.com/pub?sign=" . urlencode($b64);

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


//    分布式注册

    public function openreg()
    {
        $str = file_get_contents("php://input");
        $data=json_decode($str);
        $arr=[
            'name'=>$data->name,
            'pwd'=>$data->pwd,
        ];
        $arrInfo = DB::table("user2")->insertGetId($arr);
        if ($arrInfo) {
            $response = [
                "code" => 1,
                "msg" => "注册成功",
            ];
            return $response;
        } else {
            $response = [
                "code" => 2,
                "msg" => "注册失败",
            ];
            return $response;
        }
    }
//    分布式登录
    public function openlogin(){
        $str = file_get_contents("php://input");
        $data=json_decode($str);
        $name=$data->name;
        $pwd=$data->pwd;
        $where=[
            "name"=>$name,
            "pwd"=>$pwd,
        ];
        $res=DB::table("user2")->where($where)->first();
        if($res){
            $token=$this->generateLoginToken($res->id);
            $key="login_token".$res->id;
            Redis::set($key,$token);
            Redis::expire($key,86400);
            $key="login_token".$res->id;
            $token=Redis::get($key);
            $response=[
                "code"=>1,
                "msg"=>"登录成功",
                "token"=>$token,
                "uid"=>$res->id,
            ];
            return $response;
        }
    }
    private function generateLoginToken($id){
        return substr(sha1($id.time().Str::random(10)),5,15);
    }
}