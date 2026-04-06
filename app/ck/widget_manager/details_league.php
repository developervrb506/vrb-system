<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
</head>
<body>
<?
  //echo "<pre>";
 // print_r($_POST);
 // echo "</pre>";

 $leagues = get_all_event_leagues();
 $league = trim($_POST["league"]); 
 $types = array("spread","money","total");
 $value["spread"]= "s";
 $value["money"]= "m";
 $value["total"]= "t";
 $league_details = get_event_league_details($league);
 $matchups = 0;
 
 
  if (isset($_POST["total_p"])){
	
	$str="";
	$strPtype = "";
	for ($x=1;$x<=$_POST["total_p"]; $x++){
	
	   if (isset($_POST["period_".$x])){ 
	   
	      $str .= $x.","; 
	      $strPtype .= "__".$x."_";
		   for ($l = 0; $l< 3;$l++){
			   switch ($l){
				 case 0 : $lt = "s"; break;
 				 case 1 : $lt = "m"; break;  
				 case 2 : $lt = "t"; break;				   
			   }
			 
		   	 if (isset($_POST[$x."_".$lt])){  
			    $strPtype .= $lt;
			 
			 }
			}
		  
	   }	
		
	}
	
	$str = substr($str,0,-1);
	echo $str;
	$str_type = "";
	foreach($types as $t){
		
	  if (isset($_POST[$t])) { $str_type .= $value[$_POST[$t]]; }
	}
	
	if (isset($_POST["default_type"])){
		$str_type = $value[$_POST["default_type"]].$str_type;
	}
	if (isset($_POST["matchups"])){
	 $matchups = 1;   
	}
	
	if(is_null($league_details)){
		
		$league_details = new _event_leagues_details();
		$league_details->vars["league"]= $league;
		$league_details->vars["periods"]= $str;
		$league_details->vars["period_type"]= $strPtype;
		$league_details->vars["type"] = $str_type;
		$league_details->vars["matchups"] = $matchups;
		$league_details->insert();
		
	}else{
		$league_details->vars["periods"]= $str;
		$league_details->vars["matchups"] = $matchups;
		$league_details->vars["period_type"]= $strPtype;
		$league_details->vars["type"] = $str_type;
		$league_details->update(array("periods","period_type","type","matchups"));
	}
    
	//print_r($league_details);
	?><script> alert("Data Saved");</script><? 	
	  
  }
$str_type = $league_details->vars["type"];
?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Details League <? echo $league ?></span><br /><br />
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>
<form action="" method="post" >
 
 
 League : 
 <select name ="league" onchange="this.form.submit()" >
  <option value ="">Select a League</option>
  <? foreach ($leagues as $le) {?>
     <option <? if ($league == trim($le->vars["league"]) ) { echo ' selected="selected" '; }?> value="<? echo trim($le->vars["league"])?> "><? echo $le->vars["league"]?></option>
  <? } ?>
  
  </select>
 </form>
 
 <?
 if ($_POST["league"] != ""){
 
 $ptype = explode("__",$league_details->vars["period_type"]);
 array_shift($ptype);
 
 $petypes = array();
   foreach ($ptype as $pt){
	   
	 $pp =   explode("_",$pt);  
	 $petypes[$pp[0]] =$pp[1];
   
   }
 
 
 /*
 echo "<pre>";
 print_r($petypes);
 echo "</pre>";
 */
 $periods = explode(",",$league_details->vars["periods"]);
 $period = array();
 
  if (!empty($periods)){
	foreach( $periods as $pe){
	  $period[$pe] = $pe;	
		
	}  
	  
  }
 

  
  
 $periods = get_all_event_periods();


 $actual = get_event_period_history($league, false);
 $history = get_event_period_history($league,true);
 
 $spread = get_event_line_type_total($league,"spread",false);
 $history_spread = get_event_line_type_total($league,"spread",true);
 $money = get_event_line_type_total($league,"money",false);
 $history_money = get_event_line_type_total($league,"money",true);
 $total = get_event_line_type_total($league,"total",false);
 $history_total = get_event_line_type_total($league,"total",true);
 
 $value["spread"]= "s";
 $value["money"]= "m";
 $value["total"]= "t";
 

 
 $actual_types = array_merge($spread,$total,$money);
 $actual_type = array();
 foreach ($actual_types as $at){
	$actual_type[$at["type"]] = $at;
 }

 $history_types = array_merge($history_spread,$history_total,$history_money);
 $history_type = array();
 foreach ($history_types as $ht){
	$history_type[$ht["type"]] = $ht;
 }
 
  
 ?>
 <form method="post" >
 <input type="hidden" name="league" value="<? echo $league ?>" />
 <input type="hidden" name="total_p" value="<? echo count($periods); ?>" />
 <BR>
 
  <?

  
  

  
  ?> 
 
 <table id="" width="60%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">SHOW</td> 
			<td width="100"  class="table_header" align="center" >Period</td>
            <td width="100"  class="table_header" align="center" ></td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Period has lines for this League">Actual Lines</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Period had lines in last events ">History Lines</td>
            <td  name ="game_info_" width="80"  align="center"class="table_header">Last History Date</td>
		 </tr>  
		 
		  <? foreach ($periods as $pe) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <input  <? if($pe["id"] == $period[$pe["id"]]) { echo ' checked="checked" ';} ?> style="width:80px; height:25px" type="checkbox" name="period_<? echo $pe["id"]?>" value="<? echo $pe["id"]?>" />
               </td>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;">
			  <? echo $pe["display_name"];
			   if ($pe["display_name"] == "Game" ){ ?>
               <BR> (Matchups) <input  title="Check to Display Matchups name"  <? if($league_details->vars["matchups"]) { echo ' checked="checked" ';} ?>  style="width:20px; height:15px" type="checkbox" name="matchups" value="matchups" /> 
               <? }
			  ?>
              </td> 
               <td align="left" class="table_td<? echo $style ?>" style="font-size:12px;">
                <input  title="Check to use this type on this period"  <? if(contains_ck($petypes[$pe["id"]],"s")) { echo ' checked="checked" ';} ?>  style="width:20px; height:15px" type="checkbox" name="<? echo $pe["id"]?>_s" value="s" /> Spread <BR>
                 <input  title="Check to use this type on this period"  <? if(contains_ck($petypes[$pe["id"]],"m")) { echo ' checked="checked" ';} ?>  style="width:20px; height:15px" type="checkbox" name="<? echo $pe["id"]?>_m" value="m" /> Money <BR>
                  <input  title="Check to use this type on this period"  <? if(contains_ck($petypes[$pe["id"]],"t")){ echo ' checked="checked" ';} ?>  style="width:20px; height:15px" type="checkbox" name="<? echo $pe["id"]?>_t" value="t" /> Total <BR>
               </td>
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
               <? if (isset($actual[$pe["id"]])) {  ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
              
              </td> 
               <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
                <? if (isset($history[$pe["id"]])) {  ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
                </td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $history[$pe["id"]]["line_date"]?></td> 

  <? } ?>
		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        
        <BR><BR>
               
        <table id="" width="60%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">SHOW</td> 
			<td width="100"  class="table_header" align="center" >Type</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Type has lines for this League">Actual Lines</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Type had lines in last events ">History Lines</td>
            <td  name ="game_info_" width="80"  align="center"class="table_header">Last History Date</td>
		 </tr>  
		 
          <? foreach ($types as $type) { ?>
          <tr>
         <td class="table_td1" style="font-size:12px;">
               <input  <? if(contains_ck($str_type,$value[$type])) { echo ' checked="checked" ';} ?> style="width:80px; height:25px" type="checkbox" name="<? echo $type ?>" value="<? echo $type ?>" />
               </td>
          <td align="center" class="table_td1" style="font-size:12px;">
		  <input  <? if($league_details->vars["type"][0] == $type[0]) { echo ' checked="checked" ';} ?>  title="Set as Default" type="radio" name="default_type" value="<? echo $type ?>">
		  <? echo strtoupper($type) ?>
          
          </td>
           <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
               <? if ($actual_type[$type]["total"] > 0) {  ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
              
              </td> 
               <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
                <? if ($history_type[$type]["total"] > 0) { ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
                </td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $history_type[$type]["line_date"]?></td>  
              </tr> 
            <? } ?> 
            <tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
            
          </table> 
          
         <BR><BR>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input style="width:140px; height:35px" type="submit" value="Save Changes"><BR><BR><BR>     
    </form >            
 <? } ?>
</div>
<? include "../../includes/footer.php" ?>