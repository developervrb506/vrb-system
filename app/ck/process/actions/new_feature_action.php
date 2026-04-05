<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("new_features")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$id = param('id');
$type = param('type');
$title = param('title');

//echo "...".$type;

if ($type == 'newEdit'){
   
	//variables
	$description  = htmlentities($_POST["content"], ENT_QUOTES);
	$f_type  = param('f_type');
	$sub_title  = htmlentities($_POST["sub_title"], ENT_QUOTES);
	$image  = $_POST["image"];
	
	
	//logic
	$status = 0;
	if (isset($_POST["active"])) { $status = 1; }
	
	$edit = false;
	if ($id){
    	$edit = true;
	}
	
	
	
	if (!$edit){ // ADD NEW POST
	
		$feature = new _new_feature();
		$feature->vars["type"] = $f_type;
		$feature->vars["description"] = $description;
		$feature->vars["date"] = date("Y-m-d H:i:s");
		$feature->vars["active"] = $status;	
		$feature->vars["title"] = $title;	
		$feature->insert();
	
	}
	else { // UPDATE POST	
	
		$feature = get_new_feature($id);
		$feature->vars["type"] = $f_type;
		$feature->vars["description"] = $description;
		$feature->vars["date"] = date("Y-m-d H:i:s");
		$feature->vars["active"] = $status;	
		$feature->vars["title"] = $title;				
		$feature->update();
		
	}
	
	
	if ($edit){ $action = 'u'; }
	else { $action = 'a'; }
	
	header("Location: http://localhost:8080/ck/new_feature.php?type=".$f_type);
		
	
	
}
else {
	$feature = get_new_feature($id);
	if(!is_null($feature)){
		
		if ($type == "delete"){
			$feature->delete();
		?>
		<script type="text/javascript">alert("Entry has been Deleted");</script>
		<?
		}
		else if ($type == "status"){
		   
			switch ($feature->vars["active"]) {
			  case "1":
				$status_id = "0";
				
				  
			  break;
			  case "0":
				$status_id = "1";
				   
			  break;		      
			}		
			
			$feature->vars["active"] = $status_id;
			$feature->update(array("active"));
			?>
			<script type="text/javascript">alert("Status has been Updated");</script>
			<?
			
		}
	}

}
?>
