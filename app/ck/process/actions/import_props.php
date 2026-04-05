<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?


//DebugLogTxt("POST", $_POST);


 $spreads = (string)$_POST['spreads'];
 $spreads = mb_convert_encoding($spreads, 'UTF-8', 'ISO-8859-1');
 $moneys = (string)$_POST['moneys'];
 $moneys = mb_convert_encoding($moneys, 'UTF-8', 'ISO-8859-1');
 $totals = (string)$_POST['totals'];
 $totals = mb_convert_encoding($totals, 'UTF-8', 'ISO-8859-1');

    $replacements = array(
        'Â¼' => '.25',
        '-¼' => '-.25',
        '¼' => '.25',
        'Â¾'  => '.75',
        '-¾'  => '-.75',
         '¾'  => '.75',
         'Â½'  => '.5',
         '-½'  => '-.5',
         '½'  => '.5',
         'PK'  => '+0',
         'EV'  => '+100',

      );

    foreach ($replacements as $char => $replacement) {
        $spreads = str_replace($char, $replacement, $spreads);
        $moneys = str_replace($char, $replacement, $moneys);
        $totals = str_replace($char, $replacement, $totals);
    }


    $_POST['spreads'] = $spreads;
    $_POST['moneys'] = $moneys;
    $_POST['totals'] = $totals;

//DebugLogTxt("POST 2#", $_POST);


if($current_clerk->im_allow("props_system")){ 
	$_POST["clerk"] = $current_clerk ->vars["id"];
	echo do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/import_props_action.php",$_POST);
}


?>


