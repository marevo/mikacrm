<?php
//   if($objUser->login == "adminMarevo" && $objUser->password == "AdMiNmArEvO_1972")
//   if($objUser->login == "admin" && $objUser->password == "password")
?>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="left-sidebar"><!--navbar navbar-inverse navbar-fixed-top-->
			<!--меню сайта слева--> 
<!--			<img class="img-circle img-sm" hspace="20" vspace="20"/> -->
			<div class="menu_list">
<!--				<span class="fa-user" style="margin-left: 20px; margin-top: 10px;"></span>-->
				<?
				//вроде autoload.php уже подключен
//					require_once 'autoload.php';
//					$sid = session_id();
//				    $currentUserBySession =\App\Models\User::getCurrentUserBySession($sid);
//				    $currentUserBySession->name;
				?>
<!--				<a><span class="glyphicon glyphicon-cog btn-lg" style="float: right;" id="profile"></span></a>-->
<!--			</div>-->
				<ul id="menu_list">
					<?php // include "handlers/menu.php"; ?>
				</ul>
			<!-- Доп блок для ответов сервера при отладке или для подсказки -->
			<ul id="answerServer"><li></li></ul>
			<!-- новая панель навигации  begin-->
<!--			<div class="row">-->
<!--				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main_menu" style="background-color: #2aabd2;">-->
					<?php include'./templates/viewMenu.php' ?>
<!--				</div>-->
<!--                </div>-->
			</div>
			<!-- новая панель навигации  end-->
		</div>

		<!-- конец меню сайта ( слева )--> 
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" id="main_modul">
		<!--контент сайта-->
			<?
				require_once "functions/functions.php";
                $pageIndex = "templates/viewAllOrders.php";
                $pageNoIndex ="";
				if( isset($_GET['page'])) {
                    $pageFromGet = htmlspecialchars( $_GET['page']);
                   // меню и обработчики доступные только админу
                    // предохранитель к доступу меню для администратора
                    $titlesForAdmin = ['AdminPanel','viewAllUsers','viewMenu'];
                    $handlersByMenuForAdmin = ['templates/viewAdminPanel.php','templates/viewAllUsers.php','templates/viewMenu.php'];
                    $rightCurrentUser = explode(' ',$user->rightUser);
                    if( in_array($pageFromGet, $titlesForAdmin) &&
                        ( in_array('all' , $rightCurrentUser ) ||  in_array('super',$rightCurrentUser) ) ){
                        $pageNoIndex = $resultTemplateViewForAdmin = get_handler_by_menu_title($pageFromGet);
                    }else{
                        $titlesForOrdinaryUser = [
                            'Contacts',
                            'Clients',
                            'Orders',
                            'Suppliers',
                            'Materials',
                            'Place_order'
                        ];
                        $handlersByMenuForOrdinaryUser = [
                            'templates/viewAllContacts.php',
                            'templates/viewAllClients.php',
                            'templates/viewAllOrders.php',
                            'templates/viewAllSuppliers.php',
                            'templates/viewAllMaterials.php',
                            'templates/formAddNewOrder.php'
                        ];
                        if(in_array($pageFromGet, $titlesForOrdinaryUser) &&
                            ( in_array('c' , $rightCurrentUser ) ||  in_array('r',$rightCurrentUser) || in_array('u',$rightCurrentUser )
                                || in_array('d',$rightCurrentUser ) ) ){
                            $pageNoIndex = $resultTemplateViewForOrdinaryUser = get_handler_by_menu_title($pageFromGet);
                        }else{
                            //если нет никаких прав то надо переключить на ветку регистрации
                           // $pageNoIndex = 'authorization.php';
                            $pageNoIndex= './pageDontHaveAccessRights.php';
                        }
                    }

//					include "templates/viewAdminPanel.php" ;
                    include $pageNoIndex ;
				} else {
					//загрузка страницы по умолчанию заказы
					include $pageIndex;
				}
			?>
		</div>


<script type="text/javascript">
//    document.getElementById("profile").onclick=function() {
//		// создать объект для формы
//        // отослать
//        var xhr = new XMLHttpRequest();
//        xhr.open("POST", "./profile.php", false);
//	    xhr.overrideMimeType("text/plain; charset=utf8");
//        xhr.send(null);
//		document.getElementById("main_modul").innerHTML = xhr.responseText;
//		document.getElementById("name_profile").value='<?//echo $res[0]->name;?>//';
//		document.getElementById("email_profile").value='<?//echo $res[0]->gmail;?>//';
//		document.getElementById("phone_profile").value='<?//echo $res[0]->phone;?>//';
//}

   var zoomed=true;
   function zoomInY(targetBlock)
   {
	   if(zoomed)
	   {
	        new Effect.Scale(targetBlock, 10, {duration: 1, scaleX: true, scaleY: false, scaleContent: false});
			zoomed=false;
			document.getElementById("menu_list").style.display="none";
	   }
	   else
	   {
		   new Effect.Scale(targetBlock, 1000, {duration: 1, scaleX: true, scaleY: false, scaleContent: false});
		   zoomed=true;
		   document.getElementById("menu_list").style.display="block";
	   }
   }
   
</script>