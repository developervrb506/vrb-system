<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_access")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:20px; background:#fff;">
<?
$method = get_cashier_method_description($_GET["mid"]);

?>
<span class="page_title">Cashier Method Description</span><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><? echo $method->vars["cashier_method"]->vars["name"]; ?></td>
  </tr>

   <tr>
        <td class="table_td1"><? echo $method->vars["description"]; ?></td>
   </tr>	
   <tr>
        <td class="table_td1"><? echo $method->vars["steps"]; ?></td>
   </tr>
   <tr>
        <td class="table_td1"><? echo $method->vars["fees"]; ?></td>
   </tr>
   <tr>
        <td class="table_td1"><? echo $method->vars["extra_info"]; ?></td>
   </tr> 
   <tr>
        <td class="table_td1"><strong>Mobile</strong></td>
   </tr>     
   <tr>
        <td class="table_td1"><? echo $method->vars["mobile"]; ?></td>
   </tr>   

    <tr>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? }else{echo "Acces Denied";} ?>