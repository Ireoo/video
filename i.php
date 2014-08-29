<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-13
 * Time: 下午5:51
 */

header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
include_once('lib/mysql.class.php');
include_once('lib/user.class.php');
include_once('include/config.php');

//print_r($o);
if(!isset($o)) header("Location: http://{$_SERVER['HTTP_HOST']}/login?url={$_SERVER['HTTP_HOST']}/i");

$mysql = new mysql;

if(isset($_GET['player']) and $_GET['player'] == 'yes') {
    $mysql->insert('video', array('uid' => $o['id']));
    header("Location: http://{$_SERVER['HTTP_HOST']}/i?i=basic");
}

if(isset($_GET['edit']) and $_GET['edit'] == 'yes') {
    foreach($_POST as $k => $v) {
        $_POST[$k] = htmlspecialchars($v);
    }
    $mysql->update('video', $_POST, "uid = {$o['id']}");
    header("Location: http://{$_SERVER['HTTP_HOST']}/i");
}


$sql = array(
    'table' => 'video',
    'condition' => 'uid = ' . $o['id']
);

$player = $mysql->row($sql);


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $o['username']; ?></title>
    <meta name="keywords" content="主播，主持人，直播，琦益" />
    <meta name="description" content="" />
    <link href="css/head.css" rel="stylesheet" type="text/css">
    <link href="css/i.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>

</head>
<body>
<?php include_once('include/head.php'); ?>

<div class="mian">

    <?php
    if(isset($_GET['i'])) {
        $page = $_GET['i'];
    }else{
        $page = 'user';
    }
    ?>

        <div class="edit">

            <ul class="caidan">
                <img src="<?php echo $o['avatar']; ?>" />

                <a<?php if($page == 'user') {echo ' class="on"';} ?> href="?i=user">个人资料</a>
                <a<?php if($page == 'avatar') {echo ' class="on"';} ?> href="?i=avatar">头像设置</a>
                <a<?php if($page == 'money') {echo ' class="on"';} ?> href="?i=money">个人账户</a>
                <?php if(is_array($player)) { ?>
                <a<?php if($page == 'basic') {echo ' class="on"';} ?> href="?i=basic">基本信息</a>
                <a<?php if($page == 'logo') {echo ' class="on"';} ?> href="?i=logo">海报设置</a>
                <a<?php if($page == 'yy') {echo ' class="on"';} ?> href="?i=yy">YY直播频道绑定</a>
                <?php }else{ ?>
                    <a<?php if($page == 'open') {echo ' class="on"';} ?> href="?i=open">开通直播房间</a>
                <?php } ?>
            </ul>

            <ul class="mian">

                <?php if($page != 'open') {
                    include_once('i/' . $page . '.php');
                }else{
                ?>
                    <div class="tiaokuan">

                        <h1>开通主播房间条款</h1>

                        <div class="connect">
                            <?php include_once('i/tiaokuan.txt'); ?>
                        </div>

                        <div class="bt">
                            <form action="?player=yes" method="post">
                                <button>同意</button>
                                <a href="/">不同意</a>
                            </form>
                        </div>
                    </div>
                <?php } ?>

            </ul>

        </div>

</div>

</body>
</html>
