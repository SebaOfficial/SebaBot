<?php

if($id == $owner){ // Only the owner can have access to the panel

    if(isset($text)){

        if($text == "panel"){ // The panel is requested
            
            sendMessage($chat_id, 
                getTexts("PANEL_TXT", $lang),
                composeKeyboard("panel", $lang)
            );

        }

        else if(str_starts_with($action, "panel:")){ // The user hasn't sent a command, and their action is panel related
            include_once "helpers/$action.php"; // Including so it won't give a fatal error if there is some mistake
        }

    }

    if(isset($data)){

        if($data == "panel"){ // The panel is requested

            editMessage($chat_id, $message_id,
                getTexts("PANEL_TXT", $lang),
                composeKeyboard("panel", $lang)
            );
            answerCall($callbackId,
                getTexts("PANEL_CALLBACK", $lang)
            );

        } else{ // Some section of the panel is requested
            include_once "helpers/$data.php"; // Including so it won't give a fatal error if there is some mistake
        }
    }

}

?>