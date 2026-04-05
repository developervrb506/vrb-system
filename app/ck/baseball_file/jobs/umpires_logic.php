 <?
 require_once(ROOT_PATH . "/ck/db/handler.php"); 
 require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

 $year = date('Y');
 
 $html = file_get_html("http://www.thelogicalapproach.com/umpire_".$year."_website.htm");
//$valid_line = true;
 $cont_lines = 0;
 $next_row=16;

// Columns
 $umpire_interval=0; 
 $hw_interval=1;
 $rw_interval=2;
 $nd_interval=3;
 $pct_hom_interval=4;
 $pl_hom_interval=5;
 $pl_rod_interval=6;
 $run_interval=7;
 $ov_interval=8;
 $un_interval=9;
 $p_interval=10;
 $pct_ovr_interval=11;
 $inn_per_interval=12;
 $era_interval=13;
 $kbb_interval=14;
 $inn_bb_interval=15;

 
echo "-------------------------<BR>";
echo "  UMPIRE LOGIC FOR ".$year."<br>";
echo "http://www.thelogicalapproach.com/umpire_".$year."_website.htm<br>";
echo "----------------------<BR><BR>";

?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Umpire</td>
    <td class="table_header">Umpire ID</td>
    <td class="table_header">HW</td>
    <td class="table_header">RW</td>
    <td class="table_header">ND</td>
    <td class="table_header">PCT_H</td>
    <td class="table_header">PL_H</td>
    <td class="table_header">PL_R</td>
    <td class="table_header">RUN</td>
    <td class="table_header">OV</td>
    <td class="table_header">UN</td>
    <td class="table_header">P</td>
    <td class="table_header">PCT_O</td>
    <td class="table_header">INN_P</td>
    <td class="table_header">ERA</td>
    <td class="table_header">KBB</td>
    <td class="table_header">INN_BB</td>   
  </tr>


<?

 $umpires = get_all_baseball_umpires();
 echo "<pre>";
//print_r($umpires);
echo "</pre>"; $l=0;
$cont_lines = -1; 
 foreach ( $html->find('Td') as $element ) { $l++;

	  if ($l == 46 ){	$valid_line = true;	$cont_lines = 0;}
	  
		
	//  }
	 
    //if ($cont_lines == ($umpire_interval) && ($valid_line) ){
   if ( ($valid_line)  ){		
	  //   echo $l.")".$cont_lines."--".$element->plaintext ."<BR>";
	
	 
		// echo $l.")".$cont_lines."--".$element->plaintext ."<BR>";
		//$cont_lines++;
	// echo "****)".$umpire_interval."==".$cont_lines."<BR>";
	if ($umpire_interval == $cont_lines && ($valid_line)){
		// echo "SIIIII<BR>";
		 ?>
        <tr>
      
	    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	  $umpire = str_replace("'"," ",$element->plaintext); 
	  ?>
      <td style="font-size:12px;"><? echo $umpires[$umpire]->vars["id"] ?></td>
      <? 
	 // $umpire_interval = $umpire_interval + $next_row;
	}
   
    if ($cont_lines == $hw_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	  $hw=$element->plaintext;
	 // $hw_interval = $hw_interval + $next_row;
     }
   
    if ($cont_lines == $rw_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	  $rw = $element->plaintext;
 	 // $rw_interval = $rw_interval + $next_row;
    }
   
    if ($cont_lines == $nd_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	  $nd = $element->plaintext;
	 // $nd_interval = $nd_interval + $next_row;
    }
   
    if ($cont_lines == $pct_hom_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
      $pct_hom = $element->plaintext;
	 // $pct_hom_interval = $pct_hom_interval + $next_row;
    }
   
    if ($cont_lines == $pl_hom_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	  $pl_hom = $element->plaintext;
	 // $pl_hom_interval = $pl_hom_interval + $next_row;
    }
   
    if ($cont_lines == $pl_rod_interval && ($valid_line) ){
	  ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	  <?
	 $pl_rod = $element->plaintext;  
	 //$pl_rod_interval = $pl_rod_interval + $next_row;
    }
   
    if ($cont_lines == $run_interval && ($valid_line) ){
	 ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	 <?
     $run = $element->plaintext;
	// $run_interval = $run_interval + $next_row;
    }
   
    if ($cont_lines == $ov_interval && ($valid_line) ){
	 ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	 <?
     $ov = $element->plaintext; 
	// $ov_interval = $ov_interval + $next_row;
    }
   
   if ($cont_lines == $un_interval && ($valid_line) ){
	 ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	 <?
	 $un = $element->plaintext;
	// $un_interval = $un_interval + $next_row;
   }
   
   if ($cont_lines == $p_interval && ($valid_line) ){
	 ?>
      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	 <?
	$p = $element->plaintext;
	//$p_interval = $p_interval + $next_row;
   }
   
   if ($cont_lines == $pct_ovr_interval && ($valid_line) ){
 	?>
    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	<?
    $pct_ovr = $element->plaintext; 
	//$pct_ovr_interval = $pct_ovr_interval + $next_row;
   }
   
   if ($cont_lines == $inn_per_interval && ($valid_line) ){
	?>
    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	<?
    $inn_per = $element->plaintext;
	//$inn_per_interval = $inn_per_interval + $next_row;
   }
   
   if ($cont_lines == $era_interval && ($valid_line) ){
	?>
    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	<?
	$era = $element->plaintext;
	//$era_interval = $era_interval + $next_row;
   }
    
      
   if ($cont_lines == $kbb_interval && ($valid_line)){
	?>
    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	<?
	$kbb = $element->plaintext;
	//$kbb_interval = $kbb_interval + $next_row; 
   }
   
   if ($cont_lines == $inn_bb_interval && ($valid_line) ){
	?>
    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
	<?
	$inn_bb = $element->plaintext;
	//$inn_bb_interval = $inn_bb_interval + $next_row;
   
     
     // If the Umpire is New
	  $new= false;
	 if ($umpire != $umpires[$umpire]->vars["full_name"]){
	    //echo $umpire;
	  
	    $new_umpire = new _baseball_umpire();
	    $new_umpire->vars["full_name"]= $umpire;
	    $new_umpire->vars["espn_name"] ="";
		$new_umpire->insert();
	   
		$new_statistics = new _baseball_umpire_stadistics();
		$new_statistics->vars["umpire"] = $new_umpire->vars["id"];
		$new_statistics->vars["year"] = $year;
		$new_statistics->vars["k_bb"] = $kbb;  
		$new_statistics->insert();
		$new=true;  
	 }
	 
	 if ($new){
      $statistics = get_umpire_basic_stadistics($new_umpire->vars["id"],$year);
	 }
	 else {
	  $statistics = get_umpire_basic_stadistics($umpires[$umpire]->vars["id"],$year);	 
      }
	  
	  
	  echo "<pre>";
      // print_r($statistics);
      echo "</pre>";

      if (is_null($statistics) && (!$new)){ 
		$new_statistics = new _baseball_umpire_stadistics();
		$new_statistics->vars["umpire"] = $umpires[$umpire]->vars["id"];
		$new_statistics->vars["year"] = $year;
		$new_statistics->vars["k_bb"] = $kbb;  
		$new_statistics->insert();
	    $statistics = get_umpire_basic_stadistics($umpires[$umpire]->vars["id"],$year);
	  }
	 
	 
   	 $statistics->vars["hw"] = $hw;
 	 $statistics->vars["rw"] = $rw;
 	 $statistics->vars["nd"] = $nd;
     $statistics->vars["pct_hom"] = $pct_hom;
	 $statistics->vars["pl_hom"] = $pl_hom;
	 $statistics->vars["pl_rod"] = $pl_rod;
	 $statistics->vars["run"] = $run;
	 $statistics->vars["ov"] = $ov;
 	 $statistics->vars["un"] = $un;
  	 $statistics->vars["p"] = $p;
  	 $statistics->vars["pct_ovr"] = $pct_ovr;
 	 $statistics->vars["inn_per"] = $inn_per;
 	 $statistics->vars["era"] = $era;
  	 $statistics->vars["k_bb"] = $kbb;
 	 $statistics->vars["inn_bb"] = $inn_bb;
	 
	 if (!is_null($statistics)){
	   $statistics->update(array("hw","rw","nd","pct_hom","pl_hom","pl_rod","run","ov","un","p","pct_ovr","inn_per","era","k_bb","inn_bb")); 
	 } else { echo $umpire." ".$umpires[$umpire]->vars["id"]."<BR>"; }
    // break;
   }

  
   if (contains_ck($element->plaintext,"ML TOTALS / AVER")){
	  // break;
	   $valid_line = false; 
	   $cont_lines=-32;   
   }   
//  $cont_lines++;
   if($cont_lines == 15 && $valid_line){ 
    //echo "-*-*".$element->plaintext."-*-*<BR><BR>";
   echo "</TR>"; $cont_lines = -1;}
    $cont_lines++;
   
  }//valid line

}
?>   
</table>   
<?   

?>