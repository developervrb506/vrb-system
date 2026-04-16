<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Agent Tool Access</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Agent Tool Access </span><br /><br />

 
 <?
 
 $sub=0;
 $show=0;
 
 if(isset($_POST['agent'])){
  $agent= $_POST['agent'];
 } else { 
  if(isset($_GET['agent'])){
   $agent= $_GET['agent'];  
  }
 }
 
  $total = param('total');
  $str_tool = "";
 
 if(isset($_POST['agent'])){
	 for ($j=1;$j<=$total;$j++){
	 if (isset($_POST['rep_'.$j])){
	$str_tool .= param('pos_'.$j).","
;	 }
	  
  }
 
 $str_tool = substr($str_tool,0,-1); 
	 
 } else {
 
  if(isset($_GET['tools'])){
    $str_tool= param('tools');
	$show = 1;
  }
  
 }
 
 
 if (isset($_POST['sub'])){
  $sub=1;	 
 }
$data = "?agent=".$agent."&sub=".$sub."&tools=".$str_tool."&show=".$show;
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_manager/vrb_agent_tool_access.php".$data); 
?>


</div>
<? include "../../includes/footer.php" ?>