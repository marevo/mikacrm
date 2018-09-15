<?
chdir($_SERVER["DOCUMENT_ROOT"]);
require_once 'autoload.php';

//Функция проверки валидности текущей сессии
function check_session()
{
	$sid=session_id();
    $res=\App\Models\User::getCurrentUserBySession($sid);
	//Если срок действия сессии не истёк - продлеваем сессию
	if($res && time()-$res[0]->updated<1800)
	{
		
		$updated=\App\Models\User::createSession($res[0]->login);
		if($updated)
		{
		    return "authorized";
		}
		else
		{
			return $res; //Отладочная информация в случае ошибки
		}
	}
	//Иначе не авторизируем пользователя
	else
	{
		return "unauthorized";
	}
}
//Обработка запроса авторизации
if($_POST["action"]=="create")
{
	session_start();
    $res=\App\Models\User::getCurrentUserByLogin($_POST["login"]);
	if($res && password_verify($_POST["password"],$res[0]->password))
	{
		$updated=\App\Models\User::createSession($_POST["login"]);
		if($updated)
		{
		    echo "authorized";
		}
		else
		{
			echo $res;
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
