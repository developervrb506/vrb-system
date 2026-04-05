<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dj_expenses")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1;

             maximum-scale=1;

             minimum-scale=1; 

             user-scalable=no;" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:3px;">

<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
validations.push({id:"note",type:"null", msg:"Please insert a Note"});
</script>
<a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a><br /><br />
<span class="page_title">Insert Michael's Expense</span><br /><br />
<? include "../includes/print_error.php" ?>
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="../process/actions/insert_dj_expense_action.php" >
    <input name="mobile" type="hidden" id="mobile" value="1" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Type:</td>
		<td>
			<select name="type" id="type">
			  <option value="-">Paypment</option>
			  <option value="">Receipt</option>
			</select>
		</td>
	  </tr>
      <tr>
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" value="" />
		</td>
	  </tr>
      <tr>
		<td>Category</td>
		<td>
			<? $s_cat = $expense->vars["category"]->vars["id"]; include("../includes/dj_expenses_categories_list.php"); ?>
		</td>
	  </tr>
      <tr>
		<td>Month/Year:</td>
		<td>
			<?
            $s_month = $expense->vars["month"]; 
			if($s_month == ""){$s_month = date("n");}
			include("../includes/month_list.php"); 
			?>
            <?
            $s_year = $expense->vars["year"]; 
			if($s_year == ""){$s_year = date("Y");}
			include("../includes/year_list.php");
			?>
		</td>
	  </tr>
	  <tr>
		<td>Note</td>
		<td><textarea name="note" cols="20" rows="5" id="note"><? echo $expense->vars["note"] ?></textarea></td>
	  </tr> 
	  <tr>    
		<td align="center" colspan="2"><input type="image" src="../../images/temp/submit.jpg" /></td>
	  </tr>
	</table>
  </form>
</div>
<br /><br /><a href="index.php" class="normal_link">&lt;&lt; Back to Main Menu</a>
</body>
</html>
<? }else{echo "Access Denied";} ?>