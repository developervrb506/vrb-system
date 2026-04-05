<a onclick="display_div('new_message_content')" href="javascript:;" class="normal_link">New Message</a>

<div class="form_box" style="margin-top:15px; display:none;" id="new_message_content">
    <div style="float:right; width:auto;">
        <a onclick="display_div('new_message_content')" href="javascript:;" class="normal_link">Close</a>
    </div>
    <script type="text/javascript" src="../process/js/functions.js"></script>
    <script type="text/javascript">
    var validations = new Array();
    validations.push({id:"title",type:"null", msg:"Subject is required"});
    validations.push({id:"content",type:"null", msg:"Content is required"});
    </script>
    <form method="post" action="process/actions/send_message_action.php" onsubmit="return validate(validations);" enctype="multipart/form-data">
    <table width="350" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>To:</td>
            <td><? $clerks_admin = "1"; $me_option = true; include "includes/clerks_list.php" ?></td>
          </tr>
          <tr>
            <td>Subject:</td>
            <td><input name="title" type="text" id="title" /></td>
          </tr>
          <tr>
            <td><a href="javascript:;" class="normal_link" onclick="display_div('attach_new')">Attach File</a></td>
            <td><div style="display:none;" id="attach_new"><input name="attachment" type="file" id="attachment" /></div></td>
          </tr>
        </table>            
        <textarea name="content" style="width:99%" rows="5" id="content"></textarea><br />
        <div align="right"><input name="" type="submit" value="Submit" /></div>
    </form> 
</div>