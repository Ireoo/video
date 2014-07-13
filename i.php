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
    header("Location: http://{$_SERVER['HTTP_HOST']}/i");
}

if(isset($_GET['edit']) and $_GET['edit'] == 'yes') {
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

    <?php if(is_array($player)) { ?>

        <div class="edit">

            <ul class="caidan">
                <img src="http://ireoo.com/<?php echo $o['avatar_large']; ?>" />
                <li><a href="?i=basic">基本信息</a></li>
                <li><a href="?i=logo">海报设置</a></li>
                <li><a href="?i=yy">YY直播频道绑定</a></li>
                <li><a href="?i=gift">礼物</a></li>
            </ul>

            <ul class="mian">

                <form action="?edit=yes" method="post">
                    <li>
                        <label>直播间名称</label>
                        <input name="title" value="<?php echo $player['title']; ?>" />
                    </li>

                    <li>
                        <label>直播间logo</label>
                        <input name="logo" value="<?php echo $player['logo']; ?>" />
                    </li>

                    <li>
                        <label>YY ID</label>
                        <input name="yyVideo" value="<?php echo $player['yyVideo']; ?>" />
                    </li>

                    <li>
                        <label>房间介绍</label>
                        <textarea name="connect"><?php echo $player['connect']; ?></textarea>
                    </li>

                    <li><button>保存</button></li>
                </form>

            </ul>

        </div>

    <?php }else{ ?>

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

</div>

</body>
</html>
