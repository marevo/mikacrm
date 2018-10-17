<?
chdir($_SERVER["DOCUMENT_ROOT"]);
require_once 'autoload.php';

//Функция проверки валидности текущей сессии
function check_session()
{
	$sid=session_id();
    $currentUserBySessionId =\App\Models\User::getCurrentUserBySession($sid);
	//Если срок действия сессии не истёк - продлеваем сессию
	if($currentUserBySessionId && time()- $currentUserBySessionId->updated<1800)
	{
		
		$updated=\App\Models\User::createSession($currentUserBySessionId->login);
		if($updated)
		{
		    return "authorized";
		}
		else
		{
			return $currentUserBySessionId; //Отладочная информация в случае ошибки
		}
	}
	//Иначе не авторизируем пользователя
	else
	{
		return "unauthorized";
	}
}


//Обработка запроса авторизации первый раз зайдя на сайт и жмет кнопку #authorization
//сессия еще не создана!
if( $_POST["action"] && htmlspecialchars( $_POST["action"] )== "create")
{
	session_start();
	$login = htmlspecialchars($_POST["login"]);
	$password = htmlspecialchars($_POST["password"]);
    //найдем User который отправил запрос на авторизацию и проверим его пароль
	$currentUserByLogin =\App\Models\User::getCurrentUserByLogin($login);
//	$sesion_id =
//	$currentUserByLoginAndBySessionId =\App\Models\User::getCurrentUserByLoginAdnBySessionId($login);
//	проверка пароля от клиента с паролем из базы данных текущего пользователя
	if($currentUserByLogin && password_verify( $password, $currentUserByLogin->password))
	{
		//если пароли совпадают то делаем update в таблице user для данного пользователя и вернем 
        //в случае успеха самого текущего юзера в случае не успеха false
		$resOrUser = $currentUserByLogin->updateSession(); 
//		$updated =\App\Models\User::createSession( $login );
		if($resOrUser)
		{
//            вернем обЪект json текущего юзера authorization.php
//            $objAuthorizedUserId = {'id' => $resOrUser->id,};
            $resOrUser->password = $password;
           $jsonUser = json_encode($resOrUser,JSON_UNESCAPED_UNICODE);
            echo $jsonUser;
		}
		else
		{
            $NoAuthorizedUser = ['user'=> 'enter Login','password'=>'enter password','authorizen'=>'false' ];
            $jsonNoAuthorizedUser = json_encode($NoAuthorizedUser);
            echo $jsonNoAuthorizedUser;
		}
	}
	else
	{
		echo "unauthorized";
	}
}
//Обработка запроса на выход
else if($_POST["action"]=="delete")
{
	if(session_start())
    {
        $session=session_id();
        $deleted=\App\Models\User::deleteSession($session);
    }
}
