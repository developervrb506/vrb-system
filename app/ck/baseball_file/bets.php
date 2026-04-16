<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Bets</span><br />
<br />

<?
$identifier = 8; // id for cowboy base
$period = 'Game';

$bets = search_first_bet_by_game($_GET["gid"],$period,$identifier); 
echo "<pre>";
//print_r($bets);
echo "</pre>";
?>

<div class="form_box">

     <table width="100%" border="1" cellspacing="0" cellpadding="0">
	
		  <tr>
		    <td class="table_header">Account</td>
		   <td class="table_header">Line</td>
  	      </tr>
   <?          
        if (empty($bets)) { ?>
            <td class="table_header">-- No Bets for this Game</td> 
		<? }
		  	foreach ($bets as $bet) {
  
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	  
	  ?>	
	   <tr>
      
          <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $bet->vars["account"]->vars["name"] ?></td>
	  
   	  
          <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $bet->vars["line"] ?></td>
	   </tr>	
	<?	 
	}
  
	  
  ?></table>
  
</div>
</body>
</html>