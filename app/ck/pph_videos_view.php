<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("pph_video_admin")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Sites Videos</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
 
<script type="text/javascript">
<!--

function delete_video(id){
	if(confirm("Are you sure you want to DELETE this video from the system?")){
		document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/insert_pph_videos_action.php?id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
//-->
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">PPH Sites Videos</span><br /><br />
<?
if (isset($_POST["btn"])){
 $id_site = $_POST["site"];	
}else { $id_site = "";}

//include "includes/print_error.php"; 
?>
<a href="http://localhost:8080/ck/pph_videos_create.php">Add a New</a><br /><br />
<BR>
<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<?
$video = 1; 
$pph_sites = get_all_pph_sites($video);
?>
<form action="" method="post">
 <strong>Sites:</strong>
    <select name="site">   
       <option <? if ($site == ''){ echo "selected"; } ?>  value="" >All</option>
       <? foreach( $pph_sites as $ps ){ ?>
       <option <? if ($id_site == $ps["id"]){ echo "selected"; } ?> value="<? echo $ps["id"] ?>" ><? echo $ps["site"] ?></option>
	   <? } ?>	   
    </select>    
   <input type="submit" value="Search" name="btn"> 
</form>
<BR><BR>
<?
$videos = get_all_pph_videos($id_site);

if(!is_null($videos)) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center"><strong>ID</strong></th>
    <td class="table_header" align="center"><strong>SITE</strong></th>
    <td class="table_header" align="center"><strong>URL</strong></th>
    <td class="table_header" align="center"><strong>DATE</strong></th>
    <td class="table_header" align="center"></th> 
    <td class="table_header" align="center"></th>   
  </tr>
   <?   
   foreach( $videos as $v ){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   $site_name = get_pph_site($v->vars["id_site"]);
   ?>
  <tr id="tr_<? echo $v->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $v->vars["id"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $site_name["site"]; ?></th>       
		<th class="table_td<? echo $style ?>"><a class="normal_link" href="<? echo $v->vars["url"]; ?>" target="_blank"><? echo $v->vars["url"]; ?></a></th>
        <th class="table_td<? echo $style ?>"><? echo $v->vars["pdate"]; ?></th>       
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="http://localhost:8080/ck/pph_videos_create.php?id=<? echo $v->vars["id"] ?>">Edit</a></th>  
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_video(<? echo $v->vars["id"] ?>,'delete')">Delete</a>
        </th> 
  </tr>
<? } ?>
 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>	
<BR>
<? } else { 

    $html='No Data Found';
	echo $html;
}

?>
</div>
<? include "../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>