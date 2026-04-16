<? include(ROOT_PATH . "/ck/process/security.php"); 
   if($current_clerk->im_allow("baseball_file")){ ?>
  
 <?
  require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');	
 ?>  
   
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="myhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball File</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<style>
.table-container
{
   /* height: 500px;
    width: 500px; */
    overflow: auto;
}
tbody tr:nth-child(2n)
{
    background-color: #F7F7F7;
}


</style>
<? 

//patch
// replace strstr for myStrstrTrue

$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$year = date('Y',strtotime($from));
$date=  date('Y-m-d',strtotime($from));
$games = get_baseball_games_by_date($from);
$season =  get_baseball_season($year);
$pk_total = 0;
$game_count = 0;
$ump_weighted_total = 0;
$ump_data = get_all_umpire_data();
$column_desc = get_all_baseball_column_description();
$day_bets = get_baseball_bets($from);
$team_speed = get_all_baseball_team_speed($from,"team");
$stadiums_dewpoint = get_all_stadium_dewpoint_avg();
$stadiums_parkfactor_season = get_baseball_stadium_parkfactor_season_data($year);
$green_color = "#9F6"; 
$red_color = "#F30";
$year = date("Y");

$pa_catchers =  get_baseball_pitchers_vs_catchers("a",($year-1)."-01-01");
$ph_catchers =  get_baseball_pitchers_vs_catchers("h",($year-1)."-01-01");

//print_r($ph_catchers);

//Stadium Formula Data;
$std_formula = get_all_stadium_formula_data();
  
    if($current_clerk->vars['id'] != 86 ){
	$subject = 'BASEBALL FILE 2 ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	 send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	}
  


if ($season['start'] > $date){
$preseason = true;
}



 $pitchers = array();
  $ji = 0;
  foreach ($games as $_game_home){
    
      $pitchers[$ji]["startdate"] = $_game_home->vars["startdate"];
	  $pitchers[$ji]["pitcher"] = $_game_home->vars["pitcher_away"];
	  $ji++;
	  $pitchers[$ji]["startdate"] = $_game_home->vars["startdate"];
	  $pitchers[$ji]["pitcher"] = $_game_home->vars["pitcher_home"];
      $ji++;    
  }
  
 
 $j=0;
  $last_game = array();
  foreach ($pitchers as $_pitchers){
   $_last_gameA =  get_baseball_games_last_game_player($_pitchers["pitcher"],$_pitchers["startdate"],"away");	  
    
   if (!is_null($_last_gameA)){
    
    $last_game[$_pitchers["pitcher"]] = $_last_gameA;
   }
  
   $_last_gameH =  get_baseball_games_last_game_player($_pitchers["pitcher"],$_pitchers["startdate"],"home");	  
   if (!is_null($_last_gameH)){
    
     if (isset($last_game[$_pitchers["pitcher"]])){
    
	    if ($last_game[$_pitchers["pitcher"]]["startdate"] < $_last_gameH["startdate"]) {
	       $last_game[$_pitchers["pitcher"]] = $_last_gameH;
	     }
	 } else {
		$last_game[$_pitchers["pitcher"]] = $_last_gameH; 
	 }
   }
  }
  
   
 
   
?>


<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<? /*  <script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script> */ ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!-- For draggable -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
		
	};
</script>
<!--
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="../includes/js/jquery.stickyheader.js"></script> -->
        
<script>


  function fix_changes(){
	  
	  document.getElementById("pitcher_fix").style.display = "block" ;
  }
  
  
 
    function bet_total(type,game){
	
	 var value = document.getElementById("value_"+game).value;
     var action = 1;
	
	 if (type == 'o'){
		 document.getElementById("bets_u_"+game).checked = false; 
	 }
     if (type == 'u'){
		 document.getElementById("bets_o_"+game).checked = false; 
	 }
	 
	 if((document.getElementById("bets_u_"+game).checked == false) && (document.getElementById("bets_o_"+game).checked == false) ){ action = 0;}

	 
	 document.getElementById("changer").src = "process/actions/change_bet.php?type=t&game="+game+"&value="+value+"&bet_type="+type+"&action="+action; 	 
	 //document.location = "process/actions/change_bet.php?type=t&game="+game+"&value="+value+"&bet_type="+type; 	 
   }
   


$(function(){
    $("table").stickyTableHeaders({container: "#container"});
    //$("table").stickyTableHeaders();
});
/*! Copyright (c) 2011 by Jonas Mosbech - https://github.com/jmosbech/StickyTableHeaders
    MIT license info: https://github.com/jmosbech/StickyTableHeaders/blob/master/license.txt */

;(function ($, window, undefined) {
    'use strict';

    var pluginName = 'stickyTableHeaders';
    var defaults = {
            fixedOffset: 0,
            container: null
        };


    /* 
     * This was taken from stackoverflow:
     * http://stackoverflow.com/questions/7501761/div-scrollbar-width
     */
    function getScrollbarWidth() 
    {
        var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
        $('body').append(div); 
        var w1 = $('div', div).innerWidth(); 
        div.css('overflow-y', 'auto'); 
        var w2 = $('div', div).innerWidth(); 
        $(div).remove(); 
        return (w1 - w2);
    }


    function Plugin (el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;
        base.options = $.extend({}, defaults, options);

        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;

        // Cache DOM refs for performance reasons
        base.$window = $(window);
        base.$clonedHeader = null;
        base.$originalHeader = null;
        base.$container = base.options.container != null ? $(base.options.container) : base.$window;

        /* Need to use element to get offset if container is window.
         * Otherwise use container's offset for calculations.
         */
        base.getContainerOffset = function(){
            var c_offset = base.$container.offset();
            var e_offset = base.$el.offset();
            return c_offset === null ? {'top': 0, 'left': e_offset.left} : c_offset;
        };

        /* We need to know how much to scroll to activate and deactivate the
         * sticky header. I originally tried to calculate this using .position
         * on the child element. This works fine so long as the parent element
         * has its position set to something other than "static". Please
         * see this stackoverflow thread for why:
         *  http://stackoverflow.com/questions/2842432/jquery-position-isnt-returning-offset-relative-to-parent
         *
         * So to get this to work everywhere, I grab the difference from
         * the top of the child element and the top of the parent element
         * when the page loads. This should tell us how much we need to
         * scroll to activate the sticky header.
         *
         * Also - the offset function does not seem to take any table
         * captions into consideration. So we check for a table caption
         * and add this in to the amount we need to scroll for an
         * activation.
         */
        var startTopOffset = base.$el.offset().top - base.getContainerOffset().top;
        var caption = base.$el.find('caption');
        if (caption.length){
            startTopOffset += caption.height();
        }
        base.scrollAmountToActivate = startTopOffset;
        base.scrollAmountToDeactivate = base.scrollAmountToActivate + base.$el.height();

        /* See notes in updateWidth for why we need this*/
        base.parentClientWidth = base.$container.width() - getScrollbarWidth();

        // Keep track of state
        base.isCloneVisible = false;
        base.leftOffset = null;
        base.topOffset = null;

        base.init = function () {

            base.$el.each(function () {
                var $this = $(this);

                // remove padding on <table> to fix issue #7
                $this.css('padding', 0);

                $this.wrap('<div class="divTableWithFloatingHeader"></div>');

                base.$originalHeader = $('thead:first', this);
                base.$clonedHeader = base.$originalHeader.clone();

                base.$clonedHeader.addClass('tableFloatingHeader');
                base.$clonedHeader.css({
                    'position': 'fixed',
                    'top': 0,
                    'z-index': 1, // #18: opacity bug
                    'display': 'none'
                });

                base.$originalHeader.addClass('tableFloatingHeaderOriginal');
                base.$originalHeader.after(base.$clonedHeader);

                // enabling support for jquery.tablesorter plugin
                // forward clicks on clone to original
                $('th', base.$clonedHeader).click(function (e) {
                    var index = $('th', base.$clonedHeader).index(this);
                    $('th', base.$originalHeader).eq(index).click();
                });
                $this.bind('sortEnd', base.updateWidth);
            });

            base.updateWidth();
            base.toggleHeaders();

            base.$container.scroll(base.toggleHeaders);
            base.$container.resize(base.toggleHeaders);
            base.$container.resize(base.updateWidth);
        };

        base.toggleHeaders = function () {
            base.$el.each(function () {
                var $this = $(this);
                var newTopOffset = isNaN(base.options.fixedOffset) ?
                    base.options.fixedOffset.height() : base.options.fixedOffset;
                var offset = base.getContainerOffset();
                var scrollTop = base.$container.scrollTop() + newTopOffset;
                var scrollLeft = base.$container.scrollLeft();
                if ((scrollTop > base.scrollAmountToActivate) && (scrollTop < base.scrollAmountToDeactivate)) {
                    var newLeft = offset.left - scrollLeft;
                    if (base.isCloneVisible && (newLeft === base.leftOffset) && (newTopOffset === base.topOffset)) {
                        return;
                    }
                    base.$clonedHeader.css({
                        'top': newTopOffset + offset.top,
                        'margin-top': 0,
                        'left' : newLeft,
                        'display': 'block'
                    });
                    base.updateWidth();

                    base.$originalHeader.css('visibility', 'hidden');
                    base.isCloneVisible = true;
                    base.leftOffset = newLeft;
                    base.topOffset = newTopOffset;
                }
                else if (base.isCloneVisible) {
                    base.$clonedHeader.css('display', 'none');
                    base.$originalHeader.css('visibility', 'visible');
                    base.isCloneVisible = false;
                }
            });
        };

        base.updateWidth = function () {
            // Copy cell widths and classes from original header
            $('th', base.$clonedHeader).each(function (index) {
                var $this = $(this);
                var $origCell = $('th', base.$originalHeader).eq(index);
                this.className = $origCell.attr('class') || '';
                $this.css('width', $origCell.width());
            });

            // Copy row width from whole table
            base.$clonedHeader.css('width', base.$originalHeader.width());

            // One last thing - if our table is inside of another
            // scrolled div, the width of our parent div could
            // be less than that of the cloned header.
            // This would cause the cloned div to display outside
            // of our parent's viewport and would appear "on top of"
            // any scrollbars on our parent. Need to clip.
            if(base.$clonedHeader.width() > base.parentClientWidth)
            {
                var scrollLeft = base.$container.scrollLeft();
                var clipLeft = scrollLeft;
                var clipRight =  base.parentClientWidth + scrollLeft;
                base.$clonedHeader.css({
                    'clip': 'rect(0px, ' + clipRight + 'px, ' 
                                       + base.$clonedHeader.height() + 'px,' 
                                       + clipLeft + 'px)'
                    });
            }
            
        };

        // Run initializer
        base.init();
    }

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
            }
        });
    };

})(jQuery, window);

</script>

<style>
  #wrapper1{
    position: fixed;
    width: 100px;
    border: none 0px red;
    overflow-x: scroll; 
    overflow-y:hidden;
    z-index: 10000;
    padding: 7px 0 60px 27px;
    background-color: #008000;
    border: 2px solid #ffffff;
    color: #ffffff;
    font-size: 16px;
    border-radius: 9px;
    box-shadow: 0 0 16px rgba(0,0,0,0.6);
    background-image: url("./images/sidetoside.png");
    background-position: 50% 40%;
    background-size: 50%;
    background-repeat: no-repeat;
    left: 320px;
    top: 266px;
  }

  #wrapper1{
    height: 20px;
  }

  #div1 {
    width:15500px; /*Aqu{i define la sensibilidad del scroll*/
    height: 20px; 
  } 

  #wrapper2{
    width: 150px;
    height: 
    padding: 15px;
    overflow-x: scroll;
  }

</style>
</head>
<body>
<? $page_style = " width:3500px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<div id="wrapper1" class="draggable">
    <div id="div1"></div>
</div>

<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="baseball_reports.php" class="normal_link">Reports</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="baseball_tools.php" class="normal_link">Tools</a>

</span><BR>
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a id="pitcher_fix" style="display:none" href="jobs/pitchers_game_fix.php?date=<? echo $from ?>" class="normal_link" rel="shadowbox;height=270;width=400">Pitcher Fix </a>
&nbsp;&nbsp; || &nbsp;&nbsp; 
<a id="pitcher_list"  href="pitchers_list.php?date=<? echo $from ?>" class="normal_link" rel="shadowbox;height=600;width=650">Today Pitchers </a>


<br /><br />


<form method="post">
    Date: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
 
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
   
    &nbsp;&nbsp;&nbsp;&nbsp;<span><strong></strong></span>
    <br /><br />
</form>
 <? if (count($games)>6) { ?>
  &nbsp;&nbsp;&nbsp;
   <a href="javascript:;" onclick="move_scroll('up');" title="Go Up"><img src="images/arrow_up.png" width="20px" onclick="move_scroll('up');"  id="up"  title="Go Up" /></a>
   <a href="javascript:;" onclick="move_scroll('down');" title="Go Down"><img src="images/arrow_down.png" width="20px" onclick="move_scroll('down');"  /></a>
   <BR>          
  <? } ?> 

<?
if ($preseason){ ?>
<span style="font-size:14px;">
    <strong>Preseason</strong>
</span><br /><br />	
<? }
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11px;">
  
    <strong>TMP: </strong>Temp in °F, 
    <strong>HM: </strong> % of Humidity, 
    <strong>WS: </strong>Wind Speed (mph),
    <strong>WD: </strong>Wind Direct, 
    <strong>WP </strong>Wind Position,  
    <strong>WG: </strong>Wind Gust (mph),     
    <strong>AirP: </strong>Pressure (in), 
    <strong>DewP: </strong>Dewpoint (°F), 
    <strong>DryA: </strong>Dry Air Density (kg/m3), 
    <strong>VapourP: </strong>Vapour Pressure(hPa), 
    <strong>MoistA: </strong>Moist Air Density (kg/m3), 
    <strong>M_A: </strong>Money Away,
    <strong>M_H: </strong>Money Home, 
    <strong>T 0: </strong>Total Over,
    <strong>T_0J: </strong>Total Over Juice,
    <strong>T U: </strong>Total Under,
    <strong>T_UJ: </strong>Total Under Juice,  
    <strong>SCR: </strong>Score,
</span>
<iframe id="changer" width="1" height="1" scrolling="no" frameborder="0"></iframe>

<?
$games_bets = get_all_games_with_bet_by_date($from,8);//8 is the id for the required identifier
$umpires = get_all_umpires();
$manual_wind = get_all_baseball_stadium_position();
$constants = get_baseball_constants();
$constants = get_baseball_constants();
$fix = false;;
?>
<div id="container" class='table-container'>
<table  id="baseball" name="baseball" width="<? echo $table_width ?>" border="0" cellspacing="0" cellpadding="0" >
 <thead>
  <tr >
 
    <th width="120"  class="table_header" >Date</th>
    <th  name ="game_info_" width="120"  class="table_header">Hour</th>
    <th  name ="game_info_" width="120" class="table_header">Away
    <th width="120" class="table_header">Home</th>            
    <th width="120" class="table_header">Roof</th>            
    <th name="weather_stadistics" width="120" class="table_header">TMP</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">Condition</th>
    <th name="weather_stadistics" width="120" class="table_header">HM</th>
    <th name="weather_stadistics" width="120" class="table_header">WS</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">WD</th>
    <th name="weather_stadistics" width="120" class="table_header">WP</th>
    <th name="weather_stadistics" width="120" class="table_header">WG</th>
    <th name="weather_stadistics" width="120" class="table_header">AirP</th>
    <th name="weather_stadistics" width="120" class="table_header">DewP</th>
    <th name="weather_stadistics" width="120" class="table_header">DryA</th>
    <th name="weather_stadistics" width="120" class="table_header">VapourP</th>  
    <th name="weather_stadistics" width="120" class="table_header">MoistA</th>
    <th name="weather_stadistics" width="120" class="table_header">PK</th>
    <th name="weather_stadistics" width="120" class="table_header">Aird</th> 
    <th name="weather_stadistics" width="120" class="table_header">PK ADJ</th>        
    <th name="weather_stadistics" width="120" class="table_header">AIRP ADJ</th>            
    <th name="weather_stadistics" width="120" class="table_header">TOTAL ADJ</th>            
    <th name="umpire_stadistics" width="120" class="table_header">Umpire</th>
    <th name="umpire_stadistics" width="120" class="table_header">Rating</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Catcher</th>  
    <th name="pitcher_stadistics"  width="120"  class="table_header"> GB %</th>  
    <th name="pitcher_stadistics" width="120" class="table_header">Era</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Catcher</th> 
    <th  name="pitcher_stadistics"  width="120"  class="table_header"> GB %</th>       
    <th name="pitcher_stadistics" width="120" class="table_header">Era</th> 
    <th  name="ten_stadistics" width="120" class="table_header" align="center">+10 A</th>  
    <th  name="ten_stadistics" width="120" class="table_header" align="center">+10 H</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY A</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">MONEY H</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total OVER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total O JUICE</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total UNDER</th>  
    <th name="lines_stadistics" width="120" class="table_header" align="center">Total U JUICE</th> 
    <th name="game_stadistics" width="120" class="table_header" align="center">HOMERUNS</th> 
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS A</th>  
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS H</th>
    <th name="game_stadistics" width="120" class="table_header" align="center">RUNS T</th>   
    <th name="game_stadistics" width="120" class="table_header" align="center">SCORE</th>
    <th width="120" class="table_header" align="center">Espn Info</th>
           
  </tr>
 </thead> 
 <tbody>
<?

 foreach($games as $game){
   
  if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
   $ump_id = 0;
   $ump_value = 0;
   $fangraphs_team_away = get_baseball_team($game->vars["team_away"]);
   $fangraphs_team_home = get_baseball_team($game->vars["team_home"]);
   $players_team_away = get_all_baseball_player_by_team($fangraphs_team_away->vars["fangraphs_team"],$year);
   $players_team_home = get_all_baseball_player_by_team($fangraphs_team_home->vars["fangraphs_team"],$year);
   $day= date('M-d',strtotime($game->vars["startdate"]));
	 $hour= date('H:i',strtotime($game->vars["startdate"]));
	 $Hh =  date('H',strtotime($game->vars["startdate"]));
	 $date = date('Y-m-d',strtotime($game->vars["startdate"]));
	
	 //Pitcher FaceOff
    $faceoff_away = get_pitcher_faceoff_team($game->vars["team_home"],$game->vars["pitcher_away"],$date);
	  $faceoff_home = get_pitcher_faceoff_team($game->vars["team_away"],$game->vars["pitcher_home"],$date);

		
	if ($i==1){
	 $lines_game = get_sport_lines($date,'MLB','Game',true);
	 $lines_innings = get_sport_lines($date,'MLB','1st 5 Innings',true);	
	}
	
	//Weather formulas
	$weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	$stadium_away = get_baseball_stadium_by_team($game->vars["team_away"]);	
	$stadium_position = $stadium->get_baseball_stadium_wind_position($weather->vars["wind_direction"]);
	
	if (!$game->vars["manual_wind"]){
	  $adjustment_factors = get_adjustment_factors($stadium_position['id']);  
	}
	else{
      $adjustment_factors = get_adjustment_factors($game->vars["manual_wind"]);  	
	}
	  
	if (!is_null($weather->vars["temp"])){
  	
	// pk
	 $pk=$game->get_pk($weather,$stadium,$adjustment_factors,$constants);
    }else { $pk = "0";}
	
	// Air Density
 	 
	 $temp_kelvin=$game->get_kelvin_temp($weather->vars["temp"]);
     $air_density = $game->get_air_density($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$temp_kelvin);
	 $dewpoint_celsius = $game->get_celsius_temp($weather->vars["dewpoint"]);
	 $water_vapour = $game->get_water_vapour($dewpoint_celsius);
	 $moist_air_density = $game->get_moist_air_density ($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$water_vapour, $temp_kelvin);
	 //$aird = $game->get_aird ($game->get_kelvin_temp($weather->vars["temp"]),$weather->vars["air_pressure"],$water_vapour);
	
	  $weather_style = "";
	  $orweather_style = "";
	  $pkweather_style = "";
	  if ($pk <= -15 && $game->vars["roof_open"]) {$pkweather_style = "_red";}
	  else if ($pk >= 15 && $game->vars["roof_open"]) {$pkweather_style = "_green";}
	  $orweather_style = $weather_style;
	  
	  if ($weather->vars["wind_direction"] == 'Variable' ){$weather_style = "_gray";} 
	  
	  if ($stadium->vars["has_roof"] == 2 || !$game->vars["roof_open"]) {$weather_style = "_gray";} 
	  
	  //Yesterday Game
	   $yesterday = date ('Y-m-d',strtotime ( '-1 day' , strtotime ( $game->vars["startdate"]))) ;
       $firstbase=get_baseball_firstbase($game->vars["team_away"],$game->vars["team_home"],$yesterday);
	    echo "<pre>";
		//print_r($firstbase);
		echo "</pre>";
	   $firstbase_name = get_umpire_name_by_id($firstbase["firstbase"]);
	   $yesterday_data = $firstbase;
		  
	  ?> 
     <tr  id="game_<? echo $game->vars["id"] ?>">
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day ?></td>
      
       <?
	   if (!$game->vars["espn_game"]){
	   ?>
          <td class="table_td<? echo $style ?>_red" style="font-size:12px;">
	   <a href="<?= BASE_URL ?>/ck/baseball_file/game_hour_fix.php?gid=<? echo $game->vars["id"]?>" class="normal_link" rel="shadowbox;height=270;width=300"><? echo $hour ?></a>
            </td>
	   <? 
      }
      else { 
     
       if ($game->vars["postponed"]){ ?>
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $hour ?><strong> (Postponed)</strong></td>           
		  <? }else
		 {
		 ?>
         <td name ="game_info_" class="table_td<? echo $style ?>" style="font-size:12px; 
         <? if($stadium->vars["time"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["time"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($Hh >= 19 ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($Hh < 19 ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
         
         "><? echo $hour ?></td> 
         <? }
          }?>
          
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?><BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_away']?></span>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_phones.php?sid=<? echo $stadium->vars["id"]?>" class="normal_link" rel="shadowbox;height=700;width=630"><? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?></a>
        <BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_home']?></span>
      </td>
      
           
      <? // To control the PK avg excluding games with roof closed
       $roof = true;
	    if ($stadium->vars["has_roof"] == 1) { 
	       if (!$game->vars["roof_open"]){ $roof = false;} 
	    }
	   if ($stadium->vars["has_roof"] == 2) { $roof = false; }
	  ?>

       <td name="stadium_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; 
        <? if ($stadium->vars["has_roof"] ==1) { ?>
	   
	   <? if($stadium->vars["roof"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["roof_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($stadium->vars["roof"] == $game->vars["roof_open"] ) { echo ' background-color:'.$w_color.'; '; } 
	      } ?>
       <? } ?>
      " align="table_td<? echo $style.$orweather_style ?>" id="r<? echo $game->vars["id"]?>" >
		   <? if ($stadium->vars["has_roof"] ==1) { ?>
           		<? if(!$game->started()){ ?>
                   <select name="roof" id="<? echo $game->vars["id"]?>" onChange="change_roof_status(<? echo $game->vars["id"]?>,this.value)" >
                   <option value="1">Open</option>
                   <option value="0" <? if(!$game->vars["roof_open"]){ ?>selected="selected"<? } ?>>Close</option>
                   </select>
               <? }else{echo $game->get_roof_comparison();} ?>
          <? }else if ($stadium->vars["has_roof"] ==2) { ?>
          		<strong>Always Closed</strong>
          <? }else{ ?>
          		No Roof
          <? } ?>
      </td>
  <?    
   //stadium stadistics
     $stadium_stadistics = get_baseball_stadium_stadistics($stadium->vars['id'],$game->vars['id']);  
   ?>
    
 
     
 <? //weather  ?>    
   
           
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px; 
      <? if($stadium->vars["temp_cond"] != -1 && $game->vars["roof_open"] ) { 
	        $cond = explode("_",$stadium->vars["temp_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["temp"] <= $weather->vars["temp"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["temp"] > $weather->vars["temp"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo 'background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>"
      
      
      id="t<? echo $game->vars["id"]?>"><? echo $weather->vars["temp"] ?></td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" align="center" id="i<? echo $game->vars["id"]?>" >
      	<img src="<? echo $weather->vars["img_url"] ?>"><br />
      	<? echo $weather->vars["condition"] ?><br /><br /><a  target="_blank" title="Click to open an Hourly Forecast" href="http://www.weather.com/weather/hourbyhour/l/<? echo $stadium->vars["zip_code"]?>" >Hourly Forecast</a>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
      <? if($stadium->vars["humidity_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["humidity_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["humidity"] <= $weather->vars["humidity"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["humidity"] > $weather->vars["humidity"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>"
      id="h<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["humidity"] ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px; 
	  <? if($stadium->vars["wind_speed_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["wind_speed_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["wind_speed"] <= $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["wind_speed"] > $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>"
      id="ws<? echo $game->vars["id"]?>"><? echo $weather->vars["wind_speed"] ?>
      </td> 
         
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?> hoverTable" style="font-size:12px;<?
      
	   if ($weather->vars["wind_direction"] == $stadium->vars['wind_runs'] ||$weather->vars["wind_direction"] == $stadium->vars['wind_homeruns'] ){
		// echo ' background: green; ';  
		 }
	  ?>" align="center" id="wd<? echo $game->vars["id"]?>">
      
          <? /*<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_wind_data.php?st=<? echo $stadium->vars["team_id"] ?>&wd=<? echo $weather->vars["wind_direction"] ?>" target="_blank" > */ ?>
		  <img src="images/s<? echo $stadium->vars["id"] ?>.jpg" width="98" height="98" />
          <? /* </a>  */ ?>
		  
		  <style>
			.box2{
				position: fixed;
				display: none;
				width: auto;
				height: auto;
				background-color: #ffffff;
				padding: 7px;
				z-index: 1500;
				left: 40%;
				top: 15%;
				box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-o-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-ms-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-moz-box-shadow: 0 0 12px rgba(0,0,0,0.4);
				-webkit-box-shadow: 0 0 12px rgba(0,0,0,0.4);
			
			}
			
			.hoverTable:hover .box2{
				display: block;
			}
		  </style>
		  
		 <div class="box2">
		 <iframe src="<?= BASE_URL ?>/ck/baseball_file/stadium_wind_data.php?st=<? echo $stadium->vars["team_id"] ?>&wd=<? echo $weather->vars["wind_direction"]  ?>" width = "300px" height = "475px"></iframe>
		 </div>
       
        <br />
      <? if ($game->vars["manual_wind"]==0 || $game->vars["manual_wind"] == $stadium_position['id'] ){ ?>
        <div class="wind_direction_image" style="
         <? if($stadium->vars["wind_direction_green"] != "" && $game->vars["roof_open"]) { 
	         
			   $g_wind = explode(",",$stadium->vars["wind_direction_green"]);
			 if (in_array($weather->vars["wind_direction"],$g_wind)) { echo ' background-color:#9F6; '; } 
		    }
			if($stadium->vars["wind_direction_red"] != "" && $game->vars["roof_open"]) { 
			   $r_wind = explode(",",$stadium->vars["wind_direction_red"]);
			    if (in_array($weather->vars["wind_direction"],$r_wind)) { echo ' background-color:#F30; '; } 
			   
			}
		     
	        ?>"
        
        > <img src="images/<? echo $weather->vars["wind_direction"] ?>.png" width="98" height="98" /></div>
       
         <? echo $weather->vars["wind_direction"] ; /* if (in_array($weather->vars["wind_direction"],$g_wind)) { echo '  Ok  '; }  */ ?>
        
         <? }
         else{
			echo "Position was Manual Selected";
		 }?>
        

     </td> 
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wp<? echo $game->vars["id"]?>">
	 	<? //display_div  <? echo $stadium_position["position"]
		$selected_position = $stadium_position['id']; 
		if ($game->vars["manual_wind"]){
			 
			 $selected_position = $game->vars["manual_wind"]; ?>
           <strong>Original:</strong> <? echo $stadium_position["position"] ?><BR/> 
		   <strong>Selected:</strong>
           <? if (!$game->started()){ ?>
           <a href="javascript:display_div('manual_position'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to change the position" ><? echo $manual_wind[$game->vars["manual_wind"]]->vars["position"] ?></a> 
           <? } 
           else{ echo $manual_wind[$game->vars["manual_wind"]]->vars["position"]; } ?>    
           
		<? }
		else{ ?>
		  <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_position'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to open options to change the position" ><? echo $stadium_position["position"] ?></a> 	
          <? } 
           else{ echo $stadium_position["position"]; } ?>    
          
          
		<? } ?>
		<div id="manual_position<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("stadium_position", "stadium_position", $manual_wind, "id", "position", $default_name = "",$selected_position,"change_wind_position(".$game->vars['id'].",this.value)","_baseball_stadium_position");  ?>
        </div>
       </td>
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["wind_gust_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["wind_gust_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) {  
			
			    if($stadium->vars["wind_gust"] <= $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["wind_gust"] > $weather->vars["wind_speed"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>
       " id="wg<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["wind_gust"]?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["air_pressure_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["air_pressure_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["air_pressure"] <= $weather->vars["air_pressure"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["air_pressure"] > $weather->vars["air_pressure"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>
       " id="ai<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["air_pressure"]?>
       </td>
     
       <td name="weather_stadistics"  class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
         <? if($stadium->vars["dew_point_cond"] != -1 && $game->vars["roof_open"]) { 
	       	$cond = explode("_",$stadium->vars["dew_point_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["dew_point"] <= $weather->vars["dewpoint"] ) { echo ' background-color:'.$w_color.'; '; }
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 } 
	        } else {
				
			   if($stadium->vars["dew_point"] > $weather->vars["dewpoint"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>" id="dw<? echo $game->vars["id"]?>">
	 	<a class="normal_link"><? echo $weather->vars["dewpoint"] ?></a>
        <div class="box">
          <BR><BR>
          <table>
            <tr >
              <td class="table_header"><strong>Avg Dwpnt</strong></td>
               <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_dewpoint"]?></td>
            </tr> 
            <tr >
              <td class="table_header"><strong>Avg R</strong></td>
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_runs"]?></td>
              </tr>
              <tr >
              
              <td class="table_header"><strong>Avg HR</strong></td>
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["avg_homeruns"]?></td>
             </tr>
             <tr > 
              <td class="table_header"><strong>Games</strong></td>  
              <td class="table_header"><? echo $stadiums_dewpoint[$stadium->vars["team_id"]]->vars["games"]?></td>                                           
             </tr>
  
          </table>
        </div>
       </td> 
       
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["dry_air_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["dry_air_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["dry_air"] <= $air_density ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["dry_air"] > $air_density ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?>
       " id="air_d<? echo $game->vars["id"]?>">
	 	<? echo $air_density ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
        <? if($stadium->vars["vapor_pressure_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["vapor_pressure_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) {  
			
			    if($stadium->vars["vapor_pressure"] <= $water_vapour ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["vapor_pressure"] > $water_vapour ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }	
			}
			
	      } ?> 
       " id="wat_v<? echo $game->vars["id"]?>">
	 	<? echo $water_vapour ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
       <? if($stadium->vars["moist_air_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["moist_air_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			
			    if($stadium->vars["moist_air"] <= $moist_air_density ) { echo ' background-color:'.$w_color.'; '; } 
				else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["moist_air"] > $moist_air_density ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
       " id="air_m<? echo $game->vars["id"]?>">
	 	<? echo $moist_air_density ?>
       </td> 
       <? 
	   if ($roof) {	$pk_total = $pk_total + $pk; $game_count++; }
		
	   ?>
       <td name="weather_stadistics" class="table_td<? echo $style.$pkweather_style ?>" style="font-size:12px;" id="pk<? echo $game->vars["id"]?>">
	 	<? echo $pk ?>
       </td>
        
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;
       <?  $w_color = "";
	     if($stadium->vars["aird_cond"] != -1 && $game->vars["roof_open"]) { 
	        $cond = explode("_",$stadium->vars["aird_cond"]);
			if($cond[1]== 'g'){ $w_color = "#9F6"; } else { $w_color = "#F30";}
			if($cond[0]) { 
			   
			    if($stadium->vars["aird"] <= $weather->vars["aird"] ) { echo ' background-color:'.$w_color.'; '; } 
				else { $test .= "B"; if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
	        } else {
				
			   if($stadium->vars["aird"] > $weather->vars["aird"] ) { echo ' background-color:'.$w_color.'; '; } 
			   else { if($w_color == $green_color) { $w_color = $red_color; } else { $w_color = $green_color;}
				   echo ' background-color:'.$w_color.'; ';
				 }
			}
			
	      } ?>  
       " id="aird_<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["aird"]; ?>
       </td> 
       <?  
	     $data_stadium = "";
	     $data_stadium = @stadium_data_formula($pk,$weather->vars["air_pressure"],$std_formula[$stadium->vars["id"]]);
	   ?>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["pk"] ?>
       </td>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["airp"] ?>
       </td>
        <td name="weather_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" id="std<? echo $game->vars["id"]?>">
	 	<? echo $data_stadium["total"] ?>
       </td>
       
   
   <?

/* Moved Up
    $yesterday = date ('Y-m-d',strtotime ( '-1 day' , strtotime ( $game->vars["startdate"]))) ;
    $firstbase=get_baseball_firstbase($game->vars["team_away"],$game->vars["team_home"],$yesterday);
	$firstbase_name = get_umpire_name_by_id($firstbase["firstbase"]); */
 $ump_rating = "";
	if ($game->vars["umpire"]){
	     $umpire_statistics = get_umpire_stadistics($game->vars["umpire"],$year);
	     $umpire = $umpire_statistics[$year]->vars["full_name"];
        $ump_rating = $umpires[$game->vars["umpire"]]->vars["rating"];
	     
		 if ($firstbase["firstbase"]){
		  $umpire = $game->get_firstbase_comparison($firstbase["firstbase"]);
		 }
		 if($game->started()){     
           $umpire = $game->get_umpire_comparison();	
           ?><td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire  ?></td><?
	      }
	      else{
		 ?> 
         <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire   ?><BR>
          <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "",$game->vars["umpire"],"change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
         </td>
         <? } ?>  		  
	     <? 
	  
	  }
	  else{
	     if ($firstbase_name["full_name"]){
		  $umpire = " FB: ".$firstbase_name["full_name"] .""; 
          $umpire_statistics = get_umpire_stadistics($firstbase["firstbase"],$year);
		   ?>
		  <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
		  <? echo $umpire   ?><BR>
          <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "",$firstbase["firstbase"],"change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
          </td>   
		  <?
           
		
		    }
            else{
           	   
		      $umpire = "N/A";
              ?>
		      <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
		      <? create_objects_list("umpire", "umpire", $umpires, "id", "umpire", $default_name = "","","change_manual_umpire(".$game->vars['id'].",this.value)","_baseball_umpire"); ?>
		 	 <BR><? echo $umpire   ?></td>   
		     <?  
	       
            }
	    } ?>
        <?
		$ump_id = $game->vars["umpire"];
		$ump_value = $ump_data[$ump_id]["weighted_avg"];
   
		 // If there is not data for UMP. the value used is 2.35 According to Mike.
		if ($game->vars["umpire"] && $ump_data[$game->vars["umpire"]]["weighted_avg"] == 0 ){
		  $ump_value = 2.35;
		  
		}
		if ((!$game->vars["umpire"]) && ($firstbase["firstbase"]) ){
		   $ump_id = $firstbase["firstbase"];	
		   $ump_value = $ump_data[$ump_id]["weighted_avg"];
       $ump_rating = $umpires[$ump_id]->vars["rating"];
		   if ($ump_data[$ump_id]["weighted_avg"] == 0 ){
		    $ump_value = 2.35;
		   }
		
		}
		if ($game->vars["real_umpire"]){
			$ump_id = $game->vars["real_umpire"];	
		   $ump_value = $ump_data[$ump_id]["weighted_avg"];
        $ump_rating = $umpires[$ump_id]->vars["rating"];
		   if ($ump_data[$ump_id]["weighted_avg"] == 0 ){
		    $ump_value = 2.35;
		   }
		
		
		}
		
         
		?>
        
        
         <? $ump_weighted_total = $ump_weighted_total + $ump_value;
  		if ($ump_data[$ump_id]["weighted_avg"] < $column_desc["weig_avg"]["description"]) { $color = "#0C3"; }
			   else { $color = "#F00"; } 
		 
		 ?>
		<td  name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px; "><? echo $ump_rating ?></td>  

    
  


     <? //Player
   
   if (!$game->vars["pitcher_home"]){
    $fix = true;
   }
      $ta_catcher = 0;
      $th_catcher = 0;    
     if ($game->vars["pitcher_away"]){
    
    //$player_a= get_player_data_stadistics
    
    $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
    //print_r($player_a);
      $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);  
    $pitches_count_a = get_baseball_player_highest_pitches($game->vars["pitcher_away"]);
    $pitches_count_h = get_baseball_player_highest_pitches($game->vars["pitcher_home"]);    
    $stadistics_a = get_player_basic_stadistics($game->vars["pitcher_away"],$year,true,$game->vars["id"]);        if (is_null($stadistics_a)) { $stadistics_a = new _baseball_player_stadistics_by_game();}                  
        $stadistics_h = get_player_basic_stadistics($game->vars["pitcher_home"],$year,true,$game->vars["id"]);         if (is_null($stadistics_h)) { $stadistics_h = new _baseball_player_stadistics_by_game();}         
      $player_name_a = $player_a->vars["player"];
      $player_name_b =  $player_h->vars["player"];
    $catcher_a = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_home"]);
    //print_r($player_a);
      $catcher_h = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_away"]); 
    $catcher_name_a =  $catcher_a->vars["player"];
      $catcher_name_b =  $catcher_h->vars["player"];
    $ta_catcher = $pa_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"] + $ph_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"];
    $th_catcher = $pa_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"] + $ph_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"];
    
      }
      else{
      $fix = true;
    $player_name_a = "";
      $player_name_b = "";
      $stadistics_a = array();
        $stadistics_h = array();
      } 


      if($fix && $game->vars["postponed"]) { $fix = false;}

      ?>
     
   <td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["away"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="pitcher_a_<? echo $game->vars["id"]?>">
   
    <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_pitcher_away'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to change manually the pitcher" ><strong><? echo $player_name_a ?></strong></a> 
         	
          <? } 
           else{ echo "<strong>".$player_name_a."</strong>"; 
		   
		   
		   }?> 
		   <BR>
           <? if ($player_name_a != "" ){ ?>
           <a href="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_a->vars["espn_player"] ?>&name=<? echo $player_name_a ?>&img=<? echo $player_a->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_home->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_home->vars["team_name"]  ?>">Info</a><div class="box"><iframe src="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_a->vars["espn_player"] ?>&name=<? echo $player_name_a ?>&img=<? echo $player_a->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_home->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_home->vars["team_name"]  ?>" width = "550px" height = "500px"></iframe></div>
		   <? } ?>
		      
   
     <div id="manual_pitcher_away<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("pitcher_manual", "pitcher_manual", $players_team_away , "fangraphs_player", "espn_nick", $default_name = "",$game->vars["pitcher_away"],"change_manual_pitcher(".$game->vars['id'].",this.value,'away')","_baseball_player");  ?>
    </div>
    <? if ($last_game[$game->vars["pitcher_away"]]["location"] == "away" && $last_game[$game->vars["pitcher_away"]]["team"] == "58" ) { ?>
    <br>
    <div align="center" style="background-color:#396">  
    <span title="Last Game was played on Colorado">Colorado</span> 
    </div>
   <? } ?>
   
   <? if ($last_game[$game->vars["pitcher_away"]]["game_note"] != "" ) { ?>
    <br>
    <div style="background-color:#FC9">  
     <a href="javascript:display_div('note_pitcher_away'+<? echo $game->vars["id"]?>)" class="normal_link" title="<? echo $last_game[$game->vars["pitcher_away"]]["game_note"] ?>" ><strong>Last Game Note</strong></a> 
    </div>
   <? } ?>
   
    <div id="note_pitcher_away<? echo $game->vars["id"]?>" style="display:none">	 
	 <span style="font-size:9px"><BR>	
        <? echo $last_game[$game->vars["pitcher_away"]]["game_note"] ?> 
        <br>
        <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $last_game[$game->vars["pitcher_away"]]["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
    </span>
    </div>
  <BR><BR> 
    <?
	 if (trim($player_a->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: right; margin-top: -40px;" >  
    </a>
    <div class="box"><strong>VS OPS</strong>
   <? echo $team_speed[$game->vars["team_home"]]->vars["ops"] ?></strong>(<span style=""><? echo $team_speed[$game->vars["team_home"]]->vars["rank_ops"] ?>/30</span>)
     </div>
    <? }?>
  <BR><BR>
      <? if (count($faceoff_away)>0) {?>
      <a href="" target="_blank" >
         <strong>#10</strong>
          </a>
<div class="box">
   <?
     foreach ($faceoff_away as $fa){?>
     <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $fa["espn_game"] ?>" class="normal_link" target="_blank"> Last Game</a>
	<?	
	  }
    ?>
 </div>
 <? }?>
    
   </td>   
 <?
 $last_game_color = "";
 $last_3game_color = "";
  if ($stadistics_a->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_a->vars['sum_last_games'] >= 330){
  $last_3game_color = "background-color: #6C9";
 }
?>  
    <td name="pitcher_stadistics" title="Catcher <? echo $game->vars["away"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="catcher_a_<? echo $game->vars["id"]?>">   <? if ($catcher_name_a != -1 ){ 
       echo $catcher_name_a;     
	   if ($ta_catcher > 0) { echo " (".$ta_catcher.")"; }
     } ?>
    </td> 
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;">
     <table>
       <tr>
         <td  title="GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['gb'] ?></td>
       </tr>
       <tr>
        <td title="Total GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_total_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['gb_total'] ?></td>
       </tr>
      </table>
    </td> 
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['era']?></td>
   	<td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["home"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;"  id="pitcher_b_<? echo $game->vars["id"]?>">
    
     <? if (!$game->started()){ ?> 
          <a href="javascript:display_div('manual_pitcher_home'+<? echo $game->vars["id"]?>)" class="normal_link" title="Click to change manually the pitcher" ><strong><? echo $player_name_b ?></strong></a> 	
          <? } 
           else{ echo "<strong>".$player_name_b."</strong>"; } ?> 
       
    <? if ($player_name_b != "" ){ ?>        
   <BR><a href="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_h->vars["espn_player"] ?>&name=<? echo $player_name_b ?>&img=<? echo $player_h->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_away->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_away->vars["team_name"]  ?>">Info</a><div class="box"><iframe src="<?= BASE_URL ?>/ck/baseball_file/player_fantasy_data.php?player=<? echo $player_h->vars["espn_player"] ?>&name=<? echo $player_name_b ?>&img=<? echo $player_h->vars["image"] ?>&std=<? echo $stadium->vars["id"]?>&std_name=<? echo $stadium->vars["name"] ?>&vs=<? echo $fangraphs_team_away->vars["espn_team"]  ?>&vs_name=<? echo $fangraphs_team_away->vars["team_name"]  ?>" width = "550px" height = "500px"></iframe></div>
   <? } ?>
   
     <div id="manual_pitcher_home<? echo $game->vars["id"]?>" style="display:none">	 
		<? create_objects_list("pitcher_manual", "pitcher_manual", $players_team_home , "fangraphs_player", "espn_nick", $default_name = "",$game->vars["pitcher_home"],"change_manual_pitcher(".$game->vars['id'].",this.value,'home')","_baseball_player");  ?>
    </div>
    
     <? if ($last_game[$game->vars["pitcher_home"]]["location"] == "away" && $last_game[$game->vars["pitcher_home"]]["team"] == "58" ) { ?>
    <br>
    <div align="center" style="background-color:#396">  
    <span title="Last Game was played on Colorado">Colorado</span> 
    </div>
   <? } ?>
    
     <? if ($last_game[$game->vars["pitcher_home"]]["game_note"] != "" ) { ?>
    <br>
    <div style="background-color:#FC9">  
     <a href="javascript:display_div('note_pitcher_home'+<? echo $game->vars["id"]?>)" class="normal_link" title="<? echo $last_game[$game->vars["pitcher_home"]]["game_note"] ?>" ><strong>Last Game Note</strong></a> 
    </div>
   <? } ?>
   
    <div id="note_pitcher_home<? echo $game->vars["id"]?>" style="display:none">	 
		<span style="font-size:9px"><BR>
        <? echo $last_game[$game->vars["pitcher_home"]]["game_note"] ?> 
        
        <br>
        <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $last_game[$game->vars["pitcher_home"]]["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
</span>
    </div>
     <BR><BR> 
    <?
	 if (trim($player_h->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: right; margin-top: -40px;" >  
    </a>
    <div class="box"><strong>VS OPS</strong>
   <? echo $team_speed[$game->vars["team_away"]]->vars["ops"] ?></strong>(<span style=""><? echo $team_speed[$game->vars["team_away"]]->vars["rank_ops"] ?>/30</span>)
     </div>
    <? }?>
    
    <BR><BR>
      <? if (count($faceoff_away)>0) {?>
      <a href="" target="_blank" >
         <strong>#10</strong>
          </a>
  <div class="box">
   <?
     foreach ($faceoff_away as $fa){?>
     <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $fa["espn_game"] ?>" class="normal_link" target="_blank"> Last Game</a>
	<?	
	  }
    ?>
 </div>
 <? }?>
    
    
  </td> 
<?
 $last_game_color = "";
 $last_3game_color = "";
  if ($stadistics_h->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_h->vars['sum_last_games'] >= 330){
  $last_3game_color = "background-color: #6C9";
 }
?>   
 <td name="pitcher_stadistics" title="Catcher <? echo $game->vars["home"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="catcher_h_<? echo $game->vars["id"]?>">
  <? if ($catcher_name_b != -1 ){ 
       echo $catcher_name_b; 
	   if ($th_catcher > 0) { echo " (".$ta_catcher.")"; }    
     } ?></td> 
   <td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;">
    <table>
      <tr>
        <td  title="GroundBalls"  class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['gb'] ?></td>
       </tr>
         <tr>
        <td title="Total GroundBalls" class="table_td<? echo $style ?>" style="font-size:12px;" id="gb_total_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['gb_total'] ?></td>
       </tr>
     </table>  
     </td> 
 <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['era']?></td> 
    
	   
  
  <?  // ten

 $ten_aa = get_baseball_scores_ten($game->vars["team_away"],"away",$date);
 $ten_ah = get_baseball_scores_ten($game->vars["team_away"],"home",$date);
 $ten_ha = get_baseball_scores_ten($game->vars["team_home"],"away",$date);
 $ten_hh = get_baseball_scores_ten($game->vars["team_home"],"home",$date);
  
 if ($ten_aa["lose_ten"] == "YES" || $ten_ah["lose_ten"] == "YES"){
   $ten_away = "Yes"	;
 }
 else{
   $ten_away = "No"	;	  
 }
	 
 if ($ten_ha["lose_ten"] == "YES" || $ten_hh["lose_ten"] == "YES"){
  $ten_home = "Yes"	;
 }
 else{
  $ten_home = "No"	;	  
 }	  
 
 ?>
    

      
 <td name="ten_stadistics" title="Team lose +10"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_a_<? echo $game->vars["id"]?>"><? echo $ten_away ?></td>    
 <td name="ten_stadistics" title="Team lose +10" class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_h_<? echo $game->vars["id"]?>"><? echo  $ten_home  ?></td>    
          
 
  
      <td name="lines_stadistics" title="Money Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_a_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["away_money"] ?></td>  
      
       <td name="lines_stadistics" title="Money Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_h_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["home_money"] ?></td>  

     <?
	    $over_game =  prepare_line($lines_game[$game->vars["away_rotation"]]->vars["away_total"]);
		$under_game = prepare_line($lines_game[$game->vars["away_rotation"]]->vars["home_total"]);  
	 ?>
     
      <td name="lines_stadistics" title="Total Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_a_<? echo $game->vars["id"]?>"><?   echo $over_game["line"] ?>
       </td> 
      
       <td name="lines_stadistics" title="Total Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_o_<? echo $game->vars["id"]?>"><? echo $over_game["juice"] ?></td> 
     
      <td name="lines_stadistics" title="Total Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="under_<? echo $game->vars["id"]?>" ><? echo $under_game["line"] ?></td> 
      
             <td name="lines_stadistics" title="Total Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_u_<? echo $game->vars["id"]?>"><? echo  $under_game["juice"] ?></td> 
             
   
 

       <td name="game_stadistics" title="Total of HomeRuns'"  class="table_td<? echo $style ?>" style="font-size:12px;" id="t_h_<? echo $game->vars["id"]?>">
       <? if (($game->vars["homeruns_away"] + $game->vars["homeruns_home"])>=0) { 
        	   echo  ($game->vars["homeruns_away"] + $game->vars["homeruns_home"]); 
	   } else{
		   echo "0";
	   }
	   ?>
       
       </td>      
 
    
     <td  name="game_stadistics" title="Runs Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_a_<? echo $game->vars["id"]?>"><? echo  $game->vars["runs_away"] ?></td>  
     
     <td  name="game_stadistics" title="Runs Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_h_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_home"] ?></td>  
     
     <td name="game_stadistics" title="Game Runs" class="table_td<? echo $style ?>" style="font-size:12px;" id="game_runs_<? echo $game->vars["id"]?>"><? echo  ($game->vars["runs_away"] + $game->vars["runs_home"]) ?></td>  
     
     <td name="game_stadistics" title="Final Score" class="table_td<? echo $style ?>" style="font-size:12px;" id="score_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_away"]." - ".$game->vars["runs_home"]?>  </td>  
      
     
      
      

<td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>"><a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars["espn_game"] ?>" class="normal_link" target="_blank"> Espn Box Score
</a>
</td>   
     
</tr>  

<? } ?>
   
 <tr>
  <td class="table_last" colspan="1000"></td>
  </tr>
  </tbody>
</table>
<div id="bottom_anchor"></div>
</div>
   <? if (count($games)>6) { ?>
  <BR>
   &nbsp;&nbsp;&nbsp; 
   <a href="javascript:;" onclick="move_scroll('up');" title="Go Up"><img src="images/arrow_up.png" width="20px" onclick="move_scroll('up');"  id="up1"  title="Go Up" /></a>
    <a href="javascript:;" onclick="move_scroll('down');" title="Go Down"><img src="images/arrow_down.png" width="20px" onclick="move_scroll('down');"  /></a>
   <? } ?>



 <? if ($fix){ ?>
	 <script>
	fix_changes();
	 </script> 
<? } ?>
<?
if (count($games) != 0){
	if (date("Y-m-d") == $from) {
		$grand_salami = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_mlb_grandSalami.php?date=".$from));
		$salami_over = "o".$grand_salami->TotalOver." ".$grand_salami->OverOdds;
		$salami_under = "u".$grand_salami->TotalUnder." ".$grand_salami->UnderOdds;
		if($game_count > 0){
     $pk_avg = number_format($pk_total/$game_count,2);
    }
		
		
		if($ump_weighted_total) {
		 $ump_avg = number_format($ump_weighted_total/count($games),2);
		} else {$ump_avg = 0;}
	  
	}else {
		$stat = get_baseball_stats($from);
		$salami_over = $stat->vars["grand_salami_over"];
		$salami_under = $stat->vars["grand_salami_under"];
		$pk_avg = $stat->vars["pk_avg"];
		$ump_avg = $stat->vars["ump_weighted_avg"];
	}
	
	
	?>
	
	<BR><BR>
	<span><strong>Baseball Stats</strong></span>
	<BR>
	<table  width="300px" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="120"  class="table_header" align="center" >Grand Salami</td>
				<td width="120"  class="table_header" align="center" >PK AVG</td>
				<td width="120"  class="table_header" align="center" >UMP W. AVG</td>
				
			  </tr>  
			  <tr>
			   <td class="table_td1" style="font-size:12px;">
			   <table align="center">
			   <tr>
				<td><? echo $salami_over ?></td>
			   </tr>
			   <tr>
				<td><? echo $salami_under ?></td>
			   </tr>
			   </table>
			   
			   </td> 
			   <td class="table_td1" style="font-size:12px;" align="center"><? echo $pk_avg ?></td> 
			  <td class="table_td1" style="font-size:12px;" align="center"><? echo $ump_avg	?></td>      
			  </tr>
	</table>
<? } else { ?>
    <BR><BR>
	<span><strong>No games for Today</strong></span>
    <? }?>

</div>



<?php /*?><script src="../includes/js/jquery-1.8.3.min.js"></script> <?php */?> 
 

<script type="text/javascript" src="../includes/js/jquery.freezeheader.js"></script>
  <script>

$(document).ready(function () {

$("#baseball").freezeHeader({ 'height': '780px' });

})





</script>
  
</script>  

 <script type="text/javascript">
		
		function move_scroll(side){
			
			var step = 350;
			var thediv = document.getElementById('hdScrollbaseball');
			//document.getElementById("up").style.display = "block";
			
			if(side == 'up'){
				$("#hdScrollbaseball").animate({scrollTop: thediv.scrollTop - step},  'fast');
			}else{
			
				$("#hdScrollbaseball").animate({scrollTop: thediv.scrollTop + step}, 'fast')
			}
		}
		
		
 </script>


 <script>
   $( function() {
     $( ".draggable" ).draggable();
   } );
 </script>

 <script>

     $(document).ready(function(){
      var wrapper1 = document.getElementById('wrapper1');
      var myhtml = document.getElementById('myhtml');
      wrapper1.onscroll = function() {
        myhtml.scrollLeft = wrapper1.scrollLeft;
      };

      myhtml.onscroll = function() { alert(2);
        wrapper1.scrollLeft = myhtml.scrollLeft;
      };
     });

 </script>
        
</body>
<? //aca si nece modificar le estyle de eso,,,le pasa info a la variable $site_style --siga..?>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>
