<?
session_start();
require 'autoload.php';
include "handlers/session.php";
$res = check_session();
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
<?php
      require_once ('./head.php');
?>
<body>

<div class="container">
    <div class="row navbar navbar-fixed-top" id="header" >
        <?php
		    require_once ('./templates/header.php');
		?>
	</div>
	<div class="row" id="main_cont">

        <!--    подтянем menu сайта-->
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