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
    li.money *{vertical-align: middle;}
    li.money i{font-style: normal; color: red; font-weight: bold; font-size: 40px;}
    li.money a{padding: 5px 10px; margin-left: 10px; color: #FFF; background: #4898F8; font-size: 12px; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-block;}

    li ul h1{font-size: 14px; margin-bottom: 5px;}
    li ul li{margin-left: 20px; line-height: 20px; font-size: 12px;}

</style>

<li class="money">余额：<i><?php echo $o['money']; ?></i><a href="pay" target="_blank">充值</a></li>

<li>

    <ul>

        <h1>消费记录</h1>
        <li><?php echo date('Y年m月d日 H:i:s'); ?> - 消费100元.</li>

    </ul>

</li>