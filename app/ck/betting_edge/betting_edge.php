<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_edge_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<title>The Betting Edge</title>

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
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
</script>
<script type="text/javascript">
<!--

function delete_bet(id){
	if(confirm("Are you sure you want to DELETE this entry from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/insert_betting_edge_action.php?id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
//-->
</script>
</head>

<?
$from = clean_get("from");
$to =  clean_get("to");
if($from == ""){
  $from = date("Y-m-d"); 
  $to = date( "Y-m-d", strtotime( "1 day", strtotime(date( "Y-m-d")))); 
}


?>

<body>

<? // $page_style = " width:1600px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<span class="page_title">The Betting Edge</span><br /><br />
<a href="betting_edge_create.php" class="normal_link" rel="shadowbox;height=270;width=400">Add New</a><br /><br />
<?
 $bets = get_all_external_bets($from,$to);

?>


<form method="post" onsubmit="">

    &nbsp;&nbsp;From:&nbsp;&nbsp; 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
  
      &nbsp;&nbsp;&nbsp;To:&nbsp;&nbsp; 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
      &nbsp;&nbsp;&nbsp;
 
    <input type="submit" value="Search" />
     
 </form>
<BR />

<? if (!empty($bets)) { ?>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center" ><strong>Game Date</strong></td>
    <td class="table_header" align="center" ><strong>Game</strong></td>
    <td class="table_header" align="center" ><strong>League</strong></td>
    <td class="table_header" align="center" ><strong>Period</strong></td>
    <td class="table_header" align="center">Bet Type</td> 
    <td class="table_header" align="center">Line</td>  
    <td class="table_header" align="center">Risk/Win</td> 
     <td class="table_header" align="center"></td> 
     <td class="table_header" align="center"></td>      
        
  </tr>

 <?   foreach( $bets as $bet){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   
   ?>
   <tr id="tr_<? echo $bet->vars["id"] ?>">   	
        <td class="table_td<? echo $style ?>"><? echo $bet->vars["game_date"] ?></td>
		<td class="table_td<? echo $style ?>"><? echo $bet->vars["home"]." VS ".$bet->vars["away"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $bet->vars["league"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $bet->vars["period"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $bet->vars["bet_type"] ?></td>
        <td class="table_td<? echo $style ?>"><? echo $bet->vars["line"] ?></td>
        <td class="table_td<? echo $style ?>">$<? echo $bet->vars["risk"] ?> / $<? echo $bet->vars["win"] ?> </td>
         <td class="table_td<? echo $style ?>"><a class="normal_link" href="<?= BASE_URL ?>/ck/betting_edge/betting_edge_create.php?id=<? echo $bet->vars["id"] ?>">Edit</a></td>  
        <td class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_bet(<? echo $bet->vars["id"] ?>,'delete')">Delete</a>
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
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>    

  </tr>
</table>
<? } else { ?>

&nbsp;&nbsp;&nbsp;&nbsp;<span><strong> There are not Information to show</strong></span>

<? } ?>



</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>