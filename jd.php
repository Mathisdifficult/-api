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

//Ӧ�ò�����json��ʽ
$_360buy_param_json =
'{"channel":"'.$channel.'","materialId":"'.$sourceurl.'","promotionType":'.$type.',"unionId":"'.$unionId.'",
  "webId":"'.$webId.'"}';

//ϵͳ����
$fields = [
    "360buy_param_json" => urlencode($_360buy_param_json),
    "access_token" => urlencode($token),
    "app_key" => urlencode($appkey),

    "method" => urlencode($method),
   
    "v" => urlencode($v),
];

$fields_string = "";

//��������md5����appSecret��ͷ
$_tempString = $appSecret;

foreach($fields as $key=>$value)
{
    //ֱ�ӽ�������ֵƴ��һ��
    $_tempString .= $key.$value;
    //��Ϊurl�������ַ���
    $fields_string .= $key.'='.$value.'&';
}

//�����ƴ��appSecret
$_tempString .= $appSecret;

//����md5��Ȼ��תΪ��д��sign������Ϊurl�е����һ������
$sign = strtoupper(md5($_tempString));

//�ӵ����
$fields_string .= ("sign=".$sign);

//���������url
$link = $baseurl.$fields_string;

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

    curl_close($ch);
//ת��Ϊjson
$jsonArray = json_decode($result,true);
$queryjs_result= $jsonArray["jingdong_service_promotion_getcode_responce"]["queryjs_result"];
$url = json_decode($queryjs_result,true);
echo urldecode($url["url"]);
$final= $url["url"];
header("Location: $final");


?>