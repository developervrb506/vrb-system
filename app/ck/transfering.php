<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$at = $_GET["i"] + 1;
$transfer = get_transfer_relation($current_clerk->vars["id"]);
$name = get_ckname($transfer->vars["call"]->vars["name"]);
if(is_null($transfer)){header("Location: call.php?e=23");}
else if(!$transfer->vars["pending"]){$transfer->delete(); header("Location: index.php?e=24");}
else if($at == 7){
	$transfer->insert_log("na");
	$transfer->delete();
	header("Location: call.php?e=26");
}
else if($current_clerk->transfer_sender($transfer)){
	$sender = true;
	$to = get_clerk($transfer->vars["to"]);
	if(!is_null(get_open_call($transfer->vars["to"]))){
		$transfer->delete();
		$transfer->insert_log("bu");
		header("Location: call.php?e=22");
	}
	
	$title = "Transferring ".ucwords($name->full_name()) ." Call to " . $to->vars["name"];
}else{
	$from = get_clerk($transfer->vars["from"]);
	$title = $from->vars["name"] . " wants to transfer you a call from " . ucwords($name->full_name());	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? if($sender){ ?><META HTTP-EQUIV="refresh" CONTENT="5; URL=transfering.php?i=<? echo $at ?>"><? } ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Transferring Call</title>
</head>
<body>
<? include "../includes/header.php" ?>
<div class="page_content" style="padding-left:50px; ">
<span class="page_title"><? echo $title ?></span><br /><br />

<div align="center">
<? if($sender){ ?>
	Please wait while transfer is made...
<? }else{ ?>
	Do you want to accept the call?<br /><br />
    
    <table width="200" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>
        	<form method="post" action="process/actions/trasfer_action.php">
                <input name="accepted" type="hidden" id="accepted" value="1" />
                <input name="" type="submit" value="Accept" />
            </form>  
        </td>
        <td>
        	<form method="post" action="process/actions/trasfer_action.php">
                <input name="accepted" type="hidden" id="accepted" value="0" />
                <input name="" type="submit" value="Deny" />
            </form> 
        </td>
      </tr>
    </table>
     
<? } ?>
</div>



</div>
<? include "../includes/footer.php" ?>