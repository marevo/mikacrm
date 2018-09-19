<div class="row"><!-- основной блок контета состоит из 2 колонок слева и 10 колонок справа -->
    <!--<div class="col-lg-2 backForDiv"> <!-- начало доп блока слева
        этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
    </div> конец доп блока слева-->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 backForDiv">
        <?php
        //                получим из таблицы всех поставщиков и покажем через вызов быстрого показа в трэйте FastViewTable.php
        //echo \App\Models\Client::showAllFromTable('tableClient',\App\Models\Client::findAll());
        ?>
        <div class="row headingContent"><!--строка для отображения названия страницы где находится пользователь -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center   text-center "> клиенты</div>
        </div>
        <div class="row rowSearch"><!-- строка поиска-->
            <!--  сторка для поиска клиентов по name клиента или contactPerson -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="inputFindClient" placeholder="по названию"/>
                <button id="btnSearchClientLikeNameORLikeContactPerson" class="btn-primary">искать</button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <!--                        <label for="makeNewClient"  class="text-center">новый клиент</label>-->
                <div title="создать нового клиента" id="makeNewClient" class="addNewClient">
                    <button class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый клиент</button>
                    <!--                            <a href='formAddNewClientToBase.php'> <div class="text-center"> <span class='glyphicon glyphicon-plus'></span></div></a>-->
                    <script type="text/javascript">
                        $('#makeNewClient').on('click', includeFormAddNewClient);
                        function includeFormAddNewClient() {
                            jquery_send('#main_modul', 'post',
                                '../App/controllers/controllerViewAllClients.php', ['includeFormNewClient'], ['']);
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
                //найдем всех клиентов и отобразим их через таблицу
                $allClientsInBase = \App\Models\Client::findAllOrderByName();
                if ($allClientsInBase) {
                    $tableAllClients = "<table id='tbViewAllClients' class='table-bordered'><thead><tr><td class='tdDisplayNone'>id</td>" .
                        "<td>название</td><td>контакт</td><td>телефон 1</td><td class='tdDisplayNone'>телефон 2</td><td class='tdDisplayNone'>email</td>" .
                        "<td>адрес</td>" .
                        "<td class='text-center'><span class='glyphicon glyphicon-eye-open'></span></td>" .
                        "<td class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                    foreach ($allClientsInBase as $item) {
                        if(! $item->id)
                            continue;
                        //найдем id заказа для каждого клиента, чтобы узнать есть у него заказы и
                        // разрешать удалять только тех клиентов, у которых нет заказов
                        if ($item->ifExistAnyOrderForThisClient()) {
//                                есть  заказы поэтому не будем разрешать удалять клента
                            $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                                "<td>$item->phone0</td><td class='tdDisplayNone'>$item->phone1</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td>" .
                                "<td class='text-center'><a data-id = $item->id href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td><td></td></tr>";
                        } else {
                            // нет заказов у этого клиента, поэтому разрешим его удаление
                            $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                                "<td>$item->phone0</td><td class='tdDisplayNone'>$item->phone1</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td>" .
                                "<td class='text-center'><a data-id = $item->id href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                                "<td data-id='$item->id' class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                        }
                    }
                    $tableAllClients .= "</tbody></table>";
                } else {
                    $tableAllClients = "пока ничего нет (";
                }
                echo $tableAllClients;
                ?>
            </div>
        </div>
    </div>
</div><!-- row end-->
<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteClient" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center text-danger">клиент будет удален навсегда!
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center">хотите удалить этотого клиента навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameClient"> название клиента</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdClient"> id
                                    клиента
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                    <button name="btnDeleteClient" class="btn btn-danger">да</button>
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


<script src = '/js/viewAllClients.js'></script>






