<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Stadium Formula Data</title>
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>

<script type="text/javascript">

function SendData(frm){
	
 document.getElementById(frm+'_frm').submit();	
}
function change_diff(id,pre){

 var A = document.getElementById(pre+"_minor_"+id).value;
 var B = document.getElementById(pre+"_major_"+id).value;
 var Result = 0;
 
  if(pre == 'pk'){
	   Result = B - A; 
  }	
  if(pre == 'airp'){
	   Result = A - B; 
  }	
  if(pre == 'adi'){
	   Result = A - B; 
  }	
    document.getElementById(pre+"_diff_"+id).value = Result.toFixed(2) ;

}

</script>
</head>
<body>
<? $page_style = " width:1800px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 
$stadiums = get_all_baseball_stadiums();
$std = get_all_stadium_formula_data();

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Stadium Formula Data  
</span><br /><br />
 <div style="height:1000px">	
     <div style="width:35%;float: left; margin-left: 20px;">
      <form id="pk_frm" action="process/actions/stadium_formula_action.php" method="post">
      <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="5" class="table_header" align="center"><strong>PK</strong>
            <input style="float:right" type="button" value="save" onclick="SendData('pk')">
            </td>
          </tr>
          <tr>
            <td   class="table_header" >Stadium</td>
            <td align="center"  class="table_header">Range</td>
			<td align="center"  class="table_header">-</td>
            <td align="center"  class="table_header">+</td>                      
            <td align="center"  class="table_header">Diff</td>                                  
            
         </tr>  
          <? $i = 0; $pre="pk";  
		    foreach ($stadiums as $st) { 
          		
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <input type="hidden" value="<? echo $std[$i]->vars["id_stadium"]?>" name="st_<? echo $i ?>">
				<input type="hidden" value="<? echo $pre ?>" name="pre">                
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $st->vars["name"]; ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" id="<? echo $pre ?>_minor_range_<? echo $i ?>"  name="minor_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_minor_range"]?>"> / <input  style="width:50px" id="<? echo $pre ?>_major_range_<? echo $i ?>" name="major_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_major_range"]?>"></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')"  style="width:50px" id="<? echo $pre ?>_minor_<? echo $i ?>" name="minor_<? echo $i ?>" value="<? echo $std[$i]->vars[$pre."_minor"]?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')" style="width:50px" value="<? echo $std[$i]->vars[$pre."_major"]?>" id="<? echo $pre ?>_major_<? echo $i ?>" name="major_<? echo $i ?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" disabled="disabled"  value="<? echo $std[$i]->vars[$pre."_diff"]?>"  name="diff_<? echo $i ?>" id="<? echo $pre ?>_diff_<? echo $i ?>"  type="number" step="0.01" placeholder='0.00'></td> 
               </tr>
        <? } ?>
			<tr>
			  <td class="table_last" colspan="5"></td>
			</tr>
		
		</table>
        
        </form>
        </div>
        
       <div style="width:30%;float: left; margin-left: 20px;">
      <form id="airp_frm" action="process/actions/stadium_formula_action.php" method="post">
      <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="4" class="table_header" align="center"><strong>AIRP</strong>
            <input style="float:right" type="button" value="save" onclick="SendData('airp')">
            </td>
          </tr>
          <tr>
            <td align="center"  class="table_header">Range</td>
			<td align="center"  class="table_header">-</td>
            <td align="center"  class="table_header">+</td>                      
            <td align="center"  class="table_header">Diff</td>                                  
            
         </tr>  
          <? $i = 0; $pre="airp";  
		    foreach ($stadiums as $st) { 
          		
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <input type="hidden" value="<? echo $std[$i]->vars["id_stadium"]?>" name="st_<? echo $i ?>">
				<input type="hidden" value="<? echo $pre ?>" name="pre">                
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" id="<? echo $pre ?>_minor_range_<? echo $i ?>"  name="minor_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_minor_range"]?>"> / <input  style="width:50px" id="<? echo $pre ?>_major_range_<? echo $i ?>" name="major_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_major_range"]?>"></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')"  style="width:50px" id="<? echo $pre ?>_minor_<? echo $i ?>" name="minor_<? echo $i ?>" value="<? echo $std[$i]->vars[$pre."_minor"]?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')" style="width:50px" value="<? echo $std[$i]->vars[$pre."_major"]?>" id="<? echo $pre ?>_major_<? echo $i ?>" name="major_<? echo $i ?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" disabled="disabled"  value="<? echo $std[$i]->vars[$pre."_diff"]?>"  name="diff_<? echo $i ?>" id="<? echo $pre ?>_diff_<? echo $i ?>"  type="number" step="0.01" placeholder='0.00'></td> 
               </tr>
        <? } ?>
			<tr>
			  <td class="table_last" colspan="4"></td>
			</tr>
		
		</table>
        
        </form>
        </div>
        
         <div style="width:30%;float: left; margin-left: 20px;">
      <form id="adi_frm" action="process/actions/stadium_formula_action.php" method="post">
      <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="4" class="table_header" align="center"><strong>ADI</strong>
            <input style="float:right" type="button" value="save" onclick="SendData('adi')">
            </td>
          </tr>
          <tr>
            <td align="center"  class="table_header">Range</td>
			<td align="center"  class="table_header">-</td>
            <td align="center"  class="table_header">+</td>                      
            <td align="center"  class="table_header">Diff</td>                                  
            
         </tr>  
          <? $i = 0; $pre="adi";  
		    foreach ($stadiums as $st) { 
          		
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <input type="hidden" value="<? echo $std[$i]->vars["id_stadium"]?>" name="st_<? echo $i ?>">
				<input type="hidden" value="<? echo $pre ?>" name="pre">                
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" id="<? echo $pre ?>_minor_range_<? echo $i ?>"  name="minor_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_minor_range"]?>"> / <input  style="width:50px" id="<? echo $pre ?>_major_range_<? echo $i ?>" name="major_range_<? echo $i ?>" type="number" step="0.01" placeholder='0.00' value="<? echo $std[$i]->vars[$pre."_major_range"]?>"></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')"  style="width:50px" id="<? echo $pre ?>_minor_<? echo $i ?>" name="minor_<? echo $i ?>" value="<? echo $std[$i]->vars[$pre."_minor"]?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input onchange="change_diff('<? echo $i ?>','<? echo $pre ?>')" style="width:50px" value="<? echo $std[$i]->vars[$pre."_major"]?>" id="<? echo $pre ?>_major_<? echo $i ?>" name="major_<? echo $i ?>" type="number" step="0.01" placeholder='0.00'></td> 

                <td class="table_td<? echo $style ?>" style="font-size:12px;"><input style="width:50px" disabled="disabled"  value="<? echo $std[$i]->vars[$pre."_diff"]?>"  name="diff_<? echo $i ?>" id="<? echo $pre ?>_diff_<? echo $i ?>"  type="number" step="0.01" placeholder='0.00'></td> 
               </tr>
        <? } ?>
			<tr>
			  <td class="table_last" colspan="4"></td>
			</tr>
		
		</table>
        
        </form>
        </div>
        
    
   
 </div>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>

