/**
 * Created by marevo on 03.06.2018.
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
