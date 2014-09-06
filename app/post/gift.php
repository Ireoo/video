<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-8-21
 * Time: 上午5:02
 */
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();

include_once("../../lib/mysql.class.php");
include_once("../../lib/user.class.php");
include_once("../oauth/oauth2.php");
//print_r($_POST);

$mysql = new mysql();

$gift = array(0, 0.1, 0.1, 1, 5, 8, 10, 60, 100);

if(!isset($_SESSION['user'])) {

    die('请登陆后再赠送！');

}else{

    $user = new user();
    $o = $user->getID($mysql, $_SESSION['user']['id']);

    $money = $_POST['member']*$gift[$_POST['gift']];

    if($o['money'] - $money < 0) {
        //print_r($user);
        die('当前余额：' . $o['money'] . ' ，不足以支付该费用，还须充值 ' .($money - $o['money']) . ' 元才可送出!');
    }else{

        if($mysql->execute("UPDATE  `user` SET  `money` =  `money` - {$money} WHERE  `id` ={$o['id']};")){
            if($_POST['gift'] == 0) {
                if($mysql->execute("UPDATE  `video` SET  `hua` =  `hua` + {$_POST['member']} WHERE  `uid` ={$_POST['room']};")){
                    unset($mysql);
                    die('ok');
                }else{
                    unset($mysql);
                    die(mysql_error());
                }
            }elseif($_POST['gift'] == 1) {
                if($mysql->execute("UPDATE  `video` SET  `good` =  `good` + {$_POST['member']} WHERE  `uid` ={$_POST['room']};")){
                    $mysql->execute("UPDATE  `video` SET  `pingfen` =  `good` - `bad` WHERE  `uid` ={$_POST['room']};");
                    unset($mysql);
                    die('ok');
                }else{
                    unset($mysql);
                    die(mysql_error());
                }
            }elseif($_POST['gift'] == 2) {
                if($mysql->execute("UPDATE  `video` SET  `bad` =  `bad` + {$_POST['member']} WHERE  `uid` ={$_POST['room']};")){
                    $mysql->execute("UPDATE  `video` SET  `pingfen` =  `good` - `bad` WHERE  `uid` ={$_POST['room']};");
                    unset($mysql);
                    die('ok');
                }else{
                    unset($mysql);
                    die(mysql_error());
                }
            }else{
                if($mysql->insert('gift', array('fromuser' => $_POST['from'], 'touser' => $_POST['room'], 'gift' => $_POST['gift'], 'member' => $_POST['member'], 'mian' => $_POST['mian']))) {
                    unset($mysql);
                    die('ok');
                }else{
                    unset($mysql);
                    die(mysql_error());
                }
            }
        }else{
            unset($mysql);
            die(mysql_error());
        }
    }


}

?>