<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.06.2018
 * Time: 6:25
 */
$idContact=1;
if(isset($_POST['includeViewOneContact'])){
    var_dump('пришел запрос на подтяжку просмотра одного контакта');
    if(isset($_POST['idOneContact'])){
        $idContact = intval($_POST['idOneContact']);
        var_dump("хотим показать контакт $idContact");
    }

    include_once ('../../templates/viewAllContacts.php');
}