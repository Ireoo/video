<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-13
 * Time: 下午11:41
 */
?>

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
        <label>房间介绍</label>
        <textarea name="connect"><?php echo $player['connect']; ?></textarea>
    </li>

    <li><button>保存</button></li>
</form>