<?php include("C:/websites/jobs.inspin.com/includes/functions.php"); ?>
<script type="text/javascript" src="http://jobs.inspin.com/includes/js/functions-header.js"></script>
<link rel="stylesheet" href="http://jobs.inspin.com/wp-content/themes/inspin2011/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://jobs.inspin.com/wp-content/themes/inspin2011/old-style.css" type="text/css" media="screen" />
<?php require_once('C:/websites/jobs.inspin.com/contests/functions.php');?>
<? 
$league = $_GET["le"];
$id_customer = $_GET["aid"];
 ?>
<script type="text/javascript" src="http://jobs.inspin.com/twitter/functions.js"></script>

<? include("sidebar.php"); ?>
<div class="box_content_left_interna_contest">
<div id="sportsTrendsRight" class="floatRight" style="width:100%">
   <div>
        <div class="black_box_content">
        	<? $contests = get_all_contests_by_league($league); ?>
          	<img src="http://jobs.inspin.com/images/contest/<? echo $league ?>_b.jpg" width="569" height="348" alt="<? echo $league ?> Contest" />
        <br>
        
        <div class="question_background">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"></td>
                    <td>
                    	<div class="question_text_content">
                        <div class="select_contest_title"><?
							if(count($contests) > 0){echo "Select a " . $league . " Contests:"; }
							else{echo "No Current $league Contest(s) Available";}
						?></div>
                        
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              
					<?
                    $i = 0;
                    foreach($contests as $contest){
                        $i++;
                        if($i % 2){$style = "f3f3f3";}else{$style = "fafafa";}
						$url_contest = "http://jobs.inspin.com/contests/vrb/index.php?cid=" . $contest->id."&aid=" . $id_customer;
						$count = explode(" ",count_down($contest->close_date));
                    ?>
                    	<tr class="contetn_title_box_list" style="background:#<? echo $style ?>;">
                          <td class="contetn_title_box_list_cell"><ul class="ul_contest_content">
                            <li>
                            	<a style="text-decoration:none" href="javascript:;" onclick="location.href = '<? echo $url_contest ?>'"><? echo $contest->name ?></a>
                            </li>
                          </ul></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[0]; ?><br /><span class="little_black_text_contest">HOUR</span></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[2]; ?><br /><span class="little_black_text_contest">MIN</span></td>
                          <td class="contetn_title_box_list_cell_time"><? echo $count[4]; ?><br /><span class="little_black_text_contest">SEC</span></td>
                          <td width="100" class="contetn_title_box_list_cell_click">
                          	<a style="color:#000; font-size:12px;" class="links_azul_triangulito_der" href="javascript:;" onclick="location.href = '<? echo $url_contest ?>'">Click Here</a>
                          </td>
                        </tr>
                                                
          			<? } ?>
                    	</table>
          			</div>
                    </td>
                  </tr>
                </table>
          </div><br />
          </div>
  </div>
</div>
<div class="clear"></div>
</div>