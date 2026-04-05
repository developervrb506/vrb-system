<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("office_expenses")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Pending Moneypak Expenses</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Pending Moneypak Expenses</span><br /><br />

<? include "includes/print_error.php" ?>

<?
if(isset($_GET["p"])){
	$hideex = get_office_expense($_GET["p"]);
	
	if(!is_null($hideex)){
		$hideex->vars["paid"] = "1";
		$hideex->update(array("paid"));
	
	  	$exp = new _expense();
	    $exp->vars["edate"] = date("Y-m-d");
	    $exp->vars["amount"] = $hideex->vars["amount"];
	    $exp->vars["category"] = $hideex->vars["category"]->vars["id"];
	    $exp->vars["note"] = $hideex->vars["note"];
	    $exp->vars["inserted_date"] = $hideex->vars["edate"];
		$exp->vars["status"] = "po";
		$exp->insert();
	
	}
	
	
	
}
?>
<? $expenses = get_current_office_expenses(1); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Category</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Note</td>
    <?php /*?><td class="table_header" align="center"></td><?php */?>
  </tr>
  <?
  $i=0;
  $total = 0;
   foreach($expenses as $ex){
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $total += $ex->vars["amount"];
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["category"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo_report_number(number_format($ex->vars["amount"],2)); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->str_date(); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    <span title="<? echo $ex->vars["note"]; ?>" style="cursor:pointer;">
			<? echo cut_text($ex->vars["note"],25); ?>
        </span>
    </td>
   <?php /*?> <td class="table_td<? echo $style ?>" align="center">
        <a href="insert_office_expense.php?ex=<? echo $ex->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=480;width=405">Edit</a>
    </td><?php */?>
 
  </td>
  <tr>
  	<td class="table_td_message" align="center" colspan="100">
    	<a href="add_mps_to_expense.php?eid=<? echo $ex->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=600;width=850">
        	+ Add Paks
        </a>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="table_header" align="center">Id</td>
            <td class="table_header" align="center">Player</td>
            <td class="table_header" align="center">Amount</td>
            <td class="table_header" align="center">mp#</td>
            <td class="table_header" align="center">Zip</td>
            <td class="table_header" align="center">Date</td>
            <td class="table_header" align="center">Status</td>
            <td class="table_header" align="center"></td>
          </tr>
          
          
        
		<? 
		$i=0; 
        $dep_ids = explode(",",$ex->vars["moneypaks"]);
        $ids = "";
		$payout_total = 0;
        foreach($dep_ids as $did){
            $ids .= ",'".trim($did)."'";
        }
        $deposits = get_moneypaks_by_group_ids(substr($ids,1));
        foreach($deposits as $dep){
			if($i % 2){$style = "1";}else{$style = "2";}
			$payout_total += $dep->vars["amount"];
        ?>
        
           <tr>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["id"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["player"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["amount"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center">
            	<? 
				if($current_clerk->im_allow("view_mp_numbers")){
					echo num_two_way($dep->vars["number"], true); 
				}else{
					echo $dep->vars["number"]; 
				}		
				?>
            </td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["zip"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->vars["tdate"]; ?></td>
            <td class="table_td<? echo $style ?>" align="center"><? echo $dep->color_status(); ?></td>
            <td class="table_td<? echo $style ?>" align="center">
                <form method="post" action="process/actions/release_mps_from_expense.php" id="release_<? echo $dep->vars["id"]; ?>">
                	<input name="pid" type="hidden" id="pid" value="<? echo $ex->vars["id"] ?>" />
                    <input name="did" type="hidden" id="did" value="<? echo $dep->vars["id"] ?>" />
                	<a href="javascript:;" onclick="document.getElementById('release_<? echo $dep->vars["id"]; ?>').submit()" class="normal_link">Release</a>
                </form>            </td>
          </tr>
        
        <? $i++;} ?>
        
          <tr>
          	<td class="table_header" colspan="2" align="right"><strong>Current Amount:&nbsp;&nbsp;</strong></td>
            <td class="table_header" align="center"><strong><? echo $payout_total ?></strong></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
            <td class="table_header"></td>
          </tr>
        
        </table>
        <br />
        
        <div align="right">
        	
				<? if(count($deposits)>0 && !$inserted){ ?>
                <form method="post" action="process/actions/complete_mp_expense.php" onsubmit="return confirm('Are you sure you want to pay this expense?');">
                <input name="pid" type="hidden" id="pid" value="<? echo $ex->vars["id"] ?>" />
                <input name="Enviar" type="submit" value="Pay" />
                </form>
                &nbsp;&nbsp;&nbsp;
                <? } ?>            
            
        </div>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"><? echo_report_number(number_format($total,2)) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <?php /*?><td class="table_header" align="center"></td><?php */?>
  </tr>

</table>





</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>