<?php
//--строка показа времени и показа результата добавки материала в базу
 include_once 'App/html/forDisplayTimeShowAnswerServer.html';
?>
<div class="row"><!-- основной блок контета состоит из 2 колонок слева и 10 колонок справа -->

    <!--            начало доп блока слева
    <div class="col-lg-2 backForDiv">
        этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
    </div>
    <!--            конец доп блока слева-->
    <div class="col-lg-12 backForDiv">
        <!--строка для отображения названия страницы где находится пользователь -->
        <div class="row headingContent">
            <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center "> все контакты </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"></div>
        </div>
        <div class="row rowSearch" ><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="inputFindContactClient">искать по названию или доп характ </label></div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><input type="text" id="inputFindContactClient" placeholder="по названию"/></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><button id="btnSearchContactClientLikeNameORLikeAddCharacteristic" class="btn-primary">искать </button></div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="makeNewContactClient" title="создать новый контакт">
                <button class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый контакт</button>
            </div>
        </div><!-- конец блока строки поиска  -->
        <div class="row backForDiv divForTable">
            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tableParent">
                <?php
                $tableAllContact = "<table  id ='tbViewAllContact'>
                                          <thead>
                                          <tr><td>ФИО</td><td>id_client</td><td>телефон</td><td>email</td><td><span class='glyphicon glyphicon-eye-open'></span></td><td><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                $allContactInBase = \App\Models\Contacts::findAllOrderByName();
               // var_dump($allContactInBase);
                $ContactTBODY = "";
                if(! empty($allContactInBase)){
                    foreach ($allContactInBase as $itemCCIB){
                        $ContactTBODY .= "<tr><td>$itemCCIB->name</td><td>$itemCCIB->id</td><td>$itemCCIB->phone</td><td>$itemCCIB->email</td><td data-do='view' data-id = $itemCCIB->id><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-do='trash' data-id = $itemCCIB->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
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
</div>
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteContact" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">удалить контакт навсегда!
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-folder-close"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center">хотите удалить этот контакт навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameMaterial"> название контакта</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdMaterial"> id контакта</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteMaterial" class="btn btn-danger">да</button></div>
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




