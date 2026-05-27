<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin") && !$current_clerk->im_allow("john_list_control")  && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");}


$jlists = explode(",",str_replace(" ","",$gsettings["johns_lists_ids"]->vars["value"]));
if(!$current_clerk->im_allow("john_list_control") || in_array($_GET["lid"],$jlists)){


 ?>





<?
$conn_id = ftp_audio_conecction(); // Open Ftp Conection.
$s_clerk = $_POST["clerk_list"];
$s_status =  $_POST["status_list"];
$s_from =  $_POST["from"];
$s_to =  $_POST["to"];
$s_list =  $_POST["list_list"];
$calls = array();
$all_option = true;

$display_clerks = true;
$display_lists = true;
$display_name = true;
$title = "Search";
$search_action = "?all";

$names_per_page = 100;
$page_index =  $_POST["page_index"];

if(isset($_GET["lid"])){
	$display_clerks = true;
	$display_lists = false;
	$display_name = true;
	$list = get_names_list($_GET["lid"]);
	$calls = search_calls($s_clerk, "", $s_from, $s_to, $s_status, $list->vars["id"], $page_index*$names_per_page);
	$count_calls = search_calls($s_clerk, "", $s_from, $s_to, $s_status, $list->vars["id"], $page_index*$names_per_page,true);
	$title = $list->vars["name"];
	$search_action = "?lid=".$list->vars["id"];
}else if(isset($_GET["cid"])){
	$display_clerks = false;
	$display_lists = true;
	$display_name = true;
	$clerk = get_clerk($_GET["cid"]);
	$calls = search_calls($clerk->vars["id"], "", $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page);
	$count_calls = search_calls($clerk->vars["id"], "", $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page,true);
	$title = $clerk->vars["name"];
	$search_action = "?cid=".$clerk->vars["id"];
}else if(isset($_GET["nid"])){
	$display_clerks = true;
	$display_lists = false;
	$display_name = false;
	if(is_numeric($_GET["nid"])){
		$ckname = get_ckname($_GET["nid"]);
	}else{
		$ckname  = get_ckname_by_account($_GET["nid"]);
	}
	
	
	if (!is_null($ckname)) {
	   $title = $ckname->full_name();
   	   $calls = search_calls($s_clerk, $ckname->vars["id"], $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page);
  	 $count_calls = search_calls($s_clerk, $ckname->vars["id"], $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page,true);
	}
	else{
	$calls= array();
	$count_calls=0;
	}
	
	$search_action = "?nid=".$ckname->vars["id"];
}else if(isset($_POST["search"])){
	$calls = search_calls($s_clerk, "", $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page);
	$count_calls = search_calls($s_clerk, "", $s_from, $s_to, $s_status, $s_list, $page_index*$names_per_page,true);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?> Calls</title>
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
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title"><? echo $title ?> Calls</span><br /><br />

<? include "includes/print_error.php" ?>

<form action="calls.php<? echo $search_action ?>" method="post" id="form_search">
<input name="search" type="hidden" id="search" value="1" />
<input name="page_index" type="hidden" id="page_index" value="<? echo $page_index ?>" />
<? //if(!$current_clerk->im_allow("marketing_names")){ ?>
<? //if($display_lists){ ?>
List:
<? include "includes/lists_list.php" ?>
&nbsp;&nbsp;&nbsp;
<? //} ?>

Status:
<? $open_option = true; include "includes/status_list.php" ?>
&nbsp;&nbsp;&nbsp;

<? //if($display_clerks){ ?>
Clerk:
<? $clerks_admin = "2,4,5"; include "includes/clerks_list.php" ?>
&nbsp;&nbsp;&nbsp;
<? //} ?> 
<br /><br />
<?// } ?>
From:
<input name="from" type="text" id="from" value="<? echo $s_from ?>" />
&nbsp;&nbsp;&nbsp;
to:
<input name="to" type="text" id="to" value="<? echo $s_to ?>" />
&nbsp;&nbsp;&nbsp;

<input name="" type="submit" value="Filter" onclick="document.getElementById('page_index').value = '0';" />
</form>
<br /><br />

<? echo $count_calls["num"]." Calls Found" ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Call Id</td>
    <? if($display_lists){ ?><td class="table_header" align="center">List</td><? } ?>
    <? if($display_clerks){ ?><td class="table_header" align="center">Clerk</td><? } ?>
    <? if($display_name){ ?><td class="table_header" align="center">Name</td><? } ?>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Time</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Conv. Result</td>
     <td class="table_header" align="center">Call</td>
  </tr>
  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $name = get_ckname($call->vars["name"]);
	  $clerk = get_clerk($call->vars["clerk"]);
	  $clerk_logins = get_all_clerk_phone_logins($clerk->vars["id"]);
	  
	  $login = array();
	  $k = 0;
	  foreach ($clerk_logins as $clerk_login){
		 $login[$k] = $clerk_login->vars["login"]; 
		 $k++;
	  
	  }
	  $audio = get_call_audio($clerk->vars["ext"],$login,$name->vars["phone"],get_minute_direfence($call->vars["call_start"],10,"-"),get_minute_direfence($call->vars["call_start"],10,"+"));

	  
  ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["id"]; ?></td>
	<? if($display_lists){ ?><td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["list"]->vars["name"]; ?></td><? } ?>
    <? if($display_clerks){ ?><td class="table_td<? echo $style ?>" align="center">
		<? echo $clerk->vars["name"]; ?> (<? echo $clerk->vars["ext"]; ?>)
    </td><? } ?>
    <? if($display_name){ ?><td class="table_td<? echo $style ?>" align="center">
		<a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">
			<? echo $name->full_name(); ?>
        </a>
    </td><? } ?>
    <td class="table_td<? echo $style ?>" align="center"><? echo date("M jS, Y / g:i a",strtotime($call->vars["call_start"])); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->call_time(); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->get_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? 
		if(!is_null($call->vars["conversation_status"])){
			echo $call->vars["conversation_status"]->vars["name"];
			echo "<br />";
			echo date("g:i:s a",strtotime($call->vars["conversation_status_time"]));
		}else{
			echo "N/A";	
		}
        ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
	
	<? if (count($audio)>0 && check_ftp_audio_exist($audio["uniqueid"],$conn_id)){ ?>
        <a href="<?= BASE_URL ?>/ck/audio_box.php?id=<? echo $audio["uniqueid"] ?>" class="normal_link" rel="shadowbox;height=150;width=250"> Listen </a>
   <? } ?>
    </td>
  </tr>
  
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
    <td class="table_last"></td>
  </tr>
</table>
<br /><br />



<?
ftp_audio_close($conn_id); // Closing the FTP conection.

$num_pages = ceil($count_calls["num"] / $names_per_page);
for($i=0;$i<$num_pages;$i++){
	if($i == $page_index){echo $i + 1 ."&nbsp;&nbsp;-&nbsp;&nbsp;";}
	else{
		?>
		<a onclick="change_index('<? echo $i ?>')" href="javascript:;" class="normal_link"><? echo $i + 1 ?></a>&nbsp;&nbsp;-&nbsp;&nbsp;
		<?
	}

?>
<script type="text/javascript">
function change_index(index){
	document.getElementById("page_index").value = index;
	document.getElementById("form_search").submit();
}
</script>
</div>

<? include "../includes/footer.php" ; }


}else{echo "Access denied";}

?>