<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
include_once('lib/mysql.class.php');
include_once('lib/user.class.php');
include_once('include/config.php');

//print_r($o);

$mysql = new mysql;

$sql = array(
    'table' => 'video',
    'order' => 'pingfen desc'
//    , 'condition' => "play = 1"
);

$players = $mysql->select($sql);

$player1 = 72587511;
$player2 = 50326584;
$player1 = 28446475; //【Ｈome娱乐】萌小美Ｍｏｎｋｅｙ❤直播间 新浪微博“萌小美Monkey”求关注
$player1 = 99678367; //quan

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>主播·Pro</title>
    <meta name="keywords" content="主播，主持人，直播，zhubo.pro" />
    <meta name="description" content="主播，由万达信息科技有限公司倾力打造，是个人及团队展示自我的舞台！" />
    <link href="css/head.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var meng = $('<div />').css({'background' : 'url(/images/meng.png)', 'width' : '100px', 'height' : '100px', 'position' : 'absolute', 'top' : '0', 'left' : '0'}).hide();
            $('li.sider_player a').append(meng).css({'position' : 'relative'});
            $('li.sider_player').each(function(e) {
                $(this).hover(
                    function() {
                        $('li.sider_player a div').show();
                        $(this).find('a div').hide();
                    },
                    function() {
                        $('li.sider_player a div').hide();
                    }
                );
            });

        });
    </script>
</head>
<body>
<?php include_once('include/head.php'); ?>


<div class="pk">
    <div class="mian">

        <div class="chat"></div>
        <div class="player left">
            <embed src="app/video/play.swf?uid=xyz123" type="application/x-shockwave-flash" style="width:400px; height: 300px";>
        </div>
        <div class="player right">
            <embed src="app/video/play.swf?uid=xyz123" type="application/x-shockwave-flash" style="width:400px; height: 300px";>
        </div>

    </div>
</div>

<div class="background">
    <div class="mian">

        <ul class="list">
            <?php foreach($players as $key => $value) { $v = $value['video']; ?><li class="sider_player"><a target="player" href="/<?php echo $v['uid']; ?>"><img class="pulse animated" src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /></a></li><?php } ?>
        </ul>

        <ol>
            <a class="reload"><i></i></a><a class="login" href="login"><i></i></a><a class="reg" href="reg"><i></i></a>
        </ol>

        <div class="clear"></div>

    </div>
</div>

<div class="list">
    <div class="mian">

        <ul class="list">
            <h1 class="title">热门主播</h1>
            <?php
            $sql = array(
                'table' => 'video',
                'order' => 'hua desc',
                'limit' => 'LIMIT 0, 12'
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
            ?><li><a class="img" target="_blank" href="/<?php echo $v['uid']; ?>"><img class="animated" src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /><span></span></a><div>
                    <h1><a target="_blank" href="/<?php echo $v['uid']; ?>"><img src="/uploads/u/a<?php echo $v['uid']; ?>.jpg" /></a><a target="_blank" href="/<?php echo $v['uid']; ?>"><?php echo $u['username']; ?></a></h1>
                    <span><img src="images/b.gif" /><?php echo $v['hua']; ?></span>
            </div></li><?php } ?>
        </ul>

        <?php for($i=floor(Date('H')); $i<floor(Date('H')) + 3; $i++) {
            if($i >= 24) $i = $i - 24;
            ?>

            <ul class="list">
                <h1 class="title"><?php echo $i; ?>点开播</h1>
                <?php
                $sql = array(
                    'table' => 'video',
                    'condition' => 'start = ' . $i,
                    'order' => 'hua desc',
                    'limit' => 'LIMIT 0, 12'
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
                    ?><li><a class="img" target="_blank" href="/<?php echo $v['uid']; ?>"><img class="animated" src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /><span></span></a><div>
                        <h1><a target="_blank" href="/<?php echo $v['uid']; ?>"><img src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /></a><a target="_blank" href="/<?php echo $v['uid']; ?>"><?php echo $u['username']; ?></a></h1>
                        <span><img src="images/b.gif" /><?php echo $v['hua']; ?></span>
                    </div></li><?php } ?>
            </ul>


        <?php } ?>

        <ul class="list">
            <h1 class="title">新加入主播</h1>
            <?php
            $sql = array(
                'table' => 'video',
                'order' => 'uid desc',
                'limit' => 'LIMIT 0, 12'
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
                ?><li><a class="img" target="_blank" href="/<?php echo $v['uid']; ?>"><img class="animated" src="uploads/u/a<?php echo $v['uid']; ?>.jpg" /><span></span></a><div>
                    <h1><a target="_blank" href="/<?php echo $v['uid']; ?>"><img src="/uploads/u/a<?php echo $v['uid']; ?>.jpg" /></a><a target="_blank" href="/<?php echo $v['uid']; ?>"><?php echo $u['username']; ?></a></h1>
                    <span><img src="images/b.gif" /><?php echo $v['hua']; ?></span>
                </div></li><?php } ?>
        </ul>

    </div>

    <div class="right">

        <div class="g"><script> var dsaid=49904; var dwidth=120; var dheight=240; </script> <script type="text/javascript" src="http://unionjs.dianxin.com/showPic.js" name="showpic" charset="utf-8" ></script></div>

        <ul class="timer">

            <h1>开播时间</h1>

            <?php for($i=floor(Date('H')); $i<24; $i++) { ?><li><a><?php if($i<10){echo '0' . $i;}else{echo $i;} ?> - <?php if($i<9){echo '0' . ($i + 1);}else{echo $i + 1;} ?></a></li><?php } for($i=0; $i<floor(Date('H')); $i++) { ?><li><a><?php if($i<10){echo '0' . $i;}else{echo $i;} ?> - <?php if($i<9){echo '0' . ($i + 1);}else{echo $i + 1;} ?></a></li><?php } ?>

        </ul>
    </div>

    <div class="clear"></div>

</div>

</body>
</html>
