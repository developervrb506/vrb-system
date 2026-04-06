<div class="wrapper_content_right">
  <div class="content_right_external">
    <div class="titulos_right">News and updates</div>
    <? $news = get_all_news_updates(); ?>
    <? if ( count($news) > 0 ) { ?>
    <div id="featured_border_news_updates" class="jcarousel-container">
      <div id="featured_wrapper_news_updates" class="jcarousel-clip">
        <ul id="featured_news_updates" class="jcarousel-list">
          <?
          foreach($news as $new){		   
	      ?>
          <li>
            <div class="text_news_right"><br />
              <span class="negrita14"><? echo $new->vars["title"] ?></span><br />
              <span class="orange14"><? echo date("F j, Y, g:i a",strtotime($new->vars["nudate"])).' et'; ?><br />
              </span><? echo $new->vars["description"] ?></div>
          </li>
          <? } ?>
        </ul>
      </div>
    </div>
    <? } ?>
  </div> 
  <div class="content_right_external" style="height:30px; border-top:1px solid #999;"> 
    <?php /*?><div id="wrap-right"> 
      <ul id="logos-aboutus" class="jcarousel-skin-tango">
        <li><img src="<?= BASE_URL ?>/images/inspin-right.jpg" width="75" height="75" /></li>
        <li><img src="<?= BASE_URL ?>/images/wagerweb-right.jpg" width="75" height="75" /></li>
        <li><img src="<?= BASE_URL ?>/images/sb-logo-right.jpg" width="75" height="75" /></li>
        <li><img src="<?= BASE_URL ?>/images/bet-on-line-right.jpg" width="75" height="75" /></li>
        <li><img src="<?= BASE_URL ?>/images/book-maker-right.jpg" width="75" height="75" /></li>
      </ul>    
  </div><?php */?>
</div>
</div>
