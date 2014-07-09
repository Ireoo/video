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

// here our data
$name         = $person['office'];
$sortName     = $person['realname'];
$phone        = $person['workphone'];
$phonePrivate = $person['homephone'];
$phoneCell    = $person['phone'];
$orgName      = $person['company'];

$email        = $person['email'];

// if not used - leave blank!
$addressLabel     = '工作地址';
$addressPobox     = '';
$addressExt       = '';
$addressStreet    = $person['address'];
$addressTown      = $person['city'];
$addressRegion    = '';
$addressPostCode  = '';
$addressCountry   = 'CHINA';

// we building raw data
$codeContents  = 'BEGIN:VCARD'."\n";
$codeContents .= 'VERSION:2.1'."\n";
//
$codeContents .= 'FN:'.$sortName."\n";
$codeContents .= 'TITLE:'.$name."\n";
$codeContents .= 'ORG:'.$orgName."\n";

$codeContents .= 'URL:'.curPageURL()."\n";
$codeContents .= 'NOTE:点击上面网址查看用户详细微名片'."\n";

$codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
$codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n";
$codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n";



    $codeContents .= 'ADR;TYPE=work;'.
        'LABEL="'.$addressLabel.'":'
        .$addressPobox.';'
        .$addressExt.';'
        .$addressStreet.';'
        .$addressTown.';'
        .$addressPostCode.';'
        .$addressCountry
    ."\n";


$codeContents .= 'PHOTO;JPEG;VALUE=uri:'.$person['avatar_large']."\n";
$codeContents .= 'EMAIL:'.$email."\n";
$codeContents .= 'END:VCARD';

QRcode::png($codeContents, $filename, 'H', 10, 0);
//QRcode::png(curPageURL(), $filename, 'H', 10, 0);

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php echo $person['realname']; ?> 个人名片</title>
        <meta name="keywords" content="<?php echo $person['realname']; ?>，琦益" />
        <meta name="description" content="<?php echo $person['desc']; ?>" />
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });

            $(function() {

                $('#follow').click(function() {
                    alert('1');
                    //WeixinJSBridge.log('2');
                    weixinAddContact('gh_995f2725729f');
                    weixinShareTimeline('琦益网','您的网上商城','http://w.ireoo.com','http://ireoo.com/<?php echo $person['avatar_large']; ?>');
                    
                });

            });
            
            function weixinAddContact(name){
				WeixinJSBridge.invoke("addContact", {webtype: "1",username: name}, function(e) {
					alert(e.err_msg);
					//e.err_msg:add_contact:added 已经添加
					//e.err_msg:add_contact:cancel 取消添加
					//e.err_msg:add_contact:ok 添加成功
					if(e.err_msg == 'add_contact:added' || e.err_msg == 'add_contact:ok'){
					    //关注成功，或者已经关注过
					}
				})
			}
			
			function weixinShareTimeline(title,desc,link,imgUrl){
				WeixinJSBridge.invoke('shareTimeline',{
					"img_url":imgUrl,
					//"img_width":"640",
					//"img_height":"640",
					"link":link,
					"desc": desc,
					"title":title
				});	
			}

        </script>
    </head>
    <body>
    <div class="top">
        <div class="mian">
            <img class="avatar" src="http://ireoo.com/<?php echo $person['avatar_large']; ?>" />
            <ul>
                <h1><?php echo $person['realname']; ?><span><?php echo $person['office']; ?></span></h1>

                <?php
                $bothday = mktime(0, 0, 0, $person['mouth'], $person['day'], $person['year']);
                ?>
                <div><?php echo $person['synopsis']; ?></div>
            </ul>
        </div>
    </div>

    <ol>
        <h1>联系方式</h1>
        <li>联系电话：<?php echo $person['phone']; ?></li>
        <li>联系QQ：<?php echo $person['qq']; ?></li>
        <li>微信号：<?php echo $person['wechat']; ?></li>
        <li>MSN：<?php echo $person['msn']; ?></li>
        <li>SKYPE：<?php echo $person['skype']; ?></li>
        <li>邮箱：<?php echo $person['email']; ?></li>
        <li>公司：<?php echo $person['company']; ?></li>
        <li>详细地址：<?php echo $person['address']; ?></li>

        <h1>资料</h1>
        <li><?php echo '年龄：' . (DATE('Y', time() - $bothday) - 1970); ?></li>
        <li><?php echo '生日：' . $person['year'] . '年' . $person['mouth'] . '月' . $person['day'] . '日'; ?></li>
        <li><?php echo '性别：' . $person['sex']; ?></li>
        <li><?php echo '情感：' . $person['love']; ?></li>

        <h1>简介</h1>
        <li><?php echo $person['desc']; ?></li>



        <h1>二维码</h1>
        <li><img class="QRcode" src="<?php echo $PNG_WEB_DIR.basename($filename); ?>" /></li>
        <li>扫描二维码将信息保存到手机通讯录</li>

        <h1>想更好的销售您的产品吗？请关注我们的微信公众帐号以更好的营销您的产品！</h1>
        <li><a href="weixin://contacts/profile/gh_995f2725729f">一键关注我们</a></li>
        <li><button id="follow" style="width: 100%; height: 50px; background: #4898F8; color: #FFF; font-size: 24px; border: none;">关注我们</button></li>

    </ol>

    <div class="foot">
        <li><a href="http://ireoo.com/3Greg">创建自己的微名片</a></li>
        <li>微名片由 <a href="http://ireoo.com">万达信息科技</a> 独家技术支持</li>
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
