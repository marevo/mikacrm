<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.10.2018
 * Time: 20:52
 */

//require_once 'autoload.php';
?>
<div class="row headingContent">
    <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12   text-center"> пользователи</div>
</div>
<div class="row rowSearch"><!-- строка поиска-->
    <!--  сторка для поиска заказов по клиенту и по названию заказа -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="inputFindUser">искать по
                    любому полю </label></div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="inputFindUser" placeholder="по любому полю"/></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <button id="btnSearchAnyField" class="btn-primary">искать</button>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

        <div title="создать нового пользователя" id="makeNewUser">
            <button class="btn btn-primary"><span class='glyphicon glyphicon-plus'></span> новый пользователь
            </button>
            <!--                    <a href='formAddNewSupplierToBase.php'> <div class="text-center"> <span class='glyphicon glyphicon-plus'></span></div></a>-->
            <script type="text/javascript">
//                $('#makeNewUser').on('click', includeFormAddNewSupplier);
//                function includeFormAddNewUser() {
//                    jquery_send('#main_modul', 'post',
//                        '../App/controllers/controllerViewAllUsers.php', ['includeFormNewUser'], ['']);
//                    //event.stopPropagation();
//                    //                            document.getElementById("#main_modul").innerHTML= '<?//// echo  include ('formAddNewOrder.php');?>////';
//                    return false;
//                }
            </script>

        </div>
    </div>
</div><!-- конец блока строки поиска  -->
<div class="row backForDiv divForTable">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        //найдем всех поставщиков и отобразим их через таблицу
        $allUsersInBase = \App\Models\User::findAll();
        if (!empty ($allUsersInBase)) {
            $tableAllUsers = "<table id='tbViewAllUsers' class='table-bordered'><thead><tr><td>id</td>" .
                "<td>название</td><td>логин</td><td>пароль</td><td>email</td><td>вопрос</td>" .
                "<td>ответ</td><td>сессия</td><td>дата</td><td>права</td>" .
                "<td  class='text-center'><span class='glyphicon glyphicon-eye-open'></span></td>" .
                "<td class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
            foreach ($allUsersInBase as $item) {
                    $timeIn = $item->getTimeIn();
                    $tableAllUsers .= "<tr><td>$item->id</td>" .
                        "<td>$item->name</td><td>$item->login</td><td>$item->password</td><td>$item->gmail</td><td>$item->secretQuestion</td>" .
                        "<td>$item->secretAnswer</td><td>$item->session</td><td>$timeIn</td><td>$item->rightUser</td>" .
                        "<td class='text-center'><a data-id_supplier = $item->id href='viewOneUser.php?id=$item->id'><span class='glyphicon glyphicon-eye-open'></span></a></td>" .
                        "<td data-id_user = $item->id class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr>";
                }
            $tableAllUsers .= "</tbody></table>";
        } else {
            $tableAllUsers = "пока ничего нет (";
        }
        echo "$tableAllUsers";
        ?>
    </div>
</div>

<!-- модальное окно для удаления   -->
<div id="modalWinForDeleteUser" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">удаление пользователя
                <button class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" style="background-color: #c0c7d2;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 text-center text-danger">хотите удалить этотого пользователя навсегда ?</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center " id="modalNameUser"> название пользователя</div>
                                <div style="display: none;" class="col-lg-12 text-center " id="modalIdUser"> id пользователя</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteUser" class="btn btn-danger">да</button></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--modal-body-->
        </div><!--modal content-->
    </div><!--modal-dialog-->
</div><!--id="modalWinForDeleteSupplier" modal-fade -->
<script src = '/js/viewAllUsers.js'></script>


