<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cs_logs")){  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$today = $_GET["rdate"];
if($today == ""){$today = date("Y-m-d");}
?>
<? if($today == date("Y-m-d")){ ?><META HTTP-EQUIV="refresh" CONTENT="15"><? } ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Customer Service Logs</title>

<style type="text/css">
body {
	background-color: #FFF;
}
</style>
</head>
<body>
<div id="chat_content">
<?
$tomorrow = date("Y-m-d", strtotime($today."+1 DAY"));
$chats = get_closed_chats_by_date($today, $tomorrow);
$lives = get_live_chats_info();
for($x=0;$x<count($lives);$x++){
	//if(file_exists("http://localhost:8080/livehelp/web/chatsessions/".$live["session"]."_transcript.txt")){
		$lives[$x]["formatted"] = file_get_contents("../livehelp/web/chatsessions/".$lives[$x]["session"]."_transcript.txt");
	//}
}
$chats = array_merge($lives,$chats);
?>

<? if(count($chats)<1){echo "<strong>NO CHATS TO SHOW</strong>";} ?>

<? foreach($chats as $chat){ ?>

	<?
	$content = str_replace("</p>","</p><split>",$chat["formatted"]);
	$content = str_replace("<ts","<strong><!--TIME-->",$content);
	$content = str_replace("ts>","<!--/TIME--></strong>",$content);
	$content = str_replace(":</span>",":</span><br /><br />",$content);
	$parts = explode("<split>",$content);
	$req_time = str_center("<!--TIME-->","<!--/TIME-->",$parts[0]);
	$atend_time = str_center("<!--TIME-->","<!--/TIME-->",$parts[1]);
	$res_delay = strtotime(str_replace(")","",str_replace("(","",$atend_time))) - strtotime(str_replace(")","",str_replace("(","",$req_time)));
	?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="table_header_samll">
        	(<? echo $chat["dep"] ?>)
            <br />
            <? echo $chat["customer"] ?> sent a Chat on <? echo date("M jS",$chat["cdate"]) . " " .  $req_time ?><br />
        	 Attended by <? echo $chat["clerk"] ?><br />
             <span style="color:#069">Response time: <? echo time_diff($res_delay) ?></span>
             
        </td>
      </tr>
      <tr>
        <td class="table_td2">
			<? 
			$parts = array_reverse($parts);			
			foreach($parts as $part){				
				echo $part;
			}
			?>
        </td>
      </tr>
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
    </table>
	
    <br /><hr><br />
    
<? } ?>
</div>

<?  }else{echo "Access Denied";} ?>