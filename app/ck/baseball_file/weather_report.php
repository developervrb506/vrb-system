<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){ ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/style.css" rel="stylesheet" type="text/css" />
  <title>Baseball Report</title>
  <link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
   
   <script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.9.1.js"></script> 
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/ck/includes/Datatables/DataTables/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/Datatables/DataTables/js/jquery.dataTables.min.js"> </script>
  
   <?
   /*
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>     
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/ck/includes/Datatables/datatables.css">
   
    <script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/Datatables/DataTables/js/jquery.dataTables.min.js"> </script>
   <script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
  <script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>/ck/includes/DataTables/datatables.js"></script>

 */?>




  <script type="text/javascript" src="js/functions.js"> </script>
  <script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>

  <script type="text/javascript">
  Shadowbox.init();
  </script>
  <script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
  <script type="text/javascript">
      window.onload = function(){
          new JsDatePick({
              useMode:2,
              target:"from",
              dateFormat:"%Y-%m-%d"
          });
          new JsDatePick({
              useMode:2,
              target:"to",
              dateFormat:"%Y-%m-%d"
          });
     

     var table = $('#myTable').DataTable();
 
new $.fn.dataTable.Buttons( table, {
    buttons: [
        'copy', 'excel', 'pdf'
    ]
} );

 };
      
  </script>
  </head>
  <body>
  <? include "../../includes/header.php"  ?>
  <? include "../../includes/menu_ck.php"  ?>
  <? 
  
  //Post params
  
  $from = clean_get("from");
  $to =  clean_get("to");
  if($from == ""){
    $year = date("Y"); 
   }
   else{
   $year = date('Y',strtotime($from));	 
   }
  
  $season =  get_baseball_season($year);
  
  if($from == ""){ 
    $from = $season['start'];
     if ($season['season'] == date('Y')) {
      $to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
     }
     else {$to = $season['end'] ; }
  }
  
  
  $stadiums = get_all_baseball_stadiums();
  
  ?>
  
  <div class="page_content" style="padding-left:10px;">
  <div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
  <span class="page_title">Temp Factors Report
  </span><br /><br />
  
  
  <form method="post">
      From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />&nbsp;&nbsp;
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
      &nbsp;&nbsp;&nbsp;&nbsp;
      <br /><br />
      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", $default_name = "",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
       Factor: 
       <select name="factor">
        <option  <? if ($_POST["factor"] == "humidity"){ echo 'selected="selected"'; }?> value="humidity" >Humedity</option>
        <option <? if ($_POST["factor"] == "temp"){ echo 'selected="selected"' ; }?>value="temp" >Temperature</option>
        <option <? if ($_POST["factor"] == "air_pressure"){ echo 'selected="selected"' ; }?> value="air_pressure" >Air Pressure</option>
        <option <? if ($_POST["factor"] == "dewpoint"){ echo 'selected="selected"' ; }?> value="dewpoint" >Dew Point</option>
        
       </select>
      &nbsp;&nbsp;&nbsp;
      <? /* <input  type="checkbox" <? if (!isset($_POST['factor'])){ echo 'checked="checked"'; } if ($_POST['indoors']){ echo 'checked="checked"'; } ?>  value="1"  name="indoors" />
     Exclude Indoors Games */ ?>
       
       <br /><br />
     <input type="submit" value="Search" />
      
  <br /><br />
  
  
  </form>


  <table id="myTable" class="display">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
    </tbody>
</table>

  </div>
  </body>
  <? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>

