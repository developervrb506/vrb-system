<? if($current_clerk->im_allow("expenses_user")){ include "expenses_user.php";} ?>
<? if(isset($_GET["phs"])){ ?> <script type="text/javascript">location.href = "admin_clerk_index.php?e=<? echo $_GET["e"] ?>";</script> <? }else{} ?>

<iframe src="changed_players.php?menu=off" frameborder="0" scrolling="auto" width="100%" height="500"></iframe>
<hr />
<iframe src="changed_wagers.php?menu=off" frameborder="0" scrolling="auto" width="100%" height="500"></iframe>