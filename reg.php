<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
$get_start_time = time();
require_once("lib/mysql.class.php");
require_once("lib/user.class.php");
require_once("include/config.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>帐号注册 - <?php echo HOST_NAME; ?></title>
        <meta name="keywords" content="<?php echo '注册星主播帐号，' . KEYWORDS; ?>" />
    	<meta name="description" content="<?php echo DESCRIPTION; ?>" />
    	<link href="css/head.css" rel="stylesheet" type="text/css">
        <link href="css/rl.css" rel="stylesheet" type="text/css">
        <link href="css/foot.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript">

        	
        	function reg() {
        		//alert('ok');
        		$('button.button').hide();
        		yan = $('li.result').show();
	        	$.ajax({
	        		type: "post",
	        		url: "include/reg.php",
	        		data: {
	        			phone:$('#phone').val(),
	        			yanzheng:$('#yanzheng').val(),
	        			username:$('#username').val(),
	        			password:$('#password').val(),
	        			password2:$('#password2').val()
	        		},
	        		beforeSend: function(re){
	        			yan.show();
	        			yan.html('努力注册中...');
	        		},
	        		success: function(data, textStatus){
	        			yan.html(data);
	        			if(data != '注册成功！') {
                            $('button.button').show();
                        }else{
                            location.href = '/i';
                        }
	        		}
	        	});
	        	return false;
        	}
        </script>
    </head>
    <body>
        <div class="logo">
		<div>
			<a href="http://zhubo.pro">星主播</a>
			<a class="right" href="http://zhubo.pro/login">登陆星主播</a>
		</div>
        </div>
        <div class="mian">
		<div>
			<h1>加入星主播</h1>
			<h2>星主播，展示自我的平台</h2>
		</div>
		
        	<ul>
			<h3>创建一个免费的帐号</h3>
	        	<li>
	        		<label>手机号码：</label>
	        		<input name="phone" id="phone" type="text" value="" />
	        	</li>
                <!--
	        	<li>
	        		<label>验证码：</label>
	        		<input name="yanzheng" id="yanzheng" class="sl" type="text" value="" />
                    <span><a onclick="return yanzheng();" class="get" href="#">获取验证码</a></span>
	        	</li>
                -->
	        	<li>
	        		<label>昵称：</label>
	        		<input name="username" id="username" type="text" value="" />
				<span class="ur"></span>
	        	</li>
	        	<li>
	        		<label>注册密码：</label>
	        		<input name="password" id="password" type="password" value="" />
	        	</li>
	        	<li>
	        		<label>确认密码：</label>
	        		<input name="password2" id="password2" type="password" value="" />
	        	</li>
	        	<li class="result"></li>
	        	<li><button type="button" onclick="return reg();">立即注册</button></li>
	        </ul>
        	<div class="right" style="display: none;">
        	   <?php
        	   $mysql = new mysql;
        	   foreach($mysql->select(array('table'=>'store','limit'=>'LIMIT 0, 3')) as $k => $v) {
            	   echo '<a title="' . $v['store']['sname'] . '" href="' . HOST_URL . $v['store']['id'] . '"><img src="u/s' . $v['store']['id'] . '.jpg" /></a>';
        	   }
        	   ?>
        	</div>
        	<br class="clear" />
        </div>
<?php require_once("include/foot.php"); ?>
    </body>
</html>
