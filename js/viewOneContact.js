/**
 * Created by marevo on 07.06.2018.
 */

$(function () {
    $('#btnUpdateShow').on('click',function () {
        location.reload();
    });
    $('#btnEnableUpdate').on('click',function () {
        $('.tdDisplayNone').each(function () {
            $(this).css('display',function (i,value) {
                if(value == 'block')
                    return 'none';
                else return 'block';
            });
        });
    });
    //ORDER.newValue = $('#forClearNameClient option:checked').val();
    //при выборе не нулевого селекта надо показать кнопку для заполнения полей телефона, email
    $('[name=selectIdClient]').on("change", function (event) {
        var tarSelect = event.target;
        var tarSelectValue = $(tarSelect).val();
        if(tarSelectValue > 0){
            $('#btnForSelect').css('visibility','visible');
            return false
        }
        else 
            $('#btnForSelect').css('visibility','hidden');
        return false
    });
    $('#btnForSelect').on('click',function () {
       jquery_send( '#rezShow','post','/App/controllers/controllerOneContact.php',
       ['getClientForOneContact', 'valueClient'],['',$('[name=selectIdClient]').val()] );
        return false;
    });
});

$('form').submit(function () {
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),//ссылка куда идут данные,
        data: $(this).serializeArray(),//сериализирует в виде массива
        success: function ( data) {
//                                     fUspehAll('удачно');
            $('.divForAnswerServer').html(data);
//                                     return false;
//                                    $(this).find('.alert').remove();
//                    alert('улетели данные ' + $(this).serializeArray());
            console.log($(this).serializeArray());
        }
    });
    $(this).find('.alert').remove();
    return false;
});

