<?
require_once 'autoload.php';
//use App\Models\User;
function check_session()
{
	$sid=session_id();
    $res=\App\Models\User::getCurrentUserBySession($sid);
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
	else
	{
		return "unauthorized";
//		echo $sid;
 //       echo $res[0]-;
	}
}
