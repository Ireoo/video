<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-8-20
 * Time: 下午10:04
 */

?>

<style type="text/css">

    li.money{font-size: 12px; color: #CCC;}
    li.money *{}
    li.money i{font-style: normal; color: red; font-weight: bold; font-size: 40px;}
    li.money a{padding: 5px 10px; margin-left: 10px; color: #FFF; background: #4898F8; font-size: 12px; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-block;}

    li ul h1{font-size: 14px; margin-bottom: 5px;}
    li ul li{margin-left: 20px; line-height: 20px; font-size: 12px;}

</style>

<li class="money">余额：<i><?php echo $o['money']; ?></i></li>

<li>
    <form action="app/alipay/alipayapi.php?token=<?php echo md5(rand(0, 10000000000)); ?>" method="post">
        <label>充值金额：</label>
        <input type="text" style="width: 100px;" name="money" />
        <input type="hidden" name="uid" value="<?php echo $o['id']; ?>" />
        <input type="hidden" name="name" value="用户 <?php echo $o['username']; ?> 充值" />
        <button>确认</button>
    </form>
</li>

<li>

    <ul>

        <h1>充值记录</h1>
<!--        <li>--><?php //echo date('Y年m月d日 H:i:s'); ?><!-- - 消费100元.</li>-->

    </ul>

</li>