
<?
foreach($messages as $msg){if($i % 2){$style = 1;}else{$style = 0;}
		if($msg->vars["from"] != $message_user && $msg->vars["to"] != $message_user){
			if($msg->vars["from"] == $current_clerk){$message_user = $msg->vars["to"];}
			else{$message_user = $msg->vars["from"];}
			if($preview || $name_sort){
				?>
				<tr>
                    <td height="50" colspan="9" style="font-size:20px; border-bottom:1px solid #CCC; border-top:1px solid #CCC;">
                    	<br /><strong><? echo $message_user->vars["name"] ?> </strong>
                    </td>
                </tr>
				<?
			}
		}
		$i++;
		$auto_from = false;
		$auto_to = false;
		if($msg->vars["from"]->vars["id"] == $current_clerk->vars["id"]){$auto_from = true;}
		if($msg->vars["to"]->vars["id"] == $current_clerk->vars["id"]){$auto_to = true;}
    ?>
    <tr id="tr_<? echo $msg->vars["id"] ?>" class="<? if($msg->is_message_read($current_clerk)){echo "tr_read";}else{echo "tr_no_read";} ?>" style=" background-color:<? if(!$msg->vars["important"]){echo $row_colors[$style];}else{echo $important_colors[$style].";font-style:italic;";} ?>">
        <td align="center" class="table_td">
        	<img <? if(!$msg->vars["complete"]){echo 'style="display:none;"';} ?> src="../../images/icons/complete_vrb.png" width="20" height="20" alt="Complete" id="check_<? echo $msg->vars["id"] ?>" />
        </td>
        <td class="table_td">
       	  <script type="text/javascript">main_ids.push('<? echo $msg->vars["id"] ?>');</script>
        	<a name="message_" id="message_<? echo $msg->vars["id"] ?>"></a>
			<input name="select_<? echo $msg->vars["id"] ?>" type="checkbox" value="1" id="select_<? echo $msg->vars["id"] ?>" />
    </td>
        <td class="table_td">			           
		  <? echo date("M jS, Y / g:i a",strtotime($msg->vars["last_date"])); ?>
        </td>
        <td class="table_td">
            <? 
            if($auto_from){echo "You";}
            else{echo $msg->vars["from"]->vars["name"]; }		
            ?>
        </td>
        <td class="table_td">
            <? 
            if($auto_to){echo "You";}
            else{echo $msg->vars["to"]->vars["name"]; }		
            ?>
        </td>
        <td class="table_td pointer" onclick="open_close_message('<? echo $msg->vars["id"] ?>');">
			<? echo text_preview($msg->vars["title"], 40) ?>
            <? if($msg->vars["important"] && !$current_clerk->admin()){ ?> <span class="important_span"> (Important!)</span> <? } ?>
        </td>
        <? if($current_clerk->admin()){ ?>
        <td class="table_td pointer" onclick="open_close_message('<? echo $msg->vars["id"] ?>');">
			<? echo text_preview($msg->vars["content"], 40) ?>
        </td> 
        <td class="table_td" align="center" style="font-size:12px;">
       		<a href="javascript:;" title="Important" class="normal_link" 
            onclick="change_important('<? echo $msg->vars["id"] ?>','<? echo $row_colors[$style] ?>','<? echo $important_colors[$style] ?>',true)">
            	<img src="../../images/icons/important_vrb.png" width="20" height="20" alt="Important" border="0" />
            </a>
      </td>       
        <td class="table_td" align="center" style="font-size:12px;">
       		<a onclick="delete_ck_message('<? echo $msg->vars["id"] ?>','<? echo $msg->vars["title"] ?>',false,true)"  title="Delete" href="javascript:;" class="normal_link">
           		<img src="../../images/icons/delete_vrb.png" width="20" height="20" alt="Delete" border="0" />
            </a>
      </td>
        <? } ?>
    </tr>
    <tr id="inside_<? echo $msg->vars["id"] ?>">
      <td colspan="9" class="table_td" style="border-top:1px solid #CCC; border-bottom:1px solid #CCC; font-weight:normal; background:#e4f8ff; text-align:justify; <? if($opener != $msg->vars["id"] && !$preview){echo 'display:none;';} ?>" id="<? echo $msg->vars["id"] ?>">
      	
        
        <div style="float:right;">
        <a href="javascript:;" class="normal_link" onclick="change_complete('<? echo $msg->vars["id"] ?>',true);">
            Mark as <span id="complete_txt_<? echo $msg->vars["id"] ?>">
            <? if($msg->vars["complete"]){echo "Incomplete";}else{echo "Complete";} ?>            
            </span>
        </a>       
        <? if($current_clerk->admin()){ ?>
           &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
          <a href="includes/edit_message.php?mid=<? echo $msg->vars["id"] ?>" rel="shadowbox;height=300;width=570" title='Edit "<? echo $msg->vars["title"] ?>"' class="normal_link">
              Edit
          </a>
        <? } ?>
        </div>
        
        
        
        <strong><? echo $msg->vars["title"] ?></strong>&nbsp;&nbsp;&nbsp;
        <span style="font-size:12px;">(<? echo date("M jS, Y / g:i a",strtotime($msg->vars["send_date"])); ?>)</span>
		<? 
		if($msg->have_attachments()){
			?><br /><span style="font-size:11px; font-weight:bold">Attachments:&nbsp;&nbsp;&nbsp;&nbsp;<?
			foreach($msg->attachments as $att){
				?><a href="includes/download_file.php?file=<? echo $att->vars["file"] ?>" class="normal_link">
					<? echo $att->vars["name"] ?>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;<?
			}
			?></span><?
		}
		?>
        
        <br /><br />
        <? echo nl2br($msg->vars["content"]) ?>              
        
        <br /><br />
        <?
        $replys = get_message_replys($msg->vars["id"]);
        foreach($replys as $reply){
            $auto = false;
            if($reply->vars["from"]->vars["id"] == $current_clerk->vars["id"]){$auto = true;}
            ?><div class="form_box" <? if(!$auto){echo 'style="background:#fbfdc2"';} ?> id="tr_<? echo $reply->vars["id"] ?>" >
            		<? if($current_clerk->admin()){ ?>
  					<div style="float:right;">
                    <a onclick="delete_ck_message('<? echo $reply->vars["id"] ?>','<? echo $reply->vars["title"] ?>',true,true)" href="javascript:;" class="normal_link">
                        Delete
                    </a>
                    </div>
                    <? } ?>
<strong> 
                    <?
                    if($auto){echo "You";}
                    else{echo $reply->vars["from"]->vars["name"];} 						
                    ?> 
                    on <? echo date("M jS, Y / g:i a",strtotime($reply->vars["send_date"])) ?></strong>
                    
                    <? 
					if($reply->have_attachments()){
						?><br /><span style="font-size:11px; font-weight:bold">Attachments:&nbsp;&nbsp;&nbsp;&nbsp;<?
						foreach($reply->attachments as $att){
							?><a href="includes/download_file.php?file=<? echo $att->vars["file"] ?>" class="normal_link">
								<? echo $att->vars["name"] ?>
							</a>&nbsp;&nbsp;&nbsp;&nbsp;<?
						}
						?></span><?
					}
					?>
                    
					<br /><br />
                    <? echo nl2br($reply->vars["content"]) ?>
                </div>
            <?	
        }
        ?>
        <div class="form_box" <? if($preview){echo 'style="display:none"';} ?>>
        <strong>Reply</strong>
        &nbsp;&nbsp;&nbsp;
        <a href="javascript:;" class="normal_link" onclick="display_div('attach_<? echo $msg->vars["id"] ?>')">Attach File</a><br />
        <form method="post" action="?e=14#message_<? echo $msg->vars["id"] ?>" enctype="multipart/form-data">
            <input name="reply" type="hidden" id="reply" value="<? echo $msg->vars["id"] ?>" />
            <div style="display:none;" id="attach_<? echo $msg->vars["id"] ?>">
            	Attachment: <input name="attachment" type="file" id="attachment" />
            </div>
            <textarea name="reply_text" style="width:99%" rows="3" id="reply_text"></textarea><br />
            <div align="right"><input name="" type="submit" value="Submit" /></div>
        </form>          
        </div>
        
      </td>
    </tr>
    <? } ?>  