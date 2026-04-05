<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_search_accounts")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SBO Daily New Accounts</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">SBO Search Accounts</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$account = clean_get("account");
$type = clean_get("type");
?>

<form method="post">
    Type: 
    <select name="type" id="type">
      <option value="pl" <? if($type == "pl"){echo 'selected="selected"';} ?>>Player</option>
      <option value="ag" <? if($type == "ag"){echo 'selected="selected"';} ?>>Agent</option>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    Account: 
    <input name="account" type="text" id="account" value="<? echo $account ?>" />
    <input type="submit" value="Search" />
</form>
<? 
$data = "?acc=$account&type=$type";
echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/vrb_search_account.php".$data); 
?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>