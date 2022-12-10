<?php

if($action == "chat:other"){ // The user is sending the title of the request 
    
    if(strlen($text) > 50){
        
        editMessage($chat_id, $messageToEdit,
            getTexts("CHAT:OTHER:DESCRIPTION:ERROR_TXT", $lang),
            composeKeyboard("CHAT:OTHER:DESCRIPTION:ERROR", $lang)
        );

    } else{

        command($id, "chat:other:description");
        setUtil($id, 2, $text);

        editMessage($chat_id, $messageToEdit,
            getTexts("CHAT:OTHER:DESCRIPTION_TXT", $lang),
            composeKeyboard("CHAT:OTHER:DESCRIPTION", $lang)
        );

    }
    

} else{ // The user is sending the description of the request

    command($id, "start");
    setIsChatting($id, "true");

    editMessage($chat_id, $messageToEdit,
        getTexts("CHAT:OTHER:DONE_TXT", $lang),
        composeKeyboard("CHAT:OTHER:DONE", $lang) // The buttons are CHAT:OTHER:DONE_BTN_*
    );

    require_once strtr(__DIR__, ["helpers" => "start.php"]); // Sends the start message

    // Sends the message in the supports' group
    insertSupport($id, "other");
    $supp_id = mysqli_insert_id($db);

    $subText = strtr(getTexts("CHAT:OTHER:SUPP_TXT", $main_language), [
        "{supp_id}" => $supp_id,
        "{id}" => $id,
        "{mention}" => $mention,
        "{title}" => getUtil($id, 2),
        "{description}" => $text
    ]);

    $subKeyboard = strtr(composeKeyboard("CHAT:OTHER:SUPP", $main_language, false), [
        "{supp_id}" => $supp_id
    ]);

    sendMessage($chat_group, $subText, $subKeyboard);

}


?>