<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.11.2018
 * Time: 22:13
 */

namespace App\Models;


use App\ModelLikeTable;
use App\Db;

class Menu extends ModelLikeTable
{
    public $id;
    public $parent_id;
    public $title;
    public $handler;
    public $image;
    public $numberInOrder;
    // TODO  оставить $title или сделать как везде $name ?   
//    public $name;
    
    
    const NAME_ID ='id';
    const TABLE ='menu';

    public function isNew()
    {
        // TODO: Implement isNew() method.
        if(empty($this->id) || is_null($this->id)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * найдет все пункты меню отсортирует по parent_id и numberInOrder
     * @return array|bool
     */
    public function findAllOrderByNumberInOrder(){
        $db = new Db();
        $query = "SELECT * FROM menu ORDER BY  numberInOrder ;";
//        $query = "SELECT * FROM ". self::TABLE . " ORDER BY  parent_id  , LEFT(numberInOrder,2) ;";
//        $query = "SELECT * FROM ". self::TABLE . " ORDER BY  `parent_id` ;";
//        $query = "SELECT * FROM ". self::TABLE . " LEFT(parent_id,2)  , LEFT(numberInOrder,2) ;";
//        $query = "SELECT * FROM menu  ORDER BY  parent_id  , LEFT(numberInOrder,2) ;";
        $res = $db->query($query, __CLASS__ );
//        var_dump('<br>$res = '.$res.'<br>');
        return $res;
    }

    /**
     * не использовать
     * найдет и вернет меню в виде массива 
     * @return string
     */
    public static function getMenu()
    {
        $menu = new Menu();
        $menuFromTable = $menu->findAllOrderByNumberInOrder();
        if ($menuFromTable) {
            $arr_cat = array();
            foreach ($menuFromTable as $menuItem):
                if (empty($arr_cat[$menuItem->parent_id])):
                    $arr_cat[$menuItem->parent_id] = array();
                endif;
                $arr_cat[$menuItem->parent_id][] = $menuItem;
            endforeach;
            return $arr_cat;
        }
        return NULL;
    }
    /**
     * возвращает массив отсортированный для вывода в меню
     * @param array $arrayUsersNoSort
     * @return array Users 
     */
    public static function sortStatic( $arrayUsersNoSort=[] ){
//        $sortUsers =[];
        $sortUsers = uasort($arrayUsersNoSort,function ($a,$b){
            $aa= explode('-',$a->numberInOrder);
            $bb = explode('-',$b->numberInOrder);
            if( $aa[0] == $bb[0]){
                if($aa[1]==$bb[1])
                    return 0;
                if($aa[1]>$bb[1])
                    return 1;
                return -1;
            }
            if($aa[0]>$bb[0])
                return 1;
            return -1;
        });
        return $arrayUsersNoSort;
    }
    
}