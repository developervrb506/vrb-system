<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>My Goals</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
	<span class="page_title">My Goals</span>
    <br /><br /> 
    <? include "includes/print_error.php" ?>
    
    <? $goals = get_all_goals_by_group($current_clerk->vars["user_group"]->vars["id"]) ?>
    <? if(count($goals)>0){ ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header">Description</td>
        <td class="table_header" align="center">Start</td>
        <td class="table_header" align="center">End</td>
        <td class="table_header" align="center">Goal</td>
        <td class="table_header" align="center">Current</td>
        <td class="table_header" align="center">Perc.</td>
      </tr>
      <?
	   $i=0;
	   foreach($goals as $go){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr title="<? echo $go->vars["description"]; ?>">
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $go->vars["description"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["start_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["end_date"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center" id="goal_<? echo $go->vars["id"]; ?>"><? echo $go->vars["goal"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $go->vars["current"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<span id="per_<? echo $go->vars["id"]; ?>"><? echo $go->get_percentage(); ?></span>%
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
      </tr>
  
    </table>
	<? }else{echo "There are no Goals at this moment";} ?>


</div>
<? include "../includes/footer.php" ?>