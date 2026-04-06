<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball Report</title>


<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"pitches",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"pitches",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
 <? $page_style = " width:1600px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 
$umpires = get_all_umpires();
$ump_data = get_all_baseball_umpires_data_index();
$years =  get_umpire_year_stadistics();
$last = end($years);
$last_1 = $last["year"] - 1; 
$last_2 = ($last["year"] - 2);
$this_year = $last["year"];
$limit_starts = 25;


echo "<pre>"; 
//print_r($years);
echo "</pre>";

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Umpire Stadistics Report  
</span><br /><br />



		<table class="sortable" width="100%" border="0" cellspacing="0" cellpadding="0">
		 <thead>
          <tr>
            <th width="120" class="table_header sorttable_nosort" align="center" >Umpire</th>
			
   			<? foreach ($years as $year){ ?>   
            <th width="60" colspan="2"  class="table_header sorttable_nosort" align="center"> <? echo $year["year"]?>
            <BR>
            <table border="0"><tr><td width="60" align="left"> Starts  </td><td width="60" align="left"> K/bb </td></tr></table>
            </th>    
            <? } ?>
            
            <th class="table_header" align="center" style="cursor:pointer;" >Weighted_AVG</th>
            <th class="table_header" align="center" style="cursor:pointer;" >Weighted_AVG <? echo $this_year ?> </th>                                    
            <th class="table_header" align="center" style="cursor:pointer;" ><? echo $last_2 ?>_DIFF</th>                                                
            <th class="table_header" align="center" style="cursor:pointer;" ><? echo $last_1 ?>_DIFF</th>
            <th class="table_header" align="center" style="cursor:pointer;" ><? echo $this_year ?>_DIFF</th>
            <th class="table_header sorttable_nosort" align="center" style="display:none" >Q</th>  
            <th class="table_header sorttable_nosort" align="center" style="display:none" >R</th> 
            <th class="table_header sorttable_nosort" align="center" style="display:none" >S</th>
            <th class="table_header sorttable_nosort" align="center" style="display:none" >T</th>                                                            
			<th class="table_header" align="center" style="display:none" >U</th>
			<th class="table_header" align="center" style="cursor:pointer;" >Volatility_years</th>                        
			<th class="table_header" align="center" style="cursor:pointer;" >Volatility</th>          
			
		 </tr>
         </thead>
          <tbody>
         
		  
				
			<?
			  $info = array();
              foreach ($umpires as $umpire) {
				if($i % 2){$style = "1";}else{$style = "2";} $i++;
				?>
				<tr id="tr_<? echo $umpire->vars["id"] ?>">
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire->vars["umpire"] ?></td> 

				<?
                $t_weigted_avg = 0;
				$t_starts = 0;
				$t_weigted_avg_last = 0;
				$t_starts_last = 0;
				$first_1 =  $years[0]["year"];
				$first_2 =  $years[1]["year"];
				?>
                 <? foreach ($years as $year){ ?>  
                 <?
                  $weigted_avg = 0;
				  $weigted_avg_last = 0; 
				 ?>
                <td width="60" align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"]?></td> 
                <td width="60" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"]?></td> 
				 
                 <?
                  $weigted_avg = $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"] * $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];

				  $t_starts = $t_starts + $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"]; 
				  $t_weigted_avg = $t_weigted_avg + $weigted_avg;
				  
				  if ($year['year'] != $this_year){
				   $weigted_avg_last = $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"] * $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];  
				   $t_starts_last = $t_starts_last + $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"]; 
				  $t_weigted_avg_last = $t_weigted_avg_last + $weigted_avg_last;
				  }
				  
				  if($year["year"] == $last_2){ $kbb_2 = $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];}
				  if($year["year"] == $last_1){ $kbb_1 = $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];}	
				  if($year["year"] == $this_year){ $kbb_3 = $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];}			  
				  $info[$year["year"]."_starts"] = $ump_data[$umpire->vars["id"]."_".$year["year"]]["starts"]; 
				  $info[$year["year"]."_kbb"] = $ump_data[$umpire->vars["id"]."_".$year["year"]]["k_bb"];
				  
                 ?>
                 
                <? } ?>
                 <? if ($t_starts == 0 ){ $t_starts = 1;}?>
                 <? $t_avg = $t_weigted_avg/$t_starts;
				     if ($t_starts_last == 0 ){ $t_starts_last = 1;}
				    $t_avg_last = $t_weigted_avg_last/$t_starts_last;
				    $volatily_years = 0;
					$avg = array();
				
				     if ($info[$first_1."_starts"] >= $limit_starts && $info[$first_2."_starts"] >= $limit_starts){
				       
						$q = abs($info[$first_2."_kbb"]-$info[$first_1."_kbb"]); 		
						$volatily_years++;
						$avg[] = $q;
					 }else $q="";
					 
					 $first_1++;$first_2++;
					 
					 if ($info[$first_1."_starts"] >= $limit_starts && $info[$first_2."_starts"] >= $limit_starts){
				       
						$r = abs($info[$first_2."_kbb"]-$info[$first_1."_kbb"]); 		
						$volatily_years++;
						$avg[] = $r; 
					 }else $r="";
					 
					 $first_1++;$first_2++;
					 
					 if ($info[$first_1."_starts"] >= $limit_starts && $info[$first_2."_starts"] >= $limit_starts){
				       
						$s = abs($info[$first_2."_kbb"]-$info[$first_1."_kbb"]); 		
						$volatily_years++; 
						$avg[] = $s;
					 }else $s="";
					 
					 $first_1++;$first_2++;
					 
					 if ($info[$first_1."_starts"] >= $limit_starts && $info[$first_2."_starts"] >= $limit_starts){
				       
						$t = abs($info[$first_2."_kbb"]-$info[$first_1."_kbb"]); 		
						$volatily_years++;
						$avg[] = $t; 
					 }else $t="";
					 
					  $first_1++;$first_2++;
					 
					 if ($info[$first_1."_starts"] >= $limit_starts && $info[$first_2."_starts"] >= $limit_starts){
				       
						$u = abs($info[$first_2."_kbb"]-$info[$first_1."_kbb"]); 		
						$volatily_years++; 
						$avg[] = $u;
					 }else $u="";
					 
					 
                  if (count($avg)> 0) {
					  
				    $v_avg = array_sum($avg) / count($avg);
				  
				  } else {$v_avg = 0; }

				 $ump_info = get_baseball_umpires_data($umpire->vars["id"]);
				  if (is_null($ump_info)) {
					$ump_info = new _baseball_umpire_data();  
					$ump_info->vars["umpire"] =  $umpire->vars["id"]; 
					$ump_info->vars["weighted_avg"] = number_format($t_avg,2);
					$ump_info->vars["weighted_avg_last"] = number_format($t_avg_last,2);
					$ump_info->vars["volatility"] = number_format($v_avg,3);
				    $ump_info->insert();
				  }
				  else {
					$ump_info->vars["umpire"] =  $umpire->vars["id"]; 
					$ump_info->vars["weighted_avg"] = number_format($t_avg,2);
					$ump_info->vars["weighted_avg_last"] = number_format($t_avg_last,2);
					$ump_info->vars["volatility"] = number_format($v_avg,3);
				    $ump_info->update();
					  
					  }
				 
				 ?>
                 <? if (!is_int($q)) { $q = 0;}  ?>
                 <? if (!is_int($r))  { $r = 0;}  ?>
                 <? if (!is_int($s))  { $s = 0;}  ?>
                 <? if (!is_int($t))  { $t = 0;}  ?>
                 <? if (!is_int($u))  { $u = 0;}  ?>
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($t_avg_last,2) ?></td>
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($t_avg,2) ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format((+$kbb_2 - $t_avg_last),2) ?></td>                  
				 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format((+$kbb_1 - $t_avg_last),2) ?></td>      
                  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format((+$kbb_3 - $t_avg_last),2) ?></td>                  
                 <td class="table_td<? echo $style ?>" style="font-size:12px;display:none"><? echo number_format($q,2) ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;display:none"><? echo number_format($r,2) ?></td>
                 <td class="table_td<? echo $style ?>" style="font-size:12px;display:none"><? echo number_format($s,2) ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;display:none"><? echo number_format($t,2) ?></td>                  
                 <td class="table_td<? echo $style ?>" style="font-size:12px;display:none"><? echo number_format($u,2) ?></td> 

                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? if ($volatily_years > 0){ echo "<strong>"; }echo $volatily_years; if ($volatily_years > 0 ) { echo "</strong>"; }?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? if ($v_avg > 0){ echo "<strong>"; }echo number_format($v_avg,3); if ($v_avg > 0 ) { echo "</strong>"; }?></td>                                                                     
               </tr>                           
             
        <?  } ?>
		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		  </tbody>
		</table>
    
  
   
   

</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>

