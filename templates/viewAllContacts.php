<?php
//--строка показа времени и показа результата добавки материала в базу
 include_once 'App/html/forDisplayTimeShowAnswerServer.html';
?>
<div class="row"><!-- основной блок контета состоит из 12 колонок слева  -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  backForDiv">
        <!--строка для отображения названия страницы где находится пользователь -->
        <div class="row headingContent">
            <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12   text-center "> контакты </div>
        </div>
        <div class="row rowSearch" ><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="inputFindContact" placeholder="по названию ..доп характеристикам"/>
                <button id="btnSearchContactLikeNameORLikeAddCharacteristic" class="btn-primary">искать</button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"  >
                <button id="makeNewContactClient" title="создать новый контакт" class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый контакт</button>
                <button id="restoreLastDeletedContact" class="btn btn-primary" title="восстановить последний удаленный контакт"><span class='glyphicon glyphicon-cloud-upload'></span> восстановить контакт</button>
            </div>
        </div><!-- конец блока строки поиска  -->
        <div class="row backForDiv divForTable">
            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                $tableAllContact = "<table  id ='tbViewAllContacts' class='table-bordered'>
                                          <thead>
                                          <tr><td>название + доп характеристики</td><td>клиент контакта</td><td>телефон</td><td>email</td><td><span class='glyphicon glyphicon-eye-open'></span></td><td><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                $allContactInBase = \App\Models\Contacts::findAllOrderByName();
               // var_dump($allContactInBase);
                $ContactTBODY = "";
                if(! empty($allContactInBase)){
                    foreach ($allContactInBase as $itemCCIB){
//                        найдем имя клиента $itemCCIBNameClient если есть привязка контакта к клиенту
                        $itemCCIBNameClient = \App\Models\Client::findObjByIdStatic($itemCCIB->id_clients)->name;
                        $ContactTBODY .= "<tr><td>$itemCCIB->name</td><td data-id_clients='$itemCCIB->id_clients'>$itemCCIBNameClient</td><td>$itemCCIB->phone</td><td>$itemCCIB->email</td><td data-do='view' data-id = $itemCCIB->id><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-do='trash' data-id = $itemCCIB->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
                        //если не нужно искать имя клиента ( упрощенно выводим в таблицу id_clients
//                        $ContactTBODY .= "<tr><td>$itemCCIB->name</td><td>$itemCCIB->id_clients</td><td>$itemCCIB->phone</td><td>$itemCCIB->email</td><td data-do='view' data-id = $itemCCIB->id><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-do='trash' data-id = $itemCCIB->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
                    }
                    $ContactTBODY .= "</tbody></table>";
                }
                else{
                    $ContactTBODY = "<tbody><tr><td colspan='6' class='text-center'> пока ничего нет ( </td></tr></tbody></table>";
                }
                $tableAllContact .= $ContactTBODY;
                echo "$tableAllContact";
                ?>
            </div>
        </div>
    </div>
</div><!-- row end-->
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteContact" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center "> удаление контакта
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center text-danger">хотите удалить этот контакт навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameContact"> название контакта</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdContact"> id контакта</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteContact" class="btn btn-danger">да</button></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--modal-body-->
        </div><!--modal content-->
    </div><!--modal-dialog-->
</div><!--id="modalWinForDeleteContact" modal-fade -->

<script src = '/js/viewAllContacts.js'></script>




