<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("creditcard_players")){ ?>
<?
$player = strtoupper($_GET["pid"]);
if(isset($_FILES["ufile"])){
	$base = basename($_FILES["ufile"]['name']);
	$parts = explode(".",$base);
	$fname = $base;
	
	$url = upload_file("ufile", "player_files/", mt_rand(100,999)."_".$parts[0]);
	
	if($fname != "" && $url != ""){
		$object = new _sbo_player_file();
		$object->vars["name"] = $fname;
		$object->vars["url"] = $url;
		$object->vars["player"] = $player;
		$object->vars["description"] = $_POST["desc"];
		$object->vars["added_date"] = date("Y-m-d H:i:s");
		$object->vars["added_by"] = $current_clerk->vars["id"];
		$object->insert();
	}
}
if(isset($_GET["del"])){
	$dfile = get_player_file($_GET["del"]);
	if(!is_null($dfile)){
		unlink("player_files/".$dfile->vars["url"]);
		$dfile->delete();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $player ?> Files</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">


<span class="page_title"><? echo $player ?> Files</span><br /><br />

<form method="post" enctype="multipart/form-data" action="player_files.php?pid=<? echo $player ?>&e=66">
<table width="500" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td colspan="2"><strong>Upload new file:</strong></td>
  </tr>
  <tr>
    <td>File:</td>
    <td><input name="ufile" type="file" id="ufile" /></td>
  </tr>
  <tr>
    <td>Description:</td>
    <td><textarea name="desc" cols="" rows="" id="desc"></textarea></td>
  </tr>
  <tr>
    <td><input type="submit" value="Upload" /></td>
    <td></td>
  </tr>
</table>
</form>

<br /><br />
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td class="table_header" align="center">File</td>
    <td class="table_header" align="center">Added</td>
    <td class="table_header" align="center">Description</td>
    <td class="table_header" align="center">Delete</td>
  </tr>
  <?
  $i=0;
   $files = get_all_player_files($player);
   foreach($files as $file){
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center">
		<a href="player_files/<? echo $file->vars["url"]; ?>" class="normal_link" target="_blank">
		<? echo $file->vars["name"]; ?>
        </a>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $file->vars["added_date"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo nl2br($file->vars["description"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
        <a href="javascript:;" onclick="if(confirm('Are you sure you want to DELETE <? echo $file->vars["name"]; ?>?')){location.href = 'player_files.php?pid=<? echo $player ?>&del=<? echo $file->vars["id"] ?>';}" class="normal_link">Delete</a>
    </td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>