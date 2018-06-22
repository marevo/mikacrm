<?php
//можем здесь писать если просто вывод или пока что при подключении будет autoload.php в head.html
//require '../autoload.php';

$filds_nameToView = [ 'name' =>'название заказа',
    'nameClient'=>'название клиента',
    'orderPrice'=>'цена',
    'isReady'=>'coст',
    'isCompleted'=>'комп',
    'payment'=>'оплата',
'dateOrder'=>'дата'];
//функция показа в нужном виде данных в этом view (названия столбоц в thead,
// отображание в удобочитаемом виде готовности заказа 0-новый(не посчитан), 1-закрыт успешно, 2-закрыт неуспешно 3-новые (посчитан)
//$arrAll результат запроса из Class Order --->>>
// $query = "SELECT  o.id AS idOrder , o.name, c.name AS nameClient , o.orderPrice,o.isReady, o.isCompleted, SUM( p.sumPayment) AS payment
//FROM orders o, clients c, payments p
//                  WHERE o.idClient = c.id AND idOrder = p.idOrder AND o.id = p.idOrder
//                  GROUP BY idOrder ";

//в результате запроса получим 1)id заказа,2) название заказа,3) назавание заказчика,4) цена заказа, 5) степень готовности (0-новый не посчитан,1-закрыт успешно,2-закрыт неуспешно 3-новый посчитан),6) можно ли меняц цены заказа,
function showFromFields($idTable, $arrAll = [], $filds_nameToView)
{
    if (isset($arrAll) && !is_null($arrAll) && isset($arrAll[0])) {
//            из переданного асс массива для заголовков полей получим удобочитаемые пример 'name' =>'название заказа'
        $tableAll = '';
        //теперь в строку сверстаем таблицу
        $tableAll .= "<table id = '$idTable'  class='table-hov'>
            <thead><tr>
                      <td>$filds_nameToView[dateOrder]</td>
                      <td>$filds_nameToView[name]</td>
                      <td>$filds_nameToView[nameClient]</td>
                      <td>$filds_nameToView[orderPrice]</td>
                      <td>$filds_nameToView[isReady]</td>
                      <td>$filds_nameToView[isCompleted]</td>
                      <td>$filds_nameToView[payment]</td>
                      <td><span class='glyphicon glyphicon-eye-open'></span></td>
                      <td><span class='glyphicon glyphicon-trash'></span></td>
                  </tr>
            </thead>
            <tbody>";

        //проходим все строки таблицы
        foreach ($arrAll as $rowItem):
            //Дадим отображение для для $rowItem[isReady] вместо значения 0,1,2 дадим расшифровку <td>$rowItem[isReady]</td>
            $isReady = '';
            //новый он не запущен в работу надо еще считать или утвердить цену
            // или получить задаток 70% и тогда первести в состояние запущен
            //
            if ($rowItem[isReady] == 0) {
                $tableAll .= "<tr class='orderNewRow'>";
                $isReady = "<td ><span class='orderNewCell'>новый</span></td>";
            }
            if ($rowItem[isReady] == 3) {
                $tableAll .= "<tr class='orderNewRow'>";
                $isReady = "<td ><span class='orderNewCell'>запущен</span></td>";
            }
            if ($rowItem[isReady] == 1) {
                $tableAll .= "<tr class='orderSuccessRow'>";
                $isReady = "<td> <span class='orderSuccessCell'>успешный</span></td>";
            }
            if ($rowItem[isReady] == 2) {
                $tableAll .= "<tr class='orderNoSuccessRow'>";
                $isReady = "<td><span class='orderNoSuccessCell'>провален</span></td>";
            }
            //Дадим отображение для для    $rowItem[isAllowCalculateCost] 1-разрешено, 0-не разрешено
            // <td>$rowItem[isAllowCalculateCost]</td>
            $isAllow = '';
            if ($rowItem[isCompleted] == 0) {
                $isAllow = "<td class='text-center'><span class='orderNoSuccessCell'>нет</span></td>";
            }
            if ($rowItem[isCompleted] == 1) {
                $isAllow = "<td class='text-center'><span class='orderSuccesCell'>да</span></td>";
            }
            //для отображения предоплаты дадим расшифровку
            $payment = '';
            if ($rowItem[payment] == '' || $rowItem[payment] == 0)
                $payment = "<td><span class='orderNoSuccessCell'>0</span></td>";
            else $payment = "<td><span class='orderSuccessCell'>$rowItem[payment]</span></td>";
            //для отображения полной оплаты

            $tableAll .= "
                                 <td>нач: $rowItem[dateBegin]<br>кон: $rowItem[dateEnd]</td>
                                 <td>$rowItem[name]</td>
                                 <td>$rowItem[nameClient]</td>
                                 <td>$rowItem[orderPrice]</td>
                                 $isReady
                                 $isAllow
                                 $payment
                                 <td><a data-id= $rowItem[idOrder]  ><span class='glyphicon glyphicon-eye-open'></span></a></td>
                                 <td><button data-id=$rowItem[idOrder]><span class='glyphicon glyphicon-trash'></span></button></td>
                </tr>";
        endforeach;
        $tableAll .= '</tbody></table>';
        return $tableAll;
    } else {
        return '<div class="alert-info text-info text-center">пока нет данных</div>';
    }
}
?>

<title>заказы</title>

<!--подключение строки с показом времени и результатов запросов на сервер -->
<?php include_once('App/html/forDisplayTimeShowAnswerServer.html'); ?>

<div class="row"><!-- основной блок контета состоит из 12 колонок слева  -->
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 classPaddingRight_0">
        <div class="row headingContent">
            <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center "> заказы </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"></div>
        </div>
        <div class="row rowSearch"><!-- строка поиска-->
            <!--  сторка для поиска заказов по клиенту и по названию заказа -->
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 ">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <input type="text" size="15" name="inputFindOrderForName" placeholder="по названию">
                        <button name="searchForName" class="btn  btn-sm btn-primary">искать</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <input type="text" size="15" name="inputFindOrderForNameClient" placeholder="по клиенту">
                        <button name="searchForNameClient" class="btn btn-sm btn-primary">искать</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <button class="btn btn-primary" id="viewTrashedOrders" title="показать удаленные заказы">
                    <span class="glyphicon glyphicon-trash"></span> корзина
                </button>
                <button class="btn btn-primary addNewOrder" id="makeNewOrder" title="создать новый заказ">
                    <span class='glyphicon glyphicon-plus'></span> новый заказ
                </button>
                <script type="text/javascript">
                    $('#makeNewOrder').on('click', includeFormAddNewOrder);
                    function includeFormAddNewOrder() {
                        jquery_send('#main_modul', 'post', '/templates/controllerViewAllOrders.php', ['includeFormNewOrder'], ['']);
                        //event.stopPropagation();
                        //                            document.getElementById("#main_modul").innerHTML= '<?// echo  include ('formAddNewOrder.php');?>//';
                        return false;
                    }
                </script>
            </div>
        </div><!-- конец блока строки поиска  -->
        <div class="row backForDiv divForTable"><!-- строка показа в таблице заказов-->
            <div class="col-lg-12" id="table_Orders">
                <?php
                //передадим id='tableOrder'; в отображение будущей таблицы
                //echo \App\Models\Order::showAllFromTable('tableOrders',
                //\App\Models\Order::findAll(),['id','name', 'idClient','orderPrice','isAllowCalculateCost']);
                //                        var_dump(\App\Models\Order::selectForView());
                //вызовем функцию отображения showFromFields($idTable, $arrAll = [], $filds_nameToView)
                //$idTable = id уникальный таблицы,
                // arrAll=[] массив данных передаваемых для отображения,
                // $filds_nameToView ассоциативный массив полей для отображения определяется выше
                echo showFromFields('tableOrders', \App\Models\Order::selectForView(), $filds_nameToView);
                ?>
            </div>
        </div>
    </div>
</div>
<!-- подключение модального окна которое будет всплывать при нажатии кнопки удалить-->
<?php include_once './App/html/viewAllOrdersModal.html'; ?>
<?php // include_once '/App/html/viewAllOrdersModal.html';?>
<script src='/js/viewAllOrders.js'></script>

