<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_manager")){

    $agent_id = isset($_POST["agent_id"]) ? (int)$_POST["agent_id"] : 0;

    if(!$agent_id){
        header("Location: " . BASE_URL . "/ck/agent_control/index.php");
        exit();
    }

    $agent = get_c_agent($agent_id);
    if($agent){
        $new_status = ($agent->vars["status"] == "active") ? "inactive" : "active";
        $agent->vars["status"] = $new_status;
        $agent->update(array("status"));
    }

    header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=summary&msg=" . urlencode("Status updated."));
    exit();

}else{ echo "Access Denied"; } ?>
