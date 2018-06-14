<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.06.2018
 * Time: 6:35
 */
require '../../autoload.php';

//если пришел скрытый маркер udate контакта с id
if (isset($_POST['updateOneContact'])){
    $idContactUpdate = intval($_POST['updateOneContact']);
//    \App\FastViewTable::showAnswerServer("пришел маркер на обновление контакта id = $idContactUpdate");
    updateOneContact($idContactUpdate);
}
//функция update контакта с $idContactUpdate = $idCont
function updateOneContact($idCont){
    $objOneContact = \App\Models\Contacts::findObjByIdStatic($idCont);
    //если нашли такой контакт
    if($objOneContact){
        if(isset($_POST['email']) ){
            $emailOneContac = htmlspecialchars($_POST['email']);
            if($emailOneContac)
                $objOneContact->email = $emailOneContac;
        }
        if(isset($_POST['phone'])){
            $phoneOneContac = htmlspecialchars($_POST['phone']);
            if($phoneOneContac)
                $objOneContact->phone = $phoneOneContac;
        }
        if(isset($_POST['name'])){
            $nameOneContac = htmlspecialchars($_POST['name']);
            if($nameOneContac)
                $objOneContact->name = $nameOneContac;
        }
        if(isset($_POST['selectIdClient'])){
            $idClient = intval($_POST['selectIdClient']);
            var_dump($idClient);
            if($idClient!="")
                $objOneContact->id_clients = $idClient;
            else
                $objOneContact->id_clients = 0;
        }
        $resUpdateContact = $objOneContact -> update();
        $newNameOneContac = \App\Models\Contacts::findObjByIdStatic($idCont)->name;
        //если удачно сделали update contact
        if($resUpdateContact){
               \App\FastViewTable::showUspeh('контакт удачно обновлен');
            \App\FastViewTable::showAnswerServer("контакт $newNameOneContac успешно обновлен");
            }
            else{
                \App\FastViewTable::showNoUspeh('не удалось обновить контакт');
                \App\FastViewTable::showAnswerServer("контакт '". $objOneContact->name."' не обновлен");
            }
        }
}
//функция вставки в базу нового контакта
//если пришел скрытый маркер insert вставим новый контакт в базу
if (isset($_POST['insertContactToBase'])){
    \App\FastViewTable::showAnswerServer("пришел маркер на добавку нового контакта в базу");
    insertNewContactToBase();
}
function insertNewContactToBase(){
        $objNewContact = new \App\Models\Contacts();
        if(isset($_POST['nameContact'])){
            $nameContact = htmlspecialchars($_POST['nameContact']);
            $objNewContact ->name = $nameContact;
        }
        if(isset($_POST['phone'])){
            $phoneContact = htmlspecialchars($_POST['phone']);
            $objNewContact ->phone = $phoneContact;
        }
        if(isset($_POST['email'])){
            $emailContact = htmlspecialchars($_POST['email']);
            $objNewContact ->email = $emailContact;
        }
        //вставим новый контакт в базу
        $resInsert = $objNewContact -> insert();
//        $resInsert = true;
        if($resInsert){
            \App\FastViewTable::showUspeh('удачно');
            \App\FastViewTable::showAnswerServer(" контакт " .$objNewContact ->name ." успешно добавлен в базу ");
        }
        else{
            \App\FastViewTable::showNoUspeh('не удачно');
            \App\FastViewTable::showAnswerServer(" не удалось создать контакт ".$objNewContact ->name );
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
