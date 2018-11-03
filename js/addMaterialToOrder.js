/**
 * Created by marevo on 10.08.2017.
 */




//
// //подключение строки поиска через js по таблицу
// $(document).ready(function() {
//
//     //подключение плагина для поиска через javaScript по таблице всех материалов из базы подтянутых в таблицу #modalAddMaterialToOrder
//     $(function include(url) {
//         var script = document.createElement('script');
//         script.src = "js/jsSortSearchTable.js";
//         // script.src = url;
//         document.getElementsByTagName('head')[0].appendChild(script);
//         // alert('проверь');
//         console.log("Загружен файл1 js/jsSortSearchTable.js для поиска по таблице всех материалов в базе через javaScript js/checkInput.js");
//     });
//
//     $(function include2(url) {
//         var script = document.createElement('script');
//         script.src = "js/jsForTable2.js";
//         // script.src = url;
//         document.getElementsByTagName('head')[0].appendChild(script);
//         // alert('проверь');
//         console.log("Загружен файл2 js/jsForTable2.js для поиска по таблице всех материалов в базе через javaScript js/checkInput.js");
//     });
//
//     // $('table').DataTable({
//     //     scrollY: '50vh',
//     //     scrollCollapse: true,
//     //     paging: false
//     // });
// });

//при показе модального окна для добавки мы запросим данные о всех материалах что есть в базе и выведем их
$('#modalAddMaterialToOrder').on('show.bs.modal',function () {
    // перед показом #modalAddMaterialToOrder закрываем окно #modalViewAllMaterialsToThisOrder показа всех материалов к заказу
    $('#modalViewAllMaterialsToThisOrder').modal('hide');
    //сначала очистим таблицу всех материалов которые были отображены, а только потом выховем функцию подтягивающую все материалы из базы клиенту
    //иначе не будут правильно работать поиск среди всех материалов в модальном окне
    $('.tableFildMaterialToAddToOrder').html('<table id="tableFildMaterialToAddToOrder"></table>');
    //*** вызвать функцию ниже
    getAllMaterialsFromBase();
    //повесим фунцию показа усеха не успеха обращений на сервер (запросы на изменение)
    herePokazRezZapros($('#rezShowFormAddMaterialToOrder'));
    $('[name = "buttonSearchNameMaterial"]').on('click',serchAllMaterialsForName);
    $('#tbSearchMaterialOnName').on('input',function () {
        var target = event.target;
        console.log('в input ---'+target.nodeName);
        //проверка введения валидного значения в поле input количества материала
        if(target.nodeName == 'INPUT'){
            elementsCssAfterTestInputDigit(target);
            return false;
        }
    });
});
//запрос всех материалов и з базы
function getAllMaterialsFromBase() {
    jquery_send('#tableFildMaterialToAddToOrder','post','../controllerOneOrder.php',
    ['getAllMaterialsFromBase','idOrder'],
    ['', ORDER.id]    
    );
}
//найти материалы по названию (по подобию в названии) и вывести их в #tbSearchMaterialOnName
function serchAllMaterialsForName() {
    var nameMater = $.trim($('#idInputNameMaterial').val());
    if(nameMater != ""){
        //если есть не пусто в поиске то пошлем запрос на поиск материалов по названию и выведем результаты в эту же таблицу
        // где раньше были все материалы в базе но в тег tbody #tableFildMaterialToAddToOrder tbody
        console.log('посылаем вызов в базу с nameMater:'+nameMater);
        jquery_send('#tableFildMaterialToAddToOrder tbody','post','../controllerOneOrder.php',
            ['searchMaterialsForName','nameMaterialLike'],['',nameMater]
        );
    }
    return false;
}

//двойной клик на таблице всех материалов в базе что будут показаны в #tableFildMaterialToAddToOrder
//для работы через комп, для работы через планшет будем использовать click или tup
/*
$('#tableFildMaterialToAddToOrder').on('dblclick',function (event) {
    var target = event.target;
   console.log('двойной клик в таблице в строке');
    //найдем строку в которой был двойной клик
    while (target.nodeName != 'TBODY'){
        if(target.nodeName == 'TR'){
            console.log('поймали двойной клик в строке с id материала '+$(target).children()[0].textContent);
            var idMaterToAddForOrder = $(target).children()[0].textContent;
            var nameMaterToAddForOrder = $(target).children()[1].textContent;
            $('#modalAddMaterialToOrderFastIdMat').text(idMaterToAddForOrder);
            $('#modalAddMaterialToOrderFastNameMat').text(nameMaterToAddForOrder);
            $('#modalAddMaterialToOrderFast').modal('show');
        }
        target = target.parentNode;
    }

    return false;
});
*/
//клик на таблице всех материалов в базе что будут показаны в #tableFildMaterialToAddToOrder
//для работы через комп, для работы через планшет будем использовать click или tup
$('#tableFildMaterialToAddToOrder').on('click',function (event) {
    var target = event.target;
   console.log('двойной/одинарный клик в таблице в строке');
    //найдем строку в которой был клик
    while (target && target.nodeName != 'TBODY'){
        if(target.nodeName == 'TR' && target.parentNode.nodeName == 'TBODY'){
            console.log('поймали двойной/одинарный клик в строке с id материала '+$(target).children()[0].textContent);
            var idMaterToAddForOrder = $(target).children()[0].textContent;
            var nameMaterToAddForOrder = $(target).children()[1].textContent;
            $('#modalAddMaterialToOrderFastIdMat').text(idMaterToAddForOrder);
            $('#modalAddMaterialToOrderFastNameMat').text(nameMaterToAddForOrder);
            $('#modalAddMaterialToOrderFast').modal('show');
        }
        target = target.parentNode;
    }
    return false;
});