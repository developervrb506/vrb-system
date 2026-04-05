<? set_time_limit(900) ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Auto Bet</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../includes/js/bets.js"></script>
<script type="text/javascript" src="../../process/js/functions.js"></script>
<script type="text/javascript" src="../../process/js/jquery.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
    
    <span class="page_title">Automatic Betting Pro Mode</span><br /><br />
    
    <a href="place_auto_bet.php" class="normal_link">Basic Mode</a>
    
    <br /><br />
    
    <?
	$sport = $_POST["sport"];
	$period = $_POST["period"];
	$type = $_POST["type"];
	$group = $_POST["betting_groups_list"];
	
	$otype = $type;
	switch($type){
		case "m": $big_type_away = "money"; $big_type_home = "money"; break;	
		case "s": $big_type_away = "spread"; $big_type_home = "spread"; break;	
		case "t": $big_type_away = "over"; $big_type_home = "under"; break;
	}
	?>
    
    
    <script type="text/javascript">
	var validations = new Array();
	validations.push({id:"sport",type:"null", msg:"Sport is required"});
	validations.push({id:"type",type:"null", msg:"Type is required"});
	</script>
    <form method="post" id="setform">
    <input type="hidden" name="poster" id="poster" value="1" />
    <div class="ab_form_box">
    
    <script type="text/javascript">
    function change_sport(value){
		$("div[id^='btn_sport_']").each(function(){
			
			if($(this).attr("id") == "btn_sport_"+value){
				$(this).attr("class","ddbtn_on");
				$("#sport").val(value);
			}
			else{$(this).attr("class","ddbtn");}
			
		});
		change_period_btns();
	}
	function change_period(value){
		$("div[id^='btn_period_']").each(function(){
			
			if($(this).attr("id") == "btn_period_"+value){
				$(this).attr("class","ddbtn_on");
				$("#period").val(value);
			}
			else{$(this).attr("class","ddbtn");}
			
		});
	}
	function change_type(value){
		$("div[id^='btn_type_']").each(function(){
			
			if($(this).attr("id") == "btn_type_"+value){
				$(this).attr("class","ddbtn_on");
				$("#type").val(value);
			}
			else{$(this).attr("class","ddbtn");}
			
		});
	}
	function change_period_btns(){
	var sport = document.getElementById("sport").value;
	if(sport == "NFL" || sport == "NCAAF" || sport == "NBA"){
		dd ='<div class="ddbtn" id="btn_period_GAME" onclick="change_period(\'GAME\');">GAME</div>';
		dd +='<div class="ddbtn" id="btn_period_1H" onclick="change_period(\'1H\');">1H</div>';
		dd +='<div class="ddbtn" id="btn_period_2H" onclick="change_period(\'2H\');">2H</div>';
		dd +='<div class="ddbtn" id="btn_period_1Q" onclick="change_period(\'1Q\');">1Q</div>';
		dd +='<div class="ddbtn" id="btn_period_2Q" onclick="change_period(\'2Q\');">2Q</div>';
		dd +='<div class="ddbtn" id="btn_period_3Q" onclick="change_period(\'3Q\');">3Q</div>';
		dd +='<div class="ddbtn" id="btn_period_4Q" onclick="change_period(\'4Q\');">4Q</div>';
	}else if(sport == "NCAAB" || sport == "MLB"){
		dd ='<div class="ddbtn" id="btn_period_GAME" onclick="change_period(\'GAME\');">GAME</div>';
		dd +='<div class="ddbtn" id="btn_period_1H" onclick="change_period(\'1H\');">1H</div>';
		dd +='<div class="ddbtn" id="btn_period_2H" onclick="change_period(\'2H\');">2H</div>';
	}else if(sport == "NHL"){
		dd ='<div class="ddbtn" id="btn_period_GAME" onclick="change_period(\'GAME\');">GAME</div>';
		dd +='<div class="ddbtn" id="btn_period_1P" onclick="change_period(\'1P\');">1P</div>';
		dd +='<div class="ddbtn" id="btn_period_2P" onclick="change_period(\'2P\');">2P</div>';
		dd +='<div class="ddbtn" id="btn_period_3P" onclick="change_period(\'3P\');">3P</div>';
	}
	document.getElementById("periods_box").innerHTML = dd;
}
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td>
        	<?
            $betting_sports = get_betting_sports();
			$i=0;
			foreach($betting_sports as $sp){
				$i++;
				$extra_class = "";
				$original_class = "ddbtn";
				if($sport == $sp["name"]){$original_class = "ddbtn_on";}
				?>
				<div class="<? echo $original_class ?> <? echo $extra_class ?>" id="btn_sport_<? echo $sp["name"] ?>" onclick="change_sport('<? echo $sp["name"] ?>');"><? echo $sp["name"] ?></div>
				<?	
			}
			?>
            <input type="hidden" id="sport" name="sport" value="" />            
        </td>
        <td>
        	<div id="periods_box">
            
            	<div class="ddbtn">Select a Sport to view Periods</div>
            
            </div>
            <input type="hidden" id="period" name="period" value="" />
        </td>
        <td>
        	<div class="ddbtn" id="btn_type_s" onclick="change_type('s');">Spread</div>
            <div class="ddbtn" id="btn_type_m" onclick="change_type('m');">Money</div>
            <div class="ddbtn" id="btn_type_t" onclick="change_type('t');">Total</div>
            <input type="hidden" id="type" name="type" value="" />
        </td>
      </tr>
      <tr>
        <td><input name="" type="submit" class="ab_btn1" id value="Refresh Lines" onclick="if(validate(validations)){$('#loading').css('display','block');$('#content_table').css('display','none');$('#setform').submit();}"/></td>
        <td>&nbsp;</td>
        <td><input name="" type="button" class="ab_btn2" id value="Load Lines" onclick="if(validate(validations)){$('#loading').css('display','block');$('#content_table').css('display','none'); $('#setform').submit();}"/></td>
      </tr>
    </table>
    <? if($_POST["poster"]){ ?>
	<script type="text/javascript">
	change_sport('<? echo $sport ?>');
	change_period('<? echo $period ?>');
	change_type('<? echo $type ?>');
	</script>
    <? } ?>
    </div>
    </form>
    
    
    <div id="loading" align="center" style="display:none;"><img src="../images/loading.gif" width="300" height="300" alt="Loading" /></div>
    
    
    <?
	if($_POST["poster"]){
		$games = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/feeds/schedule.php?sport=".$sport));
		
		//if(count($games)>0){
		  if(!empty($games)){		
			
			$softwares = get_all_betting_softwares();
			$line_totals = array();
			$line_link_ids = array();
			
			foreach($softwares as $soft){	
				include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
			}
			include(ROOT_PATH . "/ck/autobet/sort.php");
			
			$_sorter = new _line_sorter();
			$accounts =  get_auto_betting_accounts($group);
			$all_settings = get_all_betting_auto_settings();
			$all_proxys = get_all_betting_proxys();
			$bots = array();
			$col_sum = 0;
			
			$bots = array();
			$lines_open = array();
			$account_errors = array();
			
			foreach($accounts as $acc){
				
				$settings = $all_settings[$acc->vars["id"]];				
				$proxy = $all_proxys[$settings->vars["proxy"]];
				
				eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot(\$proxy);");
				$bot->vars["user"] = $settings->vars["username"];
				$bot->vars["pass"] = $settings->vars["password"];
				$bot->vars["url"] = $settings->vars["url"];	
				$bot->vars["site_name"] = $settings->vars["site_name"];	
				$bot->vars["site_domain"] = $settings->vars["site_domain"];					
				$bot->login();	
				
				$bots[$acc->vars["id"]] = $bot;
				
			}
			
			foreach($games as $game){
				$game->vars = (array)$game->vars;
				
				$line_totals[$game->vars["HomeNumber"]] = array();
				$line_totals[$game->vars["VisitorNumber"]] = array();
				$line_link_ids[$game->vars["HomeNumber"]] = array();
				$line_link_ids[$game->vars["VisitorNumber"]] = array();
				
				$game_col_sum_a = 0;
				$game_col_sum_h = 0;
				$game_col_sum = 0;
				
				foreach($accounts as $acc){
					$settings = $all_settings[$acc->vars["id"]];
					$acc_amount = $settings->vars[$sport."_".$type];
					if(!is_numeric($acc_amount) || $acc_amount < 0){$acc_amount = 0;}
				
					$bot = $bots[$acc->vars["id"]];
					
					//Aways
					if($lines_open[$acc->vars["id"]]){
						$bot->vars["type"] = $big_type_away;
						$line = $bot->get_other_line($game->vars["VisitorNumber"]);
					}else{
						$lines_open[$acc->vars["id"]] = true;
						
						$bot->vars["sport"] = $sport;
						$bot->vars["period"] = $period;
						$bot->vars["amount"] = $acc_amount;
						$bot->vars["rotation"] = $game->vars["VisitorNumber"];
						$bot->vars["type"] = $big_type_away;
						$line = $bot->create_bet(false);
					}
					
					if(!is_null($line) && $line["line"] != ""){
						$acc_line = $_sorter->sort_line($big_type_away,$line["line"],$line["juice"]);
						$idline = $_sorter->encode_line($acc_line);
						
						if(is_null($line_totals[$game->vars["VisitorNumber"]][$idline])){
							$line_totals[$game->vars["VisitorNumber"]][$idline] = 0;
							$line_link_ids[$game->vars["VisitorNumber"]][$idline] = array();
							$game_col_sum_a++;
						}
						$line_totals[$game->vars["VisitorNumber"]][$idline] +=  $acc_amount;
						$line_link_ids[$game->vars["VisitorNumber"]][$idline][] =  $acc->vars["id"];
					}else{
						if(!$bot->logged){$account_errors[$acc->vars["id"]] = array("name"=>$acc->vars["name"],"msg"=>"Account Login Failed");}
					}
					
					//Homes
					$bot->vars["type"] = $big_type_home;
					if($big_type_home == "under"){$extra_rot = 1;}else{$extra_rot = 0;}
					$line = $bot->get_other_line(($game->vars["HomeNumber"] - $extra_rot));
					
					if(!is_null($line) && $line["line"] != ""){
						$acc_line = $_sorter->sort_line($big_type_home,$line["line"],$line["juice"]);
						$idline = $_sorter->encode_line($acc_line);
						
						if(is_null($line_totals[$game->vars["HomeNumber"]][$idline])){
							$line_totals[$game->vars["HomeNumber"]][$idline] = 0;
							$line_link_ids[$game->vars["HomeNumber"]][$idline] = array();
							$game_col_sum_h++;
						}
						$line_totals[$game->vars["HomeNumber"]][$idline] +=  $acc_amount;
						$line_link_ids[$game->vars["HomeNumber"]][$idline][] =  $acc->vars["id"];
					}else{
						if(!$bot->logged){$account_errors[$acc->vars["id"]] = array("name"=>$acc->vars["name"],"msg"=>"Account Login Failed");}
						else{$account_errors[$acc->vars["id"].$game->vars["VisitorNumber"]] = array("name"=>$acc->vars["name"],"msg"=>"Cant get " .  ucwords(strtolower($game->vars["VisitorTeam"])) . " vs " .  ucwords(strtolower($game->vars["HomeTeam"])) . " lines.");}
					}
					
				}
				
				if($game_col_sum_a >= $game_col_sum_h){$game_col_sum = $game_col_sum_a;}else{$game_col_sum = $game_col_sum_h;}
				if($game_col_sum > $col_sum){$col_sum = $game_col_sum;}
				
			}
			
			?>
            <div id="content_table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>    
                <td class="ab_table_header" align="center" width="90">Date</td>
                <td class="ab_table_header" align="center" width="20">#</td>
                <td class="ab_table_header">Teams</td>
                <? for($i=0;$i<$col_sum;$i++){ ?>
                <td class="ab_table_header" align="right">
                	<? if($i==0){echo "Best Line";}else{echo "Line #".($i+1);} ?>
                </td>
                <? } ?>
              </tr>
			<?
				
				foreach($games as $game){				
					$game->vars = (array)$game->vars;
					if($i % 2){$style = "1";}else{$style = "2";}
					$i++;
					?>
					<tr>    	
						<td class="table_td<? echo $style ?>" align="center" rowspan="2">
							<? echo date("Y-m-d",strtotime($game->vars["EventDate"])); ?>
                            <? echo date("h:i A",strtotime($game->vars["EventDate"])); ?>
                        </td>
                        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["VisitorNumber"]; ?></td>
                        <td class="table_td<? echo $style ?>"><? echo $game->vars["VisitorTeam"]; ?></td>
                        <?
                        $keys = array_keys($line_totals[$game->vars["VisitorNumber"]]);
						$keys = $_sorter->sort_keys($keys,$big_type_away);
						$ccols = 0;
						foreach($keys as $key){
						$ccols++;
						?>
                        <td class="table_td<? echo $style ?>" align="right">
                        	<? echo $_sorter->decode_line($key); ?>
                            &nbsp;:&nbsp;
                          <a href="place_sum_autobet.php?rot=<? echo $game->vars["VisitorNumber"] ?>&team=<? echo $game->vars["VisitorTeam"] ?>&game=<? echo $game->vars["VisitorTeam"] . " vs " . $game->vars["HomeTeam"] ?>&line=<? echo $key ?>&sport=<? echo $sport ?>&period=<? echo $period ?>&type=<? echo $big_type_away ?>&accs=<? echo implode(",",$line_link_ids[$game->vars["VisitorNumber"]][$key]); ?>&gdate=<? echo date("Y-m-d",strtotime($game->vars["EventDate"])); ?>" rel="shadowbox;height=500;width=600" class="ab_num_link">$<? echo $line_totals[$game->vars["VisitorNumber"]][$key] ?></a>
                        </td>
                        <? } ?>
                        <? for($e=0;$e<($col_sum-$ccols);$e++){ ?>
                        	<td class="table_td<? echo $style ?>"></td>
                        <? } ?>
                        
                    </tr>
                    <tr>    	
						<td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["HomeNumber"]; ?></td>
                        <td class="table_td<? echo $style ?>"><? echo $game->vars["HomeTeam"]; ?></td>
                        <?
                        $keys = array_keys($line_totals[$game->vars["HomeNumber"]]);
						$keys = $_sorter->sort_keys($keys,$big_type_home);
						$ccols = 0;
						foreach($keys as $key){
						$ccols++;
						?>
                        <td class="table_td<? echo $style ?>" align="right">
                        	<? echo $_sorter->decode_line($key); ?>
                            &nbsp;:&nbsp;
                          <a href="place_sum_autobet.php?rot=<? echo $game->vars["HomeNumber"] ?>&team=<? echo $game->vars["HomeTeam"] ?>&game=<? echo $game->vars["VisitorTeam"] . " vs " . $game->vars["HomeTeam"] ?>&line=<? echo $key ?>&sport=<? echo $sport ?>&period=<? echo $period ?>&type=<? echo $big_type_home ?>&accs=<? echo implode(",",$line_link_ids[$game->vars["HomeNumber"]][$key]); ?>" rel="shadowbox;height=500;width=600" class="ab_num_link">$<? echo $line_totals[$game->vars["HomeNumber"]][$key] ?></a>
                        </td>
                        <? } ?>
                        <? for($e=0;$e<($col_sum-$ccols);$e++){ ?>
                        	<td class="table_td<? echo $style ?>"></td>
                        <? } ?>
                    </tr>
                        
                        
                    <?
				}
				
			?>
              <tr>
                <td class="table_last" colspan="100"></td>   
              </tr>
            </table>
            
            <? if(count($account_errors) > 0){ ?>
            <br /><br />
            
            <strong>Erros Log</strong>
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>    
                <td class="ab_table_header" align="center" width="90">Account</td>
                <td class="ab_table_header" width="20">Error</td>
              </tr>
			<?
				
				foreach($account_errors as $aerror){
					if($i % 2){$style = "1";}else{$style = "2";}
					$i++;
					?>
					<tr>    	
                        <td class="table_td<? echo $style ?>" align="center"><? echo $aerror["name"]; ?></td>
                        <td class="table_td<? echo $style ?>"><? echo $aerror["msg"]; ?></td>                        
                    </tr>
                    <?
				}
				
			?>
              <tr>
                <td class="table_last" colspan="100"></td>   
              </tr>
            </table>
            
            <? } ?>
            
            
            
            </div>
			<?
		
		}else{echo "<div id='content_table'>No games available.</div>";}
		
	}
	?>
    
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
