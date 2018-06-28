<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 29.06.2017
 * Time: 9:26
 */

namespace App\Models;


use App\FastViewTable;
use App\ModelLikeTable;

class Task extends ModelLikeTable
{
    public $id;
    public $name;//название содержание
    public $content;
    public $deadline;//до какой даты надо сделать
    public $idUser;//по умолчанию null
    public $priority;//приоритет приоритет 0-сверх срочно, -1 срочно, 2-обычно,		
    public $status;//статус выполнения 0-не готова(по умолчанию) 1- назначена, 2-не назначена, 3-готова
    public $dateAppointment;//дата назначения задачи
    public $dateCompletion;//дата выполнения

    const TABLE ='tasks';
    const NAME_ID = 'id';
    
    use FastViewTable;
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