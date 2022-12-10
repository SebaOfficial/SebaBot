<?php


if($chat_id == $chat_group){ // The requests can only come from the supports' group

    if(isset($data)){
        $subText = strtr($data_text, ["toReply" => "replied"]);
        editMessage($chat_id, $message_id, $subText);
        answerCall($callbackId, getTexts("SUPPORT_CALLBACK", $lang));
    }

    if(isset($text)){

        if(str_starts_with($action, "support:")){
            
            $supp_id = strtr($action, ["support:" => ""]);
            $supp_user = getSupport($supp_id);

            $result = sendMessage( // Sends the message to the user who requested the support
                (int) $supp_user['user'],
                $text
            );

            if($result['ok']){ // The message was sent successfully
                
                sendMessage($chat_id,
                    getTexts("SUPPORT:DONE_TXT", $lang),
                    composeKeyboard("SUPPORT:DONE", $lang)
                );

                command($id, "nop");

            } else{

                $subText = strtr(getTexts("SUPPORT:ERROR_TXT", $lang), [
                    "{error}" => $result['description']
                ]);
                
                sendMessage($chat_id,
                    $subText,
                    composeKeyboard("SUPPORT:ERROR", $lang)
                );

                command($id, "nop");
            
            }

            setIsChatting((int) $supp_user['user'], "false");

        }
    }

}



?>