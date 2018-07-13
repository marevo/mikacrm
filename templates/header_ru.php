   <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3' id="logo">
				<div id="myAffix1" data-spy="affix" data-offset-top="0">
					<img src="\img\1_Primary_logo_on_transparent_322x63.png"/>
				</div>
   </div>
   <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5' id="status">
       <div id="myAffix2" data-spy="affix" data-offset-top="0">
           <?php include_once('App/html/forDisplayTimeShowAnswerServer.html'); ?>
		</div>
   </div>
   <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4' id="pod">
   <div class='row pod_row' id="myAffix3" data-spy="affix" data-offset-top="0">
			<div class=' col-lg-6 col-md-6 col-sm-6 col-xs-6 pod_user'>
						<a>
							<i class="fa-user"> </i>
									<?
										require_once 'autoload.php';
										$sid=session_id();
										$res=\App\Models\User::getCurrentUserBySession($sid);
										echo $res[0]->name;
									?>
						</a>
			</div>	
					<div class=' col-lg-6 col-md-6 col-sm-6 col-xs-6 pod_exit'>			
						<a id="exit" href="#">
							<i class="icon-exit3"></i> Exit
						</a>
					</div>
	</div>
   </div>
  <!-- <div class='col-lg-4'>
						<a id="exit" href="#">
							<i class="icon-exit3"></i> Выход
						</a>
   </div>
   <div class="navbar-header" >
				
	</div>
			-<div class="navbar-collapse collapse" id="pod">
			<div>
			<div>
			Екатерина
			</div>
			<div>
			Выход
			</div>
				 <ul class="nav navbar-nav">
					<li onclick="zoomInY('left-sidebar')">
						<a class="sidebar-control sidebar-mobile-main-toggle sidebar-main-toggle hidden-xs">
							<i class="icon-paragraph-justify3">
							</i>
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right" id="head">
					<li>
					    <a>
							<i class="fa-user"> </i>
									<?
										require_once 'autoload.php';
										$sid=session_id();
										$res=\App\Models\User::getCurrentUserBySession($sid);
										echo $res[0]->name;
									?>
						</a>			
						
					</li>
					<li>
						<a id="exit" href="#">
							<i class="icon-exit3"></i> Выход
						</a>
					</li>
				</ul>	-->
			
				<div id="completed_successfully" style="display:none">Успешно завершено</div>
<script type="text/javascript">
document.getElementById("exit").onclick=function(){
	var xhr = new XMLHttpRequest();
        xhr.open("POST", "/handlers/session.php", false);
	    xhr.overrideMimeType("text/plain; charset=utf8");
		var formData = new FormData();
		formData.append('action','delete');
        xhr.send(formData);
		location.reload();
}
function hide_completed(){
	document.getElementById("completed_successfully").style="display: none";
}
function set_completed_handler(timeout){
	document.getElementById("completed_successfully").style="display: block";
	setTimeout(hide_completed,timeout);
}
$(function(){
  $('#myAffix1').width($('#logo').width());
  $(window).resize(function(){
    $('#myAffix1').width($('#logo').width());
  });
});
$(function(){
  $('#myAffix2').width($('#status').width());
  $(window).resize(function(){
    $('#myAffix2').width($('#status').width());
  });
});
$(function(){
  $('#myAffix3').width($('#pod').width());
  $(window).resize(function(){
    $('#myAffix3').width($('#pod').width());
  });
});
</script>
