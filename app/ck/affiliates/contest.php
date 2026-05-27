<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? require_once(ROOT_PATH . '/ck/affiliates/contests/functions.php'); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Contest</title>
  <link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>

<script type="text/javascript">
function change_page(value){
	document.location.href = BASE_URL . "/ck/affiliates/contest.php?gd=" + value;
}
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/affiliates/contests/functions.js"></script>
</head>
 <? $page_style = " width:1400px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<?
$graded = $_GET["gd"];
if($graded == ""){$graded = 0;}


?>
<body>
<div class="page_content" style="padding-left:50px;">
<?php if (isset($_GET['message'])) : ?>
<div id="message" class="updated fade"><p><?php echo $_GET['message']; ?></p></div>
<?php endif; ?>

<div class="wrap">
<h2>Contests</h2> 
  <select name="grade_list" id="grade_list" onChange="change_page(this.value)">
    <option value="0">Not Graded</option>
    <option value="1">Graded</option>
    <option value="3">Canceled</option>
  </select>
<!-- Contenido -->
<script language="javascript" type="text/javascript">
	change_dropdown("grade_list","<? echo $graded ?>",false);
	function delete_contest(id){
		var answer = confirm ("Are you sure you want to DELETE the contest?")
		if (answer){location.href = 'process/actions/contests_action.php?id=' + id+"&action=delete";}
	}
	function cancel_contest(id){
		var answer = confirm ("Are you sure you want to CANCEL the contest?")
		if (answer){location.href = 'process/actions/contests_action.php?id=' + id+"&action=cancel"}
	}
</script>
<input onClick="location.href = 'contest_add.php'" type="button" name="Button" value="+ Add New Contest" />
<br><br>
<? echo "Current Time: " . date("Y-m-d H:i",time()); ?>


<br>
    <table id="sort_table" class="sortable" style="cursor:pointer;">
    <thead>
        <tr>
            <th class="table_header" scope="col" style="text-align: center">Id</th>
            <th class="table_header" scope="col" style="text-align: center">League</th>
            <th class="table_header" scope="col" style="text-align: center">Name</th>
            <th class="table_header" scope="col" style="text-align: center">Open Date</th>
            <th class="table_header" scope="col" style="text-align: center">Close Date</th>
            <th class="table_header" scope="col" style="text-align: center">Points</th>
            <th class="table_header" scope="col" style="text-align: center">Entries</th>
            <th class="table_header" scope="col" style="text-align: center">Visible</th>
            <th class="table_header" scope="col" style="text-align: center">Graded</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Edit</th>
            <th scope="col" style="text-align: center" class="table_header sorttable_nosort">Grade</th>
            <th scope="col" style="text-align: center" class="table_header sorttable_nosort">Cancel</th>
            <th scope="col" style="text-align: center" class="table_header sorttable_nosort">Delete</th>
        </tr>
    </thead>
    <tbody id="the-list">
    <?
	$contests = get_all_contests_graded($graded);
	foreach($contests as $contest){
	
	 if($i % 2){$style = "1";}else{$style = "2";} $i++; 
	?>
    
        <tr <? if(!is_on_air($contest->open_date, $contest->close_date, 0) && $graded == 0){echo 'style="background:#FF9"'; } ?> >
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["id"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["league"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["name"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["open_date"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["close_date"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $contest->vars["points"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo get_contest_entries($contest->vars["id"]); ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo str_boolean($contest->vars["visible"]) ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo str_boolean($contest->vars["check"]) ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="location.href = 'contest_add.php?id=<? echo $contest->vars["id"] ?>'" type="button" name="Button" value="Click Here" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="location.href = 'contest_grade.php?id=<? echo $contest->vars["id"] ?>'" type="button" name="Button" value="Click Here" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="cancel_contest('<? echo $contest->vars["id"] ?>')" type="button" name="Button" value="Click Here" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="delete_contest('<? echo $contest->vars["id"] ?>')" type="button" name="Button" value="Click Here" /></th>
        </tr>  
    <? } ?>  
    </tbody>
    </table>
      
<!-- Fin Contenido -->
 </div>
</div>
</BODY>





<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>