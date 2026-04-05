<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("props_system")) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<title>Props System</title>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
	
function review_alert(id){
	   
	    if(document.getElementById("comment_"+id).value == '') {
		   alert('Please add a Comment First');  
		  
		} else {
			//document.getElementById('id').value = document.getElementById('id_'+id).value;
			//document.getElementById('comment').value = document.getElementById('comment_'+id).value;
			document.getElementById('Form_'+id).submit();
	 	}
	  
	  
	   // document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/alert_props_action.php?id="+id;
		//document.location = "http://localhost:8080/ck/process/actions/alert_props_action.php?id="+id;
		//document.getElementById("td_"+id).innerHTML = "Reviewed";
	
}	
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<span class="page_title">Props Alerts</span><br /><br />
<? include "includes/print_error.php" ?>  

    
<?
$clerks =  get_all_clerks_index(1,  "1,3", false,true,"id");
echo "<pre>";
//print_r($clerks);
echo "</pre>";
$types =  get_props_alerts_types();
if(!isset($_POST["from"])) {
  $alerts = get_pending_props_alerts();	
  $from = date("Y-m-d");
  $to = date("Y-m-d");	
  
}  else{
  $from = $_POST["from"];
  $to = $_POST["to"];  	
  $league = $_POST["league"];  
  $type = $_POST["type"];  
  $alerts = get_props_alerts($from,$to,$league,$type);
 
}


?>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>


<form action="" method="post">
 From: <input id="from" name="from" value="<? echo $from ?>">&nbsp;&nbsp;&nbsp;
 To:  <input id="to" name="to" value="<? echo $to ?>"> &nbsp;&nbsp;&nbsp;
 League: <select id="league" name="league">
         <option value="0">All</option>   
         <option value="nba" <? if($league == "nba") { echo ' selected="selected" '; }?>>NBA</option>            
         <option value="nhl" <? if($league == "nhl") { echo ' selected="selected" '; }?>>NHL</option>                     
         <option value="nfl" <? if($league == "nfl") { echo ' selected="selected" '; }?>>NFL</option>                              
         <option value="mlb" <? if($league == "mlb") { echo ' selected="selected" '; }?>>MLB</option>                              
         </select> &nbsp;&nbsp;&nbsp;
Type : <select id="type" name="type">
		<option value="0">All</option>
        <? foreach($types as $tp){ ?>
			<option value="<? echo $tp->vars["type"] ?>" <? if($type == $tp->vars["type"]) { echo ' selected="selected" '; }?>><? echo $tp->vars["type"] ?></option>
		<? }?>
        </select>&nbsp;&nbsp;&nbsp;
        <input type="submit" value="Search">
</form>
<BR><BR>

     
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">league</td>
        <td class="table_header" align="center">type</td>
        <td class="table_header" align="center">Description</td>
        <td class="table_header" align="center">Comment</td>
        <td class="table_header" align="center" style="width: 150px;"></td>
         <td class="table_header" align="center"></td>         
      </tr>
      <?
	  $i=0;	   
	   foreach($alerts as $alert){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
		  
	  ?>
      <tr id="tr_<? echo $alert->vars["id"]?>">
        <td class="table_td<? echo $style ?>" align="center"><? echo $alert->vars["date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo strtoupper($alert->vars["league"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $alert->vars["type"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $alert->vars["description"]; ?></td>
	    <td class="table_td<? echo $style ?>" align="center">
        <form method="post" id="Form_<? echo $i ?>" action="process/actions/alert_props_action.php">
       
        <input type="hidden"  name="id" id="id" value="<? echo $alert->vars["id"]; ?>">
         <input type="hidden" name="comment" id="comment" value="<? echo $alert->vars["id"]; ?>">
        <textarea <? if ($alert->vars["reviewed"]){?>  disabled="disabled" <? } ?> id="comment_<? echo $i ?>" name="comment" rows="5" cols="20" ><? echo $alert->vars["comment"]; ?></textarea></td>          
        <td id="td_<? echo $alert->vars["id"]?>" class="table_td<? echo $style ?>" align="center"><? if (!$alert->vars["reviewed"]){?><input type="button" value="Review" onclick="if(confirm('Do you want to mark this alert as Reviewed')){
		review_alert('<? echo $i ?>')}"> <? } else {
			$to_time = strtotime($alert->vars["reviewed_date"]);
			$from_time = strtotime($alert->vars["date"]);
			$elapsed =  round(abs($to_time - $from_time) / 60,2);
			if($alert->vars["reviewed_date"] == ""){ $elapsed = "N/A"; }
			
			 ?>
        
         <div class="error">
                        Reviewed<br />
                          By <? echo $clerks[$alert->vars["reviewed"]] ->vars["name"]; ?><br />
								<? echo $alert->vars["reviewed_date"]; ?><br /> 
                                Elapsed TIme: 
                                <? echo $elapsed. " minutes"; ?>
              </div>
        
         <? }; ?></td>
       </form>
        <td class="table_td<? echo $style ?>" align="center"><a class="normal_link" target="_blank" href="http://www.espn.com/<? echo $alert->vars["league"] ?>/boxscore?gameId=<? echo $alert->vars["espn_id"]?>">Boxscore</a></td>        
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
	   <td class="table_last"></td>   
	   <td class="table_last"></td>    
       <td class="table_last"></td>             
      </tr>
  
    </table>
    <? // }else{echo "No Solved Issues";} ?>


</div>
<? include "../includes/footer.php" ?>

<? } else { echo "ACCESS DENIED"; }?>

