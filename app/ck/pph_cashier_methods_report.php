<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$method = param("method");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Cashier Methods Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Cashier Method by Agents</span><br /><br />
<? 
$accounts = get_all_pph_accounts(); 
$methods = json_decode(file_get_contents("http://cashier.vrbmarketing.com/utilities/api/basic/list.php"),true);
?>
<form method="post">
Method: 

<select name="method" id="method">
	<? foreach($methods["deposit"] as $dm){ ?>
    <option value="<? echo $dm["id"] ?>" <? if($dm["id"] == $method){ echo 'selected="selected"';} ?>><? echo $dm["name"] ?></option>  
    <? } ?>
</select>

&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>
<br /><br />
<? include "includes/print_error.php" ?>    
<? if(is_numeric($method)){ ?>
    <table width="300" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Account</td>
      </tr>
      <?
      $i=0;
       $accs = get_all_pph_accounts_by_method($method);
       foreach($accs as $acc){	   
           if($i % 2){$style = "1";}else{$style = "2";}
           $i++;
      ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $acc->vars["name"]; ?></td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
    
    </table>
    <? if(!$accs){echo "No Accoutns found";} ?>
<? } ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>