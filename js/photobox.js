/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-30
 * Time: 下午3:00
 * To change this template use File | Settings | File Templates.
 */
var photobox = function(divID, sid , type) {
    var cedit = $('<button>+</button>').css({fontSize: '12px', fontWeight: 'normal', width: '194px', height: '194px', borderRadius: '0px', marginLeft: '3px'});
    $(divID).after(cedit).remove();
    cedit.click(function() {
        $('<div id="showedit"><div id="avatar"></div></div>').appendTo('body').css({position: "fixed", background: "#CCC", padding: '3px'});
        xiuxiu.setLaunchVars ("nav", "edit");
        xiuxiu.embedSWF("avatar", 1, 1000, 400);
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("");
        };
        xiuxiu.setUploadURL("http://www.ireoo.com/app/xiuxiu/storePhoto.php");
        var divID = $('#showedit');
        var winHeight = $(window).height();
        var winWidth = $(window).width();
        var divHeight = divID.height();
        var divWidth = divID.width();
        var top = (winHeight - divHeight) / 2;
        var left = (winWidth - divWidth) / 2;
        divID.css({ top: top + "px", left: left + "px"});
    });
    xiuxiu.onClose = function()
    {
        $('#showedit').remove();
    };
    xiuxiu.onBeforeUpload = function(data, id) {};
    xiuxiu.onUploadResponse= function(data,id) {
        //alert(data);
        location.reload();
    };
    xiuxiu.onDebug = function (data)
    {
        //alert(data);
    };
}
