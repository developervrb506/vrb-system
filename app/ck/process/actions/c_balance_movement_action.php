<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_manager")){

    global $conn_db;

    $agent_id      = isset($_POST["agent_id"])      ? (int)$_POST["agent_id"]             : 0;
    $movement_type = isset($_POST["movement_type"]) ? trim($_POST["movement_type"])        : "";
    $amount        = isset($_POST["amount"])        ? floatval($_POST["amount"])           : 0;
    $detail        = isset($_POST["detail"])        ? trim($_POST["detail"])               : "";

    $valid_types = array("increment","decrement");

    if(!$agent_id || !in_array($movement_type, $valid_types) || $amount <= 0){
        header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=movements&err=" . urlencode("Invalid data. Amount must be greater than 0."));
        exit();
    }

    $clerk_id = $current_clerk->vars["id"];
    $now      = date("Y-m-d H:i:s");
    $direction = ($movement_type == "increment") ? "credit" : "debit";

    accounting_db();
    $mysqli = $conn_db->mysqli_connector;
    $mysqli->begin_transaction();

    try {
        // Lock the agent row and read current balance
        $res = $mysqli->query("SELECT current_balance FROM c_agents WHERE id = {$agent_id} FOR UPDATE");
        if(!$res) throw new Exception("Failed to lock agent.");
        $row = $res->fetch_assoc();
        $balance_before = floatval($row["current_balance"]);

        $balance_after = ($movement_type == "increment")
            ? $balance_before + $amount
            : $balance_before - $amount;

        // Update agent balance
        $mysqli->query("UPDATE c_agents SET current_balance = {$balance_after} WHERE id = {$agent_id}");

        // Insert movement record
        $detail_esc = $mysqli->real_escape_string($detail);
        $mysqli->query("INSERT INTO c_agent_balance_movements
            (agent_id, movement_type, direction, amount, balance_before, balance_after, detail, clerk_id, created_at)
            VALUES ({$agent_id}, '{$movement_type}', '{$direction}', {$amount}, {$balance_before}, {$balance_after}, '{$detail_esc}', {$clerk_id}, '{$now}')");

        $mysqli->commit();

        header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=movements&msg=" . urlencode("Balance updated successfully."));
        exit();

    } catch(Exception $e){
        $mysqli->rollback();
        header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=movements&err=" . urlencode("Transaction failed. Please try again."));
        exit();
    }

}else{ echo "Access Denied"; } ?>
