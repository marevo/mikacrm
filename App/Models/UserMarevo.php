<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 26.09.2017
 * Time: 21:07
 */

namespace App\Models;
use App\ModelLikeTable;
use App\Db;

class UserMarevo extends ModelLikeTable
{
    public $id;
    public $name;
    public $login;
    public $password;
    public $gmail;
    public $secretQuestion;
    public $secretAnswer;
    public $session;
    public $updated;
    public $rightUser;

    const TABLE = 'users';
    const NAME_ID = 'id';

    public function isNew()
    {
        // TODO: Implement isNew() method.
        if(empty($this->id) || is_null($this->id)){
//            echo "ДА ЭТО НОВЫЙ user";
            return true;
        }
        else{
            return false;
        }
    }
    
    public function isAdmin(){
//        $objUser = self::findObjByIdStatic(intval(1));
        if($this->login == "adminMarevo" && $this->password == "AdMiNmArEvO_1972")
//        if($this->login == $login && $this->password == $password)
            return $this;
        return false;
    }
    public static function isAdminStatic($login, $password){
        $objUser = self::findObjByIdStatic(intval(1));
//        if($objUser->login == "adminMarevo" && $objUser->password == "AdMiNmArEvO_1972")
        if($objUser->login == $login && $objUser->password == $password)
            return $objUser;
        return false;
    }

    public static function getUserStatic($login, $password){
        $query = "SELECT * FROM ".self::TABLE." WHERE `login`='$login' AND `password`='$password'; ";
        $db = new Db();
        $res = $db-> query($query,self::class);
        if($res)
            return $res[0];
        else return false;
        
    }
    //есть ли привилегия на read insert update delete (r i u d) у этого пользователя
    public function isPrivilege($privilege){
        $strPrivilege = $this->rightUser;
        $privilegeThisUser = explode(' ',$strPrivilege );
        if(in_array($privilege,$privilegeThisUser )){
            return true;
        }else{
            return false;
        }
    }
}