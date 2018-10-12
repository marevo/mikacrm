<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 09.10.2018
 * Time: 2:54
 */
if(isset($idUserForViewOneUser)){
    \App\FastViewTable::showUspeh("ищем юзера");
    $oneUserView = \App\Models\User::findObjByIdStatic($idUserForViewOneUser);
}
else{
    \App\FastViewTable::showNoUspeh("не передан параметр для поиска юзера");
    \App\FastViewTable::showNoUspeh("\"ошибка при просмотре пользователя обратитесь к разработчику");
}
if($oneUserView) \App\FastViewTable::showUspeh("нашли юзера $oneUserView->name ");
//var_dump($oneUserView);
?>
<title> просмотр/правка данных юзера </title>
<div class="row">
    <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 backForDiv">
        <div class="row headingContent">
            <div class="col-lg-10  col-md-10 col-sm-10 col-xs-10   text-center ">правка юзера <?php echo $oneUserView->name;?></div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center"><button class="btn btn-sm btn-primary" id="btnUpdateShow" > вернуться </button></div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center'><button class='btn btn-sm btn-primary' id='btnEnableUpdate' >править</button></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="../App/controllers/controllerOneUser.php" method="post">
                    <table>
                        <thead>
                        <tr>
                            <td>название поля</td>
                            <td>значение</td>
                            <td class="tdDisplayNone">новое значение</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr><td>название юзера</td>
                            <td><?php echo $oneUserView->name ?></td>
                            <td class="tdDisplayNone"><input name="name" type="text"  maxlength="150" title ="новое название <?php echo "$oneUserView->name "?>" value="<?php echo $oneUserView->name ?>"/></td></tr>
                        <tr><td>права юзера</td>
                            <td>
                                <?php echo  "$oneUserView->rightUser"; ?>
                            </td>
                            <td class="tdDisplayNone">
                                <?php
                                $userRightAll = explode(' ', \App\Models\User::AllRightForUser );
                                if(false != $userRightAll) {
                                    $optionsRight="<option value='0'>сделайте выбор</option>";
                                    foreach ($userRightAll as  $oneRight){
                                        $optionsRight.= "<option value='+ $oneRight'> + $oneRight</option><option value='- $oneRight'> - $oneRight</option> ";
                                    }
                                    echo "<select name = 'selecRightUser'>  $optionsRight </select>";
                                }
                                else echo "нет прав у этого пользователя(";
                                ?>
                            </td></tr>
                        <tr><td>login</td><td><?php echo $oneUserView->login ?></td><td class="tdDisplayNone">
                                <input name="login" maxlength="50" type="text" value="<?php echo $oneUserView->login?>"/></td></tr>
                        <tr><td>password</td><td><?php //echo $oneUserView->password ?></td><td class="tdDisplayNone">
                                <input name="password" maxlength="100" type="text" placeholder="enter new password" value="<?php// echo $oneUserView->password ?>"/></td></tr>
                        <tr><td>email</td><td><?php echo $oneUserView->gmail ?></td><td class="tdDisplayNone">
                                <input name="email" maxlength="100" type="text" value="<?php echo $oneUserView->gmail ?>"/></td></tr>
                        <tr><td>секретный вопрос</td><td><?php echo $oneUserView->secretQuestion ?></td><td class="tdDisplayNone">
                                <input name="sQuestion" maxlength="100" type="text" value="<?php echo $oneUserView->secretQuestion ?>"/></td></tr>
                        <tr><td>секретный ответ</td><td><?php echo $oneUserView->secretAnswer ?></td><td class="tdDisplayNone">
                                <input name="sAnswer" maxlength="100" type="text" value="<?php echo $oneUserView->secretAnswer ?>"/></td></tr>
                        <tr><td>сессия</td><td><?php echo $oneUserView->session ?></td><td class="tdDisplayNone">
                                <input name="session" maxlength="32" type="text" disabled value="<?php echo 'нельзя править' ?>"/></td></tr>
                      <?php
                       $timeIn = $oneUserView->lastVisitAge();
                      ?>
                        <tr><td>последний заход</td><td><?php echo $timeIn ?></td><td class="tdDisplayNone">
                                <input name="updated" maxlength="50" type="text" disabled value="<?php echo 'нельзя править' ?>"/></td></tr>

                        <tr><td></td><td></td><td class="tdDisplayNone"><input name="nameOneUserFromClientUpdate" type="submit" value="править"/></td></tr>
                        <tr style="display: none;"><td>скрытое поле</td><td>маяк</td><td><input name="updateOneUser" value='<?php echo "$oneUserView->id"?>' /></td></tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/viewOneUser.js"></script>
<script type="text/javascript">
    //выбор в селекте значения по умолчанию value=0
    $(function () {
//        $('select').val('<?php //echo $oneUserView->id_clients ;?>//');
        $('select').val('0');
    });
</script>








