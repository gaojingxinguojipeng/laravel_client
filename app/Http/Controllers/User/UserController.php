<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

public function decode(){



    //凯撒加密
     function encode($str,$n=1){
$asscii="";
    $length=strlen($str);
    for($i=0;$i<$length;$i++){
        $pass=ord($str[$i])+$n;
        $asscii.=chr($pass);

    }
    echo $asscii;
 }

    $str="abc";
    $n=1;
    echo encode($str,$n);


}




//对称加密
public function eclist(){
     $str="hellow world";
     $method="AES-256-CBC";
     $key="xxyy";
     $option=OPENSSL_RAW_DATA;
     $iv="qqqqqqqqqqqqqqqq";
     $enc_str=openssl_encrypt($str,$method,$key,$option,$iv);
     $b64=base64_encode($enc_str);
     echo '原文：'.$str;echo '</br>';
     echo '密文：'.$b64;echo '</br>';
}
public function delist(){
     $str=$_GET["b64"];
     $method="AES-256-CBC";
     $key="xxyy";
     $option=OPENSSL_RAW_DATA;
     $iv="qqqqqqqqqqqqqqqq";
     $b64=base64_decode($str);
     $dec_str=openssl_decrypt($b64,$method,$key,$option,$iv);
     echo '密文：'.$str;echo '</br>';
     echo '原文：'.$dec_str;echo '</br>';
}


//非对称加密
public function pri(){
    $data=[
        "name"=>"dapeng",
        "email"=>"15670507992@shoujihao.com",
    ];
    $json_str=json_encode($data);
    $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
    openssl_private_encrypt($json_str,$enc_data,$k);
    var_dump($enc_data);

    //解密
    $pk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
    openssl_public_decrypt($enc_data,$dec_data,$pk);
    echo '<hr>';
    echo $dec_data;

}



//非对称加密验证签名
public function rsa(){
    $data=[
        "name"=>"gaogao",
        "email"=>"1411817587@qq.com",
    ];

    $json_str=json_encode($data);
    $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));

    //$kk=openssl_error_string();
    //echo $kk;
    //var_dump($kk);die;

    openssl_sign($json_str,$enc_data,$k);
  //  echo $enc_data;
    $b64=base64_encode($enc_data);
    echo $b64;

    $api_url="http://vm.two.api.com/rsa?sign=".urlencode($b64);

    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$api_url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$json_str);
    curl_setopt($ch,CURLOPT_HTTPHEADER,[
        'Content-Type:text/plain'
    ]);
    $response=curl_exec($ch);
    $err_code=curl_errno($ch);
    if($err_code>0){
    echo "CURL 错误码：".$err_code;
    exit;
    }
    curl_close($ch);






}
}
