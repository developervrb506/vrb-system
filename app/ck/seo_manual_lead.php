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
<title>SEO Manual Lead</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SEO Manual Lead</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box">

<form method="post" action="process/actions/seo_save_lead.php" >
<table width="700" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>Status</strong></td>
    <td>
    	<select name="status" id="status">
    	  <option value="a">Active</option>
    	  <option value="o">Open</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td><strong>Website</strong></td>
    <td><input name="website" type="text" id="website" /></td>
  </tr>
  <tr>
    <td><strong>First Name</strong></td>
    <td><input name="name" type="text" id="name" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input name="last_name" type="text" id="last_name"  /></td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td><input name="email" type="text" id="email"  /></td>
  </tr>
  <tr>
    <td><strong>Phone</strong></td>
    <td><input name="phone" type="text" id="phone"  /></td>
  </tr>
  <tr>
    <td><strong>Contact Form</strong></td>
    <td>
    	<input name="form" type="text" id="form"  />
    </td>
  </tr>
  <tr>
    <td><strong>PR</strong></td>
    <td><input name="pr" type="text" id="pr"  /></td>
  </tr>
  <tr>
    <td><strong>Alexa</strong></td>
    <td><input name="alexa" type="text" id="alexa"  /></td>
  </tr>
  <tr>
    <td><strong>Twitter</strong></td>
    <td><input name="twitter" type="text" id="twitter"  /></td>
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
    	<input name="other" type="text" id="other" />
    </td>
  </tr>
  <tr>
    <td><strong>Comments</strong></td>
    <td><textarea name="comments" cols="60" rows="10" id="comments"></textarea>
    </td>
  </tr>
</table>


<input name="s" type="submit" id="s" value="Submit" />

</form>


</div>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>