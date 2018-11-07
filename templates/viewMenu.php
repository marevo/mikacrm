<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.11.2018
 * Time: 22:03
 */

//                получим из таблицы всех поставщиков и покажем через вызов быстрого показа в трэйте FastViewTable.php
//echo \App\Models\Client::showAllFromTable('tableClient',\App\Models\Client::findAll());

?>
<!--<div class="row">--><!-- основной блок контета состоит из 12 колонок слева  -->
<!--    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  backForDiv">-->
        <!--строка для отображения названия страницы где находится пользователь -->
        <div class="row headingContent">
            <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12   text-center "> просмотр/правка меню </div>
        </div>
        <div class="row rowSearch" ><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="inputFindContact" placeholder="по названию ..доп характеристикам"/>
                <button id="btnSearchContactLikeNameORLikeAddCharacteristic" class="btn-primary">искать</button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"  >
                <button id="createNewMenuIter" title="создать новый пункт меню" class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый пункт меню</button>
                <button id="restoreLastDeletedMenuItem" class="btn btn-primary" title="восстановить последний удаленный пункт меню"><span class='glyphicon glyphicon-cloud-upload'></span> восстановить</button>
            </div>
        </div><!-- конец блока строки поиска  -->
        <div class="row backForDiv divForTable">
            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                $tableAllMenuItem = "<table  id ='tbViewMenu' class='table-bordered'>
                                          <thead>
                                          <tr><td>id</td><td>parent_id</td><td>title</td><td>handler</td><td>image</td><td>numberInOrder</td><td><span class='glyphicon glyphicon-eye-open'></span></td><td><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                $allMenuItems = \App\Models\Menu::findAll();
//                var_dump($allMenuItems);
                $menuTBODY = "";
                if(! empty($allMenuItems)){
                    foreach ($allMenuItems as $itemMenu){
                        $menuTBODY .=
                            "<tr><td>$itemMenu->id</td>".
                            "<td data-id_parent_id='$itemMenu->parent_id'>$itemMenu->parent_id</td>".
                            "<td>$itemMenu->title</td>".
                            "<td>$itemMenu->handler</td>".
                            "<td>$itemMenu->image</td>".
                            "<td>$itemMenu->numberInOrder</td>".
                            "<td data-do='view' data-id = $itemMenu->id><span class='glyphicon glyphicon-eye-open'></span></a></td>".
                            "<td data-do='trash' data-id = $itemMenu->id><span class='glyphicon glyphicon-trash'></span></td></tr>";
                       }
                    $menuTBODY .= "</tbody></table>";
                }
                else{
                    $menuTBODY = "<tbody><tr><td colspan='6' class='text-center'> пока ничего нет ( </td></tr></tbody></table>";
                }
                $tableAllMenuItem .= $menuTBODY;
                echo "$tableAllMenuItem";
                ?>
             </div>
        </div>
<!--    </div>-->
<!--</div>--><!-- row end-->
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteMenuItem" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center "> удаление пункта меню
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center text-danger">хотите удалить этот пунтк меню навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameContact"> название пункта меню</div>
                                <div class="col-lg-12 text-center " id="modalIdContact"> id пункта меню</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteMenuItem" class="btn btn-danger">да</button></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--modal-body-->
        </div><!--modal content-->
    </div><!--modal-dialog-->
</div><!--id="modalWinForDeleteMenuItem" modal-fade -->

<script src = '/js/viewMenu.js'></script>




