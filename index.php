<?
session_start();
require 'autoload.php';
include "handlers/session.php";//подключили файл для проверки юзера по сессии или update сессии
//из handlers\session.php проверим на наличие сессии и времени не просрочки сессии и найдем юзера по этим параметрам
$res = check_session();
if($res=='unauthorized') {
	include "authorization.php";
}
else
{
	//session start
	// проверка на авторизацию
	// если нет параметра то грузим заказы
?>
    <!DOCTYPE html>
    <html>
    <?php require_once ('./head.php'); ?>
    <body>

    <div class="container">
        <nav class="navbar navbar-default  navbar-fixed-top">
            <div class="row " id="header">
                <?php
                //запрос хедера
                //$currentUser - заодно будет получен текущий юзер по id сессии
                //$sid - заодно будет получен текущий id сессии
                require_once('./templates/header.php');
                ?>
            </div>
        </nav>
        <div class="row" id="main_cont">
            <!--    подтянем menu сайта и основной контент через 2 колонки бутстрапа-->
            <?php require_once ('./navigation.php'); ?>
        </div>
    </div>
    </body>
    </html>
  
    <script type="text/javascript">
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
    </script>
<?}?>