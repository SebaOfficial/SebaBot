<?php

$stats = strtr(getTexts("PANEL:STATS_TXT", $lang), [
    "{users_tot}" => count(getAllUsers()),
    "{users_active}"  => count(getAllUsers(["status", "active"])),
    "{users_blocked}" => count(getAllUsers(["status", "blocked"])),
    "{chats_tot}" => count(getAllSupports()),
    "{chats_bots}" => count(getAllSupports("bots")),
    "{chats_hire}" => count(getAllSupports("hire")),
    "{chats_privacy}" => count(getAllSupports("privacy")),
    "{chats_other}" => count(getAllSupports("other")),
]);

editMessage($chat_id, $message_id,
    $stats,
    composeKeyboard("panel:stats", $lang)
);

answerCall($callbackId,
    getTexts("PANEL:STATS_CALLBACK", $lang)
);

?>