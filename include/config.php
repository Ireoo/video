<?php

//error_reporting(0); //去除所有错误显示

if(isset($_GET['loginout'])) {
	if($_GET['loginout'] == 'yes') {
		unset($_SESSION['user']);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
	}
}
$own = new mysql;
if(isset($_SESSION['user'])) {
	$user = new user();
	$o = $user->getID($own, $_SESSION['user']['id']);
    $s = array(
        'table' => 'store',
        'condition' => 'uid = ' . $_SESSION['user']['id'],
        'order' => 'id asc'
    );
    $os = $own->row($s);
}else{
	$o = '';
}

defined('HOST_NAME') or define('HOST_NAME','星主播，展示自我的平台');
defined('SNAME') or define('SNAME','星主播');
defined('HOST_URL') or define('HOST_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');

function thisIP() {
	if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
	else if (@$_SERVER["HTTP_CLIENT_IP"]) 
		$ip = $_SERVER["HTTP_CLIENT_IP"]; 
	else if (@$_SERVER["REMOTE_ADDR"]) 
		$ip = $_SERVER["REMOTE_ADDR"]; 
	else if (@getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (@getenv("HTTP_CLIENT_IP")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
	else if (@getenv("REMOTE_ADDR")) 
		$ip = getenv("REMOTE_ADDR"); 
	else 
		$ip = "unknown"; 
	return $ip; 
}

function utf_substr($str,$len){
for($i=0;$i<$len;$i++){
   $temp_str=substr($str,0,1);
   if(ord($temp_str) > 127){
    $i++;
    if($i<$len){
     $new_str[]=substr($str,0,3);
     $str=substr($str,3);
    }
   }
   else{
    $new_str[]=substr($str,0,1);
    $str=substr($str,1);
   }
}
return join($new_str);
}

function curPageURL()
{
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function getIPLoc_sina($queryIP){
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
    $ch = curl_init($url);
    //curl_setopt($ch,CURLOPT_ENCODING ,'utf8');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
    $location = curl_exec($ch);
    $location = json_decode($location);
    curl_close($ch);

    $loc = "";
    if($location===FALSE) return "";
    if (empty($location->desc)) {
        $loc = $location->province.$location->city.$location->district.$location->isp;
    }else{
        $loc = $location->desc;
    }
    return $loc;
}

function getIPLoc_QQ($queryIP){
    $url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP;
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_ENCODING ,'gb2312');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
    $result = curl_exec($ch);
    $result = mb_convert_encoding($result, "utf-8", "gb2312"); // 编码转换，否则乱码
    curl_close($ch);
    preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray);
    $loc = $ipArray[1];
    return $loc;
}

?>
