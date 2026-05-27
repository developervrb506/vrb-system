<?php

class _image_customize{
  
  
 var $headlines = array();

/*
  var $max_base_width  = 340; // ancho de la imagen base
  var $max_base_heigth = 400; // Alto de la imagen base
  var $max_prd_width  = 320;  // Maximo ancho de la imagen producto, si éste execede el sistema va escalar la imagen
  var $max_prd_heigth = 300;  // Maximo alto de la imagen producto, si éste execede el sistema va escalar la imagen
  var $max_logo_width  = 50;  // Maximo ancho de la imagen logo , si éste execede el sistema va escalar la imagen
  var $max_logo_heigth = 50;  // Maximo alto de la imagen logo, si éste execede el sistema va escalar la imagen
  var $imgCheck;      // Variable que contiene imagen GD para revision de extension y tamaño
*/
  var $imgMain;       // Variable que contiene imagen GD para la base con el texto
  var $imgTeamAway;   // Variable que contiene imagen GD con el producto
  var $imgPlayerAway;   // Variable que contiene imagen GD con el producto
  var $imgTeamHome;   // Variable que contiene imagen GD con el producto
  var $imgLogo;       // Variable que contiene imagen GD con el logo
  var $imgVs;       // Variable que contiene imagen GD con el logo
  var $imgEspn;       // Variable que contiene imagen GD con el logo
  var $imgbetNow;       // Variable que contiene imagen GD con el logo
  var $imgResult;     // Variable que contiene imagen GD con un el producto y el texto
  var $imgFinal;      //  Variable que contiene imagen GD con un el producto , el texto y logo.
  var $fsize = 20;   // Tamaño de la letra SKU
  var $ffile = "../font/JosefinSans-Bold.ttf"; // Font usada para la letra de SKU
  var $mainpath = BASE_URL . '/ck/headlines/';
  var $control = false;

   function __construct(){
    $this->headlines[0]['max_base_heigth'] = 600;
    $this->headlines[0]['max_base_width'] = 1920;
    $this->headlines[0]['path'] = 'sbo';
   }


  function image_base($data){
   
   foreach ($this->headlines as $hd) {

     //$this->imgMain =  imagecreate($hd['max_base_width'],$hd['max_base_heigth']);   
     $this->imgMain =    @imagecreatetruecolor($hd['max_base_width'],$hd['max_base_heigth']) // you want to create a truecolorimage here
    or die("Cannot Initialize new GD image stream");
     
     $bg_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del Fondo
     //$txt_color = imagecolorallocate($this->imgMain,0,0,0); // Numeros son RBG del color de texto
     // imagettftext($this->imgMain,$this->fsize, 0,($hd['max_base_width']-180),($hd['max_base_heigth']-50),$txt_color,$this->ffile,$time);
     //imagestring($this->imgMain, 5, ($this->max_base_width-175),($this->max_base_heigth-45), $text2, $txt_color);
     //imagejpeg($this->imgMain, '../images/'.$hd['path'].'/base.jpeg');
     //unlink( '../images/'.$hd['path'].'/base2.png');
  
     //imagepng($this->imgMain, 'images/'.$hd['path'].'/base2.png'); exit;

     
     $this->control = false;  
     $aplayer = explode('_',$data['player_away']);
     $hplayer = explode('_',$data['player_home']);
     $data['player_away'] = $aplayer[0];
     $data['player_away_type'] = $aplayer[1];
     $data['player_home'] = $hplayer[0];
     $data['player_home_type'] = $hplayer[1];
  

     
     $img_away = $this->mainpath.'images/teams/'.$data['league'].'/'.$data['away'].'.jpg';
     $img_home = $this->mainpath.'images/teams/'.$data['league'].'/'.$data['home'].'.jpg';
     $img_away_player = $this->mainpath.'images/Players/'.$data['league'].'/'.$data['player_away'].'.png';
     $img_home_player = $this->mainpath.'images/Players/'.$data['league'].'/'.$data['player_home'].'.png';
     if (getimagesize($img_away) && getimagesize($img_home)) {
        $this->control = true;  
     } else {
       $this->control = false;  
     }

     if($this->control){
   
      //PREPARE AWAY TEAM
      $this->imgTeamAway = imagecreatefromjpeg($img_away);
      $imgTeamAWidth  = imagesx($this->imgTeamAway);
      $imgTeamAHeight = imagesy($this->imgTeamAway) ;
     // imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, $imgTeamAHeight, $imgTeamAWidth, $imgTeamAHeight);
      imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, 700, $imgTeamAWidth, $imgTeamAHeight);



      //PREPARE HOME TEAM 
      $this->imgTeamHome = imagecreatefromjpeg($img_home);
      $imgTeamHWidth  = imagesx($this->imgTeamHome);
      $imgTeamHHeight = imagesy($this->imgTeamHome);
      $pos = $imgTeamAWidth + $imgTeamHWidth;
      //imagecopyresampled($this->imgMain, $this->imgTeamHome, $pos, 0, 0, 0, $imgTeamHWidth, $imgTeamHHeight, $imgTeamHWidth, $imgTeamHHeight);
      imagecopyresampled($this->imgMain, $this->imgTeamHome, $pos, 0, 0, 0, $imgTeamHWidth, 700, $imgTeamHWidth, $imgTeamHHeight);
      

       //PREPARE AWAY PLAYER
        $this->imgPlayerAway =  imagecreatefrompng($img_away_player);
        if($data['player_away_type'] != 'a'){
         imageflip($this->imgPlayerAway, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerAWidth  = imagesx($this->imgPlayerAway);
        $imgPlayerAHeight = imagesy($this->imgPlayerAway);
        $pos =  $imgTeamAWidth + ($imgTeamAWidth/2) - $imgPlayerAWidth/2;
        imagecopyresampled($this->imgMain, $this->imgPlayerAway, $pos, 60, 0, 0, $imgPlayerAWidth, $imgPlayerAHeight, $imgPlayerAWidth, $imgPlayerAHeight);
    




       //PREPARE HOME PLAYER
        $this->imgPlayerHome =  imagecreatefrompng($img_home_player);
        if($data['player_home_type'] != 'h'){
         imageflip($this->imgPlayerHome, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerHWidth  = imagesx($this->imgPlayerHome);
        $imgPlayerHHeight = imagesy($this->imgPlayerHome);
        //$pos =  $imgTeamHWidth *3 - $imgPlayerHWidth ;
         $pos =  $imgTeamAWidth * 2 + ($imgTeamHWidth/2) - $imgPlayerHWidth/2;
        imagecopyresampled($this->imgMain, $this->imgPlayerHome, $pos, 60, 0, 0, $imgPlayerHWidth, $imgPlayerHHeight, $imgPlayerHWidth, $imgPlayerHHeight);
    

      

       
      //PREPARE LOGO
       $img_logo = $this->mainpath.'images/Logos/bet_'.strtolower($data['league']).'.png';
       $this->imgLogo = imagecreatefrompng($img_logo); 
       $imgLogoWidth  = imagesx($this->imgLogo);
       $imgLogoHeight = imagesy($this->imgLogo);
       $realSpaceWidth = ($imgTeamAWidth - $imgLogoWidth) / 2 ;
       $realSpaceHeigth = ($imgTeamAHeight - $imgLogoHeight) / 3 ;
       imagecopyresampled($this->imgMain, $this->imgLogo, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgLogoWidth, $imgLogoHeight, $imgLogoWidth, $imgLogoHeight);
       

       // ADDING DATE TIME
       $realSpaceWidth = ($imgTeamAWidth   ) + (strlen($data['date']) /2 ) - strlen($data['date']) ; //strlen($data['date']) * 2; //($imgTeamAWidth ) - 50);
     
      // $realSpaceWidth= ((imagesx($imgTeamAWidth)/2)-(strlen($data['date'])));

       //Get the center of a the text
       $box = imagettfbbox(30, 0, $this->ffile, $data['date']);
       $txt_w = $box[4] - $box[0];
       $x = ($imgTeamAWidth - $txt_w) /2;
       
       $boxh = imagettfbbox(20, 0, $this->ffile, $data['hour']);
       $txt_wh = $boxh[4] - $boxh[0];
       $xh = ($imgTeamAWidth - $txt_wh) /2;
     
      // $x = $bbox[0] + (imagesx($imgTeamAWidth) / 2) - ($bbox[4] / 2) - 25;
       //$y = $bbox[1] + (imagesy($imgTeamAWidth) / 2) - ($bbox[5] / 2) - 5;

       $txt_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del color de texto
       //imagettftext($this->imgMain,30,0, $realSpaceWidth,($realSpaceHeigth+$imgLogoHeight+40),$txt_color,$this->ffile,$data['date']);
       imagettftext($this->imgMain,30,0, $x,($realSpaceHeigth+$imgLogoHeight+40),$txt_color,$this->ffile,$data['date']);
       $realSpaceWidth = $imgTeamAWidth / 2 ;
       imagettftext($this->imgMain,20,0, $xh ,($realSpaceHeigth+$imgLogoHeight+80),$txt_color,$this->ffile,$data['hour']);


       
       //PREPARE TV IMG
       $img_espn = $this->mainpath.'images/Logos/'.$data['tv'].'.png';
       $this->imgEspn= imagecreatefrompng($img_espn); 
       $imgEspnWidth  = imagesx($this->imgEspn);
       $imgEspnHeight = imagesy($this->imgEspn);
       $realSpaceWidth = (($imgTeamAWidth - $imgEspnWidth) / 2) ;
       $realSpaceHeigth = ($imgTeamAHeight - ($imgEspnHeight*2))  ;
       //imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);
       imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth,$realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);

       //PREPARE VS IMG
       $img_vs = $this->mainpath.'images/Logos/vs_'.rand(1,3).'.png';
       $this->imgVs= imagecreatefrompng($img_vs); 
       $imgVsWidth  = imagesx($this->imgVs);
       $imgVsHeight = imagesy($this->imgVs);
       //$realSpaceWidth = ((($pos) - $imgVsWidth) / 2)+ $imgTeamAWidth;
      // $realSpaceWidth =   ($imgTeamAWidth * 1)- ( $imgVsWidth*2);
       $realSpaceWidth =   ($imgTeamAWidth *2) - ($imgVsWidth/2);
       $realSpaceHeigth = ($imgTeamAHeight - $imgVsHeight) / 2 ;
       imagecopyresampled($this->imgMain, $this->imgVs, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgVsWidth, $imgVsHeight, $imgVsWidth, $imgVsHeight);


         //PREPARE BETNOW IMG
       $img_bet = $this->mainpath.'images/Logos/bet-now.png';
       $this->imgBet= imagecreatefrompng($img_bet); 
       $imgBetWidth  = imagesx($this->imgBet);
       $imgBetHeight = imagesy($this->imgBet);
       //$realSpaceWidth = ((($pos) - $imgVsWidth) / 2)+ $imgTeamAWidth;
      // $realSpaceWidth =   ($imgTeamAWidth * 1)- ( $imgVsWidth*2);
       $realSpaceWidth =   ($imgTeamAWidth *2) - ($imgBetWidth/2);
       $realSpaceHeigth = ($imgTeamAHeight - $imgBetHeight) ;
       imagecopyresampled($this->imgMain, $this->imgBet, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgBetWidth, $imgBetHeight, $imgBetWidth, $imgBetHeight);


       
       

       //CREATE IMAGES   
       imagejpeg($this->imgMain, '../images/'.$hd['path'].'/sbo.jpg');
      // imagepng($this->imgMain, '../images/'.$hd['path'].'/base2.png');
     
     

     } else {
       echo 'DOES NOT EXIST TEAM IMG';
     }

   }
   //$this->imgMain = imagecreate($this->max_base_width,$this->max_base_heigth);
  // imagettftext($this->imgMain,$this->fsize, 0,($this->max_base_width-180),($this->max_base_heigth-50),$txt_color,$this->ffile,$text1);
   //imagestring($this->imgMain, 5, ($this->max_base_width-175),($this->max_base_heigth-45), $text2, $txt_color);
   //imagepng($this->imgMain, 'temp/base.png');

   

  }


  function image_destroy(){

     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgCheck);
     @imagedestroy($this->imgMain);
     @imagedestroy($this->imgProducto);
     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgFinal);
     @imagedestroy($this->imgLogo);

  } 

} 

 

?>