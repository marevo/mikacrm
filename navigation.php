<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="fon">
	<div class="row" >
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 navbar navbar-inverse navbar-fixed-top" id="left-sidebar"><!--navbar navbar-inverse navbar-fixed-top-->
			<!--меню сайта--> 
			<img class="img-circle img-sm" hspace="20" vspace="20"/> 
			<div class="menu_list">
				<span class="fa-user" style="margin-left: 20px; margin-top: 10px;">
				</span>
				<?
					require_once 'autoload.php';
					$sid=session_id();
					$res=\App\Models\User::getCurrentUserBySession($sid);
					echo $res[0]->name;
				?>
				<a>
					<span class="glyphicon glyphicon-cog btn-lg" style="float: right;" id="profile">
					</span>
				</a>
			</div>
				<ul id="menu_list">
					<? include "handlers/menu.php"; ?>
				</ul>
			<ul id="answerServer"><li>сообщения сервера</li></ul>
		</div>	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" id="main_modul">
		<!--контент сайта-->
			<?
				require_once "functions/functions.php";
				if($_GET['page'])
				{
					$result=get_handler_by_menu_title($_GET['page']);
					include $result;
				}
				else
				{
					include "templates/viewAllOrders.php";
				}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
    document.getElementById("profile").onclick=function() {
		// создать объект для формы
        // отослать
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./profile.php", false);
	    xhr.overrideMimeType("text/plain; charset=utf8");
        xhr.send(null);
		document.getElementById("main_modul").innerHTML = xhr.responseText;
		document.getElementById("name_profile").value='<?echo $res[0]->name;?>';
		document.getElementById("email_profile").value='<?echo $res[0]->email;?>';
}
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