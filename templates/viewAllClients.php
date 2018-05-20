<?php
//require_once 'autoload.php';
////       echo get_called_class();
////        echo Нужно отметить, что для большего удобства в PHP кроме слова «static» есть еще специальная функция get_called_class(), которая сообщит вам — в контексте какого класса в данный момент работает ваш код.
?>
<!DOCTYPE HTML>
 <html lang="ru-RU">
    <?php
       //include('../head.html');
    ?>
    <body>
    <div class="container">
        <!--<div class="row">
            <?php //require_once('header.html'); ?>
        </div>
<!--        добавление панели навигации
        <div class="row"><!-- навигация 
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                     //require_once('../navigation.html');
                ?>
                <script>
                    showLi('клиенты');
                </script>

            </div>
            <!-- конец навигации 
        </div>-->
        <!--строка показа времени и показа результата добавки материала в базу  -->
        <?php  include_once 'App/html/forDisplayTimeShowAnswerServer.html'?>
        <div class="row"><!-- основной блок контета состоит из 2 колонок слева и 10 колонок справа -->
            <!--<div class="col-lg-2 backForDiv"> <!-- начало доп блока слева
                этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
            </div> конец доп блока слева-->
            <div class="col-lg-12 backForDiv">
                <?php
                //                получим из таблицы всех поставщиков и покажем через вызов быстрого показа в трэйте FastViewTable.php
                //echo \App\Models\Client::showAllFromTable('tableClient',\App\Models\Client::findAll());
                ?>
                <div class="row headingContent"><!--строка для отображения названия страницы где находится пользователь -->
                    <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center ">клиенты</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"></div>
                </div>
                <div class="row rowSearch" ><!-- строка поиска-->
                    <!--  сторка для поиска клиентов по name клиента или contactPerson -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="inputFindClient">искать по названию или контакту </label></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><input type="text" id="inputFindClient" placeholder="по названию"/></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><button id="btnSearchClientLikeNameORLikeContactPerson" class="btn-primary">искать </button></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label for="makeNewClient"  class="text-center">новый клиент</label>
                        <div title="создать нового клиента" id="makeNewClient" class="addNewClient">
                            <a href='formAddNewClientToBase.php'> <div class="text-center"> <span class='glyphicon glyphicon-plus'></span></div></a>
                            <script type="text/javascript">
                                $('#makeNewClient').on('click',includeFormAddNewClient);
                                function includeFormAddNewClient() {
                                    jquery_send('#main_modul','post',
                                        '../App/controllers/controllerViewAllClients.php',['includeFormNewClient'],['']);
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
                        if($allClientsInBase){
                            $tableAllClients = "<table id='tbViewAllClients'><thead><tr><td class='tdDisplayNone'>id</td>" .
                                "<td>название</td><td>контакт</td><td>телефон 1</td><td class='tdDisplayNone'>телефон 2</td><td class='tdDisplayNone'>email</td>" .
                                "<td>адрес</td>" .
                                "<td class='text-center'><span class='glyphicon glyphicon-eye-open'></span></td>" .
                                "<td class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
                            foreach ($allClientsInBase as $item){
                                //найдем id заказа для каждого клиента, чтобы узнать есть у него заказы и
                                // разрешать удалять только тех клиентов, у которых нет заказов
                                if($item->ifExistAnyOrderForThisClient()){
//                                есть  заказы поэтому не будем разрешать удалять клента
                                    $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                                        "<td>$item->phone0</td><td class='tdDisplayNone'>$item->phone1</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td>" .
                                        "<td class='text-center'><a data-id = $item->id href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td><td></td></tr>";
                                }
                                else{
                                    // нет заказов у этого клиента, поэтому разрешим его удаление
                                    $tableAllClients .= "<tr><td class='tdDisplayNone'>$item->id</td><td>$item->name</td><td>$item->contactPerson</td>" .
                                        "<td>$item->phone0</td><td class='tdDisplayNone'>$item->phone1</td><td class='tdDisplayNone'>$item->email0</td><td>$item->address</td>" .
                                        "<td class='text-center'><a data-id = $item->id href='viewOneClient.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                                        "<td data-id='$item->id' class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                                }
                            }
                            $tableAllClients .= "</tbody></table>";
                        }
                        else{
                            $tableAllClients = "пока ничего нет (";
                        }
                        echo $tableAllClients;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- модальное окно для удаления   -->
        <div id="modalWinForDeleteClient" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">удалить клиента навсегда!
                        <button class="close" data-dismiss="modal">x</button>
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
                                        <div style="display: none;" class="col-lg-12 text-center " id="modalIdClient"> id клиента</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteClient" class="btn btn-danger">да</button></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--modal-body-->
                </div><!--modal content-->
            </div><!--modal-dialog-->
        </div><!--id="modalWinForDeleteMat" modal-fade -->
    </div>
    </body>
    </html>
<script src = '/js/viewAllClients.js'></script>

<script type='text/javascript'>

</script>




