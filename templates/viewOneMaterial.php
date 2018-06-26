<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 27.08.2017
 * Time: 23:17
 */
//require '../autoload.php';
$idMaterial=1;
if(isset($_POST['id'])){
//    если передали id значит работаем с ним иначе будем брать в else по умолчанию id=1
    $idMaterial = intval($_POST['id']);
    \App\FastViewTable::showUspeh("есть материал с id = $idMaterial");
}
else{
    \App\FastViewTable::showUspeh("ошибка в id = $idMaterial");
}
$mat = \App\Models\Material::findObjByIdStatic($idMaterial);

?>
   
<title> просмотр/правка данных материала </title>
   
    
        <div class="row">
            <!--            начало доп блока слева
            <div class="col-lg-2 backForDiv">
                этот див слева от таблицы в нем можно расположить дополнительные кнопки добавить редактировать удалить
            </div>
            <!--            конец доп блока слева-->
            <div class="col-lg-12 backForDiv">
                <!--строка показа времени и показа результата добавки материала в базу  -->
                <?php  include_once '../../App/html/forDisplayTimeShowAnswerServer.html'?>
                <div class="row headingContent">
                    <div class="col-lg-10   col-md-10 col-sm-10 col-xs-10   text-center ">правка материала <?php echo $mat->name;?></div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center"><button id="btnUpdateShow" class="btn btn-sm btn-primary" > вернуться </button></div>
                    <?php
                    $ifExistOrderWithThisMaterial = \App\Models\MaterialsToOrder::ifExistThisMaterialInAnyOneOrder_2($mat->id);
                    if(! $ifExistOrderWithThisMaterial){
//                        echo  "$mat->id";
                        //нет материалов этого поставщика ни в одном заказе кнопка править будет доступна на клиенте
                        echo "<div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center'><button class='btn btn-sm btn-primary' id='btnEnableUpdate' >править</button></div>";
                    }
                    else{
//                        echo "материал с id= $mat->id есть в заказах и удалять и править его нельзя";
                        echo "<div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center'><!--<button  class='btn btn-sm btn-primary' id='btnEnableUpdate' >править</button>--></div>";
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form action="../App/controllers/controllerOneMaterial.php" method="post">
                        <table>
                            <thead>
                            <tr>
                                <td>название поля</td>
                                <td>значение</td>
                                <td class="tdDisplayNone">новое значение</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="display: none;"><td>id</td><td><?php echo $mat->id ?></td><td class="tdDisplayNone"><input  name="id" type="text" value="<?php echo $mat->id ?>"/></td></tr>
                            <tr><td>название</td><td><?php echo $mat->name ?></td><td class="tdDisplayNone"><input name="name" type="text" size="55" maxlength="200" title ="<?php echo $mat->name ?>" value="<?php echo $mat->name ?>"/></td></tr>
                            <tr><td>дополнительные сведения</td><td><?php echo $mat->addCharacteristic ?></td><td class="tdDisplayNone"><textarea cols="60" rows="4" maxlength="200"  name="addCharacteristic" title="<?php echo $mat->addCharacteristic ?>" type="text" ><?php echo $mat->addCharacteristic ?></textarea></td></tr>
                            <tr><td>единица измерения</td><td><?php echo $mat->measure ?></td><td class="tdDisplayNone"><input name="measure" maxlength="50" type="text" value="<?php echo $mat->measure ?>"/></td></tr>
                            <tr><td>форма поставки</td><td><?php echo $mat->deliveryForm ?></td><td class="tdDisplayNone"><input pattern="\d{1,4}(\.)?\d{1,2}" name="deliveryForm" type="text" value="<?php echo $mat->deliveryForm ?>"/></td></tr>
                            <tr><td>цена за единицу</td><td><?php echo $mat->priceForMeasure ?></td><td class="tdDisplayNone"><input pattern="\d{1,4}(\.)?\d{1,2}" name="priceForMeasure" type="text" value="<?php echo $mat->priceForMeasure ?>"/></td></tr>
                            <tr><td>поставщик</td><td><?php echo   \App\Models\Supplier::findObjByIdStatic($mat->id_suppliers)->name;  ?>

                                   </td><td class="tdDisplayNone">
                                    <select name="id_suppliers">
                                        <?php
                                        $allSuppliers = \App\Models\Supplier::findAll();
                                        $options="";
                                        foreach ($allSuppliers as $supplierItem){
                                            $options.= "<option value='$supplierItem->id'>".htmlspecialchars($supplierItem->name)."</option>";
                                        }
                                        echo "$options" ?>
                                    </select></td></tr>
<!--                            <tr><td>название поставщика</td><td>--><?php //echo \App\Models\Supplier::findObjByIdStatic($mat->id_suppliers)->name; ?><!--</td><td class="tdDisplayNone"><input name="name_suppliers" type="text"/></td></tr>-->
                            <tr><td></td><td></td><td class="tdDisplayNone"><input name="name_suppliers" type="submit"/></td></tr>
                            <tr style="display: none;"><td>скрытое поле</td><td>маяк</td><td><input name="submitOneMaterial" /></td></tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
                <table></table>
            </div>
        </div>
    
    <script type="text/javascript" src="/js/viewOneMaterial.js"></script>
<script type="text/javascript">
    //выбор в селекте нужного значения по id поставщика
    $(function () {
        $('select').val('<?php echo $mat->id_suppliers ;?>');
    });
</script>


    




