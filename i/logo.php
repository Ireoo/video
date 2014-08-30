<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-13
 * Time: 下午11:57
 */
?>

<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script type="text/javascript">
    window.onload = function(){

        xiuxiu.setCropPresets("800x600");
        xiuxiu.setLaunchVars ("uploadBtnLabel", "上传");

        xiuxiu.embedSWF("avatar", 5, 980, 400);

        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("http://zhubo.pro/uploads/logo/<?php echo $o['id']; ?>.jpg?<?php echo rand(0, 9999999999999999999); ?>");
        };

        xiuxiu.setUploadURL("http://zhubo.pro/app/xiuxiu/logo.php?id=<?php echo $o['id']; ?>");
        //xiuxiu.setUploadArgs({'sid' : '<?php echo $id; ?>'});
        xiuxiu.setUploadType(1);
        xiuxiu.onBeforeUpload = function(data, id) {
            //alert("上传响应" + data);
        };
        xiuxiu.onUploadResponse= function(data,id) {
            //alert(data);
            location.reload();
        };
        xiuxiu.onDebug = function (data)
        {
            //alert(data);
        };
    }
</script>


<li>
    <label>上传海报
        <span>可以上传自己喜欢的图片,然后用鼠标在图片上选择合适的大小.</span>
    </label>
    <div id="avatar"></div>
</li>