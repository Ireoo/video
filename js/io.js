/**
 * Created by Ultra on 14-7-9.
 */
$(function() {

    /**
     *
     * 调试代码
     *
     */
    localStorage.debug='*';

    /**
     * 连接服务器
     */
    var socket = io.connect("http://ireoo.com:8000");

    var usersbox = $('div.title span#users i');

    socket.on('say to everyone', function(msg) {

        chatcom(msg.name, msg.avatar, msg.msg, msg.time, msg.self);

    });

    socket.on('user disconnect', function(user) {

        $('div.list li#' + user.id).remove();
        console.log('div.list li#' + user.id);
        usersbox.text(parseInt(usersbox.text()) - 1);
        systemmsg('[系统] ' + '用户 ' + user.name + ' 离开聊天室.');

    });

    socket.on('new user connect', function(user) {

        addplayer(user.id, user.name, user.avatar);
        usersbox.text(parseInt(usersbox.text()) + 1);
        systemmsg('[系统] ' + '用户 ' + user.name + ' 进入聊天室.');

    });

    var gifttimer = 0,
        cheng = 1,
        chengtxt = '',
        giftmember = 0,
        giftid = 0,
        giftuser = '',
        giftto = '';

    socket.on('give gift', function(data) {

        var giftwidth = parseInt($('div.vs div.bar h1').width());
        //alert(1);
        var color = '##1cd14f';


        if(data.timer - gifttimer < 5000 && giftmember == data.member && giftid == data.gift && giftuser == data.from && giftto == data.room) {
            cheng = parseInt(cheng) + 1;
            if(cheng > 1 && cheng < 11) color = '#3ec896';
            if(cheng >= 11 && cheng < 21) color = '#34d2d4';
            if(cheng >= 21 && cheng < 60) color = '#3290db';
            if(cheng >= 60 && cheng < 120) color = '#433acb';
            if(cheng >= 120 && cheng < 520) color = '#753cd3';
            if(cheng >= 520 && cheng < 1314) color = '#b245d8';
            if(cheng >= 1314 && cheng < 5201314) color = '#d861b7';
            if(cheng >= 5201314) color = '#da3636';
            chengtxt = '<sup style="padding-left: 10px; color: #76bcff;">连送</sup><span style="font-weight: bold; color: #ffa34f;">×</span><span style="font-size: 20px; padding-left: 10px; color: ' + color + '">' + cheng + '</span>';
        }else{
            cheng = 1;
            chengtxt = '';
        }
        gifttimer = data.timer;
        giftid = data.gift;
        giftmember = data.member;
        giftuser = data.from;
        giftto = data.room;
        giftmsg('<spasn style="color: red;">' + data.name + '</spasn><spasn style="padding: 0 10px;">送给</spasn><spasn style="color: red;">' + data.toname + '</spasn><spasn style="padding: 0 10px; color: #D861B7;">' + data.member + '</spasn><spasn>个</spasn>' + ' <img style="height: 40px;" src="' + giftarray[data.gift].url + '" />' + chengtxt);

        if(data.gift == 1) {
            $('div.vs div.bar h1 span.left i').text(parseInt($('div.vs div.bar h1 span.left i').text()) + parseInt(data.member));
            var good = parseInt($('div.vs div.bar h1 span.left i').text());
            var bad = parseInt($('div.vs div.bar h1 span.right i').text());
            $('div.vs div.bar h1 span.left').animate({width: good/(good+bad)*giftwidth}, {speed: 1000, queue: false});
            $('div.vs div.bar h1 span.right').animate({width: bad/(good+bad)*giftwidth}, {speed: 1000, queue: false});
        }
        if(data.gift == 2) {
            $('div.vs div.bar h1 span.right i').text(parseInt($('div.vs div.bar h1 span.right i').text()) + parseInt(data.member));
            var good = parseInt($('div.vs div.bar h1 span.left i').text());
            var bad = parseInt($('div.vs div.bar h1 span.right i').text());
            $('div.vs div.bar h1 span.left').animate({width: good/(good+bad)*giftwidth}, {speed: 1000, queue: false});
            $('div.vs div.bar h1 span.right').animate({width: bad/(good+bad)*giftwidth}, {speed: 1000, queue: false});
        }

    });

    var giftmsg = function(msg) {

        var com = $('<div />').css({fontSize: '12px', color: '#333', padding: '10px 0'}).html(msg);
        var li = $('<li />').append(com);
        $('ul.getgift').prepend(li);
        //li.delay(10000).slideUp(1000, function() {$(this).css({backgroundColor: '#FFF'}).remove();});

    };

    socket.on('get users', function(users) {

        addplayer('', name + '(自己)', avatar);
        usersbox.text(parseInt(usersbox.text()) + 1);

        for(var i = 0; i < users.length; i++) {
            if(users[i].room == room) {
                addplayer(users[i].id, users[i].name, users[i].avatar);
                usersbox.text(parseInt(usersbox.text()) + 1);
            }
        }
        systemmsg('获取用户列表完成.');

    });

    socket.on('system', function(msg) {

        systemmsg(msg);
        //alert(data);

    });

    /**
     * 登录服务器命令
     */
    socket.emit('user connect', {
        name : name,
        avatar : avatar,
        room : room,
        toname : toname
    });

    /**
     *
     * 创建列表框
     * @type {appendTo|*|jQuery}
     */

    var listbox = $('div.list');

    var css = {listStyle: 'none', padding:'5px', display: 'inline-block'};

    var addplayer = function(socketid, player, avatar) {
        if(player == name) player += '(自己)';
        var one = $('<li />').css(css).attr('id', socketid).hover(
            function() {
                $(this).addClass('hover');
            },
            function() {
                $(this).removeClass('hover');
            }
        ).click(
            function(e) {
//                            var cunzai = false;
//                            $('ul.chatroom li').each(
//                                    function(e) {
//                                        if($(this).attr('id') == socketid) cunzai = true;
//                                    }
//                            );
//                            if(!cunzai) {
//                                addchat(socketid, player, avatar);
//                            }
            }
        );
        var img = $('<img />').attr('src', avatar).css({float: 'left'}).width(40).height(40);
        var name = $('<h2 />').text(player).css({margin: '0', padding: '0 0 0 50px', fontSize: '12px', fontWeight: 'bold'}).height(40);
//                message.append(input).append(to).append(by);
        one.append(img).appendTo(listbox); //.append(message); //.append(name)

    };

    /**
     *
     * 创建聊天框
     *
     */

    var chatroom = $('div.chat');

    var chatheight = 0;

    var chatcom = function(name, avatar, msg, timer, ziji) {
        var image = $('<img />').attr('src', avatar).attr('title', name).width(20).height(20).css({borderRadius: '3px', verticalAlign: 'bottom'});
        var a = $('<a />').attr('src', 'http://v.ireoo.com/').text(name + ':').css({'display' : 'block', 'font-size' : '12px', 'margin-bottom' : '5px'});
        msg = msg.replace(/(<.*?>)/g, function() {return '';});
        msg = msg.replace(/\{([0-9]+)\}/g, function() {return '<i style="background: url(' + faceurl + ') ' + facearray[RegExp.$1] + '; width: 30px; height: 30px; display: inline-block; vertical-align : middle;"></i>';});
        var com = $('<div />').css({background: '#EBEBEB', fontSize: '12px', borderRadius: '3px', padding: '5px', verticalAlign: 'bottom', display: 'inline-block', wordBreak: 'break-all', wordWrap: 'break-word', 'vertical-align' : 'middle'}).append(msg);
        if(!ziji) {
            var li = $('<li />').css({marginBottom: '10px'}).append(a).append(com).appendTo(chatroom); //.append(image)
            //alert('ziji');
        }else{
            com.css({background: '#4898F8', color: '#FFF'}); //, textAlign: 'left'
            var li = $('<li />').css({marginBottom: '10px'}).append(a).append(com).appendTo(chatroom); //.append(image) //, textAlign: 'right'
        }

        chatheight += li.height() + 10;
        chatroom.animate({scrollTop: chatheight}, 300);
    };

    var systemmsg = function(msg) {

        var com = $('<div />').css({display: 'inline-block', fontSize: '12px', color: '#CCC', margin: 'auto'}).html(msg);
        var li = $('<li />').css({marginBottom: '10px'}).append(com).appendTo(chatroom);
        chatheight += li.height() + 10;
        chatroom.animate({scrollTop: chatheight}, {speed: 300, queue: false});
    };

    /**
     *
     * 创建聊天框
     *
     */

    //var chatbox = $('<div />').css({borderRadius: '5px', boxShadow: '0 0 5px #333', position: 'fixed', bottom: '20px', left: '20px', overflow: 'hidden'}).width($(window).width() - 40).height(50).appendTo('body');
    var chatinput = $('input#say');
    chatinput.keypress(function(e) {
        //alert(chatinput.val());
        if(e.keyCode == 13) {

            chatroom.height(430);

//            if(name != '游客') {
            if(chatinput.val() != '') {
                var timer = (new Date()).getTime();
                var msg = chatinput.val();
                socket.emit('say to everyone', {
                    msg   : msg
                });
                //chatcom(name, avatar, msg, timer, true);
                chatinput.val('');
            }
//            }else{
//                chatcom(name, avatar, '对不起，亲爱的游客，您还没有登录哦，请先<a href="http://w.ireoo.com/login.php?url=' + thisURL + '">登录</a>', timer, true);
//            }

            return false;
        }
    });

    /**
     *
     * 表情
     *
     */

    var facearray = [
        '-1px -1px', '-32px -1px', '-63px -1px', '-94px -1px', '-125px -1px', '-156px -1px', '-187px -1px', '-218px -1px', '-249px -1px', '-280px -1px', '-311px -1px', '-342px -1px',
        '-1px -32px', '-32px -32px', '-63px -32px', '-94px -32px', '-125px -32px', '-156px -32px', '-187px -32px', '-218px -32px', '-249px -32px', '-280px -32px', '-311px -32px', '-342px -32px',
        '-1px -63px', '-32px -63px', '-63px -63px', '-94px -63px', '-125px -63px', '-156px -63px', '-187px -63px', '-218px -63px', '-249px -63px', '-280px -63px', '-311px -63px', '-342px -63px',
        '-1px -94px', '-32px -94px', '-63px -94px', '-94px -94px', '-125px -94px', '-156px -94px', '-187px -94px', '-218px -94px', '-249px -94px', '-280px -94px', '-311px -94px', '-342px -94px',
        '-1px -125px', '-32px -125px'
    ];
    var faceurl = '/images/all.gif';

    var face = $('span.face').css({"position" : "relative"})
        .click(function() {
            var facebox = $('<div />').css({'position' : 'absolute', 'bottom' : '41px', 'left' : '-35px', 'width' : '373px', 'textAlign' : 'left', 'background' : '#FFF', 'padding' : '10px', 'border' : '1px #CCC solid'}).appendTo($('div.input'));
            for(var i = 0; i < facearray.length; i++) {
                var zhi = i;
                $('<div />').css({'background' : 'url("' + faceurl + '")', 'backgroundPosition' : facearray[i], 'width' : '30px', 'height' : '30px', 'display' : 'inline-block', 'border' : '1px #CCC solid', 'margin' : '-1px 0 0 -1px', 'cursor' : 'pointer'}).appendTo(facebox).hover(
                    function() {
                        $(this).css({backgroundColor: '#EBEBEB'});
                    },
                    function() {
                        $(this).css({backgroundColor: ''});
                    }
                ).click(
                    function() {

                        facebox.remove();
                        chatinput.focus().val(chatinput.val() + '{' + $(this).attr('id') + '}');

                    }
                ).attr('id', i);
            }
        }
    );

    /**
     *
     * 礼物
     *
     *
     */

    var giftarray = [
        {title: '棒棒糖（每分钟获得一个，最高累计5个）', money : '0', url : '/images/gift/bangbangtang.gif'}
        , {title: '喜欢(增加评分)', money : '0.1', url : '/images/gift/xihuan.gif'}
        , {title: '炸弹(减少评分)', money : '0.1', url : '/images/gift/zhadan.gif'}
        , {title: '萝莉', money : '1', url : '/images/gift/luoli.gif'}
        , {title: '巧克力', money : '5', url : '/images/gift/qiaokeli.gif'}
        , {title: '拥抱', money : '8', url : '/images/gift/shuangren.gif'}
        , {title: 'i love you', money : '10', url : '/images/gift/love.gif'}
        , {title: '蓝色妖姬', money : '60', url : '/images/gift/hua.gif'}
        , {title: '钻戒', money : '100', url : '/images/gift/zuanjie.gif'}
    ];

    var giftChoose = $('<div />').css({marginBottom: '10px'});
    var giftButton = $('<div />').css({textAlign: 'right'});
    var giftMember = $('<input />').width(120).height(28).val(1).css({'vertical-align' : 'middle', 'border' : '1px #4898F8 solid', 'padding' : '0 5px', 'margin-right' : '1px'});
    var giftSend = $('<button />').width(60).height(30).text('赠送').css({'vertical-align' : 'middle'});
    var giftPay = $('<button />').width(60).height(30).text('充值').css({'vertical-align' : 'middle'});
    var giftresult = $('<div />').css({fontSize: '12px', color: 'red', display: 'inline-block'});

    var giftBox = $('div.gift');

    giftButton.append(giftresult).append(giftSend).append(giftMember).append(giftPay);
    giftBox.append(giftChoose).append(giftButton);

    var jishu = $('<span />').css({borderRadius: '10px', width: '20px', height: '20px', display: 'inline-block', background: 'red', color: '#FFF', position: 'absolute', top : '-10px', right : '-10px', fontSize: '12px', textAlign: 'center', lineHeight: '20px'}).text(0);

    for(var i = 0; i < giftarray.length; i++) {

        var bang = $('<div />').css({'width' : '67px', 'display' : 'inline-block', 'border' : '1px #EBEBEB solid', 'cursor' : 'pointer', 'padding' : '10px 0', 'margin-right' : '10px', 'text-align' : 'center'}).attr('id', i).attr('title', giftarray[i].title + "   价值:" + giftarray[i].money + '元').append($('<img />').attr('src', giftarray[i].url).height(40)).appendTo(giftChoose).hover(
            function() {
                if(!$(this).hasClass('on')) {
                    $(this).css({'borderColor' : '#333'});
                }else{
                    $(this).css({'borderColor' : '#4898F8'});
                }
            },
            function() {
                if(!$(this).hasClass('on')) {
                    $(this).css({'borderColor' : '#EBEBEB'});
                }else{
                    $(this).css({'borderColor' : '#4898F8'});
                }
            }
        ).click(
            function() {
                giftChoose.find('div').removeClass('on').css({borderColor: '#EBEBEB'});
                $(this).addClass('on').css({borderColor: '#4898F8'});
                gift = $(this).attr('id');
            }
        );

        if(i == 0) {
            bang.css({'borderColor' : '#4898F8', position: 'relative'}).addClass('on').append(jishu);
            setInterval(
                function() {
                    if(parseInt(jishu.text()) < 5) {
                        jishu.text(parseInt(jishu.text()) + 1);
                    }
                }, 60000
            );
        }

    }

    var gift = 0;

    giftSend.click(
        function() {
            var d = {
                from : from,
                name : name,
                gift : gift,
                member : giftMember.val(),
                room : room,
                timer : new Date().getTime(),
                toname : toname
            };

            if(gift != 0) {
                $.post("/app/post/gift.php", d, function(result) {
                    if(result == 'ok') {
                        giftresult.text('');
                        socket.emit('gift', d);
                    }else{
                        giftresult.text(result);
                    }
                });
            }else{
                if(parseInt(jishu.text()) >= d.member) {
                    $.post("/app/post/gift.php", d, function(result) {
                        if(result == 'ok') {
                            giftresult.text('');
                            socket.emit('gift', d);
                        }else{
                            giftresult.text(result);
                        }
                    });
                    jishu.text(parseInt(jishu.text()) - d.member);
                }else{
                    giftresult.text('鲜花数量不够！');
                }
            }

        }
    );

    giftPay.click(
        function() {
            window.open('http://v.ireoo.com/pay', '_blank');
        }
    );

});