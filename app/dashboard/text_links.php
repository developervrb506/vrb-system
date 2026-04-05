<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"text_content",type:"null", msg:"You need to write a Text for the Link"});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Text Links</title>
</head>

<body>
<?
$camp = get_campaigne($_GET["cid"]);
usort($camp->promos, array("promo", "order_by_id"));

$book = get_sportsbook($_COOKIE["banbook"]);

?>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>

<div class="page_content" style="padding-left:20px;">
<span class="page_title"><? echo ucwords($camp->name) ?> Text Links</span><br /><br />
<div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left;">
To generate code with the default text, click "generate text link".<br />
To generate code with custom text, type in the text box area and then click "generate text link".
</div>
<br /><br /><br />
<div class="conte_banners" style="font-size:12px;">
            <div class="conte_banners_header"><strong>Text Links Generator</strong> </div>
        <br />
        <form action="../process/actions/add_personal_promo.php" method="post" onsubmit="return validate(validations);">
        <input name="cid" type="hidden" id="cid" value="<? echo $camp->id ?>" />
      <strong>Text:&nbsp;</strong> <input name="text_content" type="text" id="text_content" value="<? echo ucwords($camp->name); ?>" size="50" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      
      <input onclick="" name="" type="submit" value="Generate Text Link" />
      </form>
      <br /><br />
    </div>
    
<span class="error"><? if (isset($_GET["e"])) { echo  get_error($_GET["e"]) . "<br /><br /><br /><br />"; }?></span>
<?
$preaff = $current_affiliate->id;
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
?>
<? foreach($camp->promos as $promo){ ?>
	<? if($promo->type == "t" && (!contains($promo->name,"_-_") || contains($promo->name,"_-_".$preaff . "_-_"))){ ?>
    <? $promo->name = str_replace("_-_".$preaff . "_-_","",$promo->name); ?>
	<div class="conte_banners">
            <div class="conte_banners_header"><strong>Text Link</strong> </div>
            <br /><br /><? echo $promo->name .' <strong>PID:</strong> '. $promo->id; ?>
        <br /><br />
        <textarea cols="90" rows="3" readonly="readonly" id="code_<? echo $promo->name ?>"><? echo $promo->get_code($current_affiliate, $book->folder); ?></textarea><br />
      <input onclick="select_value('code_<? echo $promo->name ?>')" name="" type="button" value="Select Code" />
        
    </div>
	<? } ?>
<? } ?>

</div>
<? include "../includes/footer.php" ?>