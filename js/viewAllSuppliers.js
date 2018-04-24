/**
 * Created by marevo on 23.04.2018.
 */

$(function () {
    //функция обработки клика на таблице будем обрабатыать только ячейки с наличием data-id то есть где можно удалить поставщика
    $('#tbViewAllSuppliers').on('click',function (event) {
        var target = event.target;
        while (target.tagName != 'TABLE'){
            if(target.tagName == 'TD'){
                //нашли ячейку где был клик
                if($(target).data('id')){
                    console.log('id for delete '+$(target).data('id'));
                    //вызовем модальное окно для удаления ненужного материала
                    $('#modalIdSupplier').text( $(target).data('id') );
                    $('#modalNameSupplier').text( $(target).siblings()[1].textContent );
                    $('#modalWinForDeleteSuppleir').modal('show');
                }
            }
            if(target.closest('a')){
                console.log('хотим перейти на просмотр одного поставщика');
                if(target.nodeName == 'SPAN')
                    target = target.parentNode;
                var tarHref = $(target).attr('href');
                console.log('tarHref=' + tarHref);
                var idOneOrder = $(target).data('id');
                console.log('idOrderForView=' + idOneOrder);
                includeViewOneClient(tarHref,idOneOrder);
                return false;
                // if($(target).find('a').)
            }
            target = target.parentNode;
        }
        console.log('click по таблице');


    });
    //функция обработки клика в модальном окне будем обрабатывать только кнопку
    $('#modalWinForDeleteClient').on('click',function (event) {
        var target = event.target;
        if(target.name == 'btnDeleteClient'){
            console.log('кликнули кнопку на удаление клиента');
            //будем удалять клиента из базы
            jquery_send('.divForAnswerServer','post','App/controllers/controllerViewAllClients.php',
                ['deleteClientFromBase','idClient'],['',$('#modalIdClient').text()]);
            $('#modalIdClient').text('');
            $('#modalNameClient').text( '');
            $('#modalWinForDeleteClient').modal('hide');

        }
    });
    //функция обработки при вызове модального окна
    $('#modalWinForDeleteClient').on('show.bs.modal',function () {

    });
    //функция поиска поставщика по подобию названия или доп. характеристик
    $('#btnSearchClientLikeNameORLikeContactPerson').on('click',function () {
        console.log('нажали кнопку поиска поставщика по подобию названию или добхарактеристик');
        var inputSearchValue = $('#inputFindClient').val();
        if(inputSearchValue.length < 3 || inputSearchValue.length == 0){
            $('#inputFindClient').val('').attr('placeholder','минимум 3 символа');
        }else {
            console.log('отправим запрос на поиск');
            jquery_send('#tbViewAllClients tbody','post','App/controllers/controllerViewAllClients.php',['searchLike','likeValue'],['',inputSearchValue]);
        }
    });

});

//функция загрузки данных одного клиента в окошко '#main_modul'
//функция подтяжки в id='#main_modul' viewOneClient.php с заданным id
function includeViewOneClient(tarHref,idOneClient) {
    jquery_send('#main_modul','post','../App/controllers/controllerViewAllClients.php',
        ['includeViewOneClient','tarHref','id'],
        ['',tarHref, idOneClient]);

}
