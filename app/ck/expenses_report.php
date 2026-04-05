<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Expenses</title>
</head>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datef",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Expenses Report</span><br /><br />

<div class="form_box">
	<? $all_option = true; ?>
    <?
	$s_from = clean_get("datef");
	$s_to = clean_get("datet");
	$s_type = clean_get("type");
	$s_cat = clean_get("categories_list");
	$s_status = clean_get("status_list");
	?>
    <form method="post" id="frm_search">
	From: <input name="datef" type="text" id="datef" value="<? echo $s_from ?>" readonly="readonly" size="10" /> &nbsp;&nbsp;
    To: <input name="datet" type="text" id="datet" value="<? echo $s_to ?>" size="10" readonly="readonly" /> &nbsp;&nbsp;
    Type:
    <select name="type" id="type">
      <option value="" >All</option>
      <option value="p" <? if($s_type == "p"){echo 'selected="selected"';} ?>>Payment</option>
      <option value="r" <? if($s_type == "r"){echo 'selected="selected"';} ?>>Receipt</option>
    </select>
    &nbsp;&nbsp;    
    Category: <? include("includes/expenses_categories_list.php"); ?>&nbsp;&nbsp;
    Status: <? include("includes/expenses_status.php"); ?>&nbsp;&nbsp;
    <input name="" type="submit" value="Search" />
    </form>
</div>
<br /><br />

<? include "includes/print_error.php" ?>

<? if(isset($_POST["datef"])){ ?>
	<? $expenses = search_expenses($s_from, $s_to, $s_cat, $s_status, $s_type); ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Category</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Note</td>
        <td class="table_header" align="center">Status</td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
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
        <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["edate"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        <span title="<? echo $ex->vars["note"]; ?>" style="cursor:pointer;">
                <? echo cut_text($ex->vars["note"],25); ?>
            </span>
        </td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $ex->str_status(); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
            <a href="insert_expense.php?ex=<? echo $ex->vars["id"]; ?>&report=1" class="normal_link" rel="shadowbox;height=420;width=405">Edit</a>
        </td>
        <td class="table_td<? echo $style ?>" style="font-size:11px; color:#900;"><? echo $ex->get_error(); ?></td>
      </td>
      <? } ?>
      <tr>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"><? echo_report_number(number_format($total,2)) ?></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
        <td class="table_header" align="center"></td>
      </tr>
    
    </table>

<? } ?>

</div>
<? include "../includes/footer.php" ?>

<? }else{echo "Access Denied";} ?>