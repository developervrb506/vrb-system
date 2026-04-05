<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("line_blocker")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?

if($_POST['agent_id'] == ""){
  $action = 'new';	
} else {
  $action = 'edit';	
}

if($_GET['action'] == 'delete'){

	$action = "delete";
	$id_agent	=  $_GET['id_agent'];
	$only = 0;
 	 if(isset($_GET['only'])){
      $only = 1;
     }
}

if($_GET['action'] == 'players'){ 
   $action = 'players'; 
    $id_agent  = param('id_agent');


 }

if($action != "delete" && $action !='players'){

$leagues = explode(",",$_POST['leagues']);
$str_info = "";
foreach($leagues as $le){
  if(isset($_POST[$le])){
    $str_info .= $le.','.$_POST[$le."_limit"].",".$_POST[$le."_expire"].",".$_POST[$le."_hours"]."__";
  }

}
  $str_info = rtrim($str_info,"__");
 
  $only = 0;
 if(isset($_POST['only'])){
   $only = 1;
 }


 $id_agent	= param('agent_id');
 $name = $_POST['agent_name'];

}


  $data = "?info=".$str_info."&id_agent=".$id_agent."&agent=".$name."&only=".$only."&action=".$action."&players=".$_POST['str_players'];

/*
 if($action != 'players'  ){
   echo "http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_money_line_blocker_action_sport.php".$data;
   exit;
 }*/

 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_money_line_blocker_action_sport.php".$data);

 if($action != 'players'  ){
    header("Location: ../../agent_money_line_blocker_sport.php?s=1");
}


?>
