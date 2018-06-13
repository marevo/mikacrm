<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.06.2018
 * Time: 6:25
 */
require '../../autoload.php';
$idContact=1;
if(isset($_POST['includeViewOneContact'])){
   //var_dump('пришел запрос на подтяжку просмотра одного контакта');
    if(isset($_POST['idOneContact'])){
        $idContact = intval($_POST['idOneContact']);
        //var_dump("хотим показать контакт $idContact");
    }
    include_once ('../../templates/viewOneContact.php');
}
if(isset($_POST['includeFormNewContact'])){
    //echo "пришел запрос на подтяжку формы добавления нового контакта";
    include_once ('../../templates/formAddNewContactToBase.php');
}
if(isset($_POST['deleteContactFromBase']) && isset($_POST['idContact']) ){
    \App\FastViewTable::showAnswerServer("пришел запрос удаления контакта ");
    $idContact = intval($_POST['idContact']);
    deleteContactFromBase($idContact);
}
function deleteContactFromBase($idCont){
    \App\FastViewTable::showAnswerServer("работает функция удаления контакта ");
    $contactName = \App\Models\Contacts::findObjByIdStatic($idCont)->name;
    //$res = true;
//        $res = false;
    try{
        $res = \App\Models\Contacts::deleteObj($idCont);
        if($res){
            \App\ModelLikeTable::showAnswerServer("$contactName удален успешно");
            \App\ModelLikeTable::showUspeh('успешно');
            echo "<script>$('[data-id = $idCont]').parent().remove() ;</script>";
        }
        else{
            \App\ModelLikeTable::showNoUspeh('не удалось');
            \App\ModelLikeTable::showAnswerServer("$contactName не удалось удалить");
        }
    }
    catch (PDOException $ex){
        \App\ModelLikeTable::showAnswerServer("$ex <br/> не удачно сработала функция удаления контакта в базе");
    }
}