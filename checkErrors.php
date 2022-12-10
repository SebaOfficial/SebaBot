<?php

/*
Run this file to check if there are any errors in your bot (php checkErrors.php)
*/

require_once "utils.php";

// Telegram checks
require_once "telegram/methods.php";

if(!getMe(token)['ok']){ // Checks the token
    echo "The token is NOT set correctly, please be sure to copy the right token.\n";
} else{
    echo "The token is set.\n";

    if(getChat($owner)['ok']){ // Checks if the owner has started the bot
        echo "The owner is recognized.\n";
    } else{
        echo "The owner is NOT recognized.\n";
    }

    if($log){ // If the owner wants to log, change this value in utils.php to stop logging
        
        if(getChat($log)['ok']){
            echo "The log is set ";
            
            if(getMember(getMe()['result']['id'], $log)['result']['can_post_messages']){ // if the bot can send messages
                echo "and the bot can send messages.\n";
            }else{
                echo "but the bot CAN'T send messages.\n";
            }

        } else{
            echo "The log is NOT set correctly.\n";
        }

    } else{
        echo "Skipping log...\n";
    }

    if(getChat($chat_group)['ok']){
        echo "The chat to send the support requests is set ";
        
        if(getMember(getMe()['result']['id'], $chat_group)['result']['status'] != "restricted"){ // if the bot is not restricted
            echo "and the is bot not restricted.\n";
        }else{
            echo "but the bot is RESTRICTED.\n";
        }

    } else{
        echo "The chat to send the support requests is NOT set correctly.\n";
    }    

    // Checking the webhook
    $webhook = getWebhookInfo();
    if($webhook['result']['url'] != ""){
        echo "The webhook is set ";
        
        if($webhook['result']['pending_update_count'] > 0){
            echo "but there is an error: " . $webhook['result']['last_error_message'] . "\n";
        } else{
            echo "and there are no errors.\n";
        }

    } else{
        echo "You need to set the webhook, see https://core.telegram.org/bots/api#setwebhook.\n";
    }
    
}


// Database checks

mysqli_query( // Creates the database if it doesn't exists
    mysqli_connect(
        $db_host, $db_username, $db_password
    ), 
    "CREATE DATABASE IF NOT EXISTS $db_name"
);

require_once "database/config.php";

echo "Creating all the required tables...\n";

$db_tables = [ // Edit this only if you know what you're doing
    "users",
    "bots",
    "texts",
];

mysqli_query($db, "CREATE TABLE IF NOT EXISTS users (
    id text NOT NULL UNIQUE,
    action text NULL,
    active text NOT NULL DEFAULT 'true',
    lang text NOT NULL DEFAULT '$main_language',
    ban text NOT NULL DEFAULT 'false',
    is_chatting text NOT NULL DEFAULT 'false',
    util1 text DEFAULT '',
    util2 text DEFAULT '',
    util3 text DEFAULT ''
    )"
);

mysqli_query($db, "CREATE TABLE IF NOT EXISTS texts (
    id text NOT NULL UNIQUE,
    $main_language text NOT NULL,
    type text NULL,
    callback text NULL
    )"
);

mysqli_query($db, "CREATE TABLE IF NOT EXISTS bots (
    username text NOT NULL UNIQUE,
    status text NOT NULL DEFAULT 'online',
    visible text NOT NULL DEFAULT 'true'
    )"
);

mysqli_query($db, "CREATE TABLE IF NOT EXISTS supports (
    id int AUTO_INCREMENT UNIQUE,
    user text NOT NULL,
    type text NOT NULL,
    date text NOT NULL
    )"
);

echo "Tables set.\n";

echo "All done, you're good to go!\n";

?>