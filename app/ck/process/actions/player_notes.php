<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_notes")){ ?>
<?

 $type = param("type");
 $idplayer = param("player");
 $note =  str_replace(" ","_",param("note"));
 $marketing = param("marketing");

 if($marketing != 1){

 $data = "?t=".$type."&player=".$idplayer."&note=".$note;
 
 file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_player_notes_action.php".$data);
 }
 if($marketing == 1){

  $data = "?t=".$type."&player=".$idplayer."&note=".$note."&marketing=1";
  file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_player_notes_action.php".$data);
}

?>
<? }else{echo "Access Denied";} ?>