<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js"></script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Pitcher</span><br />
<br />
<? 
//$game = get_baseball_game($_GET["gid"]);

?>
<div class="form_box">
   
  
  <form method="post" action="process/actions/game_hour_update_action.php" >
    <table width="50%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td width="29%">Game StartDate</td>
      </tr>
      <tr>
        <td width="50%">
        	 <input name="gid" type="hidden" id="gid" value="<? echo $game->vars["id"] ?>" />
             Start: 
             <input name="startdate" type="text" id="startdate" value="<? echo $game->vars["startdate"]?>" />
        </td>
      </tr>
      <tr>
        <td width="50%"><input type="submit" value="Update" /></td>
      </tr>
    </table>
    
  </form>
 
</div>
<? if($_GET["in"]){ ?><script type="text/javascript">alert("StartDate has been Updated, Please Refresh");</script><? } ?>
</body>
</html>