<?
    require_once('./head.php');
//echo password_hash ( "AdMiNmArEvO_1972" , PASSWORD_BCRYPT);
?>
<div class="container">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-lg-6 col-lg-offset-3  co-md-offset-3 text-center">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">
				<h3 class="panel-title">
				Авторизация на сайте</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 login-box vcenter">
							<form role="form" name="authorization">
								<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<input type="text" class="form-control" placeholder="Имя пользователя" required autofocus name="login"/>
								</div>
								<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" class="form-control" placeholder="Ваш пароль" required name="password"/>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 vcenter">
							<button type="submit" class="btn btn-labeled btn-success" id="authorization">
							<span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Войти</button>
							<button type="button" class="btn btn-labeled btn-danger">
							<span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Выход</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>    
	function authorize() {
		// создать объект для формы
        var formData = new FormData(document.forms.authorization);
		formData.append('action','create');
        // отослать
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/handlers/session.php", false);
	    xhr.overrideMimeType("text/plain; charset=utf8");
        xhr.send(formData);
			if(xhr.responseText=="authorized")
			{
				location.reload();
			}
			else if(xhr.responseText!="unauthorized")
			{
				console.log(xhr.responseText);
			}
		}
document.getElementById("authorization").onclick=authorize;
document.onkeyup = function(e){
			e = e || window.event;
		if(e.keyCode==13)
		{
			authorize();
		}
		return false;
		}
</script>