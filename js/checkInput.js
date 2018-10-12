/**
 * Created by marevo on 17.06.2018.
 */

// проверка поля на пустоту и наличие хотя бы 3 символов
function checkNotEmtyAndLengthTrue(elemInput, minChars, maxChars) {
    // убрали ранее введенные предупреждения
    $(elemInput).parent().find('.alertDelete').remove();
    if($(elemInput).val()==''){
        $(elemInput).before('<div class="alertDelete backgroundAlertRed">поле обязательно для заполнения</div>');
//                                $(this).parent().addClass('alert');
        return false;
    }
    // убрали пробелы по краям
    $(elemInput).val($.trim($(elemInput).val()));

    if($(elemInput).val().length < minChars){
        $(elemInput).before('<div class="alertDelete backgroundAlertRed">обязательно не менее ' + minChars + ' символов</div>');
        return false;
    }
    if($(elemInput).val().length > maxChars) {
        elemInput.value = elemInput.value.substr(0, 200);
        console.log('обрезали длину названия и описания контакта до 200 символов');
    }
return true
}
