<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-13
 * Time: 下午11:38
 */
?>

<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script type="text/javascript">

    xiuxiu.embedSWF("avatar", 5, 980, 400);

    xiuxiu.onInit = function ()
    {
        // your code here
        xiuxiu.loadPhoto("http://zhubo.pro/uploads/u/a<?php echo $o['id']; ?>.jpg?<?php echo rand(0, 9999999999999999999); ?>");
    };

    xiuxiu.setUploadURL("http://zhubo.pro/app/xiuxiu/avatar.php?uid=<?php echo $o['id']; ?>");
    //xiuxiu.setUploadArgs({'uid' : '<?php echo $o['id']; ?>'});
xiuxiu.setUploadType(1);

xiuxiu.onBeforeUpload = function(data, id) {
//alert("上传响应" + data);
};

xiuxiu.onUploadResponse= function(data, id) {
//alert(data);
    location.reload();
};

xiuxiu.onDebug = function (data)
{
//alert(data);
}
</script>


<li>
    <label>上传修改头像
        <span>可以上传自己喜欢的图片,然后用鼠标在图片上选择合适的大小.</span>
    </label>
    <div id="avatar"></div>
</li>