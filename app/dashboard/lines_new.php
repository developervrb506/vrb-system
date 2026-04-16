<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<?
$book = get_sportsbook($_GET["book"]);
$category = get_category($_GET["category"]);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Lines</title>
</head>

<body>
<?
$top_size = "234x60";
$foot_size = "610x100";
$campaigns = search_campaign($book, $category);

session_start();
$books = get_sportsbooks_by_affiliate($_SESSION['parent_aff_id']);
$str_books = "";
foreach($books as $pbook){
	$str_books .= "-".$pbook->name;
}
$str_books = str_replace("BetOnline","Bet Online",$str_books);
$str_books = substr($str_books,1);
?>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<? if($book->id == 1){ ?>
<span class="page_title">Betting Lines</span><br /><br /><br />

<div class="conte_banners" style="font-size:12px;">
            <div class="conte_banners_header"><strong>Live Lines Code</strong> </div>
        <br />
        <input name="aff_books" type="hidden" id="aff_books" value="Wagerweb" />
      <strong>With:</strong> <input name="if_w" type="text" id="if_w" value="900" size="5" /> px&nbsp;&nbsp;&nbsp;
      <strong>Height:</strong> <input name="if_h" type="text" id="if_h" value="1100" size="5" /> px&nbsp;&nbsp;&nbsp;
      <strong>Default Sport:</strong> 
      <select name="sports" id="sports">
        <option value="MLB">MLB</option>
        <option value="NFL">NFL</option>
        <option value="NBA">NBA</option>
        <option value="NCAAF">NCAAF</option>
        <option value="NCAAB">NCAAB</option>
        <option value="NHL">NHL</option>
      </select>
      &nbsp;&nbsp;&nbsp;
      <br /><br /><strong>Header Banner: </strong>
      <? echo get_campaigns_by_size($campaigns, $top_size, "head_banners", "", false) ?>
      
      &nbsp;&nbsp;&nbsp;
      <strong>Footer Banner: </strong>
      <? echo get_campaigns_by_size($campaigns, $foot_size, "foot_banners", "", false) ?>
      <br /><br />      
      <strong><a href="javascript:;" onclick="lines_preview('<? echo $current_affiliate->id ?>');" class="normal_link">Click here for Preview</a></strong>
      <br /><br />
      <input onclick="generate_lines_code('<? echo $current_affiliate->id ?>');" name="" type="button" value="Generate Code" />
      <br /><br />
      
      <div id="code_area" style="display:none;"><br />
      <textarea name="code" cols="90" rows="2" readonly="readonly" id="code"></textarea><br />
      <input onclick="select_value('code')" name="" type="button" value="Select HTML Code" />
      </div>
    </div>
<? }else{echo "This Tool is not available for " . $book->name;} ?>
</div>
<? include "../includes/footer.php" ?>