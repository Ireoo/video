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

if(!is_array($person)) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    exit();
}

$sql = array(
    'table' => 'video',
    'condition' => "uid = $id"
);

$player = $mysql->row($sql);

if(!is_array($person)) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
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
    <title><?php echo $player['title']; ?> - 主播·Pro</title>
    <meta name="keywords" content="<?php echo $player['title']; ?>， <?php echo $person['realname']; ?>， <?php echo $person['username']; ?>，主播，主持人，直播" />
    <meta name="description" content="<?php echo $person['realname']; ?>(艺名：<?php echo $person['username']; ?>)是zhubo.pro的特约主播，期待你的支持！" />
    <link href="css/head.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script style="text/javascript" src="http://115.29.39.169:8000/socket.io/socket.io.js"></script>
    <script style="text/javascript">
        var toname = '<?php echo $person['username']; ?>';
        <?php if(!is_array($o)) { ?>
        var name = '游客';
        var avatar = 'http://ireoo.com/include/images/i_quanquan_on.png';
        var from = 0;
        <?php }else{ ?>
        var name = '<?php echo $o['username']; ?>';
        var avatar = 'http://ireoo.com/<?php echo $o['avatar_large']; ?>';
        var from = <?php echo $o['id']; ?>;
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

        <div class="title">
            <h1><?php echo $player['title']; ?></h1>
            <span>ID: <?php echo $id; ?></span>
            <span id="users">现场人数：<i>0</i></span>
        </div>

        <div class="videoBox">

            <div class="video">
                <?php if($player['yyVideo'] != '0') { ?>
                    <embed src="http://yy.com/s/<?php echo $player['yyVideo']; ?>/<?php echo $player['yyVideo']; ?>/entscene.swf" type="application/x-shockwave-flash" style="width:800px; height: 500px";>
            <?php }else{ if($player['uid'] == $o['id']) { ?>
                    <embed src="http://v.ireoo.com/app/video/recover.swf?uid=<?php echo $player['uid']; ?>" type="application/x-shockwave-flash" style="width:800px; height: 500px";>
                    <?php }else{ ?>
                    <embed src="http://v.ireoo.com/app/video/play.swf?uid=<?php echo $player['uid']; ?>" type="application/x-shockwave-flash" style="width:800px; height: 500px";>
                <?php }} ?>
                <video id="me" style="display: none;" autoplay muted></video>
            </div>

            <div class="clear"></div>
        </div>

        <div class="vs">

            <div class="bar">
                <?php
                if($player['good'] == 0 and $player['good'] == 0){
                    $barl = 400;
                    $barr = 400;
                }else{
                    $barl = $player['good']/($player['good']+$player['bad'])*800;
                    $barr = $player['bad']/($player['good']+$player['bad'])*800;
                }
                ?>
                <h1><span class="left" style="width: <?php echo $barl; ?>px;">(喜欢)<i><?php echo $player['good']; ?></i></span><span class="right" style="width: <?php echo $barr; ?>px;"><i><?php echo $player['bad']; ?></i>(炸弹)</span></h1>
            </div>
            <div class="gift">

            </div>

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

        <ul class="getgift"></ul>

        <div style="margin-bottom: 20px;">

            <script> var dsaid=49527; var dwidth=360; var dheight=150; </script> <script type="text/javascript" src="http://unionjs.dianxin.com/showPic.js" name="showpic" charset="utf-8" ></script>

        </div>

        <ul class="username">
            <h1><img src="http://ireoo.com/uploads/u/a<?php echo $person['id']; ?>.jpg" /><?php echo $person['username']; ?></h1>
            <li><?php echo '年龄：' . (DATE('Y', time() - strtotime($person['year'] . '/' . $person['mouth'] . '/' . $person['day'] . ' 00:00:00')) - 1970); ?></li>
            <li><?php echo '生日：' . $person['year'] . '年' . $person['mouth'] . '月' . $person['day'] . '日'; ?></li>
            <li><?php echo '性别：' . $person['sex']; ?></li>
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
