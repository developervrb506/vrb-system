<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("goals_admin")){ ?>
<? $goal = get_goal($_GET["gid"]); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
<script type="text/javascript" src="includes/js/bets.js"></script>

<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Please Write a Name"});
validations.push({id:"end",type:"null", msg:"Please select the End Date"});
validations.push({id:"goal",type:"numeric", msg:"Please insert a Goal"});
validations.push({id:"group_list",type:"null", msg:"Please select a Group"});
validations.push({id:"desc",type:"null", msg:"Please Write a Description"});
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"start",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"end",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<span class="page_title">Goal</span><br /><br />
<div class="form_box">
	<form action="process/actions/add_goal.php" method="post" target="_parent" onsubmit="return validate(validations)">
    <input name="edit_id" type="hidden" id="edit_id" value="<? echo $goal->vars["id"] ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Name:</td>
		<td><input name="name" type="text" id="name" value="<? echo $goal->vars["name"] ?>" /></td>
      </tr>
      <tr>
		<td>Group:</td>
		<td><? $s_group = $goal->vars["ugroup"]->vars["id"]; include(ROOT_PATH . "/ck/includes/group_list.php"); ?></td>
      </tr>
      <tr>
		<td>Start:</td>
        <? 
		$def_start = $goal->vars["start_date"];
		if($def_start==""){$def_start = date("Y-m-d");}
		?>
		<td><input name="start" type="text" id="start" readonly="readonly" value="<? echo $def_start ?>" /></td>
      </tr>
      <tr>
		<td>End:</td>
		<td><input name="end" type="text" id="end" readonly="readonly" value="<? echo $goal->vars["end_date"] ?>" /></td>
      </tr>
      <!--<tr>
		<td colspan="2">
        Result should be 
        
        <select name="type" id="type">
          <option value="&gt;" <? if($goal->vars["type"]==">" ){echo 'selected="selected"';} ?>>bigger</option>
          <option value="&lt;" <? if($goal->vars["type"]=="<" ){echo 'selected="selected"';} ?>>smaller</option>
        </select>
        
        than         
        <input name="goal" type="text" id="goal" size="5" value="<? echo $goal->vars["goal"] ?>" />
        </td>
      </tr>-->
      <tr>
		<td>Goal:</td>
		<td><input name="goal" type="text" id="goal" value="<? echo $goal->vars["goal"] ?>" /></td>
      </tr>
      <tr>
		<td>Description:</td>
		<td><textarea name="desc" id="desc"><? echo $goal->vars["description"] ?></textarea></td>
      </tr>
	  <tr>    
		<td><input type="image" src="../images/temp/submit.jpg" /></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
  </form>
</div>
    
</body>
</html>
<? }else{echo "Access Denied";} ?>