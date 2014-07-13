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

        $('#edit').click(function() {
            $('img#show').hide();
            xiuxiu.embedSWF("avatar", 1, 580, 300);
            xiuxiu.onInit = function ()
            {
                xiuxiu.loadPhoto("");
            };
            $('div.windows').show();
        });

        xiuxiu.onClose = function()
        {
            $('#xiuxiuEditor').after('<div id="avatar"></div>').remove();
            $('div.windows').hide();
        };
        xiuxiu.setUploadURL("http://v.ireoo.com/app/xiuxiu/logo.php?id=<?php echo $o['id']; ?>");
        //xiuxiu.setUploadArgs({'sid' : '<?php echo $id; ?>'});
        xiuxiu.setUploadType (1);
        xiuxiu.onBeforeUpload = function(data, id) {
            //alert("上传响应" + data);
        };
        xiuxiu.onUploadResponse= function(data,id) {
            //alert(data);
            location.reload();
        };
        xiuxiu.onDebug = function (data)
        {
            alert(data);
        };
    }
</script>


<li>
    <label>上传海报
        <span>可以上传自己喜欢的图片,然后用鼠标在图片上选择合适的大小.</span>
    </label>
    <div id="avatar"><img width="400" src="/uploads/logo/<?php echo $o['id']; ?>.jpg" </div>
</li>

<li><button id="edit">上传新好报</button></li>