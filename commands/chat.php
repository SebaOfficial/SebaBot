<?php

if(isset($text)){

    if($text == "chat"){ // If the user has sent the command to chat

        sendMessage($chat_id, 
            getTexts("CHAT_TXT", $lang),
            composeKeyboard("chat", $lang)
        );

    }
    
    elseif(str_starts_with($action, "chat:")){ // The user hasn't sent a command, and their action is chat related
        $messageToEdit = $util1; // The message_id to edit

        if(str_starts_with($action, "chat:bot")){ // Bots related stuff
            require_once "helpers/chat:bot.php";
        }
         
        elseif(str_starts_with($action, "chat:hire")){ // Hire related stuff
            require_once "helpers/chat:hire.php";
        }

        elseif(str_starts_with($action, "chat:privacy")){ // Privacy related stuff
            require_once "helpers/chat:privacy.php";
        }

        elseif(str_starts_with($action, "chat:other")){ // Other stuff
            require_once "helpers/chat:other.php";
        }

    }
    
}

if(isset($data)){

    if($isChatting == "true"){

        answerCall($callbackId,
            getTexts("CHAT_ERROR", $lang),
            true
        );

    } elseif(str_contains($data, ":")){
        
        setUtil($id, 1, $message_id);
        $messageToEdit = $util1; // The message_id to edit
        
        $chatText = strtr(getTexts($data . "_TXT", $lang), [ // The text for every section
            "{chat:hire}" => getTexts("CHAT_BTN_2", $lang), // Replacement for the :bot section
            "{github_link}" => $github_link, // Replacement for the :privacy section
        ]);

        editMessage($chat_id, $message_id,
            $chatText,
            composeKeyboard($data, $lang)
        );
        answerCall($callbackId,
            getTexts($data . "_CALLBACK", $lang)
        );

    } else{

        editMessage($chat_id, $message_id,
            getTexts("CHAT_TXT", $lang),
            composeKeyboard("chat", $lang)
        );
        answerCall($callbackId,
            getTexts("CHAT_CALLBACK", $lang)
        );

    }

}

?>