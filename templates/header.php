   <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' id="logo">
				<div id="myAffix1" data-spy="affix" data-offset-top="0">
					<img src="\img\1_Primary_logo_on_transparent_322x63.png"/>
				</div>
   </div>
   <div class='col-lg-7 col-md-7 col-sm-7 col-xs-7' id="status">
       <div id="myAffix2" data-spy="affix" data-offset-top="0">
           <?php include_once('App/html/forDisplayTimeShowAnswerServer.html'); ?>
		</div>
   </div>
   <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3' id="pod">
   <div class='row pod_row' id="myAffix3" data-spy="affix" data-offset-top="0">
            <div class=' col-lg-4 col-md-4 col-sm-4 col-xs-4 pod_lang'>
				    <a id="en">EN</a>
					<a id="ru">RU</a>
			</div>
			<div class=' col-lg-4 col-md-4 col-sm-4 col-xs-4 pod_user'>
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
					<div class=' col-lg-4 col-md-4 col-sm-4 col-xs-4 pod_exit'>			
						<a id="exit" href="#">
							<i class="icon-exit3"></i> 
							<?
							    $strings=parse_ini_file(__DIR__.'/../locales/'.$_GET['lang'].'.ini');
								echo $strings['exit'];
							?>
						</a>
					</div>
	</div>
   </div>
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
///Добавить параметр языка в конец строки запроса
   function insertParam(key, value)
   {
    key = encodeURI(key); value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i=kvp.length; var x; while(i--) 
    {
        x = kvp[i].split('=');

        if (x[0]==key)
        {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&'); 
   }
   
   document.getElementById("en").onclick=function() {
	   insertParam("lang","en");
	   
   }
   
   document.getElementById("ru").onclick=function() {
	   insertParam("lang","ru");
       
   }
   function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
   }
   if(!findGetParameter('lang')) {
	   insertParam("lang","ru");
   }
</script>
