<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");

include_once('lib/mysql.class.php');


$id = $_GET['id'];
if(!isset($_GET['id'])) $id = 123456789;
$mysql = new mysql;

$sql = array(
    'table' => 'user',
    'condition' => "id = $id"
);

$person = $mysql->row($sql);

if(!is_array($person)) {
    include('error.php');
    exit();
}

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
    <title><?php echo $person['realname']; ?> 的直播间</title>
    <meta name="keywords" content="<?php echo $person['realname']; ?>，主播，主持人，直播，琦益" />
    <meta name="description" content="<?php echo $person['desc']; ?>" />
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">

    </script>

</head>
<body>
<div class="top">
    <div class="mian">
        <img class="avatar" src="http://ireoo.com/<?php echo $person['avatar_large']; ?>" />
        <ul>
            <h1><?php echo $person['realname']; ?><span><?php echo $person['synopsis']; ?></span></h1>

            <?php
            $bothday = mktime(0, 0, 0, $person['mouth'], $person['day'], $person['year']);
            ?>
            <div><?php echo 'http://v.ireoo.com/' . $id; ?></div>
        </ul>
    </div>
</div>

<div class="mian">

    <ol>
        <!--        <h1>联系方式</h1>-->
        <!--        <li>联系电话：--><?php //echo $person['phone']; ?><!--</li>-->
        <!--        <li>联系QQ：--><?php //echo $person['qq']; ?><!--</li>-->
        <!--        <li>微信号：--><?php //echo $person['wechat']; ?><!--</li>-->
        <!--        <li>MSN：--><?php //echo $person['msn']; ?><!--</li>-->
        <!--        <li>SKYPE：--><?php //echo $person['skype']; ?><!--</li>-->
        <!--        <li>邮箱：--><?php //echo $person['email']; ?><!--</li>-->
        <!--        <li>公司：--><?php //echo $person['company']; ?><!--</li>-->
        <!--        <li>详细地址：--><?php //echo $person['address']; ?><!--</li>-->

        <ul>
            <h1>资料</h1>
            <li><?php echo '年龄：' . (DATE('Y', time() - $bothday) - 1970); ?></li>
            <li><?php echo '生日：' . $person['year'] . '年' . $person['mouth'] . '月' . $person['day'] . '日'; ?></li>
            <li><?php echo '性别：' . $person['sex']; ?></li>
            <li><?php echo '情感：' . $person['love']; ?></li>
        </ul>

        <ul>
            <h1>简介</h1>
            <li><?php echo $person['desc']; ?></li>
        </ul>

        <ul class="gift">
            <h1>礼物</h1>
        </ul>

        <ul>
            <h1>二维码</h1>
            <li><img class="QRcode" src="<?php echo $PNG_WEB_DIR.basename($filename); ?>" /></li>
            <li>扫描二维码将信息保存到手机通讯录</li>

            <li><button id="follow" style="width: 100%; height: 50px; background: #4898F8; color: #FFF; font-size: 24px; border: none;">关注我</button></li>
        </ul>

        <ul class="list">
            <h1>用户列表</h1>
        </ul>
    </ol>

    <div class="right">
        <div class="video">
            <video id="boss" autoplay></video>
            <video id="me" style="display: none;" autoplay muted></video>
        </div>
        <div class="input">
            <input id="say" />
        </div>

        <div class="chat">

        </div>

    </div>
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
