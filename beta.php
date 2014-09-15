<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-9-12
 * Time: 上午6:23
 */

header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
include_once('lib/mysql.class.php');
include_once('lib/user.class.php');
include_once('include/config.php');

//print_r($o);

$mysql = new mysql;


if(isset($_GET['id'])) {
    $sql = array(
        'table' => 'video',
        'condition' => "uid = {$_GET['id']}"
    );

    $player = $mysql->row($sql);
    $player['yyVideo'] = $player['yyVideo'] . '/' . $player['yyVideo'];

    $sql = array(
        'table' => 'user',
        'condition' => "id = {$_GET['id']}"
    );

    $person = $mysql->row($sql);
    //print_r($player);
}else{
    $player['yyVideo'] = '36158250/629064507';
    $person = array(
        'username' => '560',
        'id' => '0'
    );
}




$player1 = 72587511;
$player2 = 50326584;
$player1 = 28446475; //【Ｈome娱乐】萌小美Ｍｏｎｋｅｙ❤直播间 新浪微博“萌小美Monkey”求关注
$player1 = 99678367; //quan

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>星主播，展示自我的平台</title>
    <meta name="keywords" content="星主播，主播，主持人，直播，zhubo.pro" />
    <meta name="description" content="主播，由万达信息科技有限公司倾力打造，是个人及团队展示自我的舞台！" />
    <link href="css/beta.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script style="text/javascript" src="http://ireoo.com:8000/socket.io/socket.io.js"></script>
    <script style="text/javascript">
        var toname = '<?php echo $person['username']; ?>';
        <?php if(!is_array($o)) { ?>
        var name = '<?php echo str_replace('&nbsp;', '', getIPLoc_QQ(thisIP())); ?>用户';
        var avatar = 'http://ireoo.com/include/images/i_quanquan_on.png';
        var from = 0;
        <?php }else{ ?>
        var name = '<?php echo $o['username']; ?>';
        var avatar = 'uploads/u/a<?php echo $o['id']; ?>.jpg';
        var from = <?php echo $o['id']; ?>;
        <?php } ?>
        var room = '<?php echo $person['id']; ?>';
        var thisURL = '<?php echo curPageURL(); ?>';
    </script>
    <script style="text/javascript" src="js/beta.js"></script>
</head>
<body>
<?php include_once('include/head.php'); ?>

<div style="padding: 10px; font-size: 30px; text-align: center; background: #80bcf8; font-weight: bolder; font-family: 'microsoft yahei';">
    从今天开始注册就送10元礼物券，本活动到9月30日！
</div>

<div class="player">
    <div class="users">现场用户：<i><?php echo rand(1000, 3000); ?></i></div>
    <div class="video">

        <?php if($player['yyVideo'] != '0') { ?>
            <embed src="http://yy.com/s/<?php echo $player['yyVideo']; ?>/entscene.swf" type="application/x-shockwave-flash" style="width:666px; height: 500px";>
            <?php }else{ if($player['uid'] == $o['id']) { ?>
            <embed src="app/video/recover.swf?uid=<?php echo $player['uid']; ?>" type="application/x-shockwave-flash" style="width:666px; height: 500px";>
                    <?php }else{ ?>
            <embed src="app/video/play.swf?uid=<?php echo $player['uid']; ?>" type="application/x-shockwave-flash" style="width:666px; height: 500px";>
                <?php }} ?>

    </div>
    <div class="chatBox">
        <div class="getgift"></div>
        <div class="chat"></div>
        <div class="input">
            <span class="face"></span><input id="say" placeholder="说点什么吧，按回车键发送" />
        </div>
    </div>

</div>

<div class="gift"></div>

<div class="list">
    <div class="mian">

        <ul class="list">
            <?php
            $sql = array(
                'table' => 'video',
                'order' => 'hua desc'

//                ,'limit' => 'LIMIT 0, 12'
//    , 'condition' => "play = 1"
            );
            $list = $mysql->select($sql);
            foreach($list as $key => $value) {
                $v = $value['video'];
                $thissql = array(
                    'table' => 'user',
                    'condition' => 'id = ' . $v['uid']
                );
                $u = $mysql->row($thissql);
                ?><li><a class="img" href="beta!<?php echo $v['uid']; ?>"><img class="animated" src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /><span></span></a><div>
                    <h1><a href="beta!<?php echo $v['uid']; ?>"><img src="/uploads/u/a<?php echo $v['uid']; ?>.jpg" /></a><a href="beta!<?php echo $v['uid']; ?>"><?php echo $u['username']; ?></a></h1>
                    <span><img src="images/b.gif" /><?php echo $v['hua']; ?></span>
                </div></li><?php } ?>
        </ul>

    </div>



    <div class="clear"></div>

</div>

<?php include_once('include/foot.php'); ?>

</body>
</html>