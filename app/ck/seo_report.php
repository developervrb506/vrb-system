<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Websites Report</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Websites Report</span><br /><br />

<? include "includes/print_error.php" ?>

<br /><br />

<?
$website = $_GET["website"];
$status = $_GET["status"];
$clerk = $_GET["clerk"];
$clerks = get_all_clerks_index("", "", false,true);
?>
<form method="get">
<strong>Filter:</strong>&nbsp;&nbsp;
Website:
<input name="website" type="text" id="website" value="<? echo $website ?>" />
&nbsp;&nbsp;
Status:
<select name="status" id="status">
  <option value="">All</option>
  <option <? if($status == "u"){?> selected="selected" <? } ?> value="u">Uploaded</option>
  <option <? if($status == "r"){?> selected="selected" <? } ?> value="r">Ready</option>
  <option <? if($status == "a"){?> selected="selected" <? } ?> value="a">Active</option>
  <option <? if($status == "o"){?> selected="selected" <? } ?> value="o">Open</option>
  <option <? if($status == "i"){?> selected="selected" <? } ?> value="i">Inactive</option>
  <option <? if($status == "m"){?> selected="selected" <? } ?> value="m">Moved</option>
</select>
&nbsp;&nbsp;
Clerk:
<select name="clerk" id="clerk">
  <option value="">All</option>
  <? foreach($clerks as $clk){ if($clk->im_allow("seo_system")){ ?>
  <option <? if($clerk == $clk->vars["id"]){?> selected="selected" <? } ?> value="<? echo $clk->vars["id"] ?>"><? echo $clk->vars["name"] ?></option>
  <? }} ?>
</select>
&nbsp;&nbsp;
<input name="" type="submit" value="Filter" />
</form>


<br /><br />
<?
$webs = get_seo_website_report($website, $status, $clerk);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">ID</td>
    <td class="table_header">Website</td>
    <td class="table_header">Status</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">History</td>
    <td class="table_header">Edit</td>
  </tr>
  <? foreach($webs as $web){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  <tr>
    <td class="table_td<? echo $style_color ?><? echo $style ?>"><? echo $web->vars["id"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>"><? echo $web->vars["website"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>"><? echo $web->str_status(); ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>"><? echo $clerks[$web->vars["clerk"]]->vars["name"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>">
    	<a href="seo_web_history.php?w=<? echo $web->vars["id"]; ?>" class="normal_link"  rel="shadowbox;height=500;width=600">
    		History
        </a>
    
    </td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>">
    	<a href="seo_lead_detail.php?edit=1&l=<? echo $web->vars["id"]; ?>" class="normal_link" target="_blank">
    		Edit
        </a>
    
    </td>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>