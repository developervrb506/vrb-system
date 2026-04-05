<? 
if(!$included){
	include(ROOT_PATH . "/ck/process/security.php"); ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Gambling Check List by day</title>
<? } ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
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
<script type="text/javascript">
 function active_btn(id){

 if(document.getElementById("save_"+id).disabled == false){
	 document.getElementById("save_"+id).disabled = true;
	 }	 else {
	document.getElementById("save_"+id).disabled = false;	 
		 }

}
</script>
<? if(!$included){ ?>
</head>
<body>
<? } ?>
<? 
 if (isset($_POST["from"])){
	$date =  $_POST["from"];
 }
 else{
    $date = date("Y-m-d");	 
 }

?>
<? if(!$included){ ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
  <? } ?>
  <?
if (isset($_POST["id"])){

	$new = new 	_gambling_checklist_by_day();
	$new->vars['day'] = $date;
	$new->vars['clerk'] = $current_clerk->vars["id"];
	$new->vars['datetime'] = date("Y-m-d H:i:s");
	$new->vars['item'] = param('id');
	$new->vars['comment'] = param('comment');
	$new->insert();
	
}

if (isset($_POST["delete"])){

	$del = get_gambling_checklist($_POST["delete"]);
	//$del->delete();
	
}

?>
  <?
   $list = get_all_gambling_checklist();
   $day_list = get_all_gambling_checklist_by_day($date); 
?>
  <span class="page_title"> Gambling Check List by Day </span> <br />
  <br />
  <form method="post" action="" id="forms" name="forms">
    <strong>Date :</strong>
    <input name="from" type="text" id="from" size="20" value="<? echo $date ?>" />
    <input name="asd" type="submit" id="asd" value="Check Day" />
  </form>
  <p>
    <? if(count($list)>0){ ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sortable">
    <thead>
      <tr>
        <th class="table_header" align="center" style="cursor:pointer;"></th>
        <th class="table_header" align="center" style="cursor:pointer;">Data</th>
        <th class="table_header" align="center" style="cursor:pointer;">Comment</th>
        <th class="table_header" align="center" style="cursor:pointer;"></th>
      </tr>
    </thead>
    <tbody>
      <? $i=0; foreach($list as $rea){ $i++; ?>
      <? if($i % 2){$style = "1";}else{$style = "2";} ?>
      <tr>
        <form action="" method="post">
          <input type="hidden" name="from" value="<? echo $date ?>">
          <input type="hidden" name="id" value="<? echo $rea->vars["id"] ?>">
          <td class="table_td<? echo $style ?>" align="center"><? if (!isset($day_list[$date."_".$rea->vars["id"]])) { ?>
              <input onchange="active_btn('<? echo $rea->vars["id"]  ?>')" style="width: 20px; height: 20px;" type="checkbox" name="checked" id="checked">
              <? } 
                   else {
					  echo "Checked by:<BR>";
					  echo $day_list[$date."_".$rea->vars["id"]]->vars["clerk"]->vars["name"]."<BR>";  
					  echo $day_list[$date."_".$rea->vars["id"]]->vars["datetime"]; 
					   
				    } ?></td>
          <td class="table_td<? echo $style ?>" align="center"><? echo $rea->vars["data"] ?></td>
          <td class="table_td<? echo $style ?>" align="center"><textarea name="comment" id="comment" cols="40" <? if (isset($day_list[$date."_".$rea->vars["id"]])) { echo ' readonly="readonly"  ';} ?>   ><? echo $day_list[$date."_".$rea->vars["id"]]->vars["comment"] ?></textarea></td>
          <td class="table_td<? echo $style ?>" align="center"><input name="save" type="submit" id="save_<? echo $rea->vars["id"] ?>" value="Save"  <? if (isset($day_list[$date."_".$rea->vars["id"]])) { echo ' disabled="disabled" ';} else { echo ' disabled="disabled" '; } ?>   /></td>
        </form>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <? }else{ echo "No information to show"; } ?>
  </p>
  <? if(!$included){ ?>
</div>
<? include "/../includes/footer.php" ?>
<? } ?>
