/**
 * Created by marevo on 17.06.2018.
 */

// проверка поля на пустоту и наличие хотя бы 3 символов
function checkEmtyAndLength(elemInput,minChars, maxChars) {

    $(elemInput).parent().find('.alertDelete').remove();
    if($(elemInput).val()==''){
        $(elemInput).before('<div class="alertDelete backgroundAlertRed">поле обязательно для заполнения</div>');
//                                $(this).parent().addClass('alert');
        return false;
    }
    if($(elemInput).val().length < minChars){
        $(elemInput).before('<div class="alertDelete backgroundAlertRed">не менее трех символов</div>');
        return false;
    }
    $(elemInput).val($.trim($(this).val()));
    console.log('убрали пробелы');
    if($(elemInput).val().length > maxChars) {
        elemInput.value = elemInput.value.substr(0, 200);
        console.log('обрезали длину названия и описания контакта до 200 символов');
    }
return false;
}
