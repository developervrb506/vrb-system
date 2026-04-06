<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"text_content",type:"null", msg:"You need to write a Text for the Link"});
validations.push({id:"text_url",type:"null", msg:"You need to write a URL for the Link"});
</script>
<?
$promos = get_personal_promos($current_affiliate->id);
$book = get_sportsbook($_GET["b"]);
//$sportsbooks = get_affiliate_sportsbooks($current_affiliate->id);
if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo ucwords($book->name); ?> Custom Text Links</title>
</head>

<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title"><? echo ucwords($book->name); ?> Custom Text Links</span><br /><br /><br />

<div class="conte_banners" style="font-size:12px;">
            <div class="conte_banners_header"><strong>Text Links Generator</strong> </div>
        <br />
        <form action="../process/actions/add_custom_personal_promo.php" method="post" onsubmit="return validate(validations);">
      <strong>Link Text:&nbsp;</strong> <input name="text_content" type="text" id="text_content" value="Type text here" size="70" /> <br /><br />
      
       <strong>Target URL:&nbsp;</strong> <input name="text_url" type="text" id="text_url" value="Paste URL target for text" size="70" /> <br /><br />
       <input name="text_book" type="hidden" id="text_book" value="<? echo $book->id; ?>" />
       <!--<strong>Sportbook:&nbsp;</strong> 
       
       <select name="text_book" id="text_book">
		  <? 
             //foreach($sportsbooks as $book){ ?>
                  <option value="<? //echo $book->id ?>"><? echo $book->name ?></option>
        <? //} ?>
        <option value="-1">None</option>
      </select>
       
       <br /><br />-->
      
      <input onclick="" name="" type="submit" value="Generate Text Link" />
      </form>
      <br /><br />
    </div>


<span class="page_title">Available Text Links</span><br />
<span class="error"><? if (isset($_GET["e"])) { echo  get_error($_GET["e"]) . "<br />"; }?></span>
<br /><br />
    
<? foreach($promos as $promo){ ?>
	<? 
    $parts = explode("_-_",$promo->name);
    $promo->name = $parts[0];
    ?>
	<? if($promo->type == "t" && $parts[3] == $book->id){ ?>
	    
	<div class="conte_banners">
            <div class="conte_banners_header"><strong><? if($parts[1] != "all"){echo "Custom";}else{echo ucwords($book->name);}?> Text Link PID: <? echo $promo->id; ?></strong></div>
            <br /><? echo $promo->name; ?>
        <br /><br />
        <?
		$link = $book->folder.'/custom_redir.php?pid='. $promo->id .'&aid='. $current_affiliate->id .'&tgt='. $parts[2] .'&bk='. $parts[3];
		$code = '<!--Affiliate Code Start Here-->';
		$code .= '<a href="'.$link.'" target="_blank">';
		$code .= $promo->name;
		$code .= '<img border="0" src="<?= BASE_URL ?>/process/image.php?pid='. $promo->id .'&aid='. $current_affiliate->id .'" /></a>';
		$code .= '<!--Affiliate Code End Here-->';
		?>
        <textarea cols="90" rows="3" readonly="readonly" id="code_<? echo $promo->name ?>"><? echo $code ?></textarea><br />
      <input onclick="select_value('code_<? echo $promo->name ?>')" name="" type="button" value="Select Code" />
        
        <br /><br />
        
        <span class="little"><strong>Direct Link:</strong></span> 
        <input name="link_<? echo $promo->name ?>" type="text" id="link_<? echo $promo->name ?>" value="<? echo $link; ?>" size="100" readonly="readonly" />
        <input onclick="select_value('link_<? echo $promo->name ?>')" name="" type="button" value="Select Link" />
        <br /><br />
        
    </div>
	<? } ?>
<? } ?>


</div>
<? include "../includes/footer.php" ?>