<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 11:55
 */

function sendHttp($url,$header = ''){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($header != '')
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 0); //表示需要response body
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $imgcontent); //表示需要response body
    if(preg_match('/https/',$url)){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    // 设为0表示不检查证书 设为1表示检查证书中是否有CN(common name)字段 设为2表示在1的基础上校验当前的域名是否与CN匹配
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//以文件流的形式返回获取的信息
    $response = curl_exec($ch);
    curl_close($ch);
    \Illuminate\Support\Facades\Log::info($response);
    return $response;
}