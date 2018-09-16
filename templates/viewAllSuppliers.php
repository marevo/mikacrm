<?php
//можем здесь писать если просто вывод или пока что при подключении будет autoload.php в head.html
require_once 'autoload.php';
?>

<div class="row"><!-- основной блок контета состоит из  12 колонок -->
    <div class="col-lg-12 backForDiv">
        <!--строка для отображения названия страницы где находится пользователь -->
        <div class="row headingContent">
            <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12   text-center"> поставщики</div>
        </div>
        <div class="row rowSearch"><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="inputFindMaterial">искать по
                            названию или доп характ </label></div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><input type="text" id="inputFindMaterial"
                                                                            placeholder="по названию"/></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button id="btnSearchMaterialLikeNameORLikeAddCharacteristic" class="btn-primary">искать
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <!--                    <label for="makeNewSupplier"  class="text-center">новый поставщик</label>-->
                <div title="создать нового поставщика" id="makeNewSupplier">
                    <button class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый поставщик
                    </button>
                    <!--                    <a href='formAddNewSupplierToBase.php'> <div class="text-center"> <span class='glyphicon glyphicon-plus'></span></div></a>-->
                    <script type="text/javascript">
                        $('#makeNewSupplier').on('click', includeFormAddNewSupplier);
                        function includeFormAddNewSupplier() {
                            jquery_send('#main_modul', 'post',
                                '../App/controllers/controllerViewAllSuppliers.php', ['includeFormNewSupplier'], ['']);
                            //event.stopPropagation();
                            //                            document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
                            return false;
                        }
                    </script>

                </div>
            </div>
        </div><!-- конец блока строки поиска  -->
        <div class="row backForDiv divForTable">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                //найдем всех поставщиков и отобразим их через таблицу
                $allSuppliersInBase = \App\Models\Supplier::findAll();
                if (!empty ($allSuppliersInBase)) {
                    $tableAllSupp = "<table id='tbViewAllSuppliers' class='table-bordered'><thead><tr><td class='tdDisplayNone'>id</td>" .
                        "<td>название</td><td>доп характ</td><td class='tdDisplayNone'>контакт</td><td>телефон</td><td class='tdDisplayNone'>email</td>" .
                        "<td>адрес поставщика</td><td class='tdDisplayNone'>день доставки</td><td class='tdDisplayNone'>сайт</td>" .
                        "<td  class='text-center'><span class='glyphicon glyphicon-eye-open'></span></td>" .
                        "<td class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                    foreach ($allSuppliersInBase as $item) {
                        //найдем idMaterial для каждого поставщика, чтобы узнать есть или нет эти материалы в заказах и
                        // разрешать удалять только тех поставщиков, чьих материалов нет в заказах
                        if (\App\Models\MaterialsToOrder::ifExistThisSupplierInAnyMaterilsToOrder($item->id)) {
//                                есть материал этото поставщика хотябы в одном заказе поэтому не будем разрешать удалять поставщика
                            $tableAllSupp .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->addCharacteristic</td>" .
                                "<td class='tdDisplayNone'>$item->contactPerson</td><td>$item->phone0</td><td class='tdDisplayNone'>$item->email0</td>" .
                                "<td>$item->address</td><td class='tdDisplayNone'> " . $item->getDeliveryDays() . " </td>" .
                                "<td class='tdDisplayNone'><a href='$item->site' target='_blank'>$item->site</a></td>" .
                                "<td class='text-center'><a data-id_supplier = $item->id href='viewOneSupplier.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                                "<td></td></tr>";
                        } else {
                            // нет материалов этого поставщика, поэтому разрешим его удаление
                            $tableAllSupp .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->addCharacteristic</td>" .
                                "<td class='tdDisplayNone'>$item->contactPerson</td><td>$item->phone0</td><td class='tdDisplayNone'>$item->email0</td>" .
                                "<td>$item->address</td><td class='tdDisplayNone'> " . $item->getDeliveryDays() . " </td>" .
                                "<td class='tdDisplayNone'><a href='$item->site' target='_blank'>$item->site</a></td>" .
                                "<td class='text-center'><a data-id_supplier = $item->id href='viewOneSupplier.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                                "<td data-id_supplier = $item->id class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                        }
                    }
                    $tableAllSupp .= "</tbody></table>";
                } else {
                    $tableAllSupp = "пока ничего нет (";
                }
                echo "$tableAllSupp";
                ?>
            </div>
        </div>
    </div>
</div><!-- row end-->
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteSupp" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">удаление поставщика
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center text-danger">хотите удалить этотого поставщика навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameSupplier"> название поставщика</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdSupplier"> id поставщика</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteSupplier" class="btn btn-danger">да</button></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--modal-body-->
        </div><!--modal content-->
    </div><!--modal-dialog-->
</div><!--id="modalWinForDeleteSupplier" modal-fade -->
<script src = '/js/viewAllSuppliers_2.js'></script>


