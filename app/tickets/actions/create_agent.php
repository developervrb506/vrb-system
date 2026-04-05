<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$mobile         = clean_str_ck($_POST["mobile"]);
$wpx  = clean_str_ck($_POST["wpx"]);
if($wpx != ""){$player = two_way_enc($wpx, true);}
$department     = get_live_help_department($department_id);

$object = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?pid=".two_way_enc($player)));

$agent = $object->vars->IdAgent->vars->Agent;

$data["why"] = "play_agent";
$data["subject"] = "Player Agent Communication. ". clean_str_ck($_POST["subject"]);
$data["acc"] = $player;
$data["data"] = $agent;
$data["message"] = clean_str_ck($_POST["message"]);
$data["cat"] = 45;
$ticket = do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/send_tiket.php",$data);	

      
if (isset($mobile) and $mobile == 1) { 
   header("Location: ../thanks.php?web=".$ticket->vars["website"]."&mobile=".$mobile."&wpx=".$wpx);
} else {
   header("Location: ../thanks.php?web=".$ticket->vars["website"]."&wpx=".$wpx);	
}
?>