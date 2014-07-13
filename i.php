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


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $person['realname']; ?> 的直播间</title>
    <meta name="keywords" content="<?php echo $person['realname']; ?>，主播，主持人，直播，琦益" />
    <meta name="description" content="<?php echo $person['desc']; ?>" />
    <link href="css/head.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<?php include_once('include/head.php'); ?>

<div class="background">

    <div class="mian">
        <div class="chat"></div>
        <div class="player">
            <embed src="http://yy.com/s/<?php echo $player1; ?>/0/yyscene.swf" type="application/x-shockwave-flash" style="width:400px; height: 660px";>
        </div>
    </div>

</div>

<div class="mian">

    <ul>

        <?php foreach($players as $key => $value) { ?>
            <li>
                <a target="player" href="/<?php echo $value['uid']; ?>"><img src="<?php echo $value['logo']; ?>" /></a>
                <h1><a target="player" href="/<?php echo $value['uid']; ?>"><?php echo $value['title']; ?></a></h1>
            </li>
        <?php } ?>

    </ul>

</div>

</body>
</html>
