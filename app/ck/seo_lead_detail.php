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
<title>SEO Lead Detail</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SEO Lead Detail</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box">
<? 
$lead = get_seo_website(clean_str_ck($_GET["l"]));
if(is_null($lead)){echo "Not found";}
else{
?>
<h1><? echo $lead->vars["website"] ?></h1>
<form method="post" action="process/actions/seo_save_comments.php" >
<input name="web" type="hidden" id="web" value="<? echo $lead->vars["id"] ?>" />
<table width="700" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>First Name</strong></td>
    <td><input name="name" type="text" id="name" value="<? echo $lead->vars["name"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input name="last_name" type="text" id="last_name" value="<? echo $lead->vars["last_name"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td><input name="email" type="text" id="email" value="<? echo $lead->vars["email"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Phone</strong></td>
    <td><input name="phone" type="text" id="phone" value="<? echo $lead->vars["phone"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Contact Form</strong></td>
    <td>
    	<select name="contact_form" id="contact_form">
    	  <option value="0">No</option>
    	  <option value="1" <? if($lead->vars["contact_form"]){ ?>selected="selected"<? } ?>>Yes</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td><strong>PR</strong></td>
    <td><input name="pr" type="text" id="pr" value="<? echo $lead->vars["pr"] ?>" /></td>
  </tr>
  <tr>
    <td><strong>Alexa</strong></td>
    <td><input name="alexa" type="text" id="alexa" value="<? echo $lead->vars["alexa"] ?>" /></td>
  </tr>
  <tr>
    <td><strong>Network Solution</strong></td>
    <td><input name="network" type="text" id="network" value="<? echo $lead->vars["network_solutions"] ?>" /></td>
  </tr>
  <tr>
    <td><strong>Twitter</strong></td>
    <td><input name="twitter" type="text" id="twitter" value="<? echo $lead->vars["twitter"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Facebook</strong></td>
    <td><input name="facebook" type="text" id="facebook" value="<? echo $lead->vars["facebook"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Google+</strong></td>
    <td><input name="google_plus" type="text" id="google_plus" value="<? echo $lead->vars["google_plus"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Other</strong></td>
    <td><input name="other" type="text" id="other" value="<? echo $lead->vars["other_social"] ?>" size="50" /></td>
  </tr>
  <tr>
    <td><strong>Website Type</strong></td>
    <td>
    	<select name="type" id="type">
    	  <option value="">Not Set</option>
          <option value="s" <? if($lead->vars["type"] == "s"){ ?>selected="selected"<? } ?>>Sports</option>
          <option value="h" <? if($lead->vars["type"] == "h"){ ?>selected="selected"<? } ?>>Horses</option>
          <option value="c" <? if($lead->vars["type"] == "c"){ ?>selected="selected"<? } ?>>Casino</option>
          <option value="o" <? if($lead->vars["type"] == "o"){ ?>selected="selected"<? } ?>>Other</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td><strong>Comments</strong></td>
    <td><textarea name="comments" cols="60" rows="10" id="comments"><? echo $lead->vars["comments"]; ?></textarea>
    </td>
  </tr>
</table>

<? if(isset($_GET["edit"])){ ?>

	<br /><br />
	<select name="my_lead" id="my_lead">
	  <option value="">Not my Lead</option>
	  <option value="a">My Lead, Mark it as Active</option>
       <option value="o">My Lead, Mark it as Open</option>
	</select>


<? }else{ ?>

<br /><br />
<? if($lead->vars["status"] == "a"){ ?>
<input name="s" type="submit" id="s" value="Save" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="s" type="button" id="s" value="Mark as Open" onClick="location.href = 'process/actions/seo_mark_open.php?id=<? echo $lead->vars["id"] ?>'" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="s" type="button" id="s" value="Mark as Inactive" onClick="location.href = 'process/actions/seo_mark_inactive.php?id=<? echo $lead->vars["id"] ?>'" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="s" type="button" id="s" value="Release" onClick="location.href = 'process/actions/seo_mark_release.php?id=<? echo $lead->vars["id"] ?>'" />
<? }else{ ?>

<strong>Sent it to:</strong>
<select name="action" id="action" onChange="if(this.value == 'lk'){document.getElementById('linksfields').style.display = 'block';}else{document.getElementById('linksfields').style.display = 'none';}">
  <option value="">-- None --</option>
  <option value="af">Affiliate Deal</option>
  <option value="lk" <? if($_GET["links_count"]>0){ ?> selected="selected"<? } ?>>Link Buy</option>
  <option value="bo">Betting Odds</option>
  <option value="in">Inactive</option>
</select>

<div id="linksfields" style="display:none;">
<br /><br />
How many?:

<select name="links_count" id="links_count">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select>
<input name="" type="button" value="Go" onClick="location.href = 'seo_lead_detail.php?l=<? echo $lead->vars["id"]; ?>&links_count='+document.getElementById('links_count').value;" />
<br /><br />
</div>
<? if($_GET["links_count"]>0){ ?>
<input name="links_count" type="hidden" id="links_count" value="<? echo $_GET["links_count"] ?>" />
<br />
<br />
<? for($i=0;$i<$_GET["links_count"];$i++){ $inx = $i+1; ?>
<h3>Link Buy <? echo $inx ?>:</h3>
<table width="400" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td><strong>Brand</strong></td>
        <td><input name="brand<? echo $inx ?>" type="text" id="brand<? echo $inx ?>" /></td>
      </tr>
      <tr>
        <td><strong>URL</strong></td>
        <td><input name="url<? echo $inx ?>" type="text" id="url<? echo $inx ?>"  /></td>
      </tr>
      <tr>
        <td><strong>Article Type</strong></td>
        <td>
        	<select name="article_type<? echo $inx ?>" id="article_type<? echo $inx ?>" onChange="if(this.value != '' && this.value != 'No Article'){document.getElementById('at_box<? echo $inx ?>').style.display = 'inline';}else{document.getElementById('at_box<? echo $inx ?>').style.display = 'none';}">
        	  <option value="">-- Select --</option>
              <option value="Unique">Unique</option>
        	  <option value="Database">Database</option>
              <option value="Webmaster will write">Webmaster will write</option>
        	  <?php /*?><option value="No Article">No Article</option><?php */?>
        	</select>
            <br />
            <span style="display:none" id="at_box<? echo $inx ?>"><p>Topic: <input name="article_type_desc<? echo $inx ?>" type="text" id="article_type_desc<? echo $inx ?>"  /></p></span>
        </td>
      </tr>
      <tr>
        <td><strong>Keywords</strong></td>
        <td><input name="keywords<? echo $inx ?>" type="text" id="keywords<? echo $inx ?>"  /></td>
      </tr>
      <tr>
        <td><strong>Rank</strong></td>
        <td><input name="rank<? echo $inx ?>" type="text" id="rank<? echo $inx ?>"  /></td>
      </tr>
      <tr>
        <td><strong>Amount</strong></td>
        <td><input name="amount<? echo $inx ?>" type="text" id="amount<? echo $inx ?>"  /></td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td><input name="email<? echo $inx ?>" type="text" id="email<? echo $inx ?>" /></td>
      </tr>
      <tr>
        <td><strong>Method</strong></td>
        <td><input name="method<? echo $inx ?>" type="text" id="method<? echo $inx ?>" /></td>
      </tr>
      <tr>
        <td><strong>Paid Date</strong></td>
        <? if($i==0){$sdays = 1;}else{$sdays = ((7*$i) + 1);} ?>
        <td><input name="paid_date<? echo $inx ?>" type="text" id="paid_date" value="<? echo date("Y-m-d",strtotime(date("Y-m-d")." + $sdays days")) ?>" /></td>
      </tr> 
</table>

<br />
<br />
<? } ?>
<? } ?>
<? } ?>
<? } ?>

<br /><br />
<input name="s" type="submit" id="s" value="Submit" />



</form>



<? } ?>
</div>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>