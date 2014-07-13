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

    <li><button>保存</button></li>
</form>