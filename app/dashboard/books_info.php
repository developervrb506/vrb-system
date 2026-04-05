<? 
$bookid = $_GET['bk'];
if ($bookid == 3) {
  $player_prefix = "SBO";
  $book_name = "SBO";
}elseif ($bookid == 6) {
  $player_prefix = "PBJ";
  $book_name = "PlayBlackjack";	
}elseif ($bookid == 7) {
  $player_prefix = "OWI";
  $book_name = "BetOWI";
}elseif ($bookid == 8) {
  $player_prefix = "BITBET";
  $book_name = "BitBet";
}elseif ($bookid == 9) {
  $player_prefix = "HRB";
  $book_name = "HRB";
}
/*elseif ($bookid == 10) {
  $player_prefix = "BLN";
  $book_name = "BetLion";
}*/
?>