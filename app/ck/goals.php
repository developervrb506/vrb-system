<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("goals_admin")){ 



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Goals</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
Shadowbox.init();
function live_perc(id){
	var current = document.getElementById("current_"+id).value;
	var goal = document.getElementById("goal_"+id).innerHTML;
	var perc = document.getElementById("per_"+id);
	if(IsNumeric(current)){
		perc.innerHTML = Math.round((current * 100) / goal);
	}else{
		perc.innerHTML = "N/A";
	}
}
function update_current(id){
	var current = document.getElementById("current_"+id).value;
	var iframe = document.getElementById("sender");
	iframe.src = "process/actions/update_goal_current.php?gid="+id+"&cr="+current;
	alert("Updated");
}
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
	<span class="page_title">Goals</span>    
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="insert_goal.php" class="normal_link" rel="shadowbox;height=475;width=475">
    	+ Add New Goal
    </a>
    <br /><br />
    <? include "includes/print_error.php" ?>
    
    <? $goals = get_all_goals() ?>
    
    <iframe frameborder="0" scrolling="no" width="0" height="0" src="" id="sender"></iframe>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Start</td>
        <td class="table_header" align="center">End</td>
        <td class="table_header" align="center">Goal</td>
        <td class="table_header" align="center">Current</td>
        <td class="table_header" align="center">Perc.</td>
        <td class="table_header" align="center">Group</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	   $i=0;
	   foreach($goals as $go){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr title="<? echo $go->vars["description"]; ?>">
        <td class="table_td_<? echo $style ?>" align="center"><? echo $go->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["start_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["end_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center" id="goal_<? echo $go->vars["id"]; ?>"><? echo $go->vars["goal"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<input name="current_<? echo $go->vars["id"]; ?>" type="text" id="current_<? echo $go->vars["id"]; ?>" value="<? echo $go->vars["current"]; ?>" size="4" onkeyup="live_perc('<? echo $go->vars["id"]; ?>');" />
            <input name="" type="button" value="update" style="font-size:11px;" onclick="update_current('<? echo $go->vars["id"]; ?>');" />
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<span id="per_<? echo $go->vars["id"]; ?>"><? echo $go->get_percentage(); ?></span>%
        </td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["ugroup"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
       	  <a href="insert_goal.php?gid=<? echo $go->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=475;width=475">Edit</a>
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
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>