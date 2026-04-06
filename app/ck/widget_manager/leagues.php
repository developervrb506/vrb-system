<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Events leagues</title>
<script type="text/javascript" src="/process/js/functions.js"> </script>
<script type="text/javascript" src="/process/js/jquery.js"> </script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Leagues Manager</span>
<br /><br />
<div id="success_saved"></div>
<br /><br />
<?
$leagues = get_leagues();

$cant_leagues = count($leagues);

if(!is_null($leagues)) { 

$error = $_GET["error"];

if($error == 1){
	$message = "There was a problem saving the information in the database.";
}elseif($error == 2){
	$message = "The leagues information has been saved successfully.";
}
?>

<h3 align="center"><? echo $message; ?></h3>

<form action="/ck/process/actions/update_leagues_order_control.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>    
    <td class="table_header" align="center"><strong>League</strong></th>
    <td class="table_header" align="center"><strong>Sort</strong></th>
    <td class="table_header" align="center"><strong>Active</strong></th>
    <td class="table_header" align="center"><strong>Default</strong></th>     
    <td class="table_header" align="center"><strong>Default Line Type</strong></th>
  </tr>
  
   <?   
   foreach( $leagues as $row ){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   ?>
  <input name="record_id_<? echo $row->vars["id"] ?>" value="<? echo $row->vars["id"] ?>" type="hidden" /> 
  <tr id="tr_<? echo $row->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $row->vars["name"]; ?></th>
        <th class="table_td<? echo $style ?>">		        
         <select class="position" name="position_<? echo $row->vars["id"] ?>" id="position_<? echo $row->vars["id"] ?>" style="width:50px;">
            <? for ($j = 1; $j <= $cant_leagues; $j++){ ?>
            <option <? if ($j == $row->vars["pos"]){ echo "selected"; } ?>  value="<? echo $j; ?>"><? echo $j; ?></option>
    <? } ?>
         </select>                  
         </th>
         <th class="table_td<? echo $style ?>">		        
         <input class="available" name="available_<? echo $row->vars["id"] ?>" id="available_<? echo $row->vars["id"] ?>" type="checkbox" <? if ($row->vars["available"] == 1){ ?>checked="checked" <? } ?> />                
         </th>
         <th class="table_td<? echo $style ?>">		        
         <input onchange="f_check_default_league('<? echo $row->vars["id"] ?>','<? echo $cant_leagues ?>');" class="default_league" name="default_league" id="default_league_<? echo $row->vars["id"] ?>" type="radio" <? if ($row->vars["default_league"] == 1){ ?> checked="checked" <? } ?> value="<? echo $row->vars["default_league"] ?>" /><br />
          <input name="default_league_hidden_<? echo $row->vars["id"] ?>" id="default_league_hidden_<? echo $row->vars["id"] ?>" type="hidden" value="<? echo $row->vars["default_league"] ?>" />              
         </th>
         <th class="table_td<? echo $style ?>">		        
         <select class="default_line_type" name="default_line_type_<? echo $row->vars["id"] ?>" id="default_line_type_<? echo $row->vars["id"] ?>" style="width:90px;"> 
            <option <? if ("" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="">Choose</option>
            <option <? if ("s" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="s">Spread</option>
            <option <? if ("m" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="m">Moneyline</option>
            <option <? if ("t" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="t">Total</option>
         </select>                
         </th>        
  </tr>  
<? } ?>
<br />

 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>      
  </tr>
</table>
<br />
<div align="center"><input name="Save" value="Save" type="submit" /></div>
</form>
 
<BR>
<? } else {

    $html= 'No Data Found';
	echo $html;
} 
?>
</div>
<? include "../../includes/footer.php" ?>

<script>	

function f_check_default_league(id,cant_leagues){
		
	if(document.getElementById("default_league_"+id).checked){
	   document.getElementById("default_league_hidden_"+id).value = 1;
	   
	   for(i=1;i<=cant_leagues;i++){
		  if(i != id){ 
		     document.getElementById("default_league_hidden_"+i).value = 0; 
		  }
	   }	
	}
}

</script>