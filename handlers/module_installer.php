<?
/*if($_POST["sql"])
{
//	$command = "mysql -uroot -D reclama < {$_FILES['sql']['tmp_name']}";
//	$message = shell_exec($command);
//    $mysqli = mysqli_connect("localhost", "root", NULL, "reclama");
//	mysqli_multi_query($mysqli,$_POST["sql"]);
//	file_put_contents("reclama_debug.log",$_POST["sql"]);
    
}
*/
// Выполнение SQL запросов, записанных в файл
function execute_sql($filename,$mysqli)
{
                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $lines = file("./" . $filename);
                file_put_contents("reclama_debug.log",error_get_last());
                // Loop through each line
                foreach ($lines as $line)
                {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;

                    // Add this line to the current segment
                    $templine .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';')
                    {
                        // Perform the query
                        mysqli_query($mysqli,$templine) or file_put_contents("reclama_debug.log",'Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
}
function my_sql_connect($config)
{
	// MySQL host
    $mysql_host = $config['host'];
   // MySQL username
   $mysql_username = $config['user'];
   // MySQL password
   $mysql_password = $config['password'];
   // Database name
   $mysql_database = $config['dbname'];

   // Connect to MySQL server
   $mysqli = mysqli_connect($mysql_host, $mysql_username,$mysql_password,$mysql_database) or file_put_contents("reclama_debug.log",'Error connecting to MySQL server: ' . mysql_error());
   return $mysqli;
}
//Функция рекурсивного удаления заданной директории
function deleteDirectory($dir) {
	// Достигнут лист дерева директорий - возврат из тупиковой ветки рекурсивных функций
    if (!file_exists($dir)) {
        return true;
    }
    // Удаление файла
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    // Проход по всем файлам и директориям внутри текущей директории
    foreach (scandir($dir) as $item) {
		// Пропуск текущей и родительской директории
        if ($item == '.' || $item == '..') {
            continue;
        }
        // Рекурсивный вызов функции удаления директории
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }
    // Удаление пустой директории
    return rmdir($dir);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Подключение файла настроек соединения с базой данных
$config = include (__DIR__.'/../config.php');
//Обработчик установки модуля
if($_POST['mode']=='install')
{
	//Распаковка ZIP архива с уствановочным модулем
   $zip = new ZipArchive;
   if ($zip->open($_FILES['file']['tmp_name']) === TRUE) {
    $zip->extractTo('../tmp');
    $zip->close();
	//Инструкиции для установки модуля берутся из файла installer.ins
	chdir("../tmp");
	$handle = @fopen("installer.ins", "r");
	echo "extracted";
	if ($handle) {
		echo "handled";
		//Чтение файла построчно
        while (($buffer = fgets($handle)) !== false) {
            $params=explode("=",$buffer);
			//Параметр 'SQL' указывает путь к файлу с запросами SQL
			if($params[0]=='SQL')
			{
				
				$filename=trim($params[1]);
				$mysqli=my_sql_connect($config);
				//Выполнение запросов из указанного файла с использованием пользовательской функции execute_sql
                execute_sql($filename,$mysqli);
				mysqli_close($mysqli);
			}
			//Параметр 'DIR' указывает имя корневой директории устанавливаемого модуля в директории modules
			else if($params[0]=='DIR')
			{
				$dirname=trim($params[1]);
				$module_root="../modules/" . $dirname;
				rename($dirname,$module_root);
			}
        }
        fclose($handle);
    }
   }
}
//Удаление модулей
else if($_POST['mode']=='remove') 
{
	    
		chdir("../modules");
		//Подключение к базе данных
		$mysqli=my_sql_connect($config);
		//Проход по списку параметров POST
		foreach($_POST as $key => $value)
		{
			//Пропуск параметра mode
			if($key!='mode')
			{
				//Получение сведений об удаляемом модуле
				$sql="SELECT * FROM modules WHERE name='".$key."'";
				$result = mysqli_query($mysqli,$sql);
				$row = $result->fetch_assoc();
				//Выполнение запросов на удаление модуля
				execute_sql($row["dir"]."/".$row["unsql"],$mysqli);
				//Удаление директории модуля
				deleteDirectory($row["dir"]);
            }
		}
		
}

	
?>