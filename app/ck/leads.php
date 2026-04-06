<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$names_per_page = 25;
$page_index =  $_POST["page_index"];

if(isset($_POST["fire_action"])){
	$ids = explode(",",$_POST["ids"]);
	foreach($ids as $id){
		$action = $_POST["action_".$id];
		if($action != ""){
			$name = get_ckname($id);
			switch($action){
				case "update":
					if(!$name->vars["on_the_phone"]){
						if(!$name->vars["closer_attended"] && $_POST["clerk_list_".$id] != ""){
							$name->insert_lead_transfer();
							//echo "insert lead<br />";
						}
						if($_POST["clerk_list_".$id] != ""){
							$name->vars["closer_attended"] = 1;	
							$name->vars["clerk"] = $_POST["clerk_list_".$id];
							//echo "change clerk<br />";
						}
						$name->vars["next_date"] = $_POST["call_back_date_".$id];						
						$name->update(NULL,true);
						//echo "update<br />";
					}
				break;
				case "deposit":
					$name->vars["deposit"] = 1;
					$name->vars["available"] = "0";
					$name->update(NULL,true);
					//echo "deposit<br />";
				break;
				case "limbo":
					$name->vars["status"] = 10;
					$name->vars["available"] = "0";
					$name->update(NULL,true);
					//echo "limbo<br />";
				break;	
				case "fronter":
					$name->vars["lead"] = "0";
					$name->vars["closer_attended"] = "0";
					$name->vars["status"] = "1";
					$name->vars["clerk"] = "0";	
					$name->vars["next_date"] = "0000-00-00 00:00:00";
					$name->update(NULL,true);
					//echo "front<br />";
				break;	
			}
		}
	}
}

$names = get_all_lead_names(false, $page_index*$names_per_page, $names_per_page);
$count_names = get_all_lead_names(true);
$ids = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar_time/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Lead Names</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Lead Names</span><br /><br />

<? include "includes/print_error.php" ?>

<form action="" method="post" id="pager_form">
    <input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />
</form>

<? echo $count_names["number"]." Lead Names" ?>
<form action="?e=36" method="post" id="pager_form">
	<input name="page_index" type="hidden" id="page_index_action" value="<? echo $page_index ?>" />    
    <input name="fire_action" type="hidden" id="fire_action" value="1" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">List</td>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Last</td>
        <td class="table_header" align="center">Clerk</td>
        <td class="table_header" align="center">Status</td>
        <td class="table_header" align="center">Calls</td>
        <td class="table_header" align="center">Closer</td>
        <td class="table_header" align="center">Call Back Date</td>
        <td class="table_header" align="center">Action</td>
      </tr>
      <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
      	<? $ids .= ",".$name->vars["id"]; ?>
      
      <tr>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <? echo "<strong>".$name->vars["list"]->vars["name"]."</strong>"; ?>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["last_name"]; ?></td>
    
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <? 	echo "<strong>".$name->vars["clerk"]->vars["name"]."</strong>";	?>
        </td>
    
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <? echo $name->vars["status"]->vars["name"]; ?>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">Calls</a>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <? 
            $s_clerk = "";
            $select_option = true; 
            if($name->vars["closer_attended"]){$s_clerk = $name->vars["clerk"]->vars["id"];}
            $extra_cid = "_".$name->vars["id"];
            $clerks_admin = "4"; include "includes/clerks_list.php" 
            ?>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <input name="call_back_date_<? echo $name->vars["id"] ?>" type="text" id="call_back_date_<? echo $name->vars["id"] ?>"  onClick="javascript:NewCssCal(this.id)" value="<? echo $name->vars["next_date"] ?>" size="15" readonly="readonly" />
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <select name="action_<? echo $name->vars["id"] ?>" id="action_<? echo $name->vars["id"] ?>">
              <option value="">None</option>
              <option value="update">Update</option>
              <option value="deposit">Deposit</option>
              <option value="limbo">Limbo</option>
              <option value="fronter">Fronter</option>
            </select>
        </td>
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
        <td class="table_last"></td>
      </tr>
    </table>
    <br /><br />
    <input name="ids" type="hidden" id="ids" value="<? echo substr($ids, 1); ?>" />
    <div align="right"><input name="" type="submit" value="Submit" /></div>
</form>
<br /><br />
<?
$num_pages = ceil($count_names["number"] / $names_per_page);
for($i=0;$i<$num_pages;$i++){
	if($i == $page_index){echo $i + 1 ."&nbsp;&nbsp;-&nbsp;&nbsp;";}
	else{
		?>
		<a onclick="change_index('<? echo $i ?>')" href="javascript:;" class="normal_link"><? echo $i + 1 ?></a>&nbsp;&nbsp;-&nbsp;&nbsp;
		<?
	}
}
?>
<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("pager_form").submit();
}
</script>
</div>
<? include "../includes/footer.php" ?>