<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
include_once('lib/mysql.class.php');
include_once('lib/user.class.php');
include_once('include/config.php');

//print_r($o);

$id = $_GET['id'];
if(!isset($_GET['id'])) $id = 123456789;
$mysql = new mysql;

$sql = array(
    'table' => 'user',
    'condition' => "id = $id"
);

$person = $mysql->row($sql);

//if(!is_array($person)) {
//    include('error.php');
//    exit();
//}

$sql = array(
    'table' => 'video',
    'condition' => "uid = $id"
);

$player = $mysql->row($sql);

//if(!is_array($person)) {
//    include('error.php');
//    exit();
//}

//QRcode
include_once('app/phpqrcode/qrlib.php');

$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';

if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);

$filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

QRcode::png('http://v.ireoo.com/' . $id, $filename, 'H', 10, 0);
//QRcode::png(curPageURL(), $filename, 'H', 10, 0);

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $player['title']; ?> - 主播·Pro</title>
    <meta name="keywords" content="<?php echo $player['title']; ?>, <?php echo $person['realname']; ?>，主播，主持人，直播" />
    <meta name="description" content="<?php echo $person['desc']; ?>" />
    <link href="css/head.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script style="text/javascript" src="http://115.29.39.169:8000/socket.io/socket.io.js"></script>
    <script style="text/javascript">
        <?php if(!is_array($o)) { ?>
        var name = '游客';
        var avatar = 'http://ireoo.com/include/images/i_quanquan_on.png';
        <?php }else{ ?>
        var name = '<?php echo $o['username']; ?>';
        var avatar = 'http://ireoo.com/<?php echo $o['avatar_large']; ?>';
        <?php } ?>
        var room = '<?php echo $person['id']; ?>';
        var thisURL = '<?php echo curPageURL(); ?>';
    </script>
    <script style="text/javascript" src="js/io.js"></script>

</head>
<body>
<?php include_once('include/head.php'); ?>

<div class="all">

    <div class="videoBackground">

        <!--    <div class="avatar">-->
        <!--        <img class="avatar" src="http://ireoo.com/--><?php //echo $person['avatar_large']; ?><!--" />-->
        <!--        <ul>-->
        <!--            <h1>--><?php //echo $person['realname']; ?><!--</h1>-->
        <!---->
        <!--            <div class="desc">--><?php //echo $person['synopsis']; ?><!--</div>-->
        <!--            <div>--><?php //echo 'http://v.ireoo.com/' . $id; ?><!--</div>-->
        <!--        </ul>-->
        <!--        <div class="clear"></div>-->
        <!--    </div>-->

        <div class="title">
            <h1><?php echo $player['title']; ?></h1>
            <span>ID: <?php echo $id; ?></span>
        </div>

        <div class="videoBox">

            <div class="video">
                <?php if($player['yyVideo'] != '0') { ?>
                    <embed src="http://yy.com/s/<?php echo $player['yyVideo']; ?>/0/entscene.swf" type="application/x-shockwave-flash" style="width:800px; height: 500px";>
            <?php }else{ ?>
                    <video id="boss" autoplay></video>
                <?php } ?>
                <video id="me" style="display: none;" autoplay muted></video>
            </div>

            <div class="clear"></div>
        </div>


        <div class="list"></div>

        <div class="con">

            <ul>
                <h1>简介</h1>
                <li><?php echo $person['desc']; ?></li>
            </ul>

        </div>

    </div>

    <ol>
        <div class="chatBox">
            <div class="chat"></div>
            <div class="input">
                <span class="face"></span><input id="say" placeholder="说点什么吧，按回车键发送" />
            </div>
        </div>

        <div style="margin-bottom: 20px;">

            <script> var dsaid=49527; var dwidth=360; var dheight=150; </script> <script type="text/javascript" src="http://unionjs.dianxin.com/showPic.js" name="showpic" charset="utf-8" ></script>

        </div>

        <ul>
            <h1>资料</h1>
            <li><?php echo '年龄：' . (DATE('Y', time() - strtotime($person['year'] . '/' . $person['mouth'] . '/' . $person['day'] . ' 00:00:00')) - 1970); ?></li>
            <li><?php echo '生日：' . $person['year'] . '年' . $person['mouth'] . '月' . $person['day'] . '日'; ?></li>
            <li><?php echo '性别：' . $person['sex']; ?></li>
            <li><?php echo '情感：' . $person['love']; ?></li>
        </ul>

    </ol>
    <div class="clear"></div>
</div>

</body>
</html>

<?php
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
?>
