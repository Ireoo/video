/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-25
 * Time: 下午4:26
 * To change this template use File | Settings | File Templates.
 */


var saybox = function(obj, sid, tid) {

    var textarea = $('<textarea></textarea>'),
        span = $('<span></span>'),
        button = $('<button>发送</button>'),
        div = $('<div></div>'),
        hide = $('<div></div>'),
        zhe = $('<div></div>'),
        imgArea = $('<span />');


    $(obj).append(textarea).append(button).append(hide).append(zhe).append(span).append(imgArea);
    //span.append(em);

    $(obj).css({position: 'relative'});
    w = $(obj).width() - 3 - 90;
    textarea.width(w).height(68).css({borderRadius: '0', maxWidth: w + 'px', padding: '5px', marginRight: '1px', outline: 'none', resize: 'none', fontSize: '1em'}); // paddingBottom: '30px',
    span.width(w + 12).height(24).css({display: 'block', padding: '1px 0px', position: 'relative'});
    button.width(80).height(80);
    hide.width(80).height(80).css({background: '#EBEBEB', display: 'inline-block', textAlign: 'center', lineHeight: '80px', fontSize: '14px', fontWeight: 'bold', color: '#CCC'}).text('发送').hide();
    zhe.width(w + 8).height(75).css({background: '#CCC', position: 'absolute', top: '3px', left: '2px', color: '#EBEBEB', fontSize: '12px', textAlign: 'center', lineHeight: '75px'}).text('发布中...').hide();
    imgArea.css({display: 'block', padding: '1px 0px'});

    button.click(function() {
        button.hide();
        hide.show();
        zhe.show();

        var imgInput = '';

        $.each(imgArea.find('img'), function(i, img) {
            if(i>0) {
                imgInput += ',' + $(this).attr('id');
            }else{
                imgInput += $(this).attr('id');
            }
        });

        $.ajax({
            type: "post",
            url: "http://ireoo.com/include/php/say.php",
            data: {
                sid : sid,
                tid : tid,
                txt : textarea.val(),
                img : imgInput
            },
            beforeSend: function(re){
                //o.attr('disabled', 'disabled').text('努力发布中...');
            },
            success: function(data, textStatus){
                //alert(data);
                if(data != 1) {
                    //o.removeAttr('disabled').text(text);
                    //o.parent().parent().find('textarea').css('background', '#FFF');
                    button.show();
                    hide.hide();
                    zhe.hide();
                    alert(data);
                    //alert("亲，您说话的速度太快啦，休息下吧！");
                }else{
                    location.reload(true);
                }
            }
        });
    });

    textarea.autoResize({
        // On resize:
        onResize : function() {
            $(this).css({opacity:0.8});
        },
        // After resize:
        animateCallback : function() {
            $(this).css({opacity:1});
        },
        // Quite slow animation:
        animateDuration : 100,
        // More extra space:
        extraSpace : 0
    });

    var cssStyle = {padding: '0px 5px', fontSize: '12px', fontWeight: 'normal', background: '#CCC', color: '#FFF', marginRight: '1px', height: '24px'};
    var cssImg = {padding: '5px', fontSize: '12px', fontWeight: 'normal', background: '#CCC', color: '#FFF', marginRight: '1px', marginBottom: '1px'};
    var phiz = $('<button />').text('表情').css(cssStyle).hover(
        function() {
            $(this).css({background: '#4898F8'});
        },
        function() {
            $(this).css({background: '#CCC'});
        }
    );
    var photo = $('<button />').text('照片').css(cssStyle).hover(
        function() {
            $(this).css({background: '#4898F8'});
        },
        function() {
            $(this).css({background: '#CCC'});
        }
    ).click(function() {
            var t = $(this).text('加载...');
            $.getScript('http://open.web.meitu.com/sources/xiuxiu.js', function() {
                t.text('照片');
                var divID = $('<div id="showedit"><div id="photo"></div></div>').appendTo('body').css({position: "fixed", background: "#CCC", padding: '3px'});
                xiuxiu.setLaunchVars ("nav", "edit");
                xiuxiu.embedSWF("photo", 1, 800, 400);
                xiuxiu.onInit = function ()
                {
                    xiuxiu.loadPhoto("");
                };
                xiuxiu.setUploadURL("http://ireoo.com/app/xiuxiu/photo.php?id=" + sid);
                var winHeight = $(window).height();
                var winWidth = $(window).width();
                var divHeight = divID.height();
                var divWidth = divID.width();
                var top = (winHeight - divHeight) / 2;
                var left = (winWidth - divWidth) / 2;
                divID.css({ top: top + "px", left: left + "px"});
                xiuxiu.onClose = function()
                {
                    divID.remove();
                };
                xiuxiu.onBeforeUpload = function(data, id) {};
                xiuxiu.onUploadResponse= function(data,id) {
                    if(data == -1) {
                        alert('文件不存在，请重新选择');
                        divID.remove();
                    }else if(data == 0) {
                        alert('上传失败，请稍后再试');
                    }else{
                        divID.remove();
                        //alert(data);
                        var showImg = $('<img />').attr('src', '/image.' + data + '.100.100.1').attr('id', data).width(100).height(100);
                        var showButton = $('<button />').css(cssImg).attr('title', '单击去除，但图片任在我的相册中保存').append(showImg).hover(
                            function() {
                                $(this).css({background: '#4898F8'});
                            },
                            function() {
                                $(this).css({background: '#CCC'});
                            }
                        ).click(function() {
                                $(this).remove();
                            });
                        imgArea.append(showButton);
                    }
                };
                xiuxiu.onDebug = function (data)
                {
                    //alert(data);
                };
            });

        });

    span.append(phiz).append(photo);

};


/*
 * Query autoResize (textarea auto-resizer)
 * @copyright James Padolsey http://james.padolsey.com
 * @version 1.04
 */

(function($){

    $.fn.autoResize = function(options) {

        // Just some abstracted details,
        // to make plugin users happy:
        var settings = $.extend({
            onResize : function(){},
            animate : true,
            animateDuration : 150,
            animateCallback : function(){},
            extraSpace : 20,
            limit: 1000
        }, options);

        // Only textarea's auto-resize:
        this.filter('textarea').each(function(){

            // Get rid of scrollbars and disable WebKit resizing:
            var textarea = $(this).css({resize:'none','overflow-y':'hidden'}),

            // Cache original height, for use later:
                origHeight = textarea.height(),

            // Need clone of textarea, hidden off screen:
                clone = (function(){

                    // Properties which may effect space taken up by chracters:
                    var props = ['height','width','lineHeight','textDecoration','letterSpacing'],
                        propOb = {};

                    // Create object of styles to apply:
                    $.each(props, function(i, prop){
                        propOb[prop] = textarea.css(prop);
                    });

                    // Clone the actual textarea removing unique properties
                    // and insert before original textarea:
                    return textarea.clone().removeAttr('id').removeAttr('name').css({
                        position: 'absolute',
                        top: 0,
                        left: -9999
                    }).css(propOb).attr('tabIndex','-1').insertBefore(textarea);

                })(),
                lastScrollTop = null,
                updateSize = function() {

                    // Prepare the clone:
                    clone.height(0).val($(this).val()).scrollTop(10000);

                    // Find the height of text:
                    var scrollTop = Math.max(clone.scrollTop(), origHeight) + settings.extraSpace,
                        toChange = $(this).add(clone);

                    // Don't do anything if scrollTip hasen't changed:
                    if (lastScrollTop === scrollTop) { return; }
                    lastScrollTop = scrollTop;

                    // Check for limit:
                    if ( scrollTop >= settings.limit ) {
                        $(this).css('overflow-y','hidden');
                        return;
                    }
                    // Fire off callback:
                    settings.onResize.call(this);

                    // Either animate or directly apply height:
                    settings.animate && textarea.css('display') === 'block' ?
                        toChange.stop().animate({height:scrollTop}, settings.animateDuration, settings.animateCallback)
                        : toChange.height(scrollTop);
                };

            // Bind namespaced handlers to appropriate events:
            textarea
                .unbind('.dynSiz')
                .bind('keyup.dynSiz', updateSize)
                .bind('keydown.dynSiz', updateSize)
                .bind('change.dynSiz', updateSize);

        });

        // Chain:
        return this;

    };



})(jQuery);