<?php

error_reporting(0); //去除所有错误显示

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
defined('ROOT') or define('ROOT', dirname(__FILE__) . '/../../');

defined('HOST_NAME') or define('HOST_NAME','琦益网 - 企业产品直销平台');
defined('SNAME') or define('SNAME','琦益');
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

?>
