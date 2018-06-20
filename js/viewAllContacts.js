/**
 * Created by marevo on 06.06.2018.
 */
//можно сюда перенести js код из viewAllMaterials.php
$(function () {
    //функция обработки клика на таблице будем обрабатыать только ячейки с наличием data-id то есть где можно удалить контакт или просмотреть его
    $('#tbViewAllContacts').on('click',function (event) {
        var target = event.target;
        while (target.tagName != 'TABLE'){
            if(target.tagName == 'TD'){
                //нашли ячейку где был клик
                //обработка клика для удаления контакта
                if($(target).data('id')&& $(target).data('do')=='trash'){
                    console.log('idContact for delete '+$(target).data('id'));
                    //вызовем модальное окно для удаления ненужного материала
                    $('#modalIdContact').text( $(target).data('id') );
                    $('#modalNameContact').text( $(target).siblings()[0].textContent );
                    $('#modalWinForDeleteContact').modal('show');
                    //сохраним в localeStorage id удаленного контакта
                    localStorage.setItem('idContact-trashed', $(target).data('id') );
                    console.log('idContact-trashed= '+$(target).data('id'));
                    localStorage.setItem('idClient', $(target).siblings()[1].textContent ) ;
                    console.log('idClient= '+$(target).siblings()[1].textContent);
                    localStorage.setItem('phoneContact-trashed', $(target).siblings()[2].textContent ) ;
                    console.log('phoneContact-trashed= '+ $(target).siblings()[2].textContent);
                    localStorage.setItem('emailContact-trashed', $(target).siblings()[3].textContent ) ;
                    console.log('emailContact-trashed= '+ $(target).siblings()[3].textContent);
                  debugger;
                    var contactDeleted = {
                        'idContact': $(target).data('id'),
                        'nameContact':$(target).siblings()[0].textContent,
                        'idClient': $(target).siblings()[1].textContent,
                        'phoneContact' : $(target).siblings()[2].textContent,
                        'emailContact': $(target).siblings()[3].textContent
                    };
                    localStorage.setItem('objContactTrashed', JSON.stringify(contactDeleted) );
                    var restoredContactDeleted = JSON.parse(localStorage.getItem('objContactTrashed'));
                    console.log(restoredContactDeleted);
                    debugger;

                }
                //обработка клика для просмотра одного контакта
                if($(target).data('id')&& $(target).data('do') == 'view'){
                    console.log('хотим перейти на просмотр одного материала');
                    var idOneContact = $(target).data('id');
                    console.log('idContactForView=' + idOneContact);
                    includeViewOneContact(idOneContact);
                    return false;
                    // if($(target).find('a').)
                }
            }
            target = target.parentNode;
        }
        console.log('click по таблице');
    });
    //функция для создания нового контакта в базе
    $('#makeNewContactClient').on('click',includeFormAddNewContact);
    function includeFormAddNewContact() {
        jquery_send('#main_modul','post','../App/controllers/controllerViewAllContacts.php',['includeFormNewContact'],['']);
        //event.stopPropagation();
        //document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
        return false;
    }
    //кнопка для восстановления последнего удаленного контакта
    $('#restoreLastDeletedContact').on('click', restoreLastDeleteContactFunction );
    function restoreLastDeleteContactFunction() {
        var restoredContactDeletedToSend = JSON.parse(localStorage.getItem('objContactTrashed'));
        restoredContactDeletedToSend.restoreLastDeleteContact = 'restoreContactInBase';
        // debugger;
        // jquery_send('.divForAnswerServer','post',"../App/controllers/controllerViewAllContacts.php",
        //     ['restoredContactDeletedToSend','idContact','nameContact','idClient','phoneContact','emailContact'],
        //     ['', restoredContactDeletedToSend.idContact , restoredContactDeletedToSend.nameContact ,
        //         restoredContactDeletedToSend.idClient , restoredContactDeletedToSend.phoneContact , restoredContactDeletedToSend.emailContact]
        // );
        debugger;
        if(true){
            $.ajax({
                type: 'post',
                url: "../App/controllers/controllerViewAllContacts.php", //ссылка куда идут данные,
                data: 'restoredContactDeletedToSend',// маркер для сервера
                success: function (data) {
//                                     fUspehAll('удачно');
                    $('.divForAnswerServer').html(data);
//                                     return false;
                    $(this).find('.alert').remove();
//        alert('улетели данные ' + $(this).serializeArray());
//                 console.log($(this).serializeArray());

                    //var timerId = setTimeout(function() {location.reload(); clearTimeout(timerId); }, 1000);
                    // $(this).find('.alert').remove();
//                                        вернемся на показ всех контактов
//                 location.reload();
                    return false;
                }
            });
        }
    }
    
    //функция обработки клика в модальном окне будем обрабатывать только кнопку
    $('#modalWinForDeleteContact').on('click',function (event) {
        var target = event.target;
        if(target.name == 'btnDeleteContact'){
            console.log('кликнули кнопку на удаление контакта');
            //будем удалять материал из базы
            jquery_send('.divForAnswerServer','post','App/controllers/controllerViewAllContacts.php',
                ['deleteContactFromBase','idContact'],['', $('#modalIdContact').text()]);
            $('#modalIdContact').text('');
            $('#modalNameContact').text('');
            $('#modalWinForDeleteContact').modal('hide');

        }
    });
    //функция обработки при вызове модального окна
    $('#modalWinForDeleteContact').on('show.bs.modal',function () {

    });
    //функция поиска материала по подобию названия или доп. характеристик
    $('#btnSearchContactLikeNameORLikeAddCharacteristic').on('click',function () {
        console.log('нажали кнопку поиска материалы по подобию названию или добхарактеристик');
        var inputSearchValue = $('#inputFindContact').val();
        if(inputSearchValue.length < 3 || inputSearchValue.length == 0){
            $('#inputFindContact').val('').attr('placeholder','минимум 3 символа');
        }else {
            console.log('отправим запрос на поиск');
            jquery_send('#tbViewAllContacts tbody','post','App/controllers/controllerViewAllContacts.php',
                ['searchLike','likeValue'],['',inputSearchValue]);
        }
    });

});


//функция загрузки данных одного материала в окошко '#main_modul'
//функция подтяжки в id='#main_modul' viewOneMaterial.php с заданным id
function includeViewOneContact(idOneContact) {
    jquery_send('#main_modul','post','../App/controllers/controllerViewAllContacts.php',
        ['includeViewOneContact','idOneContact'],
        ['', idOneContact]
    );

}
