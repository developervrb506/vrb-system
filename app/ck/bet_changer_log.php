<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? set_time_limit(0); ?>
<? if($current_clerk->im_allow("graded_games_checker")){ ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="../css/style.css" rel="stylesheet" type="text/css" />
		<title> History	Log</title>
		<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
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
	<body style="background:#fff; padding:20px;">

        <? 
        $from = param('from',false) ;
        $to = param("to",false);
        $rot = param('rot'); 
        if($from == ""){$from = $to = date("Y-m-d"); }			
        ?>


		<span class="page_title">Bet Changer Log</span><br /><br />
		<? include "includes/print_error.php" ?>
		<div class="form_box">

			<form action="bet_changer_log.php" method="post" id="form_search">
               Game Date<BR> <BR> 
				From:
				<input name="from" type="text" id="from" value="<? echo $from ?>" />
				&nbsp;&nbsp;&nbsp;
				to:
				<input name="to" type="text" id="to" value="<? echo $to ?>" />
				&nbsp;&nbsp;&nbsp;
				Rot (optional)&nbsp;&nbsp;<input name="rot" type="text" id="rot" value="<? echo $rot ?>" />

&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="search" type="submit" value="Filter" onclick="" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</form>

			<br /><br />
            
            <? if(isset($_POST['search'])) { ?>  

			<span >O/N = OLD / NEW</span>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="table_header" align="center">Bet</td>
					<td class="table_header" align="center">Time</td>
					<td class="table_header" align="center">Player</td>
					<td class="table_header" align="center">Rot</td>    
					<td class="table_header" align="center">GameDate</td>        
					<td class="table_header" align="center">Action</td>
					<td class="table_header" align="center">Message</td>
					<td class="table_header" align="center">Type</td>
					<td class="table_header" align="center">Points(O/N)</td>
					<td class="table_header" align="center">Odds(O/N)</td>
					<td class="table_header" align="center">Desc_old</td>
					<td class="table_header" align="center">Desc_new</td>
					<td class="table_header" align="center">Risk(O/N)</td>
					<td class="table_header" align="center">Win(O/N)</td>
					<td class="table_header" align="center">Date</td>
					<td class="table_header" align="center">User</td>
				</tr>

				<? 

                 $logs = get_bet_changer_log($from,$to,$rot);

				foreach ($logs as $l){ ?>


					<tr>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['bet'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['bet_time'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['player'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['rot'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['game_date'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['action'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['msj'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['type'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['points_old'] ?> / <? echo $l['points_new'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['odds_old'] ?> / <? echo $l['odds_new'] ?></td>						
						<td class="table_td<? echo $style ?>" align="center"><? echo utf8_encode($l['desc_old']) ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo utf8_encode($l['desc_new']) ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['risk_old'] ?> / <? echo $l['risk_new'] ?></td>						
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['win_old'] ?> / <? echo $l['win_new'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['date'] ?></td>
						<td class="table_td<? echo $style ?>" align="center"><? echo $l['user'] ?></td>

					</tr>

				<? } ?>

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

		</div>

	<? } ?>
	<? include "../includes/footer.php" ; ?>








	