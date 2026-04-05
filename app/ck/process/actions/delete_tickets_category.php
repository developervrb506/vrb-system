<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets_categories")){ ?>

<?
 
 if(isset($_GET["delete"])){
  //details
  $categorie = get_ticket_categorie($_GET["delete"]);
  $categorie->vars['deleted'] = 1;
  $categorie->update(array('deleted'));
  $tickets = search_tickets($from, $to, $open, $email, "agents",  0,$keyword = "", $clerk_id , true,$_GET["delete"]);
  

  if(!is_null($tickets)){
     foreach ($tickets as $tk) {
     	$tk->vars['deleted'] = 1;
     	$tk->update(array('deleted'));
     }

  }
 
}


?>
<? }else{echo "Access Denied";} ?>