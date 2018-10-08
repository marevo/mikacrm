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
                <form  id="formOneContact"   method="post" action="../App/controllers/controllerOneUser.php" >
                    <table>
                        <thead><tr class="trDisplayNone">
                            <td>название поля</td>
                            <td>значение поля</td></tr></thead>
                        <tbody>
                        <!--невидимый маркер для отслеживания запроса добавки нового контакта в базу -->
                        <tr class="trDisplayNone">
                            <td class="text-right">скрытое поле  для отправки маркера</td>
                            <td class="text-left"><input  name="insertContactToBase"  value="sendMarkerToaddNewUserToBase"/></td>
                        </tr>
                        <tr><td class="text-right"><label for="nameContact">название пользователя</label></td>
                            <td class="text-left">
                                <input maxlength="150" size="55" name="nameUser" id="idNameUser"
                                       placeholder="Иванов Иван Иванович (max 150 символов)"  /></td>
                        </tr>
                        <!--                            <tr><td class="text-right"><label for="contactPerson">контактное лицо фио</label></td>-->
                        <!--                                <td class="text-left"><input maxlength="100" size="55"  name="contactPerson" placeholder="Иванов Иван Иванович"  /></td>-->
                        <!--                            </tr>-->
                        <tr><td class="text-right"><label for="login">login</label></td>
                            <td><input type="tel" name="password" placeholder="пароль"  title="пароль" /></td></tr>
                        <tr><td class="text-right"><label for="gmail">email</label></td>
                            <td><input type="email" name="gmail"   placeholder="ivan@ivan.ua" title="формат email ivan@ivan.ua или ivan@ivan.ua.com"/></td>
                        </tr>
                        <tr><td class="text-right"><label for="right">права</label></td>
                            <td><input type="text" name="right"   placeholder="c r u d " title="c r u d"/></td>
                        </tr>

                        <tr><td class="text-right"></td><td><input type="submit" id="idsubmitFromFormOneUser"  name="submitFromFormOneUser"/></td>
                        </tr>

                        </tbody>
                    </table>
                </form>

                <script type="text/javascript">
                    //                        $('form select').on('change',function () {
                    //                            if($(this).val() == 0) {
                    //                                $('.alert .alert-info').remove();
                    //                                $(this).before('<div class="alert alert-info">выберитите поставщика из выпадающего списка</div>');
                    //                                return false;
                    //                            }
                    //                            else
                    //                                $('.alert').remove();
                    //                            return false;
                    //                        });
                    //обработка полей textarea  на min & max кол символов и отсутсвие пробелов по краям
                    //                        var newNameContactSubmit = false; //флаговая переменная для определения валидности в поле имя
                    //                        $('#idNameContact').on('blur', function (event) {
                    //                            var elemInput = $(this);
                    //                            //запустим функцию проверки на пустоту и на min max количество символов в поле input #idNameContact
                    //                            newNameContactSubmit = checkNotEmtyAndLengthTrue(elemInput, 3, 200);
                    //                        });
                    ////
                    //                        //обработка полей телефона и имейла
                    //                        var newPhoneContactSubmit = false;//флаговая переменная для определения валидности в поле телефон
                    //                        var newEmailContactSubmit = false;//флаговая переменная для определения валидности в поле email
                    //                        $('form input').on('blur',function (event) {
                    //                            //проверка на валидность введения телефона в ajax_post_get.js function testOnPhoneExpand(elemInput)
                    //                            if(this.name == 'phone'){
                    //                                var phoneField = $(this);
                    //                                newPhoneContactSubmit = testOnPhoneExpand(phoneField);
                    //                            }
                    //                            if (this.name == 'email') {
                    //                                $(this).parent().find('[class~=alertDelete]').remove();
                    //                                if ($(this).val().length == 0) {
                    //                                    console.log('email клиента не задан');
                    //                                    newEmailContactSubmit = true;
                    //                                }
                    //                                else {
                    //                                    var inputEmail = $(this);
                    //                                    newEmailContactSubmit = testOnEmailExpand(inputEmail);
                    //                                }
                    //                            }
                    //                        });

                    //обязательные поля для заполнения название клиента, телефон
                    $('form').submit(function () {
                        var elemInputNameUser = $(this).find($('#idNameContact'));
//                            var newNameContactSubmit = checkNotEmtyAndLengthTrue(elemInputNameContact , 3, 200);
//                            console.log("newNameContactSubmit = "+ newNameContactSubmit);
                        var elemInputLogin = $(this).find('[name = "login"]');
//                            var newPhoneContactSubmit = testOnPhoneExpand(elemInputPhoneContact);
//                            console.log("elemInputPhoneContact "+ newPhoneContactSubmit);
                      var elemInputPassword = $(this).find('[name = "password"]');
//                            var newPhoneContactSubmit = testOnPhoneExpand(elemInputPassword);
                            console.log("elemInputPhoneContact "+ newPhoneContactSubmit);
                        var elemInputEmailContact = $(this).find('[name ="gmail"]');
//                            var newEmailContactSubmit = ($(elemInputEmailContact).val()=='' ||  testOnEmailExpand( elemInputEmailContact) );
//                            console.log("newEmailContactSubmit =" + newEmailContactSubmit);
//                            console.log("$(elemInputEmailContact).val()=='' =" + $(elemInputEmailContact).val()=='');
                        if(checkNotEmtyAndLengthTrue(elemInputNameUser , 5, 150)
                                &&checkNotEmtyAndLengthTrue(elemInputLogin , 5, 50)
                                &&checkNotEmtyAndLengthTrue(elemInputPassword , 5, 20)
                            && testOnPhoneExpand(elemInputPhoneContact)
                            && ($(elemInputEmailContact).val()=='' || testOnEmailExpand(elemInputEmailContact)  )
                        ){
                            //newNameContactSubmit = newPhoneContactSubmit = newEmailContactSubmit = false;
                            console.log(' variable checked');
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
//                                        вернемся на показ всех контактов
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

