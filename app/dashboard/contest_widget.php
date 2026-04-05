<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$book = get_sportsbook($_GET["book"]);

if($book->id == 3){$promoid = "2749";}
else if($book->id == 7){$promoid = "2750";}

if($_SESSION['cc']!=""){
	$current_affiliate->id .= "-".$_SESSION['cc'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Contest Widget</title>
<script type="text/javascript" src="http://jobs.inspin.com/includes/js/encrypt.js"></script>
</head>
<script type="text/javascript">

function copy_code(field){
	field.focus();
	field.select();
}
</script>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>

<div class="page_content">
<div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
<span class="page_title">Contest Widget</span><br /><br />

<? if($promoid != ""){ ?>

<div style="float:none;" class="gray_box">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><strong>Code</strong></td>
        <td width="50%"><strong>Preview</strong></td>
      </tr>
      <tr>
        <td width="50%" valign="top">
        	<textarea name="code_field" cols="40" rows="10" readonly="readonly" id="code_field" onclick="copy_code(this)"><iframe id="ipreview" frameborder="0" width="380" height="805" src="https://www.commissionpartners.com/widgets/contest_widget.php?book=<? echo $book->id ?>&aid=<? echo $current_affiliate->id ?>&pid=<? echo $promoid ?>" scrolling="no"></textarea><br />
        </td>
        <td width="50%" valign="top">
        	<iframe id="ipreview" frameborder="0" width="380" height="805" src="https://www.commissionpartners.com/widgets/contest_widget.php?book=<? echo $book->id ?>&aid=<? echo $current_affiliate->id ?>&pid=<? echo $promoid ?>" scrolling="no">
            </iframe>            
        </td>
      </tr>
    </table>
</div>
<? }else{echo "No ". $book->name . " Widgets Available";} ?>
</div>
<? include "../includes/footer.php" ?>