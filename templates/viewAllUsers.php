<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 26.09.2017
 * Time: 21:21
 */
//require "../autoload.php";
use App\Models;
use App\Models\User;
?>
<!DOCTYPE HTML>
<html lang="ru-RU">
<?php
//include('../head.html');
$isAdmin = false;
$objUser = false;
if( (isset($_POST['login']) && isset($_POST['password'])) || (isset($_GET['login']) && isset($_GET['password'])) ){
    if(isset($_POST['login']) && isset($_POST['password'])){
        $login = htmlspecialchars($_POST['login']) ;
        $password = htmlspecialchars($_POST['password']) ;
    }else{
        $login = htmlspecialchars($_GET['login']) ;
        $password = htmlspecialchars($_GET['password']) ;
    }
    $objUser = User::getUserStatic($login, $password);
//    var_dump($objUser);
    if($objUser && $objUser->isAdmin()){
        $isAdmin = true;
    }
}

//Найти all users
/**
 * @param bool $isAdmin 
 * @param []$allUdersInBase
 */
function createTbAllUsers($isAdmin,$allUsersInBase)
{
    if ($isAdmin && $allUsersInBase ) {
        if ($allUsersInBase) {
            $tableAllUsers = "<table id='tbViewAllUsers'><thead><tr><td>idUser</td><td>имя</td>" .
                "<td>логин</td><td>пароль</td><td>почта</td><td>к вопрос</td><td> к ответ</td>" .
                "<td>grants</td><td>session</td><td>update</td>" .
                "<td class = 'text-center'><span class = 'glyphicon glyphicon-edit'></span></td>" .
                "<td class='text-center'><span class='glyphicon glyphicon-trash'></span></td></tr></thead><tbody>";
            foreach ($allUsersInBase as $user) {
                $tableAllUsers .= "<tr><td>$user->id</td><td>$user->name</td><td>$user->login</td>" .
                    "<td>$user->password</td><td>$user->gmail</td><td>$user->secretQuestion</td>" .
                    "<td>$user->secretAnswer</td><td>$user->rightUser</td><td>$user->session</td>" .
                    "<td>$user->updated</td>" .
                    "<td class = 'text-center'><button class = 'btn btn-default'" .
                    " data-id = '$user->id' name='btnEditModalUser'><span class='glyphicon glyphicon-edit'></span></button></td>" .
                    "<td class='text-center'><button class='btn btn-default'" .
                    " data-id='$user->id' name='btnDeleteModalUser'" .
                    " ><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
            }
            $tableAllUsers .= "</tbody></table>";
        } else {
            $tableAllUsers = "<table id='tbViewAllUsers'><thead></thead><tbody><tr><td>пока ничего нет (</td></tr></tbody></table> ";
        }
        return $tableAllUsers;
    } else {
        return "<table id='tbViewAllUsers'><thead></thead><tbody><tr><td>вас нет прав просмотра :(</td></tr></tbody></table>";
    }
}

?>
<body>
<div class="container">
   <!-- <div class="row">
        <?php //require_once('header.html'); ?>
    </div>
            добавление панели навигации
    <div class="row"><!-- навигация 
        <?php
        //require_once('../navigation.html');
        ?>
        <script>
            showLi('пользователи');
        </script>
    </div><!-- конец навигации -->
    <!--строка показа времени и показа результата добавки материала в базу  -->
    <?php  include_once 'App/html/forDisplayTimeShowAnswerServer.html'?>
    <div class="row"><!-- основной блок контета состоит из 2 колонок слева и 10 колонок справа -->
        <!--<div class="col-lg-2 backForDiv"> <!-- начало доп блока слева
            этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
        </div><!-- конец доп блока слева-->
        <div class="col-lg-12 backForDiv">

            <div class="row headingContent"><!--строка для отображения названия страницы где находится пользователь -->
                <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center ">пользователи</div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"></div>
            </div>
            <div class="row rowSearch" ><!-- строка поиска-->
                <!--  сторка для поиска  -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><label for="inputFindForNameUser"> названию пользователя </label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                    </div>
                    <div class="row">
                        <?php 
                              if($isAdmin)
                                 echo "<div class=\"col-lg-3 col-md-3 col-sm-3 col-xs-3\"><input type=\"text\" id=\"inputFindForNameOrLoginUser\"/></div>
                                       <div class=\"col-lg-3 col-md-3 col-sm-3 col-xs-3\"><button id=\"btnFindUser\" class=\"btn-primary\">искать </button></div>";
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 "><?php
                    if($objUser->name){
                        if($isAdmin)
                            echo "привет admin: $objUser->name ";
                        else
                             echo "здравствуйте:  $objUser->name ";
                    }?>
                </div>
                <?php if($isAdmin){
                    echo "<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-2\">
                    <label for=\"makeNewClient\"  class=\"text-center\">новый пользователь</label>
                    <div title=\"создать новый платеж\" ></div>
                    <a  id=\"makeNewPaymentFromModalFormAddNewPayment\"> <div class=\"text-center\"> <span class='glyphicon glyphicon-plus'></span></div></a>
                </div>";
                }else{
                    echo "<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-2\"></div>";
                }
                ?>

            </div><!-- конец блока строки поиска  -->

            <div class="row backForDiv divForTable">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                    //если зашел на страницу  admin то вызовем все записи, и отправим на страницу
                    if($isAdmin){
                        $allUsersInBase = User::findAllOrderByName();
                        $tableAllUsers = createTbAllUsers($isAdmin,$allUsersInBase);
                        echo $tableAllUsers;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- модальное окно для удаления user  -->
    <div id="modalWinForDeleteUser" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">удалить пользователя навсегда!
                    <button class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row" style="background-color: #c0c7d2;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 text-center">хотите удалить этого пользователя навсегда ?</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center " id="modalNameClient"> название пользователя</div>
                                    <div style="display: block;" class="col-lg-12 text-center " id="modalIdUser"> id user</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button name="btnDeleteUser"
                                                                                                         class="btn btn-danger">да</button></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center"><button class="btn btn-default" data-dismiss="modal">нет</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--modal-body-->
            </div><!--modal content-->
        </div><!--modal-dialog-->
    </div><!--id="modalWinForDeleteMat" modal-fade -->

    <!-- модальное окно для показа всех данных user по клику кнопки -->
    <div id="modalViewUpdateUser" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center" >показываем все о пользователе
                    <button class="close" data-dismiss="modal">x</button>
                    <div>
                        <div class=" uspeh text-center "><span class="glyphicon glyphicon-import "> успешно</span></div>
                        <div class=" noUspeh text-center "><span class="glyphicon glyphicon-alert "> ошибка обратитесь к разработчику</span></div>
                        <!-- в поле с классом divForAnswerServer будем получать ответы сервера (script ) -->
                        <div class="divShowAnswerServer">ответ сервера</div>
                    </div>
                </div><!-- end modal-header -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <table id="tbModalDataUser">
                                        <thead><tr><td>поле</td><td>старое знач</td><td>новое знач</td><td></td></tr></thead>
                                        <tbody>
                                        <tr><td>idUser</td><td></td><td data-id></td><td></td><td></td></tr>
                                        <tr><td>имя</td><td></td><td data-name></td><td><input size="15"/></td><td data-name=""><button class="btn btn-default btn-sm" data-name="">править</button></td></tr>
                                        <tr><td>логин</td><td data-login></td><td><input size="15"/></td><td data-login=""><button class="btn btn-default btn-sm" data-login="">править</button></td></tr>
                                        <tr><td>пароль</td><td data-password></td><td><input size="15"/></td><td data-password=""><button class="btn btn-default btn-sm" data-password="">править</button></td></tr>
                                        <tr><td>почта</td><td data-mail></td><td><input size="15"/></td><td data-mail=""><button class="btn btn-default btn-sm" data-mail="">править</button></td></tr>
                                        <tr><td>к вопрос</td><td data-question></td><td><input size="15"/></td><td data-question=""><button class="btn btn-default btn-sm" data-question="">править</button></td></tr>
                                        <tr><td> к ответ</td><td data-answer></td><td><input size="15"/></td><td data-answer=""><button class="btn btn-default btn-sm" data-answer="">править</button></td></tr>
                                        <tr><td>session</td><<td></td><td data-session></td><td></td><td></td></tr>
                                        <tr><td>update</td><td></td><td data-update></td><td></td><td></td></tr>
                                        <tr><td>update</td><td></td><td data-update></td><td></td><td></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!--modal-body-->
                <div class="modal-futer">
                </div>
            </div><!--modal content-->
        </div><!--modal-dialog-->
    </div><!--modal-fade -->
    <!-- модальное окно правки данных user  -->
</div>
</body>
</html>
<script src="/js/viewAllUsers.js"></script>


