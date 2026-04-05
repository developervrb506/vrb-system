
<?
set_time_limit(300); 

if($current_clerk->vars["level"]->vars["sale_closer"]){
	$lead = "";
}else{
	//$lead = "0";  doesnt allow fronters to get lead names
	$lead = "";
}


$rule_unread = get_no_read_rule($current_clerk->vars["id"]);
if($rule_unread["rule"] != ""){
	?><script type="text/javascript">location.href='view_rule.php?req&rid=<? echo $rule_unread["rule"]  ?>';</script><?
}
?>
<div class="time_marker_box">
	<iframe src="http://localhost:8080/ck/includes/time_logs.php" scrolling="no" width="200" height="100" frameborder="0"></iframe>
</div>


<div class="left_column">
	<div style="float:none;" class="gray_box">
    	<a href="index.php" class="normal_link"><strong>Refresh My Home Page</strong></a>

        <br /><br />
        <a href="transaction_history.php?cid=<? echo $current_clerk->vars["id"] ?>" rel="shadowbox;height=270;width=570" title="Your Transactions History" class="normal_link">
        Your Current Balance: $<? echo $current_clerk->my_balance(); ?>
        </a>

    </div>
	<?
	$open_name = get_open_call($current_clerk->vars["id"]);	
	if(!is_null($open_name)){
	?>
	
	<div style="float:none;" class="gray_box">
    	<a href="call.php" class="normal_link">You Have an Open Call with <strong><? echo $open_name->full_name() ?></strong></a>
    </div>
	
	<? }else{ ?>
	
	<?
	
	//if(!is_null(get_transfer_relation($current_clerk->vars["id"],"1"))){
		?><script type="text/javascript">//location.href='transfering.php';</script><?
	//}
	
	if($current_clerk->vars["level"]->vars["sale_manager"] || $admin_is_clerk){
		echo "<br /><br />";
		$clerks_available = 1;
		$clerks_admin = "2";
		$clerks_deleted = false;
		$your_option = true;
		$s_clerk = $_GET["cbc"];
		$clerk_onchange = "location.href = 'index.php?cbc='+this.value";
		if($admin_is_clerk){$clerk_onchange = "location.href = 'admin_clerk_index.php?cbc='+this.value";}
		
		
		include "includes/clerks_list.php";
		echo " Call Backs:";
		
		if($_GET["cbc"]!=""){
			$cb_clerk = $_GET["cbc"];
		}else{
			$cb_clerk = $current_clerk->vars["id"];
		}
	}else{
		$cb_clerk = $current_clerk->vars["id"];
	}
	
	$names = get_all_call_back_names_light($cb_clerk, $lead);
	$def_status = "-1";
	$index = 0;
	$preid = "";
	foreach($names as $name){
		$index++;
		$name->vars["status"] = get_name_status($name->vars["status"]);
		if($def_status != $name->vars["status"]->vars["id"]){
			if($def_status != -1){ ?>
            	<a href="javascript:;" onclick="display_div('group_<? echo $preid ?>')" class="normal_link">
                	Hide List
                </a>
                </div></div>
			<? }
			$def_status = $name->vars["status"]->vars["id"];
			$preid = $name->vars["status"]->vars["id"];
			?>
            <div style="float:none;" class="gray_box">
            	<strong>
                	<a href="javascript:;" onclick="display_div('group_<? echo $name->vars["status"]->vars["id"]; ?>')" class="normal_link">
						<? echo $name->vars["status"]->vars["name"]; ?>
                    </a>
                    <span id="alerts_<? echo $name->vars["status"]->vars["id"]; ?>" style="font-size:11px; font-weight:bold;"></span>                    
                </strong>
                <div id="group_<? echo $name->vars["status"]->vars["id"]; ?>" style="display:none"><br /><br />
			<?
		}
		$call = get_name_last_call($name->vars["id"]);
		if(in_array($name->vars["list"],array(38,39))){$is_reload = true;}else{$is_reload = false;}
		?>
		<a href="call.php?nid=<? echo $name->vars["id"] ?>" class="normal_link" style="color:#<? echo $name->call_back_color(); ?>">
        	<? if($name->vars["important"]){ ?> <img src="images/important.png" width="20" height="20" alt="I" /> <? } ?>
            <? if($is_reload){ ?> <img src="images/reload.png" width="20" height="20" alt="R" /> <? } ?>
			Please Call Back <strong><? echo $name->full_name() . " " . $name->call_back_str() ?></strong>         
		</a>
        
        <script type="text/javascript">
		<? 
		if($name->vars["important"]){
			if($is_reload){$star = '(!r)';}
			else{$star = '(!)';}			
		}else{
			if($is_reload){$star = '(r)';}
			else{$star = 'x';}
		} 
		
		?>
		//document.getElementById("alerts_<? echo $name->vars["status"]->vars["id"]; ?>").innerHTML += '<span style="color:#<? echo $name->call_back_color(); ?>;"> <? echo $star ?> </span>';
		</script>
        
        <br />

        	<!--(<a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">
            	Open Call History
            </a>)-->
            
            (<? echo $name->vars["state"] ?>)

        <br />
		<span style="font-size:12px;">(<? echo $name->back_status() . " " . date("l, M jS, Y",strtotime($call->vars["call_end"])) ?>)<br /> </span>
		<span style="font-size:12px;">
        	<strong><a href="javascript:;" onclick="display_div('note_<? echo $name->vars["id"] ?>')" class="normal_link">Note</a></strong> 
			<span id="note_<? echo $name->vars["id"] ?>" style="display:none;">
			<? echo nl2br($name->vars["note"]) ?>
            </span>
        </span>
        <br /><br />
		<?
		if($index == count($names)){
			?>
            <a href="javascript:;" onclick="display_div('group_<? echo $name->vars["status"]->vars["id"]; ?>')" class="normal_link">
                Hide List
            </a>
            </div></div>
			<?
		}
	}
	?>
    
    
   <? if($current_clerk->vars["level"]->vars["sale_manager"] || $admin_is_clerk){echo "<br /><br />";} ?>
    
    <? if($current_clerk->vars["level"]->vars["sale_closer"]){ ?>
    <div style="float:none;" class="gray_box"><a href="call.php?lead" class="normal_link">Get New Lead</a></div>
    <? } ?>	
    
    <div style="float:none;" class="gray_box"><a href="call.php" class="normal_link">Get New Name</a></div>
    
    <div style="float:none;" class="gray_box"><a href="add_name.php" class="normal_link">Add New Name</a></div>
    
    <div style="float:none;" class="gray_box">
        <strong>
            <a href="javascript:;" onclick="display_div('group_suo')" class="normal_link">
                Signup Outgoing
            </a>
        </strong>
    
        <div id="group_suo" style="display:none"><br /><br />
        
			<?
            $sign_names = get_all_clerks_names_by_status_light($current_clerk->vars["id"],9,$lead);
            if(count($sign_names)<1){echo "You haven't made any Outgoing Signup";}
            foreach($sign_names as $sname){
                $call = get_call_by_status($sname->vars["id"],9);
                ?>
                
                <a href="call.php?nid=<? echo $sname->vars["id"] ?>" class="normal_link">
                    <strong><? echo $sname->full_name() ?></strong>         
                </a>
                
                <?
				if($sname->vars["free_play"]){echo "&nbsp;<strong>(Free Play)</strong>";}
				?>
                
                
                <br />

                (<a href="call_history.php?nid=<? echo $sname->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $sname->full_name() ?> Call History" class="normal_link">
                    Open Call History
                </a>)
                
                <br />
                <span style="font-size:12px;">(<? echo "Signed up on " . date("l, M jS, Y",strtotime($call->vars["call_end"])) ?>)<br /> </span>
                <span style="font-size:12px;"><strong>Note:</strong> <? echo nl2br($sname->vars["note"]) ?></span><br /><br />
                
                <?
            }
            ?>
        </div>
        
	</div>
    
    
    
    
    <div style="float:none;" class="gray_box">
        <strong>
            <a href="javascript:;" onclick="display_div('group_sui')" class="normal_link">
                Signup Incoming
            </a>
        </strong>
    
        <div id="group_sui" style="display:none"><br /><br />
        
			<?
            $sign_names = get_all_clerks_names_by_status_light($current_clerk->vars["id"],11,$lead);
            if(count($sign_names)<1){echo "You haven't made any Incoming Signup";}
            foreach($sign_names as $sname){
                $call = get_call_by_status($sname->vars["id"],11);
                ?>
                
                <a href="call.php?nid=<? echo $sname->vars["id"] ?>" class="normal_link">
                    <strong><? echo $sname->full_name() ?></strong>         
                </a>
                
                <?
				if($sname->vars["free_play"]){echo "&nbsp;<strong>(Free Play)</strong>";}
				?>
                
                
                <br />

                (<a href="call_history.php?nid=<? echo $sname->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $sname->full_name() ?> Call History" class="normal_link">
                    Open Call History
                </a>)
                
                <br />
                <span style="font-size:12px;">(<? echo "Signed up on " . date("l, M jS, Y",strtotime($call->vars["call_end"])) ?>)<br /> </span>
                <span style="font-size:12px;"><strong>Note:</strong> <? echo nl2br($sname->vars["note"]) ?></span><br /><br />
                
                <?
            }
            ?>
        </div>
        
	</div>
    
    
    
	<? } ?>
    
    <div style="float:none;" class="gray_box">
    	<strong>Rules:</strong><br /><br />
        <?
		$rules = get_all_rules();
		foreach($rules as $rule){
			?><a href="view_rule.php?rid=<? echo $rule->vars["id"] ?>" target="_blank" class="normal_link"><? echo $rule->vars["title"] ?></a><br /><br /><?
		}
		?>
    </div>
    
</div>

<div class="right_column">   
    
	<? if($current_clerk->im_allow("phone_home_stats")){ ?>
    <?php /*?><div id="sales_stats_rep">Loading Sales Stats...</div>
    <br />
    <div id="agent_stats_rep">Loading Agent Stats...</div><?php */?>
    <script type="text/javascript">
	//load_url_content_in_div('http://localhost:8080/ck/includes/phone_home_reports.php',"sales_stats_rep");
	//load_url_content_in_div('http://localhost:8080/ck/includes/agent_phone_home_reports.php',"agent_stats_rep");
	</script>
    <? } ?>
    
    
	<? //include "includes/phone_home_reports.php" ?>
    <br />
    
    <strong>Call History</strong>
    <? $yesterday = date("Y-m-d",strtotime($today."- 1 day")); ?>
    <? $recents = search_calls($current_clerk->vars["id"], "", $yesterday, $today, "", "", 0, false, "0, 20"); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center"></td>
        <td class="table_header">NAME</td>
        <td class="table_header">PHONE</td>
        <td class="table_header" title="Last Call Date">LCD</td>
        <td class="table_header" title="Call Back Date">CBD</td>
        <td class="table_header" align="center">OPEN</td>
        <td class="table_header" align="center">CALLS</td>
      </tr>
    <? $i = 0; foreach($recents as $rcall){ if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
    	<? $rname = get_ckname($rcall->vars["name"]); ?>
        <tr>
          <td rowspan="2" align="center" class="table_td<? echo $style ?>">
          	<? if($rname->vars["important"]){echo "(!)";} ?>
          </td>
          <td class="table_td<? echo $style ?>"><? echo $rname->full_name() ?></td>
          <td class="table_td<? echo $style ?>"><? echo $rname->vars["phone"] ?></td>
          <td class="table_td<? echo $style ?>"><? echo $rcall->vars["call_start"] ?></td>
          <td class="table_td<? echo $style ?>"><? echo $rname->vars["next_date"] ?></td>
          <td class="table_td<? echo $style ?>" align="center">
          	<a href="http://localhost:8080/ck/call.php?nid=<? echo $rname->vars["id"] ?>" class="normal_link">Open</a>
          </td>
          <td class="table_td<? echo $style ?>" align="center">
          	<a href="call_history.php?nid=<? echo $rname->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $rname->full_name() ?> Call History" class="normal_link">Calls</a>
          </td>
        </tr>
        <tr>
        	<td class="table_td<? echo $style ?> table_last2" colspan="7">
            	<div class="form_box">
                	<strong>NOTES:</strong><br />
                	<? echo nl2br(trim($rname->vars["note"])) ?>
                </div>
            </td>
        </tr>
    <? } ?>
    </table>
    
    <br /><br />    
    <? if(!$admin_is_clerk){ ?>
    
        <br /><br />
		<p><a href="message_table.php" class="normal_link">View Messages</a></p>
    
    <? } ?>

</div>