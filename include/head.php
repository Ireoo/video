<div class="meun">
    <ul class="meun">
        <div<?php if(is_array($o)) {echo ' class="login"';} ?>>

            <?php
            if(is_array($o)) {
                ?>
                <a target="_blank" href="/i"><img src="uploads/u/a<?php echo $o['id']; ?>.jpg" /><span><?php echo $o['username']; ?></span></a><a><span>余额：<?php echo $o['money']; ?></span></a><a href="/<?php echo $o['id']; ?>"><span>直播</span></a><a href="<?php echo HOST_URL; ?>?loginout=yes"><span>退出</span></a>
            <?php
            }else{
                ?>
                <a href="<?php echo HOST_URL; ?>login?url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"><span>登陆</span></a>|<a href="<?php echo HOST_URL; ?>reg"><span>免费注册</span></a>
            <?php
            }
            ?>
        </div>

        <li><a href="http://v.ireoo.com"><span>主播·Pro</span></a></li>
    </ul>

</div>