<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_leads")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Add New Leads</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"call_back_date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<?
$statuses = get_all_afleads_status();
$owners = get_all_afleads_owners();
$levels = array(array("id"=>"A","label"=>"A"),array("id"=>"B","label"=>"B"),array("id"=>"C","label"=>"C"),array("id"=>"D","label"=>"D"),array("id"=>"E","label"=>"E"),array("id"=>"F","label"=>"F"));
?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Add New Lead</span><br /><br />

<? include "includes/print_error.php" ?>
<form method="post" action="process/actions/create_aflead.php">
<input name="lead" type="hidden" id="lead" value="<? echo $lead->vars["id"] ?>" />
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td class="table_header" colspan="4"></td>
  </tr>
  <tr>
    <td class="table_td1">Name:<br /><input name="name" type="text" id="name" /></td>
    <td class="table_td1">
    	Last Name:<br /><input name="last_name" type="text" id="last_name" />
    </td>
	<td class="table_td1">Emails:<br />
	  <textarea name="email" id="email"></textarea></td>
    <td class="table_td1">Phones:<br />
      <textarea name="phone" id="phone"></textarea></td>
  </tr>
  <tr>
  	<td class="table_td2">
    	Address:<br /><input name="address" type="text" id="address" size="27" />
    </td>
    <td class="table_td2">City:<br /><input name="city" type="text" id="city" /></td>
    <td class="table_td2">State:<br /><input name="state" type="text" id="state" /></td>
    <td class="table_td2">Country:<br /><input name="country" type="text" id="country" /></td>
  </tr>
  <tr>
    <td  class="table_td1">
      Websites:<br />
      <textarea name="website" cols="40" rows="3" id="website"></textarea>
    </td>
    <td  colspan="3" class="table_td1">
      Payment Method:<br />
	  <textarea name="p_method" id="p_method"><? echo $lead->vars["payment_method"] ?></textarea>
    </td>
  </tr>
    <tr>
      <td class="table_td2">
      	Level:<br />
        <? create_list("level", "level", $levels) ?>
      </td>
      <td class="table_td2">
      	Plan:<br />
        <? create_list("plan", "plan", get_all_afleads_plans(), NULL, "", "", "None") ?>
      </td>
      <td class="table_td2">
      	Type:<br />
        <? create_list("site_type", "site_type", get_all_afleads_types(), NULL, "", "", "N/A") ?>
      </td>
      <td class="table_td2">
      	Rate:<br />
        <input name="rate" type="text" id="rate" />
      </td>
    </tr>
    <tr>
    	<td class="table_td1">Rank:<br /><input name="rank" type="text" id="rank" /></td>
        <td class="table_td1">Alexa:<br /><input name="alexa" type="text" id="alexa" /></td>
        <td class="table_td1">WW AF:<br /><input name="ww_af" type="text" id="ww_af" /></td>
        <td class="table_td1">
        	Active Players:<br />
            <input name="active_players" type="active_players" id="rank" />
        </td>
    </tr>
    <tr>
    	<td class="table_td2">
        	Disposition:<br /><? create_list("disposition", "disposition", get_all_afleads_dispositions(), NULL, "", "", "None") ?>
        </td>
    	<td class="table_td2">
            Call Back Date:<br />
            <input name="call_back_date" type="text" id="call_back_date"/>
        </td>
    	<td class="table_td2">
        	Owner:<br />
            <? 
			$owner = $current_clerk->vars["id"];
			create_list("owner", "owner", get_all_afleads_owners(), $owner, "", "", "Free") 
			?>
        </td>
    	<td class="table_td2">
        Aff Id:<br />
            <input name="aff_id" type="text" id="aff_id"  />
        </td>
    </tr>
    <tr>
    	<td colspan="3" class="table_td1">
        	Notes:<br /><textarea name="Notes" cols="80" rows="7" id="Notes">Added on <? echo date("Y-m-d") ?></textarea>
        </td>
    	<td class="table_td1" align="center"><input type="submit" name="button" id="button" value="Store Lead" /></td>
    </tr>
    
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
  </table>
</form>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>