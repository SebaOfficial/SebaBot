<?php

$bots = getBots();
$substitute = "";
$on = getTexts("BOTS_ON", $lang);
$off = getTexts("BOTS_OFF", $lang);
$keyboard = '{"inline_keyboard":[';

foreach($bots as $key => $value){
    
    if($value['visible'] == 'true'){
        $username = $value['username'];
    
        $listKey = match($value['status']){
            "online" => $on,
            "offline" => $off
        };

        $substitute .= "$listKey @$username\n";
        $keyboard .= "[{\"text\":\"@$username\",\"url\":\"https://t.me/$username\"}, {\"text\":\"ℹ️\", \"callback_data\": \"bots:$username\"}, {\"text\":\"🗂\", ";
        
        if(repoExists($github_username, $username)){
            $keyboard .= "\"url\": \"$github_link/$username\"}],";
        } else{
            $keyboard .= "\"callback_data\": \"bots:no_repo\"}],";
        }

        

    }

    
}
$back = getTexts("BACK", $lang);
$keyboard .= "[{\"text\":\"$back\",\"callback_data\":\"start\"}]]}";

$botsText = strtr(getTexts("BOTS_TXT", $lang), ["{bot_list}" => $substitute]);

if(isset($text)){
    
    sendMessage($chat_id, 
        $botsText,
        $keyboard
    );
    
}

if(isset($data)){
    
    if(str_contains($data, ":")){
        
        answerCall($callbackId,
            getTexts($data, $lang),
            true
        );

    } 
    else{

        editMessage($chat_id, $message_id,
            $botsText, 
            $keyboard
        );
        answerCall($callbackId,
            getTexts("BOTS_CALLBACK", $lang)
        );

    }
    
}

?>