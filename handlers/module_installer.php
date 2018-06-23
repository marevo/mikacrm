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
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$config = include (__DIR__.'/../config.php');
if($_POST['mode']=='install')
{
   $zip = new ZipArchive;
   if ($zip->open($_FILES['file']['tmp_name']) === TRUE) {
    $zip->extractTo('../tmp');
    $zip->close();
	chdir("../tmp");
	$handle = @fopen("installer.ins", "r");
	echo "extracted";
	if ($handle) {
		echo "handled";
        while (($buffer = fgets($handle)) !== false) {
            $params=explode("=",$buffer);
			if($params[0]=='SQL')
			{
				
				$filename=trim($params[1]);
				$mysqli=my_sql_connect($config);
                execute_sql($filename,$mysqli);
				mysqli_close($mysqli);
			}
			else if($params[0]=='DIR')
			{
				$dirname=trim($params[1]);
				$module_root="../modules/" . $dirname;
				rename($dirname,$module_root);
				//mkdir($module_root);
				//copy("installer.ins",$module_root."/installer.ins");
			}
/*			else if($params[0]=='NAME')
			{
				copy("installer.ins","../modules/" . $params[1]);
			}
			else 
			{
				$filename=trim($params[1]);
				rename($filename,"../modules/" . $filename);
			}
*/
        }
        fclose($handle);
    }
	//rmdir('../tmp/*');
   }
}
else if($_POST['mode']=='remove') 
{
	    
		chdir("../modules");
		$mysqli=my_sql_connect($config);
		foreach($_POST as $key => $value)
		{
			if($key!='mode')
			{
				$sql="SELECT * FROM modules WHERE name='".$key."'";
				$result = mysqli_query($mysqli,$sql);
				$row = $result->fetch_assoc();
				execute_sql($row["dir"]."/".$row["unsql"],$mysqli);
				deleteDirectory($row["dir"]);
            }
		}
		
}

	
?>