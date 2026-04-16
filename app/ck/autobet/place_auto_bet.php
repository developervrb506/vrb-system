<? set_time_limit(900) ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Auto Bet</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../includes/js/bets.js"></script>
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
<script type="text/javascript" src="../../process/js/jquery.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"sport",type:"null", msg:"Sport is required"});
validations.push({id:"rotation",type:"numeric", msg:"Rotation is required"});
validations.push({id:"line",type:"null", msg:"Line is required"});
validations.push({id:"juice",type:"numeric", msg:"Juice is required"});
validations.push({id:"type",type:"null", msg:"Type is required"});
</script>
<style type="text/css">
.input_line{
	width:80px;
	text-align:center;
	cursor:pointer;
}
</style>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
    <span class="page_title">Automatic Betting Basic Mode</span><br /><br />
    
    <a href="sum_mode.php" class="normal_link">Pro Mode</a>
    
    <br /><br />
    
    
    <?
	$sport = $_POST["sport"];
	$period = $_POST["period"];
	$rotation = $_POST["rotation"];
	$amount = $_POST["amount"];
	$bet_line = $_POST["line"];
	$juice = $_POST["juice"];
	$type = $_POST["type"];
	$group = $_POST["betting_groups_list"];
	$placer = $_POST["placer"];
	?>
    
    
    
    <form method="post" onsubmit="return validate(validations)">
    <input type="hidden" name="poster" id="poster" value="1" />
    <div class="form_box">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="33%">
            Sport:<br />
            <select name="sport" id="sport" onchange="change_period_drop()" class="ab_input">
            	<option value="">-Select-</option>
            	<? foreach(get_betting_sports() as $sp){ ?>
                <option value="<? echo $sp["name"] ?>" <? if($sport == $sp["name"]){ ?>selected="selected"<? } ?>><? echo $sp["name"] ?></option>
                <? } ?>
            </select>
        </td>
        <td width="33%">Period:<br />
          
          <div id="periods_box">
          Select the Sport
          </div>
          <? if($sport != ""){ ?> <script type="text/javascript">change_period_drop(); load_dropdown('period','<? echo $period ?>');</script> <? } ?>
        </td>
        <td width="33%">Rotation: <span class="little">(Away team for Total Bets)</span><br />
          <input name="rotation" type="text" id="rotation" size="7" value="<? echo $rotation ?>" class="ab_input" /></td>
      </tr>
      <tr>
        <td width="33%">
            Line:<br />
            <input name="line" type="text" id="line" size="7" value="<? echo $bet_line ?>" class="ab_input" />
        </td>
        <td width="33%">
            Juice:<br />
            <? if($juice == ""){$juice = "-110";} ?>
            <input name="juice" type="text" id="juice" size="7" class="ab_input" value="<? echo $juice ?>" <? if($type == "m"){ ?>disabled="disabled"<? } ?> />
        </td>
        <td width="33%">
            Type:<br />
            <select name="type" id="type" onchange="manage_juice(this.value);" class="ab_input">
            	<option value="">-Select-</option>
                <option value="m" <? if($type == "m"){ ?>selected="selected"<? } ?>>Money</option>
                <option value="s" <? if($type == "s"){ ?>selected="selected"<? } ?>>Spread</option>
                <option value="o" <? if($type == "o"){ ?>selected="selected"<? } ?>>Over</option>
                <option value="u" <? if($type == "u"){ ?>selected="selected"<? } ?>>Under</option>
            </select>
            <script type="text/javascript">
            function manage_juice(ttype){
				if(ttype == "m"){$("#juice").prop('disabled', true);}
				else{$("#juice").prop('disabled', false);}
			}
            </script>
        </td>
      </tr>
      <tr>
        <td width="33%">Amount:<br />
          <input name="amount" type="text" id="amount" size="7" value="<? echo $amount ?>" class="ab_input" /></td>
        <td width="33%">Group:<br />
          <? $none_option = true; $current_group = $group; include "../includes/betting_groups_list.php"; ?></td>
        <td width="33%"><?php /*?>Action:<br />
          <select name="action" id="action">
            <option value="manual">Manual Bet</option>
            <option value="auto">Auto Bet</option>
          </select><?php */?>
          </td>
      </tr>
    </table>
    <p><input name="submitbtn" type="submit" value="Load Preview" class="ab_btn1" /></p>
    </div>
    </form>
    
    
    
    
    <br /><br />
    
    
    
    
    
    
    
    
    
    
    
    
    <? if($placer){ ?> <h3>Results</h3> <? }else{ ?> <h3>Preview</h3> <? } ?>
    
    
    <?
    if($_POST["poster"]){
		
		$softwares = get_all_betting_softwares();
		
		foreach($softwares as $soft){	
			include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
		}
		include(ROOT_PATH . "/ck/autobet/sort.php");
		
		$_sorter = new _line_sorter();
		
		
		
		if(!is_numeric($amount)){$amount = 1000000000;}
		$otype = $type;
		switch($type){
			case "m": $big_type = "money"; break;	
			case "s": $big_type = "spread"; break;	
			case "o": $big_type = "over"; $type = "t"; break;
			case "u": $big_type = "under"; $type = "t"; break;		
		}
		
		?>
        <form method="post" id="submiter"  name="submiter">
        <input type="hidden" name="poster" id="poster" value="1" />
        <input type="hidden" name="sport" id="sport" value="<? echo $sport ?>" />
        <input type="hidden" name="period" id="period" value="<? echo $period ?>" />
        <input type="hidden" name="rotation" id="rotation" value="<? echo $rotation ?>" />
        <input type="hidden" name="line" id="line" value="<? echo $bet_line ?>" />
        <input type="hidden" name="juice" id="juice" value="<? echo $juice ?>" />
        <input type="hidden" name="amount" id="amount" value="<? echo $amount ?>" />
        <input type="hidden" name="type" id="type" value="<? echo $otype ?>" />
        <input type="hidden" name="betting_groups_list" id="betting_groups_list" value="<? echo $group ?>" />
        <p>
        <strong>Sport:</strong> <? echo $sport ?> | 
        <strong>Period:</strong> <? echo $period ?> | 
        <strong>Type:</strong> <? echo $big_type ?><br />
        <strong>Rotaion:</strong> <? echo $rotation; ?><br />
        <strong>Line:</strong> <? echo $_sorter->sort_line($big_type,$bet_line,$juice); ?><br />
        </p>
        
		<?
		
		$accounts =  get_auto_betting_accounts($group);
		$lines_list = array();
		$errors_list = array();
		
		$all_settings = get_all_betting_auto_settings();
		$all_proxys = get_all_betting_proxys();
		
		foreach($accounts as $acc){
			$settings = $all_settings[$acc->vars["id"]];
			
			if($placer){
				if($_POST["chk_".$acc->vars["id"]]){$acc_amount = $_POST["acc_amount_".$acc->vars["id"]];}
				else{$acc_amount = 0;}
				$preplace = true;	
			}else{
				$acc_amount = $settings->vars[$sport."_".$type]/* * ($acc->vars["description"] / 100)*/;		
				$preplace = false;
			}		
			
			if(is_numeric($acc_amount) && $acc_amount > 0){
				
				$proxy = $all_proxys[$settings->vars["proxy"]];
				
				eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot(\$proxy);");	
				$bot->vars["user"] = $settings->vars["username"];
				$bot->vars["pass"] = $settings->vars["password"];
				$bot->vars["sport"] = $sport;
				$bot->vars["period"] = $period;
				$bot->vars["amount"] = $acc_amount;
				$bot->vars["rotation"] = $rotation;
				$bot->vars["type"] = $big_type;
				$bot->vars["url"] = $settings->vars["url"];	
				$bot->vars["site_name"] = $settings->vars["site_name"];	
				$bot->vars["site_domain"] = $settings->vars["site_domain"];	
				
				$bot->login();
				$line = $bot->create_bet($preplace);
				
				if($type == "t"){$line["line"] = abs($line["line"]);}
				
				
				if(!is_null($line) && $line["line"] != ""){
					
					if((($bet_line > $line["line"] && $big_type != "over") || ($bet_line < $line["line"] && $big_type == "over") || ($juice > $line["juice"] && $type != "m")) && !$placer){
						$msg = "Bad Line";
						$good = false;
					}else{
						if($placer){
							$bet_res = $bot->place_bet();
							if($bet_res == 'ok'){
								$msg = "Bet was placed";
								$good = true;
							}else{
								$msg = "There was a problem placing the bet:<br />".$bet_res;
								$good = false;
							}
							
						}else{
							$msg = "Ready to place Bet";
							$good = true;	
						}
						
					}
					
					$lines_list[] = array("account"=>$acc->vars["id"],"line"=>$line,"bot"=>$bot->cookie_key,"amount"=>$acc_amount,"msg"=>$msg,"good"=>$good);
				}else{
					$errors_list[] = array("account"=>$acc->vars["id"],"msg"=>"There was a problem with this account","good"=>false);
				}
			}else{
				$errors_list[] = array("account"=>$acc->vars["id"],"msg"=>"No amount to bet","good"=>false);	
			}
			
		}
		
		
		
		if(count($lines_list) > 0){
			
			$lines_list = $_sorter->sort($lines_list,$big_type);
			
			?>
            <script type="text/javascript">var pvalidations = new Array();</script>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="ab_table_header">Account</td>
				<td class="ab_table_header" align="center">Line</td>
                <td class="ab_table_header" align="center">Amount</td>
                <td class="ab_table_header">Detail</td>
			  </tr>
              <?
              $total_amount = $amount;
			  $bet_amount = 0;
			  $line_sum = array();
			  ?>
			  <? foreach($lines_list as $line_item){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
              	  <?
				  $acc_amount = $line_item["amount"];
				  
				  $checked = $line_item["good"];
				  
				  if(!$placer){
				  
					  if($acc_amount > $amount){$acc_amount = $amount;}
					  
					  if($total_amount <= 0){$checked = false;}
					  
					  $total_amount -= $acc_amount;
				  
				  }
				  
				  if($checked){$bet_amount += $acc_amount;}
				  
				  
				  $account = $accounts[$line_item["account"]];
				  ?>
                  <tr>
                     <td class="table_td<? echo $style ?>"><? echo $account ->vars["name"] ?></td>
                     <td class="table_td<? echo $style ?>" align="center">
					 	<? 
						$acc_line = $_sorter->sort_line($big_type,$line_item["line"]["line"],$line_item["line"]["juice"]);
						$line_id = $_sorter->encode_line($acc_line);
						
						if(is_null($line_sum[$line_id])){$line_sum[$line_id] = 0;}
						if($checked || $placer){$line_sum[$line_id] += $acc_amount;}
						echo $acc_line;
						?>
                     </td>
                     <td class="table_td<? echo $style ?>" align="center">
                     
                     	<? if($placer){echo $acc_amount;}else{ ?>
                     
                     	<script type="text/javascript">pvalidations.push({id:"acc_amount_<? echo $account ->vars["id"] ?>",type:"bigger_than:<? echo $acc_amount ?>", msg:"Max amount for account <? echo $account ->vars["name"] ?> is <? echo $acc_amount ?>"});</script>
                        
                        <input name="acc_amount_<? echo $account ->vars["id"] ?>"  id="acc_amount_<? echo $account ->vars["id"] ?>" size="5" value="<? echo $acc_amount ?>" type="text" onblur="recalculate_bet_total(true, '<? echo $line_id ?>');" onkeyup="recalculate_bet_total(false, '<? echo $line_id ?>');" style="text-align:center"  class="ab_input" />
                        
                        &nbsp;&nbsp;
                        
                        <input id="chk_<? echo $account ->vars["id"] ?>" name="chk_<? echo $account ->vars["id"] ?>" type="checkbox" <? if($checked){echo 'checked="checked"';} ?> value="1" onclick="recalculate_bet_total(true, '<? echo $line_id ?>');" />
                        
                        <input type="hidden" value="<? echo $line_id ?>" name="txtline_<? echo $account ->vars["id"] ?>" id="txtline_<? echo $account ->vars["id"] ?>" />
                        
                        <? } ?>
                        
                     </td>
                     <td class="table_td<? echo $style ?>"><? echo $line_item["msg"] ?></td>
                  </tr>  
			
			  <? } ?>
              <? foreach($errors_list as $line_item){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
			      <? $account = $accounts[$line_item["account"]]; ?>
                  <tr>
                     <td class="table_td<? echo $style ?>"><? echo $account ->vars["name"] ?></td>
                     <td class="table_td<? echo $style ?>" align="center">N/A</td>
                     <td class="table_td<? echo $style ?>"><? echo $line_item["amount"] ?></td>
                     <td class="table_td<? echo $style ?>"><? echo $line_item["msg"] ?></td>
                  </tr>  
			
			  <? } ?>
			  <tr>
				<td class="ab_table_header" align="center"></td>
				<td class="ab_table_header" align="right"><strong>Bet Amount</strong></td>
                <td class="ab_table_header" align="center"><strong id="total_bet_amount"><? echo $bet_amount ?></strong></td>
                <td class="ab_table_header" align="center"></td>
			  </tr>
			 
			</table>
            
            <h3>Line Summary</h3>
            
            <? $lines_keys = array_keys($line_sum); ?>
            
            <table width="300" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="ab_table_header">Line</td>
				<td class="ab_table_header" align="center">Amount</td>
			  </tr>
			  <? foreach($lines_keys as $kline){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
              		<tr>
                       <? $pkline = $_sorter->decode_line($kline); ?>
                       <td class="table_td<? echo $style ?>"><? echo $pkline ?></td>
                       <td class="table_td<? echo $style ?>" align="center" id="linesum_<? echo $kline ?>"><? echo $line_sum[$kline] ?></td>
                    </tr> 
              <? } ?>
              <tr>
				<td class="table_header" align="center" colspan="100"></td>
			  </tr>
			 
			</table>
            
            <? if(!$placer){ ?>
            
            <br /><br />
            <p align="center"><input name="placebtn" id type="button" value="PLACE BETS" onclick="palce_bets();" class="ab_btn1"/></p>
            <input type="hidden" value="0" name="placer" id="placer"  />
            
            <? } ?>
            
	  		<script type="text/javascript">
            function recalculate_bet_total(noblank, line){
				var new_amount = 0;
				var theid = "";
				var line_amount = 0;
				$('input[id^="acc_amount_"]').each(function(){
					theid = $(this).prop("id").replace("acc_amount_","");
					if ($('#chk_'+theid).is(':checked')) {
						$(this).val($(this).val().replace(/\D/g,''));
						if(noblank){if($(this).val() == ""){$(this).val(0);}}
						new_amount += ($(this).val()*1);
						if($('#txtline_'+theid).val() == line){line_amount += ($(this).val()*1);}
					}
				});
				$("#total_bet_amount").html(new_amount);
				$("#linesum_"+line).html(line_amount);
			}
			function palce_bets(){
				if(validate(pvalidations)){
					if(confirm("Are you sure you want to place the bets? This action cant be undo.")){
						$("#placer").val("1");
						$("#submiter").submit();
					}
				}
			}
            </script>
	  <?
		
		}else{echo "No accounts to bet";}
    
    
    }else{echo "Insert bet parameters";}
    ?>
    
    </form>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
