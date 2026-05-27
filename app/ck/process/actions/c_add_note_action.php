<?php include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php if($current_clerk->im_allow("agent_manager")){

    $agent_id    = isset($_POST["agent_id"])    ? (int)$_POST["agent_id"]              : 0;
    $call_status = isset($_POST["call_status"]) ? trim($_POST["call_status"])           : "";
    $note_text   = isset($_POST["note_text"])   ? trim($_POST["note_text"])             : "";

    $valid_statuses = array("pending","called","no_answer","promise_to_pay","paid","inactive","other");

    if(!$agent_id || $note_text == "" || !in_array($call_status, $valid_statuses)){
        header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=notes&err=" . urlencode("Invalid data. Note text and status are required."));
        exit();
    }

    // Insert note
    $note = new _c_agent_call_notes();
    $note->vars["agent_id"]    = $agent_id;
    $note->vars["clerk_id"]    = $current_clerk->vars["id"];
    $note->vars["call_status"] = $call_status;
    $note->vars["note_text"]   = $note_text;
    $note->vars["created_at"]  = date("Y-m-d H:i:s");
    $note->insert();

    // Update agent last call fields
    $agent = get_c_agent($agent_id);
    if($agent){
        $agent->vars["last_call_at"]       = date("Y-m-d H:i:s");
        $agent->vars["last_call_clerk_id"] = $current_clerk->vars["id"];
        $agent->update(array("last_call_at","last_call_clerk_id"));
    }

    header("Location: " . BASE_URL . "/ck/agent_control/agent_detail.php?id={$agent_id}&tab=notes&msg=" . urlencode("Note saved."));
    exit();

}else{ echo "Access Denied"; } ?>
