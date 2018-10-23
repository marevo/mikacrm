<?
chdir($_SERVER["DOCUMENT_ROOT"]);
require_once 'autoload.php';

//Функция проверки валидности текущей сессии
function check_session(\App\Models\User $user){
	$sid=session_id();
    $currentUserBySessionId =\App\Models\User::getCurrentUserBySession($sid);
	//Если срок действия сессии не истёк - продлеваем сессию
	if($currentUserBySessionId && time()- $currentUserBySessionId->updated <1800) {
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
if ($_POST["action"] && htmlspecialchars($_POST["action"]) == "create"){
//    array_shift($_SESSION);
//die();
    $login = htmlspecialchars($_POST["login"]);
    $passwordFromPost = htmlspecialchars($_POST["password"]);
    $currentUserByLogin = \App\Models\User::getCurrentUserByLogin($login);
//	$currentUserByLoginAndBySessionId =\App\Models\User::getCurrentUserByLoginAdnBySessionId($login);
//	проверка пароля от клиента с паролем из базы данных текущего пользователя
    if ($currentUserByLogin && $currentUserByLogin->ifUserAuthorized($passwordFromPost)){
        //пароль совпадает значит пользователь авторизированый
        $userAUthorized = $currentUserByLogin;
        //если пароль и логин совпадают  сделаем update его сессии по session_id();
        //если есть то обновим его сессию, если нет добавим
        // вызов этого метода createOrUpdate_SESSION_UsersOnSite() идет в  createSession($login)
        //$currentUserByLogin->createOrUpdate_SESSION_UsersOnSite();// создаст или добавит в существующий $_SESSION['user_id' => 'session_id()']
        //если пароли совпадают то делаем update в таблице user для данного пользователя
        //и делаем в $_SESSION запись idUser idSession
        if( $userAUthorized->udpateSessionInTable() && $userAUthorized->createOrUpdate_SESSION_UsersOnSite())
            echo "$userAUthorized->authorized";
    }else
        $userAUthorized->authorized = 'unauthorized';
    echo "$userAUthorized->authorized";
}
//Обработка запроса на выход из uathorization.php
if( $_POST["action"] && $_POST["action"]=="delete"){
    if(isset($_POST['exitLoginUser'])){
        $loginForExit = htmlspecialchars($_POST['exitLoginUser']);
        //TODO: выход для Login $loginForExit
        $deleted = (new \App\Models\User())->getCurrentUserByLogin($loginForExit)->deleteSessionForLoginUser();
    }
	if(session_start())
    {
//        $session=session_id();
//        $deleted=\App\Models\User::deleteSession($session);
//        $deleted=\App\Models\User::deleteSessionForLoginUser($loginForExit);
    }
}
