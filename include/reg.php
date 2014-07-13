<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
$get_start_time = time();
include_once("../lib/mysql.class.php");
include_once("../lib/user.class.php");
include_once("../app/oauth/oauth2.php");

$own = new mysql();

if($_POST['phone'] == '') die('对不起，请填写您的手机号！');

if(!preg_match('/^([0-9a-zA-Z\@\!\#\$\%\^\&\*\.\_]{6,18})$/', $_POST['password'])) die('对不起，密码格式不正确');

//验证邮箱
//if($_POST['yanzheng'] == $_SESSION['yanzheng'][0] and $_POST['email'] == $_SESSION['yanzheng'][1]){}else{die('对不起，您的邮箱验证码不正确！');}   //.$_SESSION['yanzheng'][0])
	
	
$a = array(
	'phone'=>$_POST['phone'],
	'password'=>substr(md5($_POST['password']), 0, 20),
	'password_once'=>substr(md5($_POST['password2']), 0, 20),
	'username'=>$_POST['username'],
	'confirmation'=>0
);
$user = new user($a);
$result = $user->reg($own);

switch($result) {
	case 1011:
		$_SESSION['user'] = $user->person;
		die('注册成功！');
		break;
	case 1009:
		die('手机号已经被注册！');
		break;
	case 1008:
		die('昵称已经被注册！');
		break;
	case 1007:
		die('手机号没有填写！');
		break;
	case 1006:
		die('昵称没有填写！');
		break;
	case 1003:
		die('两次密码输入不一致！');
		break;
	case 1005:
		die('密码没有填写！');
		break;
	default:
		die($result);
        break;
}
?>
