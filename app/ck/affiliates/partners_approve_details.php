<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners Approve</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>

</head>
<?

$affiliates = get_affiliate_partner($_GET["affid"]);
//$bookid = $_GET["bookid"];
?>

<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<h2><?php echo $affiliates->full_name(); ?> </h2> 
<!-- Contenido -->
<? 
if (isset($_GET["e"])) { echo get_error($_GET["e"]); }
?>
<?php /*?><p><strong>Important note:</strong> For WagerWeb Affiliates, both fields are required</p><?php */?>
<br />
<form action="./process/actions/partners_approve_process.php" method="POST" name="approve" id="approve">  
  <table width="200" cellpadding="2" cellspacing="2">    
    <tr>
      <td nowrap="nowrap">Affiliate Code:</td>      
      <td><input type="text" name="afcode" id="afcode" size="20" maxlength="50" value=""></td>
    </tr>
    <input type="hidden" name="affid" id="affid" value="<? echo $affiliates->vars["id"] ?>">
    <?php /*?><tr>
      <td nowrap="nowrap">Affiliate Password:</td>      
      <td><input type="text" name="afpassword" id="afpassword" size="20" maxlength="50" value="">
          <input type="hidden" name="affid" id="affid" value="<? echo $affiliates->vars["id"] ?>">
          <input type="hidden" name="bookid" id="bookid" value="<? echo $bookid ?>">
      </td>
    </tr><?php */?>        
    <tr>
      <td colspan="2"><input type="submit" name="submit" id="submit" value="Approve"></td>
    </tr>
  </table>
</form>



</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>