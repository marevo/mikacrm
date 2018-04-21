<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 26.06.2017
 * Time: 17:00
 */

namespace App\Models;
use App\Db;
use App\FastViewTable;
use App\ModelLikeTable;


class Reports extends ModelLikeTable
{
    public $pure;
    public $income;//название Клиента
    public $date;
    

    use FastViewTable;
    
    const TABLE = 'orders';
    const NAME_ID ='id';
//    static $table = 'clients';
    public function isNew()
    {
        // TODO: Implement isNew() method.
        if(empty($this->id) || is_null($this->id) ){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getPreviousDay(){
        $db = new Db();
		//$query="SELECT SUM(p.sumPayment) AS 'Доходы',p.date AS 'Дата' FROM payments p WHERE p.date=DATE_ADD(CURDATE(),INTERVAL -1 DAY);";
        $query = "SELECT SUM(o.manufacturingPrice-o.orderPrice) AS pure, SUM(p.sumPayment) AS income, c.dt AS date FROM orders o RIGHT JOIN calendar_table c ON o.dateOfComplation=c.dt AND o.isReady=1 LEFT JOIN payments p ON c.dt=p.date WHERE c.dt=DATE_ADD(CURDATE(),INTERVAL -1 DAY); ";
//        var_dump('<br>обработаем запрос : '.$query.' в функции getAllSuppliers of class '.self.'<br>');

        $res = $db->query($query, self::class );
        return $res;
    }
	public static function getPreviousWeek(){
        $db = new Db();
		$query = " SELECT SUM(o.manufacturingPrice-o.orderPrice) AS pure, SUM(p.sumPayment) AS income, c.dt AS date FROM orders o RIGHT JOIN calendar_table c ON o.dateOfComplation=c.dt AND o.isReady=1 LEFT JOIN payments p ON c.dt=p.date WHERE YEARWEEK(CURDATE())-1=YEARWEEK(dt) GROUP BY c.dt;";
        //$query = "SELECT SUM(p.sumPayment)-SUM(o.manufacturingPrice) AS 'Чистая прибыль', SUM(p.sumPayment) AS 'Доходы', IFNULL(p.date,o.dateOfComplation) AS 'Дата' FROM orders o JOIN payments p ON p.idOrder=o.id WHERE o.dateOfComplation=DATE_ADD(CURDATE(),INTERVAL -1 DAY) OR p.date=; ";
//        var_dump('<br>обработаем запрос : '.$query.' в функции getAllSuppliers of class '.self.'<br>');

        $res = $db->query($query, self::class );
        return $res;
    }
    public static function getPreviousMonth(){
        $db = new Db();
		$query = "SELECT SUM(o.manufacturingPrice-o.orderPrice) AS pure, SUM(p.sumPayment) AS income, STR_TO_DATE(CONCAT(YEARWEEK(c.dt,3),' Monday'), '%x%v %W') AS date FROM orders o RIGHT JOIN calendar_table c ON o.dateOfComplation=c.dt AND o.isReady=1 LEFT JOIN payments p ON c.dt=p.date WHERE EXTRACT(YEAR_MONTH FROM CURDATE())-1=EXTRACT(YEAR_MONTH FROM dt) GROUP BY STR_TO_DATE(CONCAT(YEARWEEK(c.dt,3),' Monday'), '%x%v %W');";

        $res = $db->query($query, self::class );
        return $res;
    }
	public static function getPreviousYear(){
        $db = new Db();
		$query = "SELECT SUM(o.manufacturingPrice-o.orderPrice) AS pure, SUM(p.sumPayment) AS income, STR_TO_DATE(CONCAT(EXTRACT(YEAR_MONTH FROM c.dt),'01'),'%Y%m%d') AS date FROM orders o RIGHT JOIN calendar_table c ON o.dateOfComplation=c.dt AND o.isReady=1 LEFT JOIN payments p ON c.dt=p.date WHERE YEAR(CURDATE())-1=YEAR(dt) GROUP BY STR_TO_DATE(CONCAT(EXTRACT(YEAR_MONTH FROM c.dt),'01'),'%Y%m%d');";

        $res = $db->query($query, self::class );
        return $res;
    }
	public static function getCustomRange($start,$end){
        $db = new Db();
		$query = "SELECT SUM(o.manufacturingPrice-o.orderPrice) AS pure, SUM(p.sumPayment) AS income, c.dt AS date FROM orders o RIGHT JOIN calendar_table c ON o.dateOfComplation=c.dt AND o.isReady=1 LEFT JOIN payments p ON c.dt=p.date WHERE c.dt BETWEEN '".$start."' AND '".$end."' GROUP BY c.dt;";

        $res = $db->query($query, self::class );
        return $res;
    }
}