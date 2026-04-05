<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?

$login = 0;

$s_from =  $_GET["from"];
$s_to =  $_GET["to"];
$s_queue =  $_GET["queue"];
$s_clerk = $_GET["clerk_list"];

/*
$s_from =  "2013-12-05";
$s_to =  "2013-12-05";
$s_queue =  0;
$s_clerk = 0;
*/

$calls = array();
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
             ///this used obsolet funciton +
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
  <? $aff = array(); ?>  
  <? foreach($calls as $call){
	  $str_login = str_center("Local/","@",$call->vars["dstchannel"]); 
  ?>
  <? if (isset($names[$call->vars["src"]]->vars["acc_number"]) && ($names[$call->vars["src"]]->vars["acc_number"] != "") ){
	 if (!isset($aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent])) {
		 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"] = 1;
	     $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Name"] = $affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Name;  
			 $aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["aff"] = trim($affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent);
		  }
		  else {
			$aff[$affiliates->{strtoupper($names[$call->vars["src"]]->vars["acc_number"])}->vars->Agent]["Total"]++;			 		  }
	  } ?>

  
  <? } ?>

<?


if (count($account)>0){ ?>



<a style="display:block" id="a_link" href="javascript:display_div('aff_div')" class="normal_link" title="Click to open the Total for Affiliates" >Affiliate Total Calls </a> 
<div  id="aff_div" class="form_box" style="width:300px; display:none">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">AFF</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Total</td>    
   </tr> 

 <?
	foreach ($aff as $_aff){ 
	 if($i % 2){ $style = "1";}else{$style = "2";}$i++;
	
	 if ($_aff["aff"] != "") {
	?>
     <td class="table_td<? echo $style ?>" align="center"><? echo $_aff["aff"]; ?> </td>
     <td class="table_td<? echo $style ?>" align="center"><? echo $_aff["Name"]; ?> </td>     
     <td class="table_td<? echo $style ?>" align="center"><? echo $_aff["Total"]; ?> </td>          
	 </tr>
    <? } ?> 
   <? } ?>
    <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
   
  </tr>
</table>
    	
</div>        
 <? }  

 }

?>