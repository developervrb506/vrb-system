<? 
$cid = $_COOKIE["contestid_contest_detail"];

require_once('C:/websites/jobs.inspin.com/contests/functions.php'); ?>
<?
if( !isset($cid) or !$loged ){
  $cid = 0;
  $width = "auto";   
} 
$contest = get_contest_by_id($cid);
?>
<script type="text/javascript" src="http://jobs.inspin.com/twitter/functions.js"></script>

<div id="home_content_main" style="width:<? echo $width; ?>;">

<div class="internal_content_page">
<? 
$league = $contest->league;

if ($loged) {
  include("sidebar.php");
}
?>
<div class="box_content_right_interna_contest">   
   <? if (is_on_air($contest->open_date, $contest->close_date) && $contest->visible){ ?>
   		<form name="contest_form" action="http://jobs.inspin.com/contests/fill_contest-new-version.php" method="post">
        <input name="contest_id" id="contest_id" type="hidden" value="<? echo $contest->id ?>">
        <input name="customer_id" id="customer_id" type="hidden" value="<? echo $current_customer->vars["id"] ?>">
        <? //if($current_customer->vars["premium"]){$fill = is_fill($contest->id, $current_customer->vars["id"]);} ?>
        <? $fill = is_fill($contest->id, $current_customer->vars["id"]); ?>
        <div class="black_box_content">
            <? $contests = get_all_contests_by_league($league); ?>
          	<img src="http://jobs.inspin.com/images/contest/<? echo $league ?>_b.jpg" width="696" height="335" alt="<? echo $league ?> Contest" />
            <br />  
          	<div class="gray_tittle_content">
			<? echo $contest->name ?>
            <? if($fill){ ?> <br /><div style="float:left; width:auto;"><span style="color:#FFF; font-size:12px;">Thanks for playing. Your picks are posted below. </span></div> <div style="margin-top:-7px; float:right; margin-right:240px;"><img src="../images/contest/down_arrow.png" width="19" height="26" /></div>
            <? } ?>
            </div>
        <br>
        <!--Questions Content display dynamically here--> 
        <? 
        $i = 1;
        ?>
        <?
        foreach($contest->questions as $question){
	  	   if($i%2){$style = "1";}else{$style = "2";}
        ?>
        <!--Questions Edit Content-->
        <div class="question_background<? echo $style ?>">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>                   
                    <td>
                    	<div class="question_text_content">
                            <span class="question_tittle"><? echo $question->text ?></span>
                            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                            <!--Questions Edit Content-->
                              <tr>
							  <?
							  foreach($question->answers as $answ){ 								
							  ?>                              
                              <td width="5"><?php /*?><? if($current_customer->vars["premium"]){ ?><input name="radio_<? echo $question->id ?>" type="radio" id="radio_<? echo $question->id ?>" value="<? echo $answ->id ?>" <? if(is_answer_select_by_customer($answ->id, $current_customer->vars["id"])){echo " checked";} if($fill){echo ' disabled="disabled"';}  ?>  ><? } ?><?php */?>
                                
                                <input name="radio_<? echo $question->id ?>" type="radio" id="radio_<? echo $question->id ?>" value="<? echo $answ->id ?>" <? if(is_answer_select_by_customer($answ->id, $current_customer->vars["id"])){echo " checked";} if($fill){echo ' disabled="disabled"';}  ?> >
                                
                                </td>
                                <td><strong><? echo $answ->text ?></strong></td>                              
                              <?								  
							   } 
							  ?>
							  </tr> 
							  <?
                              $i++;
							  ?>                             
                            </table>
                        </div>
                    </td>
                  </tr>
                </table>
          </div>
          <? } ?>
          <div class="submit_btn_div_contest"><?php /*?><? if(!$fill){ if($current_customer->vars["premium"]){?> 
          	<input type="image" src="http://jobs.inspin.com/images/contest/submit.jpg" name="Submit" value="Submit" /> <? }} ?> <?php */?>
            
            <? if(!$fill){ ?> 
          	<input type="image" src="http://jobs.inspin.com/images/contest/submit.jpg" name="Submit" value="Submit" /> <? } ?>             
            <br /><br />
          </div> 
          </div>        
        </form>
        <? }else{?> <?php /*?><img src="http://jobs.inspin.com/images/contest/unavailable.jpg" width="279" height="55" alt="Unavailable" /><?php */?>
		<p style="clear:both;">
<img class="mpage" alt="Daily Sport Contests by Inspin.com" src="http://jobs.inspin.com/images/2014/sports-contest-inspin.jpg" width="150" height="75" /> <h2>Daily Sport Contests by Inspin.com </h2> Test your predicting skills, take part in our exclusive sports contest and play for a chance to win $250 in Insider's points! Wanna take part? 
Just sign up for free account and you will be ready to enter by clicking <a href="http://jobs.inspin.com/insiders/register/index.php" title="Join Now">here</a>.
<div style="clear:both;"></div> 
<p class="seomorelinks"><strong><font color="#FF0000">&gt;</font> Contest Links: </strong> Sports | <a href="http://jobs.inspin.com/sports-contests/nfl" title="NFL">NFL</a> | <a href="http://jobs.inspin.com/sports-contests/nba" title="NBA">NBA</a> | <a href="http://jobs.inspin.com/sports-contests/mlb" title="MLB">MLB</a> | <a href="http://jobs.inspin.com/sports-contests/nhl" title="NHL">NHL</a> 
<hr size="1"><div id="articlesbottom">
<div id="leftbox">
<h2>Choose a Contest for All Major Sports </h2><a href="http://jobs.inspin.com/sports-contests/nfl" title="NFL Sports Contest"><img style="float:left; margin:6px 6px 10px 0px;" alt="NFL Sports Contest" src="http://inspin.com/images/2014/contest-nfl.jpg" width="150" height="200" /></a> <h3>NFL Sports Contests<br>
Sports Contests for Football: </h3> Test your NFL knowledge and betting skills
<strong><font color="#FF0000">&gt;</font> View Page:</strong> <a href="http://jobs.inspin.com/sports-contests/nfl" title="Football Contests">Football Contests</a> <div style="clear:both;"></div> 
<hr size="1" color="#999999">
<a href="http://jobs.inspin.com/sports-contests/nba" title="NBA Sports Contest"><img style="float:left; margin:6px 6px 10px 0px;" alt="NBA Sports Contest" src="http://inspin.com/images/2014/contest-nba.jpg" width="150" height="200" /></a> <h3>NBA Sports Contests<br>
Sports Contests for Football: </h3> Test your NBA knowledge and betting skills
<strong><font color="#FF0000">&gt;</font> View Page:</strong> <a href="http://jobs.inspin.com/sports-contests/nba" title="Basketball Contests">Basketball Contests</a> <div style="clear:both;"></div> 
<hr size="1" color="#999999">
<a href="http://jobs.inspin.com/sports-contests/mlb" title="MLB Sports Contest"><img style="float:left; margin:6px 6px 10px 0px;" alt="MLB Sports Contest" src="http://inspin.com/images/2014/contest-MLB.jpg" width="150" height="200" /></a> <h3>MLB Sports Contests<br>
Sports Contests for Football: </h3> Test your MLB knowledge and betting skills
<strong><font color="#FF0000">&gt;</font> View Page:</strong> <a href="http://jobs.inspin.com/sports-contests/mlb" title="Baseball Contests">Baseball Contests</a> <div style="clear:both;"></div> 
<hr size="1" color="#999999">
<a href="http://jobs.inspin.com/sports-contests/nhl" title="NHL Sports Contest"><img style="float:left; margin:6px 6px 10px 0px;" alt="NHL Sports Contest" src="http://inspin.com/images/2014/contest-NHL.jpg" width="150" height="200" /></a> <h3>NHL Sports Contests<br>
Sports Contests for Football: </h3> Test your NHL knowledge and betting skills
<strong><font color="#FF0000">&gt;</font> View Page:</strong> <a href="http://jobs.inspin.com/sports-contests/nhl" title="Hockey Contests">Hockey Contests</a> <div style="clear:both;"></div> 
<hr size="1" color="#999999">
</div>
<div id="rightboxfr"><img alt="Inspin.com Insider" src="http://jobs.inspin.com/images/2014/inspin-home-images/sms.jpg" width="400" height="323" />

<hr size="1">
<h2>More Sports and Odds </h2> <a href="http://jobs.inspin.com/odds-scores/nfl" title="NFL Football Odds"><img class="mpage" style="float:left; margin:6px 6px -10px 6px;" alt="NFL Football" src="http://jobs.inspin.com/images/2014/nfl-football-logo-inspin-75.jpg" width="150" height="75" /></a> <h3>NFL Football</h3> <strong><font color="#999999">&gt;</font> Full Game | Half Times | Quarters </strong> 
 <strong><font color="#FF0000">&gt;</font> Odds and Scores:</strong> <a href="http://jobs.inspin.com/odds-scores/nfl" title="NFL Football">NFL Football</a> <p style="clear:both;">
<a href="http://jobs.inspin.com/odds-scores/nba" title="NBA Basketball Odds"><img class="mpage" style="float:left; margin:6px 6px -10px 6px;" alt="NBA Basketball" src="http://jobs.inspin.com/images/2014/nba-basketball-logo-inspin-75.jpg" width="150" height="75" /></a> <h3>NBA Basketball</h3> <strong><font color="#999999">&gt;</font> Full Game | Half Times | Quarters </strong> 
 <strong><font color="#FF0000">&gt;</font> Odds and Scores:</strong> <a href="http://jobs.inspin.com/odds-scores/nba" title="NBA Basketball">NBA Basketball</a> <p style="clear:both;">
<a href="http://jobs.inspin.com/odds-scores/mlb" title="MLB Baseball Odds"><img class="mpage" style="float:left; margin:6px 6px -10px 6px;" alt="MLB Baseball" src="http://jobs.inspin.com/images/2014/mlb-baseball-logo-inspin-75.jpg" width="150" height="75" /></a> <h3>MLB Baseball</h3> <strong><font color="#999999">&gt;</font> Full Game | 1st 5 Innings </strong> 
 <strong><font color="#FF0000">&gt;</font> Odds and Scores:</strong> <a href="http://jobs.inspin.com/odds-scores/mlb" title="MLB Baseball">MLB Baseball</a> <p style="clear:both;">
<a href="http://jobs.inspin.com/odds-scores/nhl" title="NHL Hockey Odds"><img class="mpage" style="float:left; margin:6px 6px -10px 6px;" alt="NHL Hockey" src="http://jobs.inspin.com/images/2014/nhl-hockey-logo-inspin-75.jpg" width="150" height="75" /></a> <h3>NHL Hockey</h3> <strong><font color="#999999">&gt;</font> Full Game | Periods </strong> 
 <strong><font color="#FF0000">&gt;</font> Odds and Scores:</strong> <a href="http://jobs.inspin.com/odds-scores/nhl" title="NHL Hockey">NHL Hockey</a> <p style="clear:both;">
<hr size="1">
<a href="http://jobs.inspin.com/insiders/register/index.php" title="Sign up Inspin.com Insider"><img alt="Sign up For Inspin.com Insider" src="http://jobs.inspin.com/images/2014/inspin-join-now.jpg" width="400" height="75" /></a> <h3>Be An Insider! Join Inspin.com </h3> Got your betting odds? Inspin.com has plenty more sports lines waiting for you, sign up for a FREE insider account now and get access to our trends, previews, matchups, odds, news, and more.   
<p class="joinbnow"><b>Be an <font color="#FF0000">In</font>sider</b> &gt; <a href="http://jobs.inspin.com/insiders/register/index.php" title="Sign up Inspin.com Insider">Join Now</a>
<hr size="1">
</div></div>
		
		
		<? } ?>
<div class="clear"></div>
</div>
</div>
</div>