<?php
date_default_timezone_set("PRC");
$sourceurl = $_POST['u'];

if($sourceurl == ""){

  echo $wu;
}

$method = "jingdong.service.promotion.getcode";
$channel = "PC";
$type = 7;
$unionId = "XXXXXXXXXXXXX";
$webId = "XXXXXXXXXXXXX";
$token = "XXXXXXXXXXXXX";
$appkey = "XXXXXXXXXXXXX8";
$appSecret = "XXXXXXXXXXXXX";
$v = "2.0";
$time1 = date('Y-m-d H:i:s',time());

$baseurl = "https://api.jd.com/routerjson?";

//应用参数，json格式
$_360buy_param_json =
'{"channel":"'.$channel.'","materialId":"'.$sourceurl.'","promotionType":'.$type.',"unionId":"'.$unionId.'",
  "webId":"'.$webId.'"}';

//系统参数
$fields = [
    "360buy_param_json" => urlencode($_360buy_param_json),
    "access_token" => urlencode($token),
    "app_key" => urlencode($appkey),

    "method" => urlencode($method),
   
    "v" => urlencode($v),
];

$fields_string = "";

//用来计算md5，以appSecret开头
$_tempString = $appSecret;

foreach($fields as $key=>$value)
{
    //直接将参数和值拼在一起
    $_tempString .= $key.$value;
    //作为url参数的字符串
    $fields_string .= $key.'='.$value.'&';
}

//最后再拼上appSecret
$_tempString .= $appSecret;

//计算md5，然后转为大写，sign参数作为url中的最后一个参数
$sign = strtoupper(md5($_tempString));

//加到最后
$fields_string .= ("sign=".$sign);

//最终请求的url
$link = $baseurl.$fields_string;

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

    curl_close($ch);
//转换为json
$jsonArray = json_decode($result,true);
$queryjs_result= $jsonArray["jingdong_service_promotion_getcode_responce"]["queryjs_result"];
$url = json_decode($queryjs_result,true);
echo urldecode($url["url"]);
$final= $url["url"];
header("Location: $final");


?>