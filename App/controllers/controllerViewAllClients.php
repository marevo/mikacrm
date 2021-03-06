<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 05.09.2017
 * Time: 22:00
 */
require "../../autoload.php";


if(isset($_POST['deleteClientFromBase'])){
//    echo "пришел запрос на удаление поставщика из базы";
    if (isset($_POST['idClient'])){
        $idClient = intval($_POST['idClient']);
//        $res = true;
//        $res = false;
        try{
            $res = \App\Models\Client::deleteObj($idClient);
            if($res){
                \App\ModelLikeTable::showUspeh('успешно удалили');
                echo "<script>$('[data-id = $idClient]').parent().remove() ;</script>";
            }
            else{
                \App\ModelLikeTable::showNoUspeh('не удалось удалить клиента');
            }
        }
        catch (PDOException $ex){
            \App\ModelLikeTable::showNoUspeh("$ex не нашли такого клиента в базе");
        }

    }
}
//поиск клиентов  по подобию в name или 
if(isset($_POST['searchLike'])){
    if(isset($_POST['likeValue'])){
        $likeValue = htmlspecialchars($_POST['likeValue']);
        $findClients = \App\Models\Client::searchAllForLikeNameOrLikeContactPerson($likeValue);
//        var_dump($findClients);
        if(! empty ($findClients)){
            $tableAllClientTbody = "";
            foreach ($findClients as $item){
                //найдем заказы для каждого клиента, чтобы узнать есть или нет у него заказы и
                // разрешать удалять только тех клиентов, у которых нет  заказов то есть ставим значек glyphicon-trash
                if($item->ifExistAnyOrderForThisClient()){
//                                есть  заказы поэтому не будем разрешать удалять клента
                    $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                        "<td>$item->phone0</td><td>$item->phone1</td><td>$item->email0</td><td>$item->address</td>" .
                        "<td class='text-center'><a href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td><td></td></tr>";
                }
                else{
                    // нет заказов у этого клиента, поэтому разрешим его удаление
                    $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                        "<td>$item->phone0</td><td>$item->phone1</td><td>$item->email0</td><td>$item->address</td>" .
                        "<td class='text-center'><a href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                        // разрешать удалять только тех клиентов, у которых нет  заказов то есть ставим значек glyphicon-trash

                        "<td data-id='$item->id' class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                }
            }
//            \App\ModelLikeTable::showUspeh('есть такие клиенты');
        }
        else{
            $tableAllClients = "пока ничего нет (";
            \App\ModelLikeTable::showNoUspeh('нет клиентов с такими данными');
        }
        echo "$tableAllClients";
    }
}

//выброс ( подтяжка через include) формы добавки нового клиента
if(isset($_POST['includeFormNewClient'])){
    echo "привет->запрос на загрузку формы добавления (создания) нового клента";
//    include '..\templates\formAddNewClientToBase.php';
    include '../../templates/formAddNewClientToBase.php';
}

if(isset($_POST['includeViewOneClient'])){
    echo 'пришел запрос на подтяжку в #main_modul показа одного клиента с параметром id клиент    ';
    if(isset($_POST['idClient'])){
        $idClient = htmlspecialchars($_POST['idClient']);
    }
    if(isset($_POST['tarHref'])){
        $tarHref = htmlspecialchars($_POST['tarHref']);
        include '../../templates/viewOneClient.php';
    }

}