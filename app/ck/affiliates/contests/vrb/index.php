<?php include("C:/websites/jobs.inspin.com/includes/functions.php"); ?>
<?php require_once('C:/websites/jobs.inspin.com/contests/functions.php');?>
<? 
$cid = $_GET["cid"];
if(!isset($cid)){$cid = 0;}
$contest = get_contest_by_id($cid);
$loged = true;
$id_customer = $_GET["aid"];
 ?>
<script type="text/javascript" src="http://jobs.inspin.com/includes/js/functions-header.js"></script>
<link rel="stylesheet" href="http://jobs.inspin.com/wp-content/themes/inspin2011/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://jobs.inspin.com/wp-content/themes/inspin2011/old-style.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://jobs.inspin.com/twitter/functions.js"></script>

<? 
$league = $contest->league; 
include("sidebar.php"); 
?>
<div class="box_content_left_interna_contest">
<div id="sportsTrendsRight" class="floatRight" style="width:100%">
   <div>
   <? if (is_on_air($contest->open_date, $contest->close_date) && $contest->visible){ ?>
   		<form name="contest_form" action="fill_contest.php" method="post">
        <input name="contest_id" id="contest_id" type="hidden" value="<? echo $contest->id ?>">
        <input name="customer_id" id="customer_id" type="hidden" value="<? echo $id_customer ?>">
        <? if($loged){$fill = is_fill_vrb($contest->id, $id_customer);} ?>
        <div class="black_box_content">
          	<div class="gray_tittle_content">
			<? echo $contest->name ?>
            <? if($fill){ ?> <br /><div style="float:left; width:auto;"><span style="color:#FFF; font-size:12px;">Thanks for playing. Your picks are posted below. </span></div> <div style="margin-top:-7px; float:right; margin-right:240px;"><img src="../../images/contest/down_arrow.png" width="19" height="26" /></div>
            <? } ?>
            </div>
        <br>
        <!--Questions Content display dynamically here--> 
        <? 
        $i = 1;
        ?>
        <?
        foreach($contest->questions as $question){
        ?>
        <!--Questions Edit Content-->
        <div class="question_background">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><img src="http://jobs.inspin.com/images/contest/<? echo $i ?>.jpg" width="51" height="62" alt="<? echo $i ?>" /></td>
                    <td>
                    	<div class="question_text_content">
                            <span class="question_tittle"><? echo $question->text ?></span>
                            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                            <!--Questions Edit Content-->
                            <? $e = 1;
								foreach($question->answers as $answ){ 
									if($e%2){$style = "background:#e5e5e5";}else{$style = "";}
								?>
                              <tr>
                                <td width="5"><? if($loged){ ?><input name="radio_<? echo $question->id ?>" type="radio" id="radio_<? echo $question->id ?>" value="<? echo $answ->id ?>" <? if(is_answer_select_by_customer_vrb($answ->id, $id_customer)){echo " checked";} if($fill){echo ' disabled="disabled"';}  ?>  ><? } ?></td>
                                <td><? echo $answ->text ?></td>
                              </tr>
                              <?  
								  $e++;
									} 
									$i++;
								?>
                             
                            </table>
                        </div>
                    </td>
                  </tr>
                </table>
          </div><br />
          <? } ?>
          <div class="submit_btn_div_contest"><? if(!$fill){ if($loged){?> 
          	<input type="image" src="http://jobs.inspin.com/images/contest/submit.jpg" name="Submit" value="Submit" /> <? }} ?> 
            <br /><br />
          </div> 
          </div>
        
        </form>
        <? }else{?> <img src="http://jobs.inspin.com/images/contest/unavailable.jpg" width="279" height="55" alt="Unavailable" /><? } ?>
  </div>
</div>
<div class="clear"></div>
</div>
<script type="text/javascript">

</script>