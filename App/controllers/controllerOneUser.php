<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 10.10.2018
 * Time: 22:54
 */
require_once '../../autoload.php';

//если пришел скрытый маркер udate юзера с id
if (isset($_POST['updateOneUser'])){
    $idUserUpdate = intval($_POST['updateOneUser']);
//    \App\FastViewTable::showAnswerServer("пришел маркер на обновление контакта id = $idContactUpdate");
    updateOneContact($idUserUpdate);
}
//функция update контакта с $idContactUpdate = $idCont
function updateOneContact($idUserUpdate){
    $objOneUser = \App\Models\User::findObjByIdStatic($idUserUpdate);
    //если нашли такой контакт
    if($objOneUser){
        if(isset($_POST['name'])){
            $nameOneUser = htmlspecialchars($_POST['name']);
            if($nameOneUser)
                $objOneUser->name = $nameOneUser;
        }
        //права пользователя +/- добавить удалить
        if(isset($_POST['selecRightUser'])){
            $rightUser = htmlspecialchars($_POST['selecRightUser']);
//            передано не 0 допустим + с добавить возможность создавать сущности
            if($rightUser){
                $objOneUser-> addRightDeleteRight($rightUser);
            }
        }
        if(isset($_POST['login'])){
            $loginOneUser = htmlspecialchars($_POST['login']);
            if($loginOneUser)
                $objOneUser->login = $loginOneUser;
        }
        if(isset($_POST['password'])) {
            $passwordOneUser = htmlspecialchars($_POST['password']);
            if ($passwordOneUser) {
                $objOneUser->setPassword($passwordOneUser);
            }
        }
        if(isset($_POST['email'])) {
            $emailOneUser = htmlspecialchars($_POST['email']);
            if($emailOneUser)
                $objOneUser->gmail = $emailOneUser;
        }
        if(isset($_POST['sQuestion'])){
            $secretQuestionOneUser = htmlspecialchars($_POST['sQuestion']);
            if($secretQuestionOneUser){
                $objOneUser->secretQuestion = $secretQuestionOneUser;
            }
        }
        if(isset($_POST['sAnswer'])){
            $secretAnswerOneUser = htmlspecialchars($_POST['sAnswer']);
            if($secretAnswerOneUser){
                $objOneUser->secretAnswer = $secretAnswerOneUser;
            }
        }
        $resUpdateUser = $objOneUser->update();
        //если юзер  удачно обновлен
        if ($resUpdateUser) {
            $newNameOneUser = \App\Models\User::findObjByIdStatic($idUserUpdate);
            \App\FastViewTable::showUspeh('юзер удачно обновлен');
            \App\FastViewTable::showAnswerServer("юзер $newNameOneUser->name успешно обновлен");
        } else {
            \App\FastViewTable::showNoUspeh('не удалось обновить юзер');
            \App\FastViewTable::showAnswerServer("юзер '" . $objOneUser->name . "' не обновлен");
        }
    }
}

//функция вставки в базу нового юзера
//если пришел скрытый маркер insert вставим новый контакт в базу
if (isset($_POST['insertUserToBase'])){
    \App\FastViewTable::showAnswerServer("пришел маркер на добавку нового контакта в базу");
    insertNewUserToBase();
}
function insertNewUserToBase(){
    $objNewUser = new \App\Models\User();

    if(isset($_POST['name'])){
        $nameOneUser = htmlspecialchars($_POST['name']);
        if($nameOneUser)
            $objNewUser->name = $nameOneUser;
    }
    if(isset($_POST['login'])){
        $loginOneUser = htmlspecialchars($_POST['login']);
        if($loginOneUser)
            $objNewUser->login = $loginOneUser;
    }
    if(isset($_POST['password'])) {
        $passwordOneUser = htmlspecialchars($_POST['password']);
        if ($passwordOneUser) {
            $objNewUser->setPassword($passwordOneUser);
        }
    }
    if(isset($_POST['email'])) {
        $emailOneUser = htmlspecialchars($_POST['email']);
        if($emailOneUser)
            $objNewUser->gmail = $emailOneUser;
    }
    if(isset($_POST['sQuestion'])){
        $secretQuestionOneUser = htmlspecialchars($_POST['sQuestion']);
        if($secretQuestionOneUser){
            $objNewUser->secretQuestion = $secretQuestionOneUser;
        }
    }
    if(isset($_POST['sAnswer'])){
        $secretAnswerOneUser = htmlspecialchars($_POST['sAnswer']);
        if($secretAnswerOneUser){
            $objNewUser->secretAnswer = $secretAnswerOneUser;
        }
    }

    //вставим новый контакт в базу
//    $resInsert = $objNewUser -> insert();
    $resInsert = $objNewUser -> save();
//        $resInsert = true;
    if($resInsert){
        \App\FastViewTable::showUspeh('новый user создан');
        \App\FastViewTable::showAnswerServer(" контакт " .$objNewUser ->name ." успешно добавлен в базу ");
        echo"<script type='text/javascript'></script>";
    }
    else{
        \App\FastViewTable::showNoUspeh('не удачно');
        \App\FastViewTable::showAnswerServer(" не удалось создать user ".$objNewUser ->name );
    }
}

//поиск поставщика по подобию имени  и выгрузка их в селект выбора поставщиков formAddNewMaterilsToBase.php ['name = idSupplier']
if(isset($_POST['searchSuppliersLikeName'])){
//    $likeName = htmlspecialchars($_POST['likeName']);
//    echo "<option value=\"0\">пришел запрос на поиск поставщика по $likeName </option>";
//    die();
    if(isset($_POST['likeName'])){
        $likeName = htmlspecialchars($_POST['likeName']);
//        \App\ModelLikeTable::showUspeh("пришел запрос на поиск по имени $likeName");
//        $suppliersSearcLikeName = \App\Models\Supplier::searchAllForLikeName($likeName);
        $suppliersSearcLikeName = \App\Models\Supplier::searchObjectsLikeNameOrLikeAddCharacteristic($likeName);
        if($suppliersSearcLikeName){
            $optionSearchingSuppliers= "<option value=\"0\">выберите поставщика</option>";
            foreach ($suppliersSearcLikeName as $rowItem){
                $optionSearchingSuppliers .= "<option data-id = '$rowItem->id' value='$rowItem->id'>$rowItem->name</option>";
            }
            echo "$optionSearchingSuppliers";
        }
        else{
            $optionSearchingSuppliers= "<option value=\"0\">такого нет (: </option>";
            \App\ModelLikeTable::showNoUspeh("не нашли с именем $likeName (:");

            echo "$optionSearchingSuppliers";
        }
    }
}

//подтяжка email phone для контакта при привязке к клиенту нужного контакта
if(isset($_POST['getClientForOneContact'])){
    if(isset($_POST['valueClient'])){
        $idClient = intval($_POST['valueClient']);
        $objClient = \App\Models\Client::findObjByIdStatic($idClient);
        if($objClient){
            echo "<script> $('[name=phone]').val($objClient->phone0);$('[name=email]').val('$objClient->email0');</script>";
        }
    }
}
