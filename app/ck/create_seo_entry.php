<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>

<?
if(isset($_GET["gid"])){
	$update = true;
	$group = get_seo_entry($_GET["gid"]);
	$title = "Edit Entry";
}else{
	$update = false;
	$title = "Create New Entry";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<title>Create SEO entry</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"paid_date",
			dateFormat:"%Y-%m-%d"
		});		
	};
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"brand",type:"null", msg:"Brand is required"});
validations.push({id:"url",type:"null", msg:"URL is required"});
validations.push({id:"keywords",type:"null", msg:"Keywords is required"});
validations.push({id:"rank",type:"null", msg:"Rank is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>
<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_seo_entry_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $group->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Clerk</td>
        <td>
        <? 
		$clerks = get_all_clerks_index("", "", false,true); 
		$rel_web = get_seo_website($group->vars["website"]);
		?>
        <select name="clerk" id="clerk">
          <option value="">None</option>
          <? foreach($clerks as $clk){ if($clk->im_allow("seo_system")){ ?>
          <option <? if($rel_web->vars["clerk"] == $clk->vars["id"]){?> selected="selected" <? } ?> value="<? echo $clk->vars["id"] ?>"><? echo $clk->vars["name"] ?></option>
          <? }} ?>
        </select>
        </td>
      </tr>
      <tr>
        <td>Brand</td>
        <td>
        <? 
		$brands = get_all_seo_rankings_brands();
		$current_brand = get_seo_brand(clean_get("brand",true));
		?>
        <? create_objects_list("brand_list", "brand_list", $brands, "id", "name", "Select from List", $current_brand->vars["id"], "location.href = '?gid=".$group->vars["id"]."&brand='+this.value;") ?>
        -->
        <?
        if(is_null($current_brand)){
			$_brand = $group->vars["brand"];
		}else{
			$_brand = $current_brand->vars["name"];
		} 
		?>
        <input name="brand" type="text" id="brand" value="<? echo $_brand ?>" />
        </td>
      </tr>
      <tr>
        <td>URL</td>
        <td>
         <? 
		 $urls = get_all_seo_rankings_urls($current_brand->vars["id"]); 
		 $current_url = clean_get("turl",true);
		 ?>
        <? create_objects_list("urls_list", "urls_list", $urls, "url", "url", "Select from List", $current_url, "location.href = '?gid=".$group->vars["id"]."&brand=".$current_brand->vars["id"]."&turl='+this.value;") ?>
        -->
        <input name="url" type="text" id="url" value="<? if(trim($current_url) == ""){echo $group->vars["url"];}else{echo $current_url;} ?>" />
        </td>
      </tr>
      <tr>
        <td>Keywords</td>
        <td>
        <? $kword = get_keyword_by_brand_url($current_brand->vars["id"],$current_url); ?>
        <? //create_objects_list("words_list", "words_list", $words, "keyword", "keyword", "Select from List", "", "document.getElementById('keywords').value += ','+this.value;") ?>
        <? 
		if(is_null($kword)){
			$_keyword = $group->vars["keywords"];
		}else{
			$_keyword = $kword->vars["keyword"];
		} ?>
        <input name="keywords" type="text" id="keywords" value="<? echo $_keyword ?>" />
        <? $paids = seo_cound_paid_links($_brand, $_keyword) ?>
        &nbsp;Paid Links: &nbsp;
        <a href="seo_system.php?paid=1&brand=<? echo $_brand ?>&keyword=<? echo $_keyword ?>" class="normal_link" target="_blank">
			<? echo $paids["total"]; ?>
        </a>
        </td>
      </tr>
      <tr>
        <td>Rank</td>
        <td><input name="rank" type="text" id="rank" value="<? echo $group->vars["rank"] ?>" /></td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><input name="amount" type="text" id="amount" value="<? echo $group->vars["amount"] ?>" /></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input name="email" type="text" id="email" value="<? echo $group->vars["email"] ?>" /></td>
      </tr>
      <tr>
        <td>Method</td>
        <td><input name="method" type="text" id="method" value="<? echo $group->vars["method"] ?>" /></td>
      </tr>
      <tr>
        <td>Paid Date</td>
        <td><input name="paid_date" type="text" id="paid_date" value="<? if ( $group->vars["paid_date"] != "0000-00-00" ) echo $group->vars["paid_date"]; ?> " /></td>
      </tr> 
      <tr>
        <td>Article Type</td>
        <td><input name="article_type" type="text" id="article_type" value="<? echo $group->vars["article_type"]; ?> " /></td>
      </tr>  
      <tr>
        <td>Article URL</td>
        <td><input name="article_url" type="text" id="article_url" value="<? echo $group->vars["article_url"]; ?> " /></td>
      </tr>        
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
