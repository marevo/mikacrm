/**
 * Created by marevo on 20.05.2018.
 */
$(function () {
    //функция обработки клика на таблице будем обрабатыать только ячейки с наличием data-id то есть где можно удалить поставщика
    $('#tbViewAllSuppliers').on('click',function (event) {
        var target = event.target;
        while (target.tagName != 'TABLE'){
            if(target.tagName == 'TD'){
                //нашли ячейку где был клик
                if($(target).data('id_supplier')){
                    console.log('id for delete '+$(target).data('id_supplier'));
                    //вызовем модальное окно для удаления ненужного материала
                    $('#modalIdSupplier').text( $(target).data('id_supplier') );
                    $('#modalNameSupplier').text( $(target).siblings()[1].textContent );
                    $('#modalWinForDeleteSupp').modal('show');
                }
            }
            if(target.closest('a')){
                console.log('хотим перейти на просмотр одного поставщика');
                if(target.nodeName == 'SPAN')
                    target = target.parentNode;
                var tarHref = $(target).attr('href');
                console.log('tarHref=' + tarHref);
                var idOneSupplier = $(target).data('id_supplier');
                console.log('idSupplierForView=' + idOneSupplier);
                includeViewOneSupplier(tarHref,idOneSupplier);
                return false;
                // if($(target).find('a').)
            }
            target = target.parentNode;
        }
        console.log('click по таблице');
    });
    //функция обработки клика в модальном окне будем обрабатывать только кнопку
    $('#modalWinForDeleteSupp').on('click',function (event) {
        var target = event.target;
        if(target.name == 'btnDeleteSupplier'){
            console.log('кликнули кнопку на удаление поставщика');
            //будем удалять поставщика из базы
            jquery_send('.divForAnswerServer','post','../App/controllers/controllerViewAllSuppliers.php',
                ['deleteSupplierFromBase','idSupplier'],['',$('#modalIdSupplier').text()]);
            $('#modalIdSupplier').text('');
            $('#modalNameSupplier').text( '');
            $('#modalWinForDeleteSupp').modal('hide');

        }
    });
    //функция обработки при вызове модального окна
    $('#modalWinForDeleteSupp').on('show.bs.modal',function (event) {

    });
    //функция поиска поставщика по подобию названия или доп. характеристик
    $('#btnSearchMaterialLikeNameORLikeAddCharacteristic').on('click',function () {
        console.log('нажали кнопку поиска поставщика по подобию названию или добхарактеристик');
        var inputSearchValue = $('#inputFindMaterial').val();
        if(inputSearchValue.length < 3 || inputSearchValue.length == 0){
            $('#inputFindMaterial').val('').attr('placeholder','минимум 3 символа');
        }else {
            console.log('отправим запрос на поиск');
            jquery_send('#tbViewAllSuppliers tbody','post','../App/controllers/controllerViewAllSuppliers.php',['searchLike','likeValue'],['',inputSearchValue]);
        }
    });

    //функция для создания нового поставщика 
    $('#makeNewSupplier').on('click',includeFormAddNewSupplier);
    function includeFormAddNewSupplier() {
        jquery_send('#main_modul','post','/controllers/controllerViewAllSuppliers.php',['includeFormNewSupplier'],['']);
        //event.stopPropagation();
        //                            document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
        return false;
    }

    //функция загрузки данных одного клиента в окошко '#main_modul'
    //функция подтяжки в id='#main_modul' viewOneSupplier.php с заданным id
    function includeViewOneSupplier(tarHref,idOneSupplier) {
        jquery_send('#main_modul','post','../App/controllers/controllerViewAllSuppliers.php',
            ['includeViewOneSupplier','tarHref','id'],
            ['',tarHref, idOneSupplier]);

    }

});
