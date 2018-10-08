/**
 * Created by marevo on 20.05.2018.
 */
$(function () {
    //функция обработки клика на таблице будем обрабатыать только ячейки с наличием data-id то есть где можно удалить поставщика
    $('#tbViewAllUsers').on('click',function (event) {
        var target = event.target;
            while (target.tagName != 'TABLE'){
            if(target.tagName == 'TD'){
                //нашли ячейку где был клик
                if($(target).data('id_user')){
                    console.log('id for delete '+$(target).data('id_user'));
                    //вызовем модальное окно для удаления ненужного материала
                    $('#modalIdUser').text( $(target).data('id_user') );
                    $('#modalNameUser').text( $(target).siblings()[1].textContent );
                    $('#modalWinForDeleteUser').modal('show');
                }
            }
            if(target.closest('a')){
                console.log('хотим перейти на просмотр одного пользователя');
                if(target.nodeName == 'SPAN')
                    target = target.parentNode;
                var tarHref = $(target).attr('href');
                console.log('tarHref=' + tarHref);
                var idOneUser = $(target).data('id_supplier');
                console.log('idSupplierForView=' + idOneUser);
                includeViewOneUser(tarHref,idOneUser);
                return false;
                // if($(target).find('a').)
            }
            target = target.parentNode;
        }
        console.log('click по таблице');
    });
    //функция обработки клика в модальном окне будем обрабатывать только кнопку
    $('#modalWinForDeleteUser').on('click',function (event) {
        var target = event.target;
        if(target.name == 'btnDeleteUser'){
            console.log('кликнули кнопку на удаление пользователя');
            //будем удалять поставщика из базы
            jquery_send('.divForAnswerServer','post','../App/controllers/controllerViewAllUsers.php',
                ['deleteUserFromBase','idUser'],['',$('#modalIdUser').text()]);
            $('#modalIdUser').text('');
            $('#modalNameUser').text( '');
            $('#modalWinForDeleteUser').modal('hide');

        }
    });
    //функция обработки при вызове модального окна
    $('#modalWinForDeleteUser').on('show.bs.modal',function (event) {

    });
    //функция поиска пользователя по подобию названия или доп. характеристик
    $('#btnSearchAnyField').on('click',function () {
        console.log('нажали кнопку поиска поставщика по подобию названию или добхарактеристик');
        var inputSearchValue = $('#inputFindUser').val();
        if(inputSearchValue.length < 2 || inputSearchValue.length == 0){
            $('#inputFindUser').val('').attr('placeholder','минимум 2 символа');
        }else {
            console.log('отправим запрос на поиск');
            jquery_send('#tbViewAllUsers tbody','post','../App/controllers/controllerViewAllUsers.php',['searchLike','likeValue'],['',inputSearchValue]);
        }
    });

    //функция для создания нового поставщика 
    $('#makeNewUser').on('click',includeFormAddNewUser);
    function includeFormAddNewUser() {
        jquery_send('#main_modul','post','/controllers/controllerViewAllUsers.php',['includeFormNewUser'],['']);
        //event.stopPropagation();
        //                            document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
        return false;
    }

    //функция загрузки данных одного клиента в окошко '#main_modul'
    //функция подтяжки в id='#main_modul' viewOneSupplier.php с заданным id
    function includeViewOneUser(tarHref,idOneUser) {
        jquery_send('#main_modul','post','../App/controllers/controllerViewAllUsers.php',
            ['includeViewOneUser','tarHref','id'],
            ['',tarHref, idOneUser]);

    }

});
