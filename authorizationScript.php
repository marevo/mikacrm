<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 30.10.2018
 * Time: 22:02
 */
session_start();
require_once './autoload.php';
function whoIsLogin()
{
    if (isset($_POST["action"]) && htmlspecialchars($_POST["action"]) == "login") {
        if (isset($_POST["name_login"])) {
            $login = htmlspecialchars($_POST["name_login"]);
            $passForTest = htmlspecialchars($_POST["name_password"]);
//			require 'autoload.php';
            $user = (new \App\Models\User())->getUserByLogin($login);
            if ($user && $user->isUserAuthorized($passForTest)) {
//такой пользователь есть в базе и логин и пароль правильны
                $_SESSION['user_id'] = $user->id;
                return $user;
            }
//		header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//		exit();
        }
        return false;
    }
    return false;
}
/**
 * разрушение сессии и переход на главную страницу причем в сессии переменных
 */
function logout()
{
    if (isset($_GET['action']) AND $_GET['action'] == "logout") {
        session_start();
        session_destroy();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
        exit;
    }
}
//пришел запрос на выход из проги
if(isset($_POST['action']) && htmlspecialchars($_POST['action'])== "delete" && isset($_POST['exitIdUser'])  ){
    $idUserToExit = intval($_POST['exitIdUser']);
    $user = new \App\Models\User();
    $user = $user->findObjById($idUserToExit);
    if($user){
        session_destroy();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
        exit;
    }
}
//пришел запрос из формы авторизации (ввели логин и пароль)
// если логин и пароль верны
//  для вернет на страницу "authorized"
if (isset($_POST['action']) && $_POST['action']== "login" &&
    isset($_POST['name_login']) && isset($_POST['name_password'])):
    session_start();
    $user=(new \App\Models\User())->getUserByLogin(htmlspecialchars($_POST['name_login']));
    if($user && $user->isUserAuthorized(htmlspecialchars($_POST['name_password'])) &&$user->updateSessionInTable()):
        //POST не пришел отправили сообщение о нахождении юзера через SESSION
        // \App\FastViewTable::showUspeh("найден в базе : ".$user->name);
        //$strForShowUserName = "<script>$('.pod_user a').html(\"<i class='fa-user'> $user->name </i>\");</script>";
        //  echo "<script> $('[name=exitIdUser]').val(\"$user->id\");</script>";
        $_SESSION['user_id']= $user->id;
        echo "authorized";
    endif;
endif;

if (isset($_GET['action']) AND $_GET['action'] == "logout") {
    session_start();
    session_destroy();
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
    exit;
}