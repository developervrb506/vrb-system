<?php

class _image_customize_mobile{
  
  
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
  var $mainpath = 'http://localhost:8080/ck/headlines/';
  var $control = false;

   function __construct(){
    $this->headlines[0]['max_base_heigth'] = 913;
    $this->headlines[0]['max_base_width'] = 800;
    $this->headlines[0]['path'] = 'sbo';
   }


  function image_base($data){
   
   foreach ($this->headlines as $hd) {

 
      $this->imgMain =    @imagecreatetruecolor($hd['max_base_width'],$hd['max_base_heigth']) // you want to create a truecolorimage here
    or die("Cannot Initialize new GD image stream");
     
     $bg_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del Fondo
     unlink( '../images/'.$hd['path'].'/mobile.png');
  
          
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
      $this->imgTeamAway = imagescale($this->imgTeamAway,400, 457);
        $imgTeamAWidth  = imagesx($this->imgTeamAway) ;
      $imgTeamAHeight = imagesy($this->imgTeamAway)  ;

      imagecopyresampled($this->imgMain, $this->imgTeamAway, 0, 0, 0, 0, $imgTeamAWidth, $imgTeamAHeight, $imgTeamAWidth, $imgTeamAHeight);
     // imagecopyresampled($this->imgMain, $this->imgTeamAway, $imgTeamAWidth, 0, 0, 0, $imgTeamAWidth, $imgTeamAHeight, $imgTeamAWidth, $imgTeamAHeight);
     // imagecopyresampled($this->imgMain, $this->imgTeamAway, 20, 400,400, 100, 800, 300, 400, 200);



      //PREPARE HOME TEAM 
      $this->imgTeamHome = imagecreatefromjpeg($img_home);
      $this->imgTeamHome = imagescale($this->imgTeamHome,400, 457);
      $imgTeamHWidth  = imagesx($this->imgTeamHome);
      $imgTeamHHeight = imagesy($this->imgTeamHome);
      $pos = $imgTeamAWidth;
      imagecopyresampled($this->imgMain, $this->imgTeamHome, $pos, 0, 0, 0, $imgTeamHWidth, $imgTeamAHeight, $imgTeamHWidth, $imgTeamHHeight);
      

       //PREPARE AWAY PLAYER
        $this->imgPlayerAway =  imagecreatefrompng($img_away_player);
         $this->imgPlayerAway = imagescale($this->imgPlayerAway,250, 200);
        if($data['player_away_type'] != 'a'){
         imageflip($this->imgPlayerAway, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerAWidth  = imagesx($this->imgPlayerAway);
        $imgPlayerAHeight = imagesy($this->imgPlayerAway);
        $pos =  $imgTeamAWidth/2 - $imgPlayerAWidth/2;
        imagecopyresampled($this->imgMain, $this->imgPlayerAway, $pos, 60, 0, 0, $imgPlayerAWidth, $imgPlayerAHeight, $imgPlayerAWidth, $imgPlayerAHeight);
    




       //PREPARE HOME PLAYER
        $this->imgPlayerHome =  imagecreatefrompng($img_home_player);
       $this->imgPlayerHome = imagescale($this->imgPlayerHome,250, 200);
        if($data['player_home_type'] != 'h'){
         imageflip($this->imgPlayerHome, IMG_FLIP_HORIZONTAL);
        }
        $imgPlayerHWidth  = imagesx($this->imgPlayerHome);
        $imgPlayerHHeight = imagesy($this->imgPlayerHome);
        //$pos =  $imgTeamHWidth *3 - $imgPlayerHWidth ;
         $pos =  $pos + $imgTeamAWidth;
        imagecopyresampled($this->imgMain, $this->imgPlayerHome, $pos, 60, 0, 0, $imgPlayerHWidth, $imgPlayerHHeight, $imgPlayerHWidth, $imgPlayerHHeight);
    

      

       
      //PREPARE LOGO
       $img_logo = $this->mainpath.'images/Logos/bet_'.strtolower($data['league']).'.png';
       $this->imgLogo = imagecreatefrompng($img_logo); 
       $imgLogoWidth  = imagesx($this->imgLogo);
       $imgLogoHeight = imagesy($this->imgLogo);
       $realSpaceWidth = $imgTeamAWidth - ($imgLogoWidth /2 )  ;
       $realSpaceHeigth = ($imgTeamAHeight +20 ) ;
       imagecopyresampled($this->imgMain, $this->imgLogo, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgLogoWidth, $imgLogoHeight, $imgLogoWidth, $imgLogoHeight);
     
       // ADDING DATE TIME

       $box = imagettfbbox(30, 0, $this->ffile, $data['date']);
       $txt_w = $box[4] - $box[0];
       $x = (800 - $txt_w) /2;

       $boxh = imagettfbbox(20, 0, $this->ffile, $data['hour']);
       $txt_wh = $boxh[4] - $boxh[0];
       $xh = (800 - $txt_wh) /2;

       $txt_color = imagecolorallocate($this->imgMain,255,255,255); // Numeros son RBG del color de texto
       imagettftext($this->imgMain,30,0, $x,($realSpaceHeigth+$imgLogoHeight+40),$txt_color,$this->ffile,$data['date']);
       $realSpaceWidth = $imgTeamAWidth / 2 ;
       imagettftext($this->imgMain,20,0, $xh ,($realSpaceHeigth+$imgLogoHeight+80),$txt_color,$this->ffile,$data['hour']);


     ///**** VOY POR ACA
        //PREPARE TV IMG
       $img_espn = $this->mainpath.'images/Logos/'.$data['tv'].'.png';
       $this->imgEspn= imagecreatefrompng($img_espn); 
       $imgEspnWidth  = imagesx($this->imgEspn);
       $imgEspnHeight = imagesy($this->imgEspn);
       $realSpaceWidth = (($imgTeamAWidth - $imgEspnWidth /2 ) ) ;
       $realSpaceHeigth = ($imgTeamAHeight * 2 ) - ($imgEspnHeight ) - ($imgEspnHeight/2);
       //imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);
       imagecopyresampled($this->imgMain, $this->imgEspn, $realSpaceWidth,$realSpaceHeigth, 0, 0, $imgEspnWidth, $imgEspnHeight, $imgEspnWidth, $imgEspnHeight);
/*
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
*/

         //PREPARE BETNOW IMG
       /*
       $img_bet = $this->mainpath.'images/Logos/bet-now.png';
       $this->imgBet= imagecreatefrompng($img_bet); 
       $imgBetWidth  = imagesx($this->imgBet);
       $imgBetHeight = imagesy($this->imgBet);
       //$realSpaceWidth = ((($pos) - $imgVsWidth) / 2)+ $imgTeamAWidth;
      // $realSpaceWidth =   ($imgTeamAWidth * 1)- ( $imgVsWidth*2);
       $realSpaceWidth =   ($imgTeamAWidth *2) - ($imgBetWidth/2);
       $realSpaceHeigth = ($imgTeamAHeight - $imgBetHeight) ;
       imagecopyresampled($this->imgMain, $this->imgBet, $realSpaceWidth, $realSpaceHeigth, 0, 0, $imgBetWidth, $imgBetHeight, $imgBetWidth, $imgBetHeight);
      */

       
       

       //CREATE IMAGES   
       imagejpeg($this->imgMain, '../images/'.$hd['path'].'/mobile.jpg');
       imagepng($this->imgMain, '../images/'.$hd['path'].'/mobile.png');
     
     

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
/*
 function image_teams($type,$img){

   
    if($type == 'away'){
      $this->imgResult = imagecreatetruecolor($imgMainWidth, $imgMainHeight);
   //   imagecopyresampled($this->imgResult,  $this->imgMain, 0, 0, 0, 0, $imgMainWidth, $imgMainHeight, $imgMainWidth, $imgMainHeight);
      imagecopyresampled($this->imgResult, $this->imgProducto, $realSpaceWidht, 0, 0, 0, $imgProductWidth, $imgProductHeight, $imgProductWidth, $imgProductHeight);
    }


 }
*/



  
  /*
   function image_create($name){
  
  $save = "./final/". strtolower($name) .".png";
  

    $this->imgMain = imagecreatefrompng('temp/base.png');
    $this->imgLogo = imagecreatefrompng("temp/logo.png");
    $this->imgProducto = imagecreatefrompng("temp/producto.png");

    //get image size
    $imgMainWidth  = imagesx($this->imgMain);
    $imgMainHeight = imagesy($this->imgMain);
    $imgLogoWidth  = imagesx($this->imgLogo);
    $imgLogoHeight = imagesy($this->imgLogo);
    $imgProductWidth  = imagesx($this->imgProducto);
    $imgProductHeight = imagesy($this->imgProducto);


   $realSpaceWidht = ($this->max_base_width -  $imgProductWidth) / 2 ;
  

  //create blank gd image
  $this->imgResult = imagecreatetruecolor($imgMainWidth, $imgMainHeight);
  imagecopyresampled($this->imgResult,  $this->imgMain, 0, 0, 0, 0, $imgMainWidth, $imgMainHeight, $imgMainWidth, $imgMainHeight);
  //imagecopyresampled($imgResult, $imgLogo, 0, 0, 0, 0, $imgLogoWidth, $imgLogoHeight, $imgLogoWidth, $imgLogoHeight);


  imagecopyresampled($this->imgResult, $this->imgProducto, $realSpaceWidht, 0, 0, 0, $imgProductWidth, $imgProductHeight, $imgProductWidth, $imgProductHeight);
  //save result images
  imagepng($this->imgResult, "temp/base_2.png");
  //imagedestroy($imgResult);
  $this->imgFinal = imagecreatefrompng("temp/base_2.png");
  imagecopyresampled($this->imgFinal, $this->imgLogo, $realSpaceWidht,($this->max_base_heigth-80), 0, 0, $imgLogoWidth, $imgLogoHeight, $imgLogoWidth, $imgLogoHeight);

  imagepng($this->imgFinal, $save);
  echo "--> New Image created on ".$save."<BR><BR>----------------------------------------------------<BR><BR>";
    

 }*/
/*
  function image_destroy(){

     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgCheck);
     @imagedestroy($this->imgMain);
     @imagedestroy($this->imgProducto);
     @imagedestroy($this->imgResult);
     @imagedestroy($this->imgFinal);
     @imagedestroy($this->imgLogo);

  } */
    
/*
   function check_ext($url,$type){

     $control = false;
     if (getimagesize($url)) {
       echo "ENTRA";
      $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
   echo $ext;
     if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
      switch ($ext) {
      case "png" :
         $this->imgCheck = @imagecreatefrompng($url);
         break;
      case "jpeg" :
          $this->imgCheck = @imagecreatefromjpeg($url);  
      break;
      case "jpg" :
             $this->imgCheck = @imagecreatefromjpeg($url);  
             break;
    }

     if($type == 1){
       $this->imgLogo = $this->imgCheck;
       imagepng( $this->imgCheck, "temp/logo.png");

     }
    
     if($type == 2){
      $this->imgProducto = $this->imgCheck;
      imagepng( $this->imgCheck, "temp/producto.png");  
     }
       if(!is_null($this->imgCheck)){
        $control = true;
       }

     } else {  $control = false;}

   }  else { $control = false;}

   return $control;

   } 


   function check_size($url,$type){
      $imgMainWidth  = imagesx($this->imgCheck);
      $imgMainHeight = imagesy($this->imgCheck);
      $resize = false;
     
     if($type == 1){ //LOGO
      if($imgMainWidth > $this->max_logo_width){$resize = true;}
      if($imgMainHeight > $this->max_logo_heigth){$resize = true;}
     } 
      if($type == 2){ //PRODUCTO
      if($imgMainWidth > $this->max_prd_width){$resize = true;}
      if($imgMainHeight > $this->max_prd_heigth){$resize = true;}
     }

     if($resize){
      if($type == 1){
       echo "--> RESIZE ".$type." Original ".$imgMainWidth." x ".$imgMainHeight." New:".$this->max_logo_width. " x ".$this->max_logo_heigth." <BR>";
      }
      if($type == 2){
       echo "--> RESIZE ".$type." Original ".$imgMainWidth." x ".$imgMainHeight." New:".$this->max_prd_width. " x ".$this->max_prd_heigth." <BR>";
      }
      $this->image_resize($type);
     }

     //echo $imgMainWidth;

  }  

  function image_resize($type){
    if($type == 1) { // Logo
      $img = imagescale($this->imgCheck, $this->max_logo_width, $this->max_logo_heigth);
      imagepng( $img, "temp/logo.png");
     
    }
    if($type == 2) { // producto
       $img = imagescale($this->imgCheck, $this->max_prd_width, $this->max_prd_heigth);
       imagepng( $img, "temp/producto.png");
    }
   //imagedestroy($img);
   }
*/

 

?>