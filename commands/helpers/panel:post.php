<?php

if(isset($data)){

    editMessage($chat_id, $message_id,
        getTexts("PANEL:POST_TXT", $lang),
        composeKeyboard("panel:post", $lang)
    );

    answerCall($callbackId,
        getTexts("PANEL:POST_CALLBACK", $lang)
    );

    setUtil($id, 1, $message_id);

}

if(isset($text)){
    
    editMessage($chat_id, $util1,
        getTexts("PANEL:POST:KEYBOARD_TXT", $lang),
        composeKeyboard("panel:post:keyboard", $lang)
    );

    command($id, "panel:post:keyboard");
    setUtil($id, 2, $message_id);

}

?>