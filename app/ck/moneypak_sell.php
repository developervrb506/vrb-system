<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_sell")){ ?>
<?
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = post_get("status_list","ac");
$delivered = post_get("delivered","0");

if(isset($_GET["ed"])){
    $trans = get_moneypak_sell($_GET["ed"]);
	$trans->vars["status"] = "de";
	$trans->update(array("status"));
	header("Location: moneypak_sell.php?e=3");
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Moneypak Sell</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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
</script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
function change_delivered(id,status){
	if(confirm("Are you sure you want to change the Deliver Status")){
	    document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/change_mp_deliver.php?id="+id;
   
      if (document.getElementById("dlv_"+id).innerHTML == "True")
	  {
	     document.getElementById("dlv_"+id).innerHTML = "False";
	  }		
	  else{
	    document.getElementById("dlv_"+id).innerHTML = "True";
		
		if (status){
		document.getElementById("dlv_"+id).style.display="none";
		document.getElementById("td_dlv_"+id).innerHTML = "<strong>True</strong>";
		}
	  }
	
	}
}
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<span class="page_title">Moneypak Sell</span>
<br /><br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Status: <? $current_status = $status; $all_option = true; include("includes/pt_transaction_status_list.php") ?>
&nbsp;&nbsp;&nbsp;
Delivered:
<select name="delivered" id="delivered">
  <option value="all" <? if($delivered == "all"){echo 'selected="selected"';} ?>>All</option>
  <option value="1" <? if($delivered == "1"){echo 'selected="selected"';} ?>>Yes</option>
  <option value="0" <? if($delivered == "0"){echo 'selected="selected"';} ?>>No</option>
</select>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>




<br />
<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center" title="BTC Amount">BTC</td>
    <td class="table_header" align="center" title="Amount Deposited">DEP</td>
    <td class="table_header" align="center">Moneypak</td>
    <td class="table_header" align="center">status</td>
    <td class="table_header" align="center">email</td>
    <td class="table_header" align="center">phone</td>
    <td class="table_header" align="center">Date</td>   
    <td class="table_header" align="center">Sent</td>   
    <td class="table_header" align="center"></td>  
  </tr>
  
  
  <?
   
  $total = 0;
  $total_btc = 0;
  $trans =  search_moneypak_sell($from, $to, $status, $delivered);
  echo "<pre>";
//print_r($trans);
echo "</pre>";

  foreach($trans as $tran){ if($i % 2){$style = "1";}else{$style = "2";}$i++;
    
   $acepted=0;
    if ($tran->vars["status"] == "ac") { $acepted =1; }	
   ?>
	
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["btc_amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["btc_deposited"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
		<? 
		if($current_clerk->im_allow("view_mp_numbers")){
			echo num_two_way($tran->vars["moneypak"]->vars["number"], true); 
		}else{
			echo $tran->vars["moneypak"]->vars["number"]; 
		}		
        if(!is_mp_available($tran->vars["moneypak"]->vars["id"])){
            ?> <br /><span class="error">NOT LONGER AVAILABLE</span> <?
        }
        ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->color_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["phone"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td  id="td_dlv_<? echo $tran->vars["id"] ?>" class="table_td<? echo $style ?>" align="center">
	
     <? if ($tran->vars["delivered"] && $tran->vars["status"] == "ac" ) { echo "<strong>True</strong>" ; } else if ($tran->vars["status"] == "ac") {?>
    <a id="dlv_<? echo $tran->vars["id"] ?>" class="normal_link" href="javascript:;" onclick="change_delivered('<? echo $tran->vars["id"] ?>',<? echo $acepted ?>);">
        	<? echo $tran->str_delivered(); ?>
    </a>
    <? } ?>
    
	
	</td>
    <td class="table_td<? echo $style ?>" align="center">
    <? if($tran->vars["status"] == "pe"){ ?>
        	<a href="?ed=<? echo $tran->vars["id"]; ?>" class="normal_link">Cancel</a>
     <? } ?>     
    </td>        
  </tr>
 
  
  
  <?
   $total = $total + $tran->vars["amount"];
   $total_btc = $total_btc + $tran->vars["btc_amount"];
  
   } ?>
   <tr>
    
    <td class="table_header" align="center">TOTAL:</td>
    <td class="table_header" align="center"><? echo $total ?></td>
    <td class="table_header" align="center"><? echo $total_btc ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>