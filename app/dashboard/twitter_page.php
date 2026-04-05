<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<?
$book = get_sportsbook($_GET["book"]);
$category =  get_category($_GET["category"]);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Twitter Page</title>
</head>

<body>
<?
$top_size = "468x60";
$foot_size = "468x60";
$campaigns = search_campaign($book, $category);

?>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Twitter Page</span><br /><br /><br />

<div class="conte_banners" style="font-size:12px;">
            <div class="conte_banners_header"><strong>Writers Page Code</strong> </div>
        <br />
        <input name="aff_books" type="hidden" id="aff_books" value="<? echo $str_books ?>" />
      <strong>With:</strong> <input name="if_w" type="text" id="if_w" value="900" size="5" /> px&nbsp;&nbsp;&nbsp;
      <strong>Default Sport:</strong> 
      <select name="sports" id="sports">
        <option value="MLB">MLB</option>
        <option value="NFL">NFL</option>
        <option value="NBA">NBA</option>
        <option value="NHL">NHL</option>
        <option value="SPORTS_WRITERS">Writers</option>
      </select>
      &nbsp;&nbsp;&nbsp;
      <br /><br /><strong>Header Banner: </strong>
      <? echo get_campaigns_by_size($campaigns, $top_size, "head_banners", "", false) ?>
      
      &nbsp;&nbsp;&nbsp;
      <strong>Footer Banner: </strong>
      <? echo get_campaigns_by_size($campaigns, $foot_size, "foot_banners", "", false) ?>
      <br /><br />      
      <strong><a href="javascript:;" onclick="twitter_preview('<? echo $current_affiliate->id ?>');" class="normal_link">Click here for Preview</a></strong>
      <br /><br />
      <input onclick="generate_twitter_code('<? echo $current_affiliate->id ?>');" name="" type="button" value="Generate Code" />
      <br /><br />
      
      <div id="code_area" style="display:none;"><br />
      <textarea name="code" cols="90" rows="2" readonly="readonly" id="code"></textarea><br />
      <input onclick="select_value('code')" name="" type="button" value="Select HTML Code" />
      </div>
    </div>

</div>
<? include "../includes/footer.php" ?>