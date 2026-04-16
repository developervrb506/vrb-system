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

  td .message {
  margin-top: 4px;
  font-size: 12px;
  min-height: 16px; /* para que el td no salte */
}


td form.pickForm {
  display: flex;
  flex-direction: column;
  align-items: center; /* centra el contenido horizontal */
  gap: 6px;            /* espacio entre selects y el botón */
  padding: 8px;
}

td form.pickForm select {
  width: 80%;         /* que no se vea tan pegado al borde */
  padding: 4px;
  font-size: 13px;
}

td form.pickForm button {
  padding: 4px 8px;
  font-size: 13px;
  cursor: pointer;
}

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

.table_base {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  font-size: 13px;
}

.table_base th {
  background-color: #0d1a2d;
  color: white;
  font-weight: bold;
  padding: 8px;
  border: 1px solid #ccc;
  text-align: center;
}

.table_base td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
  vertical-align: middle;
}

.table_base tr:nth-child(even) {
  background-color: #f9f9f9;
}

.table_base tr:hover {
  background-color: #f1f1f1;
}

.logo-round {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 1px solid #ccc;
  object-fit: cover;
}

</style>
<? 

//patch
// replace strstr for myStrstrTrue

$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$year = date('Y',strtotime($from));
$date=  date('Y-m-d',strtotime($from));
$imgdate=  date('Ymd',strtotime($from));
$games = get_baseball_games_by_date($from);
$season =  get_baseball_season($year);
$pk_total = 0;
$game_count = 0;
$ump_weighted_total = 0;
$ump_data = get_all_umpire_data();
//$column_desc = get_all_baseball_column_description();
//$day_bets = get_baseball_bets($from);
$team_speed = get_all_baseball_team_speed($from,"team");
$stadiums_dewpoint = get_all_stadium_dewpoint_avg();
$stadiums_parkfactor_season = get_baseball_stadium_parkfactor_season_data($year);
$green_color = "#9F6"; 
$red_color = "#F30";
$year = date("Y");

//$pa_catchers =  get_baseball_pitchers_vs_catchers("a",($year-1)."-01-01");
//$ph_catchers =  get_baseball_pitchers_vs_catchers("h",($year-1)."-01-01");

//print_r($ph_catchers);

//Stadium Formula Data;
$std_formula = get_all_stadium_formula_data();
  
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





///
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
    left: 340px;
    top: 200px;
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
<? $page_style = " width:1500px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>
<? //SCROLL HORIZONTAL NO ES NECESARIO 
/*
<div id="wrapper1" class="draggable" style="display: inline-block; margin-left: 10px;">
    <div id="div1"></div>
</div>
*/?>

<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><BR><BR>




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

<iframe id="changer" width="1" height="1" scrolling="no" frameborder="0"></iframe>

<?
//$umpires = get_all_umpires();

$bets = get_baseball_game_bet_by_date($from);
$umpires = get_all_baseball_umpires("id");
$manual_wind = get_all_baseball_stadium_position();
$constants = get_baseball_constants();
//$constants = get_baseball_constants();
$fix = false;
?>
<div id="container" class='table-container'>
<table  id="baseball" name="baseball" width="<? echo $table_width ?>" border="0" cellspacing="0" cellpadding="0">
 <thead>
  <tr >
 
    <th width="120"  class="table_header" >Date</th>
       <th  name ="game_info_" width="120" class="table_header">Away
    <th width="120" class="table_header">Home</th>            
    <th name="weather_stadistics" width="120" class="table_header">Weather</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">Condition</th>
    <th name="weather_stadistics" width="120" class="table_header" align="center">WD</th>
    <th name="umpire_stadistics" width="120" class="table_header">Umpire</th>
    
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher Away</th>
   
    <th name="pitcher_stadistics" width="120" class="table_header">Pitcher Home</th>
    <th name="pitcher_stadistics" width="120" class="table_header">Expert Pick</th>
    <th name="pitcher_stadistics" width="120" class="table_header">AI Pick</th>

    
    <th width="120" class="table_header" align="center">Info</th>
           
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
  //  $faceoff_away = get_pitcher_faceoff_team($game->vars["team_home"],$game->vars["pitcher_away"],$date);
//	  $faceoff_home = get_pitcher_faceoff_team($game->vars["team_away"],$game->vars["pitcher_home"],$date);

		
//	if ($i==1){
//	 $lines_game = get_sport_lines($date,'MLB','Game',true);
//	 $lines_innings = get_sport_lines($date,'MLB','1st 5 Innings',true);	
//	}
	
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
 	 
	 //$temp_kelvin=$game->get_kelvin_temp($weather->vars["temp"]);
     //$air_density = $game->get_air_density($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$temp_kelvin);
	 $dewpoint_celsius = $game->get_celsius_temp($weather->vars["dewpoint"]);
	 //$water_vapour = $game->get_water_vapour($dewpoint_celsius);
	 //$moist_air_density = $game->get_moist_air_density ($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$water_vapour, $temp_kelvin);
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
      //$firstbase=get_baseball_firstbase($game->vars["team_away"],$game->vars["team_home"],$yesterday);
	   // echo "<pre>";
		//print_r($firstbase);
		//echo "</pre>";
	  // $firstbase_name = get_umpire_name_by_id($firstbase["firstbase"]);
	  // $yesterday_data = $firstbase;
		  
	  ?> 
     <tr  id="game_<? echo $game->vars["id"] ?>">
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day ?>
           <input name="idGame" type="hidden" id="idGame" value="<? echo $game->vars["id"] ?>" />
        <?
       if (!$game->vars["espn_game"]){
       ?>
        
       <a href="<?= BASE_URL ?>/ck/baseball_file/game_hour_fix.php?gid=<? echo $game->vars["id"]?>" class="normal_link" rel="shadowbox;height=270;width=300"><? echo $hour ?></a>
        
       <? 
      }
      else { 
     
       if ($game->vars["postponed"]){ ?>
            <? echo $hour ?><strong> (Postponed)
          <? }else
         {
         ?>
         <? echo $hour ?>
         <? }
          }?>         



     </td>
      
      

   <td id="game_info_<?php echo $game->vars['id'] ?>" class="table_td<?php echo $style ?>" style="font-size:12px; text-align:center; padding:10px;">
  <!-- Nombre del equipo y número -->
  <div style="font-weight:bold; text-transform:uppercase; margin-bottom:5px;">
    <?php echo strtoupper($game->vars['away']) . ' <BR> ' . $game->vars['away_rotation']; ?>
  </div>

  <!-- Logo redondo -->
  <div style="margin-bottom:5px;">
    <img 
      src="https://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/<?php echo $imgdate; ?>/<?php echo $game->vars['away_rotation']; ?>.jpg" 
      alt="Away Logo"
      style="width:60px; height:60px; border-radius:50%; border:1px solid #ccc;"
    >
  </div>

  <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">ERA</th>
      <th style="border:1px solid #ccc; padding:4px;">LEFTY</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['era_away'];?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['lefty_away'];?></td>
    </tr>
  </table>
<BR>
   <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">BB Last 3 Avg </th>
      <th style="border:1px solid #ccc; padding:4px;">BB Last 5 Avg</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['away_last3_avg'];?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['away_last5_avg'];?></td>
    </tr>
  </table>


  
</td>

<!-- Ahora el mismo para el HOME -->
<td id="game_info_<?php echo $game->vars['id'] ?>" class="table_td<?php echo $style ?>" style="font-size:12px; text-align:center; padding:10px;">
  <!-- Nombre del equipo y número -->
  <div style="font-weight:bold; text-transform:uppercase; margin-bottom:5px;">
    <a href="<?= BASE_URL ?>/ck/baseball_file/stadium_phones.php?sid=<?php echo $stadium->vars['id']; ?>" 
       class="normal_link" rel="shadowbox;height=700;width=630" style="color:#000;">
      <?php echo strtoupper($game->vars['home']) . ' <BR> ' . $game->vars['home_rotation']; ?>
    </a>
  </div>

  <!-- Logo redondo -->
  <div style="margin-bottom:5px;">
    <img 
      src="https://www.sportsbettingonline.ag/engine/sbo/images/live_team_logos/<?php echo $imgdate; ?>/<? echo $game->vars['home_rotation']; ?>.jpg" 
      alt="Home Logo"
      style="width:60px; height:60px; border-radius:50%; border:1px solid #ccc;"
    >
  </div>

  <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">ERA</th>
      <th style="border:1px solid #ccc; padding:4px;">LEFTY</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['era_home'];?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['lefty_home'];?></td>
    </tr>
  </table>
  <BR>
     <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">BB Last 3 Avg </th>
      <th style="border:1px solid #ccc; padding:4px;">BB Last 5 Avg</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['home_last3_avg'];?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['home_last5_avg'];?></td>
    </tr>
  </table>



</td>




       <? /*   
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?><BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_away']?></span>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_phones.php?sid=<? echo $stadium->vars["id"]?>" class="normal_link" rel="shadowbox;height=700;width=630"><? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?></a>
        <BR><BR>
        <span style="font-size: 14px;" title="Yesterday's Score"><strong>Y Scr :</strong> <? echo $yesterday_data['runs_home']?></span>
      </td>
      */?>
           
      <? // To control the PK avg excluding games with roof closed
       $roof = true;
	    if ($stadium->vars["has_roof"] == 1) { 
	       if (!$game->vars["roof_open"]){ $roof = false;} 
	    }
	   if ($stadium->vars["has_roof"] == 2) { $roof = false; }
	  ?>

     
  <?    
   //stadium stadistics
     $stadium_stadistics = get_baseball_stadium_stadistics($stadium->vars['id'],$game->vars['id']);  
   ?>
    
 
     
 <? //weather  ?>   

 <td class="weather-cell table_td<? echo $style.$weather_style ?>" style="font-size:12px; text-align:left; padding:10px; line-height:1.8; min-width:160px;">
  <div style="font-size:11px; margin-bottom:4px;"><strong>TEMP: </strong><? echo $weather->vars["temp"] ?>°F</div>
  <div style="font-size:11px; margin-bottom:4px;"><strong>HUMIDITY: </strong><? echo $weather->vars["humidity"] ?>%</div>
  <div style="font-size:11px; margin-bottom:4px;"><strong>WIND SPEED: </strong><? echo $weather->vars["wind_speed"] ?> mph</div>
  <div style="font-size:11px; margin-bottom:4px;"><strong>WIND POSITION: </strong><? echo $stadium_position["position"];?></div>
  <div style="font-size:11px; margin-bottom:4px;"><strong>DEW POINT: </strong> <a class="normal_link"><? echo $weather->vars["dewpoint"] ?>°F</a>
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
        </div><br>
  </div>
  <div style="font-size:11px;"><strong>PK: </strong><? echo $pk ?></div>
</td>



           
            
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" align="center" id="i<? echo $game->vars["id"]?>" >
      	<img src="<? echo $weather->vars["img_url"] ?>"><br />
      	<? echo $weather->vars["condition"] ?><br /><br /><a  target="_blank" title="Click to open an Hourly Forecast" href="http://www.weather.com/weather/hourbyhour/l/<? echo $stadium->vars["zip_code"]?>" >Hourly Forecast</a>
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
     
      
     
      <? $umpire = $umpires[$game->vars['umpire']]->vars['espn_name']; ?>

<td class="umpire-td table_td<? echo $style ?>" style="font-size:12px; text-align:center; padding:10px;">
  <? if( $umpire != "" ) { ?>
  <div style="font-weight:bold; text-transform:uppercase;"><? echo $umpire  ?></div>
  
  <div style="margin:5px 0;">
    Rating: <? echo $umpires[$game->vars['umpire']]->vars['rating'] ?><br>
    Games: <? echo $game->vars['games'];?>
  </div>
  <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">K%</th>
      <th style="border:1px solid #ccc; padding:4px;">BB%</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['k_pct'];?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['bb_pct'];?></td>
    </tr>
  </table>
 <? } else { ?>
<div style="font-weight:bold; text-transform:uppercase; color: red;">PENDING</div>
<? } ?> 
</td>

	

    
  


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
  //  $pitches_count_a = get_baseball_player_highest_pitches($game->vars["pitcher_away"]);
   // $pitches_count_h = get_baseball_player_highest_pitches($game->vars["pitcher_home"]);    
    //$stadistics_a = get_player_basic_stadistics($game->vars["pitcher_away"],$year,true,$game->vars["id"]);        if (is_null($stadistics_a)) { $stadistics_a = new _baseball_player_stadistics_by_game();}                  
        $stadistics_h = get_player_basic_stadistics($game->vars["pitcher_home"],$year,true,$game->vars["id"]);         if (is_null($stadistics_h)) { $stadistics_h = new _baseball_player_stadistics_by_game();}         
      $player_name_a = $player_a->vars["player"];
      $player_name_b =  $player_h->vars["player"];
    //$catcher_a = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_home"]);
    //print_r($player_a);
      //$catcher_h = get_baseball_player_by_id("fangraphs_player",$game->vars["catcher_away"]); 
    //$catcher_name_a =  $catcher_a->vars["player"];
     // $catcher_name_b =  $catcher_h->vars["player"];
    //$//ta_catcher = $pa_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"] + $ph_catchers[$game->vars["pitcher_away"]."_".$game->vars["catcher_home"]]["total"];
    //$th_catcher = $pa_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"] + $ph_catchers[$game->vars["pitcher_home"]."_".$game->vars["catcher_away"]]["total"];
    
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


       <td  name="pitcher_stadistics" title="Pitcher <? echo $game->vars["away"]  ?>" id="pitcher_a_<? echo $game->vars["id"]?>" class="table_td<?php echo $style ?>" style="font-size:12px; text-align:center; padding:10px;">
  <!-- Nombre del equipo y número -->
  <div style="font-weight:bold; text-transform:uppercase; margin-bottom:5px;">
    <?php echo strtoupper($player_name_a); ?>
  </div>



  <!-- Logo redondo -->
  <div style="margin-bottom:5px;">
    <img 
      src="https://a.espncdn.com/combiner/i?img=/i/headshots/mlb/players/full/<?php echo $player_a->vars["espn_player"] ?>.png" alt="Pitcher Away" style="width:60px; height:60px; border-radius:50%; border:1px solid #ccc;" >
  </div>
  <?
  if (trim($player_a->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: left; margin-top: -40px;" >  
    </a>
<? } ?>

  <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">ERA</th>
      <th style="border:1px solid #ccc; padding:4px;">WHIP</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['p_away_era_avg']?> </td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['p_away_whip_avg']?></td>
    </tr>
     <tr>
      <td colspan="2" style="border:1px solid #ccc; padding:4px;">ERA AWAY: </td>
      </tr>
  </table>


  
</td>


<td  name="pitcher_stadistics" title="Pitcher <? echo $game->vars["home"]  ?>" id="pitcher_h_<? echo $game->vars["id"]?>" class="table_td<?php echo $style ?>" style="font-size:12px; text-align:center; padding:10px;">
  <!-- Nombre del equipo y número -->
  <div style="font-weight:bold; text-transform:uppercase; margin-bottom:5px;">
    <?php echo strtoupper($player_name_b); ?>
  </div>



  <!-- Logo redondo -->
  <div style="margin-bottom:5px;">
    <img 
      src="https://a.espncdn.com/combiner/i?img=/i/headshots/mlb/players/full/<?php echo $player_h->vars["espn_player"] ?>.png" alt="Pitcher Away" style="width:60px; height:60px; border-radius:50%; border:1px solid #ccc;" >
  </div>
  <?
  if (trim($player_h->vars["throws"])== "L") {?>
    <a><img src="images/left_pitcher.png" title="LeftHander" style="width: 12px; float: left; margin-top: -40px;" >  
    </a>
<? } ?>

  <!-- Estadísticas -->
   <table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
      <th style="border:1px solid #ccc; padding:4px;">ERA</th>
      <th style="border:1px solid #ccc; padding:4px;">WHIP</th>
    </tr>
    <tr>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['p_home_era_avg']?></td>
      <td style="border:1px solid #ccc; padding:4px;"><? echo $game->vars['p_home_whip_avg']?></td>
    </tr>

    <tr>
      <td colspan="2" style="border:1px solid #ccc; padding:4px;">ERA HOME: </td>
      </tr>
  </table>


  
</td>
  
 

   <td   class="table_td<? echo $style ?> expert-pick" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>">
  <form action="./process/actions/change_bet.php" class="pickForm" data-action="ex" data-game="<? echo $game->vars['id']?>" data-date="<? echo $from ?>">
      <select class="typeSelect" name="type">
        <option value="">--Select Type--</option>
        <option value="Spread">Spread</option>
        <option value="Money">Money</option>
        <option value="Total">Total</option>
      </select>
      <div class="dynamicFields"></div>
      <input type="hidden" name="ac" value="ex">
      <button type="submit">Save</button>
    </form>
     <div class="message"></div>
</td> 

   <td   class="table_td<? echo $style ?> ai-pick" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>">
      <form  action="./process/actions/change_bet.php" class="pickForm" data-action="ai" data-game="<? echo $game->vars['id']?>" data-date="<? echo $from ?>"  >
      <select class="typeSelect" name="type">
        <option value="">--Select Type--</option>
        <option value="Spread">Spread</option>
        <option value="Money">Money</option>
        <option value="Total">Total</option>
      </select>
      <div class="dynamicFields"></div>
      <input type="hidden" name="ac" value="ai">
      <button type="submit">Save</button>
    </form>
     <div class="message"></div>
   
</td>    

     
      
      

<td class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"] ?>">
    <? if (isset($bets[$game->vars['id']])) { ?>
        <a href="#" class="normal_link show-bets" data-game="<? echo $game->vars['id'] ?>">Bets</a><br><br>
    <? } ?> 

    <a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars['espn_game'] ?>" 
       class="normal_link" 
       target="_blank">Espn Box Score</a>
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


</div>


<div id="betsPopup" style="display:none; width:250px; position:absolute; background:white; border:1px solid #ccc; padding:10px; font-size:12px; z-index:1000;"></div>

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



document.querySelectorAll('.pickForm').forEach(form => {
  const typeSelect = form.querySelector('.typeSelect');
  const container = form.querySelector('.dynamicFields');

  typeSelect.addEventListener('change', function() {
    const type = this.value;
    container.innerHTML = ''; // Limpia el div antes

    if (type === "Spread") {
      // Team select
      const team = document.createElement('select');
      team.name = 'team';
      team.innerHTML = `<option value="AWAY">AWAY</option>
                        <option value="HOME">HOME</option>`;
      container.appendChild(team);

      // Spread range
      const spread = document.createElement('select');
      spread.name = 'spreadRange';
      for (let i = 2.5; i >= -2.5; i -= 0.5) {
        let val = (i > 0 ? "+" : "") + i.toFixed(1);
        spread.innerHTML += `<option value="${val}">${val}</option>`;
      }
      container.appendChild(spread);
    }

    if (type === "Money") {
      const team = document.createElement('select');
      team.name = 'team';
      team.innerHTML = `<option value="AWAY">AWAY</option>
                        <option value="HOME">HOME</option>`;
      container.appendChild(team);
    }

    if (type === "Total") {
      const overUnder = document.createElement('select');
  overUnder.name = 'overUnder';
  overUnder.innerHTML = `<option value="OVER">OVER</option>
                          <option value="UNDER">UNDER</option>`;
  container.appendChild(overUnder);

  const totalRange = document.createElement('select');
  totalRange.name = 'totalRange';
  for (let i = 5; i <= 12; i += 0.5) {
    totalRange.innerHTML += `<option value="${i.toFixed(1)}">${i.toFixed(1)}</option>`;
  }
  container.appendChild(totalRange);
    }
  //});
//});

   // Captura el submit
    form.addEventListener('submit', function(e) {
      e.preventDefault(); // evita que recargue

         const formData = new FormData(form);

        // agregar manualmente los data- attributes
        formData.append('game', form.dataset.game);
        formData.append('date', form.dataset.date);

   
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      console.log("Datos que se van a enviar:", data);

      // ENVÍA por fetch
      fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(text => {
        console.log("Respuesta del servidor:", text);

         // Mostrar mensaje en el div debajo del form
    const msgDiv = form.parentElement.querySelector('.message');
    msgDiv.innerText = "✅ Bet saved successfully";
    msgDiv.style.color = "green";

    // Borrar después de 4 segundos
    setTimeout(() => {
      msgDiv.innerText = "";
    }, 4000);



      })
      .catch(err => console.error("Error enviando:", err));
    });
    //
  });
});

/*
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
*/

document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('betsPopup');
    let hideTimeout;

    document.querySelectorAll('.show-bets').forEach(link => {
        link.addEventListener('mouseenter', function () {
            const gameId = this.dataset.game;

            fetch('show_bets.php?id=' + gameId)
                .then(response => response.text())
                .then(data => {
                    popup.innerHTML = data;
                    popup.style.display = 'block';

                    // Obtener posición del enlace
                    const rect = this.getBoundingClientRect();
                    const popupWidth = 250; // Ajusta según el tamaño real del popup
                    const spaceRight = window.innerWidth - rect.right;
                    const spaceLeft = rect.left;

                    let left;

                    if (spaceRight > popupWidth + 20) {
                        // Suficiente espacio a la derecha
                        left = rect.right + 10;
                    } else if (spaceLeft > popupWidth + 20) {
                        // Mostrar a la izquierda
                        left = rect.left - popupWidth - 10;
                    } else {
                        // Centrado debajo si no hay espacio a los lados
                        left = rect.left;
                    }

                    popup.style.left = left + window.scrollX + 'px';
                    popup.style.top = rect.top + window.scrollY + 20 + 'px';
                });
        });

        link.addEventListener('mouseleave', function () {
            hideTimeout = setTimeout(() => {
                popup.style.display = 'none';
            }, 200);
        });
    });

    popup.addEventListener('mouseenter', function () {
        clearTimeout(hideTimeout);
    });

    popup.addEventListener('mouseleave', function () {
        popup.style.display = 'none';
    });
});
</script>


        
</body>
<? //aca si nece modificar le estyle de eso,,,le pasa info a la variable $site_style --siga..?>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>
