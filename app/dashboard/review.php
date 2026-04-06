<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reviews</title>
</head>
<body>
<? include "../includes/header.php" ?>
  <? include "../includes/menu.php" ?>
  <? $book = 1; ?>
  <? $code = get_affiliate_code($current_affiliate->id, $book); ?>
  <div class="page_content" style="padding-left:20px;"> <span class="page_title">Reviews</span><br />
    <br />
    <br />
    <div class="conte_banners">
      <div class="conte_banners_header" style="width:200px;"><strong>Sportsbook: <a href="http://www.wagerweb.com/redir.php?PromoID=<? echo $code; ?>&mediaTypeID=11&url=http://www.wagerweb.com/" class="normal_link">Wagerweb.com</a></strong></div>
      <br />
      <div style="font-size:12px;">
        <p><strong>Site URL:</strong> <a class="normal_link" href="http://www.wagerweb.com/redir.php?PromoID=<? echo $code; ?>&mediaTypeID=11&url=http://www.wagerweb.com/">http://www.wagerweb.com</a></p>
        <p><strong>Customer Service: </strong>1-888-GO4BETS</p>
        <p><strong>Email:</strong> <a class="normal_link" title="mailto:support@wagerweb.com" href="mailto:support@wagerweb.com">support@wagerweb.com</a></p>
        <p><strong>US Players Allowed:</strong> Yes</p>
        <p><strong>Exclusive Promotion:</strong></p>
        <ul>
          <li>100%  Sign Up Bonus </li>
          <li>Deposit $100 get $100</li>
        </ul>
        <p><strong>Promo Code</strong>: <? echo $current_affiliate->web_name ?></p>
        <p><a href="<?= BASE_URL ?>/landings/stepuptotheplate/?aid=<? echo $current_affiliate->id ?>" target="_blank" class="normal_link">Click here</a> to secure above promotion</p>
        <p><strong>Additional Current Promos:</strong></p>
        <ul>
          <li>100% Reload Bonus</li>
          <li>Cashback Rewards Sportsook & Casino</li>
          <li>Free Payouts Monthly</li>
          <li>25% Referral Bonus</li>
        </ul>
        <p><strong>Location:</strong> San Jose, Costa Rica</p>
        <p><strong>Minimum Deposit:</strong> $25</p>
        <p><strong>Minimum Wager:</strong> $2 internet</p>
        <p><strong>Deposit Methods:</strong></p>
        <ul>
          <li>Visa, Cash Deposits, Cashiers Checks and Bank Wires</li>
        </ul>
        <p><strong>Sportsbook:</strong></p>
        <ul>
          <li>Straights, Parlays, Second Chance Parlays, Teasers, Pleasers, Reverses, If-Bets, Conditionals, Futures, Props, Action Points and Office Pools</li>
          <li>Moneylines, Pointspreads, Totals</li>
        </ul>
        <p><strong>Casino:</strong></p>
        <ul>
          <li>100+ games including but not limited to Blackjack, Craps, Roulette, Video Poker, Slots and more </li>
          <li>Casablanca Casino, Desert Treasure Casino and Skillgames</li>
        </ul>
        <p><strong>Racebook:</strong></p>
        <ul>
          <li>Triple Crown, Breeders Cup and A, B, C and D tracks </li>
          <li>W/P/S, Daily Double, Exacta, Parlays, Trifecta, Superfecta, Quinella/House Q's, Pick Three, Pick Four and Pick Six</li>
        </ul>
        <strong>Review:</strong>
        <p><a class="normal_link" href="http://www.wagerweb.com/redir.php?PromoID=<? echo $code; ?>&mediaTypeID=11&url=http://www.wagerweb.com/" rel="nofollow" target="_blank"> <strong>Wagerweb</strong></a> Sportsbook, Casino and  Racebook continues&nbsp;to be a leader in offshore betting. Established in 1997  they have earned a well-deserved reputation based on safety, convenience and  quick reliable payouts. <br />
          <br />
          Located  in San Jose, Costa Rica they have steadily built a large loyal customer base  over the last 10+ years. Big bonuses, cash back free plays and free payouts are  enjoyed by all customers who play at Wager web. <br />
          <br />
          Wager  web lives and breathes customer service. Working with players to ensure easy  deposits, quick payouts and the very best bonuses fuels the success of their  operation. <br />
          <br />
          An  experienced team of bookmakers, sales reps and marketing personnel has turned  this once small sports book into an enviable operator. <br />
          <br />
          Open  an account at Wager web and see for yourself how much fun and rewarding  offshore betting can be at the right sports book. Thousands of players over  10+years can't be wrong. </p>
        <p><a class="normal_link" href="http://www.wagerweb.com/redir.php?PromoID=<? echo $code; ?>&mediaTypeID=11&url=http://www.wagerweb.com/" rel="nofollow" target="_blank"> <strong>The odds   are finally in your favor</strong></a></p>
        <p><strong>Endorsement:</strong></p>
        <? $endo = get_endorsement($current_affiliate->id,$book); ?>
        <p><em>"<? echo nl2br($endo[0]); ?>"</em></p>
        <p><strong><? echo nl2br($endo[1]); ?></strong></p>
      </div>
    </div>
    <? $book = 4; ?>
    <? $code = get_affiliate_code($current_affiliate->id, $book); 
	   $code = str_replace("_868","_2",$code);	
	?>
    <div class="conte_banners">
      <div class="conte_banners_header" style="width:200px;"><strong>Sportsbook: <a href="http://partners.commission.bz/processing/clickthrgh.asp?btag=<? echo $code; ?>" class="normal_link">Betonline.com</a></strong></div>
      <br />
      <div style="font-size:12px;">
        <p><strong>Site URL:</strong> <a class="normal_link" href="http://partners.commission.bz/processing/clickthrgh.asp?btag=<? echo $code; ?>">http://www.BetOnline.com</a></p>
        <p><strong>Customer Service:</strong> 1-888-426-3661</p>
        <p><strong>Support Email:</strong> <a class="normal_link" title="mailto:cs@betonline.com" href="mailto:cs@betonline.com">cs@betonline.com</a></p>
        <p><strong>US Players Allowed:</strong> Yes</p>
        <p><strong>Exclusive Promotions:</strong></p>
        <ul>
          <li>Signup Bonus: 15-25% (depending on deposit method)</li>
          <li>Casino Signup Bonus: 100% slots bonus</li>
          <li>Reload Bonus: 10-25% (depending on deposit method)</li>
          <li>Casino Signup Bonus: 25%  reload bonus</li>
          <li>Casino Rebate:  10% cashback on losses</li>
        </ul>
        <p><a href="http://partners.commission.bz/processing/clickthrgh.asp?btag=<? echo $code; ?>" target="_blank" class="normal_link">Click here</a> to secure above promotion</p>
        <p><strong>Additional Promos:</strong></p>
        <ul>
          <li>VIP Program: Tiered VIP Program offering cash, rewards and higher limits</li>
        </ul>
        <p><strong>Location:</strong> Panama<br />
          <strong>License  Jurisdiction:</strong> Panama<br />
          <strong>Year  Established:</strong> 1991</p>
        <p><strong>Minimum  Wager: </strong>Online $1,  telephone $25</p>
        <p><strong>Deposit Methods: </strong>Visa,  Master Card and Amex, Wire Transfer (Money Gram, WU) Bankwire, Check, Book to  Book</p>
        <p><strong>Withdrawal  Methods: </strong>Wire  Transfer (Money Gram, WU) Bankwire</p>
        <p><strong>Sportsbook  Software:</strong> ASI</p>
        <p><strong>Casino  Software:</strong> DGS and BetSoft</p>
        <p><strong>RaceBook  Software:</strong> Digital  Gaming Solutions (DGS)</p>
        <p><strong>Currency:</strong> USD</p>
        <p><strong>Language:</strong> English</p>
        <p><strong>Review:</strong> </p>
        <p align="justify"><a class="normal_link" href="http://partners.commission.bz/processing/clickthrgh.asp?btag=<? echo $code; ?>">BetOnline’s</a> management has&nbsp;had a significant presence in the online  gaming community since 1991. During this time BetOnline have been incredibly  dedicated to one thing and one thing only: delivering the most exciting and  dynamic experiences possible in online gaming. BetOnline’s staff is committed  to providing the best possible Account Management service in every aspect, from  general questions, promotional notifications and lightning-fast response times. </p>
        <p align="justify"> BetOnline operates out of Panama City, Panama, which has been referred  to as &quot;the banking capital of Latin America&quot;. Panama is a reliable  and secure business environment, providing a solid infrastructure, cutting-edge  Internet bandwidth and a government that strictly regulates and monitors  offshore gaming activity.&nbsp; Unlike other Central American countries Panama  is considered a first world country and is set up to manage offshore gaming  companies.</p>
        <p align="justify"> Our Sportsbook offers the best odds in all major sports and leagues  including the NBA, NHL, MLB, NCAA basketball and football, golf, soccer, boxing  and much more. Wondering how your team did in its last game? BetOnline.com has  you covered with our own Stats Center, complete with wagering trends. For those  who&nbsp;may not&nbsp;follow sports as in depth as we do, BetOnline has been  designed to&nbsp;offer opportunities to wager in many other realms.&nbsp;Odds  in every aspect of politics and entertainment are constantly being added to our  futures and propositional bet listings. Our Racebook is the best in the world,  with up-to-post-time wagering and the most major/minor track  listings&nbsp;offered in the industry.</p>
        <p align="justify"> If sports, horses or politics are not&nbsp;in your list of favourite  things to wager on, don't hesitate to try BetOnline’s&nbsp;brand new,  state-of-the-art live internet Casino, featuring a full selection of table and  card games like Hold 'Em, Keno and Blackjack. This casino is the first of its  kind with incredible new graphics, Blackjack tournaments and cash back  offerings for casino losses. </p>
        <p align="justify">Whether your passion is sports, poker, politics,  entertainment, horse racing or casino action, look no further than BetOnline  for the most exciting and enjoyable experience on the web. With the world's  finest customer service, lightning-fast payouts and a constant stream of  promotions for you to take advantage of, it only makes sense to bet online at <a class="normal_link" href="http://partners.commission.bz/processing/clickthrgh.asp?btag=<? echo $code; ?>">BetOnline</a>.</p>
        <p><strong>Endorsement:</strong></p>
        <? $endo = get_endorsement($current_affiliate->id,$book); ?>
        <p><em>"<? echo nl2br($endo[0]); ?>"</em></p>
        <p><strong><? echo nl2br($endo[1]); ?></strong></p>
      </div>
    </div>
  </div>
  <? include "../includes/footer.php" ?>