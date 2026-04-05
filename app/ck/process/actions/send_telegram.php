<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<? require_once(ROOT_PATH . "/ck/telegram/class.php");
  $msj = param('msj',false);
  $msj = str_replace("$","\n",$msj);
  $msj= str_replace("__"," ",$msj);
  $black = param('black');
  $msj = utf8_encode ($msj); 
// /$msj =  'TEST';
  //$black = 1;

  
  $users = get_telegram_users();
 
  
  if(contains_ck($msj,'VRB BOT LINES') || contains_ck($msj,'BET VRB') ){
   // $telegram = new _GradingBot("");
    $telegram = new _Bot("Grading");
   }  else {
    $telegram = new _Bot("Blacklist");
   }


  foreach ($users as $user ){
 
    $chatid= $user->vars['phone_id'];
    $result = json_decode($telegram->envioMensajeProcesos($chatid,$msj),true);
	  //break;
    if($black){ 
    break;
    }
 	  
	  
 }



?>
  