<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
Shadowbox.init();
function delete_tweet(id){
	if(confirm("Are you sure you want to DELETE this Tweet from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_tweet.php?tweet="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
</head>
<?

if (isset($_POST["lid"])) {
  $lid = $_POST["lid"];
  unset($_POST["lid"]);
  unset($_POST["submit"]);
  $geo_states = get_states_by_geo_list($lid);
  $states_in = array();
  $states_old = array();

  foreach ($_POST as $state){
	$states_in[]=$state;
  }
  foreach ($geo_states as $geo_state){
	$states_old[]=$geo_state["state"];
  }
  
  $delete_array = array_diff ( $states_old ,$states_in );
  $add_array = array_diff (  $states_in,$states_old  );
  
    //Add New States
	if (count($add_array)>0) {
	  foreach ($add_array as $add) {
	   	insert_geo_list($lid,$add); 
	  }
	}
	 
	
    //Remove States
	if (count($delete_array)>0) {
	  foreach ($delete_array as $remove) {
        delete_geo_list($lid,$remove);
	  }
	} 
    

}

 if (isset($_GET["lid"])) { 
  $lid = $_GET["lid"];
 }
 
 

$states = get_states_by_list($lid);
$geo_states = get_states_by_geo_list($lid);


?>
<body>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">List: <? echo $_GET["name"]?></span><br /><br />

<form action="" method="post">
<input name="lid" type="hidden" value="<? echo $lid ?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td class="table_header" align="center">State</td>
    <td class="table_header" align="center"></td>
  </tr> 
    
  <? $i = 0; 
    foreach ($states as $state) {
	if($i % 2){$style = "1";}else{$style = "2";} $i++;?>
    <tr>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
	 <? echo $state["state"] ?> 
     </td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
     <input <? if (isset($geo_states[$state["state"]])){ echo 'checked="checked"'; }  ?>  id="<? echo $i?>_state" name="<? echo $state["state"] ?>" type="checkbox" value="<? echo $state["state"] ?>" />
     </td>
     </tr>
  <? } ?>
  <tr align="center">
    <td>
    <BR>
    <input style="width:100px" name="submit" type="submit" value="Save" />
    </td>
  </tr>
  
</table>

     
</form>



<div align="right">
	<iframe src="<?= BASE_URL ?>/ck/process/actions/delete_tweet.php" width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

</div>


</body>