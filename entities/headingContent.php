<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 27.06.2018
 * Time: 21:02
 */
/**функция подтяжки блока заголовка
 * @param $strCaption название заголовка
 * @return string вернет html с вставленным назанием
 */
function caption($strCaption) {
    return ("<div class='row headingContent'><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'> $strCaption </div></div>");
}