<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_reload")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SBO Reload Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>


<div class="page_content" style="padding-left:10px;">
<span class="page_title">Reload Results</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
$lists = search_names_list_by_name("Reload") ;
$dep=0;
$i=0;
$id_list = "";
$name_list="";
//prepare for the All option
$data = "n.list = ";
foreach  ($lists as $l_id){
$data .= $l_id->vars["id"]." or n.list = ";}
$data = substr($data, 0, -12); 
//Post params
$from = clean_get("from");
if($from == ""){$from = date('Y-m-d',strtotime(date("Y-m-d"). "-7 days" ));}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
$id_list = clean_get("list_list");
if(!$id_list == ""){
$selected_list = get_names_list($id_list);
$name_list= $selected_list->vars["name"];
$data="" ;
}

echo "<pre>";
//print_r($selected_list);
echo "</pre>";


?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
     &nbsp;&nbsp;&nbsp;&nbsp;    
     
<? create_objects_list("list_list", "list_list", $lists, "id", "name", $default_name = "All",$id_list); ?>     
  
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <br /><br />

</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Name</td>
    <td class="table_header">Lastname</td>
    <td class="table_header">Player</td>
    <td class="table_header">Email</td>
    <td class="table_header">Agent</td>
    <td class="table_header">List</td>
    <td class="table_header">Deposit</td>
    <td class="table_header">Calls</td>
  </tr>
  <tr>
    <? echo "<strong>".$name_list."</strong><br>" ?>
  </tr>

<?
if(isset($_POST["list_list"])){
$columns = search_names_by_added_date($from,$to,$id_list,$data);
?>
  

<? foreach($columns as $col){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	if($col->vars["deposit"]){$dep++;}
    ?>
    <tr>
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $col->vars["name"] ?>
    </td>
    
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $col->vars["last_name"] ?>
    </td>
 
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><a href="<?= BASE_URL ?>/ck/edit_name.php?nid=<? echo $col->vars["acc_number"] ?>" class= "normal_link"  target="_blank"><? echo $col->vars["acc_number"]  ?> </a>
    </td>
   
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $col->vars["email"] ?>
    </td>
   
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $col->vars["aff_id"] ?>
    </td>
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $col->vars["list_name"]?>
    </td>
    <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo str_boolean($col->vars["deposit"])?>
    </td>
   
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><a href="<?= BASE_URL ?>/ck/calls.php?nid=<? echo $col->vars["acc_number"] ?>" class="normal_link" target="_blank">Calls</a>
     </td>

    </tr>
  <? }?> 

    <tr>
     <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td> 
      <td class="table_header"></td>     
      <? if (!empty($col) && is_array($col)){ ?>	  
      <td class="table_header"><? echo round(($dep/$i)*100,1); ?>%</td>  
      <? }?>
      <td class="table_header"></td>
      </tr>
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
  <? } ?>  
</table>
</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>