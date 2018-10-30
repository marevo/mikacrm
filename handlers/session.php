<?
chdir($_SERVER["DOCUMENT_ROOT"]);
//require_once 'autoload.php';

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
      //  $userAUthorized->authorized = 'unauthorized';
   // echo "$userAUthorized->authorized";
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
