$(function() {
    var bg = $('div.b');
    var cedit = $('<button>更换背景</button>').appendTo(bg).css({position: 'absolute', top: '270px', right: '10px', fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0px', background: '#CCC'});
    var w = cedit.width() + 20;
    var edit = $('<button>编辑</button>').appendTo(bg).css({position: 'absolute', top: '270px', right: w + 'px', fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0px'});
    var avatar = $('span#editimg').css({position: 'relative'});
    var aedit = $('<button>编辑</button>').appendTo(avatar).css({position: 'absolute', bottom: '0px', right: '0px', fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0px'});

    xiuxiu.setUploadType (1);
    xiuxiu.setLaunchVars("uploadBtnLabel", "上传到圈网");

    aedit.click(function() {
        var show = $('<div id="showedit"></div>').appendTo('body').css({position: "absolute", background: "#CCC", padding: '3px'});
        var title = $('<h1>头像编辑</h1>').appendTo(show).css({fontSize: '12px', background: 'RGB(241, 241, 241)', padding: '10px', color: 'RGB(138, 138, 138)'});
        $('<div id="avatar"></div>').appendTo(show);
        $('<a>×</a>').appendTo(title).css({float: "right", cursor: 'pointer'}).click(function() {
            show.remove();
        });
        xiuxiu.embedSWF("avatar", 5, 800, 400);
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("http://www.ireoo.com/uploads/u/s" + id + ".jpg");
        };
        xiuxiu.setUploadURL("http://www.ireoo.com/app/xiuxiu/store.php?sid=" + id);
        var winHeight = $(window).height();
        var winWidth = $(window).width();
        var divHeight = show.height();
        var divWidth = show.width();
        var top = (winHeight - divHeight) / 2;
        var left = (winWidth - divWidth) / 2;
        show.css({ top: top + "px", left: left + "px"});
    });

    edit.click(function() {
        $('<div id="showedit"><div id="avatar"></div></div>').appendTo('body').css({position: "absolute", background: "#CCC", padding: '3px'});
        xiuxiu.setCropPresets("800x300");
        xiuxiu.embedSWF("avatar", 1, 1000, 400);
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("http://www.ireoo.com/uploads/u/s" + id + "bg.jpg");
        };
        xiuxiu.setUploadURL("http://www.ireoo.com/app/xiuxiu/storeBg.php?sid=" + id);
        var divID = $('#showedit');
        var winHeight = $(window).height();
        var winWidth = $(window).width();
        var divHeight = divID.height();
        var divWidth = divID.width();
        var top = (winHeight - divHeight) / 2;
        var left = (winWidth - divWidth) / 2;
        divID.css({ top: top + "px", left: left + "px"});
    });

    cedit.click(function() {
        $('<div id="showedit"><div id="avatar"></div></div>').appendTo('body').css({position: "absolute", background: "#CCC", padding: '3px'});
        xiuxiu.setCropPresets("800x300");
        xiuxiu.setLaunchVars ("nav", "edit");
        xiuxiu.embedSWF("avatar", 1, 1000, 400);
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("");
        };
        xiuxiu.setUploadURL("http://www.ireoo.com/app/xiuxiu/storeBg.php?sid=" + id);
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
        location.reload();
    };
    xiuxiu.onDebug = function (data)
    {
        alert(data);
    };

    descEdit();
    //phoneEdit();
    tipEdit();
});


//概况编辑器

var descEdit = function() {
    var descMain = $('div.com');
    var div = $('<div />').css({marginLeft: '4px'}).hide();
    var desc = $('<textarea/>').text(descMain.html()).appendTo(div).attr('id', 'desc');
    $('ul.about').after(div);

    var succ = $('<button />').text('确认').css({fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0px', marginLeft: '5px'});

    var de = $('<button />').text('编辑').css({fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0px', marginLeft: '5px'});
    de.appendTo($('ul.about h1')).click(function() {
        if(de.text() == '编辑') {
            div.show();
            descMain.hide();
            succ.appendTo($('ul.about h1')).click(function() {
                $.ajax({
                    type: "post",
                    url: "http://www.ireoo.com/include/editDesc.php",
                    data: {
                        sid : descMain.attr('id'),
                        desc : editor.getContent()
                    },
                    beforeSend: function(re){
                        //o.attr('disabled', 'disabled').text('努力发布中...');
                    },
                    success: function(data, textStatus){
                        //alert(data);
                        if(data != 1) {
                            de.text('编辑');
                            div.hide();
                            descMain.show();
                            succ.remove();
                            alert(data);
                        }else{
                            de.text('编辑');
                            div.hide();
                            descMain.show().html(editor.getContent());
                            succ.remove();
                        }
                    }
                });
            });
            de.text('取消');
        }else{
            de.text('编辑');
            div.hide();
            descMain.show();
            succ.remove();
        }
    });
    var editor = new UE.ui.Editor();
    editor.render('desc');
};

var phoneEdit = function() {

    var add = $('<button />').text('修改').css({fontSize: '12px', fontWeight: 'normal', padding: '5px', borderRadius: '0', marginLeft: '5px'}).click(function() {
            var addLi = $('<li />').html($('li.phone').html()).addClass('phone');
            $('li.phone').after(addLi);

        }
    );
    //var li = $('<li />').append(add);
    $('li.phone').parent('ul').find('h1').append(add);

};

var tipEdit = function() {

    var del = $('<i />').text('×').css({cursor: 'pointer', fontStyle: 'normal', display: 'inline-block', textAlign: 'center', borderRadius: '15px', width: '15px', height: '15px', position: 'absolute', right: '-8px', top: '-8px', zIndex: '100', background: 'red', color: '#FFF'}).appendTo($('li.tip a').css({position: 'relative'}).hover(
        function() {
            $(this).find('i').show();
        },
        function() {
            $(this).find('i').hide();
        }
        ).click(function() {
                return false;
            }
        )).hide().click(function() {
            alert($(this).parent('a').attr('id'));
        }
    );
    var add = $('<a />').text('＋').css({cursor: 'pointer'}).appendTo($('li.tip'));
};