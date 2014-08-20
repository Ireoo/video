<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-8-20
 * Time: 下午9:15
 */

if(isset($_GET['edit']) and $_GET['edit'] == 'user') {
    foreach($_POST as $k => $v) {
        if($k != 'desc') {
            $_POST[$k] = htmlspecialchars($v);
        }
    }
    print_r($_POST);
    $mysql->update('user', $_POST, "id = {$o['id']}");
    echo mysql_error();
    header("Location: http://{$_SERVER['HTTP_HOST']}/i?i=user");
}



?>
<script type="text/javascript" charset="utf-8" src="app/ueditor/config.js"></script>
<script type="text/javascript" charset="utf-8" src="app/ueditor/editor_all.js"></script>
<script type="text/javascript">
    $(
        function() {
            var ue = UE.getEditor('editor');

            //显示选择位置
            $('ul.city li').click(function(e) {
                $(this).addClass('hover');
            }).hover(
                function() {},
                function() {
                    $(this).removeClass('hover');
                }
            );

        }
    );
</script>
<form action="?i=user&edit=user" method="post">

    <li>
        <label>昵称</label>
        <input name="username" value="<?php echo $o['username']; ?>" />
    </li>

    <li>
        <label>真实姓名</label>
        <input name="realname" value="<?php echo $o['realname']; ?>" />
    </li>

    <li>
        <label>手机号（登陆账号）</label>
        <input name="phone" value="<?php echo $o['phone']; ?>" />
    </li>

    <li>
        <label>生日</label>
        <input class="year" name="year" type="text" value="<?php echo $o['year']; ?>" />年
        <select name="mouth">
            <?php for($i = 1; $i<=12; $i++) { ?>
                <option<?php if($o['mouth'] == $i) {echo ' selected';} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>月
        <select name="day">
            <?php for($i = 1; $i<=31; $i++) { ?>
            <option<?php if($o['day'] == $i) {echo ' selected';} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>日
    </li>

    <li>
        <label>性别</label>
        <select name="sex">
            <option value=""></option>
            <option<?php if($o['sex'] == '男') {echo ' selected';} ?> value="男">男</option>
            <option<?php if($o['sex'] == '女') {echo ' selected';} ?> value="女">女</option>
        </select>
    </li>

    <li>
        <label>自我简介</label>
        <textarea id="editor" name="desc"><?php echo $o['desc']; ?></textarea>
    </li>

    <li><button>保存</button></li>
</form>