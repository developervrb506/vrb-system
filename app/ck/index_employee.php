

<div class="time_marker_box">
<? if(!$current_clerk->im_allow("just_queue_calls") && $current_clerk->vars['user_group']->vars['id'] != 27 ) { ?>
	<iframe src="http://localhost:8080/ck/includes/time_logs.php" scrolling="no" width="200" height="100" frameborder="0"></iframe>
 <? } ?>   
</div>

<? if($current_clerk->im_allow("unclosed_time")){include("log_time_pending.php");} ?>

<?
$rule_unread = get_no_read_rule($current_clerk->vars["id"]);
if($rule_unread["rule"] != ""){
	?><script type="text/javascript">location.href='view_rule.php?req&rid=<? echo $rule_unread["rule"]  ?>';</script><?
}
?>


<br /><br />
<? if(!$current_clerk->im_allow("just_queue_calls") && $current_clerk->vars['user_group']->vars['id'] != 27 ) { ?>
<p><a href="message_table.php" class="normal_link">View Messages</a></p>
<? } ?>


<? if($current_clerk->im_allow("gambling_checklist_checker")){$included = true; include("gambling_checklist_by_day.php");} ?>