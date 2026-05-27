<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_control")){ ?>
<?php
$agent_code = isset($_GET["code"]) ? trim($_GET["code"]) : "";
$account    = $agent_code ? get_pph_account_by_name($agent_code) : null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Contact: <?php echo htmlspecialchars($agent_code); ?></title>
<style>
body { font-family: Arial, sans-serif; font-size:13px; margin:0; padding:18px; background:#fff; }

.contact-card { border:1px solid #ddd; border-radius:6px; overflow:hidden; }
.contact-header {
    background:#2c3e50; color:#fff;
    padding:12px 16px;
    display:flex; align-items:center; gap:10px;
}
.contact-header .avatar {
    width:40px; height:40px; border-radius:50%;
    background:#fff; color:#2c3e50;
    display:flex; align-items:center; justify-content:center;
    font-size:20px; font-weight:bold; flex-shrink:0;
}
.contact-header .agent-code { font-size:18px; font-weight:bold; }
.contact-header .agent-label { font-size:11px; opacity:.75; }

.contact-body { padding:14px 16px; }
.contact-row {
    display:flex; align-items:flex-start;
    padding:8px 0; border-bottom:1px solid #f0f0f0;
}
.contact-row:last-child { border-bottom:none; }
.contact-row .icon { width:28px; font-size:16px; flex-shrink:0; color:#7f8c8d; }
.contact-row .label { width:110px; font-size:11px; color:#95a5a6; text-transform:uppercase; flex-shrink:0; padding-top:2px; }
.contact-row .value { flex:1; font-size:13px; color:#2c3e50; font-weight:500; word-break:break-word; }

.badge-alert { display:inline-block; background:#e74c3c; color:#fff; padding:2px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
.badge-no-alert { display:inline-block; background:#27ae60; color:#fff; padding:2px 10px; border-radius:10px; font-size:12px; }

.no-account {
    text-align:center; padding:30px 16px; color:#95a5a6;
}
.no-account .icon { font-size:40px; }
.no-account p { margin:8px 0 0; }
</style>
</head>
<body>

<?php if(!$account): ?>
<div class="no-account">
    <div class="icon">&#128100;</div>
    <p>No PPH contact info found for <strong><?php echo htmlspecialchars($agent_code); ?></strong></p>
</div>

<?php else: ?>
<div class="contact-card">
    <div class="contact-header">
        <div class="avatar">&#128100;</div>
        <div>
            <div class="agent-code"><?php echo htmlspecialchars($account->vars["name"]); ?></div>
            <div class="agent-label">PPH Account</div>
        </div>
    </div>
    <div class="contact-body">

        <?php if(!empty($account->vars["phone"])): ?>
        <div class="contact-row">
            <div class="icon">&#128222;</div>
            <div class="label">Phone</div>
            <div class="value"><?php echo htmlspecialchars($account->vars["phone"]); ?></div>
        </div>
        <?php endif; ?>

        <?php if(!empty($account->vars["pph_agent"])): ?>
        <div class="contact-row">
            <div class="icon">&#128101;</div>
            <div class="label">PPH Agent</div>
            <div class="value"><?php echo htmlspecialchars($account->vars["pph_agent"]); ?></div>
        </div>
        <?php endif; ?>

        <?php if(!empty($account->vars["description"])): ?>
        <div class="contact-row">
            <div class="icon">&#128203;</div>
            <div class="label">Description</div>
            <div class="value"><?php echo nl2br(htmlspecialchars($account->vars["description"])); ?></div>
        </div>
        <?php endif; ?>

        <div class="contact-row">
            <div class="icon">&#128276;</div>
            <div class="label">Balance Alert</div>
            <div class="value">$<?php echo number_format(floatval($account->vars["balance_alert"]), 2); ?></div>
        </div>

    </div>
</div>
<?php endif; ?>

</body>
</html>
<?php }else{ echo "Access Denied"; } ?>
