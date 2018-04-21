    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="row" id="container">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="logo">
				<div id="logo"><img src="\img\1_Primary_logo_on_transparent_322x63.png"/></div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 " id="pod">
			<ul class="nav navbar-nav navbar-right">
			<li>
				<span class="fa-user" style="margin-left: 100px; margin-top: 30px;">
							<?
								require_once 'autoload.php';
								$sid=session_id();
								$res=\App\Models\User::getCurrentUserBySession($sid);
								echo $res[0]->name;
							?>
							
				</span>
				</li>
				<li>
				<a id="exit"><i class="icon-exit3"></i>Выход</a>
				</li>
			</ul>	
			</div>	
				<div id="completed_successfully" style="display:none">Успешно завершено</div>
		</div>
    </div>
<script type="text/javascript">
document.getElementById("exit").onclick=function(){
	var xhr = new XMLHttpRequest();
        xhr.open("POST", "/handlers/deleteSession.php", false);
	    xhr.overrideMimeType("text/plain; charset=utf8");
        xhr.send(null);
		location.reload();
}
function hide_completed(){
	document.getElementById("completed_successfully").style="display: none";
}
function set_completed_handler(timeout){
	document.getElementById("completed_successfully").style="display: block";
	setTimeout(hide_completed,timeout);
}
</script>
