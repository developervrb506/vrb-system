<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?

$conn_id = ftp_audio_conecction(); // Open Ftp Conection.
//$all_option = true;
//$names_per_page = 50;
//$page_index =  $_POST["page_index"];

$login = 0;
/*
$s_from =  $_GET["from"];
$s_to =  $_GET["to"];
$s_queue =  $_GET["queue"];
$s_clerk = $_GET["clerk_list"];
*/
$s_from =  "2013-12-05";
$s_to =  "2013-12-05";
$s_queue =  0;
$s_clerk = 0;




$calls = array();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
var str_html = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td class='table_header'align='center'>AFF</td><td class='table_header' align='center'>Name</td><td class='table_header' align='center'>Total</td></tr>";

function print_aff(aff,cant,name,style){
	
	
	if (style == 1) {
		str_html = str_html.concat('<tr><td class="table_td1" align="center">'+aff+'</td>'+'<td class="table_td1" align="center">'+name+'</td>'+'<td class="table_td1" align="center">'+cant+'</td></tr>');
	}
	else {
		str_html = str_html.concat('<tr><td class="table_td2" align="center">'+aff+'</td>'+'<td class="table_td2" align="center">'+name+'</td>'+'<td class="table_td2" align="center">'+cant+'</td></tr>');
	}

}

function show_aff_table(){

str_html =	 str_html.concat("</table>");

document.getElementById("aff_div").innerHTML = str_html;
document.getElementById("a_link").style.display = "block";
}
</script>

</head>
<body>
<div class="page_content" style="padding-left:20px;">
<a style="display:none" id="a_link" href="javascript:display_div('aff_div')" class="normal_link" title="Click to open the Total for Affiliates" >Affiliate Total Calls </a> 
<div  id="aff_div" class="form_box" style="width:300px; display:block">
</div>
<br/><br/>

<? 

$no_login = false;
if ($s_clerk != 0){ 
  $clerk_logins = get_all_clerk_phone_logins($s_clerk);
  $login = array();
  $k = 0;

 foreach ($clerk_logins as $clerk_login){
   $login[$k] = $clerk_login->vars["login"]; 
  $k++;
 }

 if (count($login)==0) { 
   $no_login = true;
   $login =0;
 }
}
  
if ($no_login){
  echo "This Clerk does not have any Login asigned";
}
else {
 
 $count_calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,$page_index,$names_per_page,false,true); 
 $calls = get_call_by_queue($login,$s_queue,$s_from, $s_to,0,0,false,false); 


$str_phone = "";
$str_player = "";
$account = array();

foreach($calls as $call){
  $str_phone .= "'".$call->vars["src"]."',";	
}
$str_phone = substr($str_phone,0,-1);

$names = get_names_by_phone_list($str_phone);
$clerks = get_all_clerks_phone_login();
  

foreach($calls as $call){
	foreach ($names as $name){
	 
	  if (isset($names[$call->vars["src"]]->vars["acc_number"])){
		  $names[$call->vars["src"]]->vars["acc_number"] = strtoupper($names[$call->vars["src"]]->vars["acc_number"]);
		 			 
			 if (!isset($account[$name->vars["acc_number"]])){
			   $account[$name->vars["acc_number"]] = $name->vars["acc_number"]; 
			   }
	  }
	}
}
if (count($account)>0){

foreach ($account as $_account){
  if ($_account != ""){
    $str_player .= "'".trim(strtoupper($_account))."',";	
  }
}
$str_player = substr($str_player,0,-1);


$data = "?str_player=$str_player";
$affiliates = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_players_by_list.php".$data));
}

?>

<? echo $count_calls[0]->vars["num"]." Calls Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Account</td>    
    <td class="table_header" align="center">AFF</td>        
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Queue</td>
    <td class="table_header" align="center">Duration</td>
    <td class="table_header" align="center">Call</td>
  </tr>
  
  <? $aff = array(); ?>  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $str_login = str_center("Local/","@",$call->vars["dstchannel"]); 
 
	  
	 	  
  ?>
  
  <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo date("M jS, Y / g:i a",strtotime($call->vars["calldate"])); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
		 <? if (isset($names[$call->vars["src"]])) { ?>
        
         <a href="call_history.php?account_name=<?  echo $names[$call->vars["src"]]->vars["acc_number"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $names[$call->vars["src"]]->full_name() ?> Call History" class="normal_link">
			<? echo $names[$call->vars["src"]]->full_name(); ?>
         </a> 
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo strtoupper($names[$call->vars["src"]]->vars["acc_number"]) ?></td>
    <td class="table_td<? echo $style ?>" align="center">
	<? if (isset($names[$call->vars["src"]]->vars["acc_number"]) && ($names[$call->vars["src"]]->vars["acc_number"] != "") ){
		 echo $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent; 
          if (!isset($aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent])) {
		  	 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"] = 1;
			 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Name"] = $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Name;  
			 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["aff"] = trim($affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent);
		  }
		  else {
			$aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"]++;			  
  
			  }
		 
		 
	  } ?>
    
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["src"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $clerks[$str_login]->vars["name"]; ?> </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["lastdata"]; ?></td>  
    <td class="table_td<? echo $style ?>" align="center"><? echo gmdate("i:s", $call->vars["duration"])?></td> 
       <td class="table_td<? echo $style ?>" align="center">
	
	<? if (check_ftp_audio_exist($call->vars["uniqueid"],$conn_id)){ ?>
        <a href="<?= BASE_URL ?>/ck/audio_box.php?id=<? echo $call->vars["uniqueid"] ?>" class="normal_link" rel="shadowbox;height=150;width=250"> Listen </a>
   <? } ?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  
  </tr>
</table>
<br /><br />



<?

ftp_audio_close($conn_id); // Closing the FTP conection.


 //No login

if (count($account)>0){

	foreach ($aff as $_aff){ 
	
	// if ($_aff["aff"] != ""){
		
	 if($i % 2){ $style = "1";}else{$style = "2";}$i++;
	?>
		<script type="text/javascript">	
		print_aff('<? echo $_aff["aff"] ?>','<? echo $_aff["Total"] ?>','<? echo $_aff["Name"] ?>','<? echo $style ?>');
		</script>
	<? } ?>
	<script type="text/javascript">	
	show_aff_table();
	</script> 

  <? // } ?>
<? } ?>

<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("form_search").submit();
}
</script>
</div>

<? include "../includes/footer.php" ; }








?>