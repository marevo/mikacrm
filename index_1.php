<?
//$_SESSION = array();
//session_unset ();
//array_shift($_SESSION[]);
//die();
session_start();
use App\Models\User;
require 'autoload.php';
$userAUthorized = new User();

//обработка запроса на выход
if( $_POST["action"] && $_POST["action"]=="delete"){
    if(isset($_POST['exitLoginUser'])){
        $loginForExit = htmlspecialchars($_POST['exitLoginUser']);
        //TODO: выход для Login $loginForExit
        $deleted = (new \App\Models\User())->getCurrentUserByLogin($loginForExit)->deleteSessionForLoginUser();
    }
}
//Обработка запроса авторизации
if ($_POST["action"] && htmlspecialchars($_POST["action"]) == "create") {
//    array_shift($_SESSION);
//die();
    $login = htmlspecialchars($_POST["login"]);
    $passwordFromPost = htmlspecialchars($_POST["password"]);
    $currentUserByLogin = \App\Models\User::getCurrentUserByLogin($login);
//	проверка пароля от клиента с паролем из базы данных текущего пользователя
    if ($currentUserByLogin && $currentUserByLogin->ifUserAuthorized($passwordFromPost)) {
        //пароль совпадает значит пользователь авторизированый

        $userAUthorized = $currentUserByLogin;
        echo  "user $userAUthorized->name aвторизирован:";
        //если пароль и логин совпадают  сделаем update его сессии по session_id();
        //если есть то обновим его сессию, если нет добавим
        // вызов этого метода createOrUpdate_SESSION_UsersOnSite() идет в  createSession($login)
        //$currentUserByLogin->createOrUpdate_SESSION_UsersOnSite();// создаст или добавит в существующий $_SESSION['user_id' => 'session_id()']
        //если пароли совпадают то делаем update в таблице user для данного пользователя
        //и делаем в $_SESSION запись idUser idSession
        if ($userAUthorized->check_session()) {
//        if ($userAUthorized->updateSessionInTable() && $userAUthorized->createOrUpdate_SESSION_UsersOnSite()) {
            echo " 
 <!DOCTYPE html>
    <html>";
            require_once('./head.php');
            echo "
<body>
    <div class='container'>
        <nav class='navbar navbar-default  navbar-fixed-top'>
            <div class='row'  id='header'>
            
            ";
            require_once('./templates/header.php');
            echo "
            </div><!-- end .row id=header   -->
        </nav>
        <div class='row' id='main_cont'>";
            require_once('./navigation.php');
            echo " 
        </div><!-- end .row id=main_cont   -->
    </div><!-- end .container   -->
</body>
</html>";
        }
    }
}else{
    echo "<!DOCTYPE html>
    <html><head>";
    require_once('./head.php');
    echo "</head><body>";
    echo "<div class='container'>";
    echo "<div class='row' id='main_cont'>";
    include_once('./authorization_one.php');

    echo "</div></div></body></html>";
}




//   <script type="text/javascript">
/*$(document).ready(function () {
      var offset = $('#header').offset();
    var topPadding = 0;
    $(window).scroll(function() {
        if ($(window).scrollTop() > offset.top) {
            $('#header').css('margin-top',$(window).scrollTop() - offset.top + topPadding);
           // $('#header').stop().animate({marginTop: $(window).scrollTop() - offset.top + topPadding});
        }
        else {
            $('#header').css('margin-top',0);
           // $('#header').stop().animate({marginTop: 0});
        }
    });
});
id="myAffix"
data-spy="affix" data-offset-top="0"*/
//$(function(){
//  $('#myAffixHeader').width($('#affix_header').width());
//  $(window).resize(function(){
//    $('#myAffixHeader').width($('#affix_header').width());
//  });
//});
//  </script>
