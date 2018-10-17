<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 17.10.2018
 * Time: 21:22
 */
?>
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