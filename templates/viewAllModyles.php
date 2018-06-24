<h1>Список установленных модулей</h1>
<form enctype="multipart/form-data" method="post" id="form_del">
<ul><?
                $config = include (__DIR__.'/../config.php');
                // MySQL host
                $mysql_host = $config['host'];
                // MySQL username
                $mysql_username = $config['user'];
                // MySQL password
                $mysql_password = $config['password'];
                // Database name
                $mysql_database = $config['dbname'];
				$mysqli = mysqli_connect($mysql_host, $mysql_username,$mysql_password,$mysql_database);
				$sql="SELECT * FROM modules";
				$result = mysqli_query($mysqli,$sql);
		        if($result) {
					
			        for($i = 0; $i < mysqli_num_rows($result);$i++) {
				        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				        echo '<li><input name='.$row['name'].' type="checkbox">'.$row['title'].'</li>';
			        }
				}
?></ul>
    <input type="button" id="delete" value="Удалить"><div class="progress-bar">
    <span class="progress-bar-fill" style="width: 30%"></span></div>
</form>
<form enctype="multipart/form-data" method="post" action="templates/module_installer.php" id="form_file"><p>Установите модуль на сервер</p>
<p><input type="file" name="file" id="file" accept="application/zip">
<input type="button" id="send" value="Установить"><div class="progress-bar">
<span class="progress-bar-fill" style="width: 30%"></span></div>
</p></form>
<div>Контрольная сумма:<div id="sha256sum"></div>
<script>
document.getElementById("send").onclick=function() {
	              set_completed_handler(3000);
                 var formData=new FormData(document.getElementById("form_file"));
			     var xhr = new XMLHttpRequest();
                 xhr.open("POST", "/handlers/module_installer.php");
				 formData.append("mode","install");
                 xhr.send(formData);
				 var result=xhr.responseText;
				 location.reload();
			 };

document.getElementById("delete").onclick=function() {
                 set_completed_handler(3000);
                 var formData=new FormData(document.getElementById("form_del"));
			     var xhr = new XMLHttpRequest();
                 xhr.open("POST", "/handlers/module_installer.php");
				 formData.append("mode","remove");
                 xhr.send(formData);
				 var result=xhr.responseText;
				 location.reload();
			 };
			 
function sha256() {
                 var formData=new FormData(document.getElementById("form_file"));
			     var xhr = new XMLHttpRequest();
                 xhr.open("POST", "/handlers/sha256.php",false);
                 xhr.send(formData);
				 document.getElementById("sha256sum").innerHTML=xhr.responseText;
};
document.getElementById("file").addEventListener('change',sha256);
</script>