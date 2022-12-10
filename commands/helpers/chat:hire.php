<?php

if($action == "chat:hire"){ // The user is sending the description of the request, slot 2 of utils
                
    setUtil($id, 2, $text);
    command($id, "chat:hire:budget");
    
    editMessage($chat_id, $messageToEdit,
        getTexts("CHAT:HIRE:BUDGET_TXT", $lang),
        composeKeyboard("CHAT:HIRE:BUDGET", $lang) // The buttons are CHAT:BOT:BUDGET_BTN_*
    );
    
}
    
elseif($action == "chat:hire:budget"){ // The user is sending the budget, slot 3 of utils

    command($id, "start");
    setIsChatting($id, "true");
    
    editMessage($chat_id, $messageToEdit,
        getTexts("CHAT:HIRE:DONE_TXT", $lang),
        composeKeyboard("CHAT:HIRE:DONE", $lang) // The buttons are CHAT:BOT:CONFIRM_BTN_*
    );
    
    require_once strtr(__DIR__, ["helpers" => "start.php"]); // Sends the start message
    

    // Sends the message in the supports' group
    insertSupport($id, "hire");
    $supp_id = mysqli_insert_id($db);

    $subText = strtr(getTexts("CHAT:HIRE:SUPP_TXT", $main_language), [
        "{supp_id}" => $supp_id,
        "{id}" => $id,
        "{mention}" => $mention,
        "{description}" => getUtil($id, 2),
        "{budget}" => $text
    ]);

    $subKeyboard = strtr(composeKeyboard("CHAT:HIRE:SUPP", $main_language, false), [
        "{supp_id}" => $supp_id
    ]);

    sendMessage($chat_group, $subText, $subKeyboard);

    
    
}




?>