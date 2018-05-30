/**
 * Created by marevo on 30.08.2017.
 */
//можно сюда перенести js код из viewAllMaterials.php
$(function () {
    //функция обработки клика на таблице будем обрабатыать только ячейки с наличием data-id то есть где можно удалить материал
    $('#tbViewAllMaterials').on('click',function (event) {
        var target = event.target;
        while (target.tagName != 'TABLE'){
            if(target.tagName == 'TD'){
                //нашли ячейку где был клик
                if($(target).data('id')){
                    console.log('id for delete '+$(target).data('id'));
                    //вызовем модальное окно для удаления ненужного материала
                    $('#modalIdMaterial').text( $(target).data('id') );
                    $('#modalNameMaterial').text( $(target).siblings()[1].textContent );
                    $('#modalWinForDeleteMat').modal('show');
                }
            }
            if(target.closest('a')){
                console.log('хотим перейти на просмотр одного материала');
                if(target.nodeName == 'SPAN')
                    target = target.parentNode;
                var tarHref = $(target).attr('href');
                console.log('tarHref=' + tarHref);
                var idOneMaterial = $(target).data('id');
                console.log('idMaterialForView=' + idOneMaterial);
                includeViewOneMaterial(tarHref,idOneMaterial);
                return false;
                // if($(target).find('a').)
            }
            target = target.parentNode;
        }
        console.log('click по таблице');
    });
    //функция обработки клика в модальном окне будем обрабатывать только кнопку
    $('#modalWinForDeleteMat').on('click',function (event) {
        var target = event.target;
        if(target.name == 'btnDeleteMaterial'){
            console.log('кликнули кнопку на удаление заказа');
            //будем удалять материал из базы
            jquery_send('.divForAnswerServer','post','App/controllers/controllerViewAllMaterials.php',
                ['deleteMaterialFromBase','idMaterial'],['',$('#modalIdMaterial').text()]);
            $('#modalIdMaterial').text('');
            $('#modalNameMaterial').text( '');
            $('#modalWinForDeleteMat').modal('hide');

        }
    });
    //функция обработки при вызове модального окна
    $('#modalWinForDeleteMat').on('show.bs.modal',function () {

    });
    //функция поиска материала по подобию названия или доп. характеристик
    $('#btnSearchMaterialLikeNameORLikeAddCharacteristic').on('click',function () {
        console.log('нажали кнопку поиска материалы по подобию названию или добхарактеристик');
        var inputSearchValue = $('#inputFindMaterial').val();
        if(inputSearchValue.length < 3 || inputSearchValue.length == 0){
            $('#inputFindMaterial').val('').attr('placeholder','минимум 3 символа');
        }else {
            console.log('отправим запрос на поиск');
            jquery_send('#tbViewAllMaterials tbody','post','App/controllers/controllerViewAllMaterials.php',['searchLike','likeValue'],['',inputSearchValue]);
        }
    });

});
//функция для создания нового материала
$('#makeNewMaterial').on('click',includeFormAddNewMaterial);
function includeFormAddNewMaterial() {
    jquery_send('#main_modul','post','/App/controllers/controllerViewAllMaterials.php',['includeFormNewMaterial'],['']);
    //event.stopPropagation();
    //                            document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
    return false;
}
//функция загрузки данных одного материала в окошко '#main_modul'
//функция подтяжки в id='#main_modul' viewOneMaterial.php с заданным id
function includeViewOneMaterial(tarHref,idOneMaterial) {
    jquery_send('#main_modul','post','../App/controllers/controllerViewAllMaterials.php',
        ['includeViewOneMaterial','tarHref','id'],
        ['',tarHref, idOneMaterial]);

}