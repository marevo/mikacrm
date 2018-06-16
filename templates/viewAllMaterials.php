<?php
//можем здесь писать если просто вывод или пока что при подключении будет autoload.php в head.html
//require '../autoload.php';
//строка показа времени и показа результата добавки материала в базу
include_once 'App/html/forDisplayTimeShowAnswerServer.html'
?>


<div class="row"><!-- основной блок контета состоит из 2 колонок слева и 10 колонок справа -->

    <!--            начало доп блока слева
    <div class="col-lg-2 backForDiv">
        этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
    </div>
    <!--            конец доп блока слева-->
    <div class="col-lg-12 backForDiv">
        <div class="row headingContent"><!--строка для отображения названия страницы где находится пользователь -->
            <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center "> все материалы</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"></div>
        </div>
        <div class="row rowSearch"><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" size="22" id="inputFindMaterial" placeholder="по названию или доп характ"/>
                <button id="btnSearchMaterialLikeNameORLikeAddCharacteristic" class="btn-primary">искать</button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="makeNewMaterial" title="создать новый материал">
                <button class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый материал</button>
                <!--                        <label for="makeNewMaterial"  class="text-center"> </label>-->
                <!--                        <a href='formAddNewMaterialsToBase.php'> <div class="text-center"> </div></a>    -->
            </div>
        </div><!-- конец блока строки поиска  -->

        <div class="row backForDiv divForTable">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                //найдем все материалы и отобразим их через таблицу через трэйт FastViewTable.php
                //                echo \App\Models\Material::showAllFromTable('tableMaterials', \App\Models\Material::findAll());
                //                найдем все материалы с названиями поставщиков
                $allMaterialsInBase = \App\Models\Material::selectForView();
                if (!empty ($allMaterialsInBase)) {
                    $tableAllMat = "<table id ='tbViewAllMaterials'><thead><tr><td style='display: none;'>id</td><td>название</td><td>доп характ</td><td>ед изм</td><td>форма поставки</td><td>цена за ед</td><td style='display: none;'>id поставщика</td><td>поставщик</td><td><span class='glyphicon glyphicon-eye-open'></span></td><td><span class=\"glyphicon glyphicon-trash\"></span></td></tr></thead><tbody>";
                    foreach ($allMaterialsInBase as $item) {
//                                получим не false если есть этот материал хотябы в одном заказе
                        $ifExistOrderWithIdMaterial = \App\Models\MaterialsToOrder::ifExistThisMaterialInAnyOneOrder_2(intval($item['id']));
//                                if($ifExistOrderWithIdMaterial )
//                                   echo "<br/> c idMaterials = $item[id] есть заказы )";
//                                else
//                                    echo "<br/>   c idMaterials = $item[id] нет  заказов ";

                        if ($ifExistOrderWithIdMaterial) {
                            $tableAllMat .= "<tr><td style='display: none;'>$item[id]</td><td>$item[name]</td><td>$item[addCharacteristic]</td><td>$item[measure]</td><td>$item[deliveryForm]</td><td>$item[priceForMeasure]</td><td style='display: none;'>$item[idSupplier]</td><td>$item[nameSupplier]</td><td><a data-id=$item[id] href='viewOneMaterial.php?id=$item[id]'><span class='glyphicon glyphicon-eye-open'></span></a></td><td></td></tr>";
                        } else {
                            //получили false на запрос значит в заказах не используется это материал вствавим иконку удаления
                            $tableAllMat .= "<tr><td style='display: none;'>$item[id]</td><td>$item[name]</td><td>$item[addCharacteristic]</td><td>$item[measure]</td><td>$item[deliveryForm]</td><td>$item[priceForMeasure]</td><td style='display: none;'>$item[idSupplier]</td><td>$item[nameSupplier]</td><td><a data-id=$item[id] href='viewOneMaterial.php?id=$item[id]'><span class='glyphicon glyphicon-eye-open'></span></a></td><td data-id='$item[id]'><span class=\"glyphicon glyphicon-trash\"></span></td></tr>";
                        }
                    }
                    $tableAllMat .= "</tbody></table>";
                } else {
                    $tableAllMat = "пока ничего нет (";
                }
                echo "$tableAllMat";
                ?>
            </div>
        </div>

    </div>
</div>
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteMat" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">удалить материал навсегда!
                <button class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center">хотите удалить этот материал навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameMaterial"> название материала</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdMaterial"> id
                                    материала
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                    <button name="btnDeleteMaterial" class="btn btn-danger">да</button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                    <button class="btn btn-default" data-dismiss="modal">нет</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--modal-body-->
        </div><!--modal content-->
    </div><!--modal-dialog-->
</div><!--id="modalWinForDeleteMat" modal-fade -->

<script src='/js/viewAllMaterials.js'></script>




