<?  include(ROOT_PATH . "/ck/process/security.php"); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>Headline System</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>


 <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= BASE_URL ?>/ck/headlines/js/script.js"> </script>

</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Headlines System</span><br /><br />

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$leagues = array('MLB','NBA','NFL');






$logos[1] = "ESPN";
?>
<div id="contenedor" style="overflow: hidden;width: 100%; ">
<div class="A" style="width:60%; padding: 25px 0; margin: 0; float: left;">
<? /* <div  style="width:60%; display:inline-block;  border:solid;"> */?>
<select style="font-size: 23px" id="league" name="league" onchange="loadGames()" >
<option value="0">Choose a League</option>
<? foreach($leagues as $league) { ?>
<option value="<? echo $league ?>"><? echo $league ?></option>
<? } ?>  
</select>
&nbsp;&nbsp;
<input style="font-size: 20px" type="date" id="date" name="date"  onchange="loadGames()" />&nbsp;&nbsp;
<div id="div_games"></div>
</div>
<div class="B" id="div_mob" style="width:30%; padding: 25px 0; margin: 0; float: left;">
<? /*<div style="width:30%; display:inline-block; border:solid;">
<img class="img_demo" src='\" . BASE_URL . \"/ck/headlines/images/sbo/mobile.jpg'><BR><BR>
<div class="div_upload"><label class="upload-label"><span onclick="preupload()" class="upload-file-label">UPLOAD HEADLINE</span> </label></div>
 */?>
</div>
</div>





<?

/*
  $hour = $_GET['hour'];
  $league = 'NBA';
  $data['hour'] =  $_GET['hour'];
  $data['date'] =  $_GET['date'];
  $data['away'] =  $_GET['away'];
  $data['home'] =  $_GET['home'];
  $data['league'] =  'NBA';

  */
?>
<?
/*
$productos[7] = "https://rcfacturas.com/TEST/Mario/images/7.PNG";
$productos[8] = "https://rcfacturas.com/TEST/Mario/images/8.jpg";
$productos[9] = "https://rcfacturas.com/TEST/Mario/images/9.PNG";
$productos[10] = "https://rcfacturas.com/TEST/Mario/images/10.png";
$productos[11] = "https://rcfacturas.com/TEST/Mario/images/11.png";
$productos[12] = "https://rcfacturas.com/TEST/Mario/images/12.png";


$logos[4] = "https://rcfacturas.com/TEST/Mario/images/L4.png";
$logos[5] = "https://rcfacturas.com/TEST/Mario/images/L5.jpg";


for ($i=0;$i<10;$i++){

  $k = array_rand($logos);
  $url_logo = $logos[$k];
  $k = array_rand($productos);
  $url_producto  =  $productos[$k];
  $k = array_rand($tallas);
  $talla  =  $tallas[$k];
  $sku = rand(10000,99999);
  $name = "file_".$sku;

  echo "#".$i.")<BR>";
  echo "Producto: ".$url_producto."<BR>";
  echo "Logo: ".$url_logo."<BR>";
  echo "SKU: ".$sku."<BR>";
  echo "TALLAS: ".$talla."<BR>";
  echo "Nombre: ".$name."<BR><BR><BR>";


  // Proceso de Bucle

     // Se llama la clase
      $check_ext_logo = false;
      $check_ext_prd = false;
      $image = new _image_customize();
 
    // En este primer Proceso se revisa la Extension de las imagenes
    // Se revisa el tamaño de las mismas, si son mas grandes de la base se procede a hacer un resize segun los parametros maximos de la clase
    // La salida de las imagenes van a ser PNG sin importar si el principal es JPG
  
     //Process for Logo
     $check_ext_logo = $image->check_ext($url_logo,1); //1 for Logo 2 For Product
  
     if($check_ext_logo){
      $check_size = $image->check_size($url_logo,1);    
     } else   { 
      echo " Error de Locacion o Extension de Archivo LOGO, Solamente JPG, JPEG y PNG son Válidas <BR>";
     }
  
     //Process for Product
     $check_ext_prd = $image->check_ext($url_producto,2); //1 for Logo 2 For Product
    if($check_ext_prd){
      
     $check_size = $image->check_size($url_producto,2);  
    } else   { 
      echo " Error de Locacion o Extension de Archivo PRODUCTO, Solamente JPG, JPEG y PNG son Válidas <BR>";
    }

    // Si paso el control de Revision de Extensiones y Resize de imagen creamos la base
    if($check_ext_logo && $check_ext_prd){
      $image->image_base($sku,$talla);
      $image->image_create($name);
    }

 

  
}
*/
?>


</div>
<? include "../../includes/footer.php" ?>