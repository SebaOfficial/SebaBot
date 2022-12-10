<?php

if($action == "chat:bot"){ // The user is sending the bot's username 
    $text = strtr($text, ["@" => ""]); // Removes the @ if there is one
    
    if(botExists($text)){ // The bot exists
        
        setUtil($id, 2, $text);
        command($id, "chat:bot:request");
        
        editMessage($chat_id, $messageToEdit,
            getTexts("CHAT:BOT:REQUEST_TXT", $lang),
            composeKeyboard("CHAT:BOT:REQUEST", $lang)
        );

    } else{ // The bot doesn't exists

        editMessage($chat_id, $messageToEdit,
            getTexts("CHAT:BOT:ERROR_TXT", $lang),
            composeKeyboard("CHAT:BOT:ERROR", $lang), // The buttons are CHAT:BOT_ERROR_BTN_*
        );

    }

} else{ // The user is sending the description of the request
    
    command($id, "start");
    setIsChatting($id, "true");

    editMessage($chat_id, $messageToEdit,
        getTexts("CHAT:BOT:DONE_TXT", $lang),
        composeKeyboard("CHAT:BOT:DONE", $lang) // The buttons are CHAT:BOT:DONE_BTN_*
    );

    require_once strtr(__DIR__, ["helpers" => "start.php"]); // Sends the start message


    // Sends the message in the supports' group
    insertSupport($id, "bots");
    $supp_id = mysqli_insert_id($db);

    $subText = strtr(getTexts("CHAT:BOT:SUPP_TXT", $main_language), [
        "{supp_id}" => $supp_id,
        "{id}" => $id,
        "{mention}" => $mention,
        "{bot}" => getUtil($id, 2),
        "{description}" => $text
    ]);

    $subKeyboard = strtr(composeKeyboard("CHAT:BOT:SUPP", $main_language, false), [
        "{supp_id}" => $supp_id
    ]);

    sendMessage($chat_group, $subText, $subKeyboard);

}


?>