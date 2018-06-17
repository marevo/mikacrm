<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 01.09.2017
 * Time: 14:12
 */
require_once ('../../autoload.php');
\App\FastViewTable::showAnswerServer('загрузим форму для добаления нового контакта');
?>

    <div class="row">
        <!--<div class="col-lg-2 backForDiv">
            этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
        </div>-->
        <div class="col-lg-12 backForDiv">
            <!--строка показа времени и показа результата добавки материала в базу  -->
            <?php
            include_once '../html/forDisplayTimeShowAnswerServer.html' ;
            ?>
            <div class="row">
                <div class="col-lg-12   col-md-12 col-sm-12 col-xs-12 bg-primary  h2 text-center text-info">создание нового контакта</div>
            </div>
            <div class="row"><!--форма добавки контакта в базу -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pading0">
                    <form  id="formOneContact"   method="post" action="../App/controllers/controllerOneContact.php" >
                        <table>
                            <thead><tr class="trDisplayNone">
                                <td>название поля</td>
                                <td>значение поля</td></tr></thead>
                            <tbody>
<!--невидимый маркер для отслеживания запроса добавки нового контакта в базу -->
                            <tr class="trDisplayNone">
                                <td class="text-right">скрытое поле  для отправки маркера</td>
                                <td class="text-left"><input  name="insertContactToBase"  value="sendMarkerToaddNewContactToBase"/></td>
                            </tr>
                            <tr><td class="text-right"><label for="nameContact">название контакта</label></td>
                                <td class="text-left"><input maxlength="200" size="55" name="nameContact" id="idNameContact" placeholder="Иванов Иван Иванович чп Иванов Чернигов (max 200 символов)" required /></td>
                            </tr>
<!--                            <tr><td class="text-right"><label for="contactPerson">контактное лицо фио</label></td>-->
<!--                                <td class="text-left"><input maxlength="100" size="55"  name="contactPerson" placeholder="Иванов Иван Иванович"  /></td>-->
<!--                            </tr>-->
                            <tr><td class="text-right"><label for="phone">телефон</label></td>
                                <td><input type="tel" name="phone" placeholder="телефон"  pattern="\d{5,10}" title="формат телефона от 5 до 10 цифр !"/></td></tr>
                            <tr><td class="text-right"><label for="email">email</label></td>
                                <td><input type="email" name="email"   placeholder="ivan@ivan.ua" title="формат email ivan@ivan.ua или ivan@ivan.ua.com"/></td>
                            </tr>

                            <tr><td class="text-right"></td><td><input type="submit"  name="submitFromFormOneContact"/></td>
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
                        $('#idNameContact').on('blur', function (event) {
                            var elemInput = $(this);
                            //запустим функцию проверки на пустоту и на min max количество символов в поле input #idNameContact
                            checkEmtyAndLength(elemInput, 3, 200);
                        });
//                        $('#idNameContact').on('blur',function () {
//                            $(this).parent().find('.alertDelete').remove();
//                            if($(this).val()==''){
//                                $(this).before('<div class="alertDelete backgroundAlertRed">поле обязательно для заполнения</div>');
////                                $(this).parent().addClass('alert');
//                                return false;
//                            }
//                            if($(this).val().length < 3){
//                                $(this).before('<div class="alertDelete backgroundAlertRed">не менее трех символов</div>');
//                                return false;
//                            }
//                            $(this).val($.trim($(this).val()));
//                            console.log('убрали пробелы');
//                            if(this.name == 'nameContact'){
//                                if($(this).val().length > 200 ) {
//                                    var elem = $(this);
//                                    elem.value = elem.value.substr(0, 200);
//                                    console.log('обрезали длину названия и описания контакта до 200 символов');
//                                }
//                            }
//                            return false;
//                        });
                        //обработка полей телефона и имейла
                        $('form input').on('blur',function (event) {
                            //проверка на валидность введения телефона в ajax_post_get.js function testOnPhoneExpand(elemInput)
                            if(this.name == 'phone'){
                                var phoneField = $(this);
                                testOnPhoneExpand(phoneField);
                            }
                            if(this.name == 'email' && $(this).val().length>0){
                                console.log('заносили данные в полe email');
                                var inputEmailValue = $(this).val();
                                if(testOnEmail(inputEmailValue) == false){
                                    $(this).parent().find('[class~=alertDelete]').remove();
                                    $(this).before('<div class="alertDelete backgroundAlertRed">не правильный формат email - исправьте</div>');
                                }else {
//                                 $(this).prev().remove();
                                    $(this).parent().find('[class~=alertDelete]').remove();
                                }
                            }
                        });
                        //обязательные поля для заполнения название клиента, телефон, адрес
                        $('form').submit(function () {
                            if ($(this).find('[name=nameContact]').val() == "" || $(this).find('[name=nameContact]').prev().hasClass('alert alert-info') ) {
                                $(this).find('[name=nameContact]').prev().remove();
                                $(this).find('[name=nameContact]').before('<div class="alert alert-info">имя контакта обязательно!</div>');
                                return false;
                            }
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
                                    //вернемся на показ всех контактов
                                    location.reload();
                                }
                            });
                            $(this).find('.alert').remove();
                            return false;
                        });
                    </script>
                </div>
            </div><!-- .row -->
        </div>
    </div><!-- .row -->

