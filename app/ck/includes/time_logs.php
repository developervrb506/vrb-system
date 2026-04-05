<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<body style="background:#fff;">
<div align="right">
<?
if(isset($_GET["start"])){user_log();}
else if(isset($_GET["end"])){
	user_log(true);
	$unfinished = get_current_break($current_clerk->vars["id"]);				
		if(!is_null($unfinished)){$current_clerk->break_action($unfinished->vars["id"]);}
}
if(isset($_GET["break"])){
	if(isset($_GET["endbkr"])){
		$current_clerk->break_action($_GET["endbkr"]);
	}else{
		$current_clerk->break_action();
	}
}


$ips = explode(",",str_replace(" ","",$gsettings["ips_allowed"]->vars["value"]));
if(/*in_array(getenv(REMOTE_ADDR),$ips)*/ true){
	$log = get_log_in($current_clerk->vars["id"], date("Y-m-d", strtotime(date("Y-m-d H:i:s")." - 3 hours")));
	if(is_null($log)){
		if(true/*check_log_from_computer()*/){
			?><a href="?start" class="normal_link">START WORK</a><?
		}else{
			echo "This computer already has been used for login a User!";
		}
	}else{
		if($log->vars["out"]){
			?>
			<span style="font-size:11px;">Today you Finished at <? echo date("h:i a",strtotime($log->vars["date"])); ?></span><br />
			<?	
		}else{
			?>
			<span style="font-size:11px;">Today you Started at <? echo date("h:i a",strtotime($log->vars["date"])); ?></span><br />
			<a href="javascript:;" class="normal_link" onClick="if(confirm('Are you sure you want to Finish Work now?')){location.href = '?end';}">
            	FINISH WORK
            </a>
			<?
			//Breaks
			echo "<br><br>";
			$current_break = get_current_break($current_clerk->vars["id"]);				
			if(is_null($current_break)){
				?><a href="?break" class="normal_link" style="font-size:24px;"><strong>START BREAK</strong></a><?
			}else{
				?>
				<a href="?break&endbkr=<? echo $current_break->vars["id"] ?>" class="normal_link" style="font-size:24px;">
					<strong>END BREAK</strong>
				</a><br>
				<span style="font-size:11px;">Started at <? echo date("h:i a",strtotime($current_break->vars["start_time"])); ?></span>
				<?
			}
			//End Breaks
		}		
	}
}else{echo "You are not at the Office" .getenv(REMOTE_ADDR);}
?>
</div>
</body>