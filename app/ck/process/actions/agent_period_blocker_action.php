<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("line_blocker")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?


/*echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

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


if($action != "delete"){

$leagues = explode(",",$_POST['leagues']);
$str_info = "";
foreach($leagues as $le){
  if(isset($_POST[$le])){
    $str_info .= $le.','.$_POST[$le."_expire"]."__";
  }

}
  $str_info = rtrim($str_info,"__");
 
  $only = 0;
 if(isset($_POST['only'])){
   $only = 1;
 }


 $id_agent	=  $_POST['agent_id'];
 $name = $_POST['agent_name'];

}


  $data = "?info=".$str_info."&id_agent=".$id_agent."&agent=".$name."&only=".$only."&action=".$action;

  //echo "http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_period_blocker_action.php".$data;


 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_period_blocker_action.php".$data);

 header("Location: ../../agent_period_blocker.php?s=1");


?>
