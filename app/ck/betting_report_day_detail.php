<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$type = $_GET["t"];
$monday = $_GET["date"];
if($_GET["to"] == ""){
 $sunday = date("Y-m-d",strtotime($monday)+518400);
} else {
 $to = $_GET["to"]; 
 $sunday = $to; 
}
$account = get_betting_account($_GET["acc"]);
if($type == "pmts"){
	$pay = true;
	$title = $account->vars["name"] . " Payments ($monday to $sunday)";
}else{
	$days = array("mon"=>0,"tue"=>1,"wed"=>2,"thu"=>3,"fri"=>4,"sat"=>5,"sun"=>6);
	$current_date = date("Y-m-d",strtotime($monday)+($days[$type]*24*60*60));
  if($to == ""){ $to = $current_date; }
	$title = $account->vars["name"] . " History ($current_date)";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">

<span class="page_subtitle"><? echo $title ?></span><br /><br />

<? if($pay){ ?>
	<? $trans = get_all_accounts_transactions_by_account($account->vars["id"], $monday, $sunday) ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Comment</td>
      </tr>
	  <?
      $i=0;
	 foreach($trans as $tid){
           if($i % 2){$style = "1";}else{$style = "2";}$i++;
		   $ammount = $tid->vars["amount"];
		   if($tid->vars["substract"]){$ammount = "-".$ammount;}
      ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo date("Y-m-d g:iA",strtotime($tid->vars["tdate"])) ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo_report_number(round($ammount)); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tid->vars["description"] ?></td>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
    
    </table>
<? }else{ ?>
	<? //include "process/actions/inspin_sport_parser.php";
   
    $bets = get_bets_by_account($account->vars["id"], true, $current_date, $to,$days[$type]);	
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Placed</td>
       <!-- <td class="table_header" align="center">Sport</td>-->
        <td class="table_header">Desc</td>
        <td class="table_header" align="center">Risk</td>
        <td class="table_header" align="center">Win</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Result</td>
      </tr>
	  <?
      $i=0;
	 foreach($bets as $bet){
           if($i % 2){$style = "1";}else{$style = "2";}$i++;
		   //$game = get_game($bet->vars["gameid"]);
      ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center">
			<? echo date("Y-m-d",strtotime($bet->vars["place_date"])) ."<br />".date("g:iA",strtotime($bet->vars["place_date"])); ?>
        </td>
        <!--<td class="table_td<? echo $style ?>" align="center"><? echo strtoupper($game->vars["sport"]); ?></td>-->
        <td class="table_td<? echo $style ?>"><? echo $bet->get_report_comment(); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo round($bet->vars["risk"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo round($bet->vars["win"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo echo_report_number(round($bet->get_result_amount())); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $bet->str_status(); ?></td>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <!--<td class="table_last"></td>-->
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
    
    </table>
    
<? } ?>


</body>
</html>
<? }else{echo "Access Denied";} ?>