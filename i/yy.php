<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-13
 * Time: 下午11:53
 */

?>

<form action="?edit=yes" method="post">
    <li>
        <label>YY ID
            <span>绑定后，在YY直播，这里也可以同步显示哦！</span>
        </label>
        <input name="yyVideo" value="<?php echo $player['yyVideo']; ?>" />
    </li>

    <li><button>保存</button></li>
</form>