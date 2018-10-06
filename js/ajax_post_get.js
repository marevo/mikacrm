//################################################# ФОРМИРОВАНИЕ И ОТПРАВКА jQuery
//!!!ПРИ ИСПОЛЬЗОВАНИИ ПОДКЛЮЧИТЕ jQuery!!!
//!!!ВЫЗОВ - jquery_send(elemm, 'post', 'function.php', ['param'], [param.value])
var req;
var elem    //!!! - ГЛОБАЛЬНАЯ (т.к. для post_send(get_send) и func_response) elem - ЭЛЕМЕНТ ДЛЯ ВЫВОДА
//################################################# ФОРМИРОВАНИЕ И ОТПРАВКА POST

/**
 * @elemm куда вернуть результат запроса
 * @method тип запроса post or get
 * @program файл который бедет обрабатывать запрос
 * @param_arr массив названий переменных
 * @value_arr массив значений переменных
 *  */
function jquery_send(elemm, method, program, param_arr, value_arr) {
    var str='';                                                                //!!! - начальный str=''
    for(var i=0; i<param_arr.length; i++) {                                    //!!! - массивы - перебор
        str+= param_arr[i]+'='+ encodeURIComponent(value_arr[i])+'&';             //!!! - накапливаем str
    }
    $.ajax(
        {
            type: method,
            url: program,
            data: str,
            success: function(data){
                $(elemm).html(data);
            } //!!! - ВЫВОД В ЭЛЕМЕНТ ТУТ - function(data){$('elemm').html(data);
        }
    );
}
//проверка подключен ли файл для работы с отправкой данных на сервер
//console.log('подключен ajax_post_get.js');
//**   функция отображения где мы находимсч в заголовке (просто выделяет в меню ли только то что равно переданному аргументу
function showLi() {
    if(arguments.length>0){
        var ar = arguments[0];
        $('#navbarCollapse li').each(function () {
            if($(this).find('a').text() == ar)
                $(this).addClass('active');
            else $(this).removeClass('active');
        });
    }
}
$('table').each(function () {
    // $(this).on('click',findTd );
});
// функция выделения строки таблицы по клику на ней
//divId хранит id записи в выделенной строке( в кликнутой строке)
function findTd() {
    var target = event.target;//где был клик
    if(target.tagName != 'TD' || target.closest('THEAD')) return;//клик в неинтересном месте для нас
    //уберем подсветку во всей таблице кроме той строки в которой есть клик на ячейке
    // $("table td[class ~= 'highLightTd']").removeClass('highLightTd');
    //подсветим ячейку где был клик и братьев ее, то есть выделим строку где был клик
    // $(target).addClass('highLightTd').siblings().addClass('highLightTd');

    // $("table tr[class ~= 'highLightTd']").removeClass('highLightTd');
    //выделение строкт и дать бекграунд
    // $(target).parent().addClass('highLightTd');
}

//показ материалов по заказу при клике на строке в таблице заказа
//*фукция взятия текущей даты для вывода на любой странице
function getDate() {
    var d = new Date();
    var day = function () {
        if( d.getDate()<10)
            return '0'+d.getDate();
        else
            return d.getDate();
    }();
    var month = function () {
        if((d.getMonth() + 1 )<10)
            return '0'+( d.getMonth()+1);
        else return d.getMonth()+1;
    }() ;
    var year = d.getFullYear();
    var date = year + "-" + month + "-" + day;
    return date;
}
//*/фукция взятия текущей даты для вывода на любой странице
function datePlusDays(days) {
    var d = new Date();
    var day = function () {
        var dNow = d.getDate();
        var dFuture = dNow + days;
        if( dFuture <10)
            return '0'+ dFuture;
        else
            return dFuture;
    }();
    var month = function () {
        if((d.getMonth()  )<10)
            return '0'+( d.getMonth());
        else return d.getMonth();
    }() ;
    var year = d.getFullYear();
    var dateFuture = new Date( year,  month, day);
    dFuture = dateFuture.getDate();
    if(dFuture < 10 )
        dFuture = '0'+ dFuture;
    var mFuture = dateFuture.getMonth()+1;
    if(mFuture < 10 )
        mFuture = '0'+ mFuture;

    return (dateFuture.getFullYear() + "-" + mFuture + "-" + dFuture);
}
//*функция проверки ввода  денежных сумм
function testSumOnFloat(sum){
    var regExp1 =/(^\d{1,5})((\.{0,1}\d{1,2}){0,1})$/;
    return regExp1.test(sum);
}
//*/функция проверки ввода  денежных сумм
//*функция отображения проверки поля на валидность ( можно ввоодить только вида  ггггггг.кк тоесть гривны точка копейки)
function rezChangeSumShow(elemm) {
    if( testSumOnFloat($(elemm).val()) == true){
        // Console.log('testSumOnFloat '+ testSumOnFloat($(elemm).val()));
        $(elemm).removeClass('orderNoSuccessCell').addClass('orderSuccessCell')
    }
    else {
        $(elemm).removeClass('orderSuccessCell').addClass('orderNoSuccessCell')
    }
}
//*/функция отображения проверки поля на валидность ( можно ввоодить только вида  ггггггг.кк)
//*функция повесит на элемент отображения валидации денежного поля
function povesitProverkuValidnostyNaInput(elem) {
    $(elem).on('input',function () {
        rezChangeSumShow($(this));
    });
}
//*/функция повесит на элемент отображения валидации денежного поля
//*функция тестирует на формат d || d.dd // d.d
function testInputDigit(sum) {
    var regExp2 =/(^\d{1,3})((\.{0,1}\d{1,2}){0,1})$/;
    return regExp2.test(sum);
}

//*  отображение в поле ввода input через цвет проверки на валидность input в диапазоне 100 - 10000.00
function elementsCssAfterTestInputDigit (elem) {
    var count = $(elem).val();
    if(testInputDigit(count) == true){
        $(elem).css('backgroundColor','#add8bc');
    }
    else{
        $(elem).css('backgroundColor','#d8adbc');
    }
}
//*функция повесит на нужный элемент показ результатов обращения к серверу div сможет показывать с изменением цвета "успешно"-"неуспешно - обратитесь к разработчику"
function herePokazRezZapros(elem) {
    elem.html('<div class=" uspeh text-center ">' +
        '<span class="glyphicon glyphicon-import "> успешно</span></div>' +
        '<div class=" noUspeh text-center "><span class="glyphicon glyphicon-alert "> ошибка обратитесь к разработчику</span></div>');
}
//*/функция повесит на нужный элемент показ результатов обращения к серверу


//*функция подсветки на определенное время некоторого елемента target через (beginShow) млсек и продолжительность подсветки( endShow ) элемента target
function promptShow(beginShow,endShow,target) {
    //случай когда стоит запрет на добавку материала
    if(ORDER.isAllowCalculateCost  == 0){
        setTimeout(function () {
            $(target).addClass('backgroundAlertRed');
            setTimeout(function () {
                $(target).removeClass('backgroundAlertRed');
            },endShow);
        },beginShow);
    }
}
//*/viewOneOrder.php
//*функции отображения на клиенте результатов запроса на сервер можно использовать во всех файлах проекта надо чтобы был div .divForAnswerServer элемент для отображения
function fUspehAll() {
    if(arguments.length > 0)
        var textToShow = arguments[0];
    else var textToShow = "успешно :)";
    $('.uspeh').show('1500').text(textToShow);
    var uspehShow = setTimeout(fUspehHideAll,2000);
    function fUspehHideAll() {
        $('.uspeh').hide('3000').text('');
        clearTimeout('uspehShow');
    }
}
function fNoUspehAll() {
    if(arguments.length > 0)
        var textToShow = arguments[0];
    else var textToShow = "не успешно :(";
    $('.noUspeh').show('1500').text(textToShow);
    var alrRmv = setTimeout(fNoUspehHideAll,2000);
    function fNoUspehHideAll() {
        $('.noUspeh').hide('3000').text('');
        clearTimeout('alrRmv');
    }
}
//*/функции отображения на клиенте сообщений сервера в #answerServer
/**ShowAnswerServer
 * показ в ul пяти последних сообщений сервера
 * передавать надо 1 сообщение в функцию
 * @param str в качестве аргумента передаем строку сообщение для показа на данной странице всего будет отображено 5 последних сообщений
 */
function ShowAnswerServer(str) {
    if(arguments.length > 0){
        var strAppendLi = arguments[0];
        var countLi = $('#answerServer li').length;
        if(countLi >4 ){
            //уже есть 5 li в ul
            $('#answerServer li').eq(0).remove();
        }
        $('#answerServer').append("<li>"+strAppendLi+"</li>");
    }
}
//*/функции отображения на клиенте сообщений сервера в #answerServer
/*функция вешает  на elem обработчик ограничения количества limitCount символов в поле textarea*/
function limitTextInTextArea(elem,limitCount ) {
    elem.keyup(function() {
        if (elem.value.length > limitCount)
            elem.value = elem.value.substr(0, limitCount);
        else 
            elem.value = elem.value.trim();
    });

}
//*/функция ограничения количества символов в поле textarea*/

//функция проверки на валидность номера телефона
function testOnPhone(phone) {
    // var regExpPhone =/\(+38\)?\d{5,13}/;
    // var regExpPhone =/^\d(\d{3,8})\d$/g;
    var regExpPhone =/^\d(\d{3,8})\d$/;
    // var regExpPhone =/[0-9]{5,13}/;
    // var regExpPhone =/^(s*)?(\+)?([-_():=+]?\d[-_():=+]?){10,14}(\s*)?$/;
    return regExpPhone.test(phone);
}

//расширенная функция для проверки валидности телефона и если валидность не пройдена то вылезет подсказка
function testOnPhoneExpand(elemInputPhone){
    $(elemInputPhone).parent().find('[class~=alertDelete]').remove();
    var inputPhoneValue =$(elemInputPhone).val();
    if(testOnPhone(inputPhoneValue) == false){
        $(elemInputPhone).parent().find('[class~=alertDelete]').remove();
        $(elemInputPhone).before('<div class="alertDelete backgroundAlertRed">формат номера от 5 до 10 цифр</div>');
        return false;
    }else {
        //                                   $(this).prev().remove();
        $(elemInputPhone).parent().find('[class~=alertDelete]').remove();
        return true;
    }
}
function testOnEmail(email){
    // var regExpEmail =/^([\w\._]+)@\1\.([a-z]{2,6}\.?)$/;
    // var regExpEmail =/^(((\w+).)?(\w+))@(\w+)(\.\w+)+$/
    var regExpEmail =/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/;
    return regExpEmail.test(email);
}
//расширенная функция для проверки валидности email если валидность не пройдена, то вылезет подсказка
function testOnEmailExpand(elemInputEmail){
    $(elemInputEmail).parent().find('[class~=alertDelete]').remove();
    var inputEmailValue =$(elemInputEmail).val();
    if(testOnEmail(inputEmailValue) == false){
        $(elemInputEmail).parent().find('[class~=alertDelete]').remove();
        $(elemInputEmail).before('<div class="alertDelete backgroundAlertRed">что-то типа name@domen.ua</div>');
    } else {
        //                                   $(this).prev().remove();
        $(elemInputEmail).parent().find('[class~=alertDelete]').remove();
    }
}
//на загрузку document повесим вызов времени с сервера
//определим переменную которая будет содержать время сервера
var dateFromServer ='';
var countTimeOnThisPage = 0 ;
var coutnReqGetTimeFromServer = 0;
// var $elemForDislayTimeFromServer = $('.nav.navbar-nav li:last-child a');
var $elemForDislayTimeFromServer = $('.forDisplayTime ');
var intervalForClear;
// function getTimeFromServer() {
//     $.ajax({
//         type: 'post',
//         url: '/timeZone.php',
//         data: 'getTimeServer',
//         success: function(data){
//             coutnReqGetTimeFromServer++;
//             // console.log('вызов № '+coutnReqGetTimeFromServer);
//             // console.log('getTimeFromServer()='+data);
//             dateFromServer = data;
//             $elemForDislayTimeFromServer.html(dateFromServer);
//         }
//     });
// };
function showInDomElement(elem) {
    return function () {
        //заполним новым значением  даты сервера переменную dateFromServer
        getTimeFromServer();
        $(elem).text(''+dateFromServer+'');
        $('#rezShow').text('вы на сайте '+ ++countTimeOnThisPage + ' минут');
        // console.log(' вы сидите на этой странице уже '+ countTimeOnThisPage++ +' sec');
        clearInterval(intervalForClear);
    }
}
/**
 * функция запроса времени с сервера пока не запущена чтобы запустить надо обрамить ее в "$();"
 */
// $(function getTimeFromServer() {
//     $.ajax({
//         type: 'post',
//         url: '/timeZone.php',
//         data: 'getTimeServer',
//         success: function(data){
//             coutnReqGetTimeFromServer++;
//             // console.log('вызов № '+coutnReqGetTimeFromServer);
//             // console.log('getTimeFromServer()='+data);
//             dateFromServer = data;
//             $($elemForDislayTimeFromServer).html(dateFromServer);
//         }
//     });
//     //запросим даныые о времени через ajax и запишем их в dateFromServer
//     // getTimeFromServer();
//     //отобразим dateFromServer на элементе $elemForDislayTimeFromServer
//     $($elemForDislayTimeFromServer).html(dateFromServer);
//     //запустим это функцию запроса времени и отображения на элементе раз в минуту
//     intervalForClear = setInterval(showInDomElement($elemForDislayTimeFromServer),1000*60);
// });
//подключение файла js/checkInput.js к этому файлу
$(function include(url) {
    var script = document.createElement('script');
    script.src = "js/checkInput.js";
    // script.src = url;
    document.getElementsByTagName('head')[0].appendChild(script);
    // alert('проверь');
            console.log("Загружен файл js/checkInput.js");
});
// include();
//     $.getScript("js/checkInput.js", function(){
//         alert('проверь');
//         console.log("Загружено.");
// //используем скрипт здесь
//     });




//на загрузку document повесим вызов времени с сервера
// $(function () {
//     (function () {
//         $.ajax({
//             type: 'post',
//             url: '/timeZone.php',
//             data: 'getTimeServer',
//             success: function(data){
//                 $('.nav.navbar-nav li:last-child a').html(data);
//             }
//         });
//     })();
//     setInterval(function () {
//         $.ajax({
//             type: 'post',
//             url: '/timeZone.php',
//             data: 'getTimeServer',
//             success: function(data){
//                 $('.nav.navbar-nav li:last-child a').html(data);
//             }
//         })
//     }, 1000*60);
//
// });

//функция растягивания форм на всю ширину родительского div через добавление css правила $('form').parent().css('padding',0);
// $('form').parent().css('padding',0);

    //функция для растягивания форм просмотра/правки на всю ширину родительского div
// пока не работает !исправить
   /*
    $(document).ready(function () {
        $('form').parent().css('padding',0);
    });
*/


