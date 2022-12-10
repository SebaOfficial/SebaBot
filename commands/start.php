<?php

if(isset($text)){
    
    sendMessage($chat_id, 
        getTexts("START_TXT", $lang),
        composeKeyboard("start", $lang)
    );

}

if(isset($data)){
    
    editMessage($chat_id, $message_id,
        getTexts("START_TXT", $lang),
        composeKeyboard("start", $lang)
    );
    answerCall($callbackId,
        getTexts("START_CALLBACK", $lang)
    );

}

?>