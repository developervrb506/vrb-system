<? require_once('C:/websites/jobs.inspin.com/contests/functions.php'); ?>
<script type="text/javascript" src="http://jobs.inspin.com/twitter/functions.js"></script>

<div id="home_content_main" style="width:1015px;">

<div class="internal_content_page">

<? include("sidebar.php"); ?>
<div class="box_content_right_interna_contest">   
        <div class="black_box_content_new_version">
        	<? $contests = get_all_contests_by_league($league); ?>
          	<img src="http://jobs.inspin.com/images/contest/<? echo $league ?>_b.jpg" width="696" height="335" alt="<? echo $league ?> Contest" />
        <br />        
        <div class="question_background">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"></td>
                    <td>
                    	<? if(!$loged){ ?>
						<p class="message_insider_login">To play this contest and to have access to other exclusive INSPIN content, login below or become an Insider today for FREE.</p>
                        <? include('C:/websites/jobs.inspin.com/includes/headlines/articles/index.php'); ?>
                        <? } else { ?>                        
                        <div class="question_text_content">
                        <div class="select_contest_title">
						  <? if(count($contests) > 0){echo "Select a " . $league . " Contest:"; }
						  else{echo "No Current $league Contest(s) Available";}																	
						  ?>						
                        </div>                        
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">                              
					<?
                    $i = 0;
                    foreach($contests as $contest){
                        $i++;
                        if($i % 2){$style = "f3f3f3";}else{$style = "fafafa";}
						//$url_contest = "http://www.".this_site()."/contests/index.php?cid=" . $contest->id;
						$count = explode(" ",count_down($contest->close_date));
                    ?>
                    	<tr class="contetn_title_box_list" style="background:#<? echo $style ?>;">
                          <td class="contetn_title_box_list_cell"><ul class="ul_contest_content">
                            <li>
                            <?php /*?><a style="text-decoration:none" href="<? echo $url_contest ?>"><? echo $contest->name ?></a><?php */?>
                            <a style="text-decoration:none" onclick="f_set_cookie_contest('<? echo $contest->id ?>');" href="javascript:;"><? echo $contest->name ?></a>
                            </li>
                          </ul></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[0]; ?><br /><span class="little_black_text_contest">HOUR</span></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[2]; ?><br /><span class="little_black_text_contest">MIN</span></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[4]; ?><br /><span class="little_black_text_contest">SEC</span></td>
                          <td width="100" class="contetn_title_box_list_cell_click">
                          	<?php /*?><a style="color:#000; font-size:12px;" class="links_azul_triangulito_der" href="<? echo $url_contest ?>">Click Here</a><?php */?>
                            <script language="javascript">
			                  deleteCookie("contestid_contest_detail");               
			                </script>
                            <a style="color:#000; font-size:12px;" class="links_azul_triangulito_der" onclick="f_set_cookie_contest('<? echo $contest->id ?>');" href="javascript:;">Click Here</a>
                          </td>
                        </tr>                                                
          			<? } ?>
                   	</table>
          			</div>
                    <? } ?>                    
                    </td>
                  </tr>
                </table>
          </div><br />
          </div>
<div class="clear"></div>
</div>
</div>
</div>