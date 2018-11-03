<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 26.10.2018
 * Time: 8:56
 */
?>
<script> $('#loginForm').remove(); </script>
	<div id="loginForm"  style="margin-top: 20px;" class="col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-md-6 col-lg-offset-3  col-md-offset-3 text-center ">
		<div class="panel panel-primary text-center">
			<div class="panel-heading">
				<h3 class="panel-title">
пройдите авторизацию на сайте</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 login-box vcenter">
						<form role="form" name="authorization">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<input type="text" class="form-control" placeholder="Имя пользователя" required
									   autofocus name="name_login"/>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" class="form-control" placeholder="Ваш пароль" required
									   name="name_password"/>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 vcenter">
						<button type="submit" class="btn btn-labeled btn-success" id="authorization">
							<span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Войти
						</button>
						<button type="button" id="exit2" class="btn btn-labeled btn-danger">
							<span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Выход
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		//Обработчик формы авторизации
		function authorize() {
            // создать объект для формы
            var formData = new FormData(document.forms.authorization);
            formData.append('action', 'login');
            formData.append('name_login', $('[name=name_login]').val());
            formData.append('name_password', $('[name=name_password]').val());
            // отослать
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/authorizationScript.php", false);
            xhr.overrideMimeType("text/plain; charset=utf8");
            xhr.send(formData);
			location.reload();
			if(xhr.responseText=="authorized")
			{
				//console.log('user aвторизирован:') ;
				location.reload();
			}
			else if(xhr.responseText!="unauthorized")
			{
				var main_cont =  document.getElementById("main_cont");
				main_cont.innerHTML = xhr.responseText;
				console.log(' не авторизирован user:') ;
                console.log(xhr.responseText);
			}
        }
		//Авторизоваться можно по нажатию на кнопку
		document.getElementById("authorization").onclick = authorize;
		//а также по нажатию на клавишу Enter
		document.onkeyup = function (e) {
            e = e || window.event;
            if (e.keyCode == 13) {
                authorize();
            }
            return false;
        };

		// выход
		document.getElementById("exit2").onclick = function () {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/authorization.php", false);
            xhr.overrideMimeType("text/plain; charset=utf8");
            var formData = new FormData();
            formData.append('action', 'logout');
            xhr.send(formData);
			location.reload();
        };
	</script>
