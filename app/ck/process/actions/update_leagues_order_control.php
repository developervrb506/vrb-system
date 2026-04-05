<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("new_features")){ ?>
<?
$leagues = get_leagues();

foreach( $leagues as $row ){	
			
	$id = $_POST["record_id_".$row->vars["id"]];	
		
	$position = $_POST["position_".$id];    
    $available = $_POST["available_".$id];
	
	if($available){
		$available = 1;
	}else{
		$available = 0;
	}
	
    $default_line_type = $_POST["default_line_type_".$id];
	
    $default_league = $_POST["default_league_hidden_".$id];	
	
	$league = get_league($id);
			
    $league->vars["pos"] = $position;
    $league->vars["available"] = $available;
    $league->vars["default_line_type"] = $default_line_type;
    $league->vars["default_league"] = $default_league;					
    $result = $league->update(array("pos","available","default_line_type","default_league"));
	
	if(!$result){
		$error = 1;
	}else{
		$error = 2;
	}
		
}

header('Location: /ck/widget_manager/leagues.php?error='.$error);
exit;
?>
<? }else{echo "Access Denied";} ?>