<div class="meun">
    <ul class="meun">
        <div<?php if(is_array($o)) {echo ' class="login"';} ?>>

            <?php
            if(is_array($o)) {
                ?>
                <a href="http://ireoo.com/i"><img src="http://ireoo.com/<?php echo $o['avatar_large']; ?>" /><span><?php echo $o['username']; ?></span></a><a href="#"><span>联系客服</span></a><a href="<?php echo HOST_URL; ?>?loginout=yes"><span>退出</span></a>
            <?php
            }else{
                ?>
                <a href="<?php echo HOST_URL; ?>login.php?url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"><span>登陆</span></a>|<a href="http://ireoo.com/reg"><span>免费注册</span></a>
            <?php
            }
            ?>
        </div>

        <li><a href="http://v.ireoo.com"><span>琦益直播</span></a></li>
    </ul>

</div>