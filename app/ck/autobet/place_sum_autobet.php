<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<?

include(ROOT_PATH . "/ck/autobet/sort.php");
$_sorter = new _line_sorter();

$rot = param("rot");
$team = param("team");
$line = $_sorter->decode_line($_GET["line"]);
$sport = param("sport");
$period = param("period");
$game = param("game");
$type = substr(param("type"),0,1);
$id_accs = param("accs");
$identifier = param("identifier");
$game_date = param("gdate");


if(in_array($type,array("u","o"))){
	$title = "GAME TOTAL ($line)";
}else{
	$title = $team." ($line)";
}

$accounts = get_auto_betting_accounts_by_list($id_accs);
$lines_list = array();
$errors_list = array();
$bet_amount = 0;
$extra_rot = 0;
$all_settings = get_all_betting_auto_settings();
$all_proxys = get_all_betting_proxys();
$results = array();

$softwares = get_all_betting_softwares();		
foreach($softwares as $soft){	
	include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
}

$otype = $type;
switch($type){
	case "m": $big_type = "money"; break;	
	case "s": $big_type = "spread"; break;	
	case "o": $big_type = "over"; $type = "t"; break;
	case "u": $big_type = "under"; $type = "t"; $extra_rot = 1; break;		
}

//Place Bets
if($_POST["placer"]){
	$placer = true;
	foreach($accounts as $account){
		
		$settings = $all_settings[$account->vars["id"]];
	
		if($_POST["chk_".$account->vars["id"]]){
			$acc_amount = 	$_POST["acc_amount_".$account->vars["id"]];
			
			if(is_numeric($acc_amount) && $acc_amount > 0){
				
				$proxy = $all_proxys[$settings->vars["proxy"]];
				
				eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot(\$proxy);");	
				$bot->vars["user"] = $settings->vars["username"];
				$bot->vars["pass"] = $settings->vars["password"];
				$bot->vars["sport"] = $sport;
				$bot->vars["period"] = $period;
				$bot->vars["amount"] = $acc_amount;
				$bot->vars["rotation"] = ($rot - $extra_rot);
				$bot->vars["type"] = $big_type;
				$bot->vars["url"] = $settings->vars["url"];	
				$bot->vars["site_name"] = $settings->vars["site_name"];	
				$bot->vars["site_domain"] = $settings->vars["site_domain"];
				
				$bot->login();				
				
				$sline = $bot->create_bet(true);
				
				if(!is_null($sline) && $sline["line"] != ""){
					
					$system_line = $_sorter->sort_line($big_type,$sline["line"],$sline["juice"]);
					
					if(str_replace(" ","",$line) == str_replace(" ","",$system_line)){
					
						$bet_res = $bot->place_bet();
						
						if($bet_res == 'ok'){
							$results[$account ->vars["id"]] = array("msg"=>"Bet was placed","good"=>true,"amount"=>$acc_amount);
							
							
							
							/*Insert Bet*/
							$bet = new _bet();
							$idf = get_betting_identifier_by_name($identifier);	
							$sbo_game = get_game_by_rotation_date($rot,$game_date);		
							$amount_list = $_sorter->get_bet_amounts($acc_amount,$system_line);				
							$bet->vars["account"] = $account ->vars["id"];
							$bet->vars["line"] = $system_line;
							$bet->vars["risk"] = $amount_list["risk"];
							$bet->vars["win"] = $amount_list["win"];
							$bet->vars["identifier"] = $idf->vars["id"];
							$bet->vars["gameid"] = $sbo_game ->vars["id"];
							$bet->vars["period"] = $period;
							$bet->vars["team"] = $team;
							$bet->vars["type"] = $big_type;							
							$bet->vars["bdate"] = $game_date;
							$bet->vars["place_date"] = date("Y-m-d H:i:s");
							$bet->vars["user"] = $current_clerk->vars["id"];							
							$bet->vars["account_percentage"] = $account->vars["description"];							
							$bet->insert();
							
							
							
							
						}else{
							$results[$account ->vars["id"]] = array("msg"=>"There was a problem placing the bet:<br />".$bet_res,"good"=>false,"amount"=>0);
						}
					
					}else{						
						$results[$account ->vars["id"]] = array("msg"=>"Line Changed:|".str_replace(" ","",$system_line)."|".str_replace(" ","",$line)."|","good"=>false,"amount"=>0);						
					}
					
				}else{
					$results[$account ->vars["id"]] = array("msg"=>"There was a problem with the Account","good"=>false,"amount"=>0);
				}
				
			}else{
				$results[$account ->vars["id"]] = array("msg"=>"Not Amount to bet","good"=>false,"amount"=>0);
			}
		}else{
			$results[$account ->vars["id"]] = array("msg"=>"Not Selected","good"=>false,"amount"=>0);
		}
		
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/js/bets.js"></script>
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
<script type="text/javascript" src="../../process/js/jquery.js"></script>
</head>
<body>
<div class="page_content" style="padding-left:20px; font-size:12px;">
  <span class="page_title"><? echo $title ?></span><br />
  <? echo $game ?>
  <br /><br />
  
  <script type="text/javascript">var pvalidations = new Array();</script>
  <script type="text/javascript">
  function recalculate_bet_total(noblank, line){
	  var new_amount = 0;
	  var theid = "";
	  $('input[id^="acc_amount_"]').each(function(){
		  theid = $(this).prop("id").replace("acc_amount_","");
		  if ($('#chk_'+theid).is(':checked')) {
			  $(this).val($(this).val().replace(/\D/g,''));
			  if(noblank){if($(this).val() == ""){$(this).val(0);}}
			  new_amount += ($(this).val()*1);
		  }
	  });
	  $("#total_bet_amount").html(new_amount);
  }
  function palce_bets(){
	  if(validate(pvalidations)){
		  if(confirm("Are you sure you want to place the bets? This action cant be undo.")){
			  $('#loading').css('display','block');
			  $('#result_table').css('display','none');
			  $("#placer").val("1");
			  $("#submiter").submit();
		  }
	  }
  }
  </script>
  <form method="post" id="submiter"  name="submiter">
  <? if($placer){ ?> <h3>Results</h3> <? }else{ ?> <h3>Preview</h3> <? } ?>
  <div id="result_table">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="ab_table_header">Account</td>
      <td class="ab_table_header" align="center">Amount</td>
      <td class="ab_table_header">Detail</td>
    </tr>
    <? foreach($accounts as $account){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
        <?
		if($placer){$result = $results[$account ->vars["id"]];}
		
		$settings = $all_settings[$account->vars["id"]];
		if($placer){$acc_amount = $result["amount"];}
		else{$acc_amount = $settings->vars[$sport."_".$type];}                
		
        $bet_amount += $acc_amount;
        ?>
        <tr>
           <td class="table_td<? echo $style ?>"><? echo $account ->vars["name"] ?></td>
           <td class="table_td<? echo $style ?>" align="center">
           
              <? if($placer){echo $acc_amount;}else{ ?>
           
              <script type="text/javascript">pvalidations.push({id:"acc_amount_<? echo $account ->vars["id"] ?>",type:"bigger_than:<? echo $acc_amount ?>", msg:"Max amount for account <? echo $account ->vars["name"] ?> is <? echo $acc_amount ?>"});</script>
              
              <input name="acc_amount_<? echo $account ->vars["id"] ?>"  id="acc_amount_<? echo $account ->vars["id"] ?>" size="5" value="<? echo $acc_amount ?>" type="text" onblur="recalculate_bet_total(true, '<? echo $line_id ?>');" onkeyup="recalculate_bet_total(false, '<? echo $line_id ?>');" style="text-align:center" class="ab_input" />
              
              &nbsp;&nbsp;
              
              <input id="chk_<? echo $account ->vars["id"] ?>" name="chk_<? echo $account ->vars["id"] ?>" type="checkbox" checked="checked" value="1" onclick="recalculate_bet_total(true, '<? echo $line_id ?>');" />
              
              <? } ?>
              
           </td>
           <td class="table_td<? echo $style ?>"><? if($placer){echo $result["msg"];}else{echo "Ready to place Bet";} ?></td>
        </tr>  
  
    <? } ?>
    <tr>
      <td class="ab_table_header" align="right"><strong>Bet Amount</strong></td>
      <td class="ab_table_header" align="center"><strong id="total_bet_amount"><? echo $bet_amount ?></strong></td>
      <td class="ab_table_header" align="center"></td>
    </tr>
   
  </table>
  
  
  <? if(!$placer){ ?>
  
  <br /><br />
  
  <script type="text/javascript">pvalidations.push({id:"identifier",type:"null", msg:"Please Select an Identifier"});</script>
  <p align="center"><input placeholder="Identifier" style="text-align:center" name="identifier" type="text" id="identifier" /></p>
  
  <p align="center"><input name="placebtn" id type="button" value="PLACE BETS" onclick="palce_bets();" class="ab_btn1"/></p>
  <input type="hidden" value="0" name="placer" id="placer"  />
  
  <? } ?>
  
  </form>
  
  </div>
  
  <div id="loading" align="center" style="display:none;"><img src="../images/loading.gif" width="300" height="300" alt="Loading" /></div>
  
  
  
  
</div>
<? }else{echo "Access Denied";} ?>