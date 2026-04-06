<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("new_features")){ 

if (!isset($_GET["type"])) { $type = $_POST["type"]; }
else { $type = $_GET["type"]; }


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>New Features</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
 
<script type="text/javascript">
<!--
function confirmation(id,status,type) {

	if (confirm('Are you sure that you want to '+ status +' this posting?')){		
	   //window.location = BASE_URL . "/ck/process/actions/new_feature_action.php?id="+id+"&type="+type;
	   document.getElementById("idel").src = BASE_URL . "/ck/process/actions/new_feature_action.php?id="+id+"&type="+type;
	   
	   document.getElementById("th_status_"+id).innerHTML = status;
	}	
}
function delete_feature(id,type){
	if(confirm("Are you sure you want to DELETE this entry from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/new_feature_action.php?id="+id+"&type="+type;
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
<span class="page_title">New Features</span><br /><br />
<?
if(isset($_POST['type']) && !empty($_POST['type'])) {
   $type = $_POST['type'];	
  
}

?>
<!--TYPE-->
<table width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td><form action="" method="post">
<strong>Type:</strong>&nbsp;
<select name="type">
  <option value="0">Select a Type</option>
  <option  <? if ($type == "a") { echo ' selected="selected" '; }?> value="a">Agent</option>
  <option  <? if ($type == "p") { echo ' selected="selected" '; }?> value="p">Player</option>

</select>
<input type="submit" value="Search">&nbsp;&nbsp;<a href="<?= BASE_URL ?>/ck/new_feature_create.php">Add a New</a><br /><br />
<BR>
</form></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>

<BR/>


<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<? if ((isset($_POST["type"])) || (isset($_GET["type"])) ) { ?>
<?




$count= count(get_all_new_feature_notes($type));

$html='';

if($count > 0) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center" ><strong>ID</strong></th>
    <td class="table_header" align="center" ><strong>Type</strong></th>
    <td class="table_header" align="center" ><strong>Title</strong></th>
    <td class="table_header" align="center" ><strong>Description</strong></th>
    <td class="table_header" align="center" ><strong>Date</strong></th>
    <td class="table_header" align="center"><strong>Status</strong></th>
    <td class="table_header" align="center"></th> 
    <td class="table_header" align="center"></th>   
  </tr>


   <?
   $features = get_all_new_feature_notes($type);
   foreach( $features as $feature){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   ?>
  <tr id="tr_<? echo $feature->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $feature->vars["id"]; ?></th>
		<th class="table_td<? echo $style ?>"><? echo $feature->print_type(); ?></th>
        <th class="table_td<? echo $style ?>"><? echo  $feature->vars["title"]; ?></th>
        <th class="table_td<? echo $style ?>">
				<? echo  html_entity_decode($feature->vars["description"], ENT_QUOTES); ; ?>
      
        </th>
        <th class="table_td<? echo $style ?>"><? echo $feature->vars["date"]; ?></th>
        <th id = "th_status_<? echo $feature->vars["id"] ?>" class="table_td<? echo $style ?>">
        <?
		$new_status = "Disable";
        if(!$feature->vars["active"]) {		   
			$new_status = "Active";
        }		
        ?>
        <a class="normal_link" href="javascript:confirmation(<? echo $feature->vars["id"] ?>,'<? echo $new_status ?>','status')"><? echo $feature->print_status(); ?></a>
        </th>
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="<?= BASE_URL ?>/ck/new_feature_create.php?id=<? echo $feature->vars["id"] ?>">Edit</a></th>  
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_feature(<? echo $feature->vars["id"] ?>,'delete')">Delete</a>
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
    <td class="table_last"></td>
    <td class="table_last"></td>

  </tr>
</table>	
<BR>
<? } else { 

    $html='No Data Found';
	echo $html;
}
}
?>
</div>
<? include "../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>