<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
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
validations.push({id:"sport",type:"null", msg:"Please Write the Sport"});
validations.push({id:"away_rotation",type:"numeric", msg:"Please Write the Away Rotation Number"});
validations.push({id:"away_team",type:"null", msg:"Please Write the Away Team Name"});
validations.push({id:"home_rotation",type:"numeric", msg:"Please Write the Home Rotation Number"});
validations.push({id:"home_team",type:"null",msg:"Please Write the Home Team Name"});
</script>
<span class="page_title">Add New Game</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="process/actions/add_other_game.php">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Sport:</td>
		<td><input name="sport" type="text" id="sport" /></td>
      </tr>
      <tr>
		<td>Away Rotation Number:</td>
		<td><input name="away_rotation" type="text" id="away_rotation" /></td>
      </tr>
      <tr>
		<td>Away Team Name:</td>
		<td><input name="away_team" type="text" id="away_team" /></td>
      </tr>
      <tr>
		<td>Home Rotation Number:</td>
		<td><input name="home_rotation" type="text" id="home_rotation" /></td>
      </tr>
      <tr>
		<td>Home Team Name:</td>
		<td><input name="home_team" type="text" id="home_team" /></td>
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