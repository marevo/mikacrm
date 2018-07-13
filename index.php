<?
session_start();
require 'autoload.php';
include "handlers/session.php";
$res=check_session();
if($res=='unauthorized')
{
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
<!--<head>-->
<!-- подключим к странице head.php заголовки и линковку-->
<!--</head>-->
<?php
      require_once ('./head.php');
?>
<body>

<div class="container" >
    <div class="row navbar navbar-fixed-top" id="header" >
        <!--   wrapper      подтянем header сайта-->
<!--		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id="affix_header">
		<div id="myAffixHeader" data-spy="affix" data-offset-top="0">-->
        <?php
            if($_GET['lang']=='ru')
            {				
		        require_once ('./templates/header_ru.php');
            }
            else
            {
				require_once ('./templates/header_en.php');
            }				
		?>	
<!--		</div>
	</div>-->
	</div>
	<div class="row" id="main_cont"><!-- middle  -->
	<!--для шифровки пароля<?echo password_hash ( "password2" , PASSWORD_BCRYPT);?>-->
        <!--    подтянем menu сайта-->
        <?php require_once ('./navigation.php'); ?>
<!--         <div class="footer">-->
<!--                <div> статус: admin/user<br>имя пользователя/ник</div>-->
<!--         </div>-->
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
$(function(){
  $('#myAffixHeader').width($('#affix_header').width());
  $(window).resize(function(){
    $('#myAffixHeader').width($('#affix_header').width());
  });
});
</script>
<?}?>