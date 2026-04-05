<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("email_requests")){ ?>
<?
$from = $_POST["from"];
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
if(!isset($_POST["status"])){$status = "0";}else{$status = $_POST["status"];}
$name = $_POST["name"];
$email = $_POST["email"];
$player = $_POST["player"];
$i=0;
$reqs = search_email_requests($from, $to, $status, $name, $email, $player);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Email Requests</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Email Requests</span><br /><br />

<div class="form_box">
<form method="post">
	From: <input name="from" type="text" id="from" value="<? echo $from ?>" />&nbsp;&nbsp;&nbsp;
    To: <input name="to" type="text" id="to" readonly="readonly" value="<? echo $to ?>" />&nbsp;&nbsp;&nbsp;
    Status: 
    <select name="status" id="status">
      <option value="">All</option>
      <option value="0" <? if($status == "0"){ ?>selected="selected" <? } ?>>Pending</option>
      <option value="1" <? if($status == "1"){ ?>selected="selected" <? } ?>>Complete</option>
    </select>
    &nbsp;&nbsp;&nbsp;
    Name: <input name="name" type="text" id="name" value="<? echo $name ?>" />&nbsp;&nbsp;&nbsp;
    Email: <input name="email" type="text" id="email" value="<? echo $email ?>" />&nbsp;&nbsp;&nbsp;
    Account: <input name="player" type="text" id="player" value="<? echo $player ?>" />&nbsp;&nbsp;&nbsp;
    <input name="" type="submit" value="Search" />
</form>
</div>

<br />

<? include "includes/print_error.php" ?>
<iframe width="1" height="1" frameborder="0" id="updater" name="updater" scrolling="no"></iframe>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header">Name</td>
        <td class="table_header">Email</td>
        <td class="table_header">Account</td>
        <td class="table_header">List</td>
        <td class="table_header">Request</td>
        <td class="table_header">Date</td>
        <td class="table_header">Clerk's Notes</td>
        <td class="table_header">Clerk</td>
        <td class="table_header">Notes</td>
        <td class="table_header"></td>
      </tr>
      <? foreach($reqs as $req){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
		<? $crm_name = get_ckname($req->vars["ckname"]); ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $req->vars["id"]; ?></td>
		<td class="table_td<? echo $style ?>"><? echo ucwords(strtolower($req->vars["name"])); ?></td>  
        <td class="table_td<? echo $style ?>"><? echo strtolower($req->vars["email"]); ?></td> 
        <td class="table_td<? echo $style ?>"><? echo $req->vars["player"]; ?></td> 
        <td class="table_td<? echo $style ?>"><? echo $req->vars["list"]; ?></td>    
        <td class="table_td<? echo $style ?>" style="font-size:11px;"><? echo nl2br($crm_name->vars["email_desc"]); ?></td>    
        <td class="table_td<? echo $style ?>" style="font-size:11px;"><? echo $req->vars["rdate"]; ?></td>    
        <td class="table_td<? echo $style ?>" style="font-size:11px;"><? echo nl2br($crm_name->vars["note"]); ?></td>    
        <td class="table_td<? echo $style ?>"><? echo $crm_name->vars["clerk"]->vars["name"]; ?></td>    
        <td class="table_td<? echo $style ?>">
        	<form method="post" action="process/actions/update_email_request.php" target="updater">
            	<input name="action" type="hidden" id="action" value="add_note" />
                <input name="rid" type="hidden" id="rid" value="<? echo $req->vars["id"]; ?>" />
                <textarea name="notes" cols="15" rows="3" id="notes"><? echo $req->vars["notes"] ?></textarea><br />
                <input name="" type="submit" value="Update" />
          </form>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<? 
			if($req->vars["complete"]){
				echo "<strong>Completed</strong>";
			}else{
				
				?>
                <strong id="done_field_<? echo $req->vars["id"]; ?>">
                <form method="post" action="process/actions/update_email_request.php" target="updater" id="frm_<? echo $req->vars["id"]; ?>">
                  <input name="action" type="hidden" id="action" value="complete" />
                  <input name="rid" type="hidden" id="rid" value="<? echo $req->vars["id"]; ?>" />
                  <input name="" type="button" value="Done" onclick="complete_request('<? echo $req->vars["id"]; ?>')" />
                </form>
                </strong>
                <?
			}
			?>
            
        </td>
      </tr>
      <? } ?>
      <tr>
        <td class="table_last" colspan="1000"></td>
      </tr>
    </table>

<script type="text/javascript">
function complete_request(id){
	if(confirm("Are you sure you want to Complete this Request?")){
		document.getElementById("frm_"+id).submit();
		document.getElementById("done_field_"+id).innerHTML = "Completed";
	}
}
</script>
</div>
<? include "../includes/footer.php" ?>
<? } ?>