<?php

	#
	# EN :
	# Send it to your site where you want to install (in the good folder).
  # Then, open this file in your browser and wait until the upload is done.
	#
	#
	# FR :
	# Simplement copier ce fichier sur le serveur (via FTP) de votre choix (dans le bon dossier)
	# puis l'appeler depuis votre navigateur
	#
	#
  if (isset($_GET['lang']))  $lang = $_GET['lang'];  else $lang = "";
  //  
  if ( ($lang != "fr") and ($lang != "en") )
  {
		echo "<HTML><HEAD>";
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '</HEAD><BODY>';
    echo "<CENTER>";
    echo "<BR/><BR/><BR/><BR/>";
		echo "<form action='im_loader.php' method='get'>";
    echo "<input type='hidden' name='lang' value='en' />";
    echo "<input type='submit' name='ok' value='Start IntraMessenger server install' />";
		echo "</form>";
		echo '</BODY></HTML>';
    die();
  }
  else
  {
    define('_URL_PAQUET_ZIP','ftp://ftp2.theuds.com/theuds/intramessenger.zip');
    define('_URL_LOADER_DL',"ftp://ftp2.theuds.com/theuds/");
    define('_NOM_PAQUET_ZIP','IntraMessenger');
    define('_REMOVE_PATH_ZIP', _NOM_PAQUET_ZIP);
    //define('_LOADER_URL_RETOUR', "intramessenger/");
    define('_LOADER_URL_RETOUR', "install/");
    define('_LOADER_SCRIPT', "im_loader.php");
    //die($lang);
  }

	define('_PCL_ZIP_SIZE', 249587);

	#
	#######################################################################

	function microtime_float()
	{
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}

	//
	// Ecrire un fichier de maniere un peu sure
	//
	function ecrire_fichierT ($fichier, $contenu) {

		$fp = @fopen($fichier, 'wb');
		$s = @fputs($fp, $contenu, $a = strlen($contenu));

		$ok = ($s == $a);

		@fclose($fp);

		if (!$ok) {
			@unlink($fichier);
		}

		return $ok;
	}

	function move_all($src,$dest) 
	{
		global $chmod;

		if ($dh = opendir($src)) {
			while (($file = readdir($dh)) !== false) {
				if (!in_array($file, array('.', '..'))) {
					if (is_dir("$src/$file")) {
						if (!is_dir("$dest/$file"))
							mkdir("$dest/$file", $chmod);
						move_all("$src/$file", "$dest/$file");
						rmdir("$src/$file");
					} else if (is_file("$src/$file"))
						rename ("$src/$file", "$dest/$file");
				}
			}
		}
	}

	function tester_repertoire() 
	{
		global $chmod;
		
		$ok = false;
		$self = basename($_SERVER['PHP_SELF']);
		$uid = @fileowner('.');
		$uid2 = @fileowner($self);
		$gid = @filegroup('.');
		$gid2 = @filegroup($self);
		$perms = @fileperms($self);

		// Comparer l'appartenance d'un fichier cree par PHP
		// avec celle du script et du repertoire courant
		@rmdir('test');
		@unlink('test'); // effacer au cas ou
		@touch('test');
		if ($uid > 0 && $uid == $uid2 && @fileowner('test') == $uid)
			$chmod = 0700;
		else if ($gid > 0 && $gid == $gid2 && @filegroup('test') == $gid)
			$chmod = 0770;
		else
			$chmod = 0777;
		// Appliquer de plus les droits d'acces du script
		if ($perms > 0) {
			$perms = ($perms & 0777) | (($perms & 0444) >> 2);
			$chmod |= $perms;
		}
		@unlink('test');

		// Verifier que les valeurs sont correctes

		@mkdir('test', $chmod);
		@chmod('test', $chmod);
		$f = @fopen('test/test.php', 'w');
		if ($f) {
			@fputs($f, '<'.'?php $ok = true; ?'.'>');
			@fclose($f);
			@chmod('test/test.php', $chmod);
			include('test/test.php');
		}
		@unlink('test/test.php');
		@rmdir('test');

		return $ok;
	}
	//
	// Demarre une transaction HTTP (s'arrete a la fin des entetes)
	// retourne un descripteur de fichier
	//
	function init_http($get, $url, $refuse_gz=false) 
	{
		$fopen = false;

		$t = @parse_url($url);
		$host = $t['host'];
		if ($t['scheme'] == 'http')
		{ 
			$scheme = 'http'; $scheme_fsock='';
    }
		else 
		{
			$scheme = $t['scheme']; $scheme_fsock=$scheme.'://';
		}
		if (!isset($t['port']) OR !($port = $t['port'])) $port = 80;
		$query = isset($t['query'])?$t['query']:"";
		if (!isset($t['path']) OR !($path = $t['path'])) $path = "/";

		$f = @fsockopen($scheme_fsock.$host, $port);
		if ($f) 
		{
			fputs($f, "$get $path" . ($query ? "?$query" : "") . " HTTP/1.0\r\n");

			fputs($f, "Host: $host\r\n");
			fputs($f, "User-Agent: IM\r\n");
		}
		else
		{
			$f = @fopen($url, "rb");
			$fopen = true;
		}
    //
		return array($f, $fopen);
	}

// options : get_headers si on veut recuperer les entetes
	function recuperer_page($url) {

		// Accepter les URLs au format feed:// ou qui ont oublie le http://
		$url = preg_replace(',^feed://,i', 'http://', $url);
		if (!preg_match(',^[a-z]+://,i', $url)) $url = 'http://'.$url;

		for ($i=0;$i<10;$i++) {	// dix tentatives maximum en cas d'entetes 301...
			list($f, $fopen) = init_http('GET', $url);

			// si on a utilise fopen() - passer a la suite
			if ($fopen) {
				break;
			} else {
				// Fin des entetes envoyees par IM
				fputs($f,"\r\n");

				// Reponse du serveur distant
				$s = trim(fgets($f, 16384));
				if (ereg('^HTTP/[0-9]+\.[0-9]+ ([0-9]+)', $s, $r)) {
					$status = $r[1];
				}
				else return;

				// Entetes HTTP de la page
				$headers = '';
				while ($s = trim(fgets($f, 16384))) {
					$headers .= $s."\n";
					if (eregi('^Location: (.*)', $s, $r)) {
						$location = $r[1];
					}
					if (preg_match(",^Content-Encoding: .*gzip,i", $s))
						$gz = true;
				}
				if ($status >= 300 AND $status < 400 AND $location)
					$url = $location;
				else if ($status != 200)
					return;
				else
					break; # ici on est content
				fclose($f);
				$f = false;
			}
		}

		// Contenu de la page
		if (!$f) {
			return false;
		}

		$result = '';
		while (!feof($f))
			$result .= fread($f, 16384);
		fclose($f);

		// Decompresser le flux
		if ($gz = $_GET['gz'])
			$result = gzinflate(substr($result,10));

		return $result;
	}

	function nettoyer_racine($fichier) {
		global $dir_base;
		@unlink($dir_base.$fichier);
		@unlink($dir_base.'pclzip.php');
		$d = opendir($dir_base);
		while (false !== ($f = readdir($d))) {
			if(preg_match('/^tradloader_(.+).php$/', $f)) @unlink($dir_base.$f);
		}
		closedir($d);
		return true;
	}

	// un essai pour parer le probleme incomprehensible des fichiers pourris
	function touchCallBack($p_event, &$p_header)
	{
		// bien extrait ?
		if ($p_header['status'] == 'ok') {
		    // allez, on touche le fichier, le @ est pour les serveurs sous Windows qui ne comprennent pas touch()
		    @touch($p_header['filename']);
		}
		return 1;
	}




	error_reporting(E_ALL ^ E_NOTICE);

	$dir_base = './'; //repertoire d'installation
	$taux = 0; // calcul eventuel du taux de transfert+dezippage

	$droits = tester_repertoire();

	if ($droits) 
	{
    //on telecharge, on ecrit, au fait, on peut dezipper ?
    //
    // Verifier si la ZLib est utilisable
    //
    $gz = function_exists("gzopen");
    if ($gz) 
    {
      if (!file_exists($f = $dir_base . 'pclzip.php')) 
      {
        $taux = microtime_float();
        $contenu = recuperer_page(_URL_LOADER_DL . 'pclzip.php.txt');
        if ($contenu) {
          ecrire_fichierT($f, $contenu);
        }
        $taux = _PCL_ZIP_SIZE / (microtime_float() - $taux);
      }
      include $f;
    }
    else
      die ('fonctions zip non disponibles');

    $fichier = basename(_URL_PAQUET_ZIP);
    $paquet = (isset($_GET['paquet']) AND preg_match(',[a-zA-Z0-9_]+,', $_GET['paquet'])) ? $_GET['paquet'] : '';

    //
    // deploiement de l'archive
    //
    if ($_GET['fichier'] == 'oui' AND file_exists($dir_base.$fichier)) 
    {
      $ok = mkdir ($tmp = $dir_base.'zip_'.uniqid(rand()), $chmod);
      $zip = new PclZip($dir_base.$fichier);
      $ok &= $zip->extract(
        //PCLZIP_OPT_PATH, $tmp,
        PCLZIP_OPT_PATH, "./",
        PCLZIP_OPT_SET_CHMOD, $chmod,
        PCLZIP_OPT_REPLACE_NEWER,
        PCLZIP_OPT_REMOVE_PATH, _REMOVE_PATH_ZIP."/",
        PCLZIP_CB_POST_EXTRACT, 'touchCallBack');
      if (!$ok OR $zip->error_code<0) 
      {
        debut_html();
        echo _TT('tradloader:donnees_incorrectes',
          array('erreur' => $zip->errorInfo()));
        fin_html();
        exit;
      }
      move_all($tmp,$dir_base._DEST_PAQUET_ZIP);
      rmdir($tmp);
      nettoyer_racine($fichier);
      header("Location: ".$dir_base._LOADER_URL_RETOUR); //*****
      exit;
    }

    $contenu = recuperer_page(_URL_PAQUET_ZIP);

    if (!($contenu AND ecrire_fichierT($dir_base.$fichier, $contenu))) 
    {
      echo 'echec_chargement';
      exit;
    }

    // Passer a l'etape suivante (desarchivage)
    $sep = strpos(_LOADER_SCRIPT, '?') ? '&' : '?';
    header("Location: ".$dir_base._LOADER_SCRIPT.$sep."fichier=oui".($paquet?"&paquet=".$paquet:'') ."&lang=" . $lang);
    exit;
	}
	else 
	{
		die("Cannot...");
	}

?>
 