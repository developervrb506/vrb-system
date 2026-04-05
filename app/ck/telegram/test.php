<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
require_once("class.php"); 

  $msj = param('msj',false);
  $msj = str_replace("$","\n",$msj);
  $msj= str_replace("__"," ",$msj);
  $black = param('black');
  $msj = utf8_encode ($msj); 
  $msj = 'test';
  $black = 1;

  
  $users = get_telegram_users();
 
  $telegram = new _GradingBot("");
  foreach ($users as $user ){
 
    $chatid= $user->vars['phone_id'];
    $result = json_decode($telegram->envioMensajeProcesos($chatid,$msj),true);
	  //break;
    if($black){ 
    break;
    }
 	  
	  
 }



?>
  