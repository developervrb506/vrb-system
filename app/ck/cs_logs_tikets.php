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
<? if($today == date("Y-m-d")){ ?><META HTTP-EQUIV="refresh" CONTENT="50"><? } ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Customer Service Logs</title>

<style type="text/css">
body {
	background-color:#fff;
}
</style>
</head>
<body>
<?
$tickets = search_tickets($today, $today, "", "", "all");
$tickets = array_merge(search_ezpay_tickets($today,$today),$tickets);
usort($tickets, array("_ticket", "sort_by_date"));
?>

<? if(count($tickets)<1){echo "<strong>NO TICKETS TO SHOW</strong>";} ?>

<? foreach($tickets as $ticket){ ?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="table_header_samll">
        	<? echo $ticket->vars["tdate"] ?> - (<? echo $ticket->vars["website"] ?>)
            <br />
            <? if( $ticket->vars["website"] == "ezpay" || $ticket->vars["website"] == "buybitcoins" ){ ?>
            
            	<? echo $ticket->vars["subject"]  ?>
                
                <?
				if($ticket->vars["fixed"]){
					echo '<br /><strong style="color:#F00;">Closed</strong>';
				}
				?>
            
            <? }else{ ?>
            
             	Tiket from <? echo $ticket->vars["name"]; ?> (<? echo $ticket->vars["email"]; ?>)
                
                <br />
				<?
                $clerk = get_ticket_clerk($ticket->vars["id"]);
                
                            
                
                if(!is_null($clerk)){
                    $res_time = strtotime(get_response_time($ticket->vars["id"]));
                    $res_delay = $res_time - strtotime($ticket->vars["tdate"]);
                    echo " attended by " . $clerk->vars["name"];
                    echo "<br />";
                    ?><span style="color:#069">Response time: <? echo time_diff($res_delay) ?></span><?
                }
                else{ 
                   ?> 
                   <strong style="color:#F00;">Unattended</strong>
                   <? 
                    }
                // To print Closed  Ticket. 
                if (!$ticket->vars["open"]){?>
                <strong style="color:#F00;">, (Closed)</strong> <? }?>
                
                
             
            <? } ?>
           
            
            
        </td>
      </tr>
      <tr>
        <td class="table_td1">
			<? echo nl2br($ticket->vars["message"]); ?>
       
       		
       		<? if( $ticket->vars["website"] == "ezpay" || $ticket->vars["website"] == "buybitcoins" ){ ?>
            
                <br /><br />
                <?
                $responses = get_ezpay_ticket_responses($ticket->vars["id"]);
                ?>
                <? foreach($responses as $res){ ?>
                <div class="form_box">
                        <strong><? echo $res->vars["name"] ?></strong> on <? echo $res->vars["rdate"] ?><br />
                        <? echo nl2br($res->vars["content"]) ?>
                    </div>
                <? } ?>
            
            <? }else{ ?>
       
                <br /><br />
                <?
                $responses = get_ticket_responses($ticket->vars["id"]);
                $responses = array_reverse($responses);
                ?>
                <? foreach($responses as $res){ ?>
                <div class="form_box" <? if($ticket->is_me($res->vars["by"])){echo 'style="background:#fbfdc2"';} ?>>
                        <strong><? echo $res->vars["by"] ?></strong> on <? echo $res->vars["rdate"] ?><br />
                        <? echo nl2br($res->vars["message"]) ?>
                    </div>
                <? } ?>
            
            <? } ?>
        </td>
      </tr>
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
    </table>
	
    <br /><hr><br />
    
<? } ?>

<?  }else{echo "Access Denied";} ?>