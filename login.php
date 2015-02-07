<?php
require_once('./config.php');

$uid = _htmlencode($_POST['user']);
$pass = _htmlencode($_POST['pass']);

if (!empty($uid) && !empty($pass))
{
    $sql= new sqlCompo(new sql('uid',$uid));
    $sql->add(new sql('pwd',md5($pass)));

    $result = $kerdb->getvars('user',$sql);

    if ($kerdb->num_rows($result) == 1)
    {
        $res = $kerdb->fetch_array($result);
        $_SESSION['uno'] = $res['uno'];
        $keruser = getUserByNo($res['uno']);
        _redirect(SITE);
    }
    else
    {
        echo '使用者帳號密碼錯誤';
        _redirect();
    }
}
else
    _redirect();
?>