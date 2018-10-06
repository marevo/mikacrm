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
//Обработка запроса авторизации
if( $_POST["action"] && htmlspecialchars( $_POST["action"] )== "create")
{
	session_start();
	$login = htmlspecialchars($_POST["login"]);
	$password = htmlspecialchars($_POST["password"]);
	$currentUserByLogin =\App\Models\User::getCurrentUserByLogin($login);
//	проверка пароля от клиента с паролем из базы данных текущего пользователя
	if($currentUserByLogin && password_verify( $password, $currentUserByLogin->password))
	{
		//если пароли совпадают то создаем сессию
		$updated =\App\Models\User::createSession( $login );
		if($updated)
		{
		    echo "authorized";
		}
		else
		{
			echo $currentUserByLogin;
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
