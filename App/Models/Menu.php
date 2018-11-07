<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 07.11.2018
 * Time: 22:13
 */

namespace App\Models;


use App\ModelLikeTable;

class Menu extends ModelLikeTable
{
    public $id;
    public $parent_id;
    public $title;
    public $handler;
    public $image;
    public $numberinOrder;
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
}