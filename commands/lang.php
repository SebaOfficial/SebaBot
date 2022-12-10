<?php

if(isset($text)){
    
    sendMessage($chat_id, 
        getTexts("LANG_TXT", "en"),
        composeKeyboard("lang", "en")
    );

}

if(isset($data) && str_contains($data, ":")){
    
    $lang = strtr($data, ["lang:" => ""]);

    setLang($id, $lang);

    editMessage($chat_id, $message_id,
        getTexts("LANG:SET_TXT", $lang),
        composeKeyboard("lang:set", $lang)
    );
    
    answerCall($callbackId,
        getTexts("LANG:SET_CALLBACK", $lang)
    );

    // Sends the start message
    $data = null;
    $text = "";
    require_once "start.php";

}

?>