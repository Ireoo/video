<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-9-16
 * Time: 上午10:24
 */
header("Content-type: text/html; charset=utf-8");
include_once("../oauth/oauth2.php");
date_default_timezone_set("PRC");
session_start();
include_once('../../lib/mysql.class.php');
include_once('../../lib/user.class.php');
include_once('../../include/config.php');

//print_r($o);

$id = $_GET['id'];
//if(!isset($_GET['id'])) $id = 123456789;
$mysql = new mysql;
$sql = array(
    'table' => 'video',
    'condition' => "uid = $id"
);

$player = $mysql->row($sql);

if($player['yyVideo'] != '0') {
    $url = "http://yy.com/s/{$player['yyVideo']}/{$player['yyVideo']}/entscene.swf";
}else if($player['uid'] == $o['id']) {
    $url = "http://zhubo.pro/app/video/recover.swf?uid={$player['uid']}";
}else{
    $url = "http://zhubo.pro/app/video/play.swf?uid={$player['uid']}";
}

//$data = file_get_contents($url);
//
//echo $data;

header("Location: $url");