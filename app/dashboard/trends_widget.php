<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<?
$book = get_sportsbook($_GET["book"]);
$category =  get_category($_GET["category"]);
?>
<?
if($_POST){
	$path = "../images/affiliates/trends_logos/";
	$filename = upload_image_partners("logo_file", $path, $current_affiliate->id."_trends");
	if($filename != ""){$logo_url = "http://localhost:8080/images/affiliates/trends_logos/" . $filename;}
	else{$logo_url = $_POST["logo_url"];}
	$banner_id = $_POST["banners_list"];
	$width = $_POST["width"];
	$heigth = $_POST["heigth"];
	/*$tabs = $_POST["tabs"];*/
}else{
	$width = 350;
	$heigth = 550;
}

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
<title>Trends Widget</title>
</head>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $size = "93x25"; ?>
<? $campaigns = search_campaign($book, $category); ?>
<div class="page_content" style="padding-left:20px;">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Top 10 Winning Betting Trends</span><br /><br /><br />

<div class="conte_banners" style="font-size:12px;">
       <div class="conte_banners_header"><strong>Trends Widget</strong> </div>
        <br />
      <form method="post" action="trends_widget.php?book=<? echo $book->id; ?>&category=<? echo $category->id; ?>" enctype="multipart/form-data">
      
      <table width="500" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><strong>Logo URL (200x30):</strong></td>
        <td><input name="logo_file" type="file" id="logo_file" />
        <input name="logo_url" type="hidden" id="logo_url" value="<? echo $logo_url ?>"/>
      <input name="banners" type="hidden" id="banners" value="<? echo $banner_id ?>"/></td>
      </tr>
      <!--<tr>
        <td><strong>Default Sport:</strong></td>
        <td><select name="tabs" id="tabs">	
        <option value="NFL">NFL</option>
        <option value="NHL">NHL</option>
        <option value="MLB">MLB</option>
        <option value="NBA">NBA</option>
        <option value="SPORTS_WRITERS">WRITTERS</option>
    </select></td>
      </tr>-->
      <tr>
        <td><strong>Width:</strong></td>
        <td><input name="width" type="text" id="width" value="<? echo $width ?>" /></td>
      </tr>
      <tr>
        <td><strong>Heigth:</strong></td>
        <td><input name="heigth" type="text" id="heigth" value="<? echo $heigth ?>" /></td>
      </tr>
      <tr>
        <td><strong>Campaign:</strong></td>
        <td><? echo get_campaigns_by_size($campaigns, $size, "banners_list", "", false) ?></td>
      </tr>
      <tr>
        <td><input name="" type="submit" value="Generate Code" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
      <br /><br />
      <div id="result" style="display:none;">
		<strong>Code: </strong><br />
        <textarea name="code_text" cols="50" rows="4" readonly="readonly" id="code_text"></textarea><br />
        <input type="button" onClick="select_value('code_text');" value="Select Code" />
        <br /><br />
        <div id="iframe_content"></div>
      </div>
      
    </div>

</div>
<? include "../includes/footer.php" ?>
<?
if($_POST){
	?><script type="text/javascript">
		/*load_dropdown("tabs", "<? echo $tabs ?>", false);*/
		load_dropdown("banners_list", "<? echo $banner_id ?>", false);
		trends_widget_code('<? echo $current_affiliate->id ?>', '<? echo $book->url ?>');
    </script><? 
}
?>