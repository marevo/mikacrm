<?php
namespace App\Models;
use App\Db;
//use App\FastViewTable;
use App\ModelLikeTable;


class User extends ModelLikeTable
{
    public $id;
    public $name; //Имя клиента
    public $login;
    public $password;//
    public $gmail;
    /**
     * @var string
     */
    public $secretQuestion;
    public $secretAnswer;
    public $session;//varchar(32)
    /**
     * @var \DateTime 
     */
    public $updated;//время последнего захода в сек для отслеживания сессии
    public $rightUser; //права пользователя c r u d all super   all & super только для admin
   /*
    *  login adminMarevo  password $2y$10$Da0edjR1TuRVWDqtACSrw.XM3I1QjLfPcJh18X62Buq5/HisKo6I.
    *
    */
 //   use FastViewTable;
    
    const TABLE = 'users';
    const NAME_ID ='id';
//    const NAME_ID ='login';
    const AllRightForUser = "c r u d all super"; 

    public function isNew()
    {
        
        if(empty($this->id) || is_null($this->id) ){
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

    public static function getCurrentUserByLoginAdnBySessionId(string $login , $password ){
    
    }

    /**
     * return user by login and password from base
     * @param string $login
     * @param string $password
     * @return User
     */
    public static function getCurrentUserByLoginAdnByPassword(string $login , string $password ){
        $db = new Db();
        $password = password_hash($password,PASSWORD_BCRYPT);
        $query = "SELECT * FROM ".self::TABLE." WHERE `login` = '$login' AND `password` = '$password'  ; ";
        $res = $db->query($query, self::class);
        return $res[0];
    }

    /**
     * делает update в таблице users по времени и сессии и в случае успеха возращает User - юзера для которого был сделан update сессии
     * @return $this|bool
     */
    public function updateSession(){
        $this->session = session_id();
        $this->updated = time();
        $res = $this->save();
        if($res){
//            вводим дополнительное поле authorized это поле покажет авторизировался пользователь ? или нет
            $this->authorized = 'true';
            $this->updated = (string)$this->updated;
            return $this;
        }
           
        else return false;
    }
	public static function createSession(string $login)
	{
		$db = new Db();
		$values = [];
		$values [':session'] = session_id();
		$values [':updated'] = time();
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

    public static function searchObjectsLikeAnyField(  $likeAnyField){
        $db = new Db();
        $query  = "SELECT * FROM ".static::TABLE ."
                   WHERE `name` LIKE '%".$likeAnyField."%' OR 
                   `login` LIKE '%".$likeAnyField."%' OR
                   `password` LIKE '%".$likeAnyField."%' OR
                   `gmail` LIKE '%".$likeAnyField."%' OR
                   `secretQuestion` LIKE '%".$likeAnyField."%' OR
                   `secretAnswer` LIKE '%".$likeAnyField."%' OR
                   `rightUser` LIKE '%".$likeAnyField."%'
         ;";
//        echo "query";
//        die();
        $res = $db->query($query ,self::class );
//        var_dump('<br>$res = '.$res.'<br>');
        return $res;


    }

    /**
     * return difference between time now and time last visited this User
     * count last visited age in month, day, hour, second
     * @return string
     */
    public function lastVisitAge(){
        if(!$this->updated)
            return 'no visited';
        $timeIn = $this->updated ? date("H:i:s m-d-Y", $this->updated) : 'не заходил';
        $dateNow = new \DateTime(date("Y-m-d H:i:s"));
        $dateVisitedAge = new \DateTime(date("Y-m-d H:i:s", $this->updated));
        $difference = $dateNow->diff($dateVisitedAge);
        return $difference->format('%d days, %h Hour , %i min , %s sec');
    }

    /**
     * add or deletes right to User strin in format '+ c' - add right create '- r' delete right read
     * @param  string $rightUser string where all rights of this user are listed
     * @return bool true in case or like or false in case not luck
     */
    public function addRightDeleteRight(string  $rightUser){
        if($rightUser){
            //получим массив с перечислением существующих прав этого пользователя
            $userRightIsNow = explode( ' ', $this->rightUser);
            // узнаем что нужно добавить или удалить право эт будет перевый член строки $rightUser разбитой через explode
            $userRightWanted = explode(' ',$rightUser );
            //проверим первый член массива это будет + или - добавить/удалить
            if($userRightWanted[0]=='+'){
                //просит добавить право
                $rightToAdd = $userRightWanted[1];
                //если есть член на добавку и такого члена нет в массиве прав
                if($rightToAdd && !in_array($rightToAdd, $userRightIsNow)){
                    $userRightIsNow[] = $rightToAdd;
                    $this->rightUser = implode(' ',$userRightIsNow ) ;
                    return true;
                }
                return false;
            }
            if($userRightWanted[0]=='-'){
                //хотят убрать право
                $rightToDelete = $userRightWanted[1];
                //если есть такой член в удаление в массиве текущих прав
                if($rightToDelete && in_array($rightToDelete, $userRightIsNow)){
                    //найдем его ключ и удалим член в массиве по этому ключю
                    $key = array_search($rightToDelete, $userRightIsNow );
                    unset($userRightIsNow[$key]);
                    $this->rightUser = implode(' ',$userRightIsNow ) ;
                    return true;
                }
                return false;
            }
        }
    }

    /**
     * set new password tho user
     * @param string $newPassword 
     */
    public function setPassword( string $newPassword){
        if($newPassword){
            $this->password = password_hash($newPassword,PASSWORD_BCRYPT );
//            if($this->password){
//                $this->update();
//            }
        }
    }
}