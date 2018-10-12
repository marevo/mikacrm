<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.10.2018
 * Time: 23:40
 */

require_once ('../../autoload.php');
\App\FastViewTable::showAnswerServer('загрузим форму для добаления нового пользователя');
?>

<div class="row">

    <div class="col-lg-12 backForDiv">
        <div class="row">
            <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12 bg-primary  h2 text-center text-info">создание нового пользователя</div>
        </div>
        <div class="row"><!--форма добавки пользователя в базу -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pading0">
                <form  id="formOneUser"   method="post" action="../App/controllers/controllerOneUser.php" >
                    <table>
                        <thead><tr class="trDisplayNone">
                            <td>название поля</td>
                            <td>значение поля</td></tr></thead>
                        <tbody>
                        <!--невидимый маркер для отслеживания запроса добавки нового контакта в базу -->
                        <tr class="trDisplayNone">
                            <td class="text-right">скрытое поле  для отправки маркера</td>
                            <td class="text-left"><input  name="insertUserToBase"  value="sendMarkerToaddNewUserToBase"/></td>
                        </tr>
                        <tr><td class="text-right"><label for="idNameUser">название юзера</label></td>
                            <td class="text-left"><input maxlength="150" size="55" name="name" id="idNameUser"
                                       placeholder="Иванов Иван Иванович (max 150 символов)"/></td>
                        </tr>
                        <tr><td class="text-right"><label for="login">login</label></td>
                            <td class="text-left">
                                <input name="login" maxlength="50" type="text" placeholder="login" value=""/></td>
                        </tr>
                        <tr><td class="text-right"><label for="password">password</label></td>
                            <td><input type="tel" name="password" placeholder="пароль"  title="пароль" /></td>
                        </tr>
                        <tr><td class="text-right"><label for="email">email</label></td>
                            <td><input type="email" name="email"   placeholder="ivan@ivan.ua" title="формат email ivan@ivan.ua или ivan@ivan.ua.com"/></td>
                        </tr>

                        <tr><td class="text-right"></td><td><input type="submit" id="idsubmitFromFormOneUser"  name="submitFromFormOneUser" value="создать"/></td>
                        </tr>

                        </tbody>
                    </table>
                </form>

                <script type="text/javascript">
                    //обязательные поля для заполнения название юзера, login, name, password, email
                    $('form').submit(function () {
                        var elemInputNameUser = $(this).find($('#idNameUser'));
//                            var newNameContactSubmit = checkNotEmtyAndLengthTrue(elemInputNameContact , 3, 200);
//                            console.log("newNameContactSubmit = "+ newNameContactSubmit);
                        var elemInputLoginUser = $(this).find('[name = "login"]');
//                            var newPhoneContactSubmit = testOnPhoneExpand(elemInputPhoneContact);
//                            console.log("elemInputPhoneContact "+ newPhoneContactSubmit);
                        var elemInputPasswordUser = $(this).find('[name = "password"]');
//                           
                        var elemInputEmailUser = $(this).find('[name = "email"]');
//
                        if(
                            checkNotEmtyAndLengthTrue(elemInputNameUser , 5, 150)
                            && checkNotEmtyAndLengthTrue(elemInputLoginUser, 5, 50)
                            && checkNotEmtyAndLengthTrue(elemInputPasswordUser, 5, 20)
                            && testOnEmailExpand(elemInputEmailUser)
                        ){
                            console.log('variable checked');
//                                return false;
                            $.ajax({
                                type: $(this).attr('method'),
                                url: $(this).attr('action'),//ссылка куда идут данные,
                                data: $(this).serializeArray(),//сериализирует в виде асоциативного массива
                                success: function ( data) {
//                                     fUspehAll('удачно');
                                    $('.divForAnswerServer').html(data);
//                                     return false;
                                    $(this).find('.alert').remove();
//        alert('улетели данные ' + $(this).serializeArray());
                                    console.log($(this).serializeArray());

                                    //var timerId = setTimeout(function() {location.reload(); clearTimeout(timerId); }, 1000);
                                    // $(this).find('.alert').remove();
//                                        вернемся на показ всех user
                                    location.reload();
                                    return false;
                                }
                            });
                            $(this).find('.alert').remove();
                            return false;
                        }
//                          если дойдет сюда значит поля не валидные
                        console.log("не валидные поля");
                        return false;
//                            if($(this).find('[name=address]').val() ==""){
//                                $(this).find('[name=address]').prev().remove();
//                                $(this).find('[name=address]').before('<div class="alert alert-info">надо заполнить адрес (хотябы название города/села)</div>');
//                                return false;
//                            }
//                            $.post(
//                                $(this).attr('action'),//ссылка куда идут данные
////                                $(this).serialize() ,   //Данные формы
//                                $(this).serializeArray(),//сериализирует в виде массива
//                            );
                        //не пустим пока на сервер для добавления нового клиента
//                            console.log('отправки на добавку нового клиента в базу нет - удалите return false на строку ниже ');
//                            return false;


                    });
                </script>
            </div>
        </div><!-- .row -->
    </div>
</div><!-- .row -->

