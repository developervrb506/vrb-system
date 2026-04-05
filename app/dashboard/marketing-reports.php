<? set_time_limit(400); ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Marketing Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
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
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Marketing Report</span><br /><br />
<div style="float:right;" class="normal_link"><a href="http://localhost:8080/dashboard/reports.php"><strong><< Back</strong></a></div>
<br /><br />
<?
$from_date = $_POST["from"];
if($from_date==""){$from_date = date("Y-m-d",time()-604800);}
$to_date = $_POST["to"];
if($to_date==""){$to_date = date("Y-m-d");}
$book_id = $_POST["book"];
if($book_id == ""){$book_id = $_GET["bk"];}
$custom_campaign = $_POST["camp_list"];
$webid = $_POST["website"];
if($webid == ""){$web = $current_affiliate;}
else{$web = get_affiliate($webid);}
?><br />
<form method="post" action="marketing-reports.php">
<input name="run" type="hidden" id="run" value="1" />
From: <input name="from" type="text" id="from" value="<? echo $from_date ?>" size="10" readonly="readonly" /> &nbsp;&nbsp;
To: <input name="to" type="text" id="to" value="<? echo $to_date ?>" size="10" readonly="readonly" /> &nbsp;&nbsp;
Web: <? include(ROOT_PATH . "/includes/aff_webs.php"); ?> <br /><br />
Brand: 
<select name="book" id="book" class="<? echo $drop_style ?>">
	<option value="na">All</option>
	<?
    $books = get_sportsbooks_by_affiliate($current_affiliate->id);
    foreach($books as $book){
    ?>
      <option value="<? echo $book->id ?>"><? echo $book->name ?></option>
    <? } ?>	
</select>
 &nbsp;&nbsp;
Custom Campaign: <? $all_option = true; include(ROOT_PATH . "/includes/aff_camps.php"); ?>
&nbsp;&nbsp;
<input name="" type="submit" value="Filter" /> <span class="little">Example: 2011-05-27</span><br /><br />
</form>
<span class="little"><strong>Marketing Statistics will show after a banner or text link has at least 1 impression.</strong></span><br /><br />
<? if(isset($_POST["run"])){ ?>
<? $promos = get_promos_by_affiliate($web, $book_id, $from_date, $to_date, $custom_campaign); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><strong>Campaign</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Promo</strong></td>
    <td class="table_header" style="text-align:center;"><strong>PID</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Clicks</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Unique Clicks</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Impressions</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Unique Impressions</strong></td>
    <td class="table_header" style="text-align:center;"><strong>Signups</strong></td>
  </tr>
<? $i = 0;
	foreach($promos as $promo){ 
		if($i % 2){$style = "1";}else{$style = "2";}?>
	<? $clicks = get_reports_count($web, $promo, "clicks", $from_date, $to_date, $custom_campaign); ?>
	<? $impressions = get_reports_count($web, $promo, "impressions", $from_date, $to_date, $custom_campaign); ?>    
  <tr>
  	<td class="table_td<? echo $style ?>" style="text-transform:uppercase;">
    <? 
	$camp = $promo->get_campaigne();
	if($camp->name != ""){echo $camp->name;}
	else{echo "<em>Custom</em>";}
	?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center;">    
    <? $parts = array(); ?>
	<? if($promo->type == "b"){ ?>
    	<? echo $promo->get_size() ?><br />
    	<img style="max-height:100px; max-width:100px;" src="http://www.inspin.com/partners/images/banners/<? echo $promo->name ?>" />
        
        <?php /*?><img style="max-height:100px; max-width:100px;" src="http://images.commissionpartners.com/data/banners/<? echo $promo->name ?>" /><?php */?>
    <? }else if($promo->type == "m"){
		echo "Mailer"; 
	  }else{
		  $parts = explode("_-_",$promo->name);
		  echo $parts[0]; 
	  } ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center;"><? echo $promo->id; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center;"><? echo $clicks[0]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center;"><? echo $clicks[1]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center;"><? echo $impressions[0]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center;"><? echo $impressions[1]; ?></td>
    <? 
	if($camp->book->id == 3 || $parts[3] == 3 || $camp->book->id == 6 || $parts[3] == 6 || $camp->book->id == 7 || $parts[3] == 7 || $parts[3] == 8 || $camp->book->id == 8 || $parts[3] == 9 || $camp->book->id == 9){
		$signs = count_signups_by_promo($promo->id, $web->id, $from_date, $to_date, $custom_campaign);
	}else{$signs = "N/A";}
	?>
    <td class="table_td<? echo $style ?>" style="text-align:center;">
		<? echo $signs; ?>
    </td>
  </tr>
  <? $i++ ?>
<? } ?>
   <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>
<? } ?>
</div>
<script type="text/javascript">
load_dropdown("book", "<? echo $book_id ?>", false);
load_dropdown("website", "<? echo $webid ?>", false);
load_dropdown("camp_list", "<? echo $custom_campaign ?>", false);
</script>
<? include "../includes/footer.php" ?>