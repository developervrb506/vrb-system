<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_freeplays")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upid = get_agent_freeplay_amount($_POST["update_id"]);
		$upid->vars["agent"] = strtoupper($_POST["agent"]);
		$upid->vars["amount"] = $_POST["amount"];
		$upid->vars["enable"] = $_POST["enable"];
		if(!$upid->vars["enable"]){$upid->vars["enable"] = "0";}
		$upid->vars["comment"] = $_POST["comment"];
		$upid->update();
	}else{
		$exaff = get_agent_freeplay_amount_by_af($_POST["agent"]);
		if(is_null($exaff)){
			$newid = new _agent_freeplay_amount();
			$newid->vars["agent"] = strtoupper($_POST["agent"]);
			$newid->vars["amount"] = $_POST["amount"];
			$newid->vars["enable"] = $_POST["enable"];
			if(!$newid->vars["enable"]){$newid->vars["enable"] = "0";}
			$newid->vars["comment"] = $_POST["comment"];
			$newid->insert();
		}else{
			$exaff->vars["agent"] = strtoupper($_POST["agent"]);
			$exaff->vars["amount"] = $_POST["amount"];
			$exaff->vars["enable"] = $_POST["enable"];
			if(!$exaff->vars["enable"]){$exaff->vars["enable"] = "0";}
			$exaff->vars["comment"] = $_POST["comment"];
			$exaff->update();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliates Freeplays</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$relation = get_agent_freeplay_amount($_GET["idf"]);
	if(is_null($relation)){
		$title = "Add new FreePlay";
		$enable = true;
	}else{
		$title = "Edit FreePlay";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$relation->vars["id"] .'" />';
		$read = 'readonly="readonly"';
		if($relation->vars["enable"]){$enable = true;}else{$enable = false;}
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"agent",type:"null", msg:"Affiliate is required"});
	validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
    </script>
	<div class="form_box" style="width:400px;">
        <form method="post" action="agent_freeplays.php?e=56" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Affiliate</td>
            <td><input name="agent" type="text" id="agent" value="<? echo $relation->vars["agent"] ?>" <? echo $read ?>/></td>
          </tr> 
          <tr>
            <td>Amount</td>
            <td><input name="amount" type="text" id="amount" value="<? echo $relation->vars["amount"] ?>" /></td>
          </tr>
          <tr>
            <td>Enable</td>
            <td><input name="enable" type="checkbox" id="enable" value="1" <? if($enable){echo 'checked="checked"';} ?> /></td>
          </tr>
          <tr>
            <td>Comment</td>
            <td><textarea name="comment" id="comment"><? echo $relation->vars["comment"] ?></textarea></td>
          </tr>
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
	?>
    <span class="page_title">Affiliates FreePlays</span><br /><br />
    <a href="?detail" class="normal_link">+ Add FreePlay</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="agents_freeplays_report.php" class="normal_link">Report</a>
    <br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Affiliate</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Comment</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $relations = get_all_agent_freeplay_amounts();
	   foreach($relations as $cm){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr <? if(!$cm->vars["enable"]){ ?>style="color:#F00;"<? } ?>>
        <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["agent"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo $cm->vars["amount"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["comment"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&idf=<? echo $cm->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>