/**
 * Created by Administrator on 13-12-3.
 */

function size(id, gps) {

    //alert(id);

    if(id > 0) {
        if($(window).width() < 600 && gps == 'index') {
            location.href = 'http://mobile.ireoo.com/' + id;
        }
        if($(window).width() > 600 && gps == '3g') {
            location.href = '/' + id;
        }
    }

    if(id == 0){
        if($(window).width() < 600 && gps == 'index') {
            location.href = 'http://mobile.ireoo.com/store';
        }
        if($(window).width() > 600 && gps == '3g') {
            location.href = '/store';
        }
    }

    if(id == -1){
        if($(window).width() < 600 && gps == 'index') {
            location.href = 'http://mobile.ireoo.com/';
        }
        if($(window).width() > 600 && gps == '3g') {
            location.href = '/';
        }

        if($(window).width() < 600 && gps == 'login') {
            location.href = 'http://mobile.ireoo.com/login';
        }
        if($(window).width() > 600 && gps == '3glogin') {
            location.href = '/login';
        }
    }
}
