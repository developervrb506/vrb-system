<? 

if(is_null($leads)){
	$leads = search_affiliate_leads($name, $web, $email, $phone, $country, $from_contact, $to_contact, $owner, $status, $disposition, $plan, $ww, $type, $level, $from_cb, $to_cb,$sbo,$p_method);
	echo count($leads) . " leads found.";
}

$charlist = "\n\r\0\x0B";

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" onmouseover="deselect()">
  <tr>
    <td class="table_header" title="Level" align="center">L</td>
    <td class="table_header" title="Level" align="center">AFF ID</td>
    <td class="table_header">Name</td>
    <td class="table_header">Website</td>
    <td class="table_header">Email</td>
    <td class="table_header">Phone</td>
    <td class="table_header">Owner</td>
    <td class="table_header" title="Last Contact Date">LCD</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Disposition</td>
    <td class="table_header" title="Call Back Date">CBD</td>
    <td class="table_header"></td>
    <td class="table_header"></td>
    <td class="table_header"></td>
  </tr>

<?
$i=0;
foreach($leads as $lead){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
    //echo $lead->vars["website"];
    ?>
    <tr>
        <td align="center" class="table_td<? echo $style ?>"><? echo $lead->vars["level"]; ?></td>
        <td align="center" class="table_td<? echo $style ?>"><?
		
		 if (is_null($lead->vars["aff_id"]) || ($lead->vars["aff_id"]) == " " ){
			 if (!is_null($lead->vars["ww_af"]) || ($lead->vars["ww_af"]) == "   " ){
			  echo "ww: ".$lead->vars["ww_af"];
			 }
	     }
		 else{  echo $lead->vars["aff_id"];  }
		 
		 ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->full_name(); ?></td>
        <td class="table_td<? echo $style ?>"><? echo nl2br($lead->vars["website"]); ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->vars["email"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->vars["phone"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->str_owner_name($owners[$lead->vars["owner"]]); ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->get_last_contact_date(); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $statuses[$lead->vars["status"]]["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $dispositions[$lead->vars["disposition"]]["label"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $lead->get_call_back_date(); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="open_affiliates_lead.php?l=<? echo $lead->vars["id"] ?>" class="normal_link" target="_blank">Open</a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="affiliate_lead_history.php?lid=<? echo $lead->vars["id"] ?>" rel="shadowbox;height=230;width=570" class="normal_link">
            	History
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="javascript:;" onclick="if(confirm('Are you sure you want to remove this Lead definitely?')){location.href='process/actions/delete_af_lead.php?af=<? echo $lead->vars["id"] ?>'}" class="normal_link">
            	Delete
            </a>
        </td>
    </tr>	
<?



$line = $lead->vars["level"]." \t ".$lead->vars["aff_id"]." \t ".$lead->full_name()." \t  ".$lead->vars["website"]." \t ".$lead->vars["email"]." \t ".$lead->vars["phone"]." \t ".$lead->str_owner_name($owners[$lead->vars["owner"]])." \t  ".$lead->get_last_contact_date()." \t  ".$statuses[$lead->vars["status"]]["name"]." \t ".$dispositions[$lead->vars["disposition"]]["label"]." \t  ".$lead->get_call_back_date()." \t  ";		
 $line = str_replace(str_split($charlist), ' ', $line);
 $report_line1 .= $line."\n ";
 $report_line2 .= $line."\n ";
 $report_line3 .= $line."\n ";
 
 
}

$report_line2 = str_replace($report_line1,"",$report_line2);
$report_line3 = str_replace($report_line1,"",$report_line3);
$report_line3 = str_replace($report_line2,"",$report_line3);

?>
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>

</table>
