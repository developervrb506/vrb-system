<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_control")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../includes/shadowbox/shadowbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript">
Shadowbox.init({
    players: ['iframe'],
    onClose: function(){ location.reload(); }
});
</script>
<title>Agent Payment Control</title>
<style>
.apc-table { width:100%; border-collapse:collapse; font-size:13px; }
.apc-table th { background:#2c3e50; color:#fff; padding:8px 10px; text-align:left; }
.apc-table td { padding:7px 10px; border-bottom:1px solid #e0e0e0; vertical-align:middle; }
.apc-table tr:hover td { background:#f5f9ff; }
.apc-table tr.row-inactive td { opacity:0.55; }

.balance-cell { font-size:16px; font-weight:bold; }
.balance-pos { color:#27ae60; }
.balance-neg { color:#c0392b; }
.balance-zero { color:#7f8c8d; }

.badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; }
.badge-active { background:#27ae60; color:#fff; }
.badge-inactive { background:#95a5a6; color:#fff; }
.badge-clerk { background:#2980b9; color:#fff; }
.badge-pending { background:#f39c12; color:#fff; }

.apc-filters { background:#f8f9fa; padding:12px 16px; border:1px solid #ddd; margin-bottom:16px; border-radius:4px; }
.apc-filters label { font-weight:bold; margin-right:4px; }
.apc-filters select, .apc-filters input[type=text] { padding:4px 8px; border:1px solid #ccc; border-radius:3px; margin-right:12px; }
.apc-filters input[type=checkbox] { margin-right:4px; }

.btn-detail { background:#2980b9; color:#fff; border:none; padding:4px 10px; border-radius:3px; cursor:pointer; font-size:12px; text-decoration:none; }
.btn-detail:hover { background:#1a6fa8; }

.note-preview { color:#666; font-style:italic; font-size:12px; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.last-call-date { font-size:12px; color:#555; }
</style>
</head>
<body>
<?php include "../../includes/header.php" ?>
<?php include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:30px; padding-right:30px;">
<span class="page_title">AGENT PAYMENT CONTROL</span><br /><br />

<?php include "../includes/print_error.php" ?>

<?php
// --- Filters ---
$filter_status  = isset($_GET["status"])   ? $_GET["status"]   : "";
$filter_clerk   = isset($_GET["clerk_id"]) ? (int)$_GET["clerk_id"] : 0;
$filter_bal_pos = isset($_GET["bal_pos"])  ? 1 : 0;
$filter_search  = isset($_GET["search"])   ? trim($_GET["search"]) : "";

// Load all agents then filter in PHP (table is small ~36 rows)
$all_agents = get_c_agents_all();
$clerks     = get_clerk_available_list();

// Build clerk id->name map
$clerk_map = array();
if(is_array($clerks)){
    foreach($clerks as $c){
        $clerk_map[$c->vars["id"]] = $c->vars["name"];
    }
}

// Apply filters
$agents = array();
if(is_array($all_agents)){
    foreach($all_agents as $a){
        if($filter_status != "" && $a->vars["status"] != $filter_status) continue;
        if($filter_clerk > 0 && $a->vars["assigned_clerk_id"] != $filter_clerk) continue;
        if($filter_bal_pos && $a->vars["current_balance"] <= 0) continue;
        if($filter_search != ""){
            $s = strtolower($filter_search);
            if(strpos(strtolower($a->vars["agent_code"]), $s) === false &&
               strpos(strtolower($a->vars["agent_name"]), $s) === false) continue;
        }
        $agents[] = $a;
    }
}

// Load last note per agent
$last_notes = array();
accounting_db();
$lnotes_sql = "SELECT n1.agent_id, n1.note_text, n1.call_status, n1.created_at
               FROM c_agent_call_notes n1
               INNER JOIN (SELECT agent_id, MAX(id) as max_id FROM c_agent_call_notes GROUP BY agent_id) n2
               ON n1.agent_id = n2.agent_id AND n1.id = n2.max_id";
$lnotes_rows = get_str($lnotes_sql);
if(is_array($lnotes_rows)){
    foreach($lnotes_rows as $nr){ $last_notes[$nr["agent_id"]] = $nr; }
}
?>

<!-- Filters -->
<form method="get" action="index.php" class="apc-filters">
    <label>Status:</label>
    <select name="status">
        <option value="">All</option>
        <option value="active"   <?php if($filter_status=="active") echo "selected"; ?>>Active</option>
        <option value="inactive" <?php if($filter_status=="inactive") echo "selected"; ?>>Inactive</option>
    </select>

    <label>Clerk:</label>
    <select name="clerk_id">
        <option value="0">All Clerks</option>
        <?php if(is_array($clerks)){ foreach($clerks as $c){ ?>
        <option value="<?php echo $c->vars["id"]; ?>" <?php if($filter_clerk==$c->vars["id"]) echo "selected"; ?>>
            <?php echo htmlspecialchars($c->vars["name"]); ?>
        </option>
        <?php }} ?>
    </select>

    <label><input type="checkbox" name="bal_pos" value="1" <?php if($filter_bal_pos) echo "checked"; ?>> Balance &gt; 0</label>

    <input type="text" name="search" value="<?php echo htmlspecialchars($filter_search); ?>" placeholder="Search code or name..." style="width:180px;" />

    <input type="submit" value="Filter" class="btn-detail" />
    &nbsp;<a href="index.php" class="btn-detail" style="background:#7f8c8d;">Clear</a>
</form>

<div style="margin-bottom:8px; color:#555; font-size:13px;">
    Showing <strong><?php echo count($agents); ?></strong> agents
</div>

<table class="apc-table">
<tr>
    <th>Code</th>
    <th>Name</th>
    <th>Balance</th>
    <th>Status</th>
    <th>Assigned Clerk</th>
    <th>Last Call</th>
    <th>Last Note</th>
    <th>Action</th>
    <th></th>
</tr>
<?php if(count($agents) == 0){ ?>
<tr><td colspan="8" style="text-align:center; color:#999; padding:20px;">No agents found.</td></tr>
<?php } ?>
<?php foreach($agents as $a){
    $aid      = $a->vars["id"];
    $bal      = floatval($a->vars["current_balance"]);
    $bal_cls  = $bal > 0 ? "balance-pos" : ($bal < 0 ? "balance-neg" : "balance-zero");
    $status   = $a->vars["status"];
    $row_cls  = $status == "inactive" ? "row-inactive" : "";

    $clerk_name = "";
    if($a->vars["assigned_clerk_id"] && isset($clerk_map[$a->vars["assigned_clerk_id"]])){
        $clerk_name = $clerk_map[$a->vars["assigned_clerk_id"]];
    }

    $last_call = $a->vars["last_call_at"] ? date("m/d/y", strtotime($a->vars["last_call_at"])) : "-";

    $last_note_text = "";
    if(isset($last_notes[$aid])){
        $last_note_text = substr($last_notes[$aid]["note_text"], 0, 60);
        if(strlen($last_notes[$aid]["note_text"]) > 60) $last_note_text .= "...";
    }

    $popup_url = BASE_URL . "/ck/agent_control/agent_detail.php?id=" . $aid;
?>
<tr class="<?php echo trim($row_cls); ?>">
    <td><strong><?php echo htmlspecialchars($a->vars["agent_code"]); ?></strong></td>
    <td><?php echo htmlspecialchars($a->vars["agent_name"]); ?></td>
    <td class="balance-cell <?php echo $bal_cls; ?>">
        $<?php echo number_format($bal, 2); ?>
    </td>
    <td><span class="badge badge-<?php echo $status; ?>"><?php echo strtoupper($status); ?></span></td>
    <td>
        <?php if($clerk_name){ ?>
        <span class="badge badge-clerk"><?php echo htmlspecialchars($clerk_name); ?></span>
        <?php } else { ?>
        <span style="color:#bbb; font-size:12px;">Unassigned</span>
        <?php } ?>
    </td>
    <td class="last-call-date"><?php echo $last_call; ?></td>
    <td class="note-preview"><?php echo htmlspecialchars($last_note_text); ?></td>
    <td>
        <a href="javascript:void(0);" class="btn-detail"
           onclick="pop_shadow('<?php echo $popup_url; ?>', 'Agent <?php echo htmlspecialchars($a->vars["agent_code"]); ?>', 950, 660);">
            Detail
        </a>
    </td>
    <td>
        <?php $contact_url = BASE_URL . "/ck/agent_control/agent_contact.php?code=" . urlencode($a->vars["agent_code"]); ?>
        <a href="javascript:void(0);" title="Contact Info"
           onclick="pop_shadow('<?php echo $contact_url; ?>', 'Contact: <?php echo htmlspecialchars($a->vars["agent_code"]); ?>', 420, 320);"
           style="font-size:18px; text-decoration:none; cursor:pointer;">&#128222;</a>
    </td>
</tr>
<?php } ?>
</table>

</div>
<?php include "../../includes/footer.php" ?>
<?php }else{ echo "Access Denied"; } ?>
