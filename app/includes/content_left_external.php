<?
 if ( current_URL() == BASE_URL . "/aboutus.php" ) { 
   $title = "About Us";
   $url = BASE_URL . "/aboutus.php";
} elseif (current_URL() == BASE_URL . "/contactus.php") { 
   $title = "Contact Us";
   $url = BASE_URL . "/contactus.php";
} 
?>
<div class="content_left">
  <div class="box_content_304" style="margin-right:7px;">
    <div class="titulos"><? echo $title ?></div>
    <div class="content_text_left">
      <? if ( $url == BASE_URL . "/aboutus.php" ) { ?>
      What happens when you mix over a decade of online gaming &amp; betting affiliate management experience, unparalleled relationship-building expertise, and marketing innovations that constantly change the game?
      You get a revenue-driving powerhouse that works hard to grow your business—24/7, 365 days a year.<br /><br />
      We're VRB Marketing, an online marketing affiliate management company that specializes in online gaming and sports betting. Our team is made up of major industry players who have spent time working alongside the world's biggest online gaming companies and sports books.<br /><br />
      That means when you choose to partner with us, you're choosing to work with expert professionals who know the intricacies and nuances of your industry, have key insight into better traffic building strategies, and understand what drives customers to remain loyal.<br /><br />
      While other affiliate programs offer a one-size-fits-all solution, at VRB we believe in a more personal approach. So we work with all affiliates and operators—regardless of size or experience—and help them not just turn a profit, but develop tailored tools and solutions that promote never-ending growth. Higher traffic. Better conversions. More profits. That's the power of VRB Marketing. Partner with us and discover how VRB Marketing can seriously change the game for you.      
      <? } elseif ( $url == BASE_URL . "/contactus.php" ) { ?>      
      Thank you for contacting VRB Marketing, we'll strive  to provide the best service possible.<br />
      <br />
      <div style="float:left; width:300px; height:auto;"> <strong>General Inquiries</strong> <br />
        <strong>
        <ul>
          <li style="list-style:none;">Toll Free Phone: <span style="font-size:16px;"> 1.800.<span style="display:none;">**</span>986.1152</span></li><br />
          <li style="list-style:none;">Live Chat: <a style="color:#e94f04;" href="javascript:;" onclick="Javascript:window.open('<?= BASE_URL ?>/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=1&amp;agsite=vrb','livehelp','width=530,height=360,menubar=no,location=no,resizable=no,scrollbars=no,status=no');return(false);" target="_top">Click  Here</a></li>
        </ul>
        </strong><strong>Affiliate Team:</strong> <br />
        <ul>
          <li style="list-style:none;"> <span style="font-size:18px;"><strong>Kat Chaves</strong></span><br />
            <strong><span style="color:#e94f04">E-mail:</span></strong> katvrbmarketing(at)gmail.com<br />
            <strong><span style="color:#e94f04">Skype:</span></strong> katchaves<br />
            <br />
            <strong><span style="font-size:18px;">Federico Quiros</span></strong><br />
            <strong><span style="color:#e94f04">E-mail:</span></strong> fredvrbmarketing(at)gmail.com<br />
            <strong><span style="color:#e94f04">Skype:</span></strong> Federico_quiros<br />
          </li>
        </ul>
      </div>          
      <? } ?>
    </div>
  </div>
</div>
