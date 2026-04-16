<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
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

function change_method(m){
	
  	 document.getElementById("div_t").style.display = "none";
	 document.getElementById("div_e").style.display = "none";
 	 document.getElementById("send").disabled = true;	
	
  if (m == "t"){	
	 document.getElementById("div_"+m).style.display = "block";
	 document.getElementById("div_e").style.display = "none";	
	 document.getElementById("send").disabled = false;
  
  }
    if (m == "e"){	
	 document.getElementById("div_"+m).style.display = "block";
	 document.getElementById("div_t").style.display = "none";	
 	 document.getElementById("send").disabled = false;  
  }
	 	


}


function pre_submit(){
	
  
  var Select = document.getElementById("method");
  var method = Select.options[Select.selectedIndex].text;
  
  if(method == "Transfers"){
	  var Select = document.getElementById("system_list_to");
	  var system = Select.options[Select.selectedIndex].text;	
	  var Select = document.getElementById("to_account");
	  var account = Select.options[Select.selectedIndex].text;	
	  document.getElementById('t_system').value = system;
	  document.getElementById('t_account').value =account;
	  
  }else{
 	  var Select = document.getElementById("categories_list");
  	  var category = Select.options[Select.selectedIndex].text;	  
	  document.getElementById('t_category').value = category;  
  }
   

 document.forms["myform"].submit();
}

</script>
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<title>Search Moved Deposits</title>
</head>
<?
 $from = $_POST['from'];
 $to =  $_POST['to'];
 if($from == "") { $from = date("Y-m-d"); $to = $from; }
 
 if(isset($_POST["method"])){
	 
  $method = param('method');
  $category = param('categories_list');
  $account = param('to_account');	 
  $system = param('system_list_to');
  $str_system = str_replace(" ","_",param('t_system'));
  $str_account = str_replace(" ","_",param('t_account'));
  $str_category = str_replace(" ","_",param('t_category'));
 }

?>



<body>
<? $page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Search Moved Deposits
</span>
<BR><BR>


<form method="POST" id='myform'>
 
  <input type="hidden" name ="t_system" id="t_system" />
  <input type="hidden" name ="t_account" id="t_account"/>
  <input type="hidden" name ="t_category" id="t_category"/>  
  
  From: <input name="from" type="text" id="from" value="<? echo $from ?>" />
    
    &nbsp;&nbsp;
    
    To: <input name="to" type="text" id="to" value="<? echo $to ?>" /> <BR><BR>
    
  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<select name="method" id="method" onchange="change_method(this.value)">
  <option  selected="selected" value="">Select Method</option>
  <option  value="t">Transfers</option>
  <option value="e">Expenses</option>
  </select>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   
    <input name="send" type="button"  onclick="pre_submit();" id="send"  disabled="disabled" value="Search" />
    <BR><BR>
    <div id="div_t" style="display:none">
     <span> Transfers </span>
     <? 
	  $select_option = true;
      $extra_name = "_to";
      $system_change = "load_system_accounts('to_div_".$tid."', this.value, 'to_account', 0);";
      $system_change .= "if(this.value != ''){document.getElementById('btn_".$tid."').style.display = 'block';}else{document.getElementById('btn_".$tid."').style.display = 'none';}";
	 include("../includes/systems_list.php");
    ?>
    <br /><div id="to_div_<? echo $tid ?>"><input type="hidden" value="" name="to_account" id="to_account" /></div>
    
    
    </div>
    <div id="div_e" style="display:none">
     
       <span> Category</span>
      
		
			<? $s_cat = $expense->vars["category"]->vars["id"];
			 include("../includes/expenses_categories_list.php");
			  ?>
		
    </div>
    

</form>

<?
if (isset($_POST["method"])){
  
     $data="account=".$account."&str_account=".$str_account."&system=".$system."&str_system=".$str_system."&from=".$from."&to=".$to."&method=".$method."&category=".$category."&str_category=".$str_category;

	 echo file_get_contents("http://cashier.vrbmarketing.com/admin/search_moved_deposits.php?c=2002&p=PRXniq92iewoie2112ias&nosearch=1&".$data); 
	
	
}

?>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>