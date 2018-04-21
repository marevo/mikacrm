<?require_once ('./head.php')?>
<script>
var selectedId;
function activate (id/*,handler*/) {
	document.getElementById(id).style.fontWeight='bold';
	if(selectedId!=null)
	{
	    document.getElementById(selectedId).style.fontWeight='normal';
	}
	selectedId=id;
	var element=document.getElementById(id);
	var parent=element.parentElement;
	var children = parent.children;
	for (var i = 0; i < children.length; i++) {
        var grandchildren = children[i].children;
		
		for(var j=0;j<grandchildren.length;j++) {
			var grandchild=grandchildren[j];
			if(grandchild.tagName==="UL"&&children[i].id!='<? echo $_GET['menu'] ?>'){
			    grandchild.style.display="none";
			}
		}
	}
	var elementChildren=element.children;
	for (var i = 0; i < elementChildren.length; i++) {
		var child=elementChildren[i];
		child.style.display="block";
	}
}
</script>
<?
    function get_menu(){
		$mysql_host = 'localhost';
        // MySQL username
        $mysql_username = 'root';
		$mysql_database = 'reclam';
		$mysql_password = NULL;
		$sql="SELECT * FROM menu";
		$mysqli = mysqli_connect($mysql_host, $mysql_username,$mysql_password,$mysql_database);
		$result = mysqli_query($mysqli,$sql);
		if(!$result) {
			return NULL;
		}
		$arr_cat = array();
		if(mysqli_num_rows($result) != 0) {
			for($i = 0; $i < mysqli_num_rows($result);$i++) {
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				if(empty($arr_cat[$row['parent_id']])) {
					$arr_cat[$row['parent_id']] = array();
				}
				$arr_cat[$row['parent_id']][] = $row;
			}
			return $arr_cat;
		}
	}
	//отображение меню
	function view_menu($arr,$parent_id = 0,$hide = true,$level=0) {
		if(empty($arr[$parent_id])) {
			return;
		}
		$padding=15*$level;
		$hidden=' style="padding-left:'.$padding.'px"';
		$show_parents=false;
		if($parent_id>0&&$hide){
			$hidden=' style="display:none; padding-left:'.$padding.'px"';	
		}
		$ul_id="ul".rand();
		
		echo "<ul".$hidden." id=".$ul_id.">\n";
		
		for($i = 0; $i < count($arr[$parent_id]);$i++) {
			$id=$parent_id . "sub" . $i;
	$bold="";
	if($id==$_GET['menu'])
	{
		$bold=" style='font-weight:bold'";
	}
	echo "<li id='".$id."'".$bold."><a  href=index.php?page=".$arr[$parent_id][$i]['title']."&menu=".$id.">\n"; // onclick="activate(\''.$id.'\')"
	echo "<span class='".$arr[$parent_id][$i]['image']."' ></span>".$arr[$parent_id][$i]['title']."</a>\n";
			if($id==$_GET['menu'])
			{
			    $show_parents=true;
				view_menu($arr,$arr[$parent_id][$i]['id'],false,$level+1);
			}
		    else
			{
				$show_parents=view_menu($arr,$arr[$parent_id][$i]['id'],true,$level+1);
			}
			echo "</li>\n";
			
		}
		echo "</ul>\n";
		if($show_parents)
		{
			echo "<script>\n";
			echo "document.getElementById('".$ul_id."').style='display:block;padding-left:".$padding."px'\n";
			echo "</script>\n";
		}
		return $show_parents;
	}
	function get_handler_by_menu_title($title){
		$mysql_host = 'localhost';
        // MySQL username
        $mysql_username = 'root';
		$mysql_database = 'reclam';
		$mysql_password = NULL;
		$sql="SELECT handler FROM menu WHERE title='".$title."';";
		$mysqli = mysqli_connect($mysql_host, $mysql_username,$mysql_password,$mysql_database);
//		mysql_select_db($mysql_database);
		$result = mysqli_query($mysqli,$sql);
		if(!$result) {
			return NULL;
		}
	    $row = mysqli_fetch_row($result);

		//return($row['handler']);
		//return $sql;
		return $row[0];
	}
?>