<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Billing Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
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
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">PPH Current Billing</span><br /><br />
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">id</td>
    <td class="table_header" align="center">account</td>
    <td class="table_header" align="center">phone<br />count</td>
    <td class="table_header" align="center">phone<br />price</td>
    <td class="table_header" align="center">phone<br />total</td>
    <td class="table_header" align="center">internet<br />count</td>
    <td class="table_header" align="center">internet<br />price</td>
    <td class="table_header" align="center">internet<br />total</td>
    
    <td class="table_header" align="center">Live+<br />count</td>
    <td class="table_header" align="center">Live+<br />price</td>
    <td class="table_header" align="center">Live+<br />total</td>
    
    <td class="table_header" align="center">Horses+<br />count</td>
    <td class="table_header" align="center">Horses+<br />price</td>
    <td class="table_header" align="center">Horses+<br />total</td>
    
    <td class="table_header" align="center">Props+<br />count</td>
    <td class="table_header" align="center">Props+<br />price</td>
    <td class="table_header" align="center">Props+<br />total</td>
    
    <td class="table_header" align="center">base<br />count</td>
    <td class="table_header" align="center">max<br />players</td>
    <td class="table_header" align="center">base<br />price</td>
    <td class="table_header" align="center">base<br />total</td>
    <td class="table_header" align="center">Total</td>
  </tr>
  <?
  $i=0;
   $trans = get_current_pph_bills();
   $gtotal = 0;
   $totals = array();
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["phone_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["phone_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? $phone_total = $tran->get_phone_total(); echo basic_number_format($phone_total); $totals["phone"] += $phone_total; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["internet_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["internet_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? $internet_total = $tran->get_internet_total(); echo basic_number_format($internet_total); $totals["internet"] += $internet_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["liveplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["liveplus_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? $live_total = $tran->get_liveplus_total(); echo basic_number_format($live_total); $totals["live"] += $live_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["horsesplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["horsesplus_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? $horses_total = $tran->get_horsesplus_total(); echo basic_number_format($horses_total); $totals["horses"] += $horses_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["propsplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["propsplus_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? $props_total = $tran->get_propsplus_total(); echo basic_number_format($props_total); $totals["props"] += $props_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["base_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["max_players"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["base_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->get_base_total()); ?></td>
    
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["total"]); ?></td>
    <? $gtotal += $tran->vars["total"]; ?>
  </td>
  <? } ?>
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($totals["phone"]) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($totals["internet"]) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($totals["live"]) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($totals["horses"]) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($totals["props"]) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo basic_number_format($gtotal) ?></td>
  </tr>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>