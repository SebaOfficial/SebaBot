<?php

if(isset($text)){ // The user sent the keyboard
    
    deleteMessage($chat_id, $util1);
    $result = copyMessage($chat_id, $chat_id, $util2, "{\"inline_keyboard\": [$text]}");

    if($result['ok']){
        $sent = $result['result']['message_id'];

        sendMessage($chat_id,
            getTexts("PANEL:POST:CONFIRM_TXT", $lang),
            composeKeyboard("panel:post:confirm", $lang),
            null, $sent
        );

        setUtil($id, 3, $sent);

    } else{
        
        sendMessage($chat_id,
            strtr(getTexts("PANEL:POST:ERROR_TXT", $lang), ["{error}" => $result['description']]),
            composeKeyboard("panel:post:error", $lang)
        );

    }

}

if(isset($data)){ // The user confirmed the post
    
    editMessage($chat_id, $message_id,
        getTexts("PANEL:POST:SENDING_TXT", $lang),
        composeKeyboard("panel:post:sending", $lang)
    );

    $count = 0;

    foreach(getAllUsers(["status", "active"]) as $key => $value){
        $count++;
        
        if($count % 20 == 0){
            sleep(1);
        }

        copyMessage($value['id'], $chat_id, $util3);
    }

    editMessage($chat_id, $message_id,
        strtr(getTexts("PANEL:POST:SENT_TXT", $lang), ["{users}" => count(getAllUsers(["status", "active"]))]),
        composeKeyboard("panel:post:sent", $lang)
    );

}

?>