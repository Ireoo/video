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

    li ul.chongzhi{padding-top: 30px;}
    li ul.chongzhi h1{font-size: 14px; margin-bottom: 20px;}
    li ul.chongzhi li{margin: 0 0 0 20px !important; height: 30px; line-height: 30px; font-size: 12px; border-top: 1px #EBEBEB solid;}

</style>

<li class="money">余额：<i><?php echo $o['money']; ?></i><b>元</b></li>

<form action="app/alipay/alipayapi.php?token=<?php echo md5(rand(0, 10000000000)); ?>" method="post">
    <li>
        <label>充值金额：</label>
    </li>
    <li>
        <input type="text" style="width: 100px; padding: 5px; vertical-align: top;" name="money" />
        <span style="font-size: 12px; color: #333; border: 1px #ffa260 solid; background: #ffdaa1; padding: 0 10px; height: 26px; line-height: 26px; display: inline-block; vertical-align: top;">最少充值<b style="color: red;">1元</b>人民币</span>
    </li>
    <li>
        <input type="hidden" name="uid" value="<?php echo $o['id']; ?>" />
        <input type="hidden" name="name" value="用户 <?php echo $o['username']; ?> 充值" />
        <button style="display: block; padding: 5px 20px;">确认</button>
    </li>
</form>

<li>

    <ul class="chongzhi">

        <h1>充值记录(显示最后10条)</h1>
<!--        <li>--><?php //echo date('Y年m月d日 H:i:s'); ?><!-- - 消费100元.</li>-->
        <?php
        $s = array(
            'table' => 'cart',
            'condition' => 'uid = ' . $o['id'],
            'limit' => 'LIMIT 0, 10'
        );
        $r = $mysql->select($s);
        foreach($r as $key => $value) {
            $v = $value['cart'];
            echo '<li>';
            echo '<span class="timer">';
            echo Date('Y/m/d H:i:s', $v['timer']);
            echo '</span>';
            echo '<span class="value">';
            echo '充值 ' . $v['money'] . ' 元.';

            if($v['pay'] == 1) {
                echo '成功.';
            }elseif($v['pay'] == 0) {
                echo ', 等待付款.';
            }

            echo '</span>';
            echo '</li>';
        }
        ?>

    </ul>

</li>