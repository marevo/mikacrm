<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 27.06.2018
 * Time: 21:37
 */
/**функция подтяжки блока заголовка
 * @param $strCaption название заголовка
 * @return string вернет html с вставленным назанием
 */
function rowSearch($strCaption) {
    return ('<div class="row rowSearch" ><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="inputFindContact" placeholder="по названию ..доп характеристикам"/>
                <button id="btnSearchContactLikeNameORLikeAddCharacteristic" class="btn-primary">искать</button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"  >
                <button id="makeNewContactClient" title="создать новый контакт" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> новый контакт</button>
                <button id="restoreLastDeletedContact" class="btn btn-primary" title="восстановить последний удаленный контакт"><span class="glyphicon glyphicon-cloud-upload"></span> восстановить контакт</button>
            </div>
        </div>');
    // конец блока строки поиска

}