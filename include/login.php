<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
$get_start_time = time();
include_once("../lib/mysql.class.php");
include_once("../lib/user.class.php");
include_once("../app/oauth/oauth2.php");

$own = new mysql();

if($_POST['username'] == '') die('请填写您的手机号或邮箱！');
if($_POST['password'] == '') die('请填写您的密码！');

if(preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $_POST['username'])) {
    $a = array(
        'email'=>$_POST['username'],
        'password'=>substr(md5($_POST['password']), 0, 20)
    );
    //die('email');
    //echo 'phone';
}elseif(preg_match("/^13[0-9]{9}$|^15[0-9]{9}$|^18[0-9]{9}$/", $_POST['username'])) {
    $a = array(
        'phone'=>$_POST['username'],
        'password'=>substr(md5($_POST['password']), 0, 20)
    );
    //die('phone');
}else{
    die('您的账号格式输入有错误，请正确填写您的邮箱或手机号！');
}

$user = new user($a);
$result = $user->login($own);

//print_r('error:' . $result . '. ');

switch($result) {
	case 1000:
		$_SESSION['user'] = $user->person;
		die('登陆成功！');
		break;
	case 1001:
		die('手机号或邮箱不存在！');
		break;
	case 1002:
		die('密码错误！');
		break;
	case 1012:
		$_SESSION['user'] = $user->person;
		die('登陆成功！');
		break;
	default:
		die('未知错误，错误代码：＃'.$result);
        break;
}
?>
