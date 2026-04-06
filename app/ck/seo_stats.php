<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?
$from = isset($_GET["from"])?$_GET["from"]:date("Y-m-d");
$to = isset($_GET["to"])?$_GET["to"]:date("Y-m-d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Stats</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
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
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Stats</span><br /><br />

<? include "includes/print_error.php" ?>

<form method="get">
	From: <input name="from" type="text" id="from" readonly="readonly" value="<? echo $from ?>" />&nbsp;&nbsp;
    To: <input name="to" type="text" id="to" readonly="readonly" value="<? echo $to ?>" />&nbsp;&nbsp;
    <input name="" type="submit" value="Search" />
</form>

<br /><br />
<?
$clerks = get_all_clerks();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Clerk</td>
    <td class="table_header">Info Filled</td>
    <td class="table_header">Actived</td>
    <td class="table_header">Opened</td>
    <td class="table_header">Deactivated</td>
    <td class="table_header">Released</td>
  </tr>
  <? foreach($clerks as $cl){if($cl->im_allow("seo_system")){ if($i % 2){ $style = "1";}else{$style = "2";}$i++ ?>
	  <? $stats = get_seo_clerk_stats($cl->vars["id"], $from, $to) ?>
      <tr>
        <td class="table_td<? echo $style ?>"><? echo $cl->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>">
			<a href="seo_stat_detail.php?from=<? echo $to ?>&to=<? echo $from ?>&clerk=<? echo $cl->vars["id"] ?>&action=if" class="normal_link"  rel="shadowbox;height=500;width=600">
				<? echo isset($stats["if"]["total"])?$stats["if"]["total"]:0; ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>">
			<a href="seo_stat_detail.php?from=<? echo $to ?>&to=<? echo $from ?>&clerk=<? echo $cl->vars["id"] ?>&action=sa" class="normal_link"  rel="shadowbox;height=500;width=600">
				<? echo isset($stats["sa"]["total"])?$stats["sa"]["total"]:0; ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>">
			<a href="seo_stat_detail.php?from=<? echo $to ?>&to=<? echo $from ?>&clerk=<? echo $cl->vars["id"] ?>&action=mo" class="normal_link"  rel="shadowbox;height=500;width=600">
				<? echo isset($stats["mo"]["total"])?$stats["mo"]["total"]:0; ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>">
			<a href="seo_stat_detail.php?from=<? echo $to ?>&to=<? echo $from ?>&clerk=<? echo $cl->vars["id"] ?>&action=mi" class="normal_link"  rel="shadowbox;height=500;width=600">
				<? echo isset($stats["mi"]["total"])?$stats["mi"]["total"]:0; ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>">
			<a href="seo_stat_detail.php?from=<? echo $to ?>&to=<? echo $from ?>&clerk=<? echo $cl->vars["id"] ?>&action=re" class="normal_link"  rel="shadowbox;height=500;width=600">
				<? echo isset($stats["re"]["total"])?$stats["re"]["total"]:0; ?>
            </a>
        </td>
      </tr>
  
  <? }} ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
