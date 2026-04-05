<?	
ini_set('memory_limit', '-1');
set_time_limit(0);
require_once(ROOT_PATH . "/ck/db/handler.php"); 



// UNCOMENT ONLY TO BE USED, COMMENT BACK WHEN DONE //

$letters = array("A","B","C","D","E","F","G","H","I","J");

$max = 5;
$clerk = 14;
$token = new _token();
$token->delete($clerk);

?>
www.vrbmarketing.com/out.php
<table width="300" border="1" cellspacing="0" cellpadding="0" style="text-align:center;">
  <tr>
    <td>&nbsp;</td>
    <td><strong>A</strong></td>
    <td><strong>B</strong></td>
    <td><strong>C</strong></td>
    <td><strong>D</strong></td>
    <td><strong>E</strong></td>
    <td><strong>F</strong></td>
    <td><strong>G</strong></td>
    <td><strong>H</strong></td>
    <td><strong>I</strong></td>
    <td><strong>J</strong></td>
  </tr>
  <? for ($number=1; $number <= $max; $number++){ ?>
  <tr>
    <td><strong><? echo $number; ?></strong></td>
    <? foreach ($letters as $letter){  ?>
    	<?
		$value = mt_rand(0,99);
		if($value<10){$value = "0".$value;}
		$token = new _token();
		$token->vars["user"]= $clerk;
		$token->vars["letter"]= $letter;
		$token->vars["number"]= $number;
		$token->vars["value"]= super_encript($value);
		$token->insert();
		?>
    	<td><? echo $value ?></td>
    <? } ?>
  </tr>
  <? } ?>
</table>