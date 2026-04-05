<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin")){ ?>
<? $expense = get_expense($_GET["ex"]); ?>
<?
if(!is_null($expense)){$is_intersystem = $expense->is_intersystem();}
else{$is_intersystem = false;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">

<script type="text/javascript" src="../process/js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
validations.push({id:"note",type:"null", msg:"Please insert a Note"});
</script>
<span class="page_title">Insert Expense</span><br /><br />
<div class="form_box">
	<? if(!$is_intersystem){ ?>
    	<form method="post" onsubmit="return validate(validations)" action="process/actions/insert_expense_action.php" id="frm_ex" >
	<? } ?>
    <? if(!is_null($expense)){ ?>
    <input name="edit" type="hidden" id="edit" value="1" />
    <input name="report" type="hidden" id="report" value="<? echo $_GET["report"] ?>" />
    <input name="ex" type="hidden" id="ex" value="<? echo $expense->vars["id"] ?>" />    
    <? } ?>
    <? if($_GET["nr"]){ ?><input name="noredirect" type="hidden" id="noredirect" value="1" /> <? } ?>
    <input name="reload" type="hidden" id="reload" value="0" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Date:</td>
		<td>
        	<? 
			if(is_null($expense)){$edate = date("Y-m-d");}
			else{$edate = $expense->vars["edate"];}
			?>
			<input name="date" type="text" id="date" value="<? echo $edate ?>" readonly="readonly" />
		</td>
	  </tr>
      <tr>
		<td>Type:</td>
		<td>
			<select name="type" id="type">
			  <option value="-">Paypment</option>
			  <option value="" <? if(!is_null($expense)){if(!$expense->is_payment()){echo 'selected="selected"';}} ?>>Receipt</option>
			</select>
		</td>
	  </tr>
      <tr>
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" value="<? echo str_replace("-","",$expense->vars["amount"]) ?>" />
		</td>
	  </tr>
      <tr>
		<td>Category</td>
		<td>
			<?
			if($expense->vars["category"]->vars["id"] == 36){ //check if intersyste,
				echo "Intersystem Transfer";
			}else{
				$s_cat = $expense->vars["category"]->vars["id"]; include("includes/expenses_categories_list.php"); 
			}
			
			?>
		</td>
	  </tr> 
	  <tr>
		<td>Note</td>
		<td><textarea name="note" cols="20" rows="5" id="note"><? echo $expense->vars["note"] ?></textarea></td>
	  </tr> 
	  <tr>    
		<td align="center" colspan="2">
        	<? if(!$is_intersystem){ ?>
            
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input type="image" src="../images/temp/submit.jpg" /></td>
                    <td align="right"><input type="button" value="Submit and Add another &gt;&gt;" onclick="add_reload()" /></td>
                  </tr>
                </table>
                
            <? }else{echo "<strong>This is an Intersystem transaction and cannot be edited</strong>";} ?>
        </td>
	  </tr>
	</table>
  <? if(!$is_intersystem){ ?></form><? } ?>
</div>

<script type="text/javascript">
function add_reload(){
	document.getElementById("reload").value = "1";
	document.getElementById("frm_ex").submit();	
}
</script>

</body>
</html>
<? }else{echo "Access Denied";} ?>