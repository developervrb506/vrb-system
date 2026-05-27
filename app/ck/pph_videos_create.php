<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("pph_video_admin")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Sites Videos</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>

<script type="text/javascript">
var validations = new Array();
validations.push({id:"url",type:"null", msg:"Please add a url"});
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
$update=false;
if (isset($_GET["id"])){
 $update = true;
 $video = get_pph_video($_GET["id"]);
}

$has_video = 1; 
$pph_sites = get_all_pph_sites($has_video);

?>
<span class="page_title"><? if($update) { echo "Edit ";} else { echo "Add New ";}?>PPH Videos</span><br /><br />
<? include "includes/print_error.php"; ?>

<form action="process/actions/insert_pph_videos_action.php" method="post" onsubmit="return validate(validations);">
	<? if ($update){ ?>
    	<input id="update" type="hidden" name="update" value="<? echo $video->vars["id"] ?>">
        <strong>YouTube Video Url:</strong><BR><BR>
        <input id="url" type="text" name="url" value="<? echo $video->vars["url"] ?>" size="100" tabindex="1">
        <BR><BR>
        <strong>Site:</strong><BR><BR>
        <select name="site" tabindex="2">        
        <?
	    foreach( $pph_sites as $ps ){
		  $site_name = get_pph_site($ps["id"]); 
	    ?>
        <option <? if ($video->vars["id_site"] == $ps["id"]){ echo "selected"; } ?> value="<? echo $ps["id"] ?>"><? echo $site_name["site"] ?></option>
	   <? } ?>	   
    </select><BR><BR>
    
    <? } else { ?>
    
    <strong>YouTube Video Url:</strong><BR><BR>
        <input id="url" type="text" name="url" value="" size="100" tabindex="1">
        <BR><BR>
        <strong>Site:</strong><BR><BR>
        <select name="site" tabindex="2">        
        <?
	    foreach( $pph_sites as $ps ){
		  $site_name = get_pph_site($ps["id"]); 
	    ?>
        <option value="<? echo $ps["id"] ?>"><? echo $site_name["site"] ?></option>
	   <? } ?>
       
        </select><BR><BR>
    
    <? } ?>                 
      
    <input id="btn" style="width: 120px;" type="submit" value="Save" tabindex="3">
    
</form>


</div>
<? include "../includes/footer.php" ?>

<? } else { echo "ACCESS DENIED"; } ?>