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
            if($idClient)
                $objOneContact->id_clients = $idClient;
        }
        $resUpdateContact = $objOneContact -> update();
        //если удачно сделали update contact
        if($resUpdateContact){
               \App\FastViewTable::showUspeh('контакт удачно обновлен');
            $newNameOneContac = \App\Models\Contacts::findObjByIdStatic($idCont)->name;
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
if (isset($_POST['insertOneContact'])){
    $idContactUpdate = intval($_POST['insertOneContact']);
//    \App\FastViewTable::showAnswerServer("пришел маркер на обновление контакта id = $idContactUpdate");
    
    //insertNewMaterialToBase();
}
function insertNewContactToBase(){
    if (isset($_POST['send'])) {

        $matNew = new \App\Models\Material();
        if (isset($_POST['nameMaterial'])) {
            $matNew->name = trim( htmlspecialchars($_POST['nameMaterial']) );
        }
        if (isset($_POST['addCharacteristic'])) {
            $matNew->addCharacteristic = trim( htmlspecialchars($_POST['addCharacteristic']));
        }
        if (isset($_POST['idSupplier'])) {
            $matNew->id_suppliers = intval($_POST['idSupplier']);
        }
        if (isset($_POST['measure'])) {
            $matNew -> measure =trim( htmlspecialchars($_POST['measure']));
        }
        if (isset($_POST['deliveryForm'])) {
            $matNew -> deliveryForm = trim( htmlspecialchars($_POST['deliveryForm']));
        }
        if(isset($_POST['priceForMeasure'])){
            $matNew -> priceForMeasure = trim(htmlspecialchars($_POST['priceForMeasure']));
        }
        //вставим новый заказ в базу
        $resInsert = $matNew -> insert();

        if($resInsert != false){
            echo "<script> fUspehAll('материал добавлен');</script>";
        }
        else{
            echo "<script>fNoUspehAll('материал не добавлен(');</script>";
        }
//        if (isset($_POST['submitFromFormOneOrder']))
//            foreach ($orNew as $k => $value) {
//                echo "<br/>$k--- $value";
//            }
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
