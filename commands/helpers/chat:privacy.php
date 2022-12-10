<?php

command($id, "start");
setIsChatting($id, "true");

editMessage($chat_id, $messageToEdit,
    getTexts("CHAT:PRIVACY:DONE", $lang),
    composeKeyboard("CHAT:PRIVACY:DONE", $lang)  
);

require_once strtr(__DIR__, ["helpers" => "start.php"]); // Sends the start message 


// Sends the message in the supports' group
insertSupport($id, "privacy");
$supp_id = mysqli_insert_id($db);

$subText = strtr(getTexts("CHAT:PRIVACY:SUPP_TXT", $main_language), [
    "{supp_id}" => $supp_id,
    "{id}" => $id,
    "{mention}" => $mention,
    "{description}" => $text
]);

$subKeyboard = strtr(composeKeyboard("CHAT:PRIVACY:SUPP", $main_language, false), [
    "{supp_id}" => $supp_id
]);

sendMessage($chat_group, $subText, $subKeyboard);

?>