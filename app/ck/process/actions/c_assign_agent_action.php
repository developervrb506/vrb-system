<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_manager")){

    $agent_id  = isset($_POST["agent_id"])  ? (int)$_POST["agent_id"]  : 0;
    $clerk_id  = isset($_POST["clerk_id"])  ? (int)$_POST["clerk_id"]  : 0;
    $redirect_id = $agent_id;

    if(!$agent_id || !$clerk_id){
        header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$redirect_id}&tab=summary&err=" . urlencode("Missing agent or clerk."));
        exit();
    }

    // Close active assignment if exists
    $current_assignment = get_c_active_assignment_by_agent($agent_id);
    if($current_assignment){
        $current_assignment->vars["released_at"]    = date("Y-m-d H:i:s");
        $current_assignment->vars["release_reason"] = "reassigned";
        $current_assignment->update(array("released_at","release_reason"));
    }

    // Update agent assigned_clerk_id
    $agent = get_c_agent($agent_id);
    if($agent){
        $agent->vars["assigned_clerk_id"] = $clerk_id;
        $agent->update(array("assigned_clerk_id"));
    }

    // Insert new assignment record
    $assignment = new _c_agent_assignments();
    $assignment->vars["agent_id"]            = $agent_id;
    $assignment->vars["clerk_id"]            = $clerk_id;
    $assignment->vars["assigned_by_clerk_id"] = $current_clerk->vars["id"];
    $assignment->vars["assigned_at"]         = date("Y-m-d H:i:s");
    $assignment->insert();

    header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$redirect_id}&tab=summary&msg=" . urlencode("Agent assigned successfully."));
    exit();

}else{ echo "Access Denied"; } ?>
