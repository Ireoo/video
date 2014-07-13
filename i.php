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
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<?php include_once('include/head.php'); ?>

<div class="mian">

    <?php if(is_array($player)) { ?>

    <ul>

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

    <?php }else{ ?>

    <div class="tiaokuan">

        <h1>开通主播房间条款</h1>

        <div class="connect">
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;"><strong>一、签约主播管理制度</strong></span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1）相貌端庄靓丽，视频清晰流畅，善于与粉丝观众互动。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2）具备音质良好的独立声卡、独立麦克风与红外线视频等设备。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3）具有一定的才艺表演如：唱歌、乐器或模仿秀等特长。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">4）能保证每天有稳定的开播时间（单次播出1小时以上为“有效播出次数”,每天播出3小时以上为“有效播出天数”）。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">5)每月直播直播时间不得低于100小时,单周直播时间不得低于20小时。</span><br />
            <br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;"><strong>二、签约主播直播说明</strong></span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1）开播前须检查自己的直播封面是否标准、清晰；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2）开播前须进行自己形象及视频背景整理，不能杂乱；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3）开播前要将摄像头、声卡、麦克风等直播设备调节到最佳状态；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">4）开播前检查使用的浏览器是否是双核浏览器，为保证直播质量建议使用（极速360、谷歌浏览器）并退出迅雷、快播、电驴等BT软件，确保网速正常；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">5）直播期间摄像头要对着上半身，视频区域以包含完整的头部为标准；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">6）直播时主播要及时与打字观众互动、并观看礼物动态，发现送礼物、点歌、抢车位、飞屏等消费，主播要给予回应。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">(注：开播或直播当中遇到故障问题，请在首页联系故障报修，技术可远程协助解决；并同时告知相关运营人员跟进问题，保证第一时间迅速解决问题；)</span><br />
            <br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;"><strong>三 、主播直播内容</strong></span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">一)、内容规定：&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1、 严禁表演或播放含有色情、低俗、粗口、性暗示的伴奏或影音作品、节目；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2、 严禁主播组织、传播、讨论违反国家法律法规规定的违法行为、不良信息。包括但不限于：赌博、吸毒、低俗歌曲、色情图片、谣言话题等等；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">二)、行为规定：&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1、 严禁赤身裸体、或其他不适宜外露的部位；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2、 严禁模拟模仿各种色情挑逗动作、或者诱惑性，挑逗性的表演行为；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3、 严禁穿着透明清凉、裸露服装，或各种遮掩身体形式进行表演；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">4、 严禁舞蹈节目表演，以及其他非主播直播行为；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">5、 主播在表演过程中，必须露出脸部，严禁长时间不出现头部，或以敏感部位做主体展示；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">6、 禁止主播在镜头前抽烟、喝酒、飙脏话。&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">三)、其他类：&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1、 主播应积极配合客服人员的审核管理，严禁利用观众情绪煽动闹事；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2、 严禁主播公布散发不利于公司的言论、行为；&nbsp;</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3、 严禁鼓励鼓动用户进行私下第三方平台上、线下交易，或及类似交易的行为。</span><br />
            <br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;"><strong>四、违规处罚方式</strong></span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1) 主播直播过程中，漫不经心，完全不理会游客，挂机混时间者；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：第一次（警告）、第二次（罚款100元）、第三次 （底薪取消）</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2) 主播在直播模式中，挂录像、挂照片、图片者；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：第一次（警告），第二次（罚款100元），第三次（底薪取消）</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3) 主播直播过程中，播放电影、电视剧者， 玩手机，打电话超过5分钟(包括所有与直播内容无关的电子产品)</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：第一次（警告），第二次（罚款100元），第三次（底薪减半）</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">4）主播直播过程中，主播及房间管理胡乱封人踢人，在麦辱骂用户、粗口及低俗言论者；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：第一次（警告），第二次（罚款100元），第三次（底薪减半）</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">5）直播间非主播本人使用、把主播号给他人使用者；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：未造成播出事故或扰乱平台事故则第一次警告，造成严重播出事故则扣除当月的一半底薪和奖励；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">6）主播直播时在本平台和其他平台同时开启直播的；在本直播间内出现以文字、语音等任何形式宣传其他视频平台或其他游戏平台者；</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">处理方式：第一次（警告），第二次（底薪减半），第三次（底薪取消）</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">7）诋毁平台或恶意煽动、引导其他主播、玩家、去其他视频平台者；经核查属实者；直接禁播、并扣除所有的底薪和奖金；</span><br />
            <br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;"><strong>五、申请为签约主播流程</strong></span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">1）自查，认为符合以上条件者，方可在多罗秀首页右上角，点击申请主播（我要直播），联系主播招聘的运营人员。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">2）面试，考核内容不限制，主要观察主播谈吐和仪态，以及一些基本才艺展示。</span><br />
            <span style="color:#444444;font-family:Tahoma, 'Microsoft Yahei', Simsun;background-color:#FFFFFF;">3）通过，面试通过后资料审毕，发放主播专属主播号。</span><br />
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
