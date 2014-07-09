<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
session_start();
$get_start_time = time();
require_once("lib/mysql.class.php");
require_once("include/config.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>登陆<?php echo HOST_NAME; ?></title>
        <meta name="keywords" content="<?php echo '注册琦益帐号，' . KEYWORDS; ?>" />
    	<meta name="description" content="<?php echo DESCRIPTION; ?>" />
    	<link href="css/head.css" rel="stylesheet" type="text/css">
        <link href="css/rl.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript">
        function login() {
            t = $('button').parent();
            t.hide();
            yan = $('li.result');
            $.ajax({
                type: "post",
                url: "include/login.php",
                data: {
                    username:$('#username').val(),
                    password:$('#password').val()
                },
                beforeSend: function(re){
                    yan.show();
                    yan.html('努力登陆...');
                },
                success: function(data, textStatus){
                    yan.html(data);
                    if(data != '登陆成功！'){
                        t.show();
                    }else{
                        location.href="<?php echo $_GET['url']?$_GET['url']:'/'; ?>";
                    }
                }
            });
        }
        $(function() {

            $('input').focus(function() {
                $(this).parent().find('span').addClass('on');
            }).keyup(function() {
                        if($(this).val() != '') {
                            $(this).parent().find('span').hide();
                        }else{
                            $(this).parent().find('span').show();
                        }
                    }).blur(function() {
                        if($(this).val() == '') $(this).parent().find('span').removeClass('on');
                    });

            $('ul li span').click(function() {
                $(this).parent().find('input').focus();
            });

            $('input#password').keypress(function(e) {
                if(e.keyCode == '13') {
                    login();
                }
            });
        });
        </script>
    </head>
    <body>
        <div class="logo">
		<div>
			<a href="http://www.ireoo.com">琦益</a>
			<a class="right" href="http://www.ireoo.com/reg">注册琦益帐号</a>
		</div>
        </div>
        <div class="mian">
		<div>
			<h1>登陆琦益</h1>
			<h2>企业产品直销平台</h2>
		</div>
		
        	<ul>
	        	<li>
	        		<label>手机号或者邮箱：</label>
	        		<input name="username" id="username" type="text" value="" />
				<span class="ur"></span>
	        	</li>
	        	<li>
	        		<label>密码：</label>
	        		<input name="password" id="password" type="password" value="" />
	        	</li>
	        	<li class="result"></li>
	        	<li><button type="button" onclick="login();">登陆</button></li>
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
    </body>
</html>
