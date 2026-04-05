<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 

 //DebugLogTxt("POST", $_POST);
 //exit;

if($current_clerk->im_allow("props_system")){ 
	$_POST["clerk"] = $current_clerk ->vars["id"];
  
	//echo "<pre>"; print_r($_POST);
	/*
       $_POST['key'] = 'dca8cf70bf66e1f41f3bb7a2bfea9cf7';
    $_POST['add_odds'] = '1';
    $_POST['dgs_game'] = '8309730';
    $_POST['none_date'] = '2024-09-14 22:30:00';
    $_POST['odate'] = '2024-09-14 19:30:00';
    $_POST['edate'] = '2024-09-14 19:30:00';
    $_POST['sport'] = 'TNT';
    $_POST['name'] = 'SAN DIEGO STATE VS CALIFORNIA SAN DIEGO STATE/CALIFORNIA-FIRST SCORING PLAY (INC OT)';
    $_POST['oleague'] = '1419';
    $_POST['type'] = '42';
    $_POST['rot_1'] = '32455';
    $_POST['team_1'] = 'SAN DIEGO STATE-TOUCHDOWN';
    $_POST['odds_1'] = '+330';
    $_POST['rot_2'] = '32456';
    $_POST['team_2'] = 'SAN DIEGO STATE-FIELD GOAL';
    $_POST['odds_2'] = '+400';
    $_POST ['rot_3'] = '32457';
    $_POST['team_3'] = 'SAN DIEGO STATE- SAFETY';
    $_POST['odds_3'] = '+2500';
    $_POST['rot_4'] = '32458';
    $_POST['team_4'] = 'CALIFORNIA-TOUCHDOWN';
    $_POST['odds_4'] = '-130';
    $_POST['rot_5'] = '32459';
    $_POST['team_5'] = 'CALIFORNIA-FIELD GOAL';
    $_POST['odds_5'] = '+350';
    $_POST['rot_6'] = '32460';
    $_POST['team_6'] ='CALIFORNIA- SAFETY';
    $_POST['odds_6'] = '+2500';
*/
	echo do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/import_odds_action.php",$_POST);
}
?>
