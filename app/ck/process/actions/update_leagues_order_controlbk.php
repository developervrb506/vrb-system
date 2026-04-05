<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("new_features")){ ?>
<?
$id = $_POST["id"];
$position = $_POST["position"];
$type = $_POST["type"];
$available = $_POST["available"];
$default_line_type = $_POST["default_line_type"];
$default_league = $_POST["default_league"];

$leagues = get_leagues(1);

foreach($leagues as $row){	
   $id_league = $row->vars["id"];
   $league = get_league($id_league,$type);  
   $league->vars["default_league"] = 0;   
   $league->update(array("default_league"));
}

$league = get_league($id,$type);
$league->vars["pos"] = $position;
$league->vars["available"] = $available;
$league->vars["default_line_type"] = $default_line_type;
$league->vars["default_league"] = $default_league;					
$league->update(array("pos","available","default_line_type","default_league"));
?>
<? }else{echo "Access Denied";} ?>