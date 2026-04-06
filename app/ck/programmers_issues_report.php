<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Programmers Issues Report</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datef",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Programmer Issues Report</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
$admin = $current_clerk->admin();
if($_POST["datef"]==""){$from = date('Y-m-d');}else{$from = $_POST["datef"];} 
if($_POST["datet"]==""){$to = date('Y-m-d');}else{$to = $_POST["datet"];}
$status = $_POST["status"];
$all_option = true;

$clerk= 0;
if($_POST["clerk_list"] != ""){
   $clerk = $_POST["clerk_list"];
}
$agent = $clerk;

$clerks = get_permissions_clerk("programmers_issues");
$str_clerks = "";

foreach ($clerks as $_clerk){
  $str_clerks	.= "'".$_clerk->vars["user"]."',";
}

$str_clerks = substr($str_clerks,0,-1);
$clerks_list = get_all_clerks_exclude_list($str_clerks ,false,true);

?>
<form method="post">
From: <input name="datef" type="text" id="datef" value="<? echo $from ?>" readonly="readonly" />&nbsp;&nbsp;

To: <input name="datet" type="text" id="datet" value="<? echo $to ?>" readonly="readonly" />&nbsp;&nbsp;

Status: 
<select name="status" id="status">
  <option value="">All</option>
  <option value="pe" <? if($status == "pe"){echo 'selected="selected"';} ?>>Pending</option>
  <option value="so" <? if($status == "so"){echo 'selected="selected"';} ?>>Solved</option>
  <option value="cl" <? if($status == "cl"){echo 'selected="selected"';} ?>>Closed</option>
</select>

Created by <?  $clerk ?>:
      <select name="clerk_list" id="clerk_list">
			     <option  <? //if($clerk == "") { echo 'selected="selected"' ;} ?>  value ="">All</option>
				 <? foreach ($clerks_list as $clerk_list) {?>
                 <option <? if($clerk == $clerk_list->vars["id"]) { echo 'selected="selected"' ;} ?> value="<? echo $clerk_list->vars["id"] ?>" ><? echo $clerk_list->vars["name"]?></option>
			     <? } ?>
      </select> 
	   
	   
	   
	   <? // $s_clerk= $clerk; include "includes/clerks_list.php" ; ?>
	   

&nbsp;&nbsp;

<input type="submit" value="Search" />
</form>
<br /><br />

<?
    $tickets = search_programmers_issues_tickets($from, $to, $status, $agent,$admin);
?>

   

<? if(count($tickets)>0){ ?>  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Open by</td>
        <td class="table_header" align="center">Subject</td>
        <td class="table_header" align="center">Issue</td>
        <td class="table_header" align="center">Solution</td>
        <td class="table_header" align="center">Solved by</td>
        <td class="table_header" align="center">Solved Date</td>
        <td class="table_header" align="center">Status</td>
        <? if ($admin) { ?>
        <td class="table_header" align="center">Assigned</td>
        <? } ?>
        
        <td class="table_header" align="center"></td>
      </tr>
  <?
  $i=0;	   
   foreach($tickets as $tik){
	   if($i % 2){$style = "1";}else{$style = "2";}
	   $i++;
	  
  ?>
  <tr>
	   <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["created_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["by"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["title"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["description"],50); ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["solution"],50); ?></td>

        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["solutioned_by"]->vars["name"]; ?></td>
       <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["solution_date"]; ?></td>     
       <td class="table_td<? echo $style ?>" align="center"><? echo $tik->str_status(); ?></td>
        <? if ($admin) { ?>
       <td class="table_td<? echo $style ?>" align="center"><?
	       if ($tik->vars["assigned"] !=0){
		   		   echo "<strong>".$tik->vars["assigned"]->vars["name"]."</strong>";
		   } //else {echo "Free";}
		   ?>
         </td>
       <? } ?>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="programmers_issues.php?detail&tid=<? echo $tik->vars["id"]; ?>&close=1" class="normal_link">View</a>
        </td>
      </td>
  <? } ?>
  <tr>
     <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
         <td class="table_last"></td>
        <? if ($admin) { ?>
        <td class="table_last"></td>
        <? } ?>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
  </tr>

</table>
<? }else{echo "No Issues Found";} ?>


</div>
<? include "../includes/footer.php" ?>
