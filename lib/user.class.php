<?php
class user
{
    public $user = array();
    public $person = array();

    function __construct($u = array()) {
        $d = array(
            'username'      => 'unknow',
            'email'         => 'unkonw',
            'phone'         => 0,
            'password'      => 'unknow',
            'password_once' => 'unkonw',
            'avatar'        => 'uploads/u/avatar.jpg',
            'avatar_large'  => 'uploads/u/avatar.jpg',
            'timer'         => time(),
            'ip'            => $this->getIP()
        );
        $this->user = array_merge($d, $u);
    }

    function __destruct() {
    }

    function login(mysql $mysql){

        if($this->user['phone'] == 0) {
            $sql = array(
                'table' => 'user',
                'condition' => "email = '{$this->user['email']}'"
            );
        }else{
            $sql = array(
                'table' => 'user',
                'condition' => "phone = {$this->user['phone']}"
            );
        }
        $re = $mysql->row($sql);
        if(!$re) {
            return '1001' . json_encode($sql) . mysql_error(); //获取失败，返回错误信息
        }
        if($re['password'] != $this->user['password']) {
            return 1002;
        }
        $this->person = $re;
        $this->person['timer'] = time();
        //if(!$mysql->update('user',array('timer'=>$this->person['timer']),"id = {$this->person['id']}")) return 1004;
        unset($this->user);
        unset($this->person['password']);
        //if($this->person['confirmation'] == 0) return 1012;
        if(isset($_SESSION['openid']) and isset($_SESSION['wid'])) {
            $s = array(
                'openid' => $_SESSION['openid'],
                'wid' => $_SESSION['wid'],
                'uid' => $this->person['id']
            );
            $ys = array(
                'table' => 'userToWechat',
                'condition' => "openid = '{$_SESSION['openid']}' and wid = '{$_SESSION['wid']}' and uid = {$this->person['id']}"
            );
            $you = $mysql->row($ys);
            if(!is_array($you)) {
                $mysql->insert('userToWechat', $s);
            }
            $mysql->update('wechat', array('uid' => $this->person['id']), "openid = '" . $_SESSION['openid'] . "' and wid = '" . $_SESSION['wid'] . "'");
        }

        return 1000;
    }

    function getID(mysql $mysql, $id = NULL) {
        if($id == NULL) return 1017; //没有设置ID
        $sql = array(
            'table' => 'user',
            'condition' => "id = $id"
        );
        $r = $mysql->row($sql);
        if(!is_array($r)) return 1016; //没有数据
        unset($r['password']);
        return $r;
    }

    function reg(mysql $mysql) {
        if($this->user['username'] == 'unknow' or $this->user['username'] == '') return 1006;
        if($this->user['password'] == 'unknow' or $this->user['password'] == '') return 1005;
        if($this->user['phone'] == 'unknow' or $this->user['phone'] == '') return 1007;
        if($this->user['password'] != $this->user['password_once']) return 1003;

        if(!preg_match('/^([0-9a-zA-Z\x{4e00}-\x{9fa5}]{1,12})$/u', $this->user['username'])) return '对不起，昵称格式不正确';
        //if(!preg_match('/^([0-9a-zA-Z]{32})$/', $this->user['password'])) return '程序错误';
        if(!preg_match('/^([0-9\+]{11,15})$/', $this->user['phone'])) return '对不起，手机号格式不正确';
        //if(!preg_match('/^([\w\.\_]{2,})@(\w{1,}).([a-z]{2,10})$/', $this->user['email'])) return '邮箱格式不正确';

        if($mysql->row(array('table' => 'user','condition' => "username = '{$this->user['username']}'"))) return 1008;
        if($mysql->row(array('table' => 'user','condition' => "phone = '{$this->user['phone']}'"))) return 1009;

        $sql = array(
            'username' => $this->user['username'],
            'password' => $this->user['password'],
            'phone'    => $this->user['phone'],
            '`show`'   => 1,
            'avatar'        => 'user/avatar.jpg',
            'avatar_large'  => 'user/avatar.jpg',
            'ip'       => $this->getIP(),
            'timer'    => time()
        );
        $re = $mysql->insert('user',$sql);
        if($re){
            $this->login($mysql);
            return 1011;
        }else{
            return '1010'.mysql_error();
        }
    }

    function say(mysql $mysql, $t=array()) {
        $d = array(
            'id'    => NULL,
            'uid'   => 0,
            'sid'   => 0,
            'tid'   => 0,
            'txt'   => 'unknow',
            'ip'    => $this->getIP(),
            'timer' => time()
        );
        $t = array_merge($d, $t);
        $sql = array(
            'table' => 'say',
            'condition' => "uid = '{$t['uid']}'",
            'order'     => "id desc"
        );
        $re = $mysql->row($sql);
        if($re){
            //print_r($re);
            //print_r(":{$re[0]['id']}");
            if($t['timer']-$re['timer']<=10) return '亲，您说话的速度太快啦，休息下吧！';
        }

        $re = $mysql->insert('say',$t);
        if($re){
            return 1;
        }else{
            return '错误代码：'.mysql_error();
        }
    }

    function show(mysql $mysql, $s = array()) {
        $d = array(
            'table' => 'user',
            'condition' => '1',
            'order' => 'show desc'
        );
        $s = array_merge($d, $s);
        $r = $mysql->select($s);
        if(!is_array($r)) return 1016; //没有数据
        $out = array();
        foreach($r as $k => $v) {
            $out[$k] = $v['user'];
        }
        return $out;
    }

    function show_friends(mysql $mysql, $id = NULL) {
        if($id == NULL) return 1017; //没有设置ID
        $s = array(
            'table' => 'user_friends',
            'condition' => "id = $id"
        );
        $r = $mysql->select($s);
        if(!is_array($r)) return 1016; //没有数据
        $out = array();
        foreach($r as $k => $v) {
            $out[$k] = $v['user_friends'];
        }
        return $out;
    }

    function olist(mysql $mysql, $id = NULL, $y = 1, $show = 20) {
        if($id == NULL) return 1017; //没有设置ID
        $now = $y*$show;
        $s = array(
            'table' => 'user_friends',
            'condition' => "id = $id",
            'limit' => "LIMIT $now, $show"
        );
        $r = $mysql->select($s);
        if(!is_array($r)) return 1016; //没有数据
        $out = array();
        foreach($r as $k => $v) {
            $out[$k] = $v['user_friends'];
        }
        $o = array();
        $o['list'] = $out;
        $o['now'] = $now;
        $s = array(
            'table' => 'user_friends',
            'condition' => "id = $id"
        );
        $r = $mysql->select($s);
        if(!is_array($r)) return 1016; //没有数据
        $o['t'] = count($r);
        return $o;
    }

    function atname(mysql $mysql) {
        $s = array(
            'table' => 'user',
            'condition' => "username = '{$this->user['username']}'"
        );
        $r = $mysql->row($s);
        if(is_array($r)) return 1019; //已经被注册
        return 1018;
    }

    function getIP() {
        if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (@$_SERVER["HTTP_CLIENT_IP"])
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        else if (@$_SERVER["REMOTE_ADDR"])
            $ip = $_SERVER["REMOTE_ADDR"];
        else if (@getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (@getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (@getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "unknown";
        return $ip;
    }
}
?>
