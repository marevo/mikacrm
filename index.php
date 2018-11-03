<?
//$_SESSION = array();
//session_unset ();
//array_shift($_SESSION[]);
//die();
//$sesId_0 = session_id();
session_start();
use App\Models\User;

//include './handlers/session.php';//подключили файл для проверки юзера по сессии или update сессии
//из handlers\session.php проверим на наличие сессии и времени не просрочки сессии и найдем юзера по этим параметрам
//$rez = check_session($user);
//$userName ? (new User())->findObjById(4) ->name : "logIn";
//unset( $_SESSION['users_onSite']);
require './autoload.php';
$sid = session_id();
if (isset($_SESSION) && isset($_SESSION['user_id']) && $user = (new User())->findObjById($_SESSION['user_id'])):
//if($user && time() - $user->updated <1800):
   
    $user->updated = time();
    $user->session = $sid;
    if ($user->save()):
        //загружаем по умолчанию просмотр заказов
        ?>
<!DOCTYPE html>
<html>
<?php require_once "head.php"; ?>
<body>
<div class='container'>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-xs-12 col-sm-12' id='header'>
            <div class="row">
            <?php include_once './templates/header.php'; ?>
            </div>
        </div><!-- end .row id=header   -->
        <script type="text/javascript">
//            $('.pod_user a').html("<i class='fa-user'>$user->login </i>");
//            $('[name=exitIdUser]').val("$user->id");
        </script>
    </div>
    <div class='row' id='main_cont'>
        <?php include_once 'navigation.php'; ?>
    </div><!-- end .row id='main_cont'   -->
</div><!-- end .container   -->
</body>
    </html>
        <?php
    endif;

else:
// нет сессии или не найден юзер по параметру $_SESSION['user-id'] загрузим форму авторизации
    session_start();
    ?>
    <!DOCTYPE html>
    <html>
    <?php require_once "head.php"; ?>
    <body>
    <div class='container'>
        <nav class='navbar navbar-default  navbar-fixed-top'>
            <div class='row' id='header'>
                <?php include_once './templates/header.php'; ?>
            </div><!-- end .row id=header   -->
            <script type="text/javascript">
                $('.pod_user a').html("<i class='fa-user'>enter logIn </i>");
                $('[name=exitIdUser]').val("");
            </script>
        </nav>
        <div class='row' id='main_cont'>
            <?php include_once './authorization.php';
            ?>

        </div><!-- end .row id='main_cont'   -->
    </div><!-- end .container   -->
    </body>
    </html>
    <?php
endif;
?>


        <?php
        //обнулим найзание юзера и id user
      //  echo "<script> $('.pod_user a').html(\"<i class='fa-user'>enter logIn </i>\");</script>";
       // echo "<script> $('[name=exitIdUser]').val(\"\");</script>";
        ?>
    
    <?php
//
//    if (isset($_POST['action']) ):
//        if ($_POST['action'] == "delete" && isset($_SESSION)):
//            echo "<script> $('.pod_user a').html(\"<i class='fa-user'>enter logIn </i>\");</script>";
//            echo "<script> $('[name=exitIdUser]').val(\"\");</script>";
//            //пришел запрос на выход с сайта action:delete
//            if (isset($_POST['exitIdUser'])) {
//                $idUserToExit = intval($_POST['exitIdUser']);
//                $user = (new User())->findObjById($idUserToExit);
//                if ($user):
//                    $user->session = "NULL";
//                    if($user->save()):
//                        $userName = "залогинтесь";
//                        $strForShowUserNameNoLogin = "<script> $('.pod_user a').html(\"<i class='fa-user'> $userName </i>\");</script>";
//                        echo "<script> $('.pod_user a').html(\"<i class='fa-user'> $userName </i>\");</script>";
//                        echo "<script> $('[name=exitIdUser]').val(\"\");</script>";
//                        if($_SESSION && in_array($_SESSION['user_id'],$_SESSION ))
//                            unset($_SESSION['user_id']);
//                    location('/');
//                    endif;
//                endif;
//            }
//        endif;
//        if (isset($_POST['action']) && $_POST['action']== "login" &&
//             isset($_POST['name_login']) && isset($_POST['name_password'])):
//            $user=(new User())->getUserByLogin(htmlspecialchars($_POST['name_login']));
//            if($user && $user->isUserAuthorized(htmlspecialchars($_POST['name_password'])) &&$user->updateSessionInTable()):
//                //POST не пришел отправили сообщение о нахождении юзера через SESSION
//               // \App\FastViewTable::showUspeh("найден в базе : ".$user->name);
//                //$strForShowUserName = "<script>$('.pod_user a').html(\"<i class='fa-user'> $user->name </i>\");</script>";
//              //  echo "<script> $('[name=exitIdUser]').val(\"$user->id\");</script>";
//                $_SESSION['user_id']= $user->id;
//                echo "authorized";
//            endif;
//        endif;
//    endif;
//
//    if (isset($_SESSION['user_id'])):
//        $user= new User();
//        $user = (new User())->findObjById($_SESSION['user_id']);
//        if ($user && $user->updateSessionInTable()):
//            //юзер найден из сессии и обновлены данные в таблице users
//            //пришел POST запрос
//
//            //POST не пришел отправили сообщение о нахождении юзера через SESSION
//            \App\FastViewTable::showUspeh("через сеесию: ".$user->name);
//            //отправим имя юзера на клиент
//            $strForShowUserName = "<script>$('.pod_user a').html(\"<i class='fa-user'> $user->name </i>\");</script>";
//            //отправим в скрытое поле $('[name=exitLoginUser]').val() значение $user->id для выхода с сайта
//            $strIdUserToHiddenInput = "$user->id";
//            echo "<script> $('[name=exitIdUser]').val(\"$strIdUserToHiddenInput\");</script>";
//            \App\FastViewTable::showUspeh("загрузк данных по умолчанию");
//            ?>
<!---->
<!--            <div class='row' id='main_cont'> -->
<!--                --><?php //include_once 'navigation.php'; ?>
<!--            </div>  -->
<!-- end .row id='main_cont'   -->
<!--            --><?php
//        //при обновлении страницы и наличии юзера в сессии выше нашли этого юзера
////             $userName = $user ? $user->name : "no find user";
////          $stringForJavaScript_1 = "<script>$('.pod_user a').html(\"$sringFJSVT\");</script>";
//        else:
//            \App\FastViewTable::showNoUspeh("не нашли юзера");//будем брать по умолчанию из user->id= 4
//            $strForShowUserName = "<script>$('.pod_user a').html(\"<i class='fa-user'> $userName </i>\");</script>";
//        endif;
//        //покажем в header.php имя юзера
//        echo "$strForShowUserName";
//
//    else:?>
<!--        <div class='row' id='main_cont'>-->
<!--            <div class="col-lg-12"><h1> нет данных сессии</h1></div>-->
<!--            --><?php //include_once './authorization.php';
//            ?>
<!--        </div>-->
<!-- end .row id='main_cont'   -->
<!--    --><?php //endif; ?>


<script type="text/javascript">
    /*
     $(document).ready(function () {
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
     data-spy="affix" data-offset-top="0"
     */
    //$(function(){
    //  $('#myAffixHeader').width($('#affix_header').width());
    //  $(window).resize(function(){
    //    $('#myAffixHeader').width($('#affix_header').width());
    //  });
    //});
</script>
