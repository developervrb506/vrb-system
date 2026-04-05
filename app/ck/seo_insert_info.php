<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<script type="text/javascript">
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
Shadowbox.init();
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Entries</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Entries</span><br /><br />

<? include "includes/print_error.php" ?>

<? if(!isset($_GET["getentry"])){ ?>
	<a href="?getentry" class="normal_link">Get Entry</a>
<? }else{ ?>

<div class="form_box">
<? 
$entry = get_seo_info_entry(); 
if(is_null($entry)){echo "No sites available";}
else{
?>
<h1><? echo $entry->vars["website"] ?></h1>
<form method="post" action="process/actions/seo_insert_info.php" >
<input name="web" type="hidden" id="web" value="<? echo $entry->vars["id"] ?>" />
<table width="500" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>First Name</strong></td>
    <td><input name="name" type="text" id="name" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input name="last_name" type="text" id="last_name" /></td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td><input name="email" type="text" id="email" /></td>
  </tr>
  <tr>
    <td><strong>Phone</strong></td>
    <td><input name="phone" type="text" id="phone" /></td>
  </tr>
  <tr>
    <td><strong>Contact Form</strong></td>
    <td>
    	<select name="contact_form" id="contact_form">
    	  <option value="0">No</option>
    	  <option value="1">Yes</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td><strong>PR</strong></td>
    <td><input name="pr" type="text" id="pr" /></td>
  </tr>
  <tr>
    <td><strong>Alexa</strong></td>
    <td><input name="alexa" type="text" id="alexa" /></td>
  </tr>
  <tr>
    <td><strong>Network Solution</strong></td>
    <td><input name="network" type="text" id="network" /></td>
  </tr>
  <tr>
    <td><strong>Twitter</strong></td>
    <td><input name="twitter" type="text" id="twitter" /></td>
  </tr>
  <tr>
    <td><strong>Facebook</strong></td>
    <td><input name="facebook" type="text" id="facebook" /></td>
  </tr>
  <tr>
    <td><strong>Google+</strong></td>
    <td><input name="google_plus" type="text" id="google_plus" /></td>
  </tr>
  <tr>
    <td><strong>Other</strong></td>
    <td><input name="other" type="text" id="other" /></td>
  </tr>
  <tr>
    <td><strong>Website Type</strong></td>
    <td>
    	<select name="type" id="type">
    	  <option value="">Not Set</option>
          <option value="s">Sports</option>
          <option value="h">Horses</option>
          <option value="c">Casino</option>
          <option value="o">Other</option>
    	</select>
    </td>
  </tr>
</table>
<br /><br />
<input name="s" type="submit" id="s" value="Ready" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="s" type="button" id="s" value="Mark as Inactive" onClick="location.href = 'process/actions/seo_mark_inactive.php?id=<? echo $entry->vars["id"] ?>'" />

</form>



<? } ?>
</div>


<? } ?>



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>