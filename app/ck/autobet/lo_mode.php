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
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript" src="../../process/js/jquery.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
    
    <span class="page_title">Auto Bet</span><br /><br />
    
    <a href="../auto_betting_accounts.php" class="normal_link">Manage Accounts</a>
    
    <br /><br />
    
    <?
	$sport = $_POST["sport"];
	$period = $_POST["period"];
	$type = $_POST["type"];
	$group = $_POST["betting_groups_list"];
	
	$otype = $type;
	switch($type){
		case "m": $big_type = "money"; break;	
		case "s": $big_type = "spread"; break;	
		case "o": $big_type = "over"; $type = "t"; break;
		case "u": $big_type = "under"; $type = "t"; break;		
	}
	?>
    
    
    <script type="text/javascript">
	var validations = new Array();
	validations.push({id:"sport",type:"null", msg:"Sport is required"});
	validations.push({id:"type",type:"null", msg:"Type is required"});
	</script>
    <form method="post" onsubmit="return validate(validations)">
    <input type="hidden" name="poster" id="poster" value="1" />
    <div class="form_box">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>
            Sport:<br />
            <select name="sport" id="sport" onchange="change_period_drop()">
            	<option value="">-Select-</option>
            	<? foreach(get_betting_sports() as $sp){ ?>
                <option value="<? echo $sp["name"] ?>" <? if($sport == $sp["name"]){ ?>selected="selected"<? } ?>><? echo $sp["name"] ?></option>
                <? } ?>
            </select>
        </td>
        <td>Period:<br />
          
          <div id="periods_box">
          Select the Sport
          </div>
          <? if($sport != ""){ ?> <script type="text/javascript">change_period_drop(); load_dropdown('period','<? echo $period ?>');</script> <? } ?>
        </td>
        <td>
        
        	Type:<br />
            <select name="type" id="type" onchange="manage_juice(this.value);">
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
        <td>Group:<br />
          <? $none_option = true; $current_group = $group; include "../includes/betting_groups_list.php"; ?></td>
        <td>
          <input name="submitbtn" type="submit" value="Load Lines" />
          </td>
      </tr>
    </table>
    </div>
    </form>
    
    <?
	if($_POST["poster"]){
		$games = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/feeds/schedule.php?sport=".$sport));
		
		if(count($games)>0){
			
			$softwares = get_all_betting_softwares();
			
			foreach($softwares as $soft){	
				include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
			}
			include(ROOT_PATH . "/ck/autobet/sort.php");
			
			$_sorter = new _line_sorter();
			$accounts =  get_auto_betting_accounts($group);
			$all_settings = get_all_betting_auto_settings();
			$bots = array();
			
			foreach($accounts as $acc){
				
				$settings = $all_settings[$acc->vars["id"]];
				
				eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot();");
				$bot->vars["user"] = $acc->vars["name"];
				$bot->vars["pass"] = $settings->vars["password"];
				$bot->vars["url"] = $settings->vars["url"];	
				$bot->vars["site_name"] = $settings->vars["site_name"];	
				$bot->vars["site_domain"] = $settings->vars["site_domain"];					
				$bot->login();	
				
				$bots[$acc->vars["id"]] = $bot;
			}
			
			?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>    
                <td class="table_header" align="center">Date</td>
                <td class="table_header" align="center">#</td>
                <td class="table_header">Teams</td>
                <? for($i=0;$i<count($accounts);$i++){ ?>
                <td class="table_header" align="center">
                	<? if($i==0){echo "Best Line";}else{echo "Line #".($i+1);} ?>
                </td>
                <? } ?>
              </tr>
			<?
				
				foreach($games as $game){				
					$game->vars = (array)$game->vars;
					if($i % 2){$style = "1";}else{$style = "2";}
					$i++;
					
					$lines_list_away = array();
					$errors_list_away = array();
					$lines_list_home = array();
					$errors_list_home = array();
					
					foreach($accounts as $acc){
						$bot = $bots[$acc->vars["id"]];
						$acc_amount = $settings->vars[$sport."_".$type];
						
						if(is_numeric($acc_amount) && $acc_amount > 0){
							
							//Aways
							$bot->vars["sport"] = $sport;
							$bot->vars["period"] = $period;
							$bot->vars["amount"] = $acc_amount;
							$bot->vars["rotation"] = $game->vars["VisitorNumber"];
							$bot->vars["type"] = $big_type;
							$line = $bot->create_bet(false);
							if(!is_null($line) && $line["line"] != ""){
								$lines_list_away[] = array("account"=>$acc->vars["id"],"line"=>$line,"bot"=>$bot->cookie_key,"amount"=>$acc_amount,"msg"=>"Ready","good"=>true);
							}else{
								$errors_list_away[] = array("account"=>$acc->vars["id"],"msg"=>"No Line","good"=>false);
							}
							
							//Homes
							$bot->vars["rotation"] = $game->vars["HomeNumber"];
							$line = $bot->create_bet(false);
							if(!is_null($line) && $line["line"] != ""){
								$lines_list_home[] = array("account"=>$acc->vars["id"],"line"=>$line,"bot"=>$bot->cookie_key,"amount"=>$acc_amount,"msg"=>"Ready","good"=>true);
							}else{
								$errors_list_home[] = array("account"=>$acc->vars["id"],"msg"=>"NA","good"=>false);
							}
							
						}else{
							$errors_list_away[] = array("account"=>$acc->vars["id"],"msg"=>"No amount","good"=>false);
							$errors_list_home[] = array("account"=>$acc->vars["id"],"msg"=>"-","good"=>false);	
						}
					}
					
					$lines_list_away = $_sorter->sort($lines_list_away,$big_type);
					$lines_list_home = $_sorter->sort($lines_list_home,$big_type);					
					
					?>
					<tr>    	
						<td class="table_td<? echo $style ?>" align="center" rowspan="2">
							<? echo date("Y-m-d",strtotime($game->vars["EventDate"])); ?>
                            <? echo date("h:i A",strtotime($game->vars["EventDate"])); ?>
                        </td>
                        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["VisitorNumber"]; ?></td>
                        <td class="table_td<? echo $style ?>"><? echo $game->vars["VisitorTeam"]; ?></td>
                        <? foreach($lines_list_away as $line_item){ ?>
                        <? $caccount = $accounts[$line_item["account"]] ?>
                        <td class="table_td<? echo $style ?>" align="center">
							<? 
							$acc_line = $_sorter->sort_line($big_type,$line_item["line"]["line"],$line_item["line"]["juice"]);
							echo $acc_line;
							?>
                            &nbsp;:&nbsp;<span class="little"><? echo $caccount ->vars["name"] ?></span>
                        </td>
                        <? } ?>
                        <? foreach($errors_list_away as $error_item){ ?>
                        <? $caccount = $accounts[$error_item["account"]] ?>
                        <td class="table_td<? echo $style ?>" align="center">
                        	<? echo $error_item["msg"]; ?>
                            &nbsp;:&nbsp;<span class="little"><? echo $caccount ->vars["name"] ?></span>
                        </td>
                        <? } ?>
                    </tr>
                    <tr>    	
						<td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["HomeNumber"]; ?></td>
                        <td class="table_td<? echo $style ?>"><? echo $game->vars["HomeTeam"]; ?></td>
                        <? foreach($lines_list_home as $line_item){ ?>
                        <? $caccount = $accounts[$line_item["account"]] ?>
                        <td class="table_td<? echo $style ?>" align="center">
							<? 
							$acc_line = $_sorter->sort_line($big_type,$line_item["line"]["line"],$line_item["line"]["juice"]);
							echo $acc_line;
							?>
                            &nbsp;:&nbsp;<span class="little"><? echo $caccount ->vars["name"] ?></span>
                        </td>
                        <? } ?>
                        <? foreach($errors_list_home as $error_item){ ?>
                        <? $caccount = $accounts[$error_item["account"]] ?>
                        <td class="table_td<? echo $style ?>" align="center">
                        	<? echo $error_item["msg"]; ?>
                            &nbsp;:&nbsp;<span class="little"><? echo $caccount ->vars["name"] ?></span>
                        </td>
                        <? } ?>
                    </tr>
                        
                        
                    <?
				}
				
			?>
              <tr>
                <td class="table_last" colspan="100"></td>   
              </tr>
            </table>
			<?
		
		}else{echo "No games available.";}
		
	}
	?>
    
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
