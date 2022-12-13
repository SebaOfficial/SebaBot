<?php

/*
This file contains all the main functions. 
*/


// Returns an array with all the user information
function getUser(int $id){
    $db = $GLOBALS['db'];

    $user = mysqli_query($db, "SELECT * FROM users WHERE id=$id");

    if(mysqli_num_rows($user) > 0){
        return mysqli_fetch_all($user, MYSQLI_ASSOC)[0];
    } else{
        return null;
    }

}

// Returns an array of all user informations
function getAllUsers(array $type = null){
    $db = $GLOBALS['db'];
    
    if(isset($type)){ // To return only the ids
        
        $key = $type[0];
        $value = $type[1];
        $get = mysqli_query($db, "SELECT * FROM users WHERE $key='$value'");

    } else{
        $get = mysqli_query($db, "SELECT * FROM users");
    }

    $get = mysqli_fetch_all($get, MYSQLI_ASSOC);

    return $get;
    
}

// Adds an user in the database
function insertUser($id){
    $db = $GLOBALS['db'];
    return mysqli_query($db, "INSERT INTO users (id, active) VALUES ('$id', 'true') ON DUPLICATE KEY UPDATE id=$id");
}

// Replaces all the placeholders in a text
function replaceTexts(string $text){
    $id = $GLOBALS['id'];
    $user = getChat($id)['result'];

    return strtr($text, [
        "{mention}" => "<a href='tg://user?id=" . $user['id']. "'>" . $user['first_name'] . "</a>",
    ]);
    
}

// Returns the string of a specified text
function getTexts(string $textid, string $lang, bool $replace = true){
   $db = $GLOBALS['db'];
   $textid = strtoupper($textid);

   $getText = mysqli_query($db, "SELECT $lang FROM texts WHERE id='$textid'");

    if($getText){

        if(mysqli_num_rows($getText) > 0){

            $getText = mysqli_fetch_all($getText, MYSQLI_ASSOC);
            
            if($replace){
                return replaceTexts($getText[0][$lang]);
            }

            return $getText[0][$lang];

        } 
        
        return "NOT_SET: <code>$textid</code>";
    }
}

// Updates the 'action' of the user
function command(int $id, string $command){
    $db = $GLOBALS['db'];

    return mysqli_query($db, "UPDATE users SET action='$command' WHERE id='$id'");
}

// Composes an inline keyboard
function composeKeyboard(string $command, string $lang, bool $returnIfNothingFound = null){

    $db = $GLOBALS['db'];
    $command = strtoupper($command);

    $getButtons = mysqli_query($db, "SELECT * FROM texts WHERE id LIKE '$command\_BTN_%'");

    if($getButtons){
        $buttons = mysqli_fetch_all($getButtons, MYSQLI_ASSOC);
    }

    $countButtons = mysqli_num_rows($getButtons);

    if($countButtons > 0){

        $keyboard = '{"inline_keyboard":[';
        $count = 1;
        $countTotal = 0;
        
        foreach ($buttons as $key => $value){
        
            $countTotal ++;
            $type = $value['type'];
            $callback = $value['callback'];
            $text = $value[$lang];
    
    
            if($countTotal == $countButtons){
                
                if($count == 1){
                    $keyboard .= "[{\"text\":\"$text\", \"$type\":\"$callback\"}]]}";
                } else{
                    $keyboard .= "{\"text\":\"$text\", \"$type\":\"$callback\"}]]}";
                }
    
            } else{
                
                if($count == 1){
                    $keyboard .= "[{\"text\":\"$text\", \"$type\":\"$callback\"},";
                    $count ++;
                } else{
                    $keyboard .= "{\"text\":\"$text\", \"$type\":\"$callback\"}],";
                    $count = 1;
                }
    
            }
        }
    
        return $keyboard;

    } else{

        return $returnIfNothingFound;

    }

}

// Checks if the given string is a command, you can pass the command handlers as an array
function checkCommand(string $text, array $commands){
    
    foreach($commands as $value){

        if(str_starts_with($text, $value)){
            return true;
        }
    }

    return false;
}

// Updates a string in the database
function updateString(string $string, string $update){
    $db = $GLOBALS['db'];

    return mysqli_query($db, "UPDATE texts SET text='$update' WHERE id='$string'");    
}

// Returns the bots in the database
function getBots(){
    $db = $GLOBALS['db'];
    $get = mysqli_query($db, "SELECT * FROM bots");
    return mysqli_fetch_all($get, MYSQLI_ASSOC);
}

// Checks if a bot's username is in the database
function botExists(string $bot){
    $db = $GLOBALS['db'];
    $check = mysqli_query($db, "SELECT * FROM bots WHERE username='$bot'");
    return mysqli_num_rows($check) > 0;
}

// Sets a util*
function setUtil(int $id, int $util, string $value){
    $db = $GLOBALS['db'];
    $set = mysqli_query($db, "UPDATE users SET util$util='$value' WHERE id='$id'");
    return $set;
}

function updateStatus(int $id, string $status){
    $db = $GLOBALS['db'];
    $update = mysqli_query($db, "UPDATE users SET status='$status' WHERE id='$id'");
    return $update;
}

function setLang(int $id, string $lang){
    $db = $GLOBALS['db'];
    $set = mysqli_query($db, "UPDATE users SET lang='$lang' WHERE id='$id'");
    return $set;
}

// Gets a util*
function getUtil(int $id, int $util){
    $db = $GLOBALS['db'];
    $get = mysqli_query($db, "SELECT util$util FROM users WHERE id='$id'");

    if(mysqli_num_rows($get) > 0){
        return mysqli_fetch_all($get, MYSQLI_ASSOC)[0]["util$util"];
    } else{
        return null;
    }
}

// Sets the chatting status
function setIsChatting(int $id, string $chatting){
    $db = $GLOBALS['db'];
    $set = mysqli_query($db, "UPDATE users SET is_chatting='$chatting' WHERE id='$id'");
    return $set;
}

// Inserts a support instance
function insertSupport($user, $type){
    $db = $GLOBALS['db'];
    $date = time();
    $insert = mysqli_query($db, "INSERT INTO supports(user, type, date) VALUES ('$user', '$type', '$date')");
    return $insert;
}

// Gets a support's information
function getSupport($support_id){
    $db = $GLOBALS['db'];
    $get = mysqli_query($db, "SELECT * FROM supports WHERE id='$support_id'");

    if(mysqli_num_rows($get) > 0){
        return mysqli_fetch_all($get, MYSQLI_ASSOC)[0];
    } else{
        return null;
    }
}

function getAllSupports(string $type = null){
    $db = $GLOBALS['db'];

    if(isset($type)){
        $get = mysqli_query($db, "SELECT * FROM supports WHERE type='$type'");
    } else{
        $get = mysqli_query($db, "SELECT * FROM supports");
    }
    
    $get = mysqli_fetch_all($get, MYSQLI_ASSOC);
    return $get;
}

// Returns the result of a repostory on github
function getRepo(string $username, string $repoName){
    $token = $GLOBALS['github_access_token'];

    $url = "https://api.github.com/repos/$username/$repoName";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MyPHPApp/1.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
    ]);
    $response = curl_exec($ch);

    return json_decode($response, true);
}

// Checks if a repostory exists
function repoExists(string $username, string $repoName){
    return !isset(getRepo($username, $repoName)['message']);
}

?>