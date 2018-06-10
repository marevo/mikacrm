<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.06.2018
 * Time: 6:33
 */
require_once ('../../autoload.php');
$idContact=1;
if(isset($_POST['idOneContact'])){
//    если передали id значит работаем с ним иначе будем брать в else по умолчанию id=1
    $idContact = intval($_POST['idOneContact']);
    \App\FastViewTable::showUspeh("есть контакт с id = $idContact");
}
else{
    \App\FastViewTable::showUspeh("ошибка в id = $idContact");
}
$cont = \App\Models\Contacts::findObjByIdStatic($idContact);
//var_dump($cont);
?>

<title> просмотр/правка данных контакта </title>


<div class="row">
    <!--            начало доп блока слева
    <div class="col-lg-2 backForDiv">
        этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
    </div>
    <!--            конец доп блока слева-->
    <div class="col-lg-12 backForDiv">
        <!--строка показа времени и показа результата добавки материала в базу  -->
        <?php  include_once '../../App/html/forDisplayTimeShowAnswerServer.html'?>
        <div class="row headingContent">
            <div class="col-lg-10  col-md-10 col-sm-10 col-xs-10   text-center ">правка контакта <?php echo $cont->name;?></div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center"><button class="btn btn-sm btn-primary" id="btnUpdateShow" > обновить </button></div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center'><button class='btn btn-sm btn-primary' id='btnEnableUpdate' >править</button></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="../App/controllers/controllerViewOneContact.php" method="post">
                    <table>
                        <thead>
                        <tr>
                            <td>название поля</td>
                            <td>значение</td>
                            <td class="tdDisplayNone">новое значение</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr><td>название контакта</td>
                            <td><?php echo $cont->name ?></td>
                            <td class="tdDisplayNone"><input name="name" type="text"  maxlength="200" title =" новое название <?php echo "$cont->name "?>" value="<?php echo $cont->name ?>"/></td></tr>
                        <?php $clientName = \App\Models\Client::findNameClient($cont->id_clients);  ?>
                        <tr><td>принадлежность к клиенту</td><td><?php echo "$clientName" ?></td>
                            <td class="tdDisplayNone">

                                    <?php
                                    $allClient = \App\Models\Client::findAllOrderByName();
                                    if(false != $allClient) {
                                        $optionsNameClient="<option value='0'>выберите клиента</option>";
                                        foreach ($allClient as $client){
                                            $optionsNameClient.= "<option value='$client->id'> $client->name</option>";
                                        }
                                    echo "<select> name = 'selectNameClient' $optionsNameClient </select>";
                                    }
                                    else echo "база клиентов пуста(";

                                    ?>

                            </td></tr>
                        <tr><td>телефон</td><td><?php echo $cont->phone ?></td><td class="tdDisplayNone">
                                <input name="phone" maxlength="50" type="text" value="<?php echo $cont->phone ?>"/></td></tr>
                        <tr><td>email</td><td><?php echo $cont->email ?></td><td class="tdDisplayNone">
                                <input name="email" maxlength="50" type="text" value="<?php echo $cont->email ?>"/></td></tr>
                       <tr><td></td><td></td><td class="tdDisplayNone"><input name="nameOneContactFromClientUpdate" type="submit"/></td></tr>
                        <tr style="display: none;"><td>скрытое поле</td><td>маяк</td><td><input name="updateOneContact" value='<?php echo "$cont->id"?>' /></td></tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <table></table>
    </div>
</div>

<script type="text/javascript" src="/js/viewOneContact.js"></script>
<script type="text/javascript">
    //выбор в селекте нужного значения по id поставщика
    $(function () {
        $('select').val('<?php echo $cont->id_clients ;?>');
    });
</script>






