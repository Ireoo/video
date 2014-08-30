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

<li class="money">本月收入：<i><?php echo $o['money']; ?></i><b>元</b></li>
<li class="money">今日收入：<i><?php echo $o['money']; ?></i><b>元</b></li>



<li>

    <ul class="chongzhi">

        <h1>收入支出记录</h1>
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