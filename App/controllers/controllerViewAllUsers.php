<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 08.10.2018
 * Time: 0:07
 */

require '../../autoload.php';

if(isset($_POST['deleteUserFromBase'])){
    // echo "пришел запрос на удаление поставщика из базы";
    if (isset($_POST['idUser'])){
         $idUser= intval($_POST['idUser']);
//        $res = true;
//        $res = false;
        $res = \App\Models\Supplier::deleteObj($idUser);
        if($res){
            echo "<script>fUspehAll('пользователя удалили успешно')</script>";
            echo "<script>$('[data-id_supplier = $idUser]').parent().remove() ;</script>";
        }
        else{
            echo "<script>fNoUspehAll('не удалось удалить пользователя')</script>";
        }
    }
}
//поиск пользователя по подобию в любом поле таблицы
if(isset($_POST['searchLike'])){
    if(isset($_POST['likeValue'])){
        $likeValue = htmlspecialchars($_POST['likeValue']);
        $findUsers = \App\Models\Supplier::searchObjectsLikeNameOrLikeAddCharacteristic($likeValue);
//        var_dump($findSuppliers);
        if(! empty ($findUsers)){
            $tableAllSuppTbody = "";
            foreach ($findUsers as $item){
                //найдем idMaterial для каждого поставщика, чтобы узнать есть или нет эти материалы в заказах и
                // разрешать удалять только тех поставщиков, чьих материалов нет в заказах
                if(\App\Models\MaterialsToOrder::ifExistThisSupplierInAnyMaterilsToOrder($item->id)){
//                    есть материал этото поставщика хотябы в одном заказе поэтому не будем разрешать удалять поставщика
                    $tableAllSuppTbody .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->addCharacteristic</td><td class='tdDisplayNone'>$item->contactPerson</td><td>$item->phone0</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td><td class='tdDisplayNone'> ".$item->getDeliveryDays()." </td><td class='tdDisplayNone'><a href='$item->site' target='_blank'>$item->site</a></td><td  class='text-center'><a data-id_supplier= $item->id href='viewOneSupplier.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td><td></td></tr>";
                }
                else{
                    // нет материалов этого поставщика, поэтому разрешим его удаление
                    $tableAllSuppTbody .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->addCharacteristic</td><td class='tdDisplayNone'>$item->contactPerson</td><td>$item->phone0</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td><td class='tdDisplayNone'> ".$item->getDeliveryDays()." </td><td class='tdDisplayNone'><a href='$item->site' target='_blank'>$item->site</a></td><td class='text-center'><a data-id_supplier= $item->id href='viewOneSupplier.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-id_supplier='$item->id' class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                }
            }
//            $tableAllSuppTbody .= "";
        }
        else{
            $tableAllSuppTbody = "пока ничего нет (";
        }
        echo "$tableAllSuppTbody";
    }
}

//выбросить(подтянуть через include) на страницу форму добавления нового заказчика
if(isset($_POST['includeFormNewUser'])){
//    echo "привет->запрос на загрузку формы добавления (создания) нового поставщика";
    include '../../templates/formAddNewUser.php';
}
if(isset($_POST['includeViewOneUser'])){
    //echo 'пришел запрос на подтяжку в #main_modul показа одного юзера с параметром id    ';
    if(isset($_POST['id']))
        $idUserForViewOneUser = htmlspecialchars($_POST['id']);
    else
        $idUserForViewOneUser = "";
    include '../../templates/viewOneUser.php';

}