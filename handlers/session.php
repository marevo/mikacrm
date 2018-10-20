<?
chdir($_SERVER["DOCUMENT_ROOT"]);
require_once 'autoload.php';

//Функция проверки валидности текущей сессии
function check_session(){
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
if( $_POST["action"] && htmlspecialchars( $_POST["action"] )== "create") {
	session_start();
	$login = htmlspecialchars($_POST["login"]);
	$password = htmlspecialchars($_POST["password"]);
	$currentUserByLogin =\App\Models\User::getCurrentUserByLogin($login);
//	$sesion_id =
//	$currentUserByLoginAndBySessionId =\App\Models\User::getCurrentUserByLoginAdnBySessionId($login);
//	проверка пароля от клиента с паролем из базы данных текущего пользователя
	if($currentUserByLogin && password_verify( $password, $currentUserByLogin->password))
	{
		//если пароль и логин совпадают найдем юзера и сделаем update его сессии по session_id();
		$currentUserByLoginAndByPassword =\App\Models\User::getCurrentUserByLoginAdnByPassword($login,	$password);
        //проверим есть ли такой юзер в массиве $_SESSION['users_onSite']
        //если есть то обновим его сессию, если нет добавим 
        // вызов этого метода createOrUpdate_SESSION_UsersOnSite() идет в  createSession($login)
        //  $currentUserByLogin->createOrUpdate_SESSION_UsersOnSite();// создаст или добавит в существующий $_SESSION['user_id' => 'session_id()']
		//если пароли совпадают то делаем update в таблице user для данного пользователя
//		$resOrUser = $currentUserByLoginAndByPassword->udpateSession();
		$updated =\App\Models\User::createSession( $login );
		if($updated)
//		if($resOrUser)
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
//Обработка запроса на выход из uathorization.php
else if( $_POST["action"] && $_POST["action"]=="delete")
{
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
