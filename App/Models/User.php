<?php
namespace App\Models;
use App\Db;
//use App\FastViewTable;
use App\ModelLikeTable;


class User extends ModelLikeTable
{
    public $name; //Имя клиента
    public $login;
    public $password;//
    public $gmail;
    public $session;//varchar(32)
    public $updated;//время последнего захода в сек для отслеживания сессии
    public $rightUser; //права пользователя c r u d all super   all & super только для admin
   /*
    *  login adminMarevo  password $2y$10$Da0edjR1TuRVWDqtACSrw.XM3I1QjLfPcJh18X62Buq5/HisKo6I.
    *
    */
 //   use FastViewTable;
    
    const TABLE = 'users';
    const NAME_ID ='login';
//    static $table = 'clients';
    public function isNew()
    {
        // TODO: Implement isNew() method.
        if(empty($this->login) || is_null($this->login) ){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getCurrentUserBySession(string $session){
        $db = new Db();
        $query = "SELECT * FROM ".self::TABLE." WHERE session = '".$session."' ; ";

        $res = $db->query($query, self::class );
        if($res)
            return $res[0];
        else
            return false;
    }
    
    public static function getCurrentUserByLogin(string $login)
	{
        $db = new Db();
        $query = "SELECT * FROM ".self::TABLE." WHERE login = '".$login."' ; ";

        $currentUserByLogin = $db->query($query, self::class );
        if($currentUserByLogin)
           return $currentUserByLogin[0];
        else return false;
//         return $query;
	}
    
	public static function createSession(string $login)
	{
		$db = new Db();
		$values = [];
		$values [':session']=session_id();
		$values [':updated']=time();
        $query = "UPDATE ".self::TABLE." SET session = :session, updated = :updated WHERE login = '".$login."' ; ";
		$res = $db->execute($query, $values);
//		echo session_id();
	//	echo time();
        return $res;
	}
	public static function deleteSession(string $session)
	{
		$db = new Db();
		$values = [];
		$values [':session']='NULL';
        $query = "UPDATE ".self::TABLE." SET session = :session WHERE session = '".$session."' ; ";
		$res = $db->execute($query, $values);
        return $res;
	}
	public static function saveProfile(string $login, string $name, string $email, string $phone,string $password)
	{
		$db = new Db();
		$values = [];
		$values [':name']=$name;
		$values [':gmail']=$email;
		$values [':phone']=$phone;
		$values [':password']=$password;
        $query = "UPDATE ".self::TABLE." SET name = :name, gmail = :gmail, phone = :phone, $password = :password WHERE login = '".$login."' ; ";
		$res = $db->execute($query, $values);
//		echo session_id();
	//	echo time();
        return $res;
	}
}