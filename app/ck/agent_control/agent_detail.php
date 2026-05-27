<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_control")){ ?>
<?php
$agent_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$agent = get_c_agent($agent_id);
if(!$agent){ die("Agent not found."); }

$clerks   = get_clerk_available_list();
$clerk_map = array();
if(is_array($clerks)){
    foreach($clerks as $c){ $clerk_map[$c->vars["id"]] = $c->vars["name"]; }
}

$active_tab = isset($_GET["tab"]) ? $_GET["tab"] : "summary";

$action_base = BASE_URL . "/ck/process/actions/";
$self_url    = BASE_URL . "/ck/agent_control/agent_detail.php?id=" . $agent_id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Agent <?php echo htmlspecialchars($agent->vars["agent_code"]); ?></title>
<style>
body { font-family: Arial, sans-serif; font-size:13px; margin:0; padding:10px; background:#fff; }
h2 { margin:0 0 10px; font-size:16px; color:#2c3e50; }

.tab-nav { display:flex; border-bottom:2px solid #2c3e50; margin-bottom:14px; }
.tab-btn { padding:7px 18px; cursor:pointer; border:1px solid #ccc; border-bottom:none; background:#f0f0f0;
           margin-right:3px; border-radius:4px 4px 0 0; font-size:13px; text-decoration:none; color:#333; }
.tab-btn.active { background:#2c3e50; color:#fff; border-color:#2c3e50; }
.tab-content { display:none; }
.tab-content.active { display:block; }

.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px 24px; margin-bottom:14px; }
.info-item label { font-weight:bold; color:#555; font-size:12px; display:block; }
.info-item span  { font-size:14px; }

.balance-big { font-size:26px; font-weight:bold; }
.balance-pos { color:#27ae60; }
.balance-neg { color:#c0392b; }
.balance-zero { color:#7f8c8d; }

.badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; }
.badge-active { background:#27ae60; color:#fff; }
.badge-inactive { background:#95a5a6; color:#fff; }
.badge-clerk { background:#2980b9; color:#fff; }
.badge-pending { background:#f39c12; color:#fff; }
.badge-completed { background:#27ae60; color:#fff; }
.badge-cancelled { background:#e74c3c; color:#fff; }

.note-row { border-bottom:1px solid #eee; padding:8px 0; }
.note-row .note-meta { font-size:11px; color:#888; margin-bottom:3px; }
.note-row .note-status { display:inline-block; padding:1px 6px; border-radius:8px; font-size:10px;
                          font-weight:bold; background:#ecf0f1; color:#555; margin-right:6px; }

.mini-form { background:#f8f9fa; border:1px solid #ddd; padding:12px; border-radius:4px; margin-top:12px; }
.mini-form label { display:block; font-weight:bold; margin-bottom:3px; font-size:12px; }
.mini-form select, .mini-form input[type=text], .mini-form input[type=number], .mini-form textarea {
    width:100%; padding:5px 7px; border:1px solid #ccc; border-radius:3px; box-sizing:border-box; margin-bottom:8px; }
.mini-form textarea { height:60px; resize:vertical; }

.btn-save { background:#27ae60; color:#fff; border:none; padding:6px 16px; border-radius:3px; cursor:pointer; font-size:13px; }
.btn-save:hover { background:#1e8449; }
.btn-complete { background:#27ae60; color:#fff; border:none; padding:3px 10px; border-radius:3px;
                cursor:pointer; font-size:11px; }
.btn-complete:hover { background:#1e8449; }
.btn-assign { background:#2980b9; color:#fff; border:none; padding:5px 12px; border-radius:3px;
              cursor:pointer; font-size:12px; }
.btn-assign:hover { background:#1a6fa8; }

.mvmt-table, .pay-table { width:100%; border-collapse:collapse; font-size:12px; }
.mvmt-table th, .pay-table th { background:#ecf0f1; padding:6px 8px; text-align:left; }
.mvmt-table td, .pay-table td { padding:6px 8px; border-bottom:1px solid #eee; }
.dir-credit { color:#27ae60; font-weight:bold; }
.dir-debit  { color:#c0392b; font-weight:bold; }

.section-title { font-size:13px; font-weight:bold; color:#2c3e50; margin:12px 0 6px; border-bottom:1px solid #ddd; padding-bottom:3px; }

.msg-ok  { background:#d4edda; border:1px solid #c3e6cb; padding:6px 10px; border-radius:3px; color:#155724; margin-bottom:10px; }
.msg-err { background:#f8d7da; border:1px solid #f5c6cb; padding:6px 10px; border-radius:3px; color:#721c24; margin-bottom:10px; }
</style>
</head>
<body>

<?php
$msg     = isset($_GET["msg"])  ? $_GET["msg"]  : "";
$errmsg  = isset($_GET["err"])  ? $_GET["err"]  : "";
if($msg)    echo "<div class='msg-ok'>"  . htmlspecialchars($msg)    . "</div>";
if($errmsg) echo "<div class='msg-err'>" . htmlspecialchars($errmsg) . "</div>";
?>

<h2>
    <?php echo htmlspecialchars($agent->vars["agent_code"]); ?> &mdash; <?php echo htmlspecialchars($agent->vars["agent_name"]); ?>
</h2>

<!-- Tabs -->
<div class="tab-nav">
    <?php
    $tabs = array("summary"=>"Summary","notes"=>"Notes","movements"=>"Balance Movements");
    foreach($tabs as $tkey => $tlabel){
        $cls = ($active_tab == $tkey) ? "active" : "";
        echo "<a href='?id={$agent_id}&tab={$tkey}' class='tab-btn {$cls}'>{$tlabel}</a>";
    }
    ?>
</div>

<!-- TAB: SUMMARY -->
<div class="tab-content <?php echo $active_tab=='summary'?'active':''; ?>">
    <?php
    $bal     = floatval($agent->vars["current_balance"]);
    $bal_cls = $bal > 0 ? "balance-pos" : ($bal < 0 ? "balance-neg" : "balance-zero");
    $status  = $agent->vars["status"];
    $assigned_clerk_name = isset($clerk_map[$agent->vars["assigned_clerk_id"]]) ? $clerk_map[$agent->vars["assigned_clerk_id"]] : "Unassigned";
    $last_call_clerk_name = isset($clerk_map[$agent->vars["last_call_clerk_id"]]) ? $clerk_map[$agent->vars["last_call_clerk_id"]] : "-";
    $last_call = $agent->vars["last_call_at"] ? date("m/d/Y H:i", strtotime($agent->vars["last_call_at"])) : "-";
    ?>
    <div class="info-grid">
        <div class="info-item">
            <label>Agent Code</label>
            <span><?php echo htmlspecialchars($agent->vars["agent_code"]); ?></span>
        </div>
        <div class="info-item">
            <label>Agent Name</label>
            <span><?php echo htmlspecialchars($agent->vars["agent_name"]); ?></span>
        </div>
        <div class="info-item">
            <label>Current Balance</label>
            <span class="balance-big <?php echo $bal_cls; ?>">$<?php echo number_format($bal, 2); ?></span>
        </div>
        <div class="info-item">
            <label>Status</label>
            <span><span class="badge badge-<?php echo $status; ?>"><?php echo strtoupper($status); ?></span></span>
        </div>
        <div class="info-item">
            <label>Assigned Clerk</label>
            <span><span class="badge badge-clerk"><?php echo htmlspecialchars($assigned_clerk_name); ?></span></span>
        </div>
        <div class="info-item">
            <label>Last Call</label>
            <span><?php echo $last_call; ?> &nbsp; <span style="color:#888;font-size:12px;"><?php echo htmlspecialchars($last_call_clerk_name); ?></span></span>
        </div>
    </div>

    <div class="section-title">Assign Clerk</div>
    <form method="post" action="<?php echo $action_base; ?>c_assign_agent_action.php">
        <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
        <input type="hidden" name="redirect_id" value="<?php echo $agent_id; ?>" />
        <select name="clerk_id" style="padding:5px; border:1px solid #ccc; border-radius:3px; margin-right:8px;">
            <option value="">-- Select Clerk --</option>
            <?php if(is_array($clerks)){ foreach($clerks as $c){ ?>
            <option value="<?php echo $c->vars["id"]; ?>"
                <?php if($agent->vars["assigned_clerk_id"] == $c->vars["id"]) echo "selected"; ?>>
                <?php echo htmlspecialchars($c->vars["name"]); ?>
            </option>
            <?php }} ?>
        </select>
        <button type="submit" class="btn-assign">Assign</button>
    </form>

    <div class="section-title" style="margin-top:16px;">Toggle Status</div>
    <form method="post" action="<?php echo $action_base; ?>c_toggle_agent_status_action.php">
        <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
        <button type="submit" class="btn-assign" style="background:<?php echo $status=='active'?'#e74c3c':'#27ae60'; ?>;">
            Mark as <?php echo $status=='active' ? 'Inactive' : 'Active'; ?>
        </button>
    </form>
</div>

<!-- TAB: NOTES -->
<div class="tab-content <?php echo $active_tab=='notes'?'active':''; ?>">
    <div class="section-title">Call History</div>
    <?php
    $notes = get_c_agent_call_notes_by_agent($agent_id);
    if(!is_array($notes) || count($notes)==0){
        echo "<p style='color:#999;'>No notes yet.</p>";
    } else {
        foreach($notes as $n){
            $note_clerk = isset($clerk_map[$n->vars["clerk_id"]]) ? $clerk_map[$n->vars["clerk_id"]] : "?";
            $note_date  = date("m/d/Y H:i", strtotime($n->vars["created_at"]));
            echo "<div class='note-row'>";
            echo "<div class='note-meta'>";
            echo "<span class='note-status'>" . htmlspecialchars($n->vars["call_status"]) . "</span>";
            echo "<strong>" . htmlspecialchars($note_clerk) . "</strong> &mdash; " . $note_date;
            echo "</div>";
            echo "<div>" . nl2br(htmlspecialchars($n->vars["note_text"])) . "</div>";
            echo "</div>";
        }
    }
    ?>

    <div class="section-title">Add Note</div>
    <div class="mini-form">
        <form method="post" action="<?php echo $action_base; ?>c_add_note_action.php">
            <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
            <label>Status</label>
            <select name="call_status">
                <option value="called">Called</option>
                <option value="no_answer">No Answer</option>
                <option value="promise_to_pay">Promise to Pay</option>
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
                <option value="inactive">Inactive</option>
                <option value="other">Other</option>
            </select>
            <label>Note</label>
            <textarea name="note_text" placeholder="Enter call note..."></textarea>
            <button type="submit" class="btn-save">Save Note</button>
        </form>
    </div>
</div>

<!-- TAB: BALANCE MOVEMENTS -->
<div class="tab-content <?php echo $active_tab=='movements'?'active':''; ?>">
    <div class="section-title">Movement History</div>
    <?php
    $movements = get_c_agent_balance_movements_by_agent($agent_id);
    if(!is_array($movements) || count($movements)==0){
        echo "<p style='color:#999;'>No movements yet.</p>";
    } else {
        echo "<table class='mvmt-table'>";
        echo "<tr><th>Date</th><th>Type</th><th>Dir</th><th>Amount</th><th>Before</th><th>After</th><th>Clerk</th><th>Detail</th></tr>";
        foreach($movements as $m){
            $mv_clerk = isset($clerk_map[$m->vars["clerk_id"]]) ? $clerk_map[$m->vars["clerk_id"]] : "-";
            $mv_date  = date("m/d/y H:i", strtotime($m->vars["created_at"]));
            $dir_cls  = $m->vars["direction"] == "credit" ? "dir-credit" : "dir-debit";
            $dir_sym  = $m->vars["direction"] == "credit" ? "+" : "-";
            echo "<tr>";
            echo "<td>{$mv_date}</td>";
            echo "<td>" . htmlspecialchars($m->vars["movement_type"]) . "</td>";
            echo "<td class='{$dir_cls}'>{$dir_sym} " . htmlspecialchars($m->vars["direction"]) . "</td>";
            echo "<td class='{$dir_cls}'>\$" . number_format(floatval($m->vars["amount"]), 2) . "</td>";
            echo "<td>\$" . number_format(floatval($m->vars["balance_before"]), 2) . "</td>";
            echo "<td>\$" . number_format(floatval($m->vars["balance_after"]), 2) . "</td>";
            echo "<td>" . htmlspecialchars($mv_clerk) . "</td>";
            echo "<td>" . htmlspecialchars($m->vars["detail"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>

    <div class="section-title">Manual Balance Adjustment</div>
    <div class="mini-form">
        <form method="post" action="<?php echo $action_base; ?>c_balance_movement_action.php">
            <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
            <label>Type</label>
            <select name="movement_type">
                <option value="increment">Increment (add to balance)</option>
                <option value="decrement">Decrement (reduce balance)</option>
            </select>
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" min="0.01" placeholder="0.00" />
            <label>Detail / Comment</label>
            <input type="text" name="detail" placeholder="Reason for adjustment..." />
            <button type="submit" class="btn-save">Apply</button>
        </form>
    </div>
</div>


</body>
</html>
<?php }else{ echo "Access Denied"; } ?>
