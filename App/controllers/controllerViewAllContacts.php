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
//поиск по подобию в названии name  по подобию в name или 
if(isset($_POST['searchLike'])){
    if(isset($_POST['likeValue'])){
        $likeValue = htmlspecialchars($_POST['likeValue']);
        $findContacts = \App\Models\Contacts::searchAllForLikeName($likeValue);
//        var_dump($findContacts);
        $ContactTBODY = "";
        if(! empty($findContacts)){
            foreach ($findContacts as $itemCCIB){
//                        найдем имя клиента $itemCCIBNameClient если есть привязка контакта к клиенту
                $itemCCIBNameClient = \App\Models\Client::findObjByIdStatic($itemCCIB->id_clients)->name;
                $ContactTBODY .= "<tr><td>$itemCCIB->name</td><td data-id_clients='$itemCCIB->id_clients'>$itemCCIBNameClient</td><td>$itemCCIB->phone</td><td>$itemCCIB->email</td><td data-do='view' data-id = $itemCCIB->id><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-do='trash' data-id = $itemCCIB->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
                //если не нужно искать имя клиента ( упрощенно выводим в таблицу id_clients
//              $ContactTBODY .= "<tr><td>$itemCCIB->name</td><td>$itemCCIB->id_clients</td><td>$itemCCIB->phone</td><td>$itemCCIB->email</td><td data-do='view' data-id = $itemCCIB->id><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-do='trash' data-id = $itemCCIB->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
            }
        }
        else{
            $ContactTBODY = "<tr><td colspan='6' class='text-center'> пока ничего нет ( </td></tr>";
            \App\ModelLikeTable::showNoUspeh('нет контактов с такими данными');
        }
        echo "$ContactTBODY";
    }
}